<?php

// Special:Code/MediaWiki/40696
class CodeRevisionView extends CodeView {

	protected $showButtonsFormatReference = false, $showButtonsFormatSignoffs = false;
	protected $referenceInputName = '';

	/**
	 * @param string|CodeRepository $repo
	 * @param string|CodeRevision $rev
	 * @param null $replyTarget
	 */
	function __construct( $repo, $rev, $replyTarget = null ) {
		parent::__construct( $repo );
		global $wgRequest;

		if ( $rev instanceof CodeRevision ) {
			$this->mRevId = $rev->getId();
			$this->mRev = $rev;
		} else {
			$this->mRevId = intval( ltrim( $rev, 'r' ) );
			$this->mRev = $this->mRepo
				? $this->mRepo->getRevision( $this->mRevId )
				: null;
		}

		$this->mPreviewText = false;
		# Search path for navigation links
		$this->mPath = htmlspecialchars( trim( $wgRequest->getVal( 'path' ) ) );
		if ( strlen( $this->mPath ) && $this->mPath[0] !== '/' ) {
			$this->mPath = "/{$this->mPath}"; // make sure this is a valid path
		}
		# URL params...
		$this->mAddTags = $wgRequest->getText( 'wpTag' );
		$this->mRemoveTags = $wgRequest->getText( 'wpRemoveTag' );
		$this->mStatus = $wgRequest->getText( 'wpStatus' );
		$this->jumpToNext = $wgRequest->getCheck( 'wpSaveAndNext' ) || $wgRequest->getCheck( 'wpNext' );
		$this->mReplyTarget = $replyTarget ?
			(int)$replyTarget : $wgRequest->getIntOrNull( 'wpParent' );
		$this->text = $wgRequest->getText( "wpReply{$this->mReplyTarget}" );
		$this->mSkipCache = ( $wgRequest->getVal( 'action' ) == 'purge' );
		# Make tag arrays
		$this->mAddTags = $this->splitTags( $this->mAddTags );
		$this->mRemoveTags = $this->splitTags( $this->mRemoveTags );
		$this->mSignoffFlags = $wgRequest->getCheck( 'wpSignoff' ) ?
			$wgRequest->getArray( 'wpSignoffFlags' ) : array();
		$this->mSelectedSignoffs = $wgRequest->getArray( 'wpSignoffs' );
		$this->mStrikeSignoffs = $wgRequest->getCheck( 'wpStrikeSignoffs' ) ?
			$this->mSelectedSignoffs : array();

		$this->mAddReferences = $wgRequest->getCheck( 'wpAddReferencesSubmit' )
				? $this->stringToRevList( $wgRequest->getText( 'wpAddReferences' ) )
				: array();

		$this->mRemoveReferences = $wgRequest->getCheck( 'wpRemoveReferences' ) ?
			$wgRequest->getIntArray( 'wpReferences', array() ) : array();

		$this->mAddReferenced = $wgRequest->getCheck( 'wpAddReferencedSubmit' )
				? $this->stringToRevList( $wgRequest->getText( 'wpAddReferenced' ) )
				: array();

		$this->mRemoveReferenced = $wgRequest->getCheck( 'wpRemoveReferenced' ) ?
				$wgRequest->getIntArray( 'wpReferenced', array() ) : array();
	}

	/**
	 * @param $item string
	 * @return int
	 */
	private function ltrimIntval( $item ) {
		$item = ltrim( trim( $item ), 'r' );
		return intval( $item );
	}

	/**
	 * @param $input string
	 * @return array
	 */
	private function stringToRevList( $input ) {
		return array_map( array( $this, 'ltrimIntval' ), explode( ',', $input ) );
	}

