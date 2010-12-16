<?php
/**
 * Class representing a web view of a MediaWiki page
 */
class FlaggedArticleView {
	protected $isDiffFromStable = false;
	protected $isMultiPageDiff = false;
	protected $reviewNotice = '';
	protected $reviewNotes = '';
	protected $article = null;
	protected $loaded = false;

	protected static $instance = null;

	/*
	* Get the FlaggedArticleView for this request
	*/
	public static function singleton() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	protected function __construct() { }
	protected function __clone() { }

	/*
	* Load the global FlaggedArticle instance
	*/
	protected function load() {
		if ( !$this->loaded ) {
			$this->loaded = true;
			$this->article = self::globalArticleInstance();
			if ( $this->article == null ) {
				throw new MWException( 'FlaggedArticleViewer has no context article!' );
			}
		}
	}

	/**
	 * Get the FlaggedArticle instance associated with $wgArticle/$wgTitle,
	 * or false if there isn't such a title
	 */
	public static function globalArticleInstance() {
		global $wgTitle;
		if ( !empty( $wgTitle ) ) {
			return FlaggedArticle::getTitleInstance( $wgTitle );
		}
		return null;
	}

	/**
	 * Do the config and current URL params allow
	 * for content overriding by the stable version?
	 * @returns bool
	 */
	public function pageOverride() {
		global $wgUser, $wgRequest;
		$this->load();
		# This only applies to viewing content pages
		$action = $wgRequest->getVal( 'action', 'view' );
		if ( !self::isViewAction( $action ) || !$this->article->isReviewable() )
			return false;
		# Does not apply to diffs/old revision...
		if ( $wgRequest->getVal( 'oldid' ) || $wgRequest->getVal( 'diff' ) )
			return false;
		# Explicit requests  for a certain stable version handled elsewhere...
		if ( $wgRequest->getVal( 'stableid' ) )
			return false;
		# Check user preferences
		if ( $wgUser->getOption( 'flaggedrevsstable' ) )
			return !( $wgRequest->getIntOrNull( 'stable' ) === 0 );
		# Get page configuration
		$config = $this->article->getVisibilitySettings();
		# Does the stable version override the current one?
		if ( $config['override'] ) {
			if ( FlaggedRevs::ignoreDefaultVersion() ) {
				return ( $wgRequest->getIntOrNull( 'stable' ) === 1 );
			}
			# Viewer sees stable by default
			return !( $wgRequest->getIntOrNull( 'stable' ) === 0 );
		# We are explicity requesting the stable version?
		} elseif ( $wgRequest->getIntOrNull( 'stable' ) === 1 ) {
			return true;
		}
		return false;
	}

	 /**
	 * Is this user shown the stable version by default for this page?
	 * @returns bool
	 */
	public function isStableShownByDefaultUser() {
		$this->load();
		$config = $this->article->getVisibilitySettings(); // page configuration
		return ( $config['override'] && !FlaggedRevs::ignoreDefaultVersion() );
	}
	
	 /**
	 * Is this user shown the diff-to-stable on edit for this page?
	 * @returns bool
	 */
	public function isDiffShownOnEdit() {
		global $wgUser;
		$this->load();
		return ( $wgUser->isAllowed( 'review' ) || $this->isStableShownByDefaultUser() );
	}

	 /**
	 * Is this a view page action?
	 * @param $action string
	 * @returns bool
	 */
	protected static function isViewAction( $action ) {
		return ( $action == 'view' || $action == 'purge' || $action == 'render'
			|| $action == 'historysubmit' );
	}

	 /**
	 * Output review notice
	 */
	public function displayTag() {
		global $wgOut;
		$this->load();
		// Sanity check that this is a reviewable page
		if ( $this->article->isReviewable() ) {
			$wgOut->appendSubtitle( $this->reviewNotice );
		}
		return true;
	}


	 /**
	 * Add a stable link when viewing old versions of an article that
	 * have been reviewed. (e.g. for &oldid=x urls)
	 */
	public function addStableLink() {
		global $wgRequest, $wgOut, $wgLang;
		$this->load();
		if ( !$this->article->isReviewable() || !$wgRequest->getVal( 'oldid' ) ) {
			return true;
		}
		# We may have nav links like "direction=prev&oldid=x"
		$revID = $this->article->getOldIDFromRequest();
		$frev = FlaggedRevision::newFromTitle( $this->article->getTitle(), $revID );
		# Give a notice if this rev ID corresponds to a reviewed version...
		if ( !is_null( $frev ) ) {
			$time = $wgLang->date( $frev->getTimestamp(), true );
			$flags = $frev->getTags();
			$quality = FlaggedRevs::isQuality( $flags );
			$msg = $quality ? 'revreview-quality-source' : 'revreview-basic-source';
			$tag = wfMsgExt( $msg, array( 'parseinline' ), $frev->getRevId(), $time );
			# Hide clutter
			if ( !FlaggedRevs::useSimpleUI() && !empty( $flags ) ) {
				$tag .= " " . FlaggedRevsXML::ratingToggle() .
					"<span id='mw-fr-revisionratings' style='display:block;'><br />" .
					wfMsgHtml( 'revreview-oldrating' ) .
					FlaggedRevsXML::addTagRatings( $flags ) . '</span>';
			}
			$css = 'flaggedrevs_notice plainlinks noprint';
			$tag = "<div id='mw-fr-revisiontag-old' class='$css'>$tag</div>";
			$wgOut->addHTML( $tag );
		}
		return true;
	}
	
	/**
	* @returns mixed int/false/null
	*/
	protected function getRequestedStableId() {
		global $wgRequest;
		$reqId = $wgRequest->getVal( 'stableid' );
		if ( $reqId === "best" ) {
			$reqId = FlaggedRevs::getPrimeFlaggedRevId( $this->article );
		}
		return $reqId;
	}

	 /**
	 * Replaces a page with the last stable version if possible
	 * Adds stable version status/info tags and notes
	 * Adds a quick review form on the bottom if needed
	 */
	public function setPageContent( &$outputDone, &$pcache ) {
		global $wgRequest, $wgOut, $wgLang, $wgContLang;
		$this->load();
		# Only trigger on article view for content pages, not for protect/delete/hist...
		$action = $wgRequest->getVal( 'action', 'view' );
		if ( !self::isViewAction( $action ) || !$this->article->exists() )
			return true;
		# Do not clutter up diffs any further and leave archived versions alone...
		if ( $wgRequest->getVal( 'diff' ) || $wgRequest->getVal( 'oldid' ) ) {
			return true;
		}
		# Only trigger for reviewable pages
		if ( !$this->article->isReviewable() ) {
			return true;
		}
		$simpleTag = $old = $stable = false;
		$tag = $prot = '';
		# Check the newest stable version.
		$srev = $this->article->getStableRev();
		$stableId = $srev ? $srev->getRevId() : 0;
		$frev = $srev; // $frev is the revision we are looking at
		# Check for any explicitly requested old stable version...
		$reqId = $this->getRequestedStableId();
		if ( $reqId ) {
			if ( !$stableId ) {
				$reqId = false; // must be invalid
			# Treat requesting the stable version by ID as &stable=1
			} else if ( $reqId != $stableId ) {
				$old = true; // old reviewed version requested by ID
				$frev = FlaggedRevision::newFromTitle( $this->article->getTitle(),
					$reqId, FR_TEXT );
				if ( !$frev ) {
					$reqId = false; // invalid ID given
				}
			} else {
				$stable = true; // stable version requested by ID
			}
		}
		// $reqId is null if nothing requested, false if invalid
		if ( $reqId === false ) {
			$wgOut->addWikiText( wfMsg( 'revreview-invalid' ) );
			$wgOut->returnToMain( false, $this->article->getTitle() );
			# Tell MW that parser output is done
			$outputDone = true;
			$pcache = false;
			return true;
		}
		// Is the page config altered?
		$prot = FlaggedRevsXML::lockStatusIcon( $this->article );
		// Is there no stable version?
		if ( is_null( $frev ) ) {
			# Add "no reviewed version" tag, but not for printable output
			$this->showUnreviewedPage( $tag, $prot );
			return true;
		}
		# Get flags and date
		$time = $wgLang->date( $frev->getTimestamp(), true );
		$flags = $frev->getTags();
		# Get quality level
		$quality = FlaggedRevs::isQuality( $flags );
		$pristine = FlaggedRevs::isPristine( $flags );
		// Looking at some specific old stable revision ("&stableid=x")
		// set to override given the relevant conditions. If the user is
		// requesting the stable revision ("&stableid=x"), defer to override
		// behavior below, since it is the same as ("&stable=1").
		if ( $old ) {
			$this->showOldReviewedVersion( $srev, $frev, $tag, $prot );
			$outputDone = true; # Tell MW that parser output is done
			$pcache = false;
		// Stable version requested by ID or relevant conditions met to
		// to override page view.
		} else if ( $stable || $this->pageOverride() ) {
	   		$this->showStableVersion( $srev, $tag, $prot );
			$outputDone = true; # Tell MW that parser output is done
			$pcache = false;
		// Looking at some specific old revision (&oldid=x) or if FlaggedRevs is not
		// set to override given the relevant conditions (like &stable=0) or there
		// is no stable version.
		} else {
	   		$this->showDraftVersion( $srev, $tag, $prot );
		}
		# Some checks for which tag CSS to use
		if ( FlaggedRevs::useSimpleUI() ) $tagClass = 'flaggedrevs_short';
		elseif ( $simpleTag ) $tagClass = 'flaggedrevs_notice';
		elseif ( $pristine ) $tagClass = 'flaggedrevs_pristine';
		elseif ( $quality ) $tagClass = 'flaggedrevs_quality';
		else $tagClass = 'flaggedrevs_basic';
		# Wrap tag contents in a div
		if ( $tag != '' ) {
			$rtl = $wgContLang->isRTL() ? " rtl" : ""; // RTL langauges
			$tag = "<div id='mw-fr-revisiontag' class='{$tagClass}{$rtl} plainlinks noprint'>" .
				"$tag</div>";
			$this->reviewNotice .= $tag;
		}
		return true;
	}
	
