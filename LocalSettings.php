<?php

$IP = __DIR__;
require __DIR__.'/../config/LocalSettings.php';

$wgScript = "$wgScriptPath/index.php";
$wgArticlePath = "$wgScriptPath/wiki/$1";
$wgUploadPath = "$wgScriptPath/images";
$wgLogo = "$wgUploadPath/b/bc/Wiki.png";
