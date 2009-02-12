<?php
//gwBBCode's version
$gwbbcode_version = '1.8.0.2';

//DB paths
define('SKILLS_PATH_1', GWBBCODE_ROOT.'/skill_db_1.php');
define('SKILLS_PATH_2', GWBBCODE_ROOT.'/skill_db_2.php');
define('SKILLNAMES_PATH', GWBBCODE_ROOT.'/skillname_db.php');
define('SKILLABBRS_PATH', GWBBCODE_ROOT.'/abbr_db.php');
define('PICKUP_PATH', GWBBCODE_ROOT.'/pickup_db.php');
define('HASHES_PATH', GWBBCODE_ROOT.'/hashes_db.php');

//Include paths
if (!defined('GWBBCODE_IMG_PATH')) {
   define('GWBBCODE_IMG_PATH', GWBBCODE_ROOT);
}
define('CONSTANTS_PATH', GWBBCODE_ROOT.'/constants.inc.php');
define('CONFIG_PATH', GWBBCODE_ROOT.'/config.inc.php');
define('DEFAULT_CONFIG_PATH', GWBBCODE_ROOT.'/config_default.inc.php');
define('OLD_CONFIG_PATH', GWBBCODE_ROOT.'/config.php');
define('RENAMED_CONFIG_PATH', GWBBCODE_ROOT.'/config.old.php');
define('TEMPLATE_PATH', GWBBCODE_ROOT.'/gwbbcode.tpl');
define('BORDER_PATH', GWBBCODE_ROOT.'/img_border');
define('GWSHACK', file_exists('gwshack.php'));

define('GWBB_STATIC_HEADER', GWBBCODE_ROOT.'/static_header.tpl');
define('GWBB_STATIC_BODY', GWBBCODE_ROOT.'/static_body.tpl');
define('GWBB_DYNAMIC_HEADER', GWBBCODE_ROOT.'/dynamic_header.tpl');
define('GWBB_DYNAMIC_BODY', GWBBCODE_ROOT.'/dynamic_body.tpl');
?>