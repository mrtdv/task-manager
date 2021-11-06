<?php
namespace application\controllers;

use application\models\Tasks;
use application\core\View;
use application\core\Controller;
use application\services\Paginator;

class TasksController extends Controller
{
    private $mainmodel;

	public function mainAction()
	{
        $this->mainmodel = new Tasks;
        $tasks = [];
        $npage = (isset($_GET['page'])) ? $this->mainmodel->validatePage($_GET['page']) : 1;
        $sort = (isset($_GET['sort'])) ? $this->mainmodel->validateSort($_GET['sort']) : '';
        $paginator = new Paginator($this->mainmodel->maxtasks, $this->mainmodel->getCountTasks(), $npage);
        $pagination = $paginator->getPagination();
        $tasks = $this->mainmodel->getAllTasks($npage, $sort);
        $task_status = $this->mainmodel->getTaskStatus();

		$vars = [
            'block' => 'tasks',
            'path' => $this->path,
            'status' => $this->userstatus,
            'pagination' => $pagination,
            'sort' => $sort,
            'tasks' => $tasks,
            'task_status' => $task_status
        ];
        $this->render = new View;
        $this->render->render($vars);

	}

    public function addAction()
    {
        $this->render = new View;
        if ($this->userstatus != 1) {
            $content = $this->render->renderBlock(['block' => 'tasks_errorauth', 'path' => $this->path]);
            $this->render->message('error',$content);
        }
        if (!empty($_POST)) {
            $this->mainmodel = new Tasks;
            $post = $this->mainmodel->validatePost($_POST);
            if (!empty($this->mainmodel->error)) $this->render->message('error',$this->mainmodel->error);
            $this->mainmodel->addTask($post);
            $this->render->message('success','Успешно добавлено');
        } else {
            $this->render->message('error','Необходимо заполнить все поля');
        }
    }

    public function editAction()
    {
        $this->render = new View;
        if ($this->userstatus != 1) {
            $content = $this->render->renderBlock(['block' => 'tasks_errorauth', 'path' => $this->path]);
            $this->render->message('error',$content);
        }
        if (!empty($_POST)) {
            $this->mainmodel = new Tasks;
            $post = $this->mainmodel->validatePost($_POST);
            if (!empty($this->mainmodel->error)) $this->render->message('error',$this->mainmodel->error);
            $this->mainmodel->editTask($post);
            $this->render->message('success','Успешно изменено');
        }
    }
}