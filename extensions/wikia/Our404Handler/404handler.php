<?php

/**
 * set additional variable in $_GET array
 */
$_GET[ "404uri" ] = $_SERVER['REQUEST_URI'];
require "../../../index.php";
