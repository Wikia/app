<?php
/***************************************************************************
 *                                install.php
 *                            -------------------
 *   begin                : Tuesday, Apr 21, 2005
 *   copyright            : (C) 2006-2007 Pierre 'pikiou' Scelles
 *   email                : liu.pi.vipi@gmail.com
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   All images, skill names and descriptions are (C) ArenaNet.
 ***************************************************************************/
define('GWBBCODE_ROOT', '.');
require_once(GWBBCODE_ROOT.'/constants.inc.php');

//Before we include anything, check config.inc.php
$config_result = '';
if (!file_exists(CONFIG_PATH) && !isset($_GET['hashes'])) {  //Ignore that part if we're building hashes
   //It's not there so create it
   $config = file_get_contents(DEFAULT_CONFIG_PATH);
   $config = str_replace("\r", '', $config);
   //Copy settings from the old config to the new one
   if (file_exists(OLD_CONFIG_PATH)) {
      $old_config = file_get_contents(OLD_CONFIG_PATH);
      if (preg_match("/define\('USE_GWBBCODE', ([^)]+)\);/", $old_config, $reg)) {
         $config = str_replace("define('USE_GWBBCODE', true);", "define('USE_GWBBCODE', {$reg[1]});", $config);
      }
      if (preg_match("/define\('GWBBCODE_SQL', ([^)]+)\);/", $old_config, $reg)) {
         $config = str_replace("define('GWBBCODE_SQL', false);", "define('GWBBCODE_SQL', {$reg[1]});", $config);
      }
      if (preg_match("/define\('GWBBCODE_ALLEGIANCE', '([^']+)'\);/", $old_config, $reg)) {
         $config = str_replace("define('GWBBCODE_ALLEGIANCE', 'Kurzick');", "define('GWBBCODE_ALLEGIANCE', '{$reg[1]}');", $config);
      }
      if (preg_match("/\$not_to_hook = (.*)?>/s", $old_config, $reg)) {  //Dirty trick, only works if $not_to_hook is the last variable in config.php
         $config = str_replace("\$not_to_hook = Array();\n?>", "\$not_to_hook = {$reg[1]}?>", $config);
      }
   }
   //Try to save the new config file
   if (($f = @fopen(CONFIG_PATH, 'wb'))
       && ($res = @fwrite($f, $config)) !== false) {
      @fclose($f);
      if (file_exists(OLD_CONFIG_PATH)) {
         rename(OLD_CONFIG_PATH, RENAMED_CONFIG_PATH);
         $config_result = "\n" . basename(OLD_CONFIG_PATH) . ' successfuly copied into ' . basename(CONFIG_PATH) . ', then renamed ' . basename(RENAMED_CONFIG_PATH) . '.';
      }
      else {
         $config_result = "\n" . basename(CONFIG_PATH) . ' successfuly created.';
      }
   }
   else {
      die("<pre>Please save the following lines to ".basename(CONFIG_PATH)." in your gwBBCode directory and restart install.php, \nor rename ".basename(DEFAULT_CONFIG_PATH)." to ".basename(CONFIG_PATH)." and tweak it :<br/><br/>".htmlspecialchars($config)).'</pre>';
   }
}
 
require_once(GWBBCODE_ROOT.'/install.inc.php');
define('OLD_PICKUP_PATH', GWBBCODE_ROOT.'/pickup.txt');

//PHP-Nuke warm up
If (file_exists('../../../mainfile.php')){
	define('FORUM_ADMIN', true);
	include('../../../mainfile.php');
	define('IS_NUKE', true);
  $is_admin = is_admin($admin);
}

echo '<html><head></head><body><pre>';
install_header();
echo empty($config_result) ? '' : success($config_result);

//Compare and show file md5 hashes mismatching official hashes
echo "\n";
if (!isset($_GET['hashes']) || !file_exists('../../liupishideout.txt')) {
   $version_hashes = require_once(HASHES_PATH);
   compare_hashes(get_hashes(), $version_hashes);
}
//Or save md5 hashs to a new db if we're on the local test server
else {
//TODO: move this hash db creation part to a packaging script
   $hashes = get_hashes();
   $hashes_php = "<?php return Array(\n";
   foreach ($hashes as $name => $content) {
      $hashes_php .= "'$name'=>'$content',\n";
   }
   $hashes_php .= ");?>";
   //Save
   if ($f = @fopen(HASHES_PATH, 'wb')) {
      $res = @fwrite($f, $hashes_php);
      @fclose($f);
      die("Hashes saved in ".HASHES_PATH);
   }
}

