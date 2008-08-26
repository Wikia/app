<?php
/*
 * metavid2mvWiki.php Created on May 8, 2007
 *
 * All Metavid Wiki code is Released under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 * 
 * 
 * this is the script we will use to migrate the existing metavid db the mv wiki db
 */
$cur_path = $IP = dirname(__FILE__);
//include commandLine.inc from the mediaWiki maintance dir: 
require_once ('../../../maintenance/commandLine.inc');
require_once ('metavid2mvWiki.inc.php');

//include util functions: 
require_once('maintenance_util.inc.php');
/*
 * assume the wiki user has access to the metavid table and that the
 * metavid table is titled `metavid`
 */

/*
 * default pages (@@todo move to install script)


Template:Congress Person

<noinclude>Congress Person template simplifies 
		the structure of articles about Congress People.
		<pre>{{Congress Person|
|Full Name=The full name of the Congress person|
|Name OCR=The Name as it appears in on screen video text|
|GovTrack ID=Congress Person' <a href="www.govtrack.us">govtrack.us</a> person ID|
|Open Secrets ID=Congress Person's <a href="http://www.opensecrets.org/">Open Secrets</a> Id|
|Bio Guide ID=Congressional Biographical Directory id|
|Title=Title (Sen. or Rep.)|
|State=State|
|Party=The Cogress Persons Political party|
}}</pre>The order of the fields is not relevant. The template name (Congress Person) should be given as the ''first'' thing on a page.
</noinclude><includeonly>
[[Image:{{PAGENAME}}.jpg|left]]
{{ #if: {{{Full Name}}}| [[Full Name:={{{Full Name}}}| ]] |}} 
{{ #if: {{{Name OCR}}}| [[Name OCR:={{{Name OCR}}}| ]] |}} 
{{ #if: {{{GovTrack ID}}}| [[GovTrack ID:={{{GovTrack ID}}}| ]] |}} 
{{ #if: {{{Open Secrets ID}}}| [[Open Secrets ID:={{{Open Secrets ID}}}| ]] |}} 
{{ #if: {{{Bio Guide ID}}}| [[Bio Guide ID:={{{Bio Guide ID}}}| ]] |}} 
{{ #if: {{{Title}}}| [[Title:={{{Title}}}| ]] |}} 
{{ #if: {{{State}}}| [[State:={{{State}}}| ]] |}} 
{{ #if: {{{Party}}}| [[Party:={{{Party}}}| ]] |}} 
[[Category:Person]][[Category:Congress Person]]
</includeonly>

Template:Ht_en

<noinclude>
This is the default Template for the display of transcript text. 
</noinclude><includeonly>{{ #if:  {{{PersonName|}}} | {{ #ifexist: Image:{{{PersonName}}}.jpg | [[Image:{{{PersonName}}}.jpg|44px|left]]|[[Image:Missing person.jpg|44px|left]]}}[[{{{PersonName}}}]]: |}}{{{BodyText}}}
</includeonly>

*/

//some metavid constants
define('CC_OFFSET', -30);

$optionsWithArgs = array ();


if (count($args) == 0 || isset ($options['help'])) {
	print<<<EOT
Load Streams/data from the metavid database

Usage php metavid2mvWiki.php [options] action	
ie: senate_proceeding_04-11-07
options:
		--skipimage will skip image downloading 
		--skiptext skips text sync
		--skipfiles skips files
		--skipSpeechMeta  skips annotation track with Speech By tags for continues Spoken By attr 
		--force will force updates (if edited by a human its skiped)
actions:
		\$stream_name  will proccess that stream name		
		'all_in_sync' will insert all streams that are tagged in_sync
		'all_in_wiki' will run on all streams in the wiki 		
		'all_with_files' will insert all streams with files (and categorize acording to sync status)
		'all_sync_past_date' --date [mm/dd/yy] all in_sync streams past date (-d option required)
		[stream_name] will insert all records for the given stream name
		'people' [person_name] will insert all the people articles optional followed by a person name 	
		'bill' [bill_key]? ...empty bill key will insert all bills based on gov track subject page
		'interest' will insert interests (uses people as base so run people first) 
		'update_templates' will update templates & some semantic properties  
		'file_check' checks inserted streams file urls/pointers

EOT;
	exit ();
}

/*
 * set up the article set for the given stream/set
 */
$mvForceUpdate= (isset($options['force']))?true:false;	

switch ($args[0]) {
	case 'all_in_sync' :
		do_stream_insert('all');
	break;
	case 'all_in_wiki':	
		do_stream_insert('all_in_wiki');
	break;
	case 'all_with_files':
		do_stream_insert('files');
	break;
	case 'all_sync_past_date':
		if(!isset($options['date']))die('date missing'."\n");
		do_stream_insert('all_sync_past_date');
	break;
	case 'people' :
		$force = (isset($options['force']))?true:false;	
		$person_name = (isset($args[1]))?$args[1]:'';
		do_people_insert('',$person_name, $force);
	break;
	case 'bill':
		$bill_key = (isset($args[1]))?$args[1]:'';
		do_bill_insert($bill_key);
	break;
	case 'interest':
		do_people_insert($lookUpInterest=true);
	break;
	case 'update_templates' :
		$force = (isset($options['force']))?true:false;
		include_once('metavid_gov_templates.php');
		upTemplates($force);
	break;
	//by default treat the argument as a stream name: 
	case 'mvd_error_check':
		
	break;
	case 'rm_congress_persons':
		do_rm_congress_persons();
	break;
	default :
		do_stream_insert('stream', $args[0]);
	break;
}

?>
	
