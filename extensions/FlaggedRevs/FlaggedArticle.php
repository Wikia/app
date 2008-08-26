<?php

class FlaggedArticle extends Article {
	public $isDiffFromStable = false;
	protected $stableRev = null;
	protected $pageConfig = null;
	protected $flags = null;
	protected $reviewNotice = '';
	protected $reviewNotes = '';
	protected $file = NULL;
	protected $parent;

	/**
	 * Get the FlaggedArticle instance associated with $wgArticle/$wgTitle,
	 * or false if there isn't such a title
	 */
	public static function getGlobalInstance() {
		global $wgArticle, $wgTitle;
		if ( !empty( $wgArticle ) ) {
			return self::getInstance( $wgArticle );
		} elseif ( !empty( $wgTitle ) ) {
			return self::getTitleInstance( $wgTitle );
		} else {
			return false;
		}
	}

	/**
	 * Get a FlaggedArticle for a given title.
	 * getInstance() is preferred if you have an Article available.
	 */
	public static function getTitleInstance( $title ) {
		if ( !isset( $title->flaggedRevsArticle ) ) {
			$article = MediaWiki::articleFromTitle( $title );
			$article->flaggedRevsArticle = new FlaggedArticle( $article );
			$title->flaggedRevsArticle =& $article->flaggedRevsArticle;
		}
		return $title->flaggedRevsArticle;
	}

	/**
	 * Get an instance of FlaggedArticle for a given Article or Title object
	 * @param Article $article
	 */
	public static function getInstance( $article ) {
		# If instance already cached, return it!
		if( isset($article->flaggedRevsArticle) ) {
			return $article->flaggedRevsArticle;
		}
		if( isset( $article->getTitle()->flaggedRevsArticle ) ) {
			// Already have a FlaggedArticle cached in the Title object
			$article->flaggedRevsArticle =& $article->getTitle()->flaggedRevsArticle;
		} else {
			// Create new FlaggedArticle
			$article->flaggedRevsArticle = new FlaggedArticle( $article );
			$article->getTitle()->flaggedRevsArticle =& $article->flaggedRevsArticle;
		}
		return $article->flaggedRevsArticle;
	}

	/**
	 * Construct a new FlaggedArticle from its Article parent
	 * Should not be called directly, use FlaggedArticle::getInstance()
	 */
	function __construct( $parent ) {
		$this->parent = $parent;
		wfLoadExtensionMessages( 'FlaggedRevs' );
	}

	/**
	 * Does the config and current URL params allow
	 * for overriding by stable revisions?
	 */
	public function pageOverride() {
		global $wgUser, $wgRequest;
		# This only applies to viewing content pages
		$action = $wgRequest->getVal( 'action', 'view' );
		if( ($action !='view' && $action !='purge') || !$this->isReviewable() )
			return false;
		# Does not apply to diffs/old revision. Explicit requests
		# for a certain stable version will be handled elsewhere.
		if( $wgRequest->getVal('oldid') || $wgRequest->getVal('diff') || $wgRequest->getVal('stableid') )
			return false;
		# Check user preferences
		if( $wgUser->getOption('flaggedrevsstable') )
			return !( $wgRequest->getIntOrNull('stable') === 0 );
		# Get page configuration
		$config = $this->getVisibilitySettings();
		# Does the stable version override the current one?
		if( $config['override'] ) {
			if( FlaggedRevs::ignoreDefaultVersion() ) {
				return ( $wgRequest->getIntOrNull('stable') === 1 );
			}
			# Viewer sees stable by default
			return !( $wgRequest->getIntOrNull('stable') === 0 );
		# We are explicity requesting the stable version?
		} else if( $wgRequest->getIntOrNull('stable') === 1 ) {
			return true;
		}
		return false;
	}

	 /**
	 * Is the stable version shown by default for this page?
	 */
	public function showStableByDefault() {
		# Get page configuration
		$config = $this->getVisibilitySettings();
		return (bool)$config['override'];
	}
	
	 /**
	 * Is this user shown the stable version by default for this page?
	 */
	public function showStableByDefaultUser() {
		# Get page configuration
		$config = $this->getVisibilitySettings();
		return ( $config['override'] && !FlaggedRevs::ignoreDefaultVersion() );
	}

	/**
	 * Is this page less open than the site defaults?
	 * @returns bool
	 */
	public function isPageLocked() {
		return ( !FlaggedRevs::showStableByDefault() && $this->showStableByDefault() );
	}

	/**
	 * Is this page more open than the site defaults?
	 * @returns bool
	 */
	public function isPageUnlocked() {
		return ( FlaggedRevs::showStableByDefault() && !$this->showStableByDefault() );
	}

	/**
	 * Should tags only be shown for unreviewed content for this user?
	 * @returns bool
	 */
	public function lowProfileUI() {
		return FlaggedRevs::lowProfileUI() && FlaggedRevs::showStableByDefault() == $this->showStableByDefault();
	}

	 /**
	 * Is this article reviewable?
	 */
	public function isReviewable() {
		return FlaggedRevs::isPageReviewable( $this->parent->getTitle() );
	}
	
	 /**
	 * Is this article rateable?
	 */
	public function isRateable() {
		return FlaggedRevs::isPageRateable( $this->parent->getTitle() );
	}

	 /**
	 * Output review notice
	 */
	private function displayTag() {
		global $wgOut;
		$wgOut->appendSubtitle( $this->reviewNotice );
		return true;
	}


	 /**
	 * Add a stable link when viewing old versions of an article that
	 * have been reviewed. (e.g. for &oldid=x urls)
	 */
	public function addStableLink() {
		global $wgRequest, $wgOut, $wgLang;
		if( $wgRequest->getVal('oldid') ) {
			# We may have nav links like "direction=prev&oldid=x"
			$revID = $this->parent->getOldIDFromRequest();
			$frev = FlaggedRevision::newFromTitle( $this->parent->getTitle(), $revID );
			# Give a notice if this rev ID corresponds to a reviewed version...
			if( !is_null($frev) ) {
				$time = $wgLang->date( $frev->getTimestamp(), true );
				$flags = $frev->getTags();
				$quality = FlaggedRevs::isQuality( $flags );
				$msg = $quality ? 'revreview-quality-source' : 'revreview-basic-source';
				$tag = wfMsgExt( $msg, array('parseinline'), $frev->getRevId(), $time );
				# Hide clutter
				if( !FlaggedRevs::useSimpleUI() && !empty($flags) ) {
					$tag .= " " . FlaggedRevsXML::ratingToggle() . "<span id='mw-revisionratings' style='display:block;'>" .
						"<br/>" . wfMsgHtml('revreview-oldrating') . FlaggedRevsXML::addTagRatings( $flags ) . '</span>';
				}
				$tag = "<div id='mw-revisiontag-old' class='flaggedrevs_notice plainlinks noprint'>$tag</div>";
				$wgOut->addHTML( $tag );
			}
		}
		return true;
	}

