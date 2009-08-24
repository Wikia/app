<?php

class TextTrustImpl {

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

  ## Server forms
  const NOT_FOUND_TEXT_TOKEN = "TEXT_NOT_FOUND";
  const TRUST_COLOR_TOKEN = "<!--trust-->";

  ## Context for communicating with the trust server
  const TRUST_TIMEOUT = 10;

  ## Median Value of Trust
  var $median = 1.0;

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

  ## default values for variables found from LocalSettings.php
  var $DEFAULTS = array(
			'wgShowVoteButton' => false,
			'wgTrustCmd' => "eval_online_wiki",
			'wgTrustLog' => "/dev/null",
			'wgTrustDebugLog' => "/dev/null",
			'wgRepSpeed' => 1.0,
			'wgContentServerURL' => "http://localhost:10302/?",
			);

  ## Only write a new trust tag when the trust changes.
  var $current_trust = "trust0";

  public function TextTrustImpl(){
    global $wgShowVoteButton, $wgTrustCmd, $wgTrustLog, 
      $wgTrustDebugLog,  $wgContentServerURL, $wgRepSpeed;

    # Add localized messages.
    wfLoadExtensionMessages('RemoteTrust');

    //Add default values if globals not set.
    if(!$wgShowVoteButton)	
      $wgShowVoteButton = $this->DEFAULTS['wgShowVoteButton'];
    if(!$wgTrustCmd)
      $wgTrustCmd = $this->DEFAULTS['wgTrustCmd' ];
    if(!$wgTrustLog)
      $wgTrustLog = $this->DEFAULTS['wgTrustLog'];
    if(!$wgTrustDebugLog)
      $wgTrustDebugLog = $this->DEFAULTS['wgTrustDebugLog'];
    if(!$wgRepSpeed)
      $wgRepSpeed = $this->DEFAULTS['wgRepSpeed'];
    if(!$wgContentServerURL)
      $wgContentServerURL = $this->DEFAULTS['wgContentServerURL'];
  }
   
  /**
   Records the vote.
   Called via ajax, so this must be static.
  */
  static function handleVote($user_name_raw, $page_id_raw = 0, 
			     $rev_id_raw = 0, $page_title = ""){
    
    global $wgContentServerURL;
    $response = new AjaxResponse("0");
    
    $dbr =& wfGetDB( DB_SLAVE );
    
    $userName = $dbr->strencode($user_name_raw, $dbr);
    $page_id = $dbr->strencode($page_id_raw, $dbr);
    $rev_id = $dbr->strencode($rev_id_raw, $dbr);
    
    if($page_id){
      // First, look up the id numbers from the page and user strings
      $res = $dbr->select('user', array('user_id'), 
			  array('user_name' => $userName), array());
      if ($res){
	$row = $dbr->fetchRow($res);
	$user_id = $row['user_id'];
	if (!$user_id) {
	  $user_id = 0;
	}
      }
      $dbr->freeResult( $res ); 
      
      $ctx = stream_context_create(
				   array('http' => array(
							 'timeout' => 
							 self::TRUST_TIMEOUT
							 )
					 )
				   );
      
      $vote_str = ("Voting at " . $wgContentServerURL . "vote=1&rev=$rev_id&page=$page_id&user=$user_id&page_title=$page_title&time=" . wfTimestampNow());
      $colored_text = file_get_contents($wgContentServerURL . "vote=1&rev=".urlencode($rev_id)."&page=".urlencode($page_id)."&user=".urlencode($user_id)."&page_title=".urlencode($page_title)."&time=" . urlencode(wfTimestampNow()), 0, $ctx);
      $response = new AjaxResponse($vote_str);	   
    }
    return $response;
  }
  
