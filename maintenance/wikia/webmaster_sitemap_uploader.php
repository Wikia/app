<?php

require_once( __DIR__.'../commandLine.inc' );

global $wgExternalSharedDB;
$app = F::app();

$db = $app->wf->getDB( DB_MASTER, array(), $wgExternalSharedDB);

//$db->select( );