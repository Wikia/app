<?php
/***************************************************************************
 *                              install.inc.php
 *                            -------------------
 *   begin                : Monday, Feb 13, 2006
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

require_once(GWBBCODE_ROOT.'/gwbbcode.inc.php');


function install_header() {
   $gwbbcode_version = GWBBCODE_VERSION;
   $stars = str_repeat('*', strlen(GWBBCODE_VERSION));
   echo "
*************$stars
* <a href=\"http://gwshack.us\">gwBBCode $gwbbcode_version</a> *
*************$stars
by pikiou / Liu Pi
<img style=\"vertical-align: middle\" src=\"http://gwshack.us/email2.gif\"/>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

All images, skill names and descriptions are (C) ArenaNet.

See CREDITS.TXT for ... credits!
";
}


function rm($filename, $verbose=true) {
   if (file_exists($filename))
      if (unlink($filename))
         success("File $filename successfully removed.", !$verbose);
      else
         failure("File $filename unsuccessfully removed.", !$verbose);
}


function sub_from_file($step, $where, $what, $filename, $regexp=false) {
   echo "Step $step: ";
   if ($content = @file_get_contents($filename)) {
      $content = str_replace("\r\n", "\n", $content);
      
      //If $what isn't in the file
      if (strpos($content, $what) === false) {
         //Say it
         success("already clean");
      }
      else {
         //else remove it
         $content = str_replace("\n".$what, '', $content);   //UNSAFE TODO
         
         //If $what is no longer in the file
         if (strpos($content, $what) === false) {
            //Try to save the file
            if ($f = @fopen($filename, 'wb')) {
               fwrite($f, $content);
               fclose($f);
               success("clean");
            }
            else
               failure("Error 1: '$filename' couldn't be opened for modification.\n".
                       'Please change its access rights (chmod 777) and try again, then change access rights back to normal.');
            
         }
         else
            failure("Error 2: '$what' was found in '$filename' but couldn't be removed.\n".
                    "Please manually remove it, or replace its file by the original file from phpBB");
      }
   }
   else
      failure("Error 5: '$filename' couldn't be found or read.");
}


function add_to_file($step, $where, $what, $filename, $regexp=false) {
   echo "Step $step: ";
   if ($content = @file_get_contents($filename)) {
      $content = str_replace("\r\n", "\n", $content);
      
      //If $what isn't in the file
      if (strpos($content, $what) === false) {
         //Add it
         if ($regexp === false)
            $content = str_replace($where, $where."\n".$what, $content);
         else
            $content = preg_replace($where, "$0\n".$what, $content);
         //If $what now is in the file
         if (strpos($content, $what) !== false) {
            //Try to save the file
            if ($f = @fopen($filename, 'wb')) {
               fwrite($f, $content);
               fclose($f);
               success("hooked");
            }
            else
               failure("Error 3: '$filename' couldn't be opened for modification.\n".
                       'Please change its access rights (chmod 777) and try again, then change access rights back to normal.');
         }
         else
            failure("Error 4: '$where' wasn't found in '$filename', so '$what' couldn't be inserted in it.");
      }
      else
         success("already hooked");
   }
   else
      failure("Error 6: '$filename' couldn't be found or read.");
}


//Recreate and fill the sql 'skills' table
function add_skills_to_sql(){
   if (!mysql_query('DROP TABLE IF EXISTS skills;')) {
      die('Query failed: ' . mysql_error());
   }
   $sql =    ' CREATE TABLE IF NOT EXISTS `skills` ('
           . ' `id` mediumint(9) NOT NULL default \'0\','
           . ' `name` varchar(40) NOT NULL default \'\','
           . ' `desc` text NOT NULL,'
           . ' `prof` char(2) NOT NULL default \'\','
           . ' `ty` varchar(6) NOT NULL default \'\','
           . ' `elite` tinyint(4) NOT NULL default \'0\','
           . ' `attr` varchar(6) NOT NULL default \'\','
           . ' `energy` tinyint(4) NOT NULL default \'0\','
           . ' `adrenaline` tinyint(4) NOT NULL default \'0\','
           . ' `casting` float NOT NULL default \'0\','
           . ' `recharge` tinyint(4) NOT NULL default \'0\','
           . ' `eregen` tinyint(4) NOT NULL default \'0\','
           . ' `chapter` tinyint(4) NOT NULL default \'0\','
           . ' `profession` varchar(20) NOT NULL default \'\','
           . ' `attribute` varchar(30) NOT NULL default \'\','
           . ' `type` varchar(40) NOT NULL default \'\','
           . ' `name_id` varchar(40) NOT NULL default \'\','
           . ' PRIMARY KEY (`id`),'
           . ' KEY `name` (`name`),'
           . ' KEY `prof` (`prof`),'
           . ' KEY `ty` (`ty`),'
           . ' KEY `attr` (`attr`),'
           . ' KEY `chapter` (`chapter`),'
           . ' KEY `name_id` (`name_id`)'
           . ' );';
   if (!mysql_query($sql)) {
      die('Query failed: ' . mysql_error());
   }
   echo 'Skill table: ' . success('created', true);

   $i = 0;
   insert_skills_from(SKILLS_PATH_1, $i);
   insert_skills_from(SKILLS_PATH_2, $i);
   echo 'Inserted skills: ' . success($i, true);
}

//Insert in the 'skills' table skills from database $filename
function insert_skills_from($filename, &$i) {
   $skills = include ($filename);
   foreach ($skills as $id => $s) {
      extract($s, EXTR_OVERWRITE);
      $name_id = mysql_real_escape_string($name_id);
      $name = mysql_real_escape_string($name);
      $desc = mysql_real_escape_string($desc);
      $sql = "INSERT INTO `skills` ( `id` , `name` , `desc` , `prof` , `profession` , `ty` , `type` , `elite` , `attr` , `attribute` , `energy` , `adrenaline` , `casting` , `recharge` , `eregen` , `chapter` , `name_id` ) VALUES ('$id', '$name', '$desc', '$prof', '$profession', '$ty', '$type', '$elite', '$attr', '$attribute', '$energy', '$adrenaline', '$casting', '$recharge', '$eregen', '$chapter', '$name_id');";
      if (!mysql_query($sql)) {
         die('Query failed: ' . mysql_error());
      }
      $i++;
   }
}


//Returns hashes of gwbbcode files, including subdirectories
function get_hashes() {
   global $gwbbcode_version;
   $hashes = Array('version'=>$gwbbcode_version);
   $dirs = Array(Array('.'));
   while (!empty($dirs)) {
      $dir_arr = array_shift($dirs);
      $dir = implode('/', $dir_arr) . '/';
      $dir_hash = '';
      foreach ($dir_arr as $dirname) {
         if ($dirname != '.') {
            $dir_hash .= $dirname . '/';
         }
      }
      if ($dh = opendir($dir)) {
         while (($name = readdir($dh)) !== false) {
            if (strpos($name, '.') !== 0 && is_dir($dir.$name)) {
               $dirs[] = array_merge($dir_arr, Array($name));
            }
            else if (strpos($name, '.') !== 0 && is_file($dir.$name)) {
               $hashes[$dir_hash.$name] = substr(md5(str_replace("\r", '', file_get_contents($dir.$name))), 0, 5);
            }
         }
         closedir($dh);
      }
   }
   unset($hashes[basename(HASHES_PATH)]);    //The hash db file can't contain it's own file hash, so ignore it
   unset($hashes[basename(CONFIG_PATH)]);   //Also ignore the config file
   unset($hashes[basename(PICKUP_PATH)]);   //And pickup DB
   return $hashes;
}
   
//Output dir content infos
function compare_hashes($current_hashes, $version_hashes) {
   $current_diff = array_diff_assoc($current_hashes, $version_hashes);
   $version_diff = array_diff_assoc($version_hashes, $current_hashes);
   
   $version_html = '';
   foreach ($version_diff as $version_name => $version_content) {
      $current_name = isset($current_hashes[$version_name]) ? $version_name : 'No file';
      $current_content = ($current_name == 'No file') ? '' : $current_hashes[$current_name];
      $version_html .= "<tr style=\"color: blue;\"><td>$current_name</td><td>$current_content</td><td>$version_content</td><td>$version_name</td></tr>";
      unset($current_diff[$version_name]);
   }
   
   if (!empty($version_html) || !empty($current_html)) {
      echo "<table border=\"1\"><tbody>\n";
      echo "<tr><td colspan=\"2\"><b>Your files</b></td><td colspan=\"2\"><b>Official {$version_hashes['version']} files</b></td></tr>\n";
      echo "<tr><td><b>Name</b></td><td><b>Hash</b></td><td><b>Hash</b></td><td><b>Name</b></td></tr>\n";
      echo $version_html;
      echo "</tbody></table>";
      if (!empty($version_html)) {
         echo "Blue rows show that some files were either modified, removed or most probably not properly uploaded.\n";
         echo "Please reupload and overwrite all your server files from latest version available from <a href=\"http://gwShack.us\">gwShack</a> (bottom right).\n";
      }
   }
   else {
      success("Your files match perfectly those of gwBBCode {$version_hashes['version']}");
   }
}

function success($text, $return=false) {
   $text = str_replace('<', '&lt;', $text);
   $output = "<span style='color:green'>$text</span>\n";
   if ($return)
      return $output;
   else
      echo $output;
}

function failure($text, $return=false) {
   global $successful;
   $successful = false;
   $text = str_replace('<', '&lt;', $text);
   $output = "<span style='color:red'>$text</span>\n";
   if ($return)
      return $output;
   else
      echo $output;
}


function notice($text, $return=false) {
   $text = str_replace('<', '&lt;', $text);
   $output = "<span style='color:blue'>$text</span>\n";
   if ($return)
      return $output;
   else
      echo $output;
}


function template_list($dirname) {
   $list = Array();
   $dir = GWBBCODE_ROOT . "/../$dirname/";
   $dh  = opendir($dir);
   while (false !== ($filename = readdir($dh)))
      if (is_dir($dir.$filename) && substr($filename, 0, 1) != '.')
         $list[] = $dir.$filename;
   
   return $list;
}
?>