<?php

class ReaderFeedbackHooks {
	/**
	* Add ReaderFeedback css/js.
	*/
	public static function injectStyleAndJS() {
		global $wgOut, $wgTitle;
		if( $wgOut->hasHeadItem( 'ReaderFeedback' ) )
			return true; # Don't double-load
		if( !isset($wgTitle) || !$wgOut->isArticleRelated() ) {
			return self::InjectStyleForSpecial(); // try special page CSS?
		}
		# Try to only add to relevant pages
		if( !ReaderFeedback::isPageRateable($wgTitle) ) {
			return true;
		}
		global $wgScriptPath, $wgJsMimeType, $wgFeedbackStylePath, $wgFeedbackStyleVersion;
		# Load required messages
		wfLoadExtensionMessages( 'ReaderFeedback' );
		
		$stylePath = str_replace( '$wgScriptPath', $wgScriptPath, $wgFeedbackStylePath );

		$encCssFile = htmlspecialchars( "$stylePath/readerfeedback.css?$wgFeedbackStyleVersion" );
		$encJsFile = htmlspecialchars( "$stylePath/readerfeedback.js?$wgFeedbackStyleVersion" );
		// Add CSS
		$wgOut->addExtensionStyle( $encCssFile );
		// Add JS
		$head = "<script type=\"$wgJsMimeType\" src=\"$encJsFile\"></script>\n";
		$wgOut->addHeadItem( 'ReaderFeedback', $head );

		return true;
	}
	
	public static function injectJSVars( &$globalVars ) {
		global $wgUser;
		$globalVars['wgFeedbackParams'] = ReaderFeedback::getJSFeedbackParams();
		$globalVars['wgAjaxFeedback'] = (object) array( 
			'sendingMsg' => wfMsgHtml('readerfeedback-submitting'), 
			'sentMsg' => wfMsgHtml('readerfeedback-finished') 
		);
		return true;
	}
	
	/**
	* Add ReaderFeedback css for relevant special pages.
	*/
	public static function InjectStyleForSpecial() {
		global $wgTitle, $wgOut, $wgUser;
		if( empty($wgTitle) || $wgTitle->getNamespace() !== NS_SPECIAL ) {
			return true;
		}
		$spPages = array( 'RatingHistory' );
		foreach( $spPages as $n => $key ) {
			if( $wgTitle->isSpecial( $key ) ) {
				global $wgScriptPath, $wgFeedbackStylePath, $wgFeedbacktyleVersion;
				$stylePath = str_replace( '$wgScriptPath', $wgScriptPath, $wgFeedbackStylePath );
				$encCssFile = htmlspecialchars( "$stylePath/readerfeedback.css?$wgFeedbacktyleVersion" );
				$wgOut->addExtensionStyle( $encCssFile );
				break;
			}
		}
		return true;
	}
	
	/**
	 * Is this a view page action?
	 * @param $action string
	 * @returns bool
	 */
	protected static function isViewAction( $action ) {
		return ( $action == 'view' || $action == 'purge' || $action == 'render' );
	}

	public static function addFeedbackForm( &$data ) {
		global $wgOut, $wgArticle, $wgTitle;
		if( $wgOut->isArticleRelated() && isset($wgArticle) ) {
			global $wgRequest, $wgUser, $wgOut;
			if( !$wgTitle->exists() || !ReaderFeedback::isPageRateable($wgTitle) || !$wgOut->getRevisionId() ) {
				return true;
			}
			# Check action and if page is protected
			$action = $wgRequest->getVal( 'action', 'view' );
			if( !self::isViewAction($action) ) {
				return true;
			}
			if( $wgUser->isAllowed( 'feedback' ) ) {
				# Only allow votes on the latest revision!
				$id = $wgOut->getRevisionId();
				if( $id != $wgArticle->getLatest() ) {
					return true;
				}
				# If the user already voted, then don't show the form.
				# Always show for IPs however, due to squid caching...
				if( !$wgUser->getId() || !ReaderFeedbackPage::userAlreadyVoted( $wgTitle, $id ) ) {
					self::addQuickFeedback( $data, false, $wgTitle );
				}
			}
			return true;
		}
		return true;
	}
	