	 /**
	 * Replaces a page with the last stable version if possible
	 * Adds stable version status/info tags and notes
	 * Adds a quick review form on the bottom if needed
	 */
	public function setPageContent( &$outputDone, &$pcache ) {
		global $wgRequest, $wgOut, $wgUser, $wgLang;
		# Only trigger for reviewable pages
		if( !FlaggedRevs::isPageReviewable( $this->parent->getTitle() ) ) {
			return true;
		}
		# Only trigger on article view for content pages, not for protect/delete/hist...
		$action = $wgRequest->getVal( 'action', 'view' );
		if( ($action !='view' && $action !='purge') || !$this->parent->exists() )
			return true;
		# Do not clutter up diffs any further and leave archived versions alone...
		if( $wgRequest->getVal('diff') || $wgRequest->getVal('oldid') ) {
			return true;
		}
		$simpleTag = $old = $stable = false;
		$tag = $prot = $pending = '';
		# Check the newest stable version.
		$srev = $this->getStableRev( FR_TEXT );
		$frev = $srev;
		$stableId = $frev ? $frev->getRevId() : 0;
		# Also, check for any explicitly requested old stable version...
		$reqId = $wgRequest->getVal('stableid');
		if( $reqId === "best" ) {
			$reqId = FlaggedRevs::getPrimeFlaggedRevId( $this->parent );
		}
		if( $stableId && $reqId ) {
			if( $reqId != $stableId ) {
				$frev = FlaggedRevision::newFromTitle( $this->parent->getTitle(), $reqId, FR_TEXT );
				$old = true; // old reviewed version requested by ID
				if( !$frev ) {
					$wgOut->addWikiText( wfMsg('revreview-invalid') );
					$wgOut->returnToMain( false, $this->parent->getTitle() );
					# Tell MW that parser output is done
					$outputDone = true;
					$pcache = false;
					return true;
				}
			} else {
				$stable = true; // stable version requested by ID
			}
		}
		// Is the page config altered?
		if( $this->isPageLocked() ) {
			$prot = "<span class='fr-icon-locked' title=\"".wfMsg('revreview-locked')."\"></span>";
		} else if( $this->isPageUnlocked() ) {
			$prot = "<span class='fr-icon-unlocked' title=\"".wfMsg('revreview-unlocked')."\"></span>";
		}
		// Is there a stable version?
		if( !is_null($frev) ) {
			# Get flags and date
			$time = $wgLang->date( $frev->getTimestamp(), true );
			$flags = $frev->getTags();
			# Get quality level
			$quality = FlaggedRevs::isQuality( $flags );
			$pristine =  FlaggedRevs::isPristine( $flags );
			// Looking at some specific old stable revision ("&stableid=x")
			// set to override given the relevant conditions. If the user is
			// requesting the stable revision ("&stableid=x"), defer to override
			// behavior below, since it is the same as ("&stable=1").
			if( $old ) {
				$revsSince = FlaggedRevs::getRevCountSince( $this->parent, $frev->getRevId() );
				$text = $frev->getTextForParse();
	   			$parserOut = FlaggedRevs::parseStableText( $this->parent, $text, $frev->getRevId() );
				# Construct some tagging for non-printable outputs. Note that the pending
				# notice has all this info already, so don't do this if we added that already.
				if( !$wgOut->isPrintable() ) {
					$class = $quality ? 'fr-icon-quality' : 'fr-icon-stable';
					$tooltip = $quality ? 'revreview-quality-title' : 'revreview-stable-title';
					$tooltip = wfMsgHtml($tooltip);
					// Simple icon-based UI
					if( FlaggedRevs::useSimpleUI() ) {
						$msg = $quality ? 'revreview-quick-quality-old' : 'revreview-quick-basic-old';
						$html = "{$prot}<span class='{$class}' title=\"{$tooltip}\"></span>" .
							wfMsgExt( $msg, array('parseinline'), $frev->getRevId(), $time );
						$tag .= FlaggedRevsXML::prettyRatingBox( $frev, $html, $revsSince, true, false, $old );
					// Standard UI
					} else {
						$msg = $quality ? 'revreview-quality-old' : 'revreview-basic-old';
						$tag .= "{$prot}<span class='{$class}' title=\"{$tooltip}\"></span>" .
							wfMsgExt( $msg, array('parseinline'), $frev->getRevId(), $time );
						# Hide clutter
						if( !empty($flags) ) {
							$tag .= " " . FlaggedRevsXML::ratingToggle();
							$tag .= "<span id='mw-revisionratings' style='display:block;'><br/>" .
								wfMsgHtml('revreview-oldrating') . FlaggedRevsXML::addTagRatings( $flags ) . '</span>';
						}
					}
				}
				# Output HTML
				$this->getReviewNotes( $frev );
	   			$wgOut->addParserOutput( $parserOut );
				$wgOut->setRevisionId( $frev->getRevId() );
				# Index the stable version only
				$wgOut->setRobotPolicy( 'noindex,nofollow' );
				# Tell MW that parser output is done
				$outputDone = true;
				$pcache = false;
			// Looking at some specific old revision (&oldid=x) or if FlaggedRevs is not
			// set to override given the relevant conditions (like &action=protect).
			} else if( !$stable && !$this->pageOverride() ) {
				$revsSince = FlaggedRevs::getRevCountSince( $this->parent, $frev->getRevId() );
				$synced = false;
				# We only care about syncing if not viewing an old stable version
				if( $srev->getRevId() == $frev->getRevId() ) {
					$synced = FlaggedRevs::stableVersionIsSynced( $frev, $this->parent );
					if( $synced ) {
						$this->getReviewNotes( $frev ); // Still the same
					}
				}
				# Give notice to newer users if an unreviewed edit was completed...
				if( $wgRequest->getVal('shownotice') && !$synced && !$wgUser->isAllowed('review') ) {
					$tooltip = wfMsgHtml('revreview-draft-title');
					$pending = "{$prot}<span class='fr-icon-current' title=\"{$tooltip}\"></span>" .
						wfMsgExt('revreview-edited',array('parseinline'),$frev->getRevId(),$revsSince);
					$pending = "<div id='mw-reviewnotice' class='flaggedrevs_preview plainlinks'>$pending</div>";
					# Notice should always use subtitle
					$this->reviewNotice = $pending;
				}
				# If they are synced, do special styling
				$simpleTag = !$synced;
				# Construct some tagging for non-printable outputs. Note that the pending
				# notice has all this info already, so don't do this if we added that already.
				if( !$wgOut->isPrintable() && !$pending && !($this->lowProfileUI() && $synced) ) {
					$class = 'fr-icon-current'; // default
					$tooltip = 'revreview-draft-title';
					// Simple icon-based UI
					if( FlaggedRevs::useSimpleUI() ) {
						if( $synced ) {
							$msg = $quality ? 'revreview-quick-quality-same' : 'revreview-quick-basic-same';
							$class = $quality ? 'fr-icon-quality' : 'fr-icon-stable';
							$tooltip = $quality ? 'revreview-quality-title' : 'revreview-stable-title';
							$msgHTML = wfMsgExt( $msg, array('parseinline'), $frev->getRevId(), $revsSince );
						} else {
							$msg = $quality ? 'revreview-quick-see-quality' : 'revreview-quick-see-basic';
							$msgHTML = wfMsgExt( $msg, array('parseinline'), $frev->getRevId(), $revsSince );
						}
						$tooltip = wfMsgHtml($tooltip);
						$msgHTML = "{$prot}<span class='{$class}' title=\"{$tooltip}\"></span>$msgHTML";
						$tag .= FlaggedRevsXML::prettyRatingBox( $frev, $msgHTML, $revsSince, $synced, $synced, $old );
					// Standard UI
					} else {
						if( $synced ) {
							$msg = $quality ? 'revreview-quality-same' : 'revreview-basic-same';
							$class = $quality ? 'fr-icon-quality' : 'fr-icon-stable';
							$tooltip = $quality ? 'revreview-quality-title' : 'revreview-stable-title';
							$msgHTML = wfMsgExt( $msg, array('parseinline'), $frev->getRevId(), $time, $revsSince );
						} else {
							$msg = $quality ? 'revreview-newest-quality' : 'revreview-newest-basic';
							$msg .= ($revsSince == 0) ? '-i' : '';
							$msgHTML = wfMsgExt( $msg, array('parseinline'), $frev->getRevId(), $time, $revsSince );
						}
						$tooltip = wfMsgHtml($tooltip);
						$tag .= "{$prot}<span class='{$class}' title=\"{$tooltip}\"></span>" . $msgHTML;
						# Hide clutter
						if( !empty($flags) ) {
							$tag .= " " . FlaggedRevsXML::ratingToggle();
							$tag .= "<span id='mw-revisionratings' style='display:block;'><br/>" .
								wfMsgHtml('revreview-oldrating') . FlaggedRevsXML::addTagRatings( $flags ) . '</span>';
						}
					}
				}
				# Index the stable version only if it is the default
				if( $this->showStableByDefault() ) {
					$wgOut->setRobotPolicy( 'noindex,nofollow' );
				}
			// The relevant conditions are met to override the page with the stable version.
			} else {
	   			# We will be looking at the reviewed revision...
	   			$revsSince = FlaggedRevs::getRevCountSince( $this->parent, $frev->getRevId() );
				# Get parsed stable version
				$parserOut = FlaggedRevs::getPageCache( $this->parent );
				if( $parserOut == false ) {
					$text = $frev->getTextForParse();
	   				$parserOut = FlaggedRevs::parseStableText( $this->parent, $text, $frev->getRevId() );
	   				# Update the stable version cache
					FlaggedRevs::updatePageCache( $this->parent, $parserOut );
	   			}
				$synced = FlaggedRevs::stableVersionIsSynced( $frev, $this->parent, $parserOut, null );
				# Construct some tagging
				if( !$wgOut->isPrintable() && !($this->lowProfileUI() && $synced) ) {
					$class = $quality ? 'fr-icon-quality' : 'fr-icon-stable';
					$tooltip = $quality ? 'revreview-quality-title' : 'revreview-stable-title';
					$tooltip = wfMsgHtml($tooltip);
					// Simple icon-based UI
					if( FlaggedRevs::useSimpleUI() ) {
						$msg = $quality ? 'revreview-quick-quality' : 'revreview-quick-basic';
						# uses messages 'revreview-quick-quality-same', 'revreview-quick-basic-same'
						$msg = $synced ? "{$msg}-same" : $msg;
						$html = "{$prot}<span class='{$class}' title=\"{$tooltip}\"></span>" .
							wfMsgExt( $msg, array('parseinline'), $frev->getRevId(), $revsSince );

						$tag = FlaggedRevsXML::prettyRatingBox( $frev, $html, $revsSince, true, $synced );
					// Standard UI
					} else {
						$msg = $quality ? 'revreview-quality' : 'revreview-basic';
						if( $synced ) {
							# uses messages 'revreview-quality-same', 'revreview-basic-same'
							$msg .= '-same';
						} else if( $revsSince == 0 ) {
							# uses messages 'revreview-quality-i', 'revreview-basic-i'
							$msg .= '-i';
						}
						$tag = "{$prot}<span class='{$class} plainlinks' title=\"{$tooltip}\"></span>" .
							wfMsgExt( $msg, array('parseinline'), $frev->getRevId(), $time, $revsSince );
						if( !empty($flags) ) {
							$tag .= " " . FlaggedRevsXML::ratingToggle();
							$tag .= "<span id='mw-revisionratings' style='display:block;'><br/>" .
								FlaggedRevsXML::addTagRatings( $flags ) . '</span>';
						}
					}
				}
				# Output HTML
				$this->getReviewNotes( $frev );
	   			$wgOut->addParserOutput( $parserOut );
				$wgOut->setRevisionId( $frev->getRevId() );
				# Tell MW that parser output is done
				$outputDone = true;
				$pcache = false;
			}
			# Some checks for which tag CSS to use
			if( FlaggedRevs::useSimpleUI() )
				$tagClass = 'flaggedrevs_short';
			else if( $simpleTag )
				$tagClass = 'flaggedrevs_notice';
			else if( $pristine )
				$tagClass = 'flaggedrevs_pristine';
			else if( $quality )
				$tagClass = 'flaggedrevs_quality';
			else
				$tagClass = 'flaggedrevs_basic';
			# Wrap tag contents in a div
			if( $tag !='' ) {
				$tag = "<div id='mw-revisiontag' class='$tagClass plainlinks noprint'>$tag</div>";
				$this->reviewNotice .= $tag;
			}
		// Add "no reviewed version" tag, but not for main page or printable output.
		} else if( !$wgOut->isPrintable() ) {
			// Simple icon-based UI
			if( FlaggedRevs::useSimpleUI() ) {
				$msg = $old ? 'revreview-quick-invalid' : 'revreview-quick-none';
				$tag .= "{$prot}<span class='fr-icon-current plainlinks'></span>" .
					wfMsgExt($msg,array('parseinline'));
				$tag = "<div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint'>$tag</div>";
				$this->reviewNotice .= $tag;
			// Standard UI
			} else {
				$msg = $old ? 'revreview-invalid' : 'revreview-noflagged';
				$tag = "<div id='mw-revisiontag' class='flaggedrevs_notice plainlinks noprint'>" .
					"{$prot}<span class='fr-icon-current plainlinks'></span>" .
					wfMsgExt($msg, array('parseinline')) . "</div>";
				$this->reviewNotice .= $tag;
			}
		}
		$this->displayTag();

		return true;
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
		global $wgRequest;
		# Determine timestamp. A reviewed version may have explicitly been requested...
		$frev = null;
		$time = false;
		if( $reqId = $wgRequest->getVal('stableid') ) {
			$frev = FlaggedRevision::newFromTitle( $this->parent->getTitle(), $reqId );
		} else if( $this->pageOverride() ) {
			$frev = $this->getStableRev( FR_TEXT );
		}
		if( !is_null($frev) ) {
			$time = $frev->getFileTimestamp();
			// B/C, may be stored in associated image version metadata table
			if( !$time ) {
				$dbr = wfGetDB( DB_SLAVE );
				$time = $dbr->selectField( 'flaggedimages',
					'fi_img_timestamp',
					array( 'fi_rev_id' => $frev->getRevId(),
						'fi_name' => $this->parent->getTitle()->getDBkey() ),
					__METHOD__ );
			}
			# NOTE: if not found, this will use the current
			$this->parent = new ImagePage( $this->parent->getTitle(), $time );
		}
		if ( !$time ) {
			# Try request parameter
			$time = $wgRequest->getVal( 'filetimestamp', false );
		}

		if ( !$time ) {
			// Use the default behaviour
			return;
		}

		$title = $this->parent->getTitle();
		$displayFile = wfFindFile( $title, $time );
		# If none found, try current
		if ( !$displayFile ) {
			wfDebug( __METHOD__.": {$title->getPrefixedDBkey()}: $time not found, using current\n" );
			$displayFile = wfFindFile( $title );
			# If none found, use a valid local placeholder
			if( !$displayFile ) {
				$displayFile = wfLocalFile( $title ); // fallback to current
			}
			$normalFile = $displayFile;
		# If found, set $normalFile
		} else {
			wfDebug( __METHOD__.": {$title->getPrefixedDBkey()}: using timestamp $time\n" );
			$normalFile = wfFindFile( $title );
		}
	}

