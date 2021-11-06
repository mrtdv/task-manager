<?php

namespace application\services;

use PDO;

class Db {

	protected $db;
	
	public function __construct() {
		$config = require 'application/config/db.php';
		$this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'', $config['user'], $config['password']);
	}

	public function query($sql, $params = []) {
		$stmt = $this->db->prepare($sql);
		if (!empty($params)) {
        	foreach ($params as $key => $val) {
				if (is_int($val)) {
					$type = PDO::PARAM_INT;
				} else {
					$type = PDO::PARAM_STR;
				}
				$stmt->bindValue(':'.$key, $val, $type);
			}
        }  
		$stmt->execute();
		return $stmt;
	}

	public function row($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public function column($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchColumn();
	}

	public function lastInsertId() {
		return $this->db->lastInsertId();
	}

	public function insert($table, $params = []) {
        if (!empty($params)) {
        	$d = $par = $values = '';
        	foreach ($params as $key => $val) {
				$par .= $d . '`' . $key . '`';
				$values .= $d . ':' . $key;
				$d = ',';
			}
			$sql = 'INSERT INTO `' . $table . '` (' . $par . ') VALUES (' . $values . ')';
			$this->query($sql, $params);
        }  else return false;
	}

	public function update($table, $params = []) {
        if (!empty($params)) {
        	$d = $par = $values = '';
        	foreach ($params as $key => $val) {
        		if ($key != 'ID') {
        			$par .= $d . '`' . $key . '` = :' . $key;
				    $d = ',';
				}
			}
			$sql = 'UPDATE `' . $table . '` SET ' . $par . ' WHERE `ID` = :ID';
			$this->query($sql, $params);
        }  else return false;
	}

}