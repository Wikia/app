<?php
/**
 * Class containing UI setup functions for a FlaggedRevs environment.
 * This depends on config variables in LocalSettings.php.
 * Note: avoid  FlaggedRevs class calls here for performance (like load.php).
 */
class FlaggedRevsUISetup {
	/**
	 * Register FlaggedRevs hooks.
	 * @param $hooks Array $wgHooks (assoc array of hooks and handlers)
	 * @return void
	 */
	public static function defineHookHandlers( array &$hooks ) {
		global $wgFlaggedRevsProtection;

		# XXX: Don't mess with dumpHTML article view output...
		if ( !defined( 'MW_HTML_FOR_DUMP' ) ) {
			# Override current revision, set cache...
			$hooks['ArticleViewHeader'][] = 'FlaggedRevsUIHooks::onArticleViewHeader';
			$hooks['ImagePageFindFile'][] = 'FlaggedRevsUIHooks::onImagePageFindFile';
			# Override redirect behavior...
			$hooks['InitializeArticleMaybeRedirect'][] = 'FlaggedRevsUIHooks::overrideRedirect';
			# Set page view tabs (non-Vector)
			$hooks['SkinTemplateTabs'][] = 'FlaggedRevsUIHooks::onSkinTemplateTabs';
			# Set page view tabs (Vector)
			$hooks['SkinTemplateNavigation'][] = 'FlaggedRevsUIHooks::onSkinTemplateNavigation';
			# Add review form
			$hooks['SkinAfterContent'][] = 'FlaggedRevsUIHooks::onSkinAfterContent';
			# Show unreviewed pages links
			$hooks['CategoryPageView'][] = 'FlaggedRevsUIHooks::onCategoryPageView';
			# Mark items in file history (shown on page view)
			$hooks['LocalFile::getHistory'][] = 'FlaggedRevsUIHooks::addToFileHistQuery';
			$hooks['ImagePageFileHistoryLine'][] = 'FlaggedRevsUIHooks::addToFileHistLine';
			# Add review notice, backlog notices, protect form link, and CSS/JS and set robots
			$hooks['BeforePageDisplay'][] = 'FlaggedRevsUIHooks::onBeforePageDisplay';
		}

		# Add notice tags to edit view
		$hooks['EditPage::showEditForm:initial'][] = 'FlaggedRevsUIHooks::addToEditView';
		# Tweak submit button name/title
		$hooks['EditPageBeforeEditButtons'][] = 'FlaggedRevsUIHooks::onBeforeEditButtons';
		# Autoreview information from form
		$hooks['EditPageBeforeEditChecks'][] = 'FlaggedRevsUIHooks::addReviewCheck';
		$hooks['EditPage::showEditForm:fields'][] = 'FlaggedRevsUIHooks::addRevisionIDField';
		# Add draft link to section edit error
		$hooks['EditPageNoSuchSection'][] = 'FlaggedRevsUIHooks::onNoSuchSection';
		# Page review on edit
		$hooks['ArticleUpdateBeforeRedirect'][] = 'FlaggedRevsUIHooks::injectPostEditURLParams';

		# Mark items in page history
		$hooks['PageHistoryPager::getQueryInfo'][] = 'FlaggedRevsUIHooks::addToHistQuery';
		$hooks['PageHistoryLineEnding'][] = 'FlaggedRevsUIHooks::addToHistLine';
		# Select extra info & filter items in RC
		$hooks['SpecialRecentChangesQuery'][] = 'FlaggedRevsUIHooks::modifyRecentChangesQuery';
		$hooks['SpecialNewpagesConditions'][] = 'FlaggedRevsUIHooks::modifyNewPagesQuery';
		$hooks['SpecialWatchlistQuery'][] = 'FlaggedRevsUIHooks::modifyChangesListQuery';
		# Mark items in RC
		$hooks['ChangesListInsertArticleLink'][] = 'FlaggedRevsUIHooks::addToChangeListLine';
		if ( !$wgFlaggedRevsProtection ) {
			# Mark items in user contribs
			$hooks['ContribsPager::getQueryInfo'][] = 'FlaggedRevsUIHooks::addToContribsQuery';
			$hooks['ContributionsLineEnding'][] = 'FlaggedRevsUIHooks::addToContribsLine';
		} 

		# RC filter UIs
		$hooks['SpecialNewPagesFilters'][] = 'FlaggedRevsUIHooks::addHideReviewedFilter';
		$hooks['SpecialRecentChangesFilters'][] = 'FlaggedRevsUIHooks::addHideReviewedFilter';
		$hooks['SpecialWatchlistFilters'][] = 'FlaggedRevsUIHooks::addHideReviewedFilter';
		# Add notice tags to history
		$hooks['PageHistoryBeforeList'][] = 'FlaggedRevsUIHooks::addToHistView';
		# Diff-to-stable
		$hooks['DiffViewHeader'][] = 'FlaggedRevsUIHooks::onDiffViewHeader';
		# Add diff=review url param alias
		$hooks['NewDifferenceEngine'][] = 'FlaggedRevsUIHooks::checkDiffUrl';
		# Local user account preference
		$hooks['GetPreferences'][] = 'FlaggedRevsUIHooks::onGetPreferences';
		# Review/stability log links
		$hooks['LogLine'][] = 'FlaggedRevsUIHooks::logLineLinks';
		# Add global JS vars
		$hooks['MakeGlobalVariablesScript'][] = 'FlaggedRevsUIHooks::injectGlobalJSVars';

		if ( $wgFlaggedRevsProtection ) {
			# Add protection form field
			$hooks['ProtectionForm::buildForm'][] = 'FlaggedRevsUIHooks::onProtectionForm';
			$hooks['ProtectionForm::showLogExtract'][] = 'FlaggedRevsUIHooks::insertStabilityLog';
			# Save stability settings
			$hooks['ProtectionForm::save'][] = 'FlaggedRevsUIHooks::onProtectionSave';
		}
	}