	// For pages that have a stable version, index only that version
	public function setRobotPolicy() {
		global $wgOut;
		if ( !$this->article->isReviewable() || !$this->article->getStableRev() ) {
			return true; // page has no stable version
		}
		if ( !$this->pageOverride() && $this->article->isStableShownByDefault() ) {
			# Index the stable version only if it is the default
			$wgOut->setRobotPolicy( 'noindex,nofollow' );
		}
		return true;
	}

	/**
	* @param $tag review box/bar info
	* @param $prot protection notice
	* Tag output function must be called by caller
	*/
	protected function showUnreviewedPage( $tag, $prot ) {
		global $wgOut, $wgContLang;
		if ( $wgOut->isPrintable() ) {
			return;
		}
		$icon = FlaggedRevsXML::draftStatusIcon();
		// Simple icon-based UI
		if ( FlaggedRevs::useSimpleUI() ) {
			// RTL langauges
			$rtl = $wgContLang->isRTL() ? " rtl" : "";
			$tag .= $prot . $icon . wfMsgExt( 'revreview-quick-none', array( 'parseinline' ) );
			$css = "flaggedrevs_short{$rtl} plainlinks noprint";
			$this->reviewNotice .= "<div id='mw-fr-revisiontag' class='$css'>$tag</div>";
		// Standard UI
		} else {
			$css = 'flaggedrevs_notice plainlinks noprint';
			$tag = "<div id='mw-fr-revisiontag' class='$css'>" .
				$prot . $icon . wfMsgExt( 'revreview-noflagged', array( 'parseinline' ) ) .
				"</div>";
			$this->reviewNotice .= $tag;
		}
	}
	
	/**
	* @param $srev stable version
	* @param $tag review box/bar info
	* @param $prot protection notice icon
	* Tag output function must be called by caller
	* Parser cache control deferred to caller
	*/
	protected function showDraftVersion( $srev, &$tag, $prot ) {
		global $wgUser, $wgOut, $wgLang, $wgRequest;
		$this->load();
		$flags = $srev->getTags();
		$time = $wgLang->date( $srev->getTimestamp(), true );
		# Get quality level
		$quality = FlaggedRevs::isQuality( $flags );
		$pristine = FlaggedRevs::isPristine( $flags );
		# Get stable version sync status
		$synced = FlaggedRevs::stableVersionIsSynced( $srev, $this->article );
		if ( $synced ) {
			$this->setReviewNotes( $srev ); // Still the same
		} else {
			$this->maybeShowTopDiff( $srev, $quality ); // user may want diff (via prefs)
		}
		# If they are synced, do special styling
		$simpleTag = !$synced;
		# Give notice to newer users if an unreviewed edit was completed...
		if ( !$synced && $wgRequest->getVal( 'shownotice' ) && !$wgUser->isAllowed( 'review' ) ) {
			$revsSince = FlaggedRevs::getRevCountSince( $this->article, $srev->getRevId() );
			$tooltip = wfMsgHtml( 'revreview-draft-title' );
			$pending = $prot . FlaggedRevsXML::draftStatusIcon() .
				wfMsgExt( 'revreview-edited', array( 'parseinline' ), $srev->getRevId(), $revsSince );
			$anchor = $wgRequest->getVal( 'fromsection' );
			if( $anchor != null ) {
				$section = str_replace( '_', ' ', $anchor ); // prettify
				$pending .= wfMsgExt( 'revreview-edited-section', 'parse', $anchor, $section );
			}
			# Notice should always use subtitle
			$this->reviewNotice = "<div id='mw-fr-reviewnotice' " .
				"class='flaggedrevs_preview plainlinks'>$pending</div>";
		# Construct some tagging for non-printable outputs. Note that the pending
		# notice has all this info already, so don't do this if we added that already.
		# Also, if low profile UI is enabled and the page is synced, skip the tag.
		} else if ( !$wgOut->isPrintable() && !( $this->article->lowProfileUI() && $synced ) ) {
			$revsSince = FlaggedRevs::getRevCountSince( $this->article, $srev->getRevId() );
			// Simple icon-based UI
			if ( FlaggedRevs::useSimpleUI() ) {
				if ( !$wgUser->getId() ) {
					$msgHTML = ''; // Anons just see simple icons
				} else if ( $synced ) {
					$msg = $quality
						? 'revreview-quick-quality-same'
						: 'revreview-quick-basic-same';
					$msgHTML = wfMsgExt( $msg, array( 'parseinline' ),
						$srev->getRevId(), $revsSince );
				} else {
					$msg = $quality
						? 'revreview-quick-see-quality'
						: 'revreview-quick-see-basic';
					$msgHTML = wfMsgExt( $msg, array( 'parseinline' ),
						$srev->getRevId(), $revsSince );
				}
				$icon = '';
				# For protection based configs, show lock only if it's not redundant.
				if ( $this->showRatingIcon() ) {
					$icon = $synced
						? FlaggedRevsXML::stableStatusIcon( $quality )
						: FlaggedRevsXML::draftStatusIcon();
				}
				$msgHTML = $prot . $icon . $msgHTML;
				$tag .= FlaggedRevsXML::prettyRatingBox( $srev, $msgHTML,
					$revsSince, 'draft', $synced, false );
			// Standard UI
			} else {
				if ( $synced ) {
					if ( $quality ) {
						$msg = 'revreview-quality-same';
					} else {
						$msg = 'revreview-basic-same';
					}
					$msgHTML = wfMsgExt( $msg, array( 'parseinline' ),
						$srev->getRevId(), $time, $revsSince );
				} else {
					$msg = $quality
						? 'revreview-newest-quality'
						: 'revreview-newest-basic';
					$msg .= ( $revsSince == 0 ) ? '-i' : '';
					$msgHTML = wfMsgExt( $msg, array( 'parseinline' ),
						$srev->getRevId(), $time, $revsSince );
				}
				$icon = $synced
					? FlaggedRevsXML::stableStatusIcon( $quality )
					: FlaggedRevsXML::draftStatusIcon();
				$tag .= $prot . $icon . $msgHTML;
			}
		}
	}
	