	 /**
	 * Adds a brief feedback form to a page.
	 * @param OutputPage $out
	 * @param bool $top, should this form always go on top?
	  * @param Title $title
	 */
	protected static function addQuickFeedback( &$data, $top = false, $title ) {
		global $wgOut, $wgUser, $wgRequest, $wgFeedbackTags;
		# Are there any reader input tags?
		if( empty($wgFeedbackTags) ) {
			return false;
		}
		# Revision being displayed
		$id = $wgOut->getRevisionId();
		# Load required messages
		wfLoadExtensionMessages( 'ReaderFeedback' );
		$reviewTitle = SpecialPage::getTitleFor( 'ReaderFeedback' );
		$action = $reviewTitle->getLocalUrl( 'action=submit' );
		$form = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $action,
			'id' => 'mw-feedbackform' ) );
		$form .= Xml::openElement( 'fieldset', array('class' => 'feedback_reviewform noprint') );
		$form .= "<legend><strong>" . wfMsgHtml( 'readerfeedback' ) . "</strong></legend>\n";
		# Avoid clutter
		if( !$wgUser->isAllowed('review') ) {
			$form .= wfMsgExt( 'readerfeedback-text', array('parse') );
		}
		$form .= Xml::openElement( 'span', array('id' => 'mw-feedbackselects') );
		# Loop through all different flag types
		foreach( ReaderFeedback::getFeedbackTags() as $quality => $levels ) {
			$label = array();
			$selected = ( isset($flags[$quality]) && $flags[$quality] > 0 ) ? $flags[$quality] : -1;
			$form .= "<b>" . Xml::label( wfMsgHtml("readerfeedback-$quality"), "wp$quality" ) . ":</b>";
			$attribs = array( 'name' => "wp$quality", 'id' => "wp$quality",
				'onchange' => "updateFeedbackForm()" );
			$form .= '&nbsp;' . Xml::openElement( 'select', $attribs );
			$levels = array_reverse($levels,true);
			foreach( $levels as $i => $name ) {
				$optionClass = array( 'class' => "rfb-rating-option-$i" );
				$form .= Xml::option( wfMsg("readerfeedback-level-$i"), $i, ($i == $selected), $optionClass ) ."\n";
			}
			$form .= Xml::option( wfMsg("readerfeedback-level-none"), -1, (-1 == $selected) ) ."\n";
			$form .= Xml::closeElement( 'select' )."\n";
		}
		$form .= Xml::closeElement( 'span' );
		$form .= Xml::submitButton( wfMsg('readerfeedback-submit'),
			array('id' => 'submitfeedback','accesskey' => wfMsg('readerfeedback-ak-review'),
			'title' => wfMsg('readerfeedback-tt-review').' ['.wfMsg('readerfeedback-ak-review').']' )
		);
		# Hidden params
		$form .= Xml::hidden( 'title', $reviewTitle->getPrefixedText() ) . "\n";
		$form .= Xml::hidden( 'target', $title->getPrefixedDBKey() ) . "\n";
		$form .= Xml::hidden( 'oldid', $id ) . "\n";
		$form .= Xml::hidden( 'validatedParams', ReaderFeedbackPage::validationKey( $id, $wgUser->getId() ) );
		$form .= Xml::hidden( 'action', 'submit') . "\n";
		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() ) . "\n";
		# Honeypot input
		$form .= Xml::input( 'commentary', 12, '', array('style' => 'display:none;') ) . "\n";
		$form .= Xml::closeElement( 'fieldset' );
		$form .= Xml::closeElement( 'form' );
		if( $top ) {
			$wgOut->prependHTML( $form );
		} else {
			$data .= $form;
		}
		return true;
	}
	
	public static function addRatingLink( &$skintemplate, &$nav_urls, &$oldid, &$revid ) {
		global $wgTitle;
		# Add rating tab
		if( isset($wgTitle) && ReaderFeedback::isPageRateable($wgTitle) ) {
			wfLoadExtensionMessages( 'RatingHistory' );
			$nav_urls['ratinghist'] = array( 
				'text' => wfMsg( 'ratinghistory-link' ),
				'href' => $skintemplate->makeSpecialUrl( 'RatingHistory', 
					"target=" . wfUrlencode( "{$skintemplate->thispage}" ) )
			);
		}
		return true;
	}
	
	public static function ratingToolboxLink( &$skin ) {
		if( isset( $skin->data['nav_urls']['ratinghist'] ) ) {
			?><li id="t-rating"><?php
				?><a href="<?php echo htmlspecialchars( $skin->data['nav_urls']['ratinghist']['href'] ) ?>"><?php
					echo $skin->msg( 'ratinghistory-link' );
				?></a><?php
			?></li><?php
		}
		return true;
	}

	public static function onParserTestTables( &$tables ) {
		$tables[] = 'reader_feedback';
		$tables[] = 'reader_feedback_history';
		$tables[] = 'reader_feedback_pages';
		return true;
	}
}
