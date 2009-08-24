<?php

# Copyright (c) 2007,2008 Luca de Alfaro
# Copyright (c) 2007,2008 Ian Pye
# Copyright (c) 2007 Jason Benterou
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

## MW extension
# This defines a custom MW function to map trust values to HTML markup
# 
# Uses Tool Tip JS library under the LGPL.
# http://www.walterzorn.com/tooltip/tooltip_e.htm

class TextTrust extends TrustBase
{
  
  ## Types of analysis to perform.
  const TRUST_EVAL_VOTE = 0;
  const TRUST_EVAL_EDIT = 10;
  const TRUST_EVAL_MISSING = 15;

  ## the css tag to use
  const TRUST_CSS_TAG = "background-color"; ## color the background
  #$TRUST_CSS_TAG = "color"; ## color just the text
  
  ## ColorText is called multiple times, but we only want to color true text.
  const DIFF_TOKEN_TO_COLOR = "Lin";

  ## Trust normalization values;
  const MAX_TRUST_VALUE = 9;
  const MIN_TRUST_VALUE = 0;
  const TRUST_MULTIPLIER = 10;
  
  ## Token to split trust and origin values on
  const TRUST_SPLIT_TOKEN = ',';

  ## Token to be replaed with <
  const TRUST_OPEN_TOKEN = "QQampo:";
  
  ## Token to be replaed with >
  const TRUST_CLOSE_TOKEN = ":ampc:";

  ## default values for variables found from LocalSettings.php
  var $DEFAULTS = array(
			'wgShowVoteButton' => false,
			'wgVoteText' => "I believe this information is correct",
			'wgThankYouForVoting' => "Thank you for your vote.",
			'wgNoTrustExplanation' => 
			"<p><center><b>There is no trust information available for this text yet.</b></center></p>",
			'wgTrustCmd' => "eval_online_wiki",
			'wgVoteRev' => "vote_revision",
			'wgTrustLog' => "/dev/null",
			'wgTrustDebugLog' => "/dev/null",
			'wgRepSpeed' => 1.0,
			'wgTrustTabText' => "Show Trust",
			'wgTrustExplanation' => 
			"<p><center><b>This is a product of the text trust algoruthm.</b></center></p>",
			);

  ## Median Value of Trust
  var $median = 0.0;

  ## Number of times a revision is looked at.
  var $times_rev_loaded = 0;

  ## Load the article we are talking about
  var $title;

  ## Only color the text once.
  var $colored = false;

  ## Don't close the first opening span tag
  var $first_span = true;

  ## And the same for origin tags
  var $first_origin = true;

  ## And the last revision of the title
  var $current_rev;

  ## Only add the scripts once.
  var $scripts_added = false;

  ## Should we do all the fancy trust processing?
  var $trust_engaged = false;
    
  ## map trust values to html color codes
  var $COLORS = array(
		  "trust0",
		  "trust1",
		  "trust2",
		  "trust3",
		  "trust4",
		  "trust5",
		  "trust6",
		  "trust7",
		  "trust9",
		  "trust10",
		  );

  ## Only write a new trust tag when the trust changes.
  var $current_trust = "trust0";
  
  var $trustJS = '
<script type="text/javascript">/*<![CDATA[*/
var ctrlState = false;
function showOrigin(revnum) {
  document.location.href = wgScriptPath + "/index.php?title=" + encodeURIComponent(wgPageName) + "&diff=" + encodeURIComponent(revnum);
}

// The Vote functionality
function voteCallback(http_request){
  if ((http_request.readyState == 4) && (http_request.status == 200)) {
    document.getElementById("vote-button-done").style.visibility = "visible";
    document.getElementById("vote-button").style.visibility = "hidden";
    //alert(http_request.responseText);
    return true;
  } else {
    alert(http_request.responseText);
    return false;
  }
}

function getQueryVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  } 
  return "";
}