	/**
	* @param $srev stable version
	* @param $frev selected flagged revision
	* @param $tag review box/bar info
	* @param $prot protection notice icon
	* Tag output function must be called by caller
	* Parser cache control deferred to caller
	*/
	protected function showOldReviewedVersion( $srev, $frev, &$tag, $prot ) {
		global $wgUser, $wgOut, $wgLang;
		$this->load();
		$flags = $frev->getTags();
		$time = $wgLang->date( $frev->getTimestamp(), true );
		# Set display revision ID
		$wgOut->setRevisionId( $frev->getRevId() );
		# Get quality level
		$quality = FlaggedRevs::isQuality( $flags );
		$pristine = FlaggedRevs::isPristine( $flags );
		$text = $frev->getRevText();
		# Check if this is a redirect...
		$redirHtml = $this->getRedirectHtml( $text );
		if ( $redirHtml == '' ) {
			$parserOut = FlaggedRevs::parseStableText( $this->article, $text, $frev->getRevId() );
		}
		# Construct some tagging for non-printable outputs. Note that the pending
		# notice has all this info already, so don't do this if we added that already.
		if ( !$wgOut->isPrintable() ) {
			// Simple icon-based UI
			if ( FlaggedRevs::useSimpleUI() ) {
				$icon = '';
				# For protection based configs, show lock only if it's not redundant.
				if ( $this->showRatingIcon() ) {
					$icon = FlaggedRevsXML::stableStatusIcon( $quality );
				}
				$revsSince = FlaggedRevs::getRevCountSince( $this->article, $srev->getRevId() );
				if ( !$wgUser->getId() ) {
					$msgHTML = ''; // Anons just see simple icons
				} else {
					$msg = $quality
						? 'revreview-quick-quality-old'
						: 'revreview-quick-basic-old';
					$msgHTML = wfMsgExt( $msg, array( 'parseinline' ), $frev->getRevId(), $time );
				}
				$msgHTML = $prot . $icon . $msgHTML;
				$tag = FlaggedRevsXML::prettyRatingBox( $frev, $msgHTML,
					$revsSince, 'oldstable', false /*synced*/ );
			// Standard UI
			} else {
				$icon = FlaggedRevsXML::stableStatusIcon( $quality );
				$msg = $quality
					? 'revreview-quality-old'
					: 'revreview-basic-old';
				$tag = $prot . $icon .
					wfMsgExt( $msg, array( 'parseinline' ), $frev->getRevId(), $time );
				# Hide clutter
				if ( !empty( $flags ) ) {
					$tag .= " " . FlaggedRevsXML::ratingToggle();
					$tag .= "<span id='mw-fr-revisionratings' style='display:block;'><br />" .
						wfMsgHtml( 'revreview-oldrating' ) .
						FlaggedRevsXML::addTagRatings( $flags ) . '</span>';
				}
			}
		}
		# Output HTML
		$this->setReviewNotes( $frev );
	   	if ( $redirHtml != '' ) {
			$wgOut->addHtml( $redirHtml );
		} else {
			$wgOut->addParserOutput( $parserOut );
		}
	}

	/**
	* @param $srev stable version
	* @param $tag review box/bar info
	* @param $prot protection notice
	* Tag output function must be called by caller
	* Parser cache control deferred to caller
	*/
	protected function showStableVersion( $srev, &$tag, $prot ) {
		global $wgOut, $wgLang, $wgUser;
		$this->load();
		$flags = $srev->getTags();
		$time = $wgLang->date( $srev->getTimestamp(), true );
		# Set display revision ID
		$wgOut->setRevisionId( $srev->getRevId() );
		# Get quality level
		$quality = FlaggedRevs::isQuality( $flags );
		$pristine = FlaggedRevs::isPristine( $flags );
		# Get parsed stable version
		$redirHtml = '';
		$parserOut = FlaggedRevs::getPageCache( $this->article, $wgUser );
		if ( $parserOut == false ) {
			$text = $srev->getRevText();
			# Check if this is a redirect...
			$redirHtml = $this->getRedirectHtml( $text );
			if ( $redirHtml == '' ) {
				$parserOut = FlaggedRevs::parseStableText(
					$this->article, $text, $srev->getRevId() );
				# Update the stable version cache
				FlaggedRevs::updatePageCache( $this->article, $wgUser, $parserOut );
			}
	   	}
		$synced = FlaggedRevs::stableVersionIsSynced( $srev, $this->article, $parserOut, null );
		# Construct some tagging
		if ( !$wgOut->isPrintable() && !( $this->article->lowProfileUI() && $synced ) ) {
			$revsSince = FlaggedRevs::getRevCountSince( $this->article, $srev->getRevId() );
			// Simple icon-based UI
			if ( FlaggedRevs::useSimpleUI() ) {
				$icon = '';
				# For protection based configs, show lock only if it's not redundant.
				if ( $this->showRatingIcon() ) {
					$icon = FlaggedRevsXML::stableStatusIcon( $quality );
				}
				if ( !$wgUser->getId() ) {
					$msgHTML = ''; // Anons just see simple icons
				} else {
					$msg = $quality
						? 'revreview-quick-quality'
						: 'revreview-quick-basic';
					# Uses messages 'revreview-quick-quality-same', 'revreview-quick-basic-same'
					$msg = $synced ? "{$msg}-same" : $msg;
					$msgHTML = wfMsgExt( $msg, array( 'parseinline' ),
						$srev->getRevId(), $revsSince );
				}
				$msgHTML = $prot . $icon . $msgHTML;
				$tag = FlaggedRevsXML::prettyRatingBox( $srev, $msgHTML,
					$revsSince, 'stable', $synced );
			// Standard UI
			} else {
				$icon = FlaggedRevsXML::stableStatusIcon( $quality );
				$msg = $quality ? 'revreview-quality' : 'revreview-basic';
				if ( $synced ) {
					# uses messages 'revreview-quality-same', 'revreview-basic-same'
					$msg .= '-same';
				} elseif ( $revsSince == 0 ) {
					# uses messages 'revreview-quality-i', 'revreview-basic-i'
					$msg .= '-i';
				}
				$tag = $prot . $icon .
					wfMsgExt( $msg, array( 'parseinline' ), $srev->getRevId(), $time, $revsSince );
				if ( !empty( $flags ) ) {
					$tag .= " " . FlaggedRevsXML::ratingToggle();
					$tag .= "<span id='mw-fr-revisionratings' style='display:block;'><br />" .
						FlaggedRevsXML::addTagRatings( $flags ) . '</span>';
				}
			}
		}
		# Output HTML
		$this->setReviewNotes( $srev );
		if ( $redirHtml != '' ) {
			$wgOut->addHtml( $redirHtml );
		} else {
			$wgOut->addParserOutput( $parserOut );
		}
	}
	
	protected function getRedirectHtml( $text ) {
		$rTarget = $this->article->followRedirectText( $text );
		if ( $rTarget ) {
			return $this->article->viewRedirect( $rTarget );
		}
		return '';
	}
	
	// Show icons for draft/stable/old reviewed versions
	protected function showRatingIcon() {
		if ( FlaggedRevs::forDefaultVersionOnly() ) {
			// If there is only on quality level and we have tabs to know
			// which version we are looking at, then just use the lock icon...
			return ( !FlaggedRevs::versionTabsShown() || FlaggedRevs::qualityVersions() );
		}
		return true;
	}

	/**
	* @param FlaggedRevision $srev, stable version
	* @param bool $quality, revision is quality
	* @returns bool, diff added to output
	*/
	protected function maybeShowTopDiff( $srev, $quality ) {
		global $wgUser, $wgOut;
		$this->load();
		if ( !$wgUser->getBoolOption( 'flaggedrevsviewdiffs' ) )
			return false; // nothing to do here
		if ( !$wgUser->isAllowed( 'review' ) )
			return false; // does not apply to this user
		# Diff should only show for the draft
		$oldid = $this->article->getOldIDFromRequest();
		$latest = $this->article->getLatest();
		if ( $oldid && $oldid != $latest ) {
			return false; // not viewing the draft
		}
		# Conditions are met to show diff...
		$leftNote = $quality
			? 'revreview-hist-quality'
			: 'revreview-hist-basic';
		$rClass = FlaggedRevsXML::getQualityColor( false );
		$lClass = FlaggedRevsXML::getQualityColor( (int)$quality );
		$rightNote = "<span id='mw-fr-diff-rtier' class='$rClass'>[" .
			wfMsgHtml( 'revreview-hist-draft' ) . "]</span>";
		$leftNote = "<span id='mw-fr-diff-ltier' class='$lClass'>[" .
			wfMsgHtml( $leftNote ) . "]</span>";
		# Fetch the stable and draft revision text
		$oText = $srev->getRevText();
		if ( $oText === false )
			return false; // deleted revision or something?
		$nText = $this->article->getContent();
		if ( $nText === false )
			return false; // deleted revision or something?
		# Build diff at the top of the page
		if ( strcmp( $oText, $nText ) !== 0 ) {
			$diffEngine = new DifferenceEngine();
			$diffEngine->showDiffStyle();
			$n = $this->article->getTitle()->countRevisionsBetween( $srev->getRevId(), $latest );
			if ( $n ) {
				$multiNotice = "<tr><td colspan='4' align='center' class='diff-multi'>" .
					wfMsgExt( 'diff-multi', array( 'parse' ), $n ) . "</td></tr>";
			} else {
				$multiNotice = '';
			}
			$wgOut->addHTML(
				"<div>" .
				"<table border='0' width='98%' cellpadding='0' cellspacing='4' class='diff'>" .
				"<col class='diff-marker' />" .
				"<col class='diff-content' />" .
				"<col class='diff-marker' />" .
				"<col class='diff-content' />" .
				"<tr>" .
					"<td colspan='2' width='50%' align='center' class='diff-otitle'><b>" .
						$leftNote . "</b></td>" .
					"<td colspan='2' width='50%' align='center' class='diff-ntitle'><b>" .
						$rightNote . "</b></td>" .
				"</tr>" .
				$multiNotice .
				$diffEngine->generateDiffBody( $oText, $nText ) .
				"</table>" .
				"</div>\n"
			);
			$this->isDiffFromStable = true;
			return true;
		}
		return false;
	}