	/**
	 * Register FlaggedRevs special pages as needed.
	 * @param $pages Array $wgSpecialPages (list of special pages)
	 * @param $groups Array $wgSpecialPageGroups (assoc array of special page groups)
	 * @param $updates Array $wgSpecialPageCacheUpdates (assoc array of special page updaters)
	 * @return void
	 */
	public static function defineSpecialPages( array &$pages, array &$groups, array &$updates ) {
		global $wgFlaggedRevsProtection, $wgFlaggedRevsNamespaces, $wgUseTagFilter;

		// Show special pages only if FlaggedRevs is enabled on some namespaces
		if ( count( $wgFlaggedRevsNamespaces ) ) {
			$pages['RevisionReview'] = 'RevisionReview'; // unlisted
			$pages['ReviewedVersions'] = 'ReviewedVersions'; // unlisted
			$pages['PendingChanges'] = 'PendingChanges';
			$groups['PendingChanges'] = 'quality';
			// Show tag filtered pending edit page if there are tags
			if ( $wgUseTagFilter ) {
				$pages['ProblemChanges'] = 'ProblemChanges';
				$groups['ProblemChanges'] = 'quality';
			}
			if ( !$wgFlaggedRevsProtection ) {
				$pages['ReviewedPages'] = 'ReviewedPages';
				$groups['ReviewedPages'] = 'quality';
				$pages['UnreviewedPages'] = 'UnreviewedPages';
				$groups['UnreviewedPages'] = 'quality';
				$updates['UnreviewedPages'] = 'UnreviewedPages::updateQueryCache';
			}
			$pages['QualityOversight'] = 'QualityOversight';
			$groups['QualityOversight'] = 'quality';
			$pages['ValidationStatistics'] = 'ValidationStatistics';
			$groups['ValidationStatistics'] = 'quality';
			$updates['ValidationStatistics'] = 'FlaggedRevsStats::updateCache';
			// Protect levels define allowed stability settings
			if ( $wgFlaggedRevsProtection ) {
				$pages['StablePages'] = 'StablePages';
				$groups['StablePages'] = 'quality';
			} else {
				$pages['ConfiguredPages'] = 'ConfiguredPages';
				$groups['ConfiguredPages'] = 'quality';
				$pages['Stabilization'] = 'Stabilization'; // unlisted
			}
		}
	}

