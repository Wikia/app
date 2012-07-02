<?php
/**
 * Class containing stability settings form business logic
 */
abstract class PageStabilityForm extends FRGenericSubmitForm {
	/* Form parameters which can be user given */
	protected $page = false;            # Target page obj
	protected $watchThis = null;        # Watch checkbox
	protected $reviewThis = null;       # Auto-review option...
	protected $reasonExtra = '';        # Custom/extra reason
	protected $reasonSelection = '';    # Reason dropdown key
	protected $expiryCustom = '';       # Custom expiry
	protected $expirySelection = '';    # Expiry dropdown key
	protected $override = -1;           # Default version
	protected $autoreview = '';         # Autoreview restrictions...

	protected $oldConfig = array(); # Old page config

	public function getPage() {
		return $this->page;
	}

	public function setPage( Title $value ) {
		$this->trySet( $this->page, $value );
	}

	public function getWatchThis() {
		return $this->watchThis;
	}

	public function setWatchThis( $value ) {
		$this->trySet( $this->watchThis, $value );
	}

	public function getReasonExtra() {
		return $this->reasonExtra;
	}

	public function setReasonExtra( $value ) {
		$this->trySet( $this->reasonExtra, $value );
	}

	public function getReasonSelection() {
		return $this->reasonSelection;
	}

	public function setReasonSelection( $value ) {
		$this->trySet( $this->reasonSelection, $value );
	}

	public function getExpiryCustom() {
		return $this->expiryCustom;
	}

	public function setExpiryCustom( $value ) {
		$this->trySet( $this->expiryCustom, $value );
	}

	public function getExpirySelection() {
		return $this->expirySelection;
	}

	public function setExpirySelection( $value ) {
		$this->trySet( $this->expirySelection, $value );
	}

	public function getAutoreview() {
		return $this->autoreview;
	}

	public function setAutoreview( $value ) {
		$this->trySet( $this->autoreview, $value );
	}

	/*
	 * Get the final expiry, all inputs considered
	 * Note: does not check if the expiration is less than wfTimestampNow()
	 * @return 14-char timestamp or "infinity", or false if the input was invalid
	 */
	public function getExpiry() {
		$oldConfig = $this->getOldConfig();
		if ( $this->expirySelection == 'existing' ) {
			return $oldConfig['expiry'];
		} elseif ( $this->expirySelection == 'othertime' ) {
			$value = $this->expiryCustom;
		} else {
			$value = $this->expirySelection;
		}
		if ( $value == 'infinite' || $value == 'indefinite' || $value == 'infinity' ) {
			$time = Block::infinity();
		} else {
			$unix = strtotime( $value );
			# On error returns -1 for PHP <5.1 and false for PHP >=5.1
			if ( !$unix || $unix === -1 ) {
				return false;
			}
			// FIXME: non-qualified absolute times are not in users
			// specified timezone and there isn't notice about it in the ui
			$time = wfTimestamp( TS_MW, $unix );
		}
		return $time;
	}

	/*
	 * Get the final reason, all inputs considered
	 * @return string
	 */
	public function getReason() {
		# Custom reason replaces dropdown
		if ( $this->reasonSelection != 'other' ) {
			$comment = $this->reasonSelection; // start with dropdown reason
			if ( $this->reasonExtra != '' ) {
				# Append custom reason
				$comment .= wfMsgForContent( 'colon-separator' ) . $this->reasonExtra;
			}
		} else {
			$comment = $this->reasonExtra; // just use custom reason
		}
		return $comment;
	}

	/*
	 * Check that a target is given (e.g. from GET/POST request)
	 * @return mixed (true on success, error string on failure)
	 */
	protected function doCheckTargetGiven() {
		if ( is_null( $this->page ) ) {
			return 'stabilize_page_invalid';
		}
		return true;
	}

	/*
	 * Check that the target page is valid
	 * @param int $flags FOR_SUBMISSION (set on submit)
	 * @return mixed (true on success, error string on failure)
	 */
	protected function doCheckTarget( $flags = 0 ) {
		$flgs = ( $flags & self::FOR_SUBMISSION ) ? Title::GAID_FOR_UPDATE : 0;
		if ( !$this->page->getArticleId( $flgs ) ) {
			return 'stabilize_page_notexists';
		} elseif ( !FlaggedRevs::inReviewNamespace( $this->page ) ) {
			return 'stabilize_page_unreviewable';
		}
		return true;
	}

	/*
	 * Verify and clean up parameters (e.g. from POST request)
	 * @return mixed (true on success, error string on failure)
	 */
	protected function doCheckParameters() {
		# Load old config settings from the master
		$this->oldConfig = FRPageConfig::getStabilitySettings( $this->page, FR_MASTER );
		if ( $this->expiryCustom != '' ) {
			// Custom expiry takes precedence
			$this->expirySelection = 'othertime';
		}
		$status = $this->reallyDoCheckParameters(); // check other params...
		return $status;
	}

