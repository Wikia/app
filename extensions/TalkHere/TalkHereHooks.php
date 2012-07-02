<?php
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "not a valid entry point.\n" );
	die( 1 );
}

/**
 * Proxy object wrapping an article, intercepting rendering functions
 * to inject the talk page's content.
 */
class TalkHereHooks {

	public static function onArticleViewFooter( $article ) {
		global $wgOut, $wgRequest, $wgUser, $wgJsMimeType, $wgUseAjax, $wgTalkHereNamespaces;

		$action = $wgRequest->getVal( 'action', 'view' );

		if ( $action != 'view' && $action != 'purge' ) {
			return true;
		}

		if ( $wgRequest->getVal( 'oldid' ) || $wgRequest->getVal( 'diff' ) ) {
			return true;
		}

		$title = $article->getTitle();
		$ns = $title->getNamespace();

		if ( MWNamespace::isTalk($ns) || !MWNamespace::canTalk($ns) || !$title->exists()
			|| ( $wgTalkHereNamespaces && !in_array( $ns, $wgTalkHereNamespaces ) ) ) {
			return true;
		}
		
		$talk = $title->getTalkPage();

		if ( !$talk || !$talk->userCanRead() ) {
			return true;
		}

		$hastalk = $talk->exists();
		$cantalk = $talk->userCan('edit');

		if ( !$hastalk && !$cantalk ) {
			return true;
		}

		$skin = $wgUser->getSkin();

		$talkArticle = Article::newFromTitle( $talk, RequestContext::getMain() );

		$wgOut->addHTML('<div class="talkhere" id="talkhere">');

		if ($hastalk) {
			//Bah, would have to call a skin-snippet here :(
			$wgOut->addHTML('<div class="talkhere-head">');

			$wgOut->addHTML('<h1>');
			if ($talk->userCan('edit')) {
				$wgOut->addHTML('<span class="editsection">');
				$wgOut->addHTML( '[' . $skin->makeKnownLinkObj( $talk, wfMsg('talkhere-talkpage' ) ) . ']' );
				$wgOut->addHTML('</span>');
			}
			$wgOut->addWikiText( wfMsg('talkhere-title', $talk->getPrefixedText() ), false );
			$wgOut->addHTML('</h1>');

			$headtext = wfMsg('talkhere-headtext', $title->getPrefixedText(), $talk->getPrefixedText() );
			if ( $headtext ) {
				$wgOut->addWikiText( $headtext );
				$wgOut->addHTML('<hr/>');
			}

			$wgOut->addHTML('</div>'); //talkhere-head

			$wgOut->addHTML('<div class="talkhere-comments">');
			$talkArticle->view();
			$wgOut->addHTML('</div>'); // talkhere-comments
		}

		$wgOut->addHTML('<div class="talkhere-foot">');

		if ( $cantalk ) {
			if ($hastalk) {
				$wgOut->addHTML('<hr/>');
			}
			else {
				$wgOut->addHTML('<div class="talkhere-comments talkhere-notalk">');
				$wgOut->addWikiText(  wfMsg('talkhere-notalk') );
				$wgOut->addHTML('</div>'); // talkhere-comments
			}

			if ( $wgUseAjax ) $wgOut->addScript(
			"	<script type=\"{$wgJsMimeType}\">
				var talkHereLoadingMsg = \"" . Xml::escapeJsString(wfMsg('talkhere-loading')) . "\";
				var talkHereCollapseMsg = \"" . Xml::escapeJsString(wfMsg('talkhere-collapse')) . "\";
				var talkHereExpandMsg = \"" . Xml::escapeJsString(wfMsg('talkhere-addcomment')) . "\";
				</script>\n"
			);

			$returnto = $title->getPrefixedDBKey();
			$talktitle = $talk->getPrefixedDBKey();
			$q = 'action=edit&section=new&wpTalkHere=1&wpReturnTo=' . urlencode($returnto);

			$js = $wgUseAjax ? 'this.href="javascript:void(0);"; talkHereLoadEditor("talkhere_talklink", "talkhere_talkform", "'.Xml::escapeJsString($talktitle).'", "new", "'.Xml::escapeJsString($returnto).'"); ' : '';
			$a = 'onclick="'.htmlspecialchars($js).'" id="talkhere_talklink"';

			$wgOut->addHTML('<div class="talkhere-talklink">');
			$wgOut->addHTML( $skin->makeKnownLinkObj( $talk, wfMsg('talkhere-addcomment' ), $q, '', '', $a ) );
			$wgOut->addHTML('</div>');

			$wgOut->addHTML('<div id="talkhere_talkform" style="display:none;">&#160;</div>');
			//self::showCommentForm( $title, $talk, 'new' );
		}

		if ($hastalk) {
			$foottext = wfMsg('talkhere-foottext', $title->getPrefixedText(), $talk->getPrefixedText() );
			if ( $foottext ) {
				$wgOut->addHTML('<hr/>');
				$wgOut->addWikiText( $foottext );
			}
		}

		$wgOut->addHTML('</div>'); // talkhere-foot
		$wgOut->addHTML('</div>'); // talkhere

		return true;
	}

