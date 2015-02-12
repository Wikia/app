<?php
/**
 * @package MediaWiki
 * @subpackage Maintenance
 */

/** */

$options= array('verbose');
$optionsWithArgs = array('collision-action','skipto','prefix','postfix','single');
require_once( "../commandLine.inc" );


#Collision action arguments:

// "same" means that we assume any colliding names are the same
// person, and that re-attribution of activities should proceed using
// the user_id of the existing user in the shared database

// "different" assumes that the two colliding users are different, and
// it does not perform attribution adjustments.  It will skip that
// user altogether.  This means that, unless you are going to remember
// to fix the username manually, then their account will not be
// migrated at all

// "prompt" This option is not supported yet, but the idea is that you
// should be prompted, and allowed to specifiy:
//
// 1. Which user should get to keep the name
// 2. What the losing user's name should be changed to
//
// And re-attribution could continue as if there was no collision.

// "import" is like different/prompt with automagic "yes" to all questions
// used by mass import script

global $wgDBname;

if(!function_exists('readline')){
  function readline($str = ""){
    print "$str";
    return rtrim(fgets(STDIN));
  }
 }

if(!function_exists('readline_add_history')){
  function readline_add_history($str = ""){
    return;
  }
 }
$collisionActions = array("same","different","prompt","import");
if(!isset($options["collision-action"]) || $options["collision-action"] == ""){
  print "no collision action specified, assuming \"same\" (look in the source for what this means)\n";
  $options["collision-action"] = "same";
if(!in_array($options["collision-action"],$collisionActions)){
  print "{$options["collision-action"]} is not a valid collision action!\n";
 }
}

#argument processing
$table_bits = explode(".",$args[0]);
$num_pieces = count($table_bits);
if($num_pieces > 1){
  $shared_table = array_pop($table_bits);
  $shared_db = implode(".",$table_bits);
 }
 else{
   $shared_db = $table_bits[0];
   $shared_table = 'user';
 }

$skipto;
if(!empty($options['skipto'])){
  $skipto = $options['skipto'];
 }

$prefix = "";
if(!empty($options['prefix'])){
	$prefix = $options['prefix'];
}

$postfix = "";
if(!empty($options['postfix'])){
	$postfix = $options['postfix'];
}

$single = null;
if (!empty($options['single'])) {
	$single = true;
}

#be careful not to blast the shared DB
global $wgSharedDB;
unset($wgSharedDB);
$collisions = array();

if(isset($wgSharedDB)){
  print "\$wgSharedDB is set to `$wgSharedDB`!, you must unset that variable before running this script!\n";
  exit;
 }

#Get the user list
$dbr =& wfGetDB( DB_MASTER );

$db_main =& wfGetDB( DB_MASTER, array(), 'wikicities' );