	/**
	 * Get the normal and display files for the underlying ImagePage.
	 * If the a stable version needs to be displayed, this will set $normalFile
	 * to the current version, and $displayFile to the desired version.
	 *
	 * If no stable version is required, the reference parameters will not be set
	 *
	 * Depends on $wgRequest
	 */
	public function imagePageFindFile( &$normalFile, &$displayFile ) {
		global $wgRequest, $wgArticle;
		$this->load();
		# Determine timestamp. A reviewed version may have explicitly been requested...
		$frev = null;
		$time = false;
		if ( $reqId = $wgRequest->getVal( 'stableid' ) ) {
			$frev = FlaggedRevision::newFromTitle( $this->article->getTitle(), $reqId );
		} elseif ( $this->pageOverride() ) {
			$frev = $this->article->getStableRev();
		}
		if ( !is_null( $frev ) ) {
			$time = $frev->getFileTimestamp();
			// B/C, may be stored in associated image version metadata table
			if ( !$time ) {
				$dbr = wfGetDB( DB_SLAVE );
				$time = $dbr->selectField( 'flaggedimages',
					'fi_img_timestamp',
					array( 'fi_rev_id' => $frev->getRevId(),
						'fi_name' => $this->article->getTitle()->getDBkey() ),
					__METHOD__
				);
			}
			# NOTE: if not found, this will use the current
			$wgArticle = new ImagePage( $this->article->getTitle(), $time );
		}
		if ( !$time ) {
			# Try request parameter
			$time = $wgRequest->getVal( 'filetimestamp', false );
		}

		if ( !$time ) {
			return; // Use the default behaviour
		}

		$title = $this->article->getTitle();
		$displayFile = wfFindFile( $title, array( 'time' => $time ) );
		# If none found, try current
		if ( !$displayFile ) {
			wfDebug( __METHOD__ . ": {$title->getPrefixedDBkey()}: $time not found, using current\n" );
			$displayFile = wfFindFile( $title );
			# If none found, use a valid local placeholder
			if ( !$displayFile ) {
				$displayFile = wfLocalFile( $title ); // fallback to current
			}
			$normalFile = $displayFile;
		# If found, set $normalFile
		} else {
			wfDebug( __METHOD__ . ": {$title->getPrefixedDBkey()}: using timestamp $time\n" );
			$normalFile = wfFindFile( $title );
		}
	}

	/**
	 * Adds stable version tags to page when viewing history
	 */
	public function addToHistView() {
		global $wgOut;
		$this->load();
		# Must be reviewable. UI may be limited to unobtrusive patrolling system.
		if ( !$this->article->isReviewable() ) {
			return true;
		}
		# Add a notice if there are pending edits...
		$frev = $this->article->getStableRev();
		if ( $frev && $frev->getRevId() < $this->article->getLatest() ) {
			$revsSince = FlaggedRevs::getRevCountSince( $this->article, $frev->getRevId() );
			$tag = "<div id='mw-fr-revisiontag-edit' class='flaggedrevs_notice plainlinks'>" .
				FlaggedRevsXML::lockStatusIcon( $this->article ) . # flag protection icon as needed
				FlaggedRevsXML::pendingEditNotice( $this->article, $frev, $revsSince ) . "</div>";
			$wgOut->addHTML( $tag );
		}
		return true;
	}

	/**
	 * Adds stable version tags to page when editing
	 */
	public function addToEditView( $editPage ) {
		global $wgRequest, $wgOut, $wgLang, $wgUser;
		$this->load();
		# Must be reviewable. UI may be limited to unobtrusive patrolling system.
		if ( !$this->article->isReviewable() ) {
			return true;
		}
		$items = array();
		$tag = $warning = $prot = '';
		# Show stabilization log
		$log = $this->stabilityLogNotice();
		if ( $log ) $items[] = $log;
		# Check the newest stable version
		$quality = 0;
		$frev = $this->article->getStableRev();
		if ( $frev ) {
			$quality = $frev->getQuality();
			# Find out revision id of base version
			$latestId = $this->article->getLatest();
			$revId = $editPage->oldid ? $editPage->oldid : $latestId;
			$isOld = ( $revId != $latestId ); // not the current rev?
			# Let new users know about review procedure a tag.
			# If the log excerpt was shown this is redundant.
			if ( !$log && !$wgUser->getId() && $this->article->isStableShownByDefault() ) {
				$items[] = wfMsgExt( 'revreview-editnotice', array( 'parseinline' ) );
			}
			# Add a notice if there are pending edits...
			if ( $frev->getRevId() != $revId ) {
				$revsSince = FlaggedRevs::getRevCountSince( $this->article, $frev->getRevId() );
				$items[] = FlaggedRevsXML::pendingEditNotice( $this->article, $frev, $revsSince );
			}
			# Show diff to stable, to make things less confusing...
			# This can be disabled via user preferences
			if ( $frev->getRevId() < $revId // changes were made
				&& $this->isDiffShownOnEdit() // stable default and user cannot review
				&& $wgUser->getBoolOption( 'flaggedrevseditdiffs' ) // not disable via prefs
			) {
				# Don't show for old revisions, diff, preview, or undo
				if ( $isOld || $editPage->section === "new"
					|| in_array( $editPage->formtype, array( 'diff', 'preview' ) ) )
				{
					return true; // nothing to show here
				}
				
				# Conditions are met to show diff...
				$leftNote = $quality
					? 'revreview-hist-quality'
					: 'revreview-hist-basic';
				$rClass = FlaggedRevsXML::getQualityColor( false );
				$lClass = FlaggedRevsXML::getQualityColor( (int)$quality );
				$rightNote = "<span id='mw-fr-diff-rtier' class='$rClass'>[" .
					wfMsgHtml( 'revreview-hist-draft' ) . "]</span>";
				$leftNote = "<span id='mw-fr-diff-ltier' class='$lClass'>[" .
					wfMsgHtml( $leftNote ) . "]</span>";
				$text = $frev->getRevText();
				# Are we editing a section?
				$section = ( $editPage->section == "" ) ?
					false : intval( $editPage->section );
				if ( $section !== false ) {
					$text = $this->article->getSection( $text, $section );
				}
				if ( $text !== false && strcmp( $text, $editPage->textbox1 ) !== 0 ) {
					$diffEngine = new DifferenceEngine();
					$diffEngine->showDiffStyle();
					$diffHtml =
						wfMsgExt( 'review-edit-diff', 'parseinline' ) . ' ' .
						FlaggedRevsXML::diffToggle() .
						"<div id='mw-fr-stablediff'>" .
						"<table border='0' width='98%' cellpadding='0' cellspacing='4' class='diff'>" .
						"<col class='diff-marker' />" .
						"<col class='diff-content' />" .
						"<col class='diff-marker' />" .
						"<col class='diff-content' />" .
						"<tr>" .
							"<td colspan='2' width='50%' align='center' class='diff-otitle'><b>" .
								$leftNote . "</b></td>" .
							"<td colspan='2' width='50%' align='center' class='diff-ntitle'><b>" .
								$rightNote . "</b></td>" .
						"</tr>" .
						$diffEngine->generateDiffBody( $text, $editPage->textbox1 ) .
						"</table>" .
						"</div>\n";
					$items[] = $diffHtml;
				}
			}
			# Output items
			if ( count( $items ) ) {
				$html = "<table class='flaggedrevs_editnotice plainlinks'>";
				foreach ( $items as $item ) {
					$html .= '<tr><td>' . $item . '</td></tr>';
				}
				$html .= '</table>';
				$wgOut->addHTML( $html );
			}
		}
		return true;
	}
	
	protected function stabilityLogNotice() {
		$this->load();
		$s = '';
		# Only for pages manually made to be stable...
		if ( $this->article->isPageLocked() ) {
			$s = wfMsgExt( 'revreview-locked', 'parseinline' );
			$logHtml = '';
			LogEventsList::showLogExtract( $logHtml, 'stable',
				$this->article->getTitle()->getPrefixedText(), '', array( 'lim' => 1 ) );
			$s .= $logHtml;
		# ...or unstable
		} elseif ( $this->article->isPageUnlocked() ) {
			$s = wfMsgExt( 'revreview-unlocked', 'parseinline' );
			$logHtml = '';
			LogEventsList::showLogExtract( $logHtml, 'stable',
				$this->article->getTitle()->getPrefixedText(), '', array( 'lim' => 1 ) );
			$s .= $logHtml;
		}
		return $s;
	}
	