	/*
	static function showCommentForm( $title, $talk, $section = 'new' ) {
		global $wgOut, $wgUser;
		$tabindex = 1;

		$skin = $wgUser->getSkin();

		$q = 'action=submit';
		$action = $talk->escapeLocalURL( $q );
		$wgOut->addHTML('<form action="'.$action.'" method="post" id="editform"  name="editform" enctype="multipart/form-data">');

		$wgOut->addHTML("<div>");
		$wgOut->addWikiText( wfMsg('talkhere-beforeinput') );
		$wgOut->addHTML("</div>");

		$wgOut->addHTML('<input type="hidden" value="'.htmlspecialchars($section).'" name="wpSection" />');
		$wgOut->addHTML('<input type="hidden" value="20070401210837" name="wpStarttime" />');
		$wgOut->addHTML('<input type="hidden" value="" name="wpEdittime" />');
		$wgOut->addHTML('<input type="hidden" value="" name="wpScrolltop" id="wpScrolltop" />');

		$returnto = urlencode( $title->getPrefixedDBKey() );
		$wgOut->addHTML('<input type="hidden" value="'.htmlspecialchars($returnto).'" name="wpReturnTo" id="wpReturnTo" />');
		$wgOut->addHTML('<input type="hidden" value="1" name="wpTalkHere" id="wpTalkHere" />');

		$wgOut->addHTML("<span id='wpSummaryLabel'><label for='wpSummary'>".wfMsg('subject')."</label>:&#160;</span>");
		$wgOut->addHTML("<div class='editOptions'>");
		$wgOut->addHTML("<input tabindex='1' type='text' value='' name='wpSummary' id='wpSummary' maxlength='200' size='40' /><br />");

		$wgOut->addHTML('<textarea tabindex="1" accesskey="," name="wpTextbox1" id="wpTextbox1" rows="10" cols="100" style="width:98%" >');
		$wgOut->addHTML("</textarea>");

		global $wgRightsText;
		$copywarn = "<div id=\"editpage-copywarn\">\n" .
			wfMsg( $wgRightsText ? 'copyrightwarning' : 'copyrightwarning2',
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]',
				$wgRightsText ) . "\n</div>";

		if( $wgUser->getOption('showtoolbar') ) {
			# prepare toolbar for edit buttons
			$toolbar = EditPage::getEditToolbar();
		} else {
			$toolbar = '';
		}

		$wgOut->addHTML( $toolbar );
		$wgOut->addWikiText( $copywarn );


		$wgOut->addHTML("<div>");
		$wgOut->addWikiText( wfMsg('talkhere-afterinput') );
		$wgOut->addHTML("</div>");

		$watchOption = '';
		if ( $wgUser->isLoggedIn() ) {
			$watchthis = false;

			if( $wgUser->getOption( 'watchdefault' ) ) {
				# Watch all edits
				$watchthis = true;
			} elseif( $wgUser->getOption( 'watchcreations' ) && !$talk->exists() ) {
				# Watch creations
				$watchthis = true;
			} elseif( $talk->userIsWatching() ) {
				# Already watched
				$watchthis = true;
			}

			$watchLabel = wfMsgExt('watchthis', array('parseinline'));
			$attribs = array(
				'tabindex'  => ++$tabindex,
				'accesskey' => wfMsg( 'accesskey-watch' ),
				'id'        => 'wpWatchthis',
			);
			$watchOption =
				Xml::check( 'wpWatchthis', $watchthis, $attribs ) .
				"&#160;<label for='wpWatchthis'".$skin->tooltipAndAccesskey('watch').">{$watchLabel}</label>";
		}

		$wgOut->addHTML('<input name="wpMinoredit" type="hidden" value="0" />');
		$wgOut->addHTML($watchOption);
		$wgOut->addHTML('<div class="editButtons">');

		$temp = array(
			'id'        => 'wpSave',
			'name'      => 'wpSave',
			'type'      => 'submit',
			'tabindex'  => ++$tabindex,
			'value'     => wfMsg('savearticle'),
			'accesskey' => wfMsg('accesskey-save'),
			'title'     => wfMsg( 'tooltip-save' ).' ['.wfMsg( 'accesskey-save' ).']',
		);
		$wgOut->addHTML( Xml::element('input', $temp, '') );

		$temp = array(
			'id'        => 'wpPreview',
			'name'      => 'wpPreview',
			'type'      => 'submit',
			'tabindex'  => ++$tabindex,
			'value'     => wfMsg('showpreview'),
			'accesskey' => wfMsg('accesskey-preview'),
			'title'     => wfMsg( 'tooltip-preview' ).' ['.wfMsg( 'accesskey-preview' ).']',
		);
		$wgOut->addHTML(  Xml::element('input', $temp, '') );

		$edithelpurl = Skin::makeInternalOrExternalUrl( wfMsgForContent( 'edithelppage' ));
		$edithelp = '<a target="helpwindow" href="'.$edithelpurl.'">'.
			htmlspecialchars( wfMsg( 'edithelp' ) ).'</a> '.
			htmlspecialchars( wfMsg( 'newwindow' ) );

		$wgOut->addHTML("<span class='editHelp'>{$edithelp}</span>");

		$wgOut->addHTML('</div><!-- editButtons -->');
		$wgOut->addHTML('</div><!-- editOptions -->');

		if ( $wgUser->isLoggedIn() )
			$token = htmlspecialchars( $wgUser->editToken() );
		else
			$token = EDIT_TOKEN_SUFFIX;

		$wgOut->addHTML( "\n<input type='hidden' value=\"$token\" name=\"wpEditToken\" />\n" );

		$wgOut->addHTML('<input name="wpAutoSummary" type="hidden" value="" />');
		$wgOut->addHTML('</form>');
		$wgOut->addHTML("<div>");
		$wgOut->addWikiText( wfMsg('talkhere-afterform') );
		$wgOut->addHTML("</div>");
	}*/