	/*
	 * @return mixed (true on success, error string on failure)
	 */
	protected function reallyDoCheckParameters() {
		return true;
	}

	/*
	 * Can the user change the settings for this page?
	 * Note: if the current autoreview restriction is too high for this user
	 *       then this will return false. Useful for form selectors.
	 * @return bool
	 */
	public function isAllowed() {
		# Users who cannot edit or review the page cannot set this
		return ( $this->page
			&& $this->page->userCan( 'stablesettings' )
			&& $this->page->userCan( 'edit' )
			&& $this->page->userCan( 'review' )
		);
	}

	/*
	 * Preload existing page settings (e.g. from GET request).
	 * @return mixed (true on success, error string on failure)
	 */
	public function doPreloadParameters() {
		$oldConfig = $this->getOldConfig();
		if ( $oldConfig['expiry'] == Block::infinity() ) {
			$this->expirySelection = 'infinite'; // no settings set OR indefinite
		} else {
			$this->expirySelection = 'existing'; // settings set and NOT indefinite
		}
		return $this->reallyDoPreloadParameters(); // load the params...
	}

	/*
	 * @return mixed (true on success, error string on failure)
	 */  
	protected function reallyDoPreloadParameters() {
		return true;
	}

	/**
	 * Submit the form parameters for the page config to the DB.
	 * 
	 * @return mixed (true on success, error string on failure)
	 */
	public function doSubmit() {
		# Double-check permissions
		if ( !$this->isAllowed() ) {
			return 'stablize_denied';
		}
		# Parse and cleanup the expiry time given...
		$expiry = $this->getExpiry();
		if ( $expiry === false ) {
			return 'stabilize_expiry_invalid';
		} elseif ( $expiry !== Block::infinity() && $expiry < wfTimestampNow() ) {
			return 'stabilize_expiry_old';
		}
		# Update the DB row with the new config...
		$changed = FRPageConfig::setStabilitySettings( $this->page, $this->getNewConfig() );
		# Log if this actually changed anything...
		if ( $changed ) {
			$article = new FlaggableWikiPage( $this->page );
			if ( FlaggedRevs::useOnlyIfProtected() ) {
				# Config may have changed to allow stable versions, so refresh
				# the tracking table to account for any hidden reviewed versions...
				$frev = FlaggedRevision::determineStable( $this->page, FR_MASTER );
				if ( $frev ) {
					$article->updateStableVersion( $frev );
				} else {
					$article->clearStableVersion();
				}
			}
			# Update logs and make a null edit
			$nullRev = $this->updateLogsAndHistory( $article );
			# Null edit may have been auto-reviewed already
			$frev = FlaggedRevision::newFromTitle( $this->page, $nullRev->getId(), FR_MASTER );
			$updatesDone = (bool)$frev; // stableVersionUpdates() already called?
			# Check if this null edit is to be reviewed...
			if ( $this->reviewThis && !$frev ) {
				$flags = null;
				# Review this revision of the page...
				$ok = FlaggedRevs::autoReviewEdit( $article, $this->user, $nullRev, $flags, true );
				if ( $ok ) {
					FlaggedRevs::markRevisionPatrolled( $nullRev ); // reviewed -> patrolled
					$updatesDone = true; // stableVersionUpdates() already called
				}
			}
			# Update page and tracking tables and clear cache.
			if ( !$updatesDone ) {
				FlaggedRevs::stableVersionUpdates( $this->page );
			}
		}
		# Apply watchlist checkbox value (may be NULL)
		$this->updateWatchlist();
		# Take this opportunity to purge out expired configurations
		FRPageConfig::purgeExpiredConfigurations();
		return true;
	}

	/*
	 * Do history & log updates:
	 * (a) Add a new stability log entry
	 * (b) Add a null edit like the log entry
	 * @return Revision
	 */
	protected function updateLogsAndHistory( FlaggableWikiPage $article ) {
		global $wgContLang;
		$newConfig = $this->getNewConfig();
		$oldConfig = $this->getOldConfig();
		$reason = $this->getReason();

		# Insert stability log entry...
		FlaggedRevsLog::updateStabilityLog( $this->page, $newConfig, $oldConfig, $reason );

		# Build null-edit comment...<action: reason [settings] (expiry)>
		if ( FRPageConfig::configIsReset( $newConfig ) ) {
			$type = "stable-logentry-reset";
			$settings = ''; // no level, expiry info
		} else {
			$type = "stable-logentry-config";
			// Settings message in text form (e.g. [x=a,y=b,z])
			$params = FlaggedRevsLog::stabilityLogParams( $newConfig );
			$settings = FlaggedRevsLogView::stabilitySettings( $params, true /*content*/ );
		}
		$comment = $wgContLang->ucfirst(
			wfMsgForContent( $type, $this->page->getPrefixedText() ) ); // action
		if ( $reason != '' ) {
			$comment .= wfMsgForContent( 'colon-separator' ) . $reason; // add reason
		}
		if ( $settings != '' ) {
			$comment .= " {$settings}"; // add settings
		}

		# Insert a null revision...
		$dbw = wfGetDB( DB_MASTER );
		$nullRev = Revision::newNullRevision( $dbw, $article->getId(), $comment, true );
		$nullRev->insertOn( $dbw );
		# Update page record and touch page
		$oldLatest = $nullRev->getParentId();
		$article->updateRevisionOn( $dbw, $nullRev, $oldLatest );
		wfRunHooks( 'NewRevisionFromEditComplete',
			array( $article, $nullRev, $oldLatest, $this->user ) );

		# Return null Revision object for autoreview check
		return $nullRev;
	}

