<?php
/**
 * @author Sean Colombo
 * @date 20111005
 *
 * This file is the file which should be included in order to add ApiGate
 * to your application.
 *
 * If you're looking for the code of the ApiGate class, please see ApiGate.class.php.
 */

$dir = dirname(__FILE__);// Files used to get basic settings an utilities (used almost universally by the others).
require_once "$dir/config.php";
require_once "$dir/ApiGate_Config.php";
require_once "$dir/ApiGate_Profiler.php"; // has no dependencies & most other files depend on this... always include this before other files which have functions/methods in them.
require_once "$dir/i18n/ApiGate_i18n.php";

require_once "$dir/ApiGate.class.php";
require_once "$dir/ApiGate_ApiKey.class.php";
require_once "$dir/ApiGate_ApiKey_Profile.class.php"; // TODO: Roll into ApiKey and just lazy-load it as needed.
require_once "$dir/ApiGate_RateLimitRules.class.php";
require_once "$dir/ApiGate_Dispatcher.class.php";
