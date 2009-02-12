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
require_once(GWBBCODE_ROOT.'/install.inc.php');

$successful = true;
$step = 1;
$forced_software = isset($_GET['forced_software']) ? $_GET['forced_software'] : ''; //Forum software detection bypass

rm('functions_gw.php');
rm('bbcode.tpl');
rm('skills_php.txt');
rm('skill_names.txt');

//phpBB 3.0 Beta1
if (   $forced_software == 'phpBB3'
    || (file_exists(GWBBCODE_ROOT.'/../index.php') && strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'phpBB3') !== false)) {
   define('IN_PHPBB', 1);
   define('NEED_SID', true);
   
   // Include files
   $phpbb_root_path = './../';
   $phpEx = substr(strrchr(__FILE__, '.'), 1);
   require($phpbb_root_path . 'common.' . $phpEx);
   require($phpbb_root_path . 'includes/functions_admin.' . $phpEx);
   require($phpbb_root_path . 'includes/functions_module.' . $phpEx);
   
   // Start session management
   $user->session_begin();
   $auth->acl($user->data);
   $user->setup('acp/common');
   // End session management
   
   // Did user forget to login? Give 'em a chance to here ...
   // Is user any type of admin? No, then stop here, each script needs to
   // check specific permissions but this is a catchall
   if ($user->data['user_id'] == ANONYMOUS || !$auth->acl_get('a_'))
   {
   	die('You are either not an admin, or not logged in. Please log in automatically as admin and retry.');
   }


   //Admin confirmed, proceed
   echo '<html><head></head><body><pre>';
   install_header();

   echo "\nUnhooking phpBB...\n";
   sub_from_file($step++, "	\$s_first_unread = false;",
               "include('gwbbcode/gwbbcode.php');",
               GWBBCODE_ROOT.'/../viewtopic.php');
   sub_from_file($step++, "		\$message = str_replace(':' . \$this->bbcode_uid, '', \$message);",
               "include('gwbbcode/gwbbcode.php');",
               GWBBCODE_ROOT.'/../includes/bbcode.php');
   sub_from_file($step++, "		'L_ONLINE_EXPLAIN'	=> \$l_online_time,",
               "   'GWBBCODE_BODY' => include('gwbbcode/body.php'),",
               GWBBCODE_ROOT.'/../includes/functions.php');
   //TODO merge in one line?
   sub_from_file($step++, "		'L_ONLINE_EXPLAIN'	=> \$l_online_time,",
               "   'GWBBCODE_HEAD' => include('gwbbcode/header.php'),",
               GWBBCODE_ROOT.'/../includes/functions.php');
   
   
   //Hook all templates
   $templates = template_list('styles');
   foreach ($templates as $template) {
      if (in_array($template, $not_to_hook))
         continue;
         
      echo "\nProcessing template " . basename($template) . "...\n";
      sub_from_file($step++, '@<body[^>]*>@Uis',
                  '{GWBBCODE_BODY}',
                  $template.'/template/overall_header.html',
                  true);
      sub_from_file($step++, '</head>',
                  '{GWBBCODE_HEAD}',
                  $template.'/template/overall_header.html');
   }
}