	public function addToNoSuchSection( $editPage, &$s ) {
		$this->load();
		if( !$this->article->isReviewable() ) {
			return true; // nothing to do
		}
		$frev = $this->article->getStableRev();
		if( $frev ) {
			$revsSince = FlaggedRevs::getRevCountSince( $this->article, $frev->getRevId() );
			if( $revsSince ) {
				$s .= "<div class='flaggedrevs_editnotice plainlinks'>" .
					wfMsgExt( 'revreview-pending-nosection', array( 'parseinline' ),
						$frev->getRevId(), $revsSince ) . "</div>";
			}
		}
		return true;
	}

	/**
	 * Add unreviewed pages links
	 */
	public function addToCategoryView() {
		global $wgOut, $wgUser;
		$this->load();
		if ( !$wgUser->isAllowed( 'review' ) ) {
			return true;
		}
		$category = $this->article->getTitle()->getText();

		$unreviewed = SpecialPage::getTitleFor( 'UnreviewedPages' );
		$unreviewedLink = $wgUser->getSkin()->makeKnownLinkObj( $unreviewed,
			wfMsgHtml( 'unreviewedpages' ), 'category=' . urlencode( $category ) );

		$oldreviewed = SpecialPage::getTitleFor( 'OldReviewedPages' );
		$oldreviewedLink = $wgUser->getSkin()->makeKnownLinkObj( $oldreviewed,
			wfMsgHtml( 'oldreviewedpages' ), 'category=' . urlencode( $category ) );

		$wgOut->appendSubtitle(
			"<span id='mw-fr-category-oldreviewed'>$unreviewedLink / $oldreviewedLink</span>"
		);
		return true;
	}

	 /**
	 * Add review form to pages when necessary
	 */
	public function addReviewForm( &$data ) {
		global $wgRequest, $wgUser, $wgOut;
		$this->load();
		# User must have review rights and page must be reviewable
		if ( !$wgUser->isAllowed( 'review' ) || !$this->article->exists()
			|| !$this->article->isReviewable() )
		{
			return true;
		}
		# Avoid multi-page diffs that are useless and misbehave (bug 19327)
		if ( $this->isMultiPageDiff ) {
			return true;
		}
		# Check action and if page is protected
		$action = $wgRequest->getVal( 'action', 'view' );
		# Must be view/diff action...
		if ( !self::isViewAction( $action ) ) {
			return true;
		}
		# Place the form at the top or bottom as most convenient
		$onTop = $wgRequest->getVal( 'diff' ) || $this->isDiffFromStable;
		$this->addQuickReview( $data, $onTop, false );
		return true;
	}

	 /**
	 * Add link to stable version setting to protection form
	 */
	public function addVisibilityLink( &$data ) {
		global $wgUser, $wgRequest, $wgOut;
		$this->load();
		if ( FlaggedRevs::getProtectionLevels() )
			return true; // simple custom levels set for action=protect
		# Check only if the title is reviewable
		if ( !FlaggedRevs::inReviewNamespace( $this->article->getTitle() ) ) {
			return true;
		}
		$action = $wgRequest->getVal( 'action', 'view' );
		if ( $action == 'protect' || $action == 'unprotect' ) {
			$title = SpecialPage::getTitleFor( 'Stabilization' );
			# Give a link to the page to configure the stable version
			$frev = $this->article->getStableRev();
			if ( $frev && $frev->getRevId() == $this->article->getLatest() ) {
				$wgOut->prependHTML( "<span class='plainlinks'>" .
					wfMsgExt( 'revreview-visibility', array( 'parseinline' ),
						$title->getPrefixedText() ) . "</span>" );
			} elseif ( $frev ) {
				$wgOut->prependHTML( "<span class='plainlinks'>" .
					wfMsgExt( 'revreview-visibility2', array( 'parseinline' ),
						$title->getPrefixedText() ) . "</span>" );
			} else {
				$wgOut->prependHTML( "<span class='plainlinks'>" .
					wfMsgExt( 'revreview-visibility3', array( 'parseinline' ),
						$title->getPrefixedText() ) . "</span>" );
			}
		}
		return true;
	}

	/**
	 * Modify an array of action links, as used by SkinTemplateNavigation and
	 * SkinTemplateTabs, to inlude flagged revs UI elements
	 */
	public function setActionTabs( $skin, &$actions ) {
		global $wgUser;
		$this->load();
		if ( FlaggedRevs::getProtectionLevels() ) {
			return true; // simple custom levels set for action=protect
		}
		$title = $this->article->getTitle()->getSubjectPage();
		if ( !FlaggedRevs::inReviewNamespace( $title ) ) {
			return true; // Only reviewable pages need these tabs
		}
		// Check if we should show a stabilization tab
		if (
			!$skin->mTitle->isTalkPage() &&
			is_array( $actions ) &&
			!isset( $actions['protect'] ) &&
			!isset( $actions['unprotect'] ) &&
			$wgUser->isAllowed( 'stablesettings' ) &&
			$title->exists()
		) {
			$stableTitle = SpecialPage::getTitleFor( 'Stabilization' );
			// Add a tab
			$actions['default'] = array(
				'class' => false,
				'text' => wfMsg( 'stabilization-tab' ),
				'href' => $stableTitle->getLocalUrl(
					'page=' . $title->getPrefixedUrl()
				)
			);
		}
		return true;
	}
	
	/**
	 * Modify an array of view links, as used by SkinTemplateNavigation and
	 * SkinTemplateTabs, to inlude flagged revs UI elements
	 */
	public function setViewTabs( $skin, &$views ) {
		global $wgRequest, $wgUser;
		$this->load();
		// Get the actual content page
		$title = $this->article->getTitle()->getSubjectPage();
		$fa = FlaggedArticle::getTitleInstance( $title );

		$action = $wgRequest->getVal( 'action', 'view' );
		if ( !$fa->isReviewable() ) {
			return true; // Not a reviewable page or the UI is hidden
		}
		$flags = ( $action == 'rollback' ) ? FR_MASTER : 0;
		$srev = $fa->getStableRev( $flags );
	   	if ( !$srev ) {
			return true; // No stable revision exists
		}
		$synced = FlaggedRevs::stableVersionIsSynced( $srev, $fa );
		// Set draft tab as needed...
	   	if ( !$skin->mTitle->isTalkPage() && !$synced ) {
	   		if ( isset( $views['edit'] ) ) {
				if ( $fa->isStableShownByDefault() ) {
					$views['edit']['text'] = wfMsg( 'revreview-edit' );
				}
				if ( $this->pageOverride() ) {
					$views['edit']['href'] = $title->getLocalUrl( 'action=edit' );
				}
	   		}
	   		if ( isset( $views['viewsource'] ) ) {
				if ( $fa->isStableShownByDefault() ) {
					$views['viewsource']['text'] = wfMsg( 'revreview-source' );
				}
				if ( $this->pageOverride() ) {
					$views['viewsource']['href'] = $title->getLocalUrl( 'action=edit' );
				}
			}
	   	}
	 	if ( !FlaggedRevs::versionTabsShown() || $synced ) {
	 		// Exit, since either the stable/draft tabs should not be shown
	 		// or the page is already the most current revision
	   		return true;
	 	}
	 	$tabs = array(
	 		'stable' => array(
				'text' => wfMsg( 'revreview-stable' ), // unused
				'href' => $title->getLocalUrl( 'stable=1' ),
	 			'class' => ''
	 		),
	 		'current' => array(
				'text' => wfMsg( 'revreview-current' ),
				'href' => $title->getLocalUrl( 'stable=0&redirect=no' ),
	 			'class' => ''
	 		),
	 	);
		if ( $this->pageOverride() || $wgRequest->getVal( 'stableid' ) ) {
			// We are looking a the stable version
			$tabs['stable']['class'] = 'selected';
		} elseif (
			( self::isViewAction( $action ) || $action == 'edit' ) &&
			!$skin->mTitle->isTalkPage()
		) {
			// We are looking at the current revision or in edit mode
			$tabs['current']['class'] = 'selected';
		}
		$first = true;
		$newViews = array();
		foreach ( $views as $tabAction => $data ) {
			// Very first tab (page link)
			if ( $first ) {
				if ( $synced ) {
					// Use existing first tabs when synced
					$newViews[$tabAction] = $data;
				} else {
					// Use split current and stable tabs when not synced
					$newViews[$tabAction]['text'] = $data['text']; // keep tab name
					$newViews[$tabAction]['href'] = $tabs['stable']['href'];
					$newViews[$tabAction]['class'] = $tabs['stable']['class'];
					$newViews['current'] = $tabs['current'];
				}
				$first = false;
			} else {
				$newViews[$tabAction] = $data;
			}
	   	}
	   	// Replaces old tabs with new tabs
	   	$views = $newViews;
		return true;
	}
	