	/**
	 * Adds latest stable version tag to page when editing
	 */
	public function addToEditView( $editPage ) {
		global $wgRequest, $wgOut;
		# Talk pages cannot be validated
		if( !$this->isReviewable() )
			return false;
		# Find out revision id
	   	$revId = $editPage->oldid ? $editPage->oldid : $this->parent->getLatest();
		# Grab the ratings for this revision if any
		if( !$revId )
			return true;
		# Set new body html text as that of now
		$tag = $warning = $prot = '';
		// Is the page config altered?
		if( $this->isPageLocked() ) {
			$prot = "<span class='fr-icon-locked' title=\"".wfMsg('revreview-locked')."\"></span>";
		} else if( $this->isPageUnlocked() ) {
			$prot = "<span class='fr-icon-unlocked' title=\"".wfMsg('revreview-unlocked')."\"></span>";
		}
		# Check the newest stable version
		$frev = $this->getStableRev();
		if( !is_null($frev) ) {
			global $wgLang, $wgUser, $wgFlaggedRevsAutoReview;

			$time = $wgLang->date( $frev->getTimestamp(), true );
			$flags = $frev->getTags();
			$revsSince = FlaggedRevs::getRevCountSince( $this->parent, $frev->getRevId() );
			# Construct some tagging
			$quality = FlaggedRevs::isQuality( $flags );
			# If this will be autoreviewed, notify the user...
			if( !FlaggedRevs::lowProfileUI() && $wgFlaggedRevsAutoReview && $wgUser->isAllowed('review') ) {
				# If we are editing some reviewed revision, any changes this user
				# makes will be autoreviewed...
				$ofrev = FlaggedRevision::newFromTitle( $this->parent->getTitle(), $revId );
				if( !is_null($ofrev) ) {
					$msg = ( $revId==$frev->getRevId() ) ? 'revreview-auto-w' : 'revreview-auto-w-old';
					$warning = "<div id='mw-autoreviewtag' class='flaggedrevs_warning plainlinks'>" .
						wfMsgExt($msg,array('parseinline')) . "</div>";
				}
			}
			if( $frev->getRevId() != $revId ) {
				# Streamlined UI
				if( FlaggedRevs::useSimpleUI() ) {
					$msg = $quality ? 'revreview-newest-quality' : 'revreview-newest-basic';
					$msg .= ($revsSince == 0) ? '-i' : '';
					$tag = "{$prot}<span class='fr-checkbox'></span>" .
						wfMsgExt( $msg, array('parseinline'), $frev->getRevId(), $time, $revsSince );
					$tag = "<div id='mw-revisiontag-edit' class='flaggedrevs_editnotice plainlinks'>$tag</div>";
				# Standard UI
				} else {
					$msg = $quality ? 'revreview-newest-quality' : 'revreview-newest-basic';
					$msg .= ($revsSince == 0) ? '-i' : '';
					$tag = "{$prot}<span class='fr-checkbox'></span>" .
						wfMsgExt( $msg, array('parseinline'), $frev->getRevId(), $time, $revsSince );
					# Hide clutter
					if( !empty($flags) ) {
						$tag .= " " . FlaggedRevsXML::ratingToggle();
						$tag .= '<span id="mw-revisionratings" style="display:block;"><br/>' .
							wfMsg('revreview-oldrating') . FlaggedRevsXML::addTagRatings( $flags ) . '</span>';
					}
					$tag = "<div id='mw-revisiontag-edit' class='flaggedrevs_editnotice plainlinks'>$tag</div>";
				}
			}
			# Output notice and warning for editors
			$wgOut->addHTML( $tag . $warning );

			# Show diff to stable, to make things less confusing.
			if( !$this->showStableByDefaultUser() && !$wgUser->isAllowed('review') ) {
				return true;
			}
			if( $frev->getRevId() == $revId )
				return true; // nothing to show here
			# Don't show for old revisions, diff, preview, or undo.
			if( $editPage->oldid || $editPage->section === "new" || in_array($editPage->formtype,array('diff','preview')) ) {
				return true; // nothing to show here
			}
			$leftNote = $quality ? 'revreview-quality-title' : 'revreview-stable-title';
			$rightNote = 'revreview-draft-title';
			$text = $frev->getRevText();
			# Are we editing a section?
			$section = ($editPage->section == "") ? false : intval($editPage->section);
			if( $section !== false ) {
				$text = $this->parent->getSection( $text, $section );
			}
			if( $text !== false && strcmp($text,$editPage->textbox1) !== 0 ) {
				$diffEngine = new DifferenceEngine();
				$diffEngine->showDiffStyle();
				$wgOut->addHtml(
					"<div>" .
					"<table border='0' width='98%' cellpadding='0' cellspacing='4' class='diff'>" .
					"<col class='diff-marker' />" .
					"<col class='diff-content' />" .
					"<col class='diff-marker' />" .
					"<col class='diff-content' />" .
					"<tr>" .
						"<td colspan='2' width='50%' align='center' class='diff-otitle'><b>[" . wfMsgHtml($leftNote) . "]</b></td>" .
						"<td colspan='2' width='50%' align='center' class='diff-ntitle'><b>[" . wfMsgHtml($rightNote) . "]</b></td>" .
					"</tr>" .
					$diffEngine->generateDiffBody( $text, $editPage->textbox1 ) .
					"</table>" .
					"</div>\n" );
			}
		}
		return true;
	}

