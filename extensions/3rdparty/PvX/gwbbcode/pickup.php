<?php
/***************************************************************************
 *                                pickup.php
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
require_once(GWBBCODE_ROOT.'/gwbbcode.inc.php');
if (!USE_GWBBCODE)
   return;

//Retrieve username
///////////////////

//phpBB3
if (file_exists(GWBBCODE_ROOT.'/../index.php') && strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'phpBB3') !== false) {
   define('IN_PHPBB', true);
   $phpbb_root_path = '../';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);
	include($phpbb_root_path . 'common.' . $phpEx);
	
	$user->session_begin();
   $username = $user->data['username'];
}

//phpBB2
else if (   file_exists(GWBBCODE_ROOT.'/../index.php')
         && (   strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'phpBB') !== false
             || strpos(file_get_contents(GWBBCODE_ROOT.'/../index.php'), 'JOOM_PHPBB') !== false)) {
   define('IN_PHPBB', true);
   $phpbb_root_path = '../';
   include($phpbb_root_path . 'extension.inc');
   include($phpbb_root_path . 'common.'.$phpEx);
   
   
   // Session management
   $userdata = session_pagestart($user_ip, PAGE_VIEWONLINE);
   init_userprefs($userdata);
   $username = $userdata['username'];
}

//Other unsupported software
else {
   echo <<<EOT
<script>
alert('The pickup feature is not supported on your forum software yet.');
</script>
EOT;
   return;
}

//Load the pickup database
$pickup = @load(PICKUP_PATH);
if ($pickup === false)
   return;



//Switching
if (isset($_GET['switch'])) {
   $nobody_msg = 'No one can!';
   $id = $_GET['switch'];
   $id = str_replace("'", '', str_replace('"', '', $id));
   if (isset($pickup[$id]) && in_array($username, $pickup[$id]))
      $_GET['remove'] = $id;
   else
      $_GET['add'] = $id;
}
else
   $nobody_msg = '';



//Adding
if (isset($_GET['add'])) {
   $id = $_GET['add'];
   $id = str_replace("'", '', str_replace('"', '', $id));

   //New pickup?
   if (!isset($pickup[$id]))
      $pickup[$id] = Array();

   //New user for pickup?
   if (!in_array($username, $pickup[$id])) {
      $pickup[$id][] = $username;
      sort($pickup[$id]);
   }
}

//Removing
else if (isset($_GET['remove'])) {
   $id = $_GET['remove'];
   $id = str_replace("'", '', str_replace('"', '', $id));
   
   if (in_array($username, $pickup[$id]))
      unset($pickup[$id][array_search($username, $pickup[$id])]);

   if (empty($pickup[$id]))
      unset($pickup[$id]);
}




//In both cases, update client's webpage
$userlist = pickup_users($pickup, $username, $id, $nobody_msg);
if (!save(PICKUP_PATH, $pickup))
   $userlist = 'The pickup feature can\'t work if pickup_db.php isn\'t writable :( ';
echo <<<EOT
<script>
parent.pickup_set('$userlist', '$id');
</script>
EOT;
?>