function startVote(){

  var revID = getQueryVariable("oldid");
  if (revID == ""){
    revID = getQueryVariable("diff");
    if (revID == ""){
      revID = wgCurRevisionId;
    }
  }

  return sajax_do_call( "TextTrust::handleVote", [wgUserName, wgArticleId, revID] , voteCallback ); 
}

/*]]>*/</script>';

  var $trustCSS = '
<style type="text/css">/*<![CDATA[*/
.trust0 {
  background-color: #FFB947;
}

.trust1 {
  background-color: #FFC05C;
}

.trust2 {
  background-color: #FFC870;
}

.trust3 {
  background-color: #FFD085;
}

.trust4 {
  background-color: #FFD899;
}

.trust5 {
  background-color: #FFE0AD;
}

.trust6 {
  background-color: #FFE8C2;
}

.trust7 {
  background-color: #FFEFD6;
}

.trust8 {
  background-color: #FFF7EB;
}

.trust9 {
  background-color: #FFFFFF;
}

.trust10 {
  background-color: #FFFFFF;
}

#vote-button-done {
  visibility: hidden;
  position: absolute;
  top: 10px;
  left: 500px;
}

#vote-button {
  position: absolute;
  top: 10px;
  left: 500px;
}

/*]]>*/</style>';

  public static function &singleton( )
  { return parent::singleton( ); }
  
  public function TextTrust() 
  {
   parent::__construct( );
   global $wgExtensionCredits, $wgShowVoteButton, $wgVoteText, $wgThankYouForVoting;
   global $wgNoTrustExplanation, $wgTrustCmd, $wgVoteRev, $wgTrustLog, $wgTrustDebugLog, $wgRepSpeed;
   global $wgTrustTabText, $wgTrustExplanation;

   //Add default values if globals not set.
   if(!$wgShowVoteButton)	
     $wgShowVoteButton = $this->DEFAULTS['wgShowVoteButton'];
   if(!$wgVoteText)
     $wgVoteText = $this->DEFAULTS['wgVoteText' ];
   if(!$wgThankYouForVoting)
     $wgThankYouForVoting = $this->DEFAULTS['wgThankYouForVoting'];
   if(!$wgNoTrustExplanation)
     $wgNoTrustExplanation = $this->DEFAULTS['wgNoTrustExplanation'];
   if(!$wgTrustCmd)
     $wgTrustCmd = $this->DEFAULTS['wgTrustCmd' ];
   if(!$wgVoteRev)
     $wgVoteRev = $this->DEFAULTS['wgVoteRev'];
   if(!$wgTrustLog)
     $wgTrustLog = $this->DEFAULTS['wgTrustLog'];
   if(!$wgTrustDebugLog)
     $wgTrustDebugLog = $this->DEFAULTS['wgTrustDebugLog'];
   if(!$wgRepSpeed)
     $wgRepSpeed = $this->DEFAULTS['wgRepSpeed'];
   if(!$wgTrustTabText)
     $wgTrustTabText = $this->DEFAULTS['wgTrustTabText'];
   if(!$wgTrustExplanation)
     $wgTrustExplanation = $this->DEFAULTS['wgTrustExplanation'];

# Define a setup function
   $wgExtensionFunctions[] = 'ucscColorTrust_Setup';

# Credits
   $wgExtensionCredits['parserhook'][] = array(
					       'name' => 'Trust Coloring',
					       'author' =>'Ian Pye', 
					       'url' => 
					       'http://trust.cse.ucsc.edu', 
					       'description' => 'This Extension 
colors text according to trust.'
					       );
  }
  
  public function setup()
  {
    parent::setup();
    global $wgHooks, $wgParser, $wgRequest, $wgUseAjax, $wgShowVoteButton, $wgAjaxExportList;

# Code which takes the "I vote" action. 
# This has to be statically called.
    if($wgUseAjax && $wgShowVoteButton){
      $wgAjaxExportList[] = "TextTrust::handleVote";
    }
    
# Updater fiered when updating to a new version of MW.
    $wgHooks['LoadExtensionSchemaUpdates'][] = array( &$this, 'updateDB');

# And add and extra tab.
    $wgHooks['SkinTemplateTabs'][] = array( &$this, 'ucscTrustTemplate');

# And add a hook so the colored text is found. 
    $wgHooks['ParserBeforeStrip'][] = array( &$this, 'ucscSeeIfColored');

# Color saved text
    $wgHooks['ArticleSaveComplete'][] = array( &$this, 'ucscRunColoring');

# If the trust tab is not selected, or some other tabs are don't worry about things any more.
    if(!$wgRequest->getVal('trust') || $wgRequest->getVal('action')){
      $this->trust_engaged = false;
      return;
    } 
    $this->trust_engaged = true;
   
# Add trust CSS and JS
    $wgHooks['OutputPageBeforeHTML'][] = array( &$this, 'ucscColorTrust_OP');
 
# Add a hook to initialise the magic words
    $wgHooks['LanguageGetMagic'][] = array( &$this, 'ucscColorTrust_Magic');
   
# Set a function hook associating the blame and trust words with a callback function
    $wgParser->setFunctionHook( 't', array( &$this, 'ucscColorTrust_Render'));

# After everything, make the blame info work
    $wgHooks['ParserAfterTidy'][] = array( &$this, 'ucscOrigin_Finalize');
    
# Pull the median value
    $this->update_median();
  }

  /**
   * Update the DB when MW is updated.
   * This assums that the db has permissions to create tables.
   */
  function updateDB(){
    // Create only those tables missing.
    // Create the needed tables, if neccesary.
    // Pull in the create scripts.
    require_once("TrustUpdateScripts.inc");

    $db =& wfGetDB( DB_MASTER );
    
    // First check to see what tables have already been created.
    $res = $db->query("show tables");
    while ($row = $db->fetchRow($res)){
      $db_tables[$row[0]] = True;
    }

    foreach ($create_scripts as $table => $scripts) {
      if (!$db_tables[$table]){
	foreach ($scripts as $script){
	  $db->query($script);
	}
      }
    }
  }
  
  /** 
   * Turns an ASCII string into an octal encoded one.
   * Call like this: TextTrust::prepareOutput("This is a test");
   */
  static function prepareOutput($command){
    $escaped = "";
    foreach (str_split($command) as $c ){
      $escaped .= sprintf("\\0o%03o", ord($c));
    }
    return $escaped;
  }

  /**
   Run the vote executable.

   Called via ajax, so this must be static.
  */
  static function handleVote($user_name_raw, $page_id_raw = 0, $rev_id_raw = 0){
    
    $response = new AjaxResponse("0");
   
    $dbr =& wfGetDB( DB_SLAVE );
      
    $userName = $dbr->strencode($user_name_raw, $dbr);
    $page_id = $dbr->strencode($page_id_raw, $dbr);
    $rev_id = $dbr->strencode($rev_id_raw, $dbr);
    
    if($page_id){
      // First, look up the id numbers from the page and user strings
      $res = $dbr->select('user', array('user_id'), array('user_name' => $userName), array());
      if ($res){
	$row = $dbr->fetchRow($res);
	$user_id = $row['user_id'];
	if (!$user_id) {
	  $user_id = 0;
	}
      }
      $dbr->freeResult( $res );  

      // Now see if this user has not already voted, and count the vote if its the first time though.
      $res = $dbr->select('wikitrust_vote', array('revision_id'), array('revision_id' => $rev_id, 'voter_id' => $user_id), array());
      if ($res){
	$row = $dbr->fetchRow($res);
	if(!$row['revision_id']){
	
	  $insert_vals = array("revision_id" => $rev_id,
			       "page_id" => $page_id ,
			       "voter_id" => $user_id,
			       "voted_on" => wfTimestampNow()
			       );
	  $dbw =& wfGetDB( DB_MASTER );
	  if ($dbw->insert( 'wikitrust_vote', $insert_vals)){
	    $dbw->commit();
	    $response = new AjaxResponse(implode  ( ",", $insert_vals));
	    self::runEvalEdit(self::TRUST_EVAL_VOTE, $rev_id, $page_id, $user_id); // Launch the evaluation of the vote.
	  }
	} else {
	  $response = new AjaxResponse("Already Voted");
	}
	$dbr->freeResult( $res ); 
      }
    }
    
    return $response;
  }

  /**
   Called just before rendering HTML.
   We add the coloring scripts here.
  */
  function ucscColorTrust_OP(&$out, &$text){
    if (!$this->scripts_added){ // Only add the scripts once.
      $out->addScript($this->trustJS); 
      $out->addScript($this->trustCSS);
      $this->scripts_added = true;
    }
    return true;
  }

 /**
  Updated the cached median reputation value.
 */
 function update_median(){
   $dbr =& wfGetDB( DB_SLAVE );
   $res = $dbr->select('wikitrust_global', 'median', array(), array());
   if ($res){
     $row = $dbr->fetchRow($res);
     $this->median = $row['median']; 
   } 
   $dbr->freeResult( $res );

   // check for divide by 0 errors.
   if ($this->median == 0)
     $this->median = 1;
   
   return $this->median;
 }

 /** 
  * Actually run the eval edit program.
  * Returns -1 on error, the process id of the launched eval process otherwise.
  */
 private static function runEvalEdit($eval_type = self::TRUST_EVAL_EDIT, $rev_id = -1, $page_id = -1, $voter_id = -1){
   
   global $wgDBname, $wgDBuser, $wgDBpassword, $wgDBserver, $wgDBtype, $wgTrustCmd, $wgTrustLog, $wgTrustDebugLog, $wgRepSpeed, $wgDBprefix;
   
   $process = -1;
   $command = "";
   // Get the db.
   $dbr =& wfGetDB( DB_SLAVE );
   
   // Do we use a DB prefix?
   $prefix = ($wgDBprefix)? "-db_prefix " . $dbr->strencode($wgDBprefix): "";
   
   switch ($eval_type) {
   case self::TRUST_EVAL_EDIT:
     $command = escapeshellcmd("$wgTrustCmd -rep_speed $wgRepSpeed -log_file $wgTrustLog -db_host $wgDBserver -db_user $wgDBuser -db_pass $wgDBpassword -db_name $wgDBname $prefix") . " &";
     break;
   case self::TRUST_EVAL_VOTE:
     if ($rev_id == -1 || $page_id == -1 || $voter_id == -1)
       return -1;
     $command = escapeshellcmd("$wgTrustCmd -eval_vote -rev_id " . $dbr->strencode($rev_id) . " -voter_id " . $dbr->strencode($voter_id) . " -page_id " . $dbr->strencode($page_id) . " -rep_speed $wgRepSpeed -log_file $wgTrustLog -db_host $wgDBserver -db_user $wgDBuser -db_pass $wgDBpassword -db_name $wgDBname $prefix") . " &";
     break;
   case self::TRUST_EVAL_MISSING:
     $command = escapeshellcmd("$wgTrustCmd -rev_id " . $dbr->strencode($rev_id) . " -rep_speed $wgRepSpeed -log_file $wgTrustLog -db_host $wgDBserver -db_user $wgDBuser -db_pass $wgDBpassword -db_name $wgDBname $prefix") . " &";
     break;  
   }

   $descriptorspec = array(
			   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
			   1 => array("file", escapeshellcmd($wgTrustDebugLog), "a"),  // stdout is a pipe that the child will write to
			   2 => array("file", escapeshellcmd($wgTrustDebugLog), "a") // stderr is a file to write to
			   );
   $cwd = '/tmp';
   $env = array();
   $process = proc_open($command, $descriptorspec, $pipes, $cwd, $env);
   
   return $process; 
 }
 