//phpBB2
else if (   $forced_software == 'phpBB2'
         || (   file_exists(GWBBCODE_ROOT.'/../index.php')
             && (   strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'phpBB') !== false
                 || strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'JOOM_PHPBB') !== false))) {
   define('IN_PHPBB', true);
   define('IN_ADMIN', true);
   $no_page_header = TRUE;
   $phpbb_root_path = './../';
   require($phpbb_root_path . 'extension.inc');
   include($phpbb_root_path . 'common.'.$phpEx);
   
   //Check that user is admin
   $userdata = session_pagestart($user_ip, PAGE_INDEX);
   init_userprefs($userdata);
   
   //Logged?
   if (!$userdata['session_logged_in'])
   	redirect(append_sid("login.$phpEx?redirect=gwbbcode/uninstall.php", true));

   //Admin?
   echo '<html><head></head><body><pre>';
   install_header();
   if ($userdata['user_level'] != ADMIN) {
   	failure("\nYou need admin rights to be allowed to uninstall gwBBCode.");
   	die();
   }

   echo "\nUnhooking phpBB...\n";
   sub_from_file($step++, "// Remove our padding from the string..\n\t\$text = substr(\$text, 1);",
               "include_once('gwbbcode/functions_gw.php');",
               GWBBCODE_ROOT.'/../includes/bbcode.php');
   sub_from_file($step++, "'T_SPAN_CLASS3' => \$theme['span_class3'],",
               "   'GWBBCODE_HEAD' => file_get_contents('gwbbcode/overall_header.tpl'),",
               GWBBCODE_ROOT.'/../includes/page_header.php');
   
   sub_from_file($step++, "'T_SPAN_CLASS3' => \$theme['span_class3'],",
               "   'GWBBCODE_BODY' => include('gwbbcode/body.php'),",
               GWBBCODE_ROOT.'/../includes/page_header.php');
   //TODO merge in one line?
   sub_from_file($step++, "'T_SPAN_CLASS3' => \$theme['span_class3'],",
               "   'GWBBCODE_HEAD' => include('gwbbcode/header.php'),",
               GWBBCODE_ROOT.'/../includes/page_header.php');
   sub_from_file($step++, "// Remove our padding from the string..\n\t\$text = substr(\$text, 1);",
               "include('gwbbcode/gwbbcode.php');",
               GWBBCODE_ROOT.'/../includes/bbcode.php');
   
   
   //Clean all templates
   $templates = template_list('templates');
   foreach ($templates as $template) {
      echo "\nProcessing template " . basename($template) . "...\n";
      sub_from_file($step++, '@<body[^>]*>@Uis',
                  '{GWBBCODE_BODY}',
                  $template.'/overall_header.tpl',
                  true);
      sub_from_file($step++, '@<head[^>]*>@i',
                  '{GWBBCODE_HEAD}',
                  $template.'/overall_header.tpl',
                  true);
      sub_from_file($step++, '</title>',
                  '{GWBBCODE_HEAD}',
                  $template.'/overall_header.tpl');
   }

   //Remove the sql skill table
   if (GWBBCODE_SQL) {
      echo "\n\nMySQL skill table status: ";
      if (mysql_query('DROP TABLE IF EXISTS skills;')) {
         success('removed');
      }
      else {
         failure('couldn\'t be removed');
      }
   }
}



//vBulletin
//TODO
else if (   $forced_software == 'vBulletin'
         || (file_exists(GWBBCODE_ROOT.'/../index.php') && strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'vBulletin') !== false)) {
   define('THIS_SCRIPT', 'uninstall');
   define('CWD', '..');
   $_SERVER['HTTP_REFERER'] = '';      //To avoid a silly notice from init.php
   require_once(CWD . '/includes/init.php');
   $permissions = cache_permissions($vbulletin->userinfo);
   
   //Logged and admin?
   echo '<html><head></head><body><pre>';
   install_header();
   if (!isset($permissions['adminpermissions'])|| $permissions['adminpermissions'] == 0) {
   	failure("\nYou need to be logged in and have admin rights to be allowed to uninstall gwBBCode.");
   	die();
   }

   echo "\nUnhooking vBulletin...\n";
   sub_from_file($step++, "eval('\$headinclude = \"' . fetch_template('headinclude') . '\";');",
               "\$headinclude .= include('gwbbcode/header.php');",
               GWBBCODE_ROOT.'/../global.php');
   sub_from_file($step++, "eval('\$header = \"' . fetch_template('header') . '\";');",
               "\$header .= include('gwbbcode/body.php');",
               GWBBCODE_ROOT.'/../global.php');
   sub_from_file($step++, "function parse_bbcode(\$input_text, \$do_smilies, \$do_html = false)\n\t{",
               "include('gwbbcode/gwbbcode.php');\n\$input_text = parse_gwbbcode(\$input_text);",
               GWBBCODE_ROOT.'/../includes/class_bbcode.php');
   echo "\nYou can change the number of images allowed in a post back to normal.";
   echo "\nTo do that, go to vBulletin Options/Message Posting and Editing Options and change Maximum Images Per Post";
}



