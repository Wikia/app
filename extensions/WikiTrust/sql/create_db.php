#!/usr/bin/php
<?php

# Copyright (c) 2007,2008 Luca de Alfaro
# Copyright (c) 2007,2008 Ian Pye
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License as
# published by the Free Software Foundation; either version 2 of the
# License, or (at your option) any later version.

# This program is distributed in the hope that it will be useful, but
# WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
# General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307
# USA

# This script created the wikitrust tables needed for an online analysis.
# Usage: ./create_db.php "path to the target MediaWiki installation" 
#                         database_root_user 
#                         [remove]

$mw_root = $argv[1];
$dba = $argv[2];
$dba_pass = "";

// If true, we remove tables. If false, we create them.
$do_remove = ($argc > 2 && $argv[3] == "remove")? true: false; 

$db_indexes = array(); // Current indexes of interest.
$db_tables = array(); // Store all of the tables currently present.
$create_scripts = array(); // The actual SQL to create tables. Defined below.
$remove_scripts = array(); // The actual SQL to remove tables. Defined below.
$create_index_scripts = array();
$remove_index_scripts = array();

if(!$mw_root || !is_dir($mw_root) || !isset($dba)
   || !is_file($mw_root."/LocalSettings.php")){
  print "Usage: ./create_db.php 'path to the target MediaWiki installation' database_root_user [remove]\n";
  exit(-1);
 }

print ($do_remove)? "Removing tables\n": "Creating tables\n";
print "Do you really want to do this? [Y/n]: ";
$continue = strtoupper(fread(STDIN, 1));
if ($continue != "Y" && $continue != "\n"){
  print "Aborting script\n";
  exit(0);
 }

// Reads the root password from std in, or a file if given
if (array_key_exists(4, $argv) && is_file($argv[4])){
  $dba_pass = trim(file_get_contents($argv[4]));
} else {
  print "Enter the root mysql password:\n";
  $dba_pass = rtrim(shell_exec('
  bash -c \'
  stty_orig=`stty -g`
  trap "stty ${stty_orig}; exit" 1 2 3 15
  stty -echo <&- 2<&-
  read -s PASS
  stty ${stty_orig} <&- 2<&-
  trap 1 2 3 15
  echo $PASS
  \'
  '));
}

// Load all of the MW files.
include($mw_root."/maintenance/commandLine.inc");

global $wgDBserver, $wgDBname, $wgDBuser, $wgDBprefix, $wgCreateRevisionIndex;

// Source the update scripts
require($mw_root."/extensions/Trust/TrustUpdateScripts.inc");

// If this is set, create an index on the revision table.
if ($wgCreateRevisionIndex){
  $db_indexes[$wgDBprefix . 'revision'] = array(); 
 } else {
  $db_indexes[$wgDBprefix . 'revision']['revision_id_timestamp_idx'] = True; 
 }

// Create the needed tables, if neccesary.
$dbr =& wfGetDB( DB_SLAVE );

// First check to see what tables have already been created.
$res = $dbr->query("show tables");
while ($row = $dbr->fetchRow($res)){
  $db_tables[$row[0]] = True;
 }

// And check to see what indexes have already been created.
foreach ($db_indexes as $table => $idx){
  $res = $dbr->query("show index from " . $table);
  while ($row = $dbr->fetchRow($res)){
    $db_indexes[$table][$row[2]] = True;
  }
}

// We need root priveledges to do this.
$db_root = Database::newFromParams($wgDBserver, $dba, $dba_pass, $wgDBname);

if (!$do_remove){
  // Now do the actual creating of tables.
  foreach ($create_scripts as $table => $scripts) {
    if (!array_key_exists($table, $db_tables)){
      foreach ($scripts as $script){
        $db_root->query($script);
      }
    }
  }
  // Now do the actual creating of indexes.
  foreach ($create_index_scripts as $table => $idxs){
    foreach ($idxs as $name => $idx){
      if(!array_key_exists($name, $db_indexes[$table])){
        $db_root->query($idx);
      }
    }
  }
} else {
  // Or removing.
  foreach ($remove_scripts as $table => $scripts) {
    if (array_key_exists($table, $db_tables)){
      foreach ($scripts as $script){
        $db_root->query($script);
      }
    }
  }
  // ...Of indexes.
  foreach ($remove_index_scripts as $table => $idxs){
    foreach ($idxs as $name => $idx){
      if(array_key_exists($name, $db_indexes[$table])){
        $db_root->query($idx);
      }
    }
  }
}

// Finally, we commit any leftovers.
$db_root->query("COMMIT");

print ($do_remove)? "Removed tables\n": "Created tables\n";

?>
