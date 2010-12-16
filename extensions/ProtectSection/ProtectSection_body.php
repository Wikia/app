<?php

class ProtectSectionClass {
	protected static $protectedpages = array();
	
	/**
	 * Strip the protect tags from the parsed text (not done within parser, because we need
	 *   to wait until after "edit" links have been added to text)
	 * Remove "edit" links within protected sections (although change is purely cosmetic;
	 *   URL-level access to section-editing is still possible -- that's caught by checkProtectSection)
	 * Called by ParserAfterTidy
	 *
	 * @param &$parser The parser object
	 * @param &$text The text being parsed
	 */
	public static function stripTags ( &$parser , &$text ) {
		global $wgUser;
		$titleid = $parser->getTitle()->getArticleID();
		// skip processing if this article has not been flagged as containing protect tags
		if (!isset(self::$protectedpages[$titleid]) || self::$protectedpages[$titleid]<1)
			return true;
		
		$protag = '&lt;protect&gt;';
		$tmp = explode($protag, $text);
		$sections = array();
		$sections[] = array_shift($tmp);
		$nblock = count($tmp)-1;
		foreach($tmp as $blocknum => $block){
			$subtmp = explode('&lt;/protect&gt;',$block);
			// only process if tag is paired
			if (count($subtmp)>1 || $blocknum < $nblock) {
				if ( $wgUser->isAllowed( 'protectsection' ) ) {
					// keep edit tags if user has protectsection right
					$sections[] = "<span class='protected'>".$subtmp[0]."</span>";
				} else{
					// remove edit tags if user does not have protectsection right
					$sections[] = "<span class='protected'>".preg_replace("/<(?:span|div) class=\"editsection(.*?)<\/(?:span|div)>/i", "", $subtmp[0])."</span>";
				}
				array_shift($subtmp);
			}
			else {
				array_unshift($subtmp, $protag);
			}
			$sections[] = implode('',$subtmp);
		}
		$text = implode("",$sections);
		return true;
	}
	
	/**
	 * Prevent protect tags from being altered: this is where edits are stopped
	 * Called by EditFilterMerged
	 *   (was previously called by EditFilter, but it's impossible to control sections within protect
	 *    tags from EditFilter)
	 *
	 * @param &$editpage The EditPage object
	 * @param &$textbox1 The content of the revised article
	 */
	public static function checkProtectSection ( $editpage, $textbox1 )  {
		global $wgUser;
		
		// Do this processing before checking user's permissions, so I can figure out whether any
		// version of the article contains protect tags
		$modifyProtect = false;
		$text1 = $editpage->mArticle->getContent(true); // previous revision of article
		$text2 = $textbox1;                             // current revision of article
		
		$titleid = $editpage->mTitle->getArticleID();
		self::$protectedpages[$titleid] = 0;
		
		// Skip the rest of the processing if neither version of the page contains any protect tags
		if (!preg_match('/<\/?protect>/', $text1.$text2))
			return true;
		
		// Clear out all nowiki sections to hide any nowiki'd protection tags
		// but don't want to make it possible for people to insert stuff hidden in nowiki tags, so replace chunks with md5
		$text1 = preg_replace_callback('/<nowiki>.*?<\/nowiki>/s', 'efProtectSectionHashednowiki', $text1);
		$text2 = preg_replace_callback('/<nowiki>.*?<\/nowiki>/s', 'efProtectSectionHashednowiki', $text2);
		// Same treatment for HTML comments
		$text1 = preg_replace_callback('/<!--.*?-->/s', 'efProtectSectionHashednowiki', $text1);
		$text2 = preg_replace_callback('/<!--.*?-->/s', 'efProtectSectionHashednowiki', $text2);
		preg_match_all( "/<protect>(.*?)<\/protect>/si", $text1, $list1, PREG_SET_ORDER );
		preg_match_all( "/<protect>(.*?)<\/protect>/si", $text2, $list2, PREG_SET_ORDER );

		if (count($list1)) {
			self::$protectedpages[$titleid] = 1;
		}
		
		// Do all checks for unallowed changes
		if ( !$wgUser->isAllowed( 'protectsection' ) ) {
			wfLoadExtensionMessages( 'ProtectSection' );
			if( count($list1) != count($list2)) { 
				// number of <protect>...</protect> sections don't match
				$msg = wfMsg( 'protectsection_add_remove'); 
				$modifyProtect = true; 
			}
			else for ( $i=0 ; $i < count( $list1 ); $i++ ) {
				if( $list1[$i][0] != $list2[$i][0]) { 
					// contents of a <protect>...</protect> section have changed
					$msg = wfMsg( 'protectsection_modify' );
					$modifyProtect = true; 
					break;
				}
			}
			
			global $egProtectSectionNoAddAbove;
		// check whether a protect tag at the start of the page has had text inserted in front of it
			if (!$modifyProtect &&
			    $egProtectSectionNoAddAbove &&
			    preg_match('/^<protect>/i', $text1) &&
			    !preg_match('/^<protect>/i', $text2)) {
				$modifyProtect = true;
				$msg = wfMsg( 'protectsection_add_above' );
			}
			
			if( $modifyProtect ) {
				global $wgOut;
				$wgOut->setPageTitle( wfMsg( 'protectsection_forbidden' ) );
				$wgOut->addWikiText($msg);
				return false;
			}
		}
		return true;
	}
	
	/**
	 * If page is simply being parsed, check to see whether page contains protect tags
	 *   (page hasn't been edited, so not doing any protecting, but still need to fix edit tags, etc)
	 * Check needs to be done before parsing so that nowiki tags have not yet been altered	
	 * Called by ParserBeforeStrip
	 *
	 * @param &$parser The parser object
	 * @param &$text The text being parsed
	 */
	public static function countTags(&$parser, &$text) {
		$titleid = $parser->getTitle()->getArticleID();
		// already set means checkProtectSection already run on this article
		if (isset(self::$protectedpages[$titleid]) && self::$protectedpages[$titleid]>=0)
			return true;
		
		self::$protectedpages[$titleid] = -1;
		
		// Skip the rest of the processing if page does not contain any protect tags
		if (!preg_match('/<\/?protect>/', $text))
			return true;
		
		// Clear out all nowiki/comment sections to hide any nowiki'd protection tags
		// (contents of hidden text don't matter in this context, but for consistency with
		//  checkProtectSection, replace the chunks with md5)
		$revtext = preg_replace_callback('/<nowiki>.*?<\/nowiki>/s', 'efProtectSectionHashednowiki', $text);
		$revtext = preg_replace_callback('/<!--.*?-->/s', 'efProtectSectionHashednowiki', $text);
		preg_match_all( "/<protect>(.*?)<\/protect>/si", $revtext, $list1, PREG_SET_ORDER );
		
		if (count($list1))
			self::$protectedpages[$titleid] = 1;

		return true;
	}
	
	/**
	 * Make sure separate versions of page are stored in memcache based on user's protectsection status
	 * Necessary so that stripTags processing is actually effective
	 * Called by PageRenderingHash
	 *
	 * @param &$confstr The to-be-hashed key string that is being constructed
	 */
	public static function pageRenderingHash( &$confstr ) {
		global $wgUser;
		$confstr .= '!' . ( $wgUser->isAllowed( 'protectsection' ) ? '1' : '');
		return true;
	}
}

/**
 * Callback function for preg_replace_callback
 * Replace string with md5 hash
 */
function efProtectSectionHashednowiki($s) {
	return md5($s[0]);
}