//Start the installation
$successful = true;
$step = 1;
$forced_software = isset($_GET['forced_software']) ? $_GET['forced_software'] : ''; //Forum software detection bypass

//Check if the pickup database file is writable
echo "\nTesting writability...\n";
$pickup = @load(PICKUP_PATH);
$pickup = is_array($pickup) ? $pickup : Array();
echo PICKUP_PATH;
if (!file_exists(PICKUP_PATH))
   notice(" doesn't exist. Please create it, make it writable (chmod 666) and rerun this installation (F5).\nIf you can't do it, only the pickup feature will be disabled.");
else if (!@save(PICKUP_PATH, $pickup))
   notice(" isn't writable. Please make it writable (chmod 666) and rerun this installation (F5).\nIf you can't do it, only the pickup feature will be disable.");
else
   success(' is writable.');

echo "\nCleaning from previous installations...\n";
rm('functions_gw.php');
rm('bbcode.tpl');
rm('skills_php.txt');
rm('skill_names.txt');



//phpBB 3.0 Beta1
if (   $forced_software == 'phpBB3'
    || (file_exists(GWBBCODE_ROOT.'/../index.php') && strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'phpBB3') !== false)) {
   echo "\nHooking phpBB3...\n";
   //Cleaning from previous gwBBCode versions
   sub_from_file($step++, "		'L_ONLINE_EXPLAIN'	=> \$l_online_time,",
               "   'GWBBCODE_BODY' => include('gwbbcode/body.php'),",
               GWBBCODE_ROOT.'/../includes/functions.php');
   sub_from_file($step++, "		'L_ONLINE_EXPLAIN'	=> \$l_online_time,",
               "   'GWBBCODE_HEAD' => include('gwbbcode/header.php'),",
               GWBBCODE_ROOT.'/../includes/functions.php');

   //Installing
   add_to_file($step++, "// Additional tables",
               "define('GWBBCODE_ROOT', \"{\$phpbb_root_path}gwbbcode\");",
               GWBBCODE_ROOT.'/../includes/constants.php');
   add_to_file($step++, "		'L_ONLINE_EXPLAIN'	=> \$l_online_time,",
               "   'GWBBCODE_HEAD' => include(GWBBCODE_ROOT.'/header.php'),",
               GWBBCODE_ROOT.'/../includes/functions.php');
   //TODO merge in one line?
   add_to_file($step++, "		'L_ONLINE_EXPLAIN'	=> \$l_online_time,",
               "   'GWBBCODE_BODY' => include(GWBBCODE_ROOT.'/body.php'),",
               GWBBCODE_ROOT.'/../includes/functions.php');
   add_to_file($step++, "		\$message = str_replace(':' . \$this->bbcode_uid, '', \$message);",
               "include(GWBBCODE_ROOT.'/gwbbcode.php');",
               GWBBCODE_ROOT.'/../includes/bbcode.php');
   add_to_file($step++, "	\$s_first_unread = false;",
               "include(GWBBCODE_ROOT.'/gwbbcode.php');",
               GWBBCODE_ROOT.'/../viewtopic.php');

   //Hook all templates
   $templates = template_list('styles');
   foreach ($templates as $template) {
      if (in_array($template, $not_to_hook))
         continue;
         
      echo "\nProcessing template " . basename($template) . "...\n";
      add_to_file($step++, '</head>',
                  '{GWBBCODE_HEAD}',
                  $template.'/template/overall_header.html');
      add_to_file($step++, '@<body[^>]*>@Uis',
                  '{GWBBCODE_BODY}',
                  $template.'/template/overall_header.html',
                  true);
   }

   //Remove template cache files
   $deleted_file_count = 0;
   $dir = "../cache";
   $dh  = opendir($dir);
   while (false !== ($filename = readdir($dh))) {
      if (preg_match('@^tpl_.*overall_header@', $filename) != false) {
         $deleted_file_count += unlink("$dir/$filename") ? 1 : 0;
      }
   }
   if ($deleted_file_count > 0) {
      success("\nRemoved $deleted_file_count template cache file(s).");
   }

   echo "\nIf you add templates, please rerun install.php to hook gwbbcode on them";
}