	/**
	 * Append FlaggedRevs resource module definitions
	 * @param $modules Array $wgResourceModules (list of modules)
	 * @return void
	 */
	public static function defineResourceModules( array &$modules ) {
		$localModulePath = dirname( __FILE__ ) . '/modules/';
		$remoteModulePath = 'FlaggedRevs/frontend/modules';
		$modules['ext.flaggedRevs.basic'] = array(
			'styles'        => array( 'ext.flaggedRevs.basic.css' ),
			'localBasePath' => $localModulePath,
			'remoteExtPath' => $remoteModulePath,
		);
		$modules['ext.flaggedRevs.advanced'] = array(
			'scripts'       => array( 'ext.flaggedRevs.advanced.js' ),
			'messages'      => array(
				'revreview-toggle-show', 'revreview-toggle-hide',
				'revreview-diff-toggle-show', 'revreview-diff-toggle-hide',
				'revreview-log-toggle-show', 'revreview-log-toggle-hide',
				'revreview-log-details-show', 'revreview-log-details-hide'
			),
			'dependencies'  => array( 'mediawiki.util' ),
			'localBasePath' => $localModulePath,
			'remoteExtPath' => $remoteModulePath,
		);
		$modules['ext.flaggedRevs.review'] = array(
			'scripts'       => array( 'ext.flaggedRevs.review.js' ),
			'styles'        => array( 'ext.flaggedRevs.review.css' ),
			'messages'      => array(
				'savearticle', 'tooltip-save', 'accesskey-save',
				'revreview-submitedit', 'revreview-submitedit-title',
				'revreview-submit-review', 'revreview-submit-unreview',
				'revreview-submit-reviewed', 'revreview-submit-unreviewed',
				'revreview-submitting', 'actioncomplete', 'actionfailed',
				'revreview-adv-reviewing-p', 'revreview-adv-reviewing-c',
				'revreview-sadv-reviewing-p', 'revreview-sadv-reviewing-c',
				'revreview-adv-start-link', 'revreview-adv-stop-link'
			),
			'dependencies'  => array( 'mediawiki.util' ),
			'localBasePath' => $localModulePath,
			'remoteExtPath' => $remoteModulePath,
		);
	}

	/**
	 * Define AJAX dispatcher functions
	 * @param $ajaxExportList Array $wgAjaxExportList
	 * @return void
	 */
	public static function defineAjaxFunctions( array &$ajaxExportList ) {
		$ajaxExportList[] = 'RevisionReview::AjaxReview';
		$ajaxExportList[] = 'FlaggablePageView::AjaxBuildDiffHeaderItems';
	}

	/**
	 * Append FlaggedRevs log names and set filterable logs
	 * @param $logNames Array $wgLogNames (assoc array of log name message keys)
	 * @param $logHeaders Array $wgLogHeaders (assoc array of log header message keys)
	 * @param $filterLogTypes Array $wgFilterLogTypes
	 * @return void
	 */
	public static function defineLogBasicDescription(
		array &$logNames, array &$logHeaders, array &$filterLogTypes
	) {
		$logNames['review'] = 'review-logpage';
		$logHeaders['review'] = 'review-logpagetext';

		$logNames['stable'] = 'stable-logpage';
		$logHeaders['stable'] = 'stable-logpagetext';

		$filterLogTypes['review'] = true;
	}

	/**
	 * Append FlaggedRevs log action handlers
	 * @param $logActions Array $wgLogActions (assoc array of log action message keys)
	 * @param $logActionsHandlers Array $wgLogActionsHandlers (assoc array of log handlers)
	 * @return void
	 */
	public static function defineLogActionHandlers(
		array &$logActions, array &$logActionsHandlers
	) {
		# Various actions are used for log filtering ...
		$logActions['review/approve']  = 'review-logentry-app'; // checked (again)
		$logActions['review/approve2']  = 'review-logentry-app'; // quality (again)
		$logActions['review/approve-i']  = 'review-logentry-app'; // checked (first time)
		$logActions['review/approve2-i']  = 'review-logentry-app'; // quality (first time)
		$logActions['review/approve-a']  = 'review-logentry-app'; // checked (auto)
		$logActions['review/approve2-a']  = 'review-logentry-app'; // quality (auto)
		$logActions['review/approve-ia']  = 'review-logentry-app'; // checked (initial & auto)
		$logActions['review/approve2-ia']  = 'review-logentry-app'; // quality (initial & auto)
		$logActions['review/unapprove'] = 'review-logentry-dis'; // was checked
		$logActions['review/unapprove2'] = 'review-logentry-dis'; // was quality

		# B/C ...
		$logActions['rights/erevoke']  = 'rights-editor-revoke';

		$logActionsHandlers['stable/config'] = 'FlaggedRevsLogView::stabilityLogText'; // customize
		$logActionsHandlers['stable/modify'] = 'FlaggedRevsLogView::stabilityLogText'; // re-customize
		$logActionsHandlers['stable/reset'] = 'FlaggedRevsLogView::stabilityLogText'; // reset
	}
}
