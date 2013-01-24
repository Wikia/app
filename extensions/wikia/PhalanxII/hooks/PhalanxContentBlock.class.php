<?php

/**
 * ContentBlock
 *
 * This filter blocks an edit from being saved, if its content or the summary given
 * matches any of the blacklisted phrases.
 */

class PhalanxContentBlock extends WikiaObject {
	private static $whitelist = null;

	function __construct() {
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}

	public function editFilter( $editpage ) {
		$this->wf->profileIn( __METHOD__ );

		$phalanxModel = F::build('PhalanxContentModel', array( $this->wg->Title ) );

		/* allow blocked words to be added to whitelist */
		if ( $phalanxModel->isOk() ) {
			$this->wf->profileOut( __METHOD__ );
			return true;
		}
		
		/* summary */
		$summary = $editpage->summary;
		
		/* content */
		$textbox = $editpage->textbox1;
		
		/* compare summary with spam-whitelist */
		if ( !empty( $summary ) && !empty( $textbox ) && !empty(self::$whitelist) ) {
			self::$whitelist = $phalanxModel->buildWhiteList();
		}
		
		/* check summary */
		if ( !empty( self::$whitelist ) ) {
			$summary = preg_replace( self::$whitelist, '', $summary );
		}

		$result = PhalanxService::match( "summary", $summary );
		if ( $result !== false ) {
			if ( is_numeric( $result ) ) {
				/* user is blocked - we have block ID */
				$phalanxModel->setBlockId( $result );
				// set output with block info
				$phalanxModel->contentBlock( $summary );
				$ret = false;
			} else {
				if ( !empty( self::$whitelist ) ) {
					$textbox = preg_replace( self::$whitelist, '', $textbox );
				}
				$result = PhalanxService::match( "content", $textbox );
				if ( $result !== false ) {
					if ( is_numeric( $result ) ) {
						$editpage->spamPageWithContent( "Block #{$result}" );
						Wikia::log(__METHOD__, __LINE__, "Block '#{$result}' blocked '$textbox'.");
						$ret = false;
					} else {
						$ret = true;
					}
				}
			}
		} 
		
		/* if some problems with Phalanx service - use old version of extension */
		if ( $result === false ) {
			// TO DO
			/* problem with Phalanx service? */
			// include_once( dirname(__FILE__) . '/../prev_hooks/ContentBlock.class.php';
			// $ret = ContentBlock::onEditFilter( $editpage );		
		}
		
		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}

	/*
	 * onAbortMove
	 *
	 * Aborts a page move if the summary given matches
	 * any blacklisted phrase.
	 */
	public static function onAbortMove( $oldtitle, $newtitle, $user, &$error ) {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$reason = $wgRequest->getText( 'wpReason' );
		$blocksData = Phalanx::getFromFilter( Phalanx::TYPE_SUMMARY );
		if ( !empty($blocksData) && $reason != '' ) {
			$reason = self::applyWhitelist($reason);

			$blockData = null;
			$result = Phalanx::findBlocked($reason, $blocksData, true, $blockData);
			if ( $result['blocked'] ) {
				$error .= wfMsgExt( 'phalanx-title-move-summary', 'parseinline' );
				$error .= wfMsgExt( 'spamprotectionmatch', 'parseinline', "<nowiki>{$result['msg']}</nowiki>" );
				Wikia::log(__METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$reason'.");
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/*
	 * genericContentCheck
	 *
	 * @author Macbre
	 *
	 * Generic content checking to be used by extensions
	 */
	static public function genericContentCheck( $content ) {
		wfProfileIn( __METHOD__ );

		$blocksData = Phalanx::getFromFilter( Phalanx::TYPE_CONTENT );
		if ( !empty($blocksData) && $content != '' ) {
			$content = self::applyWhitelist($content);

			$blockData = null;
			$result = Phalanx::findBlocked($content, $blocksData, true, $blockData);
			if ( $result['blocked'] ) {
				Wikia::log(__METHOD__, __LINE__, "Block '{$result['msg']}' blocked '$content'.");
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/*
	 * applyWhitelist
	 *
	 * @author Marooned <marooned at wikia-inc.com>
	 *
	 * @param $
	 * @return
	 */
	private static function applyWhitelist($text) {
		wfProfileIn( __METHOD__ );

		//TODO: add short memcache here?
		if (is_null(self::$whitelist)) {
			$whitelist = wfMsgForContent('Spam-whitelist');
			if (wfEmptyMsg('Spam-whitelist', $whitelist)) {
				wfProfileOut( __METHOD__ );
				return $text;
			}
			$whitelist = array_filter(array_map('trim', preg_replace('/#.*$/', '', explode("\n", $whitelist))));

			foreach ($whitelist as $regex) {
				$regex = str_replace('/', '\/', preg_replace('|\\\*/|', '/', $regex));
				$regex = "/https?:\/\/+[a-z0-9_.-]*$regex/i";
				wfSuppressWarnings();
				$regexValid = preg_match($regex, '');
				wfRestoreWarnings();
				if ($regexValid === false) {
					continue;
				}
				//escape slashes uses as regex delimiter
				self::$whitelist[] = $regex;
			}

			Wikia::log(__METHOD__, __LINE__, count(self::$whitelist) . ' whitelist entries loaded.');
		}

		if (!empty(self::$whitelist)) {
			$text = preg_replace(self::$whitelist, '', $text);
		}

		wfProfileOut( __METHOD__ );
		return $text;
	}
}