//phpBB2 & PHP-Nuke
else if (   ($forced_software == 'phpBB2' || $forced_software == 'PHP-Nuke')
         || (   file_exists(GWBBCODE_ROOT.'/../index.php')
             && (   strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'phpBB') !== false
                 || strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'JOOM_PHPBB') !== false))) {
   
   //TODO: Make sure ths admin is running this if we're asked for SQL support
   if (GWBBCODE_SQL) {
      error_reporting(0);  //Otherwise it shows a warning about headers being sent already
      define('IN_PHPBB', true);
      define('IN_ADMIN', true);
      $no_page_header = TRUE;
      $phpbb_root_path = './../';
      require($phpbb_root_path . 'extension.inc');
      include($phpbb_root_path . 'common.'.$phpEx);
      
      //Check that user is a..
      //..PHP-Nuke admin
      if (defined('IS_NUKE')){
         if($is_admin == 0){
            failure("\nYou need admin rights to be allowed to install MySQL support for gwBBCode.");
            die();
         }
      }
      //..or a phpBB2 admin
      else {
         $userdata = session_pagestart($user_ip, PAGE_INDEX);
         init_userprefs($userdata);
         if (!$userdata['session_logged_in'] || $userdata['user_level'] != ADMIN) {
            failure("\nYou need admin rights to be allowed to install MySQL support for gwBBCode.");
            die();
         }
      }
      error_reporting(E_ALL);
   }

   //PHP-Nuke
	define('GWBB_ROOT', (defined('IS_NUKE') ? 'modules/Forums/' : ''));
	define('INCL_ROOT', (defined('IS_NUKE') ? '../../../' : GWBBCODE_ROOT.'/../'));

   //Cleaning from previous gwBBCode versions
   sub_from_file($step++, "// Remove our padding from the string..\n\t\$text = substr(\$text, 1);",
               "include_once('".GWBB_ROOT."gwbbcode/functions_gw.php');",
               INCL_ROOT.'includes/bbcode.php');
   sub_from_file($step++, "'T_SPAN_CLASS3' => \$theme['span_class3'],",
               "   'GWBBCODE_HEAD' => file_get_contents('".GWBB_ROOT."gwbbcode/overall_header.tpl'),",
               INCL_ROOT.'includes/page_header.php');
   if (file_exists(OLD_PICKUP_PATH)) {
      $pickup = eval('return '.file_get_contents(OLD_PICKUP_PATH).';');
      if (save(PICKUP_PATH, $pickup)) {
         echo 'Transfering ' . OLD_PICKUP_PATH . ' to ' . PICKUP_PATH . ': ' . success('done', true);
         rm(OLD_PICKUP_PATH, false);
      }
   }
   
   //Installing
   echo "\nHooking phpBB2...\n";
   add_to_file($step++, "'T_SPAN_CLASS3' => \$theme['span_class3'],",
               "   'GWBBCODE_HEAD' => include('".GWBB_ROOT."gwbbcode/header.php'),",
               INCL_ROOT.'includes/page_header.php');
   add_to_file($step++, "'T_SPAN_CLASS3' => \$theme['span_class3'],",
               "   'GWBBCODE_BODY' => include('".GWBB_ROOT."gwbbcode/body.php'),",
               INCL_ROOT.'includes/page_header.php');
   add_to_file($step++, "// Remove our padding from the string..\n\t\$text = substr(\$text, 1);",
               "include('".GWBB_ROOT."gwbbcode/gwbbcode.php');",
               INCL_ROOT.'includes/bbcode.php');
   
   
   //Hook all templates
   $templates = defined('IS_NUKE') ? template_list('../../themes') : template_list('templates');
   $templatepath = defined('IS_NUKE') ? '/forums' : '';
   foreach ($templates as $template) {
      if (in_array($template, $not_to_hook) || !is_dir($template.$templatepath))
         continue;
         
      echo "\nProcessing template " . basename($template) . "...\n";
      sub_from_file($step++, '@<head[^>]*>@Uis',      //Cleaning from previous gwBBCode versions
                  '{GWBBCODE_HEAD}',
                  $template.$templatepath.'/overall_header.tpl',
                  true);
      add_to_file($step++, '</title>',
                  '{GWBBCODE_HEAD}',
                  $template.$templatepath.'/overall_header.tpl');
      add_to_file($step++, '@<body[^>]*>@Uis',
                  '{GWBBCODE_BODY}',
                  $template.$templatepath.'/overall_header.tpl',
                  true);
   }
   echo "\nIf you add templates, please rerun install.php to hook gwbbcode on them";

   //Recreate and fill the skills table
   if (GWBBCODE_SQL) {
      echo "\n\nPreparing the MySQL skill table...\n";
      add_skills_to_sql();
   }
}



