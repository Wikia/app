<?php

/* Let's do something MVC-ish 
   (purists might disagree that this is MVC)*/

require_once('model.php');
require_once('view.php');
require_once('controller.php');

$model=new Model();
$view=new View();
$controller=new Controller();

$view->model=$model;
$controller->model=$model;
$controller->view=$view;

$controller->execute();

?>
