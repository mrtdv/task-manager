<?php

namespace application\models;

use application\core\Model;

class User extends Model
{

	public function validateLogin($arr)
	{
        $var = array();
        foreach ($arr as $key => $val) {
            $var[$key] =  htmlspecialchars($val);
        } 
        return $var;
	}

}