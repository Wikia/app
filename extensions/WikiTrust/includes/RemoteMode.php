<?php

class WikiTrust extends WikiTrustBase {
  public static function ucscOutputBeforeHTML(&$out, &$text){
    # We are done if the trust tab isn't selected
    global $wgRequest;
    $use_trust = $wgRequest->getVal('trust'); 
    if (!isset($use_trust) || 
        (($wgRequest->getVal('action') && 
          ($wgRequest->getVal('action') != 'purge'))))
	return true;

    self::color_addFileRefs($out);

    $ctext_html = "<div id='text-button'><input type='button' name='ctext' value='getColoredText' onclick='startGetColoredText()'></div>";
    $vtext_html = "<div id='vote-button'><input type='button' name='vote' value='" . wfMsgNoTrans("wgVoteText") . "' onclick='startVote()' /></div><div id='vote-button-done'>". wfMsgNoTrans("wgThankYouForVoting") ."</div>";
    
    $out->addHTML($ctext_html);
    $out->addHTML($vtext_html);

    return true;
  }

  public static function vote_recordVote(&$dbr, $user_id, $page_id, $rev_id)
  {
    // TODO: forward on vote?  Shouldn't RemoteMode assume that voting
    // is in local database?  Ian and Bo discussed and there's still
    // some fuzziness on how RemoteMode would work without help from WMF.
    // Main problem seems to be cross-site scripting issues with
    // the buttons.
    global $wgWikiTrustContentServerURL;

    $ctx = stream_context_create(
	array('http' => array( 'timeout' => self::TRUST_TIMEOUT ) )
      );

    // TODO: We need a shared key added to this.
    $colored_text = file_get_contents($wgWikiTrustContentServerURL .
	"vote=1&rev=".  urlencode($rev_id).
	"&page=".  urlencode($page_id).
	"&user=".  urlencode($user_id).
	"&page_title=". urlencode($page_title).
	"&time=" .  urlencode(wfTimestampNow()), 0, $ctx);
    $response = new AjaxResponse($vote_str);    
    return $response;
  }