	/**
	 * Add unreviewed pages links
	 */
	public function addToCategoryView() {
		global $wgOut, $wgUser;

		if( !$wgUser->isAllowed( 'review' ) )
			return true;
		# Load special page names
		wfLoadExtensionMessages( 'OldReviewedPages' );
		wfLoadExtensionMessages( 'UnreviewedPages' );

		$category = $this->parent->getTitle()->getText();

		$unreviewed = SpecialPage::getTitleFor( 'UnreviewedPages' );
		$unreviewedLink = $wgUser->getSkin()->makeKnownLinkObj( $unreviewed, wfMsgHtml('unreviewedpages'),
			"category={$category}" );

		$oldreviewed = SpecialPage::getTitleFor( 'OldReviewedPages' );
		$oldreviewedLink = $wgUser->getSkin()->makeKnownLinkObj( $oldreviewed, wfMsgHtml('oldreviewedpages'),
			"category={$category}" );

		$wgOut->appendSubtitle( "<p>$unreviewedLink / $oldreviewedLink</p>" );

		return true;
	}

	 /**
	 * Add review form to pages when necessary
	 */
	public function addReviewForm( $out ) {
		global $wgRequest, $wgUser;
		if( !$this->parent->exists() || !$this->isReviewable() || !$out->mRevisionId ) {
			return true;
		}
		# Check action and if page is protected
		$action = $wgRequest->getVal( 'action', 'view' );
		if( ($action !='view' && $action !='purge') || !$this->parent->getTitle()->quickUserCan('edit') ) {
			return true;
		}
		# User must have review rights
		if( $wgUser->isAllowed( 'review' ) ) {
			$this->addQuickReview( $out, (bool)$wgRequest->getVal('diff') );
		}
		return true;
	}


	 /**
	 * Add feedback form to pages when necessary
	 */
	public function addFeedbackForm( $out ) {
		global $wgRequest, $wgUser;
		if( !$this->parent->exists() || !$this->isRateable() || !$out->mRevisionId ) {
			return true;
		}
		# Check action and if page is protected
		$action = $wgRequest->getVal( 'action', 'view' );
		if( ($action !='view' && $action !='purge') ) {
			return true;
		}
		# User must not have review rights.
		if( $wgUser->isAllowed( 'feedback' ) && !$wgUser->isAllowed( 'review' ) ) {
			# If the user already voted, then don't show the form.
			# Always show for IPs however, due to squid caching...
			if( !$wgUser->getId() || !FlaggedRevs::userAlreadyVoted( $this->parent->getTitle() ) ) {
				$this->addQuickFeedback( $out );
			}
		}
		return true;
	}

	 /**
	 * Adds a patrol link to non-reviewable pages
	 */
	public function addPatrolLink( &$outputDone, &$pcache ) {
		global $wgRequest, $wgOut, $wgUser;
		# For unreviewable pages, allow for basic patrolling
		if( FlaggedRevs::isPagePatrollable( $this->parent->getTitle() ) ) {
			# If we have been passed an &rcid= parameter, we want to give the user a
			# chance to mark this new article as patrolled.
			$rcid = $wgRequest->getIntOrNull( 'rcid' );
			if( !is_null( $rcid ) && $rcid != 0 && $wgUser->isAllowed( 'review' ) ) {
				$reviewTitle = SpecialPage::getTitleFor( 'RevisionReview' );
				$wgOut->addHTML( "<div class='patrollink'>" .
					wfMsgHtml( 'markaspatrolledlink',
					$wgUser->getSkin()->makeKnownLinkObj( $reviewTitle, wfMsgHtml('markaspatrolledtext'),
						"patrolonly=1&target={$this->parent->getTitle()->getPrefixedUrl()}&rcid={$rcid}" .
						"&token=" . urlencode( $wgUser->editToken( $this->parent->getTitle()->getPrefixedText(), $rcid ) ) )
			 		) .
					'</div>'
			 	);
			}
		}
		return true;
	}
	 /**
	 * Add link to stable version setting to protection form
	 */
	public function addVisibilityLink( $out ) {
		global $wgUser, $wgRequest;

		if( !$this->isReviewable() )
			return true;

		$action = $wgRequest->getVal( 'action', 'view' );
		if( $action == 'protect' || $action == 'unprotect' ) {
			# Check for an overridabe revision
			$frev = $this->getStableRev( FR_TEXT );
			if( !$frev )
				return true;
			# Load special page name
			wfLoadExtensionMessages( 'Stabilization' );
			$title = SpecialPage::getTitleFor( 'Stabilization' );
			# Give a link to the page to configure the stable version
			$out->mBodytext = "<span class='plainlinks'>" .
				wfMsgExt( 'revreview-visibility',array('parseinline'), $title->getPrefixedText() ) .
				"</span>" . $out->mBodytext;
		}
		return true;
	}

	 /**
	 * Add stable version tabs. Rename some of the others if necessary.
	 */
	public function setActionTabs( $skin, &$contentActions ) {
		global $wgRequest, $wgUser, $wgFlaggedRevsOverride, $wgFlaggedRevTabs;
		# Get the subject page, not all skins have it :(
		if( !isset($skin->mTitle) )
			return true;
		$title = $skin->mTitle->getSubjectPage();
		# Non-content pages cannot be validated
		if( !FlaggedRevs::isPageReviewable( $title ) || !$title->exists() )
			return true;
		$article = new Article( $title );
		$action = $wgRequest->getVal( 'action', 'view' );
		# Add rating tab
		if( $wgUser->isAllowed( 'feedback' ) ) {
			wfLoadExtensionMessages( 'RatingHistory' );
			$ratingTitle = SpecialPage::getTitleFor( 'RatingHistory' );
			$contentActions['ratinghist'] = array(
				'class' => false,
				'text' => wfMsg('ratinghistory-tab'),
				'href' => $ratingTitle->getLocalUrl('target='.$title->getPrefixedUrl())
			);
		}
		# If we are viewing a page normally, and it was overridden,
		# change the edit tab to a "current revision" tab
	   	$srev = $this->getStableRev( FR_TEXT );
	   	# No quality revs? Find the last reviewed one
	   	if( is_null($srev) ) {
			return true;
		}
	   	# Be clear about what is being edited...
		$synced = FlaggedRevs::stableVersionIsSynced( $srev, $article );
	   	if( !$skin->mTitle->isTalkPage() && !$synced ) {
	   		if( isset( $contentActions['edit'] ) ) {
				if( $this->showStableByDefault() )
					$contentActions['edit']['text'] = wfMsg('revreview-edit');
				# If the user is requesting the draft or some revision, they don't need a diff.
				if( $this->pageOverride() )
					$contentActions['edit']['href'] = $title->getLocalUrl( 'action=edit' );
	   		} if( isset( $contentActions['viewsource'] ) ) {
				if( $this->showStableByDefault() )
					$contentActions['viewsource']['text'] = wfMsg('revreview-source');
				# If the user is requesting the draft or some revision, they don't need a diff.
				if( $this->pageOverride() )
					$contentActions['viewsource']['href'] = $title->getLocalUrl( 'action=edit' );
			}
	   	}
		# We can change the behavoir of stable version for this page to be different
		# than the site default.
		if( !$skin->mTitle->isTalkPage() && $wgUser->isAllowed('stablesettings') ) {
			wfLoadExtensionMessages( 'Stabilization' );
			$stableTitle = SpecialPage::getTitleFor( 'Stabilization' );
			if( !isset($contentActions['protect']) && !isset($contentActions['unprotect']) ) {
				wfLoadExtensionMessages( 'Stabilization' );
				$contentActions['default'] = array(
					'class' => false,
					'text' => wfMsg('stabilization-tab'),
					'href' => $stableTitle->getLocalUrl('page='.$title->getPrefixedUrl())
				);
			}
		}
		// Add auxillary tabs...
	 	if( !$wgFlaggedRevTabs || $synced )
	   		return true;
		// We are looking at the stable version
		if( $this->pageOverride() || $wgRequest->getVal('stableid') ) {
			$draftTabCss = '';
			$stableTabCss = 'selected';
		// We are looking at the talk page or diffs/hist/oldids
		} else if( !in_array($action,array('view','purge','edit')) || $skin->mTitle->isTalkPage() ) {
			$draftTabCss = '';
			$stableTabCss = '';
		// We are looking at the current revision or in edit mode
		} else {
			$draftTabCss = 'selected';
			$stableTabCss = '';
		}
		$newActions = array();
		$first = true;
		# Straighten out order, set the tab AFTER the main tab is set
		foreach( $contentActions as $tabAction => $data ) {
			# Main page tab...
			if( $first ) {
				$first = false;
				if( $synced ) {
					$newActions[$tabAction] = $data; // keep it
				} else {
					# Add new tabs after first one
					$newActions['stable'] = array(
						'class' => $stableTabCss,
						'text' => wfMsg('revreview-stable'),
						'href' => $title->getLocalUrl( 'stable=1' )
					);
					$newActions['current'] = array(
						'class' => $draftTabCss,
						'text' => wfMsg('revreview-current'),
						'href' => $title->getLocalUrl( 'stable=0&redirect=no' )
						);
				}
			# The others...
			} else {
				$newActions[$tabAction] = $data;
			}
	   	}
	   	# Reset static array
	   	$contentActions = $newActions;
		return true;
	}