	public static function onBeforePageDisplay( $out, $skin ) {
		global $wgScriptPath, $wgJsMimeType, $wgUseAjax;

		$out->addExtensionStyle( $wgScriptPath . '/extensions/TalkHere/TalkHere.css' );

		if ( $wgUseAjax ) {
			$out->addScriptFile( $wgScriptPath . '/extensions/TalkHere/TalkHere.js' );
		}

		return true;
	}

	public static function onCustomEditor( $article, $user ) {
		global $wgRequest, $wgOut;

		$action = $wgRequest->getVal( 'action' );
		$oldid = $wgRequest->getVal( 'oldid' );
		$returnto = $wgRequest->getVal( 'wpReturnTo' );
		$talkhere = $wgRequest->getVal( 'wpTalkHere' );
		if (!$talkhere || $action != 'submit' || !$returnto || $oldid) return true; //go on as normal

		$to = Title::newFromText($returnto);
		if (!$to) return true; //go on as normal

		//use a wrapper to override redirection target
		$editor = new TalkHereEditPage( $article );
		$editor->setReturnTo( $to );
		$editor->edit();
		$code = $editor->getCode();

		if ( $code == EditPage::AS_SUCCESS_NEW_ARTICLE ) {
			$wgOut->redirect( $to->getFullURL() . '#talkhere' );
		} elseif ( $code == EditPage::AS_SUCCESS_UPDATE ) {
			$wgOut->redirect( $to->getFullURL() . $editor->getAnchor() );
		}

		return false;
	}

	public static function onShowEditFormFields( &$editor, &$out ) {
		global $wgRequest;

		$returnto = $wgRequest->getVal( 'wpReturnTo' );
		$talkhere = $wgRequest->getVal( 'wpTalkHere' );

		if ($talkhere && $returnto) {
			$out->addHTML('<input type="hidden" value="1" name="wpTalkHere" id="wpTalkHere" />');
			$out->addHTML('<input type="hidden" value="'.htmlspecialchars($returnto).'" name="wpReturnTo" id="wpReturnTo" />');
		}

		return true;
	}

}

/**
 * EditPage subclass that saves the result and the section anchor after an internalAttemptSave()
 * call
 */
class TalkHereEditPage extends EditPage {
	private $code = 0;
	private $sectionanchor = '';
	private $returnto;

	public function setReturnTo( $returnto ) {
		$this->returnto = $returnto;
	}

	public function getCancelLink() {
		global $wgUser;

		if ( $this->returnto ) {
			return $wgUser->getSkin()->link( $this->returnto, wfMsgExt('cancel', array( 'parseinline' ) ) );
		} else {
			return '';
		}
	}

	public function internalAttemptSave( &$result, $bot = false ) {
		$res = parent::internalAttemptSave( $result, $bot );
		$this->code = $res->value;
		if ( isset( $result['sectionanchor'] ) ) {
			$this->sectionanchor = $result['sectionanchor'];
		}
		return $res;
	}

	public function getCode() {
		return $this->code;
	}

	public function getAnchor() {
		return $this->sectionanchor;
	}
}
