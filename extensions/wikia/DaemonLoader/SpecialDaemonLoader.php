<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * A Special Page extension that runs background scripts.
 *
 * @addtogroup Extensions
 *
 * @author Piotr Molski <moli@wikia-inc.com>
 * @copyright Copyright © 2009, Piotr Molski
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/*
CREATE TABLE dataware.daemon_tasks (
  dt_id int unsigned NOT NULL auto_increment,
  dt_name varbinary(100) NOT NULL,
  dt_script varbinary(100) NOT NULL,
  dt_desc tinyblob NOT NULL default '',
  dt_input_params blob NOT NULL default '',
  dt_value_type int unsigned NOT NULL default 1,
  dt_addedby int unsigned NOT NULL,
  dt_visible int(1) unsigned NOT NULL default 1,
  dt_added char(14) not null default '',
  PRIMARY KEY (dt_id),
  UNIQUE KEY (dt_name)
);

CREATE TABLE dataware.daemon_tasks_jobs (
  dj_id int unsigned NOT NULL auto_increment,
  dj_dt_id int unsigned NOT NULL,
  dj_start char(14) NOT NULL default '',
  dj_end char(14) NOT NULL default '',
  dj_frequency enum('day','week','month') NOT NULL default 'day',
  dj_visible tinyint(1) default 1,
  dj_param_values blob NOT NULL default '',
  dj_result_file tinyblob NOT NULL,
  dj_result_emails tinyblob NOT NULL default '',
  dj_createdby int unsigned NOT NULL default 0,
  dj_added char(14) NOT NULL default '',
  PRIMARY KEY (dj_id),
  KEY `dj_dt_id` (dj_dt_id),
  KEY `visible` (dj_visible),
  KEY `period` (dj_start, dj_end),
  KEY `frequency` (dj_frequency)
);
*/

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'DaemonLoader',
	'author' => 'Piotr Molski',
	'descriptionmsg' => 'daemonloader-desc',
);

global $wgAjaxExportList;
$wgAjaxExportList[] = "DaemonLoader::axShowDaemon";
$wgAjaxExportList[] = "DaemonLoader::axGetWikiList";
$wgAjaxExportList[] = "DaemonLoader::axGetTaskParams";
$wgAjaxExportList[] = "DaemonLoader::axJobsList";
$wgAjaxExportList[] = "DaemonLoader::axRemoveJobsList";
$wgAjaxExportList[] = "DaemonLoader::axGetJobInfo";

$wgAvailableRights[] = 'daemonloader';
$wgGroupPermissions['staff']['daemonloader'] = true;

$wgDaemonLoaderAdmins = array( "Eloy.wikia", "Moli.wikia" );

$dir =  dirname( __FILE__ );
$wgAutoloadClasses['DaemonLoader'] = $dir . '/SpecialDaemonLoader_body.php';
$wgSpecialPages['DaemonLoader'] = array( /*class*/ 'DaemonLoader', /*name*/ 'DaemonLoader', /* permission */'', /*listed*/ true, /*function*/ false, /*file*/ false );
$wgSpecialPageGroups['DaemonLoader'] = 'other';
$wgExtensionMessagesFiles['DaemonLoader'] = $dir . '/SpecialDaemonLoader.i18n.php';