	/**
   Returns colored markup.
	 
   @return colored markup.
  */
  static function ajax_getColoredText($page_title_raw,
				 $page_id_raw = null, 
				 $rev_id_raw = null){
    global $wgParser, $wgWikiTrustContentServerURL, $wgWikiTrustApiURL, $wgUser;
    global $wgMemc;

    $response = new AjaxResponse("");
    $request_headers = apache_request_headers();

    // Try to use gzip for the content, if possible.
    // Ian - This isn't working with redherring, for some reason.
    if (strstr($request_headers["Accept-Encoding"], "gzip")){
      //  $response->setContentType("gzip");
    }

    // Can set this to use client side caching, but this can also cause
    // problems.
    // Mark that the content can be cached
    // $response->setCacheDuration(self::TRUST_CACHE_VALID);
    
    if(!$page_id_raw || !$rev_id_raw){
      $data = array('action'=>'query',
		    'prop'=>'revisions',
		    'titles'=>$page_title_raw,
		    'rvlimit'=>'1',
		    'rvprop' => 'ids',
		    'format' => 'json'
		    );
      
      $page_info_raw = file_get_contents($wgWikiTrustApiURL
					 .http_build_query($data));
      $page_json = json_decode($page_info_raw, true);
      $pages_arr = array_keys($page_json["query"]["pages"]);

      // Now, parse out only what we need
      if(!$page_id_raw){
	$page_id_raw = $pages_arr[0];
      }

      if(!$rev_id_raw){
	$rev_id_raw = $page_json["query"]["pages"][$page_id_raw]["revisions"][0]["revid"];
      }
    }

    $dbr = wfGetDB( DB_SLAVE );
    
    $page_id = $dbr->strencode($page_id_raw, $dbr);
    $rev_id = $dbr->strencode($rev_id_raw, $dbr);
    $page_title = $dbr->strencode($page_title_raw, $dbr);    

    // Check the If-Modified-Since header.
    // If the timestamp of the requested revision is earlier than the IMS 
    // header, return 304 and do nothing further.
    $rev_ts = '19700101000000';
    $res = $dbr->select(self::util_getDbTable('wikitrust_colored_markup'), 
			array('revision_createdon'), 
			array('revision_id' => $rev_id), array());
    if ($res && $dbr->numRows($res) > 0){
      $row = $dbr->fetchRow($res);
      $rev_ts = $row['revision_createdon'];

      if (!$rev_ts) {
	$rev_ts = '19700101000000';
      }
    }
    $dbr->freeResult($res); 
    if($response->checkLastModified($rev_ts)){
      return $response;
    }

    // See if we have a cached version of the colored text, or if 
    // we need to generate new text.
    $memcKey = wfMemcKey( 'revisiontext', 'revid', $rev_id);
    $cached_text = $wgMemc->get($memcKey);
    if($cached_text){
      $response->addText($cached_text);
      return $response; 
    }

    // Since we are here, we need to get the colored HTML the hard way.
    $ctx = stream_context_create(
		 array('http' => array('timeout' => self::TRUST_TIMEOUT))
	   );
    
    // TODO: Should we do doing this via HTTPS?  Or POST?
    // TODO: in RemoteMode, shouldn't we use local database?
    $colored_raw = (file_get_contents($wgWikiTrustContentServerURL .
			"rev=" .  urlencode($rev_id) . 
			"&page=".urlencode($page_id).
			"&page_title=".  urlencode($page_title).
			"&time=".urlencode(wfTimestampNow()).
			"&user=0",
		 0, $ctx));
    
    if ($colored_raw && $colored_raw != self::NOT_FOUND_TEXT_TOKEN){
    
      // Inflate. Pick off the first 10 bytes for python-php conversion.
      $colored_raw = gzinflate(substr($colored_raw, 10));
      
      // Pick off the median value first.
      $colored_data = explode(",", $colored_raw, 2);
      $colored_text = $colored_data[1];
      if (preg_match("/^[+-]?(([0-9]+)|([0-9]*\.[0-9]+|[0-9]+\.[0-9]*)|
			    (([0-9]+|([0-9]*\.[0-9]+|[0-9]+\.[0-9]*))[eE][+-]?[0-9]+))$/", $colored_data[0])){
	self::$median = $colored_data[0];
	if ($colored_data[0] == 0){
	  self::$median = self::TRUST_DEFAULT_MEDIAN;
	}
      }

      // First, make sure that there are not any instances of our tokens in the colored_text
      $colored_text = str_replace(self::TRUST_OPEN_TOKEN, "", $colored_text);
      $colored_text = str_replace(self::TRUST_CLOSE_TOKEN, "", 
				  $colored_text);
      
      $colored_text = preg_replace("/&apos;/", "'", $colored_text, -1);      
      $colored_text = preg_replace("/&amp;/", "&", $colored_text, -1);
      
      $colored_text = preg_replace("/&lt;/", self::TRUST_OPEN_TOKEN, 
				   $colored_text, -1);
      $colored_text = preg_replace("/&gt;/", self::TRUST_CLOSE_TOKEN, 
				   $colored_text, -1);

      $title = Title::newFromText($page_title);
      $options = ParserOptions::newFromUser($wgUser);
      $parsed = $wgParser->parse($colored_text, $title, $options);
      $text = $parsed->getText();
      
      $count = 0;
      // Update the trust tags
      $text = preg_replace_callback("/\{\{#t:(\d+),(\d+),(.*?)\}\}/",
				    "WikiTrust::color_handleParserRe",
				    $text,
				    -1,
				    $count
				    );
      
      // Update open, close, images, and links.
      $text = preg_replace('/' . self::TRUST_OPEN_TOKEN . '/', "<"
			   , $text, -1, $count);
      // Regex broken for some pages.
      // Removing for now.
      /**
      $text = preg_replace('/<a href="(.*?)(File):(.*?)" (.*?)>/'
			   , self::TRUST_OPEN_TOKEN, $text, -1, $count);
      $text = preg_replace('/<a href="(.*?)(Image):(.*?)" (.*?)>/'
      , self::TRUST_OPEN_TOKEN, $text, -1, $count); */
      $text = preg_replace('/<a href="(.*?)title=(.*?)&amp;action=edit&amp;redlink=1" class="new" title="(.*?) \(not yet written\)">/'
			   , '<a href="/wiki/$2" title="$3">'
			   , $text, -1, $count);
      /* $text = preg_replace_callback(
				    '/'.self::TRUST_OPEN_TOKEN
				    .'(Image|File):(.*?)<\/a>/'
				    ,"WikiTrust::color_getImageInfo"
				    ,$text, -1, $count);
      */
      $text = preg_replace('/' . self::TRUST_CLOSE_TOKEN .'/', ">", $text
			   , -1, $count);
      $text = preg_replace('/<\/p>/', "</span></p>", $text, -1, $count);
      $text = preg_replace('/<p><\/span>/', "<p>", $text, -1, $count);
      $text = preg_replace('/<li><\/span>/', "<li>", $text, -1, $count);
      
      // Save the finished text in the cache.
      $wgMemc->set($memcKey, $text, self::TRUST_CACHE_VALID);

      // And finally return the colored HTML.
      $response->addText($text);

      // And mark that we have the colored version, for cache control.
      $dbw = wfGetDB( DB_MASTER );
      $dbw->begin();
      $dbw->insert( 'wikitrust_colored_markup',
		    array(
			  'revision_id' => $rev_id,
			  'revision_text' => "memcached",
			  'revision_createdon' => wfTimestampNow()),
		    'Database::insert',
		    array('IGNORE'));
      $dbw->commit();
      
    } else {
      // text not found.
      $response = new AjaxResponse(self::NOT_FOUND_TEXT_TOKEN);
    } 
    
    return $response;
  }

  /*
   Callback for Images.
  */
  static function color_getImageInfo($matches){

    /** Still not working
    $data = array('action'=>'parse',
		  'text'=>"[[File:".$matches[2]."]]",
		  'format' => 'json'
		  );
   
    global $wgWikiTrustApiURL;
    $image_info_raw = file_get_contents($wgWikiTrustApiURL
					.http_build_query($data));
    $image_json = json_decode($image_info_raw, true);
    $image_text = $image_json["parse"]["text"]["*"];
    $image_texts = explode("<p>", $image_text);
    $image_final = explode("</p>", $image_texts[1]);
    
    return $image_final[0];
    */
    return  '<a href="/wiki/File:'.$matches[2].'" class="image">File:'.$matches[2].'</a>';

  }

}    
