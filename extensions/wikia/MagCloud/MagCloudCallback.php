<?php

$dir = dirname(__FILE__);

$wgAutoloadClasses["MagCloudCallback"] = "{$dir}/SpecialMagCloudCallback.class.php";
$wgSpecialPages["MagCloudCallback"]    = "MagCloudCallback";