	/*
	 * Get current stability config array
	 * @return array
	 */
	public function getOldConfig() {
		if ( $this->getState() == self::FORM_UNREADY ) {
			throw new MWException( __CLASS__ . " input fields not set yet.\n");
		}
		if ( $this->oldConfig === array() && $this->page ) {
			$this->oldConfig = FRPageConfig::getStabilitySettings( $this->page );
		}
		return $this->oldConfig;
	}

	/*
	 * Get proposed stability config array
	 * @return array
	 */
	public function getNewConfig() {
		return array(
			'override'   => $this->override,
			'autoreview' => $this->autoreview,
			'expiry'     => $this->getExpiry(), // TS_MW/infinity
		);
	}

	/*
	 * (a) Watch page if $watchThis is true
	 * (b) Unwatch if $watchThis is false
	 */
	protected function updateWatchlist() {
		# Apply watchlist checkbox value (may be NULL)
		if ( $this->watchThis === true ) {
			$this->user->addWatch( $this->page );
		} elseif ( $this->watchThis === false ) {
			$this->user->removeWatch( $this->page );
		}
	}
}

// Assumes $wgFlaggedRevsProtection is off
class PageStabilityGeneralForm extends PageStabilityForm {
	public function getReviewThis() {
		return $this->reviewThis;
	}

	public function setReviewThis( $value ) {
		$this->trySet( $this->reviewThis, $value );
	}

	public function getOverride() {
		return $this->override;
	}

	public function setOverride( $value ) {
		$this->trySet( $this->override, $value );
	}

	protected function reallyDoPreloadParameters() {
		$oldConfig = $this->getOldConfig();
		$this->override = $oldConfig['override'];
		$this->autoreview = $oldConfig['autoreview'];
		$this->watchThis = $this->page->userIsWatching();
		return true;
	}

	protected function reallyDoCheckParameters() {
		$this->override = $this->override ? 1 : 0; // default version settings is 0 or 1
		// Check autoreview restriction setting
		if ( $this->autoreview != '' // restriction other than 'none'
			&& !in_array( $this->autoreview, FlaggedRevs::getRestrictionLevels() ) )
		{
			return 'stabilize_invalid_autoreview'; // invalid value
		}
		if ( !FlaggedRevs::userCanSetAutoreviewLevel( $this->user, $this->autoreview ) ) {
			return 'stabilize_denied'; // invalid value
		}
		return true;
	}
}

// Assumes $wgFlaggedRevsProtection is on
class PageStabilityProtectForm extends PageStabilityForm {
	protected function reallyDoPreloadParameters() {
		$oldConfig = $this->getOldConfig();
		$this->autoreview = $oldConfig['autoreview']; // protect level
		$this->watchThis = $this->page->userIsWatching();
		return true;
	}

	protected function reallyDoCheckParameters() {
		# WMF temp hack...protection limit quota
		global $wgFlaggedRevsProtectQuota;
		$oldConfig = $this->getOldConfig();
		if ( isset( $wgFlaggedRevsProtectQuota ) // quota exists
			&& $this->autoreview != '' // and we are protecting
			&& FRPageConfig::getProtectionLevel( $oldConfig ) == 'none' ) // unprotected
		{
			$dbw = wfGetDB( DB_MASTER );
			$count = $dbw->selectField( 'flaggedpage_config', 'COUNT(*)', '', __METHOD__ );
			if ( $count >= $wgFlaggedRevsProtectQuota ) {
				return 'stabilize_protect_quota';
			}
		}
		# Autoreview only when protecting currently unprotected pages
		$this->reviewThis = ( FRPageConfig::getProtectionLevel( $oldConfig ) == 'none' );
		# Autoreview restriction => use stable
		# No autoreview restriction => site default
		$this->override = ( $this->autoreview != '' )
			? 1 // edits require review before being published
			: (int)FlaggedRevs::isStableShownByDefault(); // site default
		# Check that settings are a valid protection level...
		$newConfig = array(
			'override'   => $this->override,
			'autoreview' => $this->autoreview
		);
		if ( FRPageConfig::getProtectionLevel( $newConfig ) == 'invalid' ) {
			return 'stabilize_invalid_level'; // double-check configuration
		}
		# Check autoreview restriction setting
		if ( !FlaggedRevs::userCanSetAutoreviewLevel( $this->user, $this->autoreview ) ) {
			return 'stabilize_denied'; // invalid value
		}
		return true;
	}
}