$user = $dbr->tableName( 'user' );
$res = $dbr->query( "SELECT * FROM $user" );
while($row = $dbr->fetchObject( $res )){
  $i++;
  if($skipto != ""){
    if($row->user_name == $skipto){
      print "skipped $i entries to $skipto\n";
      $skipto = "";
    }
    else{
      continue;
    }
  }
  if($options['verbose']) print "migrating $row->user_name ($row->user_id) <$row->user_email>\n";
  $res2 = $db_main->query("SELECT user_id,user_name,user_email FROM $shared_db.$shared_table where user_name=".$db_main->addQuotes($row->user_name));

#row is from the wikis DB
#row2 is from the shared/target DB

#  if(mysql_num_rows($res2) >= 1){ #user already exists in target DB
  if($row2 = $db_main->fetchObject( $res2 )) {
    $collisions[] = "$row->user_name exists in both DBs.  Email in $shared_db: $row2->user_email, in $wgDBname: $row->user_email";
    if( strtolower($row->user_email) == strtolower($row2->user_email) && $row2->user_email != ""){
      $newid = $row2->user_id;
    }
    else if($options["collision-action"] == "different"){
      continue;
    }
    else if($options["collision-action"] == "import"){

		$new_shared_username = $row2->user_name;
		$new_local_username = "{$prefix}{$row->user_name}{$postfix}";

		#local DB user name is changed
		alterTable($dbr->tableName( 'user' ),"user_name","\"$row->user_name\"","\"$new_local_username\"");
		moveUserPages("\"$row->user_name\"","\"$new_local_username\"");

		$res3 = $db_main->insert("`$shared_db`.`$shared_table`",
					  array('user_name' => $new_local_username,
						'user_real_name' => $row->user_real_name,
						'user_password' => $row->user_password,
						'user_newpassword' => $row->user_newpassword,
						'user_email' => $row->user_email,
						'user_options' => $row->user_options,
						'user_touched' => $row->user_touched,
						'user_token' => $row->user_token,
						'user_email_authenticated' => $row->user_email_authenticated,
						'user_email_token' => $row->user_email_token,
						'user_email_token_expires' => $row->user_email_token_expires,
						'user_registration' => $row->user_registration));
		$newid = $db_main->insertID();

    }
    else{
      #prompt for new user names
      print "handling entry $i. test $row->user_name exists in both DBs.  Email in $shared_db: $row2->user_email, in $wgDBname: $row->user_email\n";
      readline_add_history("$row2->user_name\n");
      $new_shared_username = rtrim(readline("change user name in $shared_db to[$row2->user_name]:"));
      if($new_shared_username == ""){
	$new_shared_username = $row2->user_name;
      }
     readline_add_history("$new_shared_username\n");
      readline_add_history("$row->user_name\n");
#      $new_local_username = rtrim(readline("change user name in $wgDBname to[$row->user_name $wgDBname]:"));
      $new_local_username = rtrim(readline("change user name in $wgDBname to[{$prefix}{$row->user_name}{$postfix}]:")); #just a hack for the yellowikis2 DB name
      if($new_local_username == ""){
	$new_local_username = "{$prefix}{$row->user_name}{$postfix}";
      }
      if($new_shared_username != $row2->user_name){
	#shared DB user name is changed changed
	alterTable("`$shared_db`.`$shared_table`","user_name","\"$row2->user_name\"","\"$new_shared_username\"", $db_main);
      }
      if($new_local_username != $row->user_name){
	#local DB user name is changed
	alterTable($dbr->tableName( 'user' ),"user_name","\"$row->user_name\"","\"$new_local_username\"");
      }
      $res2 = $db_main->query("SELECT user_id,user_name,user_email FROM $shared_db.$shared_table where user_name=".$db_main->addQuotes($new_local_username));
      $row2 = $db_main->fetchObject($res2);
	if (empty($row2) ){ #user doesn't exist in target DB
	$res3 = $db_main->insert("`$shared_db`.`$shared_table`",
			     array('user_name' => $new_local_username,
				   'user_real_name' => $row->user_real_name,
				   'user_password' => $row->user_password,
				   'user_newpassword' => $row->user_newpassword,
				   'user_email' => $row->user_email,
				   'user_options' => $row->user_options,
				   'user_touched' => $row->user_touched,
				   'user_token' => $row->user_token,
				   'user_email_authenticated' => $row->user_email_authenticated,
				   'user_email_token' => $row->user_email_token,
				   'user_email_token_expires' => $row->user_email_token_expires,
				   'user_registration' => $row->user_registration));
	$newid = $db_main->insertID();
      }
      else{ # new user name exists in target, so we merge into target ID
#	$row2 = $dbr->fetchObject( $res2 );
	$newid = $row2->user_id;
      }
    } # end prompt for user names
  }
  else{ #insert user into the shared database
    $res3 = $db_main->insert("`$shared_db`.`$shared_table`",
			 array('user_name' => $row->user_name,
			       'user_real_name' => $row->user_real_name,
			       'user_password' => $row->user_password,
			       'user_newpassword' => $row->user_newpassword,
			       'user_email' => $row->user_email,
			       'user_options' => $row->user_options,
			       'user_touched' => $row->user_touched,
			       'user_token' => $row->user_token,
			       'user_email_authenticated' => $row->user_email_authenticated,
			       'user_email_token' => $row->user_email_token,
			       'user_email_token_expires' => $row->user_email_token_expires,
			       'user_registration' => $row->user_registration));
    $newid = $db_main->insertID();
  }//end if(mysql_num_rows($res2) >= 1) # user already exists in target DB

  print "new ID is $newid\n";

  #do table alterations
  alterTable($dbr->tableName( 'archive' ),"ar_user",$row->user_id,$newid, 'ar_user_text' );
  alterTable($dbr->tableName( 'filearchive' ),"fa_user",$row->user_id,$newid, 'fa_user_text' );
  alterTable($dbr->tableName( 'image' ),"img_user",$row->user_id,$newid, 'img_user_text' );
  alterTable($dbr->tableName( 'ipblocks' ),"ipb_user",$row->user_id,$newid);
  alterTable($dbr->tableName( 'logging' ),"log_user",$row->user_id,$newid);
  alterTable($dbr->tableName( 'oldimage' ),"oi_user",$row->user_id,$newid);
  alterTable($dbr->tableName( 'recentchanges' ),"rc_user",$row->user_id,$newid, 'rc_user_text' );
  alterTable($dbr->tableName( 'revision' ),"rev_user",$row->user_id,$newid);
  alterTable($dbr->tableName( 'user_groups' ),"ug_user",$row->user_id,$newid);
  alterTable($dbr->tableName( 'user_newtalk' ),"user_id",$row->user_id,$newid);
  alterTable($dbr->tableName( 'watchlist' ),"wl_user",$row->user_id,$newid);

  if (!empty($new_local_username) && $new_local_username != $row->user_name) {
	alterTable($dbr->tableName( 'revision' ),"rev_user_text","\"$row->user_name\"","\"$new_local_username\"");
	alterTable($dbr->tableName( 'image' ),"img_user_text","\"$row->user_name\"","\"$new_local_username\"");
	alterTable($dbr->tableName( 'recentchanges' ),"rc_user_text","\"$row->user_name\"","\"$new_local_username\"");
	alterTable($dbr->tableName( 'archive' ),"ar_user_text","\"$row->user_name\"","\"$new_local_username\"");
	alterTable($dbr->tableName( 'filearchive' ),"fa_user_text","\"$row->user_name\"","\"$new_local_username\"");
	alterTable($dbr->tableName( 'oldimage' ),"oi_user_text","\"$row->user_name\"","\"$new_local_username\"");
  }

	if (!empty($single)) {
		echo "Done.\n";
		exit;
	}
 }

