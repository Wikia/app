<?php

// Special:Code/MediaWiki/40696
class CodeRevisionView extends CodeView {

	function __construct( $repoName, $rev, $replyTarget=null ){
		global $wgRequest;
		parent::__construct();
		$this->mRepo = CodeRepository::newFromName( $repoName );
		$this->mRev = $this->mRepo ? $this->mRepo->getRevision( intval( $rev ) ) : null;
		$this->mPreviewText = false;
		# URL params...
		$this->mAddTags = $wgRequest->getText( 'wpTag' );
		$this->mRemoveTags =$wgRequest->getText( 'wpRemoveTag' );
		$this->mStatus = $wgRequest->getText('wpStatus');
		$this->jumpToNext = $wgRequest->getCheck('wpSaveAndNext');
		$this->mReplyTarget = $replyTarget ? 
			(int)$replyTarget : $wgRequest->getIntOrNull( 'wpParent' );
		$this->text = $wgRequest->getText( "wpReply{$this->mReplyTarget}" );
		$this->mSkipCache = ($wgRequest->getVal( 'action' ) == 'purge');
		# Make tag arrays
		$this->mAddTags = $this->splitTags( $this->mAddTags );
		$this->mRemoveTags = $this->splitTags( $this->mRemoveTags );
	}

	function execute(){
		global $wgOut, $wgUser, $wgLang;
		if( !$this->mRepo ) {
			$view = new CodeRepoListView();
			$view->execute();
			return;
		}
		if( !$this->mRev ) {
			$view = new CodeRevisionListView( $this->mRepo->getName() );
			$view->execute();
			return;
		}
		$this->mStatus = $this->mStatus ? $this->mStatus : $this->mRev->getStatus();

		$redirectOnPost = $this->checkPostings();
		if( $redirectOnPost ) {
			$wgOut->redirect( $redirectOnPost );
			return;
		}

		$repoLink = $wgUser->getSkin()->link( SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() ),
			htmlspecialchars( $this->mRepo->getName() ) );
		$revText = $this->navigationLinks();
		$paths = '';
		$modifiedPaths = $this->mRev->getModifiedPaths();
		foreach( $modifiedPaths as $row ){
			$paths .= $this->formatPathLine( $row->cp_path, $row->cp_action );
		}
		if( $paths ){
			$paths = "<div class='mw-codereview-paths'><ul>\n$paths</ul></div>\n";
		}
		$fields = array(
			'code-rev-repo' => $repoLink,
			'code-rev-rev' => $revText,
			'code-rev-date' => $wgLang->timeanddate( $this->mRev->getTimestamp(), true ),
			'code-rev-author' => $this->authorLink( $this->mRev->getAuthor() ),
			'code-rev-status' => $this->statusForm(),
			'code-rev-tags' => $this->tagForm(),
			'code-rev-message' => $this->formatMessage( $this->mRev->getMessage() ),
			'code-rev-paths' => $paths,
		);
		$special = SpecialPage::getTitleFor( 'Code', $this->mRepo->getName().'/'.$this->mRev->getId() );

		$html = Xml::openElement( 'form', array( 'action' => $special->getLocalUrl(), 'method' => 'post' ) );

		if( $wgUser->isAllowed('codereview-post-comment') ) {
			$html .= $this->addActionButtons();
		}
		
		$html .= $this->formatMetaData( $fields );

		if( $this->mRev->isDiffable() ) {
			$diffHtml = $this->formatDiff();
			$html .=
				"<h2>" . wfMsgHtml( 'code-rev-diff' ) .
				' <small>[' . $wgUser->getSkin()->makeLinkObj( $special,
					wfMsg('code-rev-purge-link'), 'action=purge' ) . ']</small></h2>' .
				"<div class='mw-codereview-diff' id='mw-codereview-diff'>" . $diffHtml . "</div>\n";
		}
		$comments = $this->formatComments();
		if( $comments ) {
			$html .= "<h2 id='code-comments'>". wfMsgHtml( 'code-comments' ) ."</h2>\n" . $comments;
		}
		
		if( $this->mReplyTarget ) {
			global $wgJsMimeType;
			$id = intval( $this->mReplyTarget );
			$html .= "<script type=\"$wgJsMimeType\">addOnloadHook(function(){" .
				"document.getElementById('wpReplyTo$id').focus();" .
				"});</script>\n";
		}
		
		if( $wgUser->isAllowed('codereview-post-comment') ) {
			$html .= $this->addActionButtons();
		}
			