//PunBB
else if (   $forced_software == 'PunBB'
         || (file_exists(GWBBCODE_ROOT.'/../index.php') && strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'PunBB') !== false)) {
   define('PUN_ROOT', '../');
   require PUN_ROOT.'include/common.php';

   echo '<html><head></head><body><pre>';
   install_header();
   if ($pun_user['g_id'] != PUN_ADMIN) {
   	failure("\nYou need admin rights to be allowed to uninstall gwBBCode.");
   	echo "<br/>Please login as admin <a href=\"../login.php\">here</a>.";
   	die();
   }
   
   
   echo "\nUnhooking PunBB...\n";
   sub_from_file($step++, "echo '<meta name=\"ROBOTS\" content=\"NOINDEX, FOLLOW\" />'.\"\\n\";",
               "echo include('gwbbcode/header.php');",
               GWBBCODE_ROOT.'/../header.php');
   sub_from_file($step++, "// END SUBST - <body>",
               '$tpl_main = preg_replace(\'@<body[^>]*>@Uis\', "$0\\n".include(\'gwbbcode/body.php\'), $tpl_main);',
               GWBBCODE_ROOT.'/../header.php');
   sub_from_file($step++, '$text = preg_replace($pattern, $replace, $text);',
               "include('gwbbcode/gwbbcode.php');",
               GWBBCODE_ROOT.'/../include/parser.php');
}


//MyBB
else if (   $forced_software == 'MyBB'
         || (file_exists(GWBBCODE_ROOT.'/../index.php') && strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'MyBB') !== false)) {
   define('MYBB_ROOT', '../');
   define('IN_MYBB', true);
   require_once MYBB_ROOT."inc/init.php";
   require_once MYBB_ROOT."inc/class_session.php";
   $session = new session;
   $session->init();
   
   echo '<html><head></head><body><pre>';
   install_header();
   if ($mybb->usergroup['cancp'] != "yes") {
   	failure("\nYou need admin rights to be allowed to uninstall gwBBCode.");
   	echo "<br/>Please login as admin <a href=\"../login.php\">here</a>.";
   	die();
   }

   echo "\nUnhooking MyBB...\n";
   sub_from_file($step++, '$message = $this->mycode_parse_quotes($message);',
               "\t\tinclude('gwbbcode/gwbbcode.php');\n\t\t\$message = parse_gwbbcode(\$message);",
               GWBBCODE_ROOT.'/../inc/class_parser.php');
   sub_from_file($step++, 'eval("\\$header = \\"".$templates->get("header")."\\";");',
               "\$headerinclude .= include('gwbbcode/header.php');\n\$header = (include('gwbbcode/body.php')) . \$header;",
               GWBBCODE_ROOT.'/../global.php');
}


else {
   echo '<html><head></head><body><pre>';
   install_header();
   failure('No supported software on which to uninstall gwBBCode from was found :\'(');
   //Propose to bypass forum software check
   echo 'If there is a forum software you want to force uninstallation on, click it: ';
   echo '<a href="?forced_software=phpBB3">phpBB3</a>, ';
   echo '<a href="?forced_software=phpBB2">phpBB2</a>, ';
   echo '<a href="?forced_software=vBulletin">vBulletin</a>, ';
   echo '<a href="?forced_software=PunBB">PunBB</a>, ';
   echo '<a href="?forced_software=MyBB">MyBB</a>.' . "\n";
}



echo "\n\n";
if ($successful)
   success('Uninstallation successfully completed!');
else
   failure('Uninstallation failed!If you can\'t resolve the issue(s), please email me.');

?>
</pre></body></html>