	/**
	 * @param FlaggedRevision $frev
	 * @return string, revision review notes
	 */
	public function setReviewNotes( $frev ) {
		global $wgUser;
		$this->load();
		if ( $frev && FlaggedRevs::allowComments() && $frev->getComment() != '' ) {
			$this->reviewNotes = "<br /><div class='flaggedrevs_notes plainlinks'>";
			$this->reviewNotes .= wfMsgExt( 'revreview-note', array( 'parseinline' ),
				User::whoIs( $frev->getUser() ) );
			$this->reviewNotes .= '<br /><i>' .
				$wgUser->getSkin()->formatComment( $frev->getComment() ) . '</i></div>';
		}
	}

	/**
	* When comparing the stable revision to the current after editing a page, show
	* a tag with some explaination for the diff.
	*/
	public function addDiffNoticeAndIncludes( $diff, $oldRev, $newRev ) {
		global $wgRequest, $wgUser, $wgOut, $wgMemc;
		$this->load();
		# Exempt printer-friendly output
		if ( $wgOut->isPrintable() ) {
			return true;
		}
		# Avoid multi-page diffs that are useless and misbehave (bug 19327)
		if ( $this->isMultiPageDiff ) {
			return true;
		}
		# Page must be reviewable. UI may be limited to unobtrusive patrolling system.
		if ( !$this->article->isReviewable() ) {
			return true;
		}
		# Check if this might be the diff to stable. If so, enhance it.
		if ( $newRev->isCurrent() && $oldRev ) {
			$article = new Article( $newRev->getTitle() );
			$frev = $this->article->getStableRev();
			if ( $frev && $frev->getRevId() == $oldRev->getID() ) {
				global $wgParserCacheExpireTime;
				# Check the page sync value cache...
				$key = wfMemcKey( 'flaggedrevs', 'includesSynced', $article->getId() );
				$value = FlaggedRevs::getMemcValue( $wgMemc->get( $key ), $article );
				$synced = ( $value === "true" ) ? true : false; // default as false to trigger query

				$changeList = array();

				# Try the cache. Uses format <page ID>-<UNIX timestamp>.
				$key = wfMemcKey( 'stableDiffs', 'templates', $article->getId() );
				$tmpChanges = FlaggedRevs::getMemcValue( $wgMemc->get( $key ), $article );
				if ( empty( $tmpChanges ) && !$synced ) {
					$tmpChanges = false; // don't use cache, it's not consistent
				}

				# Make a list of each changed template...
				if ( $tmpChanges === false ) {
					$tmpChanges = $this->fetchTemplateChanges( $frev );
					$wgMemc->set( $key, FlaggedRevs::makeMemcObj( $tmpChanges ),
						$wgParserCacheExpireTime );
				}
				# Add set to list
				if ( $tmpChanges )
					$changeList += $tmpChanges;

				# Try the cache. Uses format <page ID>-<UNIX timestamp>.
				$key = wfMemcKey( 'stableDiffs', 'images', $article->getId() );
				$imgChanges = FlaggedRevs::getMemcValue( $wgMemc->get( $key ), $article );
				if ( empty( $imgChanges ) && !$synced ) {
					$imgChanges = false; // don't use cache, it's not consistent
				}

				// Get list of each changed image...
				if ( $imgChanges === false ) {
					$imgChanges = $this->fetchFileChanges( $frev );
					$wgMemc->set( $key, FlaggedRevs::makeMemcObj( $imgChanges ),
						$wgParserCacheExpireTime );
				}
				if ( $imgChanges )
					$changeList += $imgChanges;

				# Some important information...
				$notice = '';
				if ( count( $changeList ) > 0 ) {
					$notice = '<br />' . wfMsgExt( 'revreview-update-use', array( 'parseinline' ) );
				} elseif ( !$synced ) {
					$diff->mTitle->invalidateCache(); // bad cache, said they were not synced
				}

				# If the user is allowed to review, prompt them!
				# Only those if there is something to actually review.
				if ( count( $changeList ) || $newRev->getId() > $oldRev->getId() ) {
					$css = 'flaggedrevs_diffnotice plainlinks';
					if ( empty( $changeList ) && $wgUser->isAllowed( 'review' ) ) {
						$wgOut->addHTML( "<div id='mw-fr-difftostable' class='$css'>" .
							wfMsgExt( 'revreview-update-none', array( 'parseinline' ) ) .
								$notice . '</div>' );
					} elseif ( !empty( $changeList ) && $wgUser->isAllowed( 'review' ) ) {
						$changeList = implode( ', ', $changeList );
						$wgOut->addHTML( "<div id='mw-fr-difftostable' class='$css'>" .
							wfMsgExt( 'revreview-update', array( 'parseinline' ) ) .
								'&nbsp;' . $changeList . $notice . '</div>' );
					} elseif ( !empty( $changeList ) ) {
						$changeList = implode( ', ', $changeList );
						$wgOut->addHTML( "<div id='mw-fr-difftostable' class='$css'>" .
							wfMsgExt( 'revreview-update-includes', array( 'parseinline' ) ) .
								'&nbsp;' . $changeList . $notice . '</div>' );
					}
				}

				# Set a key to note that someone is viewing this
				if ( $wgUser->isAllowed( 'review' ) ) {
					$key = wfMemcKey( 'stableDiffs', 'underReview',
						$oldRev->getID(), $newRev->getID() );
					$wgMemc->set( $key, '1', 10 * 60 ); // 10 min
				}
			}
		}
		$newRevQ = FlaggedRevs::getRevQuality( $newRev->getPage(), $newRev->getId() );
		$oldRevQ = $oldRev
			? FlaggedRevs::getRevQuality( $newRev->getPage(), $oldRev->getId() )
			: false;
		# Diff between two revisions
		if ( $oldRev ) {
			$wgOut->addHTML( "<table class='fr-diff-ratings'><tr>" );

			$class = FlaggedRevsXML::getQualityColor( $oldRevQ );
			if ( $oldRevQ !== false ) {
				$msg = $oldRevQ ? 'revreview-hist-quality' : 'revreview-hist-basic';
			} else {
				$msg = 'revreview-hist-draft';
			}
			$wgOut->addHTML( "<td width='50%' align='center'>" );
			$wgOut->addHTML( "<span id='mw-fr-diff-ltier' class='$class'>[" .
				wfMsgHtml( $msg ) . "]</span>" );

			$class = FlaggedRevsXML::getQualityColor( $newRevQ );
			if ( $newRevQ !== false ) {
				$msg = $newRevQ ? 'revreview-hist-quality' : 'revreview-hist-basic';
			} else {
				$msg = 'revreview-hist-draft';
			}
			$wgOut->addHTML( "</td><td width='50%' align='center'>" );
			$wgOut->addHTML( "<span id='mw-fr-diff-rtier' class='$class'>[" .
				wfMsgHtml( $msg ) . "]</span>" );

			$wgOut->addHTML( '</td></tr></table>' );
		# New page "diffs" - just one rev
		} else {
			if ( $newRevQ !== false ) {
				$msg = $newRevQ ? 'revreview-hist-quality' : 'revreview-hist-basic';
			} else {
				$msg = 'revreview-hist-draft';
			}
			$class = FlaggedRevsXML::getQualityColor( $newRevQ );
			$wgOut->addHTML(
				"<table class='fr-diff-ratings'>" .
				"<tr><td><span id='mw-fr-diff-rtier' class='$class' align='center'>" .
				'[' . wfMsgHtml( $msg ) . ']' .
				'</span></td></tr></table>'
			);
		}
		return true;
	}
	
	// Fetch template changes for a reviewed revision since review
	protected function fetchTemplateChanges( $frev ) {
		global $wgUser;
		$skin = $wgUser->getSkin();
		$dbr = wfGetDB( DB_SLAVE );
		// Get templates where the current and stable are not the same revision
		$ret = $dbr->select( array( 'flaggedtemplates', 'page', 'flaggedpages' ),
			array( 'ft_namespace', 'ft_title', 'fp_stable',
				'ft_tmp_rev_id', 'page_latest' ),
			array( 'ft_rev_id' => $frev->getRevId(),
				'page_namespace = ft_namespace',
				'page_title = ft_title' ),
			__METHOD__,
			array(), /* OPTIONS */
			array( 'flaggedpages' => array( 'LEFT JOIN', 'fp_page_id = page_id' ) )
		);
		$tmpChanges = array();
		while ( $row = $dbr->fetchObject( $ret ) ) {
			$title = Title::makeTitleSafe( $row->ft_namespace, $row->ft_title );
			$revIdDraft = $row->page_latest;
			// stable time -> time when reviewed (unless the other is newer)
			$revIdStable = isset( $row->fp_stable ) && $row->fp_stable >= $row->ft_tmp_rev_id ?
				$row->fp_stable : $row->ft_tmp_rev_id;
			// compare to current
			if ( $revIdDraft > $revIdStable ) {
				$tmpChanges[] = $skin->makeKnownLinkObj( $title,
					$title->getPrefixedText(),
					'diff=cur&oldid=' . intval( $revIdStable ) );
			}
		}
		return $tmpChanges;
	}
	
