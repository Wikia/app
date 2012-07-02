<?php

class ReaderFeedbackHooks {
	/**
	* Add ReaderFeedback css/js.
	*/
	public static function injectStyleAndJS( $out ) {
		if( $out->hasHeadItem( 'ReaderFeedback' ) )
			return true; # Don't double-load
		if( !$out->getTitle() || !$out->isArticleRelated() ) {
			return self::InjectStyleForSpecial( $out ); // try special page CSS?
		}
		# Try to only add to relevant pages
		if( !ReaderFeedback::isPageRateable( $out->getTitle() ) ) {
			return true;
		}
		global $wgScriptPath, $wgJsMimeType, $wgFeedbackStylePath, $wgFeedbackStyleVersion;
		
		$stylePath = str_replace( '$wgScriptPath', $wgScriptPath, $wgFeedbackStylePath );

		$cssFile = "$stylePath/readerfeedback.css?$wgFeedbackStyleVersion";
		$jsFile = "$stylePath/readerfeedback.js?$wgFeedbackStyleVersion";
		// Add CSS
		$out->addExtensionStyle( $cssFile );
		// Add JS
		$out->addScriptFile( $jsFile );

		return true;
	}
	
	public static function injectJSVars( &$globalVars ) {
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
	public static function InjectStyleForSpecial( $out ) {
		if ( !is_object( $out->getTitle() ) || $out->getTitle()->getNamespace() !== NS_SPECIAL ) {
			return true;
		}
		$spPages = array( 'RatingHistory' );
		foreach( $spPages as $key ) {
			if( $out->getTitle()->isSpecial( $key ) ) {
				global $wgScriptPath, $wgFeedbackStylePath, $wgFeedbacktyleVersion;
				$stylePath = str_replace( '$wgScriptPath', $wgScriptPath, $wgFeedbackStylePath );
				$encCssFile = htmlspecialchars( "$stylePath/readerfeedback.css?$wgFeedbacktyleVersion" );
				$out->addExtensionStyle( $encCssFile );
				break;
			}
		}
		return true;
	}
	
	/**
	 * Is this a view page action?
	 * @param $action string
	 * @return bool
	 */
	protected static function isViewAction( $action ) {
		return ( $action == 'view' || $action == 'purge' || $action == 'render' );
	}

	public static function addFeedbackForm( &$data, $skin ) {
		global $wgOut;
		$title = $skin->getTitle();
		if( $wgOut->isArticleRelated() ) {
			global $wgRequest, $wgUser;
			if( !$title->exists() || !ReaderFeedback::isPageRateable($title) || !$wgOut->getRevisionId() ) {
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
				if( $id != $title->getLatestRevID() ) {
					return true;
				}
				# If the user already voted, then don't show the form.
				# Always show for IPs however, due to squid caching...
				if( !$wgUser->getId() || !ReaderFeedbackPage::userAlreadyVoted( $title, $id ) ) {
					self::addQuickFeedback( $data, false, $title );
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
		global $wgOut, $wgUser, $wgFeedbackTags;
		# Are there any reader input tags?
		if( empty($wgFeedbackTags) ) {
			return false;
		}
		# Revision being displayed
		$id = $wgOut->getRevisionId();
		# Load required messages
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
			$selected = ( isset($flags[$quality]) && $flags[$quality] > 0 ) ? $flags[$quality] : -1;
			$form .= "<b>" . Xml::label( wfMsgHtml("readerfeedback-$quality"), "wp$quality" ) . ":</b>";
			$attribs = array( 'name' => "wp$quality", 'id' => "wp$quality",
				'onchange' => "updateFeedbackForm()" );
			$form .= '&#160;' . Xml::openElement( 'select', $attribs );
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
		$form .= Html::hidden( 'title', $reviewTitle->getPrefixedText() ) . "\n";
		$form .= Html::hidden( 'target', $title->getPrefixedDBKey() ) . "\n";
		$form .= Html::hidden( 'oldid', $id ) . "\n";
		$form .= Html::hidden( 'validatedParams', ReaderFeedbackPage::validationKey( $id, $wgUser->getId() ) );
		$form .= Html::hidden( 'action', 'submit') . "\n";
		$form .= Html::hidden( 'wpEditToken', $wgUser->editToken() ) . "\n";
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
		# Add rating tab
		if( $skintemplate->getTitle() && ReaderFeedback::isPageRateable( $skintemplate->getTitle() ) ) {
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