		$changes = $this->formatPropChanges();
		if( $changes ) {
			$html .= "<h2 id='code-changes'>". wfMsgHtml( 'code-prop-changes' ) ."</h2>\n" . $changes;
		}
		$html .= xml::closeElement( 'form' );

		$wgOut->addHTML( $html );
	}
	
	protected function navigationLinks() {
		$rev = $this->mRev->getId();
		$prev = $this->mRev->getPrevious();
		$next = $this->mRev->getNext();
		$repo = $this->mRepo->getName();
		
		$links = array();
		
		if( $prev ) {
			$prevTarget = SpecialPage::getTitleFor( 'Code', "$repo/$prev" );
			$links[] = '&lt;&nbsp;' . $this->mSkin->link( $prevTarget, "r$prev" );
		}
		
		$revText = "<b>r$rev</b>";
		$viewvc = $this->mRepo->getViewVcBase();
		if( $viewvc ){
			$url = htmlspecialchars( "$viewvc/?view=rev&revision=$rev" );
			$viewvcTxt = wfMsgHtml( 'code-rev-rev-viewvc' );
			$revText .= " (<a href=\"$url\" title=\"revision $rev\">$viewvcTxt</a>)";
		}
		$links[] = $revText;

		if( $next ) {
			$nextTarget = SpecialPage::getTitleFor( 'Code', "$repo/$next" );
			$links[] = $this->mSkin->link( $nextTarget, "r$next" ) . '&nbsp;&gt;';
		}

		return implode( ' | ', $links );
	}

	protected function checkPostings() {
		global $wgRequest, $wgUser;
		if( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal('wpEditToken') ) ) {
			// Look for a posting...
			$text = $wgRequest->getText( "wpReply{$this->mReplyTarget}" );
			$parent = $wgRequest->getIntOrNull( 'wpParent' );
			$review = $wgRequest->getInt( 'wpReview' );
			$isPreview = $wgRequest->getCheck( 'wpPreview' );
			if( $isPreview ) {
				// Save the text for reference on later comment display...
				$this->mPreviewText = $text;
			}
		}
		return false;
	}

	protected function formatPathLine( $path, $action ) {
		$desc = wfMsgHtml( 'code-rev-modified-'.strtolower( $action ) );
		// Find any ' (from x)' from rename comment in the path.
		preg_match( '/ \([^\)]+\)$/', $path, $matches );
		$from = isset($matches[0]) ? $matches[0] : '';
		// Remove ' (from x)' from rename comment in the path.
		$path = preg_replace( '/ \([^\)]+\)$/', '', $path );
		$viewvc = $this->mRepo->getViewVcBase();
		$diff = '';
		if( $viewvc ) {
			$rev = $this->mRev->getId();
			$prev = $rev - 1;
			$safePath = wfUrlEncode( $path );
			if( $action !== 'D' ) {
				$link = $this->mSkin->makeExternalLink(
					"$viewvc$safePath?view=markup&pathrev=$rev",
					$path . $from );
			} else {
				$link = $safePath;
			}
			if( $action !== 'A' && $action !== 'D' ) {
				$diff = ' (' .
					$this->mSkin->makeExternalLink(
						"$viewvc$safePath?&pathrev=$rev&r1=$prev&r2=$rev", 
						wfMsg('code-rev-diff-link') ) .
					')';
			}
		} else {
			$link = $safePath;
		}
		return "<li>$link ($desc)$diff</li>\n";
	}
	
	protected function tagForm() {
		global $wgUser;
		$tags = $this->mRev->getTags();
		$list = '';
		if( count($tags) ) {
			$list = implode( ", ",
				array_map(
					array( $this, 'formatTag' ),
					$tags ) 
			) . '&nbsp;';
		}
		if( $wgUser->isAllowed( 'codereview-add-tag' ) ) {
			$list .= $this->addTagForm();
		}
		return $list;
	}
	
	protected function splitTags( $input ) {
		if( !$this->mRev ) return array();
		$tags = array_map( 'trim', explode( ",", $input ) );
		foreach( $tags as $key => $tag ) {
			$normal = $this->mRev->normalizeTag( $tag );
			if( $normal === false ) {
				return null;
			}
			$tags[$key] = $normal;
		}
		return $tags;
	}
	
	protected function listTags( $tags ) {
		if( empty($tags) )
			return "";
		return implode(",",$tags);
	}
	
	protected function statusForm() {
		global $wgUser;
		if( $wgUser->isAllowed( 'codereview-set-status' ) ) {
			$repo = $this->mRepo->getName();
			$rev = $this->mRev->getId();
			return Xml::openElement( 'select', array( 'name' => 'wpStatus' ) ) .
				$this->buildStatusList() . xml::closeElement('select');
		} else {
			return htmlspecialchars( $this->statusDesc( $this->mRev->getStatus() ) );
		}
	}
	
	protected function buildStatusList() {
		$states = CodeRevision::getPossibleStates();
		$out = '';
		foreach( $states as $state ) {
			$out .= Xml::option( $this->statusDesc( $state ), $state, $this->mStatus === $state );
		}
		return $out;
	}
	
	protected function addTagForm() {
		global $wgUser;
		$repo = $this->mRepo->getName();
		$rev = $this->mRev->getId();
		return '<div><table><tr><td>' .
			Xml::inputLabel( wfMsg('code-rev-tag-add'), 'wpTag', 'wpTag', 20,
				$this->listTags($this->mAddTags) ) . '</td><td>&nbsp;</td><td>' .
			Xml::inputLabel( wfMsg('code-rev-tag-remove'), 'wpRemoveTag', 'wpRemoveTag', 20,
				$this->listTags($this->mRemoveTags) ) . '</td></tr></table></div>';
	}
	
	protected function formatTag( $tag ) {
		global $wgUser;
		$repo = $this->mRepo->getName();
		$special = SpecialPage::getTitleFor( 'Code', "$repo/tag/$tag" );
		return $this->mSkin->link( $special, htmlspecialchars( $tag ) );
	}

	protected function formatDiff() {
		global $wgEnableAPI;
		
		// Asynchronous diff loads will require the API
		// And JS in the client, but tough shit eh? ;)
		$deferDiffs = $wgEnableAPI;
		
		if( $this->mSkipCache ) {
			// We're purging the cache on purpose, probably
			// because the cached data was corrupt.
			$cache = 'skipcache';
		} elseif( $deferDiffs ) {
			// If data is already cached, we'll take it now;
			// otherwise defer the load to an AJAX request.
			// This lets the page be manipulable even if the
			// SVN connection is slow or uncooperative.
			$cache = 'cached';
		} else {
			$cache = '';
		}
		$diff = $this->mRepo->getDiff( $this->mRev->getId(), $cache );
		if( !$diff && $deferDiffs ) {
			// We'll try loading it by AJAX...
			return $this->stubDiffLoader();
		}
		$hilite = new CodeDiffHighlighter();
		return $hilite->render( $diff );
	}

	protected function stubDiffLoader() {
		global $wgOut, $wgScriptPath, $wgCodeReviewStyleVersion;
		$encRepo = Xml::encodeJsVar( $this->mRepo->getName() );
		$encRev = Xml::encodeJsVar( $this->mRev->getId() );
		$wgOut->addScriptFile( "$wgScriptPath/extensions/CodeReview/codereview.js?$wgCodeReviewStyleVersion" );
		$wgOut->addInlineScript(
			"addOnloadHook(
				function() {
					CodeReview.loadDiff($encRepo,$encRev);
				}
			);" );
		return wfMsg( 'code-load-diff' );
	}

	protected function formatComments() {
		$comments = implode( "\n",
			array_map( array( $this, 'formatCommentInline' ), $this->mRev->getComments() )
		) . $this->postCommentForm();
		if( !$comments ) {
			return false;
		}
		return "<div class='mw-codereview-comments'>$comments</div>";
	}
	
	protected function formatPropChanges() {
		$changes = implode( "\n",
			array_map( array( $this, 'formatChangeInline' ), $this->mRev->getPropChanges() )
		);
		if( !$changes ) {
			return false;
		}
		return "<ul class='mw-codereview-changes'>$changes</ul>";
	}

	protected function formatCommentInline( $comment ) {
		if( $comment->id === $this->mReplyTarget ) {
			return $this->formatComment( $comment,
				$this->postCommentForm( $comment->id ) );
		} else {
			return $this->formatComment( $comment );
		}
	}
	
	protected function formatChangeInline( $change ) {
		global $wgLang;
		$line = $wgLang->timeanddate( $change->timestamp, true );
		$line .= '&nbsp;' . $this->mSkin->userLink( $change->user, $change->userText );
		$line .= $this->mSkin->userToolLinks( $change->user, $change->userText );
		$line .= '&nbsp;' . wfMsgExt("code-change-{$change->attrib}",array('parseinline'));
		$line .= " <i>[";
		if( $change->removed ) {
			$line .= '<b>'.wfMsg('code-change-removed').'</b> ';
			$line .= htmlspecialchars($change->removed);
			$line .= $change->added ? "&nbsp;" : "";
		}
		if( $change->added ) {
			$line .= '<b>'.wfMsg('code-change-added').'</b> ';
			$line .=  htmlspecialchars($change->added);
		}
		$line .= "]</i>";
		return "<li>$line</li>";
	}
	
	protected function commentLink( $commentId ) {
		$repo = $this->mRepo->getName();
		$rev = $this->mRev->getId();
		$title = SpecialPage::getTitleFor( 'Code', "$repo/$rev" );
		$title->setFragment( "#c{$commentId}" );
		return $title;
	}
	
	protected function revLink() {
		$repo = $this->mRepo->getName();
		$rev = $this->mRev->getId();
		$title = SpecialPage::getTitleFor( 'Code', "$repo/$rev" );
		return $title;
	}	
	
	protected function previewComment( $text, $review=0 ) {
		$comment = $this->mRev->previewComment( $text, $review );
		return $this->formatComment( $comment );
	}
	
	protected function formatComment( $comment, $replyForm='' ) {
		global $wgOut, $wgLang;
		$linker = new CodeCommentLinkerWiki( $this->mRepo );
		
		if( $comment->id === null ) {
			$linkId = 'cpreview';
			$permaLink = "<b>Preview:</b> ";
		} else {
			$linkId = 'c' . intval( $comment->id );
			$permaLink = $this->mSkin->link( $this->commentLink( $comment->id ), "#" );
		}
		
		return Xml::openElement( 'div',
			array(
				'class' => 'mw-codereview-comment',
				'id' => $linkId,
				'style' => $this->commentStyle( $comment ) ) ) .
			'<div class="mw-codereview-comment-meta">' .
			$permaLink .
			wfMsgHtml( 'code-rev-comment-by',
				$this->mSkin->userLink( $comment->user, $comment->userText ) .
				$this->mSkin->userToolLinks( $comment->user, $comment->userText ) ) .
			' &nbsp; ' .
			$wgLang->timeanddate( $comment->timestamp, true ) .
			' ' .
			$this->commentReplyLink( $comment->id ) .
			'</div>' .
			'<div class="mw-codereview-comment-text">' .
			$wgOut->parse( $linker->link( $comment->text ) ) .
			'</div>' .
			$replyForm .
			'</div>';
	}

	protected function commentStyle( $comment ) {
		$depth = $comment->threadDepth();
		$margin = ($depth - 1) * 48;
		return "margin-left: ${margin}px";
	}
	
	protected function commentReplyLink( $id ) {
		$repo = $this->mRepo->getName();
		$rev = $this->mRev->getId();
		$self = SpecialPage::getTitleFor( 'Code', "$repo/$rev/reply/$id" );
		$self->setFragment( "#c$id" );
		return '[' .
			$this->mSkin->link( $self, wfMsg( 'codereview-reply-link' ) ) .
			']';
	}
	
	protected function postCommentForm( $parent=null ) {
		global $wgUser;
		if( $this->mPreviewText !== false && $parent === $this->mReplyTarget ) {
			$preview = $this->previewComment( $this->mPreviewText );
			$text = htmlspecialchars( $this->mPreviewText );
		} else {
			$preview = '';
			$text = $this->text;
		}
		$repo = $this->mRepo->getName();
		$rev = $this->mRev->getId();
		if( !$wgUser->isAllowed('codereview-post-comment') ) {
			return '';
		}
		return '<div class="mw-codereview-post-comment">' .
			$preview .
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ) .
			($parent ? Xml::hidden( 'wpParent', $parent ) : '') .
			'<div>' .
			Xml::openElement( 'textarea', array(
				'name' => "wpReply{$parent}",
				'id' => "wpReplyTo{$parent}",
				'cols' => 40,
				'rows' => 5 ) ) .
			$text .
			'</textarea>' .
			'</div>' .
			'</div>';
	}

	protected function addActionButtons() {
		return '<div>' .
			Xml::submitButton( wfMsg( 'code-rev-submit' ), array( 'name' => 'wpSave' ) ) .
			' ' .
			Xml::submitButton( wfMsg( 'code-rev-submit-next' ), array( 'name' => 'wpSaveAndNext' ) ) .
			' ' .
			Xml::submitButton( wfMsg( 'code-rev-comment-preview' ), array( 'name' => 'wpPreview' ) ) .
			'</div>';
	}
}