#We only announce collisions if we aren't handling them, or if we're in verbose mode
if(count($collisions) >=1 && ($options["collision-action"] == "different")){# || $options['verbose'])){
  print "There were collisions for these names:\n";
  foreach ($collisions as $description){
    print "$description\n";
  }
 }

print "\nUsers migrated (unless collisions were reported).  Now, you should set the \$wgSharedDB variable to $shared_db\n\n";
$wgSharedDB='wikicities';

function alterTable( $table, $column, $from_val, $to_val, $where_column = false, $db = false ) {
	global $options, $dbr;
	
	if ( $db === false )
		$db = $dbr;

	# Use the indexed field, if specified
	if ( $where_column === false ) {
		$where_column = $column;
	}

	if ( $options['verbose'] ) {
		print "UPDATE low_priority $table SET $column=$to_val where $where_column=$from_val;\n";
	}

	if( !$options['dryrun'] ) {
		wfWaitForSlaves();
		$db->query("UPDATE low_priority $table SET $column=$to_val where $where_column=$from_val");
	}
}

function moveUserPages($from_text, $to_text)
{
	global $dbr, $options;
	// c&p from move_user.php

# Move user pages if there is no exisitng page at the new location
$query = 'UPDATE LOW_PRIORITY IGNORE page set page_title='. $to_text.
	' where (page_namespace = 2 or page_namespace = 3) and page_title = '. $from_text. ';';

if ( isset($options['verbose']) ) print($query. "\n");
if (!isset($options['dryrun'])) $dbr->query($query);

$query = 'UPDATE LOW_PRIORITY IGNORE page set page_title=concat('. $to_text. ',' .
	'substring(page_title, '. (strlen($options['from']) + 1) .')) ' .
	'WHERE (page_namespace = 2 OR page_namespace = 3) and page_title like "'.
	$dbr->escapeLike($options['from']). '/%";';

if ( isset($options['verbose']) ) print($query. "\n");
if (!isset($options['dryrun'])) $dbr->query($query);

}