	// Fetch file changes for a reviewed revision since review
	protected function fetchFileChanges( $frev ) {
		global $wgUser;
		$skin = $wgUser->getSkin();
		$dbr = wfGetDB( DB_SLAVE );
		// Get images where the current and stable are not the same revision
		$ret = $dbr->select(
			array( 'flaggedimages', 'page', 'image', 'flaggedpages', 'flaggedrevs' ),
			array( 'fi_name', 'fi_img_timestamp', 'fr_img_timestamp' ),
			array( 'fi_rev_id' => $frev->getRevId() ),
				__METHOD__,
			array(), /* OPTIONS */
			array(
				'page' => array( 'LEFT JOIN',
					'page_namespace = ' . NS_FILE . ' AND page_title = fi_name' ),
				'image' => array( 'LEFT JOIN', 'img_name = fi_name' ),
				'flaggedpages' => array( 'LEFT JOIN', 'fp_page_id = page_id' ),
				'flaggedrevs' => array( 'LEFT JOIN',
				'fr_page_id = fp_page_id AND fr_rev_id = fp_stable' ) )
			);
		$imgChanges = array();
		while ( $row = $dbr->fetchObject( $ret ) ) {
			$title = Title::makeTitleSafe( NS_FILE, $row->fi_name );
			// stable time -> time when reviewed (unless the other is newer)
			$timestamp = isset( $row->fr_img_timestamp ) && $row->fr_img_timestamp >= $row->fi_img_timestamp ?
				$row->fr_img_timestamp : $row->fi_img_timestamp;
			// compare to current
			$file = wfFindFile( $title );
			if ( $file && $file->getTimestamp() > $timestamp ) {
				$imgChanges[] = $skin->makeKnownLinkObj( $title, $title->getPrefixedText() );
			}
		}
		return $imgChanges;
	}

	/**
	* Set $this->isDiffFromStable and $this->isMultiPageDiff fields
	*/
	public function setViewFlags( $diff, $oldRev, $newRev ) {
		$this->load();
		if ( $newRev && $oldRev ) {
			// Is this a diff between two pages?
			if ( $newRev->getPage() != $oldRev->getPage() ) {
				$this->isMultiPageDiff = true;
			// Is there a stable version?
			} else if ( $this->article->isReviewable() ) {
				$frev = $this->article->getStableRev();
				// Is this a diff of the draft rev against the stable rev?
				if ( $frev && $frev->getRevId() == $oldRev->getId() && $newRev->isCurrent() ) {
					$this->isDiffFromStable = true;
				}
			}
		}
		return true;
	}

	/**
	* Add a link to diff-to-stable for reviewable pages
	*/
	public function addDiffLink( $diff, $oldRev, $newRev ) {
		global $wgUser, $wgOut;
		$this->load();
		// Both revs must exists and the page must be reviewable
		if ( !$newRev || !$oldRev || !$this->article->isReviewable() ) {
			return true; // nothing to do
		}
		// Is there a stable version?
		$frev = $this->article->getStableRev();
		# Give a link to the diff-to-stable if needed
		if ( $frev && !$this->isDiffFromStable ) {
			$article = new Article( $newRev->getTitle() );
			# Is the stable revision using the same revision as the current?
			if ( $article->getLatest() != $frev->getRevId() ) {
				$patrol = $wgUser->getSkin()->makeKnownLinkObj(
					$newRev->getTitle(),
					wfMsgHtml( 'review-diff2stable' ),
					"oldid={$frev->getRevId()}&diff=cur&diffonly=0"
				);
				$wgOut->addHTML( "<div class='fr-diff-to-stable' align='center'>($patrol)</div>" );
			}
		}
		return true;
	}

	/**
	* Redirect users out to review the changes to the stable version.
	* Only for people who can review and for pages that have a stable version.
	*/
	public function injectPostEditURLParams( &$sectionAnchor, &$extraQuery ) {
		global $wgUser;
		$this->load();
		# Don't show this for pages that are not reviewable
		if ( !$this->article->isReviewable() ) {
			return true;
		}
		# Get the stable version, from master
		$frev = $this->article->getStableRev( FR_MASTER );
		if ( !$frev ) {
			return true;
		}
		# Get latest revision Id (lag safe)
		$latest = $this->article->getTitle()->getLatestRevID( GAID_FOR_UPDATE );
		if ( $latest == $frev->getRevId() ) {
			return true; // only for pages with pending edits
		}
		// If the edit was not autoreviewed, and the user can actually make a
		// new stable version, then go to the diff...
		if ( $frev->userCanSetFlags() ) {
			$extraQuery .= $extraQuery ? '&' : '';
			// Override diffonly setting to make sure the content is shown
			$extraQuery .= 'oldid='.intval($frev->getRevId()).'&diff=cur&diffonly=0';
		// ...otherwise, go to the current revision after completing an edit.
		// This allows for users to immediately see their changes.
		} else {
			$extraQuery .= $extraQuery ? '&' : '';
			$extraQuery .= 'stable=0';
			// Show a notice at the top of the page for non-reviewers...
			if ( !$wgUser->isAllowed( 'review' ) && $this->article->isStableShownByDefault() ) {
				$extraQuery .= '&shownotice=1';
				if( $sectionAnchor ) {
					// Pass a section parameter in the URL as needed to add a link to
					// the "your changes are pending" box on the top of the page...
					$section = str_replace(
						array( ':' , '.' ), array( '%3A', '%' ), // hack: reverse special encoding
						substr( $sectionAnchor, 1 ) // remove the '#'
					);
					$extraQuery .= '&fromsection=' . $section;
					$sectionAnchor = ''; // go to the top of the page to see notice
				}
			}
		}
		return true;
	}

	/**
	* Add a hidden revision ID field to edit form.
	* Needed for autoreview so it can select the flags from said revision.
	*/
	public function addRevisionIDField( $editPage, $out ) {
		global $wgRequest;
		$this->load();
		$article = $editPage->getArticle(); // convenience
		$latestId = $article->getLatest(); // current rev
		# Find the ID of the revision being edited
		$revId = $article->getOldID();
		if( !$revId ) { // zero oldid => current revision
			$revId = $latestId;
		}
		# If undoing a few consecutive top edits, we can treat this
		# like a revert to a base revision...find its ID...
		$undo = $wgRequest->getIntOrNull( 'undo' );
		if ( $undo === $latestId ) {
			# We are undoing all edits *after* some rev...get that rev's ID
			$revId = $wgRequest->getInt( 'undoafter',
				$article->getTitle()->getPreviousRevisionID( $latestId, GAID_FOR_UPDATE ) );
		}
		$out->addHTML( "\n" . Xml::hidden( 'baseRevId', $revId ) );
		$out->addHTML( "\n" . Xml::hidden( 'undidRev',
			empty( $editPage->undidRev ) ? 0 : $editPage->undidRev )
		);
		return true;
	}

	 /**
	 * Adds brief review notes to a page.
	 * @param OutputPage $out
	 */
	public function addReviewNotes( &$data ) {
		$this->load();
		if ( $this->reviewNotes ) {
			$data .= $this->reviewNotes;
		}
		return true;
	}