	 /**
	 * Add link to stable version of reviewed revisions
	 */
	public function addToHistLine( $history, $row, &$s ) {
		global $wgUser;
		# Non-content pages cannot be validated. Stable version must exist.
		if( !$this->isReviewable() || !$this->getStableRev() )
			return true;
		$skin = $wgUser->getSkin();
		list($link,$class) = FlaggedRevs::markHistoryRow( $this->parent->getTitle(), $row, $skin );
		if( $link ) {
			$s = "<span class='$class'>$s</span> <small><strong>[$link]</strong></small>";
		}
		return true;
	}

	 /**
	 * Add link to stable version of reviewed revisions
	 */
	public function addToFileHistLine( $historyList, $file, &$s, &$css ) {
		# Non-content pages cannot be validated. Stable version must exist.
		if( !$this->isReviewable() || !$this->getStableRev() )
			return true;
		# Quality level for old versions selected all at once.
		# Commons queries cannot be done all at once...
		if( !$file->isOld() || !$file->isLocal() ) {
			$quality = wfGetDB(DB_SLAVE)->selectField( 'flaggedrevs', 'fr_quality',
				array( 'fr_img_sha1' => $file->getSha1(), 'fr_img_timestamp' => $file->getTimestamp() ),
				__METHOD__ );
		} else {
			$quality = is_null($file->quality) ? false : $file->quality;
		}
		# If reviewed, class the line
		if( $quality !== false ) {
			$css = FlaggedRevsXML::getQualityColor( $quality );
		}
		return true;
	}

	/**
	 * @param FlaggedRevision $frev
	 * @return string, revision review notes
	 */
	public function getReviewNotes( $frev ) {
		global $wgUser;
		if( !FlaggedRevs::allowComments() || !$frev || !$frev->getComment() ) {
			return '';
		}
   		$notes = "<div class='flaggedrevs_notes plainlinks'>";
   		$notes .= wfMsgExt('revreview-note', array('parseinline'), User::whoIs( $frev->getUser() ) );
   		$notes .= '<br/><i>' . $wgUser->getSkin()->formatComment( $frev->getComment() ) . '</i></div>';
		$this->reviewNotes = $notes;
	}