	function execute() {
		global $wgOut, $wgLang;
		if ( !$this->mRepo ) {
			$view = new CodeRepoListView();
			$view->execute();
			return;
		}
		if ( !$this->mRev ) {
			if ( $this->mRevId !== 0 ) {
				$wgOut->addWikiMsg( 'code-rev-not-found', $this->mRevId );
			}

			$view = new CodeRevisionListView( $this->mRepo->getName() );
			$view->execute();
			return;
		}
		if ( $this->mStatus == '' ) {
			$this->mStatus = $this->mRev->getStatus();
		}

		$redirectOnPost = $this->checkPostings();
		if ( $redirectOnPost ) {
			$wgOut->redirect( $redirectOnPost );
			return;
		}

		$pageTitle = $this->mRepo->getName() . wfMsg( 'word-separator' ) . $this->mRev->getIdString();
		$htmlTitle = $this->mRev->getIdString() . wfMsg( 'word-separator' ) . $this->mRepo->getName();
		$wgOut->setPageTitle( wfMsgHtml( 'code-rev-title', $pageTitle ) );
		$wgOut->setHTMLTitle( wfMsgHtml( 'code-rev-title', $htmlTitle ) );

		$repoLink = $this->skin->link( SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() ),
			htmlspecialchars( $this->mRepo->getName() ) );
		$revText = $this->navigationLinks();
		$paths = '';
		$modifiedPaths = $this->mRev->getModifiedPaths();
		foreach ( $modifiedPaths as $row ) {
			// Don't output NOOP paths
			if ( strtolower( $row->cp_action ) == 'n' ){
				continue;
			}
			$paths .= $this->formatPathLine( $row->cp_path, $row->cp_action );
		}
		if ( $paths ) {
			$paths = "<div class='mw-codereview-paths mw-content-ltr'><ul>\n$paths</ul></div>\n";
		}
		$comments = $this->formatComments();
		$commentsLink = "";
		if ( $comments ) {
			$commentsLink = " (<a href=\"#code-comments\">" . wfMsgHtml( 'code-comments' ) . "</a>)\n";
		}
		$fields = array(
			'code-rev-repo' => $repoLink,
			'code-rev-rev' => $revText,
			'code-rev-date' => $wgLang->timeanddate( $this->mRev->getTimestamp(), true ),
			'code-rev-author' => $this->authorLink( $this->mRev->getAuthor() ),
			'code-rev-status' => $this->statusForm() . $commentsLink,
			'code-rev-tags' => $this->tagForm(),
			'code-rev-message' => Html::rawElement( 'div', array( 'class' => 'mw-codereview-message' ),
				$this->formatMessage( $this->mRev->getMessage() ) ),
			'code-rev-paths' => $paths,
		);
		$special = SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/' . $this->mRev->getId() );