	 /**
	 * Adds a brief review form to a page.
	 * @param string $data
	 * @param bool $top, should this form always go on top?
	 * @param bool $hide
	 */
	public function addQuickReview( &$data, $top = false, $hide = false ) {
		global $wgOut, $wgUser, $wgRequest;
		$this->load();
		if ( $wgOut->isPrintable() ) {
			return false; // Must be on non-printable output 
		}
		# Get the revision being displayed
		$id = $wgOut->getRevisionId();
		if ( !$id ) {
			if ( $this->isDiffFromStable ) {
				$rev = Revision::newFromTitle( $this->article->getTitle() );
				$id = $rev->getId(); // if diff-to-stable, we know the revision is the current
			} else {
				return false; // only safe to assume current if diff-to-stable
			}
		} else {
			$rev = Revision::newFromTitle( $this->article->getTitle(), $id );
		}
		# The revision must be valid and public
		if ( !$rev || $rev->isDeleted( Revision::DELETED_TEXT ) ) {
			return false;
		}
		$useCurrent = false;
		if ( !isset( $wgOut->mTemplateIds ) || !isset( $wgOut->fr_ImageSHA1Keys ) ) {
			$useCurrent = true; // we need to get Ids from parser output
		}
		$skin = $wgUser->getSkin();

		$config = $this->article->getVisibilitySettings();
		# Variable for sites with no flags, otherwise discarded
		$approve = $wgRequest->getBool( 'wpApprove' );
		# See if the version being displayed is flagged...
		$frev = FlaggedRevision::newFromTitle( $this->article->getTitle(), $id );
		$oldFlags = $frev
			? $frev->getTags() // existing tags
			: FlaggedRevision::expandRevisionTags( '' ); // unset tags
		# If we are reviewing updates to a page, start off with the stable revision's
		# flags. Otherwise, we just fill them in with the selected revision's flags.
		if ( $this->isDiffFromStable ) {
			$srev = $this->article->getStableRev();
			$flags = $srev->getTags();
			# Check if user is allowed to renew the stable version.
			# If not, then get the flags for the new revision itself.
			if ( !RevisionReview::userCanSetFlags( $oldFlags ) ) {
				$flags = $oldFlags;
			}
			$reviewNotes = $srev->getComment();
			# Re-review button is need for template/file only review case
			$allowRereview = ($srev->getRevId() == $id)
				&& !FlaggedRevs::stableVersionIsSynced( $srev, $this->article );
		} else {
			$flags = $oldFlags;
			// Get existing notes to pre-fill field
			$reviewNotes = $frev ? $frev->getComment() : "";
			$allowRereview = false; // re-review button
		}

		# Begin form...
		$reviewTitle = SpecialPage::getTitleFor( 'RevisionReview' );
		$action = $reviewTitle->getLocalUrl( 'action=submit' );
		$params = array( 'method' => 'post', 'action' => $action, 'id' => 'mw-fr-reviewform' );
		if ( $hide ) {
			$params['class'] = 'fr-hiddenform';
		}
		$form = Xml::openElement( 'form', $params );
		$form .= Xml::openElement( 'fieldset',
			array( 'class' => 'flaggedrevs_reviewform noprint' ) );
		# Add appropriate legend text
		$legendMsg = ( FlaggedRevs::binaryFlagging() && $allowRereview )
			? 'revreview-reflag'
			: 'revreview-flag';
		$form .= Xml::openElement( 'legend', array( 'id' => 'mw-fr-reviewformlegend' ) );
		$form .= "<strong>" . wfMsgHtml( $legendMsg ) . "</strong>";
		$form .= Xml::closeElement( 'legend' ) . "\n";
		# Show explanatory text
		if ( !FlaggedRevs::lowProfileUI() ) {
			$form .= wfMsgExt( 'revreview-text', array( 'parse' ) );
		}

		# Disable form for unprivileged users
		$uneditable = !$this->article->getTitle()->quickUserCan( 'edit' );
		$disabled = !RevisionReview::userCanSetFlags( $flags ) || $uneditable;
		if ( $disabled ) {
			$form .= Xml::openElement( 'div', array( 'class' => 'fr-rating-controls-disabled',
				'id' => 'fr-rating-controls-disabled' ) );
			$toggle = array( 'disabled' => "disabled" );
		} else {
			$form .= Xml::openElement( 'div', array( 'class' => 'fr-rating-controls',
				'id' => 'fr-rating-controls' ) );
			$toggle = array();
		}

		# Add main checkboxes/selects
		$form .= Xml::openElement( 'span', array( 'id' => 'mw-fr-ratingselects' ) );
		$form .= FlaggedRevsXML::ratingInputs( $flags, $config, $disabled, (bool)$frev );
		$form .= Xml::closeElement( 'span' );
		# Add review notes input
		if ( FlaggedRevs::allowComments() && $wgUser->isAllowed( 'validate' ) ) {
			$form .= "<div id='mw-fr-notebox'>\n";
			$form .= "<p>" . wfMsgHtml( 'revreview-notes' ) . "</p>\n";
			$form .= Xml::openElement( 'textarea', array( 'name' => 'wpNotes', 'id' => 'wpNotes',
				'class' => 'fr-notes-box', 'rows' => '2', 'cols' => '80' ) ) .
				htmlspecialchars( $reviewNotes ) .
				Xml::closeElement( 'textarea' ) . "\n";
			$form .= "</div>\n";
		}

		# Get versions of templates/files used
		$imageParams = $templateParams = $fileVersion = '';
		if ( $useCurrent ) {
			# Get parsed current version
			$parserCache = ParserCache::singleton();
			$article = $this->article;
			$currentOutput = $parserCache->get( $article, $wgUser );
			if ( $currentOutput == false ) {
				global $wgParser, $wgEnableParserCache;
				$text = $article->getContent();
				$title = $article->getTitle();
				$options = FlaggedRevs::makeParserOptions();
				$currentOutput = $wgParser->parse( $text, $title, $options );
				# Might as well save the cache while we're at it
				if ( $wgEnableParserCache )
					$parserCache->save( $currentOutput, $article, $wgUser );
			}
			$templateIDs = $currentOutput->mTemplateIds;
			$imageSHA1Keys = $currentOutput->fr_ImageSHA1Keys;
		} else {
			$templateIDs = $wgOut->mTemplateIds;
			$imageSHA1Keys = $wgOut->fr_ImageSHA1Keys;
		}
		list( $templateParams, $imageParams, $fileVersion ) =
			FlaggedRevs::getIncludeParams( $this->article, $templateIDs, $imageSHA1Keys );

		$form .= Xml::openElement( 'span', array( 'style' => 'white-space: nowrap;' ) );
		# Hide comment input if needed
		if ( !$disabled ) {
			if ( count( FlaggedRevs::getDimensions() ) > 1 )
				$form .= "<br />"; // Don't put too much on one line
			$form .= "<span id='mw-fr-commentbox' style='clear:both'>" .
				Xml::inputLabel( wfMsg( 'revreview-log' ), 'wpReason', 'wpReason', 40, '',
					array( 'class' => 'fr-comment-box' ) ) . "&nbsp;&nbsp;&nbsp;</span>";
		}
		# Add the submit buttons
		$form .= FlaggedRevsXML::ratingSubmitButtons( $frev, (bool)$toggle, $allowRereview );
		# Show stability log if there is anything interesting...
		if( $this->article->isPageLocked() ) {
			$form .= ' ' . FlaggedRevsXML::logToggle();
		}
		$form .= Xml::closeElement( 'span' );
		# ..add the actual stability log body here
	    if( $this->article->isPageLocked() ) {
			$form .= FlaggedRevsXML::stabilityLogExcerpt( $this->article );
		}
		$form .= Xml::closeElement( 'div' ) . "\n";

		# Hidden params
		$form .= Xml::hidden( 'title', $reviewTitle->getPrefixedText() ) . "\n";
		$form .= Xml::hidden( 'target', $this->article->getTitle()->getPrefixedDBKey() ) . "\n";
		$form .= Xml::hidden( 'oldid', $id ) . "\n";
		$form .= Xml::hidden( 'action', 'submit' ) . "\n";
		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() ) . "\n";
		# Add review parameters
		$form .= Xml::hidden( 'templateParams', $templateParams ) . "\n";
		$form .= Xml::hidden( 'imageParams', $imageParams ) . "\n";
		$form .= Xml::hidden( 'fileVersion', $fileVersion ) . "\n";
		# Pass this in if given; useful for new page patrol
		$form .= Xml::hidden( 'rcid', $wgRequest->getVal( 'rcid' ) ) . "\n";
		# Special token to discourage fiddling...
		$checkCode = RevisionReview::validationKey(
			$templateParams, $imageParams, $fileVersion, $id
		);
		$form .= Xml::hidden( 'validatedParams', $checkCode ) . "\n";

		$form .= Xml::closeElement( 'fieldset' );
		$form .= Xml::closeElement( 'form' );
		# Place form at the correct position specified by $top
		if ( $top ) {
			$wgOut->prependHTML( $form );
		} else {
			$data .= $form;
		}
		return true;
	}

	/**
	* Updates parser cache output to included needed versioning params.
	*/
	public function maybeUpdateMainCache( &$outputDone, &$pcache ) {
		global $wgUser, $wgRequest;
		$this->load();

		$action = $wgRequest->getVal( 'action', 'view' );
		if ( $action == 'purge' )
			return true; // already purging!
		# Only trigger on article view for content pages, not for protect/delete/hist
		if ( !self::isViewAction( $action ) || !$wgUser->isAllowed( 'review' ) )
			return true;
		if ( !$this->article->exists() || !$this->article->isReviewable() )
			return true;

		$parserCache = ParserCache::singleton();
		$parserOut = $parserCache->get( $this->article, $wgUser );
		if ( $parserOut ) {
			# Clear older, incomplete, cached versions
			# We need the IDs of templates and timestamps of images used
			if ( !isset( $parserOut->fr_newestTemplateID )
				|| !isset( $parserOut->fr_newestImageTime ) )
			{
				$this->article->getTitle()->invalidateCache();
			}
		}
		return true;
	}
}
