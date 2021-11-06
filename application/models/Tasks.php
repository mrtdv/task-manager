<?php

namespace application\models;

use application\core\Model;

class Tasks extends Model
{
    public $maxtasks = 2;
    public $error;

    public function getAllTasks(int $npage, $sort)
    {   
        $start = $this->maxtasks * ($npage-1);
        $order = '`ID` DESC';
        if (!empty($sort)) {
            switch ($sort) {
                case 'namea':
                    $order = '`user_name` ASC';
                    break;
                case 'named':
                    $order = '`user_name` DESC';
                    break;
                case 'emaila':
                    $order = '`email` ASC';
                    break;
                case 'emaild':
                    $order = '`email` DESC';
                    break;
                case 'taska':
                    $order = '`task` ASC';
                    break;
                case 'taskd':
                    $order = '`task` DESC';
                    break;
                case 'statusa':
                    $order = '`status` ASC';
                    break;
                case 'statusd':
                    $order = '`status` DESC';
                    break;
            }
        }
        $params = [
            'start' => $start,
            'max' => $this->maxtasks
        ];
        return $this->db->row("SELECT * FROM `tasks` ORDER BY $order LIMIT :start,:max", $params);
    }

    public function getCountTasks()
    {
        return $this->db->column('SELECT COUNT(`ID`) FROM `tasks`');
    }

    public function addTask($post)
    {
        $params = [
            'ID' => '',
            'user_name' => $post['user_name'],
            'email' => $post['user_email'],
            'task' => $post['task'],
            'status' => 0
        ];
        $this->db->insert('tasks', $params);
        return true;
    }

    public function editTask($post)
    {
        $params = [
            'ID' => $post['ID']
        ];
        $task = $this->db->column('SELECT `task` FROM `tasks` WHERE `ID` = :ID', $params);
        $params = [
            'user_name' => $post['user_name'],
            'email' => $post['user_email'],
            'task' => $post['task'],
            'status' => $post['status'],
            'ID' => $post['ID']
        ];
        if ($task != $post['task']) $params['comment'] = 'Изменено администратором';
        $this->db->update('tasks', $params);
        return true;
    }

    public function getTaskStatus()
    {
        return [
            0 => 'Поставлена',
            1 => 'Выполнена'
        ];
    }

    public function validatePage($par)
    {
        if ((isset($par)) && (!empty($par)) && (is_numeric($par))) {
            return htmlspecialchars($par);
        } else return 1;
    }

    public function validateSort($par)
    {
        if (!empty($par)) {
            return htmlspecialchars($par);
        } else return '';
    }

    public function validatePost($arr)
    {
        $var = array();
        foreach ($arr as $key => $val) {
            if ($key == 'user_email') {
                if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
                    $this->error = 'Неправильно введена почта';
                    return false;
                }
            }
            if (($key == 'ID') || ($key == 'user_name') || ($key == 'user_email') || ($key == 'task'))  {
                if (empty($val)) {
                    $this->error = 'Все поля должны быть заполнены';
                    return false;
                }
            }
            $var[$key] =  htmlspecialchars($val);
        }
        return $var;
    }

}