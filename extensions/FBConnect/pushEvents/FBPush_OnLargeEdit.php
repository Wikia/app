<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed in the event of a large edit.
 */


class FBPush_OnLargeEdit extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnLargeEdit'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	static private $MIN_CHARS_TO_PUSH = 300; // number of chars that need to be changed
	static $messageName = 'fbconnect-msg-OnLargeEdit';
	static $eventImage = 'edits.png';
	
	static public function getMinCharsToPush(){
		return self::$MIN_CHARS_TO_PUSH;
	}
	
	public function init(){
		global $wgHooks;
		wfProfileIn(__METHOD__);
		
		$wgHooks['ArticleSaveComplete'][] = 'FBPush_OnLargeEdit::articleCountWordDiff';

		wfProfileOut(__METHOD__);
	}
	
	
	/*
	 * Author: Tomek Odrobny
	 * hook 
	 */
	public static function articleCountWordDiff(&$article,&$user,$newText, $summary,$flag, $fake1, $fake2, &$flags, $revision, &$status, $baseRevId){
		global $wgContentNamespaces, $wgSitename;
		wfProfileIn(__METHOD__);

		if ( !self::checkUserOptions(__CLASS__) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		if ( is_null( $revision ) ) {
			// nothing's changed, quit early
			wfProfileOut( __METHOD__ );
			return true;
		}
	
		if( !in_array($article->getTitle()->getNamespace(), $wgContentNamespaces) ) {
			wfProfileOut( __METHOD__ );
			return true;	
		}

		// do not push reverts
		$baseRevision = Revision::newFromId( $baseRevId );
		if ( $baseRevision && $revision->getTextId() == $baseRevision->getTextId() ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		
		$diff = 0;
		$wNewCount = strlen( $newText );
		$wOldCount = strlen( $article->getRawText() );
		$countDiff = $wNewCount - $wOldCount;

		if ($countDiff > self::$MIN_CHARS_TO_PUSH){
			$params = array(
				'$ARTICLENAME' => $article->getTitle()->getText(),
				'$WIKINAME' => $wgSitename,
				'$ARTICLE_URL' => $article->getTitle()->getFullURL("ref=fbfeed&fbtype=largeedit"),
				'$EVENTIMG' => self::$eventImage,
				'$SUMMART' => $summary,
				'$TEXT' => self::shortenText(self::parseArticle($article, $newText))			
			);
			self::pushEvent(self::$messageName, $params, __CLASS__ );
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}