		$html = '';
		if ( $this->mPath != '' ) {
			$links = array();
			foreach( explode( '|', $this->mPath ) as $path ) {
				$links[] = $this->skin->link(
					SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() ),
					$path,
					array(),
					array( 'path' => $path )
				);
			}
			$html .= wfMsgExt( 'code-browsing-path', array( 'parse', 'replaceafter' ), $wgLang->commaList( $links ) );
		}
		# Output form
		$html .= Xml::openElement( 'form', array( 'action' => $special->getLocalUrl(), 'method' => 'post' ) );

		if ( $this->canPostComments() ) {
			$html .= $this->addActionButtons();
		}

		$html .= $this->formatMetaData( $fields );
		# Output diff
		if ( $this->mRev->isDiffable() ) {
			$diffHtml = $this->formatDiff();
			$html .=
				"<h2>" . wfMsgHtml( 'code-rev-diff' ) .
				' <small>[' . $this->skin->makeLinkObj( $special,
					wfMsgHtml( 'code-rev-purge-link' ), 'action=purge' ) . ']</small></h2>' .
				"<div class='mw-codereview-diff' id='mw-codereview-diff'>" . $diffHtml . "</div>\n";
			$html .= $this->formatImgDiff();
		}

		# Show sign-offs
		$userCanSignoff = $this->canSignoff();
		$signOffs = $this->mRev->getSignoffs();
		if ( count( $signOffs ) || $userCanSignoff ) {
			$html .= "<h2 id='code-signoffs'>" . wfMsgHtml( 'code-signoffs' ) .
				"</h2>\n" . $this->formatSignoffs( $signOffs, $userCanSignoff );
		}

		# Show code relations
		$userCanAssociate = $this->canAssociate();
		$references = $this->mRev->getFollowupRevisions();
		if ( count( $references ) || $userCanAssociate ) {
			$html .= "<h2 id='code-references'>" . wfMsgHtml( 'code-references' ) .
				"</h2>\n" . $this->formatReferences( $references, $userCanAssociate, 'References' );
		}

		$referenced = $this->mRev->getFollowedUpRevisions();
		if ( count( $referenced ) || $userCanAssociate ) {
			$html .= "<h2 id='code-referenced'>" . wfMsgHtml( 'code-referenced' ) .
					"</h2>\n" . $this->formatReferences( $referenced, $userCanAssociate, 'Referenced' );
		}

		# Add revision comments
		if ( $comments ) {
			$html .= "<h2 id='code-comments'>" . wfMsgHtml( 'code-comments' ) .
				"</h2>\n" . $comments;
		}

		if ( $this->canPostComments() ) {
			$html .= $this->addActionButtons();
		}

		$changes = $this->formatPropChanges();
		if ( $changes ) {
			$html .= "<h2 id='code-changes'>" . wfMsgHtml( 'code-prop-changes' ) . "</h2>\n" . $changes;
		}
		$html .= xml::closeElement( 'form' );

		$wgOut->addHTML( $html );
	}

	protected function navigationLinks() {
		global $wgLang;

		$rev = $this->mRev->getId();
		$prev = $this->mRev->getPrevious( $this->mPath );
		$next = $this->mRev->getNext( $this->mPath );
		$repo = $this->mRepo->getName();

		$links = array();

		if ( $prev ) {
			$prevTarget = SpecialPage::getTitleFor( 'Code', "$repo/$prev" );
			$links[] = '&lt;&#160;' . $this->skin->link( $prevTarget, $this->mRev->getIdString( $prev ),
				array(), array( 'path' => $this->mPath ) ).wfUILang()->getDirMark();
		}

		$revText = "<b>" . $this->mRev->getIdString( $rev ) . "</b>";
		$viewvc = $this->mRepo->getViewVcBase();
		if ( $viewvc ) {
			$url = htmlspecialchars( "$viewvc/?view=rev&revision=$rev" );
			$viewvcTxt = wfMsgHtml( 'code-rev-rev-viewvc' );
			$revText .= " (<a href=\"$url\" title=\"revision $rev\">$viewvcTxt</a>)".wfUILang()->getDirMark();
		}
		$links[] = $revText;

		if ( $next ) {
			$nextTarget = SpecialPage::getTitleFor( 'Code', "$repo/$next" );
			$links[] = $this->skin->link( $nextTarget, $this->mRev->getIdString( $next ),
				array(), array( 'path' => $this->mPath ) ) . '&#160;&gt;';
		}

		return $wgLang->pipeList( $links );
	}

	protected function checkPostings() {
		global $wgRequest, $wgUser;
		if ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
			// Look for a posting...
			$text = $wgRequest->getText( "wpReply{$this->mReplyTarget}" );
			$isPreview = $wgRequest->getCheck( 'wpPreview' );
			if ( $isPreview ) {
				// Save the text for reference on later comment display...
				$this->mPreviewText = $text;
			}
		}
		return false;
	}

	/**
	 * @return bool
	 */
	protected function canPostComments() {
		global $wgUser;
		return $wgUser->isAllowed( 'codereview-post-comment' ) && !$wgUser->isBlocked();
	}

	/**
	 * @return bool Whether the current user can sign off on revisions
	 */
	protected function canSignoff() {
		global $wgUser;
		return $wgUser->isAllowed( 'codereview-signoff' ) && !$wgUser->isBlocked();
	}

	/**
	 * @return bool Whether the current user can add and remove associations between revisions
	 */
	protected function canAssociate() {
		global $wgUser;
		return $wgUser->isAllowed( 'codereview-associate' ) && !$wgUser->isBlocked();
	}

	protected function formatPathLine( $path, $action ) {
		$action = strtolower( $action );

		// If NOOP passed, return ''
		if ( $action == 'n' ) {
			return '';
		}
		// Uses messages 'code-rev-modified-a', 'code-rev-modified-r', 'code-rev-modified-d', 'code-rev-modified-m'
		$desc = wfMsgHtml( 'code-rev-modified-' . $action );
		// Find any ' (from x)' from rename comment in the path.
		$matches = array();
		preg_match( '/ \([^\)]+\)$/', $path, $matches );
		$from = isset( $matches[0] ) ? $matches[0] : '';
		// Remove ' (from x)' from rename comment in the path.
		$path = preg_replace( '/ \([^\)]+\)$/', '', $path );
		$viewvc = $this->mRepo->getViewVcBase();
		$diff = '';
		$hist = $this->skin->link(
			SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() ),
			wfMsg( 'code-rev-history-link' ), array(), array( 'path' => $path )
		);
		$safePath = wfUrlEncode( $path );
		if ( $viewvc ) {
			$rev = $this->mRev->getId();
			$prev = $rev - 1;
			if ( $action === 'd' ) {
				if ( $rev > 1 ) {
					$link = $this->skin->makeExternalLink( // last rev
						"{$viewvc}{$safePath}?view=markup&pathrev=".($rev-1),
						$path . $from );
				} else {
					$link = $safePath; // imported to SVN or something
				}
			} else {
				$link = $this->skin->makeExternalLink(
					"{$viewvc}{$safePath}?view=markup&pathrev=$rev",
					$path . $from );
			}
			if ( $action !== 'a' && $action !== 'd' ) {
				$diff = ' (' .
					$this->skin->makeExternalLink(
						"$viewvc$safePath?&pathrev=$rev&r1=$prev&r2=$rev",
						wfMsg( 'code-rev-diff-link' ) ) .
					')';
			}
		} else {
			$link = $safePath;
		}
		return "<li><b>$link</b> ($desc) ($hist)$diff</li>\n";
	}

	protected function tagForm() {
		global $wgUser;
		$tags = $this->mRev->getTags();
		$list = '';
		if ( count( $tags ) ) {
			$list = implode( ", ",
				array_map(
					array( $this, 'formatTag' ),
					$tags )
			) . '&#160;';
		}
		if ( $wgUser->isAllowed( 'codereview-add-tag' ) ) {
			$list .= $this->addTagForm( $this->mAddTags, $this->mRemoveTags );
		}
		return $list;
	}

	/**
	 * @param $input string
	 * @return array|null
	 */
	protected function splitTags( $input ) {
		if ( !$this->mRev ) {
			return array();
		}
		$tags = array_map( 'trim', explode( ",", $input ) );
		foreach ( $tags as $key => $tag ) {
			$normal = $this->mRev->normalizeTag( $tag );
			if ( $normal === false ) {
				return null;
			}
			$tags[$key] = $normal;
		}
		return $tags;
	}

	/**
	 * @param $tags array
	 * @return string
	 */
	static function listTags( $tags ) {
		if ( empty( $tags ) ) {
			return "";
		}
		return implode( ",", $tags );
	}

	/**
	 * @return string
	 */
	protected function statusForm() {
		global $wgUser;
		if ( $wgUser->isAllowed( 'codereview-set-status' ) ) {
			return Xml::openElement( 'select', array( 'name' => 'wpStatus' ) ) .
				self::buildStatusList( $this->mStatus, $this ) .
				xml::closeElement( 'select' );
		} else {
			return htmlspecialchars( $this->statusDesc( $this->mRev->getStatus() ) );
		}
	}

	/**
	 * @static
	 * @param string $status
	 * @param CodeView $view
	 * @return string
	 */
	static function buildStatusList( $status, $view ) {
		$states = CodeRevision::getPossibleStates();
		$out = '';
		foreach ( $states as $state ) {
			$out .= Xml::option( $view->statusDesc( $state ), $state,
						$status === $state );
		}
		return $out;
	}

	/**
	 * Parameters are the tags to be added/removed sent with the request
	 * @param $addTags array
	 * @param $removeTags array
	 * @return string
	 */
	static function addTagForm( $addTags, $removeTags ) {
		return '<div><table><tr><td>' .
			Xml::inputLabel( wfMsg( 'code-rev-tag-add' ), 'wpTag', 'wpTag', 20,
				self::listTags( $addTags ) ) . '</td><td>&#160;</td><td>' .
			Xml::inputLabel( wfMsg( 'code-rev-tag-remove' ), 'wpRemoveTag', 'wpRemoveTag', 20,
				self::listTags( $removeTags ) ) . '</td></tr></table></div>';
	}

	/**
	 * @param $tag string
	 * @return string
	 */
	protected function formatTag( $tag ) {
		$repo = $this->mRepo->getName();
		$special = SpecialPage::getTitleFor( 'Code', "$repo/tag/$tag" );
		return $this->skin->link( $special, htmlspecialchars( $tag ) );
	}

	/**
	 * @return string
	 */
	protected function formatDiff() {
		global $wgEnableAPI, $wgCodeReviewMaxDiffSize;

		// Asynchronous diff loads will require the API
		// And JS in the client, but tough shit eh? ;)
		$deferDiffs = $wgEnableAPI;

		if ( $this->mSkipCache ) {
			// We're purging the cache on purpose, probably
			// because the cached data was corrupt.
			$cache = 'skipcache';
		} elseif ( $deferDiffs ) {
			// If data is already cached, we'll take it now;
			// otherwise defer the load to an AJAX request.
			// This lets the page be manipulable even if the
			// SVN connection is slow or uncooperative.
			$cache = 'cached';
		} else {
			$cache = '';
		}
		$diff = $this->mRepo->getDiff( $this->mRev->getId(), $cache );
		if ( is_integer($diff) && $deferDiffs ) {
			// We'll try loading it by AJAX...
			return $this->stubDiffLoader();
		} elseif ( strlen( $diff ) > $wgCodeReviewMaxDiffSize ) {
			return htmlspecialchars( wfMsg( 'code-rev-diff-too-large' ) );
		} else {
			$hilite = new CodeDiffHighlighter();
			return $hilite->render( $diff );
		}
	}

	/**
	 * @return string
	 */
	protected function formatImgDiff() {
		global $wgCodeReviewImgRegex;
		// Get image diffs
		$imgDiffs = $html = '';
		$modifiedPaths = $this->mRev->getModifiedPaths();
		foreach ( $modifiedPaths as $row ) {
			// Typical image file?
			if ( preg_match( $wgCodeReviewImgRegex, $row->cp_path ) ) {
				$imgDiffs .= 'Index: ' . htmlspecialchars( $row->cp_path ) . "\n";
				$imgDiffs .= '<table border="1px" style="background:white;"><tr>';
				if ( $row->cp_action !== 'A' ) { // old
					// What was done to it?
					$action = $row->cp_action == 'D' ? 'code-rev-modified-d' : 'code-rev-modified-r';
					// Link to old image
					$imgDiffs .= $this->formatImgCell( $row->cp_path, $this->mRev->getPrevious(), $action );
				}
				if ( $row->cp_action !== 'D' ) { // new
					// What was done to it?
					$action = $row->cp_action == 'A' ? 'code-rev-modified-a' : 'code-rev-modified-m';
					// Link to new image
					$imgDiffs .= $this->formatImgCell( $row->cp_path, $this->mRev->getId(), $action );
				}
				$imgDiffs .= "</tr></table>\n";
			}
		}
		if ( $imgDiffs ) {
			$html = '<h2>' . wfMsgHtml( 'code-rev-imagediff' ) . '</h2>';
			$html .= "<div class='mw-codereview-imgdiff'>$imgDiffs</div>\n";
		}
		return $html;
	}

	/**
	 * @param $path
	 * @param $rev
	 * @param $message
	 * @return string
	 */
	protected function formatImgCell( $path, $rev, $message ) {
		$viewvc = $this->mRepo->getViewVcBase();
		$safePath = wfUrlEncode( $path );
		$url = "{$viewvc}{$safePath}?&pathrev=$rev&revision=$rev";

		$alt = wfMsg( $message );

		return Xml::tags( 'td',
			array(),
			Xml::tags( 'a',
				array( 'href' => $url ),
				Xml::element( 'img',
					array(
						'src' => $url,
						'alt' => $alt,
						'title' => $alt,
						'border' => '0' ) ) ) );
	}

	/**
	 * @return bool|string
	 */
	protected function stubDiffLoader() {
		global $wgOut;
		$encRepo = Xml::encodeJsVar( $this->mRepo->getName() );
		$encRev = Xml::encodeJsVar( $this->mRev->getId() );
		$wgOut->addModules( 'ext.codereview.loaddiff' );
		$wgOut->addInlineScript(
			"$(
				function() {
					CodeReview.loadDiff($encRepo,$encRev);
				}
			);" );
		return wfMsg( 'code-load-diff' );
	}

	/**
	 * Format the sign-offs table
	 * @param $signOffs array
	 * @param $showButtons bool Whether the buttons to strike and submit sign-offs should be shown
	 * @return string HTML
	 */
	protected function formatSignoffs( $signOffs, $showButtons ) {
		$this->showButtonsFormatSignoffs = $showButtons;

		$header = '';
		if ( count( $signOffs ) ) {
			if ( $showButtons ) {
				$header = '<th></th>';
			}
			$signoffs = implode( "\n",
				array_map( array( $this, 'formatSignoffInline' ), $signOffs )
			);
			$header .= '<th>' . wfMsgHtml( 'code-signoff-field-user' ) . '</th>';
			$header .= '<th>' . wfMsgHtml( 'code-signoff-field-flag' ). '</th>';
			$header .= '<th>' . wfMsgHtml( 'code-signoff-field-date' ). '</th>';
		} else {
			$signoffs = '';
		}
		$buttonrow = $showButtons ? $this->signoffButtons( $signOffs ) : '';
		return "<table border='1' class='wikitable'><tr>$header</tr>$signoffs$buttonrow</table>";
	}

	/**
	 * @return bool|string
	 */
	protected function formatComments() {
		$comments = implode( "\n",
			array_map( array( $this, 'formatCommentInline' ), $this->mRev->getComments() )
		);
		if ( !$this->mReplyTarget ) {
			$comments .= $this->postCommentForm();
		}
		if ( !$comments ) {
			return false;
		}
		return "<div class='mw-codereview-comments'>$comments</div>";
	}

	/**
	 * @return bool|string
	 */
	protected function formatPropChanges() {
		$changes = implode( "\n",
			array_map( array( $this, 'formatChangeInline' ), $this->mRev->getPropChanges() )
		);
		if ( !$changes ) {
			return false;
		}
		return "<ul class='mw-codereview-changes'>$changes</ul>";
	}

	/**
	 * @param $references array
	 * @param $showButtons bool
	 * @return string
	 */
	protected function formatReferences( $references, $showButtons, $inputName ) {
		$this->showButtonsFormatReference = $showButtons;
		$this->referenceInputName = $inputName;
		$refs = implode( "\n",
			array_map( array( $this, 'formatReferenceInline' ), $references )
		);

		$header = '';
		if ( $showButtons ) {
			$header = '<th></th>';
		}
		$header .= '<th>' . wfMsgHtml( 'code-field-id' ) . '</th>';
		$header .= '<th>' . wfMsgHtml( 'code-field-message' ) . '</th>';
		$header .= '<th>' . wfMsgHtml( 'code-field-author' ) . '</th>';
		$header .= '<th>' . wfMsgHtml( 'code-field-timestamp' ) . '</th>';
		$buttonrow = $showButtons ? $this->referenceButtons( $inputName ) : '';
		return "<table border='1' class='wikitable'><tr>{$header}</tr>{$refs}{$buttonrow}</table>";
	}

	/**
	 * Format a single sign-off row. Helper function for formatSignoffs()
	 * @param $signoff CodeSignoff
	 * @return string HTML
	 */
	protected function formatSignoffInline( $signoff ) {
		global $wgLang;
		$user = $this->skin->userLink( $signoff->user, $signoff->userText );
		$flag = htmlspecialchars( $signoff->flag );
		$signoffDate = $wgLang->timeanddate( $signoff->timestamp, true );
		$class = "mw-codereview-signoff-flag-$flag";
		if ( $signoff->isStruck() ) {
			$class .= ' mw-codereview-struck';
			$struckDate = $wgLang->timeanddate( $signoff->getTimestampStruck(), true );
			$date = wfMsgHtml( 'code-signoff-struckdate', $signoffDate, $struckDate );
		} else {
			$date = htmlspecialchars( $signoffDate );
		}

		$ret = "<tr class='$class'>";
		if ( $this->showButtonsFormatSignoffs ) {
			$checkbox = Html::input( 'wpSignoffs[]', $signoff->getID(), 'checkbox' );
			$ret .= "<td>$checkbox</td>";
		}
		$ret .= "<td>$user</td><td>$flag</td><td>$date</td></tr>";
		return $ret;
	}

	/**
	 * @param  $comment CodeComment
	 * @return string
	 */
	protected function formatCommentInline( $comment ) {
		if ( $comment->id === $this->mReplyTarget ) {
			return $this->formatComment( $comment,
				$this->postCommentForm( $comment->id ) );
		} else {
			return $this->formatComment( $comment );
		}
	}

	/**
	 * @param $change CodePropChange
	 * @return string
	 */
	protected function formatChangeInline( $change ) {
		global $wgLang;
		$revId = $change->rev->getIdString();
		$line = $wgLang->timeanddate( $change->timestamp, true );
		$line .= '&#160;' . $this->skin->userLink( $change->user, $change->userText );
		$line .= $this->skin->userToolLinks( $change->user, $change->userText );
		// Uses messages 'code-change-status', 'code-change-tags'
		$line .= '&#160;' . wfMsgExt( "code-change-{$change->attrib}", 'parseinline', $revId );
		$line .= " <i>[";
		// Items that were changed or set...
		if ( $change->removed ) {
			$line .= '<b>' . wfMsgHtml( 'code-change-removed' ) . '</b> ';
			// Status changes...
			if ( $change->attrib == 'status' ) {
				$line .= wfMsgHtml( 'code-status-' . $change->removed );
				$line .= $change->added ? "&#160;" : ""; // spacing
			// Tag changes
			} elseif ( $change->attrib == 'tags' ) {
				$line .= htmlspecialchars( $change->removed );
				$line .= $change->added ? "&#160;" : ""; // spacing
			}
		}
		// Items that were changed to something else...
		if ( $change->added ) {
			$line .= '<b>' . wfMsgHtml( 'code-change-added' ) . '</b> ';
			// Status changes...
			if ( $change->attrib == 'status' ) {
				$line .= wfMsgHtml( 'code-status-' . $change->added );
			// Tag changes...
			} else {
				$line .= htmlspecialchars( $change->added );
			}
		}
		$line .= "]</i>";
		return "<li>$line</li>";
	}

	/**
	 * @param $row
	 * @return string
	 */
	protected function formatReferenceInline( $row ) {
		global $wgLang;
		$rev = intval( $row->cr_id );
		$repo = $this->mRepo->getName();
		// Borrow the code revision list css
		$css = 'mw-codereview-status-' . htmlspecialchars( $row->cr_status );
		$date = $wgLang->timeanddate( $row->cr_timestamp, true );
		$title = SpecialPage::getTitleFor( 'Code', "$repo/$rev" );
		$revLink = $this->skin->link( $title, $this->mRev->getIdString( $rev ) );
		$summary = $this->messageFragment( $row->cr_message );
		$author = $this->authorLink( $row->cr_author );

		$ret = "<tr class='$css'>";
		if ( $this->showButtonsFormatReference ) {
			$checkbox = Html::input( "wp{$this->referenceInputName}[]", $rev, 'checkbox' );
			$ret .= "<td>$checkbox</td>";
		}
		$ret .= "<td>$revLink</td><td>$summary</td><td>$author</td><td>$date</td></tr>";
		return $ret;
	}

	/**
	 * @param $commentId int
	 * @return Title
	 */
	protected function commentLink( $commentId ) {
		$repo = $this->mRepo->getName();
		$rev = $this->mRev->getId();
		$title = SpecialPage::getTitleFor( 'Code', "$repo/$rev" );
		$title->setFragment( "#c{$commentId}" );
		return $title;
	}

	/**
	 * @return Title
	 */
	protected function revLink() {
		$repo = $this->mRepo->getName();
		$rev = $this->mRev->getId();
		$title = SpecialPage::getTitleFor( 'Code', "$repo/$rev" );
		return $title;
	}

	/**
	 * @param $text string
	 * @param $review int
	 * @return string
	 */
	protected function previewComment( $text, $review = 0 ) {
		$comment = $this->mRev->previewComment( $text, $review );
		return $this->formatComment( $comment );
	}

	/**
	 * @param  $comment CodeComment
	 * @param string $replyForm
	 * @return string
	 */
	public function formatComment( $comment, $replyForm = '' ) {
		global $wgOut, $wgLang, $wgContLang;

		if ( $comment->id === 0 ) {
			$linkId = 'cpreview';
			$permaLink = '<strong>' . wfMsgHtml( 'code-rev-inline-preview' ) . '</strong> ';
		} else {
			$linkId = 'c' . intval( $comment->id );
			$permaLink = $this->skin->link( $this->commentLink( $comment->id ), "#" );
		}

		$popts = $wgOut->parserOptions();
		$popts->setEditSection( false );
		$wgOut->parserOptions( $popts );

		return Xml::openElement( 'div',
			array(
				'class' => 'mw-codereview-comment',
				'id' => $linkId,
				'style' => $this->commentStyle( $comment ) ) ) .
			'<div class="mw-codereview-comment-meta">' .
			$permaLink .
			wfMsgHtml( 'code-rev-comment-by',
				$this->skin->userLink( $comment->user, $comment->userText ) .
				$this->skin->userToolLinks( $comment->user, $comment->userText ) ) .
			' &#160; ' .
			$wgLang->timeanddate( $comment->timestamp, true ) .
			' ' .
			$this->commentReplyLink( $comment->id ) .
			'</div>' .
			'<div class="mw-codereview-comment-text mw-content-' . $wgContLang->getDir() . '">' .
			$wgOut->parse( $this->codeCommentLinkerWiki->link( $comment->text ) ) .
			'</div>' .
			$replyForm .
			'</div>';
	}

	/**
	 * @param CodeComment $comment
	 * @return string
	 */
	protected function commentStyle( $comment ) {
		$align = wfUILang()->AlignStart();
		$depth = $comment->threadDepth();
		$margin = ( $depth - 1 ) * 48;
		return "margin-$align: ${margin}px";
	}

	/**
	 * @param $id int
	 * @return string
	 */
	protected function commentReplyLink( $id ) {
		if ( !$this->canPostComments() ) {
			return '';
		}
		$repo = $this->mRepo->getName();
		$rev = $this->mRev->getId();
		$self = SpecialPage::getTitleFor( 'Code', "$repo/$rev/reply/$id" );
		$self->setFragment( "#c$id" );
		return '[' . $this->skin->link( $self, wfMsg( 'codereview-reply-link' ) ) . ']';
	}

	protected function postCommentForm( $parent = null ) {
		global $wgUser;
		if ( $this->mPreviewText !== false && $parent === $this->mReplyTarget ) {
			$preview = $this->previewComment( $this->mPreviewText );
			$text = htmlspecialchars( $this->mPreviewText );
		} else {
			$preview = '';
			$text = $this->text;
		}

		if ( !$this->canPostComments() ) {
			return '';
		}
		return '<div class="mw-codereview-post-comment">' .
			$preview .
			Html::hidden( 'wpEditToken', $wgUser->editToken() ) .
			Html::hidden( 'path', $this->mPath ) .
			( $parent ? Html::hidden( 'wpParent', $parent ) : '' ) .
			'<div>' .
			Xml::openElement( 'textarea', array(
				'name' => "wpReply{$parent}",
				'id' => "wpReplyTo{$parent}",
				'cols' => 40,
				'rows' => 10 ) ) .
			$text .
			'</textarea>' .
			'</div>' .
			'</div>';
	}

	/**
	 * Render the bottom row of the sign-offs table containing the buttons to
	 * strike and submit sign-offs
	 *
	 * @param $signOffs array
	 * @return string HTML
	 */
	protected function signoffButtons( $signOffs ) {
		$userSignOffs = $this->getUserSignoffs( $signOffs );
		$strikeButton = count( $userSignOffs )
			? Xml::submitButton( wfMsg( 'code-signoff-strike' ), array( 'name' => 'wpStrikeSignoffs' ) )
			: '';
		$signoffText = wfMsgHtml( 'code-signoff-signoff' );
		$signoffButton = Xml::submitButton( wfMsg( 'code-signoff-submit' ), array( 'name' => 'wpSignoff' ) );
		$checks = '';

		foreach ( CodeRevision::getPossibleFlags() as $flag ) {
			$checks .= Html::input( 'wpSignoffFlags[]', $flag, 'checkbox',
				array(
					'id' => "wpSignoffFlags-$flag",
					isset( $userSignOffs[$flag] ) ? 'disabled' : '' => '',
				) ) .
				' ' . Xml::label( wfMsg( "code-signoff-flag-$flag" ), "wpSignoffFlags-$flag" ) . ' ';
		}
		return "<tr class='mw-codereview-signoffbuttons'><td colspan='4'>$strikeButton " .
			"<div class='mw-codereview-signoffchecks'>$signoffText $checks $signoffButton</div></td></tr>";
	}

	/**
	 * Gets all the current signoffs the user has against this revision
	 *
	 * @param Array $signOffs
	 * @return Array
	 */
	protected function getUserSignoffs( $signOffs ) {
		$ret = array();
		global $wgUser;
		foreach( $signOffs as $s ) {
			if ( $s->userText == $wgUser->getName() && !$s->isStruck() ) {
				$ret[$s->flag] = true;
			}
		}
		return $ret;
	}

	/**
	 * Render the bottom row of the follow-up revisions table containing the buttons and
	 * textbox to add and remove follow-up associations
	 * @param $inputName string
	 * @return string HTML
	 */
	protected function referenceButtons( $inputName ) {
		$removeButton = Xml::submitButton( wfMsg( 'code-reference-remove' ), array( 'name' => "wpRemove{$inputName}" ) );
		$associateText = wfMsgHtml( 'code-reference-associate' );
		$associateButton = Xml::submitButton( wfMsg( 'code-reference-associate-submit' ),
			array( 'name' => "wpAdd{$inputName}Submit" ) );
		$textbox = Html::input( "wpAdd{$inputName}" );
		return "<tr class='mw-codereview-associatebuttons'><td colspan='5'>$removeButton " .
			"<div class='mw-codereview-associateform'>$associateText $textbox $associateButton</div></td></tr>";
	}

	/**
	 * @return string
	 */
	protected function addActionButtons() {
		return '<div id="mw-codereview-comment-buttons">' .
			Xml::submitButton( wfMsg( 'code-rev-submit' ),
				array( 'name' => 'wpSave',
					'accesskey' => wfMsg( 'code-rev-submit-accesskey' ) )
			) . ' ' .
			Xml::submitButton( wfMsg( 'code-rev-submit-next' ),
				array( 'name' => 'wpSaveAndNext',
					'accesskey' => wfMsg( 'code-rev-submit-next-accesskey' ) )
			) . ' ' .
			Xml::submitButton( wfMsg( 'code-rev-next' ),
				array( 'name' => 'wpNext',
					'accesskey' => wfMsg( 'code-rev-next-accesskey' ) )
			) . ' ' .
			Xml::submitButton( wfMsg( 'code-rev-comment-preview' ),
				array( 'name' => 'wpPreview',
					'accesskey' => wfMsg( 'code-rev-comment-preview-accesskey' ) )
			) .
			'</div>';
	}
}
