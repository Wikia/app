<?php
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "not a valid entry point.\n" );
	die( 1 );
}

/**
 * Proxy object wrapping an article, intercepting rendering functions
 * to inject the talk page's content.
 */
class TalkHereArticle {

	var $_article;
	var $_talkTitle;
	var $_talk;

	/**
	 * Constructor
	 */
	function __construct(&$article, $talkTitle) {
		if (!$article) wfDebugDieBacktrace("article object required");

		$this->_article = $article;
		$this->_talkTitle = $talkTitle;
		$this->_talk = NULL;
	}

	function __call( $name, $args ) {
		$callback = array($this->_article, $name);
		return call_user_func_array( $callback, $args );
	}

	function __get( $name ) {
		return $this->_article->$name;
	}

	function render() {
		global $wgOut;

		$wgOut->setArticleBodyOnly(true);
		$this->view();
	}

	function view() {
		global $wgOut, $wgUser, $wgJsMimeType, $wgUseAjax;

		wfLoadExtensionMessages( 'TalkHere' );

		$skin = $wgUser->getSkin();
		$hastalk = $this->_talkTitle->exists();
		$cantalk = $this->_talkTitle->userCan('edit');

		$this->_article->view();

		if (!$hastalk && !$cantalk) return;

		if (!$this->_talk) {
			$this->_talk = MediaWiki::articleFromTitle( $this->_talkTitle );
		}

		$wgOut->addHTML('<div class="talkhere" id="talkhere">');

		if ($hastalk) {
			//Bah, would have to call a skin-snippet here :(
			$wgOut->addHTML('<div class="talkhere-head">');

			$wgOut->addHTML('<h1>');
			if ($this->_talkTitle->userCan('edit')) {
				$wgOut->addHTML('<span class="editsection">');
				$wgOut->addHTML( '[' . $skin->makeKnownLinkObj( $this->_talkTitle, wfMsg('talkhere-talkpage' ) ) . ']' );
				$wgOut->addHTML('</span>');
			}
			$wgOut->addWikiText( wfMsg('talkhere-title', $this->_talkTitle->getPrefixedText() ), false );
			$wgOut->addHTML('</h1>');

			$headtext = wfMsg('talkhere-headtext', $this->mTitle->getPrefixedText(), $this->_talkTitle->getPrefixedText() );
			if ( $headtext ) {
				$wgOut->addWikiText( $headtext );
				$wgOut->addHTML('<hr/>');
			}

			$wgOut->addHTML('</div>'); //talkhere-head

			$wgOut->addHTML('<div class="talkhere-comments">');
			$this->_talk->view();
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

			$returnto = $this->_article->mTitle->getPrefixedDBKey();
			$talktitle = $this->_talkTitle->getPrefixedDBKey();
			$q = 'action=edit&section=new&wpTalkHere=1&wpReturnTo=' . urlencode($returnto);

			$js = $wgUseAjax ? 'this.href="javascript:void(0);"; talkHereLoadEditor("talkhere_talklink", "talkhere_talkform", "'.Xml::escapeJsString($talktitle).'", "new", "'.Xml::escapeJsString($returnto).'"); ' : '';
			$a = 'onclick="'.htmlspecialchars($js).'" id="talkhere_talklink"';

			$wgOut->addHTML('<div class="talkhere-talklink">');
			$wgOut->addHTML( $skin->makeKnownLinkObj( $this->_talkTitle, wfMsg('talkhere-addcomment' ), $q, '', '', $a ) );
			$wgOut->addHTML('</div>');

			$wgOut->addHTML('<div id="talkhere_talkform" style="display:none;">&nbsp;</div>');
			//$this->showCommentForm('new');
		}

		if ($hastalk) {
			$foottext = wfMsg('talkhere-foottext', $this->mTitle->getPrefixedText(), $this->_talkTitle->getPrefixedText() );
			if ( $foottext ) {
				$wgOut->addHTML('<hr/>');
				$wgOut->addWikiText( $foottext );
			}
		}

		$wgOut->addHTML('</div>'); // talkhere-foot
		$wgOut->addHTML('</div>'); // talkhere
	}