//vBulletin
//TODO
else if (   $forced_software == 'vBulletin'
         || (file_exists(GWBBCODE_ROOT.'/../index.php') && strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'vBulletin') !== false)) {
   echo "\nHooking vBulletin...\n";
   add_to_file($step++, "eval('\$headinclude = \"' . fetch_template('headinclude') . '\";');",
               "\$headinclude .= include('gwbbcode/header.php');",
               GWBBCODE_ROOT.'/../global.php');
   add_to_file($step++, "eval('\$header = \"' . fetch_template('header') . '\";');",
               "\$header .= include('gwbbcode/body.php');",
               GWBBCODE_ROOT.'/../global.php');
   add_to_file($step++, "function parse_bbcode(\$input_text, \$do_smilies, \$do_html = false)\n\t{",
               "include('gwbbcode/gwbbcode.php');\n\$input_text = parse_gwbbcode(\$input_text);",
               GWBBCODE_ROOT.'/../includes/class_bbcode.php');
   echo "\nYou need to change the number of images allowed in a post otherwise gwBBCode's images won't show :(";
   echo "\nTo do that, go to vBulletin Options/Message Posting and Editing Options and change Maximum Images Per Post";
}




//PunBB
else if (   $forced_software == 'PunBB'
         || (file_exists(GWBBCODE_ROOT.'/../index.php') && strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'PunBB') !== false)) {
   echo "\nHooking PunBB...\n";
   add_to_file($step++, "echo '<meta name=\"ROBOTS\" content=\"NOINDEX, FOLLOW\" />'.\"\\n\";",
               "echo include('gwbbcode/header.php');",
               GWBBCODE_ROOT.'/../header.php');
   add_to_file($step++, "// END SUBST - <body>",
               '$tpl_main = preg_replace(\'@<body[^>]*>@Uis\', "$0\\n".include(\'gwbbcode/body.php\'), $tpl_main);',
               GWBBCODE_ROOT.'/../header.php');
   add_to_file($step++, '$text = preg_replace($pattern, $replace, $text);',
               "include('gwbbcode/gwbbcode.php');",
               GWBBCODE_ROOT.'/../include/parser.php');
}


//MyBB
else if (   $forced_software == 'MyBB'
         || (file_exists(GWBBCODE_ROOT.'/../index.php') && strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'MyBB') !== false)) {
   echo "\nHooking MyBB...\n";
   add_to_file($step++, 'eval("\\$header = \\"".$templates->get("header")."\\";");',
               "\$headerinclude .= include('gwbbcode/header.php');\n\$header = (include('gwbbcode/body.php')) . \$header;",
               GWBBCODE_ROOT.'/../global.php');
   add_to_file($step++, '$message = $this->mycode_parse_quotes($message);',
               "\t\tinclude('gwbbcode/gwbbcode.php');\n\t\t\$message = parse_gwbbcode(\$message);",
               GWBBCODE_ROOT.'/../inc/class_parser.php');
}


else {
   failure('No supported software on which to hook gwBBCode was found :\'(');
   //Propose to bypass forum software check
   echo 'If there is a forum software you want to force installation on, click it: ';
   echo '<a href="?forced_software=phpBB3">phpBB3</a>, ';
   echo '<a href="?forced_software=phpBB2">phpBB2</a>, ';
   echo '<a href="?forced_software=vBulletin">vBulletin</a>, ';
   echo '<a href="?forced_software=PunBB">PunBB</a>, ';
   echo '<a href="?forced_software=MyBB">MyBB</a>, ';
   echo '<a href="?forced_software=PHP-Nuke">PHP-Nuke</a>.' . "\n";
}


echo "\n\n";
if ($successful)
   success('! Installation successfully completed !');
else
   failure('Installation failed! If you can\'t resolve the issue(s), please contact me.');
?>

<form name="shack" method="post" action="http://gwshack.us/installed_gwbbcode.php" target="form_result">
<br/>To be informed of new versions of gwBBCode, just send me your email! (no ads, no spam)
<input name="email" type="text" value="" size="50"/> <input name="post" value="Send email" type="submit"/></form>
<iframe name="form_result" border="0" frameborder="0"></iframe>
</pre></body></html>