	/**
	* When comparing the stable revision to the current after editing a page, show
	* a tag with some explaination for the diff.
	*/
	public function addDiffNoticeAndIncludes( $diff, $oldRev, $newRev ) {
		global $wgRequest, $wgUser, $wgOut;

		$diffOnly = $wgRequest->getBool( 'diffonly', $wgUser->getOption( 'diffonly' ) );

		if( $wgOut->isPrintable() || !FlaggedRevs::isPageReviewable( $newRev->getTitle() ) )
			return true;
		# Check if this might be the diff to stable. If so, enhance it.
		if( $newRev->isCurrent() && $oldRev ) {
			$frev = $this->getStableRev();
			if( $frev && $frev->getRevId() == $oldRev->getID() ) {
				global $wgMemc, $wgParserCacheExpireTime, $wgUseStableTemplates, $wgUseStableImages;

				$changeList = array();
				$skin = $wgUser->getSkin();
				$article = new Article( $newRev->getTitle() );

				# Try the cache. Uses format <page ID>-<UNIX timestamp>.
				$key = wfMemcKey( 'flaggedrevs', 'stableDiffs', 'templates', (bool)$wgUseStableTemplates,
					$article->getId(), $article->getTouched() );
				$value = $wgMemc->get($key);
				$tmpChanges = $value ? unserialize($value) : false;

				# Make a list of each changed template...
				if( $tmpChanges === false ) {
					$dbr = wfGetDB( DB_SLAVE );
					// Get templates where the current and stable are not the same revision
					if( $wgUseStableTemplates ) {
						$ret = $dbr->select( array('flaggedtemplates','page','flaggedpages'),
							array( 'ft_namespace', 'ft_title', 'fp_stable','ft_tmp_rev_id' ),
							array( 'ft_rev_id' => $frev->getRevId(),
								'page_namespace = ft_namespace',
								'page_title = ft_title',
								// If the page has a stable version, is it current?
								// If not, is the specified one at review time current?
								'fp_stable IS NOT NULL AND (fp_stable != page_latest) OR
									fp_stable IS NULL AND (ft_tmp_rev_id != page_latest)' ),
							__METHOD__,
							array(), /* OPTIONS */
							array( 'flaggedpages' => array('LEFT JOIN','fp_page_id = page_id') )
						);
					// Get templates that are newer than the ones of the stable version of this page
					} else {
						$ret = $dbr->select( array('flaggedtemplates','page'),
							array( 'ft_namespace', 'ft_title', 'ft_tmp_rev_id' ),
							array( 'ft_rev_id' => $frev->getRevId(),
								'page_namespace = ft_namespace',
								'page_title = ft_title',
								'ft_tmp_rev_id != page_latest' ),
							__METHOD__ );
					}
					$tmpChanges = array();
					while( $row = $dbr->fetchObject( $ret ) ) {
						$title = Title::makeTitle( $row->ft_namespace, $row->ft_title );
						$revID = isset($row->fp_stable) ? $row->fp_stable : $row->ft_tmp_rev_id;
						$tmpChanges[] = $skin->makeKnownLinkObj( $title, $title->getPrefixedText(),
							"diff=cur&oldid={$revID}" );
					}
					$wgMemc->set( $key, serialize($tmpChanges), $wgParserCacheExpireTime );
				}
				# Add set to list
				if( $tmpChanges )
					$changeList += $tmpChanges;

				# Try the cache. Uses format <page ID>-<UNIX timestamp>.
				$key = wfMemcKey( 'flaggedrevs', 'stableDiffs', 'images', (bool)$wgUseStableImages,
					$article->getId(), $article->getTouched() );
				$value = $wgMemc->get($key);
				$imgChanges = $value ? unserialize($value) : false;

				// Get list of each changed image...
				if( $imgChanges === false ) {
					global $wgUseStableImages;
					$dbr = wfGetDB( DB_SLAVE );
					// Get images where the current and stable are not the same revision
					if( $wgUseStableImages ) {
						$ret = $dbr->select( array('flaggedimages','page','image','flaggedpages','flaggedrevs'),
							array( 'fi_name', 'fi_img_timestamp', 'fr_img_timestamp' ),
							array( 'fi_rev_id' => $frev->getRevId() ),
							__METHOD__,
							array(), /* OPTIONS */
							array( 'page' => array('INNER JOIN','page_namespace = '. NS_IMAGE .' AND page_title = fi_name'),
								'image' => array('INNER JOIN','img_name = fi_name'),
								'flaggedpages' => array('LEFT JOIN','fp_page_id = page_id'),
								'flaggedrevs' => array('LEFT JOIN','fr_page_id = fp_page_id AND fr_rev_id = fp_stable') )
						);
					// Get images that are newer than the ones of the stable version of this page
					} else {
						$ret = $dbr->select( 'flaggedimages',
							array( 'fi_name', 'fi_img_timestamp' ),
							array( 'fi_rev_id' => $frev->getRevId() ),
							__METHOD__ );
					}
					$imgChanges = array();
					while( $row = $dbr->fetchObject( $ret ) ) {
						// stable time -> time when reviewed
						$timestamp = isset($row->fr_img_timestamp) ? $row->fr_img_timestamp : $row->fi_img_timestamp;
						$title = Title::makeTitle( NS_IMAGE, $row->fi_name );
						$file = wfFindFile( $title );
						if( $file && $file->getTimestamp() > $timestamp )
							$imgChanges[] = $skin->makeKnownLinkObj( $title, $title->getPrefixedText() );
					}
					$wgMemc->set( $key, serialize($imgChanges), $wgParserCacheExpireTime );
				}
				if( $imgChanges )
					$changeList += $imgChanges;

				# Some important information...
				if( ($wgUseStableTemplates || $wgUseStableImages) && !empty($changeList) ) {
					$notice = '<br/>' . wfMsgExt('revreview-update-use', array('parseinline'));
				} else {
					$notice = "";
				}
				# Explanatory text
				if( $diffOnly && $wgUser->isAllowed('review') ) {
					$exp = '<br/>'. wfMsgExt('revreview-diffonly', array('parseinline'));
				} else {
					$exp = "";
				}

				# If the user is allowed to review, prompt them!
				if( empty($changeList) && $wgUser->isAllowed('review') ) {
					$wgOut->addHTML( "<div id='mw-difftostable' class='flaggedrevs_diffnotice plainlinks'>" .
						wfMsgExt('revreview-update-none', array('parseinline')).$notice.$exp.'</div>' );
				} else if( !empty($changeList) && $wgUser->isAllowed('review') ) {
					$changeList = implode(', ',$changeList);
					$wgOut->addHTML( "<div id='mw-difftostable' class='flaggedrevs_diffnotice plainlinks'>" .
						wfMsgExt('revreview-update', array('parseinline')).'&nbsp;'.$changeList.$notice.$exp.'</div>' );
				} else if( !empty($changeList) ) {
					$changeList = implode(', ',$changeList);
					$wgOut->addHTML( "<div id='mw-difftostable' class='flaggedrevs_diffnotice plainlinks'>" .
						wfMsgExt('revreview-update-includes', array('parseinline')).'&nbsp;'.$changeList.$notice.$exp.'</div>' );
				}
				# Set flag for review form to tell it to autoselect tag settings from the
				# old revision unless the current one is tagged to.
				if( !FlaggedRevision::newFromTitle( $diff->mTitle, $newRev->getID() ) ) {
					$this->isDiffFromStable = true;
				}
			}
		}
		$newRevQ = FlaggedRevs::getRevQuality( $newRev->getTitle(), $newRev->getId() );
		$oldRevQ = $oldRev ? FlaggedRevs::getRevQuality( $newRev->getTitle(), $oldRev->getId() ) : false;
		# Diff between two revisions
		if( $oldRev ) {
			$wgOut->addHTML( "<table class='fr-diff-ratings' width='100%'><tr>" );

			$class = FlaggedRevsXML::getQualityColor( $oldRevQ );
			if( $oldRevQ !== false ) {
				$msg = $oldRevQ ? 'hist-quality' : 'hist-stable';
			} else {
				$msg = 'hist-draft';
			}
			$wgOut->addHTML( "<td width='50%' align='center'>" );
			$wgOut->addHTML( "<span class='$class'><b>[" . wfMsgHtml( $msg ) . "]</b></span>" );

			$class = FlaggedRevsXML::getQualityColor( $newRevQ );
			if( $newRevQ !== false ) {
				$msg = $newRevQ ? 'hist-quality' : 'hist-stable';
			} else {
				$msg = 'hist-draft';
			}
			$wgOut->addHTML( "</td><td width='50%' align='center'>" );
			$wgOut->addHTML( "<span class='$class'><b>[" . wfMsgHtml( $msg ) . "]</b></span>" );

			$wgOut->addHTML( '</td></tr></table>' );
		# New page "diffs" - just one rev
		} else {
			if( $newRevQ !== false ) {
				$msg = $newRevQ ? 'hist-quality' : 'hist-stable';
			} else {
				$msg = 'hist-draft';
			}
			$wgOut->addHTML( "<table class='fr-diff-ratings' width='100%'><tr><td class='fr-$msg' align='center'>" );
			$wgOut->addHTML( "<b>[" . wfMsgHtml( $msg ) . "]</b>" );
			$wgOut->addHTML( '</td></tr></table>' );
		}
		return true;
	}

	/**
	* Add a link to patrol non-reviewable pages.
	* Also add a diff to stable for other pages if possible.
	*/
	public function addPatrolAndDiffLink( $diff, $oldRev, $newRev ) {
		global $wgUser, $wgOut;
		// Is there a stable version?
		if( FlaggedRevs::isPageReviewable( $newRev->getTitle() ) ) {
			if( !$oldRev ) {
				return true;
			}
			$frev = $this->getStableRev();
			if( $frev && $frev->getRevId() == $oldRev->getID() && $newRev->isCurrent() ) {
				$this->isDiffFromStable = true;
			}
			# Give a link to the diff-to-stable if needed
			if( $frev && !$this->isDiffFromStable ) {
				$article = new Article( $newRev->getTitle() );
				# Is the stable revision using the same revision as the current?
				if( $article->getLatest() != $frev->getRevId() ) {
					$patrol = '(' . $wgUser->getSkin()->makeKnownLinkObj( $newRev->getTitle(),
						wfMsgHtml( 'review-diff2stable' ), "oldid={$frev->getRevId()}&diff=cur&diffonly=0" ) . ')';
					$wgOut->addHTML( "<div class='fr-diff-to-stable' align='center'>$patrol</div>" );
				}
			}
		// Prepare a change patrol link, if applicable
		} else if( FlaggedRevs::isPagePatrollable( $newRev->getTitle() ) && $wgUser->isAllowed( 'review' ) ) {
			// If we've been given an explicit change identifier, use it; saves time
			if( $diff->mRcidMarkPatrolled ) {
				$rcid = $diff->mRcidMarkPatrolled;
			} else {
				# Look for an unpatrolled change corresponding to this diff
				$dbr = wfGetDB( DB_SLAVE );
				$change = RecentChange::newFromConds(
					array(
						# Add redundant user,timestamp condition so we can use the existing index
						'rc_user_text'  => $diff->mNewRev->getRawUserText(),
						'rc_timestamp'  => $dbr->timestamp( $diff->mNewRev->getTimestamp() ),
						'rc_this_oldid' => $diff->mNewid,
						'rc_last_oldid' => $diff->mOldid,
						'rc_patrolled'  => 0
					),
					__METHOD__
				);
				if( $change instanceof RecentChange ) {
					$rcid = $change->mAttribs['rc_id'];
				} else {
					$rcid = 0; // None found
				}
			}
			// Build the link
			if( $rcid ) {
				$reviewTitle = SpecialPage::getTitleFor( 'RevisionReview' );
				$patrol = '[' . $wgUser->getSkin()->makeKnownLinkObj( $reviewTitle, wfMsgHtml( 'revreview-patrol' ),
					"patrolonly=1&target=" . $newRev->getTitle()->getPrefixedUrl() . "&rcid={$rcid}" .
					"&token=" . urlencode( $wgUser->editToken( $newRev->getTitle()->getPrefixedText(), $rcid ) ) ) . ']';
			} else {
				$patrol = '';
			}
			$wgOut->addHTML( '<div align=center>' . $patrol . '</div>' );
		}
		return true;
	}

	/**
	* Redirect users out to review the changes to the stable version.
	* Only for people who can review and for pages that have a stable version.
	*/
	public function injectReviewDiffURLParams( &$sectionAnchor, &$extraQuery ) {
		global $wgUser, $wgReviewChangesAfterEdit;
		# Don't show this for the talk page
		if( !$this->isReviewable() || $this->parent->getTitle()->isTalkPage() )
			return true;
		# Get the stable version, from master
		$frev = $this->getStableRev( FR_FOR_UPDATE );
		if( !$frev )
			return true;
		$latest = $this->parent->getTitle()->getLatestRevID(GAID_FOR_UPDATE);
		// If we are supposed to review after edit, and it was not autoreviewed,
		// and the user can actually make new stable version, take us to the diff...
		if( $wgReviewChangesAfterEdit && $frev && $latest > $frev->getRevId() && $frev->userCanSetFlags() ) {
			$extraQuery .= "oldid={$frev->getRevId()}&diff=cur&diffonly=0"; // override diff-only
		// ...otherwise, go to the current revision after completing an edit.
		} else {
			if( $frev ){
				$extraQuery .= "stable=0";
				if( !$wgUser->isAllowed('review') && $this->showStableByDefault() ) {
					$extraQuery .= "&shownotice=1";
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
		# Find out revision id
		if( $this->parent->mRevision ) {
	   		$revId = $this->parent->mRevision->mId;
		} else {
			$latest = $this->parent->getTitle()->getLatestRevID(GAID_FOR_UPDATE);
	   		$revId = $latest;
			wfDebug( 'FlaggedArticle::addRevisionIDField - ID not specified, assumed current' );
	   	}
		# If undoing a few consecutive top edits, we know the base ID
		if( $undo = $wgRequest->getIntOrNull('undo') ) {
			$undoAfter = $wgRequest->getIntOrNull('undoafter');
			$latest = isset($latest) ? $latest : $this->parent->getTitle()->getLatestRevID(GAID_FOR_UPDATE);
			if( $undoAfter && $undo == $this->parent->getLatest() ) {
				$revId = $undoAfter;
			}
		}
		$out->addHTML( "\n" . Xml::hidden( 'baseRevId', $revId ) );
		return true;
	}

	/**
	 * Get latest quality rev, if not, the latest reviewed one
	 * @param int $flags
	 * @return Row
	 */
	public function getStableRev( $flags=0 ) {
		if( $this->stableRev === false ) {
			return null; // We already looked and found nothing...
		}
		# Cached results available?
		if( !is_null($this->stableRev) ) {
			return $this->stableRev;
		}
		# Get the content page, skip talk
		$title = $this->parent->getTitle()->getSubjectPage();
		# Do we have one?
		$srev = FlaggedRevision::newFromStable( $title, $flags );
		if( $srev ) {
			$this->stableRev = $srev;
			$this->flags[$srev->getRevId()] = $srev->getTags();
			return $srev;
		} else {
			$this->stableRev = false;
			return null;
		}
	}

	/**
	 * Get visiblity restrictions on page
	 * @param Bool $forUpdate, use DB master?
	 * @returns Array (select,override)
	*/
	public function getVisibilitySettings( $forUpdate = false ) {
		# Cached results available?
		if( !is_null($this->pageConfig) ) {
			return $this->pageConfig;
		}
		# Get the content page, skip talk
		$title = $this->parent->getTitle()->getSubjectPage();
		$config = FlaggedRevs::getPageVisibilitySettings( $title, $forUpdate );
		$this->pageConfig = $config;
		return $config;
	}

	/**
	 * @param int $revId
	 * @eturns Array, output of the flags for a given revision
	 */
	public function getFlagsForRevision( $revId ) {
		# Cached results?
		if( isset($this->flags[$revId]) ) {
			return $this->flags[$revId];
		}
		# Get the flags
		$flags = FlaggedRevs::getRevisionTags( $this->parent->getTitle(), $revId );
		# Try to cache results
		$this->flags[$revId] = $flags;

		return $flags;
	}

	 /**
	 * Adds brief review notes to a page.
	 * @param OutputPage $out
	 */
	public function addReviewNotes( $out ) {
		if( $this->reviewNotes ) {
			$out->addHTML( $this->reviewNotes );
		}
		return true;
	}

	 /**
	 * Adds a brief review form to a page.
	 * @param OutputPage $out
	 * @param Title $title
	 * @param bool $top, should this form always go on top?
	 */
	public function addQuickReview( $out, $top = false ) {
		global $wgOut, $wgUser, $wgRequest, $wgFlaggedRevsOverride;
		# Revision being displayed
		$id = $out->mRevisionId;
		# Must be a valid non-printable output
		if( !$id || $out->isPrintable() ) {
			return false;
		}
		if( !isset($out->mTemplateIds) || !isset($out->fr_ImageSHA1Keys) ) {
			return false; // something went terribly wrong...
		}
		$skin = $wgUser->getSkin();

		# Variable for sites with no flags, otherwise discarded
		$approve = $wgRequest->getBool('wpApprove');
		# See if the version being displayed is flagged...
		$oldFlags = $this->getFlagsForRevision( $id );
		# If we are reviewing updates to a page, start off with the stable revision's
		# flags. Otherwise, we just fill them in with the selected revision's flags.
		if( $this->isDiffFromStable ) {
			$srev = $this->getStableRev( FR_TEXT );
			$flags = $srev->getTags();
			# Check if user is allowed to renew the stable version.
			# If not, then get the flags for the new revision itself.
			if( !RevisionReview::userCanSetFlags( $oldFlags ) ) {
				$flags = $oldFlags;
			}
		} else {
			$flags = $this->getFlagsForRevision( $id );
		}

		$reviewTitle = SpecialPage::getTitleFor( 'RevisionReview' );
		$action = $reviewTitle->getLocalUrl( 'action=submit' );
		$form = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $action, 'id' => 'mw-reviewform' ) );
		$form .= Xml::openElement( 'fieldset', array('class' => 'flaggedrevs_reviewform noprint') );
		$form .= "<legend><strong>" . wfMsgHtml( 'revreview-flag', $id ) . "</strong></legend>\n";

		if( $wgFlaggedRevsOverride ) {
			$form .= wfMsgExt( 'revreview-text', array('parse') );
		} else {
			$form .= wfMsgExt( 'revreview-text2', array('parse') );
		}

		# Current user has too few rights to change at least one flag, thus entire form disabled
		$disabled = !RevisionReview::userCanSetFlags( $flags );
		if( $disabled ) {
			$form .= Xml::openElement( 'div', array('class' => 'fr-rating-controls-disabled',
				'id' => 'fr-rating-controls-disabled') );
			$toggle = array( 'disabled' => "disabled" );
		} else {
			$form .= Xml::openElement( 'div', array('class' => 'fr-rating-controls', 'id' => 'fr-rating-controls') );
			$toggle = array();
		}
		$size = count(FlaggedRevs::getDimensions(),1) - count(FlaggedRevs::getDimensions());

		$form .= Xml::openElement( 'span', array('id' => 'mw-ratingselects') );
		# Loop through all different flag types
		foreach( FlaggedRevs::getDimensions() as $quality => $levels ) {
			$label = array();
			$selected = ( isset($flags[$quality]) && $flags[$quality] > 0 ) ? $flags[$quality] : 1;
			if( $disabled ) {
				$label[$selected] = $levels[$selected];
			# else collect all quality levels of a flag current user can set
			} else {
				foreach( $levels as $i => $name ) {
					if ( !RevisionReview::userCan($quality, $i) ) {
						break;
					}
					$label[$i] = $name;
				}
			}
			$quantity = count( $label );
			$form .= Xml::openElement( 'span', array('class' => 'fr-rating-options') ) . "\n";
			$form .= "<b>" . FlaggedRevs::getTagMsg($quality) . ":</b>&nbsp;";
			# If the sum of qualities of all flags is above 6, use drop down boxes
			# 6 is an arbitrary value choosen according to screen space and usability
			if( $size > 6 ) {
				$attribs = array( 'name' => "wp$quality", 'onchange' => "updateRatingForm()" ) + $toggle;
				$form .= Xml::openElement( 'select', $attribs );
				foreach( $label as $i => $name ) {
					$optionClass = array( 'class' => "fr-rating-option-$i" );
					$form .= Xml::option( FlaggedRevs::getTagMsg($name), $i, ($i == $selected), $optionClass )."\n";
				}
				$form .= Xml::closeElement('select')."\n";
			# If there are more than two qualities (none, 1 and more) current user gets radio buttons
			} else if( $quantity > 2 ) {
				foreach( $label as $i => $name ) {
					$attribs = array( 'class' => "fr-rating-option-$i", 'onchange' => "updateRatingForm()" );
					$form .= Xml::radioLabel( FlaggedRevs::getTagMsg($name), "wp$quality", $i, "wp$quality".$i,
						($i == $selected), $attribs ) . "\n";
				}
			# Otherwise make checkboxes (two qualities available for current user
			# and disabled fields in case we are below the magic 6)
			} else {
				$i = ( $disabled ) ? $selected : 1;
				$attribs = array( 'class' => "fr-rating-option-$i", 'onchange' => "updateRatingForm()" ) + $toggle;
				$form .= Xml::checkLabel( wfMsg( "revreview-$label[$i]" ), "wp$quality", "wp$quality".$i,
					($selected == $i), $attribs ) . "\n";
			}
			$form .= Xml::closeElement( 'span' );
		}
		# If there were none, make one checkbox to approve/unapprove
		if( FlaggedRevs::dimensionsEmpty() ) {
			$form .= Xml::openElement( 'span', array('class' => 'fr-rating-options') ) . "\n";
			$form .= Xml::checkLabel( wfMsg( "revreview-approved" ), "wpApprove", "wpApprove", 1 ) . "\n";
			$form .= Xml::closeElement( 'span' );
		}
		$form .= Xml::closeElement( 'span' );

		if( FlaggedRevs::allowComments() && $wgUser->isAllowed( 'validate' ) ) {
			$form .= "<div id='mw-notebox'>\n";
			$form .= "<p>".wfMsgHtml( 'revreview-notes' ) . "</p>\n";
			$form .= Xml::openElement( 'textarea', array('name' => 'wpNotes', 'id' => 'wpNotes',
				'class' => 'fr-notes-box', 'rows' => '2', 'cols' => '80') ) . Xml::closeElement('textarea') . "\n";
			$form .= "</div>\n";
		}

		$imageParams = $templateParams = $fileVersion = '';
		# NS -> title -> rev ID mapping
		foreach( $out->mTemplateIds as $namespace => $title ) {
			foreach( $title as $dbKey => $revId ) {
				$title = Title::makeTitle( $namespace, $dbKey );
				$templateParams .= $title->getPrefixedDBKey() . "|" . $revId . "#";
			}
		}
		# Image -> timestamp -> sha1 mapping
		foreach( $out->fr_ImageSHA1Keys as $dbKey => $timeAndSHA1 ) {
			foreach( $timeAndSHA1 as $time => $sha1 ) {
				$imageParams .= $dbKey . "|" . $time . "|" . $sha1 . "#";
			}
		}
		# For image pages, note the displayed image version
		if( $this->parent instanceof ImagePage ) {
			$file = $this->parent->getDisplayedFile();
			$fileVersion = $file->getTimestamp() . "#" . $file->getSha1();
		}

		$form .= Xml::openElement( 'span', array('style' => 'white-space: nowrap;') );
		# Hide comment if needed
		if( !$disabled ) {
			$form .= "<span id='mw-commentbox' style='clear:both'>" . Xml::inputLabel( wfMsg('revreview-log'), 'wpReason',
				'wpReason', 50, '', array('class' => 'fr-comment-box') ) . "&nbsp;&nbsp;&nbsp;</span>";
		}
		$form .= Xml::submitButton( wfMsg('revreview-submit'), array('id' => 'submitreview',
			'accesskey' => wfMsg('revreview-ak-review'), 'style' => 'margin: .5em 0em 0em 0em;',
			'title' => wfMsg('revreview-tt-review').' ['.wfMsg('revreview-ak-review').']') + $toggle
		);
		$form .= Xml::closeElement( 'span' );

		$form .= Xml::closeElement( 'div' );

		# Hidden params
		$form .= Xml::hidden( 'title', $reviewTitle->getPrefixedText() ) . "\n";
		$form .= Xml::hidden( 'target', $this->parent->getTitle()->getPrefixedDBKey() ) . "\n";
		$form .= Xml::hidden( 'oldid', $id ) . "\n";
		$form .= Xml::hidden( 'action', 'submit') . "\n";
		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() ) . "\n";
		# Add review parameters
		$form .= Xml::hidden( 'templateParams', $templateParams ) . "\n";
		$form .= Xml::hidden( 'imageParams', $imageParams ) . "\n";
		$form .= Xml::hidden( 'fileVersion', $fileVersion ) . "\n";
		# Pass this in if given; useful for new page patrol
		$form .= Xml::hidden( 'rcid', $wgRequest->getVal('rcid') ) . "\n";
		# Special token to discourage fiddling...
		$checkCode = RevisionReview::validationKey( $templateParams, $imageParams, $fileVersion, $id );
		$form .= Xml::hidden( 'validatedParams', $checkCode ) . "\n";

		$form .= Xml::closeElement( 'fieldset' );
		$form .= Xml::closeElement( 'form' );

		if( $top ) {
			$out->mBodytext = $form . $out->mBodytext;
		} else {
			$wgOut->addHTML( $form );
		}
		return true;
	}

	 /**
	 * Adds a brief feedback form to a page.
	 * @param OutputPage $out
	 * @param Title $title
	 * @param bool $top, should this form always go on top?
	 */
	public function addQuickFeedback( $out, $top = false ) {
		global $wgOut, $wgUser, $wgRequest, $wgFlaggedRevsFeedbackTags;
		# Are there any reader input tags?
		if( empty($wgFlaggedRevsFeedbackTags) ) {
			return false;
		}
		$id = $out->mRevisionId; // Revision being displayed
		if( $id != $this->parent->getLatest() ) {
			return false;
		}
		$reviewTitle = SpecialPage::getTitleFor( 'ReaderFeedback' );
		$action = $reviewTitle->getLocalUrl( 'action=submit' );
		$form = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $action, 'id' => 'mw-feedbackform' ) );
		$form .= Xml::openElement( 'fieldset', array('class' => 'flaggedrevs_reviewform noprint') );
		$form .= "<legend><strong>" . wfMsgHtml( 'readerfeedback' ) . "</strong></legend>\n";
		$form .= wfMsgExt( 'readerfeedback-text', array('parse') );
		$form .= Xml::openElement( 'span', array('id' => 'mw-feedbackselects') );
		# Loop through all different flag types
		foreach( FlaggedRevs::getFeedbackTags() as $quality => $levels ) {
			$label = array();
			$selected = ( isset($flags[$quality]) && $flags[$quality] > 0 ) ? $flags[$quality] : 2;
			$form .= "<b>" . wfMsgHtml("readerfeedback-$quality") . ":</b>&nbsp;";
			$attribs = array( 'name' => "wp$quality", 'onchange' => "updateFeedbackForm()" );
			$form .= Xml::openElement( 'select', $attribs );
			foreach( $levels as $i => $name ) {
				$optionClass = array( 'class' => "fr-rating-option-$i" );
				$form .= Xml::option( wfMsg( "readerfeedback-level-$i" ), $i, ($i == $selected), $optionClass ) ."\n";
			}
			$form .= Xml::closeElement( 'select' )."\n";
		}
		$form .= Xml::closeElement( 'span' );
		$form .= Xml::submitButton( wfMsg('readerfeedback-submit'),
			array('id' => 'submitfeedback','accesskey' => wfMsg('revreview-ak-review'),
			'title' => wfMsg('revreview-tt-review').' ['.wfMsg('revreview-ak-review').']' )
		);
		# Hidden params
		$form .= Xml::hidden( 'title', $reviewTitle->getPrefixedText() ) . "\n";
		$form .= Xml::hidden( 'target', $this->parent->getTitle()->getPrefixedDBKey() ) . "\n";
		$form .= Xml::hidden( 'oldid', $id ) . "\n";
		$form .= Xml::hidden( 'validatedParams', ReaderFeedback::validationKey( $id, $wgUser->getId() ) );
		$form .= Xml::hidden( 'action', 'submit') . "\n";
		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() ) . "\n";
		# Honeypot input
		$form .= Xml::input( 'commentary', 12, '', array('style' => 'display:none;') ) . "\n";
		$form .= Xml::closeElement( 'fieldset' );
		$form .= Xml::closeElement( 'form' );
		if( $top ) {
			$out->mBodytext = $form . $out->mBodytext;
		} else {
			$wgOut->addHTML( $form );
		}
		return true;
	}

	/**
	* Updates parser cache output to included needed versioning params.
	*/
	public function maybeUpdateMainCache( &$outputDone, &$pcache ) {
		global $wgUser, $wgRequest;

		$action = $wgRequest->getVal( 'action', 'view' );
		# Only trigger on article view for content pages, not for protect/delete/hist
		if( ($action !='view' && $action !='purge') || !$wgUser->isAllowed( 'review' ) )
			return true;
		if( !$this->parent->exists() || !FlaggedRevs::isPageReviewable( $this->parent->getTitle() ) )
			return true;

		$parserCache = ParserCache::singleton();
		$parserOut = $parserCache->get( $this->parent, $wgUser );
		if( $parserOut ) {
			# Clear older, incomplete, cached versions
			# We need the IDs of templates and timestamps of images used
			if( !isset($parserOut->fr_newestTemplateID) || !isset($parserOut->fr_newestImageTime) )
				$this->parent->getTitle()->invalidateCache();
		}
		return true;
	}
}