	function doPurge() {
		global $wgUseSquid;
		// Invalidate the cache
		$this->mTitle->invalidateCache();

		if ( $wgUseSquid ) {
			// Commit the transaction before the purge is sent
			$dbw = wfGetDB( DB_MASTER );
			$dbw->immediateCommit();

			// Send purge
			$update = SquidUpdate::newSimplePurge( $this->mTitle );
			$update->doUpdate();
		}
		$this->view();
	}

	/*
	function showCommentForm( $section = 'new' ) {
		global $wgOut, $wgUser;
		$tabindex = 1;

		$skin = $wgUser->getSkin();

		$q = 'action=submit';
		$action = $this->_talkTitle->escapeLocalURL( $q );
		$wgOut->addHTML('<form action="'.$action.'" method="post" id="editform"  name="editform" enctype="multipart/form-data">');

		$wgOut->addHTML("<div>");
		$wgOut->addWikiText( wfMsg('talkhere-beforeinput') );
		$wgOut->addHTML("</div>");

		$wgOut->addHTML('<input type="hidden" value="'.htmlspecialchars($section).'" name="wpSection" />');
		$wgOut->addHTML('<input type="hidden" value="20070401210837" name="wpStarttime" />');
		$wgOut->addHTML('<input type="hidden" value="" name="wpEdittime" />');
		$wgOut->addHTML('<input type="hidden" value="" name="wpScrolltop" id="wpScrolltop" />');

		$returnto = urlencode( $this->_article->mTitle->getPrefixedDBKey() );
		$wgOut->addHTML('<input type="hidden" value="'.htmlspecialchars($returnto).'" name="wpReturnTo" id="wpReturnTo" />');
		$wgOut->addHTML('<input type="hidden" value="1" name="wpTalkHere" id="wpTalkHere" />');

		$wgOut->addHTML("<span id='wpSummaryLabel'><label for='wpSummary'>".wfMsg('subject')."</label>:&nbsp;</span>");
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
			} elseif( $wgUser->getOption( 'watchcreations' ) && !$this->_talkTitle->exists() ) {
				# Watch creations
				$watchthis = true;
			} elseif( $this->_talkTitle->userIsWatching() ) {
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
				"&nbsp;<label for='wpWatchthis'".$skin->tooltipAndAccesskey('watch').">{$watchLabel}</label>";
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
		$wgOut->addHTML( wfElement('input', $temp, '') );

		$temp = array(
			'id'        => 'wpPreview',
			'name'      => 'wpPreview',
			'type'      => 'submit',
			'tabindex'  => ++$tabindex,
			'value'     => wfMsg('showpreview'),
			'accesskey' => wfMsg('accesskey-preview'),
			'title'     => wfMsg( 'tooltip-preview' ).' ['.wfMsg( 'accesskey-preview' ).']',
		);
		$wgOut->addHTML(  wfElement('input', $temp, '') );

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
}

/**
 * Proxy object wrapping an article, overriding the redirect target after the
 * article was updated.
 */
class TalkHereEditTarget {

	var $_article;
	var $_returnto;

	/**
	 * Constructor
	 */
	function __construct(&$article, $returnto) {
		if ( !$article ) wfDebugDieBacktrace("article object required");

		$this->_article = $article;
		$this->_returnto = $returnto;
	}

	function __call( $name, $args ) {
		global $wgOut;

		$callback = array( $this->_article, $name );
		$res = call_user_func_array( $callback, $args );

		if ($name == 'insertNewArticle') {
			$wgOut->redirect( $this->_returnto->getFullURL() . '#talkhere' );
		}
		else if ($name == 'updateArticle' && $res) {
			$sectionAnchor = isset($args[5]) ? $args[5] : '';
			$wgOut->redirect( $this->_returnto->getFullURL() . $sectionAnchor );
		}

		return $res;
	}

	function __get( $name ) {
		return $this->_article->$name;
	}
}
