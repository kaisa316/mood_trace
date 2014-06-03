<?php
include '../model/model.php';

$model = new Model();
$param_val = array('s'=>'zhangsan','i'=>1);
$model->pre_query('select * from user where login_name=? and login_pwd=?',$param_val);
?>