  /**
   Called just before rendering HTML.
   We add the coloring scripts here.
  */
  function ucscColorTrust_OP(&$out, &$text){
    global $wgScriptPath;
    
    if (!$this->scripts_added){ // Only add the scripts once.
      $out->addScript("<script type=\"text/javascript\" src=\"".$wgScriptPath."/extensions/Trust/js/trust.js\"></script>\n");
      $out->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"".$wgScriptPath."/extensions/Trust/css/trust.css\" />\n");
      $this->scripts_added = true;
    }
    return true;
  }
  
  /**
   If colored text exists, use it instead of the normal text, 
   but only if the trust tab is selected.
  */
  function ucscSeeIfColored(&$parser, &$text, &$strip_state = Null) { 
    global $wgRequest, $wgUseAjax, $wgShowVoteButton, $wgDBprefix, 
      $wgContentServerURL; 
    
    // Get the db.
    $dbr =& wfGetDB( DB_SLAVE );
    
    // Do we use a DB prefix?
    $prefix = ($wgDBprefix)? "-db_prefix " . $dbr->strencode($wgDBprefix): "";
    
    // Text for showing the "I like it" button
    $voteitText = "";
    if ($wgUseAjax && $wgShowVoteButton){
      $voteitText = "
".self::TRUST_OPEN_TOKEN."div id='vote-button'".self::TRUST_CLOSE_TOKEN."".self::TRUST_OPEN_TOKEN."input type='button' name='vote' value='" . wfMsgNoTrans("wgVoteText") . "' onclick='startVote()' /".self::TRUST_CLOSE_TOKEN."".self::TRUST_OPEN_TOKEN."/div".self::TRUST_CLOSE_TOKEN."
".self::TRUST_OPEN_TOKEN."div id='vote-button-done'".self::TRUST_CLOSE_TOKEN . wfMsgNoTrans("wgThankYouForVoting") . self::TRUST_OPEN_TOKEN."/div".self::TRUST_CLOSE_TOKEN."
";
    }

    // Return if trust is not selected.
    if(!$wgRequest->getVal('trust') || $wgRequest->getVal('action')){
      return true;
    }
   
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
   
    if ($wgRequest->getVal('diff')){
      // For diffs, look for the absence of the diff token instead of counting
      if(substr($text,0,3) == self::DIFF_TOKEN_TO_COLOR){
	return true;
      }
    }

    // if we made it here, we are going to color some text
    $this->colored = true;
    
    // Check to see if this page is part of the coloring project. 
    // Disabled for now.
    //if (!strstr($text, self::TRUST_COLOR_TOKEN)){
    //  $text = $wgNotPartExplanation . "\n" . $text;
    //  return true;
    //}

    // Get the page id and other data  
    $colored_text="";
    $page_id=0;
    $rev_timestamp="";
    $rev_user=0;
    $res = $dbr->select('revision', array('rev_page', 'rev_timestamp', 
					  'rev_user'), 
			array('rev_id' => $this->current_rev), array());
    if ($res){
      $row = $dbr->fetchRow($res);
      $page_id = $row['rev_page'];
      $rev_user = $row['rev_user'];
      $rev_timestamp = $row['rev_timestamp']; 
      if (!$page_id) {
	$page_id = 0;
      }
    }
    $dbr->freeResult( $res );  
    
    $page_title = $_GET['title'];
    $ctx = stream_context_create(
				 array('http' => array(
						       'timeout' => 
						       self::TRUST_TIMEOUT
						       )
				       )
				 );
    
    // Should we do doing this via HTTPS?
    $colored_raw = (file_get_contents($wgContentServerURL . "rev=" . urlencode($this->current_rev) . "&page=".urlencode($page_id)."&page_title=".urlencode($page_title)."&time=".urlencode($rev_timestamp)."&user=".urlencode($rev_user)."", 0, $ctx));
    
    if ($colored_raw && $colored_raw != self::NOT_FOUND_TEXT_TOKEN){
    
      // Inflate. Pick off the first 10 bytes for python-php conversion.
      $colored_raw = gzinflate(substr($colored_raw, 10));
      
      // Pick off the median value first.
      $colored_data = explode(",", $colored_raw, 2);
      $colored_text = $colored_data[1];
      if (preg_match("/^[+-]?(([0-9]+)|([0-9]*\.[0-9]+|[0-9]+\.[0-9]*)|
			    (([0-9]+|([0-9]*\.[0-9]+|[0-9]+\.[0-9]*))[eE][+-]?[0-9]+))$/", $colored_data[0])){
	$this->median = $colored_data[0];
      } 
      
      // First, make sure that there are not any instances of our tokens in the colored_text
      $colored_text = str_replace(self::TRUST_OPEN_TOKEN, "", $colored_text);
      $colored_text = str_replace(self::TRUST_CLOSE_TOKEN, "", $colored_text);
      
      $colored_text = preg_replace("/&apos;/", "'", $colored_text, -1);
      
      $colored_text = preg_replace("/&amp;/", "&", $colored_text, -1);
      
      $colored_text = preg_replace("/&lt;/", self::TRUST_OPEN_TOKEN, $colored_text, -1);
      $colored_text = preg_replace("/&gt;/", self::TRUST_CLOSE_TOKEN, $colored_text, -1);
      
      // Now update the text.
      $text = $voteitText . $colored_text . "\n" . 
	wfMsgNoTrans("wgTrustExplanation");
    } else {
      // Return a message about the missing text.
      $text = $parser->recursiveTagParse(wfMsgNoTrans("wgNoTrustExplanation")) . "\n" . $text;
      return false;
    }
    
    return true;
  }
 
  /* Register the tags we are intersted in expanding. */
  function ucscColorTrust_Magic( &$magicWords, $langCode ) {
    $magicWords[ 't' ] = array( 0, 't' );
    return true;
  }
  
  /* Pull in any colored text. Also handle closing tags. */
  function ucscOrigin_Finalize(&$parser, &$text) {
    global $wgScriptPath, $IP, $wgOut;
    
    if(!$this->colored){
      // This is to handle caching problems.
      if (!strstr($text, "This page has been accessed")){
	$colored_text = $text;
	if ($this->ucscSeeIfColored($parser, $colored_text)){
	  $text = $wgOut->parse( $colored_text );
	} else {
	  $text = $colored_text;
	}
      } else {
	$colored_text = $text;
	if ($this->ucscSeeIfColored($parser, $colored_text)){
	  $wgOut->mBodytext = $wgOut->parse( $colored_text );
	} else {
	  $wgOut->mBodytext = $colored_text;
	}
      }
    } 
    
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

?>