/* 
 Code to fork and exec a new process to color any new revisions.
 Called after any edits are made.
*/
 function ucscRunColoring(&$article, &$user, &$text, &$summary, $minor, $watch, $sectionanchor, &$flags, $revision) { 
   if (self::runEvalEdit(self::TRUST_EVAL_EDIT) >= 0)
     return true;
   return false;
 }

# Actually add the tab.
 function ucscTrustTemplate($skin, &$content_actions) { 
  
   global $wgTrustTabText, $wgRequest;
   if (!isset($wgTrustTabText)){
     $wgTrustTabText = "trust";
   }
   
   if ($wgRequest->getVal('action')){
     // we don't want trust for actions.
     return true;
   }
   
   $trust_qs = $_SERVER['QUERY_STRING'];
   if($trust_qs){
     $trust_qs = "?" . $trust_qs .  "&trust=t";
   } else {
     $trust_qs .= "?trust=t"; 
   }
   
   $content_actions['trust'] = array ( 'class' => '',
				       'text' => $wgTrustTabText,
				       'href' => 
				       $_SERVER['PHP_SELF'] . $trust_qs );

   if($wgRequest->getVal('trust')){
     $content_actions['trust']['class'] = 'selected';
     $content_actions['nstab-main']['class'] = '';
     $content_actions['nstab-main']['href'] .= '';
   } else {
     $content_actions['trust']['href'] .= '';
   }
  return true;
 }
 
 /**
  If colored text exists, use it instead of the normal text, 
  but only if the trust tab is selected.
  
  TODO: Make this function work with caching turned on.
 */
 function ucscSeeIfColored(&$parser, &$text, &$strip_state) { 
   global $wgRequest, $wgTrustExplanation, $wgUseAjax, $wgShowVoteButton, $wgDBprefix, $wgNoTrustExplanation, $wgVoteText, $wgThankYouForVoting; 

   // Turn off caching for this instanching for this instance.
   $parser->disableCache();
   
   // Get the db.
   $dbr =& wfGetDB( DB_SLAVE );

   // Do we use a DB prefix?
   $prefix = ($wgDBprefix)? "-db_prefix " . $dbr->strencode($wgDBprefix): "";

   // Text for showing the "I like it" button
   $voteitText = "";
   if ($wgUseAjax && $wgShowVoteButton){
     $voteitText = "
".self::TRUST_OPEN_TOKEN."div id='vote-button'".self::TRUST_CLOSE_TOKEN."".self::TRUST_OPEN_TOKEN."input type='button' name='vote' value='" . $wgVoteText . "' onclick='startVote()' /".self::TRUST_CLOSE_TOKEN."".self::TRUST_OPEN_TOKEN."/div".self::TRUST_CLOSE_TOKEN."
".self::TRUST_OPEN_TOKEN."div id='vote-button-done'".self::TRUST_CLOSE_TOKEN.$wgThankYouForVoting.self::TRUST_OPEN_TOKEN."/div".self::TRUST_CLOSE_TOKEN."
";
   }

   // Return if trust is not selected.
   if (!$this->trust_engaged)
     return true;
   
   // Save the title object, if it is not already present
   if (!$this->title){
     $this->title = $parser->getTitle();
   }
    
   // count the number of times we load this text
   $this->times_rev_loaded++;

   // Load the current revision id.
   if (!$this->current_rev){
     if ($parser->mRevisionId){
       $this->current_rev = $parser->mRevisionId;
     } else {
       // Sometimes the revisionId field is not filled in.
       $this->current_rev = $this->title->getPreviousRevisionID( PHP_INT_MAX );
     }
   }

  /**
   This method is being called multiple times for each page. 
   We only pull the colored text for the first time through.
  */
  if ($this->colored){
    return true;
  }

  if (strstr($text, "{{ns:project}}")) {
    return true;
  }

  if ($wgRequest->getVal('diff')){
    // For diffs, look for the absence of the diff token instead of counting
    if(substr($text,0,3) == self::DIFF_TOKEN_TO_COLOR){
      return true;
    }
  }

   // if we made it here, we are going to color some text
   $this->colored = true;
   
   $res = $dbr->select('wikitrust_colored_markup', 'revision_text',
		       array( 'revision_id' => $this->current_rev ), array());
   if ($res){
     $row = $dbr->fetchRow($res);
     $colored_text = $row[0];
     if ($colored_text){
       // First, make sure that there are not any instances of our tokens in the colored_text
       $colored_text = str_replace(self::TRUST_OPEN_TOKEN, "", $colored_text);
       $colored_text = str_replace(self::TRUST_CLOSE_TOKEN, "", $colored_text);
       
       // Now update the text.
       $text = $voteitText . $colored_text . "\n" . $wgTrustExplanation;
     } else {
       // If the colored text is missing, generate it in the background.
       // For now, return a message about the missing text.
       self::runEvalEdit(self::TRUST_EVAL_MISSING);
       $text = $wgNoTrustExplanation . "\n" . $text;
     }
   } else {
     return false;
   }
   $dbr->freeResult( $res );
   return true;
 }
 
 /* Register the tags we are intersted in expanding. */
 function ucscColorTrust_Magic( &$magicWords, $langCode ) {
   $magicWords[ 't' ] = array( 0, 't' );
   return true;
 }
 
 /* Turn the finished trust info into a span tag. Also handle closing tags. */
 function ucscOrigin_Finalize(&$parser, &$text) {
   global $wgScriptPath;
   $count = 0;
   $text = '<script type="text/javascript" src="'.$wgScriptPath.'/extensions/Trust/js/wz_tooltip.js"></script>' . $text;
   $text = preg_replace('/' . self::TRUST_OPEN_TOKEN . '/', "<", $text, -1, $count);
   $text = preg_replace('/' . self::TRUST_CLOSE_TOKEN .'/', ">", $text, -1, $count);
   $text = preg_replace('/<\/p>/', "</span></p>", $text, -1, $count);
   $text = preg_replace('/<p><\/span>/', "<p>", $text, -1, $count);
   $text = preg_replace('/<li><\/span>/', "<li>", $text, -1, $count);
  
   return true;
 }

 /* Text Trust */
 function ucscColorTrust_Render( &$parser, $combinedValue = "0,0,0" ) {
   
   // Split the value into trust and origin information.
   // 0 = trust
   // 1 = origin
   // 2 = contributing author
   $splitVals = explode(self::TRUST_SPLIT_TOKEN, $combinedValue);
   
   $class = $this->computeColorFromFloat($splitVals[0]);
   $output = self::TRUST_OPEN_TOKEN . "span class=\"$class\"" 
     . "onmouseover=\"Tip('".$splitVals[2]."')\" onmouseout=\"UnTip()\""
     . "onclick=\"showOrigin(" 
     . $splitVals[1] . ")\"" . self::TRUST_CLOSE_TOKEN;

   $this->current_trust = $class;
   if ($this->first_span){
     $this->first_span = false;
   } else {
     $output = self::TRUST_OPEN_TOKEN . "/span" . self::TRUST_CLOSE_TOKEN . $output;
   }
   
   return array ( $output, "noparse" => false, "isHTML" => false );
 }
 
 /** 
  Maps from the online trust values to the css trust values.
  Normalize the value for growing wikis.
 */
 function computeColorFromFloat($trust){
   $normalized_value = min(self::MAX_TRUST_VALUE, max(self::MIN_TRUST_VALUE, 
						      (($trust + .5) * self::TRUST_MULTIPLIER) 
						      / $this->median));
   return $this->computeColor3($normalized_value);
 }
 
 /* Maps a trust value to a HTML color representing the trust value. */
 function computeColor3($fTrustValue){
   return $this->COLORS[$fTrustValue];
 }
}    

TextTrust::singleton();

?>
