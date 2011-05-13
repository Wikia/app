<?php

/**
 * JS Lint metics tool for CruiseControl
 *
 * This script is called using the following command:
 *
 * SERVER_ID=156 jslint.php
 *	 --log-junit ${project.dir}/build/logs/jslint.xml
 *	 --conf ${project.dir}/config/LocalSettings.php
 *
 * @author Maciej Brencz
 */

require_once('../maintenance/commandLine.inc');

$file = "{$IP}/extensions/wikia/VideoEmbedTool/js/VET.js";
#$file = "{$IP}/skins/oasis/js/LatestPhotos.js";

exec("java -jar {$IP}/lib/compiler.jar --debug --warning_level DEFAULT --js_output_file /dev/null --js {$file} 2>&1", $out, $res);

var_dump($out);

exit(0);