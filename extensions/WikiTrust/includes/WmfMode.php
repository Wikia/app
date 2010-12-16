<?php

class WikiTrust extends WikiTrustBase {
  /**
   Does a POST HTTP request
  */
  static function file_post_contents($url,$headers=false) {
    $url = parse_url($url);

    if (!isset($url['port'])) {
      if ($url['scheme'] == 'http') { $url['port']=80; }
      elseif ($url['scheme'] == 'https') { $url['port']=443; }
    }
    $url['query']=isset($url['query'])?$url['query']:'';
		
    $url['protocol']=$url['scheme'].'://';
    $eol="\r\n";
		
    $headers =  "POST ".
		$url['protocol'].$url['host'].$url['path']." HTTP/1.0".$eol.
		"Host: ".$url['host'].$eol.
		"Referer: ".$url['protocol'].$url['host'].$url['path'].$eol.
		"Content-Type: application/x-www-form-urlencoded".$eol.
		"Content-Length: ".strlen($url['query']).$eol.
		$eol.
		$url['query'];
    $fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30);
    if($fp) {
      fputs($fp, $headers);
      $result = '';
      while(!feof($fp)) { $result .= fgets($fp, 128); }
      fclose($fp);
      if (!$headers) {
        //removes headers
	// NOTE: these backslashes work, b/c they are actual chars!
        $pattern="/^.*\r\n\r\n/s";
        $result=preg_replace($pattern,'',$result);
      }
      return $result;
    }
  }
  
  static function vote_recordVote(&$response, $userName, $page_id, $rev_id, $page_title)
  {
    global $wgWikiTrustContentServerURL;
    $ctx = stream_context_create(
	      array('http' => array('timeout' => self::TRUST_TIMEOUT))
	    );

    wfWikiTrustDebug(__FILE__.__LINE__.": ".$wgWikiTrustContentServerURL 
                . "?method=vote"
		. "&revid=".urlencode($rev_id)
		. "&pageid=".urlencode($page_id)
		. "&username=".urlencode($userName)
		. "&title=".urlencode($page_title)
    . "&time=".urlencode(wfTimestampNow()));

    // TODO: we need a shared key!
    $vote_str = @file_get_contents($wgWikiTrustContentServerURL 
                . "?method=vote"
		. "&revid=".urlencode($rev_id)
		. "&pageid=".urlencode($page_id)
		. "&username=".urlencode($userName)
		. "&title=".urlencode($page_title)
		. "&time=".urlencode(wfTimestampNow()), 0
	    , $ctx);
    $response = new AjaxResponse($vote_str);	   
    return $response;
  }

  static function color_parseWiki($colored_text, $rev_id, &$options)
  {
    global $wgWikiTrustApiURL, $wgTitle;

    $url = $wgWikiTrustApiURL 
			."?action=parse"
			."&title=".urlencode($wgTitle)
			."&format=json"
			."&text=".urlencode($colored_text);
    $raw_text = self::file_post_contents($url);
    $body = json_decode(array_pop(explode("\n", $raw_text)), true);
    $text = $body["parse"]["text"]["*"];
 
    return $text;
  }
 
  // Share the finished HTML back.
  static function color_shareHTML($html, $rev_id)
  {
    global $wgWikiTrustContentServerURL;

    # Cache the rendered html
    $url = $wgWikiTrustContentServerURL
                         ."?method=sharehtml"
                         ."&revid=".urlencode($rev_id)
                         ."&myhtml=".urlencode($html);
    wfWikiTrustDebug(__FILE__.": ".__LINE__.": "."Sharing $rev_id");
    self::file_post_contents($url);
  }
  
  static function color_getColorData($page_title, $page_id = 0, $rev_id = 0)
  {
    $ctx = stream_context_create(
        array('http' => array(
          'timeout' => self::TRUST_TIMEOUT,
           ))
    );

    $MAX_TIMES_THROUGH = 2;
    $times_though=0;
    global $wgUser, $wgWikiTrustContentServerURL;
    $username = $wgUser->getName();

    $url = $wgWikiTrustContentServerURL
      . "?method=wikiorhtml"
      . "&revid=" . urlencode($rev_id)
      . "&pageid=" . urlencode($page_id)
      . "&title=" . urlencode($page_title)
      . "&time=" . urlencode(wfTimestampNow())
      . "&username=" . urlencode($username);

    wfWikiTrustDebug(__FILE__.":".__LINE__.": $url");

    $colored_raw = (file_get_contents($url, 0, $ctx));

    if (!$colored_raw)
      return '';

    $mode = substr($colored_raw, 0, 1);
    $colored_text = substr($colored_raw, 1);
   
    if (!$colored_text
        || $colored_raw == self::NOT_FOUND_TEXT_TOKEN
        || $colored_raw == "bad")
      {
        return '';
      }
   
    // Are we using HTML or WIKI
    if ($mode == WIKITRUST_HTML){
      // The HTML is all rendered -- we just display this.
      self::$html_rendered = true;
      return $colored_text;
    }
    // Pick off the median value first.
    $colored_data = explode(",", $colored_text, 2);
    $colored_new = $colored_data[1];
    self::$median = $colored_data[0] + 0;
    if (self::$median == 0)
        self::$median = self::TRUST_DEFAULT_MEDIAN;

    return $colored_new;
  }

  public static function ucscArticleSaveComplete(&$article, 
				 &$user, &$text, &$summary,
				 &$minoredit, &$watchthis, 
				 &$sectionanchor, &$flags, 
				 &$revision)
  {
    $userName = $user->getName();
    $page_id = $article->getTitle()->getArticleID();
    $rev_id = $revision->getID();
    $page_title = $article->getTitle()->getDBkey();

    wfWikiTrustDebug(__FILE__.": ".__LINE__.": New article id $rev_id");
		
    global $wgWikiTrustContentServerURL;

    wfWikiTrustDebug(__FILE__.": ".__LINE__.": ".
       $wgWikiTrustContentServerURL 
                         ."?method=edit"
			 ."&revid=".urlencode($rev_id)
			 ."&pageid=".urlencode($page_id)
			 ."&username=".urlencode($userName)
			 ."&text=".urlencode($text)
			 ."&title=".urlencode($page_title)
			 ."&time=".urlencode(wfTimestampNow()));

      $colored_text = self::file_post_contents($wgWikiTrustContentServerURL 
                         ."?method=edit"
			 ."&revid=".urlencode($rev_id)
			 ."&pageid=".urlencode($page_id)
			 ."&username=".urlencode($userName)
			 ."&text=".urlencode($text)
			 ."&title=".urlencode($page_title)
			 ."&time=".urlencode(wfTimestampNow()));
		
    return true;
  }
}

?>
