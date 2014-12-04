<?php
/**
 * Hooks for ArticleFeedback
 *
 * @file
 * @ingroup Extensions
 */

class ArticleFeedbackHooks {

	protected static $modules = array(
		'ext.articleFeedback.startup' => array(
			'scripts' => 'ext.articleFeedback/ext.articleFeedback.startup.js',
			'dependencies' => array(
				'mediawiki.util',
				'mediawiki.user',
			),
		),
		'ext.articleFeedback' => array(
			'scripts' => 'ext.articleFeedback/ext.articleFeedback.js',
			'styles' => 'ext.articleFeedback/ext.articleFeedback.css',
			'messages' => array(
				'articlefeedback-pitch-reject',
				'articlefeedback-pitch-or',
				'articlefeedback-pitch-thanks',
				'articlefeedback-pitch-survey-message',
				'articlefeedback-pitch-survey-body',
				'articlefeedback-pitch-survey-accept',
				'articlefeedback-pitch-join-message',
				'articlefeedback-pitch-join-body',
				'articlefeedback-pitch-join-accept',
				'articlefeedback-pitch-join-login',
				'articlefeedback-pitch-edit-message',
				'articlefeedback-pitch-edit-body',
				'articlefeedback-pitch-edit-accept',
				'articlefeedback-survey-title',
				'articlefeedback-survey-message-success',
				'articlefeedback-survey-message-error',
				'articlefeedback-survey-disclaimer',
				'articlefeedback-survey-disclaimerlink',
				'articlefeedback-privacyurl'
			),
			'dependencies' => array(
				'jquery.ui.dialog',
				'jquery.ui.button',
				'jquery.articleFeedback',
				'jquery.cookie',
				'jquery.clickTracking',
				'ext.articleFeedback.ratingi18n',
			),
		),
		'ext.articleFeedback.ratingi18n' => array(
			'messages' => null, // Filled in by the resourceLoaderRegisterModules() hook function later
		),
		'ext.articleFeedback.dashboard' => array(
			'scripts' => 'ext.articleFeedback/ext.articleFeedback.dashboard.js',
			'styles' => 'ext.articleFeedback/ext.articleFeedback.dashboard.css',
		),
		'jquery.articleFeedback' => array(
			'scripts' => 'jquery.articleFeedback/jquery.articleFeedback.js',
			'styles' => 'jquery.articleFeedback/jquery.articleFeedback.css',
			'messages' => array(
				'articlefeedback-error',
				'articlefeedback-form-switch-label',
				'articlefeedback-form-panel-title',
				'articlefeedback-form-panel-explanation',
				'articlefeedback-form-panel-explanation-link',
				'articlefeedback-form-panel-clear',
				'articlefeedback-form-panel-expertise',
				'articlefeedback-form-panel-expertise-studies',
				'articlefeedback-form-panel-expertise-profession',
				'articlefeedback-form-panel-expertise-hobby',
				'articlefeedback-form-panel-expertise-other',
				'articlefeedback-form-panel-helpimprove',
				'articlefeedback-form-panel-helpimprove-note',
				'articlefeedback-form-panel-helpimprove-email-placeholder',
				'articlefeedback-form-panel-helpimprove-privacy',
				'articlefeedback-form-panel-submit',
				'articlefeedback-form-panel-success',
				'articlefeedback-form-panel-pending',
				'articlefeedback-form-panel-expiry-title',
				'articlefeedback-form-panel-expiry-message',
				'articlefeedback-report-switch-label',
				'articlefeedback-report-panel-title',
				'articlefeedback-report-panel-description',
				'articlefeedback-report-empty',
				'articlefeedback-report-ratings',
				'articlefeedback-privacyurl'
			),
			'dependencies' => array(
				'jquery.appear',
				'jquery.tipsy',
				'jquery.json',
				'jquery.localize',
				'jquery.ui.dialog',
				'jquery.ui.button',
				'jquery.cookie',
				'jquery.clickTracking',
				'mediawiki.language',
			),
		),
	);

	/* Static Methods */

	/**
	 * LoadExtensionSchemaUpdates hook
	 *
	 * @param $updater DatabaseUpdater
	 *
	 * @return bool
	 */
	public static function loadExtensionSchemaUpdates( $updater = null ) {
		$dir = dirname( __FILE__ );
		$db = $updater->getDB();

		// Initial install tables
		$updater->addExtensionUpdate( array(
			'addTable',
			'article_feedback',
			$dir . '/sql/ArticleFeedback.sql',
			true
		) );

		$updater->addExtensionUpdate( array(
			'addTable',
			'article_feedback',
			$dir . '/sql/RenameTables.sql',
			true
		) );

		$updater->addExtensionUpdate( array(
			'addIndex',
			'article_feedback',
			'aa_page_id',
			$dir . '/sql/AddArticleFeedbackPageIndex.sql',
			true
		) );

		$updater->addExtensionUpdate( array(
			'addField',
			'article_feedback',
			'aa_design_bucket',
			$dir . '/sql/AddRatingBucket.sql',
			true
		) );

		$updater->addExtensionUpdate( array(
			'addField',
			'article_feedback_properties',
			'afp_value_text',
			$dir . '/sql/AddPropertiesValueText.sql',
			true
		) );

		$updater->addExtensionUpdate( array(
			'addTable',
			'article_feedback_properties',
			$dir . '/sql/AddPropertiesTable.sql',
			true
		) );
		$updater->addExtensionUpdate( array(
			'applyPatch',
			$dir . '/sql/FixAnonTokenSchema.sql',
			true
		) );
		$updater->addExtensionUpdate( array(
			'applyPatch',
			$dir . '/sql/FixPropertiesAnonTokenSchema.sql',
			true
		) );
		$updater->addExtensionUpdate( array(
			'addTable',
			'article_feedback_revisions',
			$dir . '/sql/AddRevisionsTable.sql',
			true
		) );

		// add article_feedback_stats_type if necessaray
		$updater->addExtensionUpdate( array(
			'addTable',
			'article_feedback_stats_types',
			$dir . '/sql/AddArticleFeedbackStatsTypeTable.sql',
			true
		) );

		$updater->addExtensionUpdate( array(
			'addTable',
			'article_feedback_stats',
			$dir . '/sql/AddArticleFeedbackStatsTable.sql',
			true
		) );

		// migrate article_feedback_stats_highs_lows to article_feedback_stats
		if ( $db->tableExists( 'article_feedback_stats_highs_lows' ) ) {
			$updater->addExtensionUpdate( array(
				'applyPatch',
				$dir . '/sql/MigrateArticleFeedbackStatsHighsLows.sql',
				true
			) );
		}

		$updater->addExtensionUpdate( array(
			'addIndex',
			'article_feedback',
			'article_feedback_timestamp',
			$dir . '/sql/AddArticleFeedbackTimestampIndex.sql',
			true
		) );
		
		$updater->addExtensionUpdate( array(
			'addIndex',
			'article_feedback',
			'aa_page_user_token',
			$dir . '/sql/aa_page_user_token.sql',
			true
		) );
		
		$updater->addExtensionUpdate( array(
			'dropIndex',
			'article_feedback',
			'aa_user_page_revision',
			$dir . '/sql/delete-aa_user_page_revision.sql',
			true
		) );

		return true;
	}

	/**
	 * ParserTestTables hook
	 */
	public static function parserTestTables( &$tables ) {
		$tables[] = 'article_feedback';
		$tables[] = 'article_feedback_pages';
		$tables[] = 'article_feedback_revisions';
		$tables[] = 'article_feedback_properties';
		return true;
	}

	/**
	 * BeforePageDisplay hook
	 */
	public static function beforePageDisplay( $out ) {
		$out->addModules( 'ext.articleFeedback.startup' );
		return true;
	}

	/**
	 * ResourceLoaderRegisterModules hook
	 */
	public static function resourceLoaderRegisterModules( &$resourceLoader ) {
		global $wgExtensionAssetsPath;
		$localpath = dirname( __FILE__ ) . '/modules';
		$remotepath = "$wgExtensionAssetsPath/ArticleFeedback/modules";
		
		if ( self::$modules['ext.articleFeedback.ratingi18n']['messages'] === null ) {
			self::$modules['ext.articleFeedback.ratingi18n']['messages'] = self::buildRatingMessagesArray();
		}
		
		foreach ( self::$modules as $name => $resources ) {
			$resourceLoader->register(
				$name, new ResourceLoaderFileModule( $resources, $localpath, $remotepath )
			);
		}
		return true;
	}

	/**
	 * ResourceLoaderGetConfigVars hook
	 */
	public static function resourceLoaderGetConfigVars( &$vars ) {
		global $wgArticleFeedbackSMaxage,
			$wgArticleFeedbackCategories,
			$wgArticleFeedbackBlacklistCategories,
			$wgArticleFeedbackLotteryOdds,
			$wgArticleFeedbackTracking,
			$wgArticleFeedbackOptions,
			$wgArticleFeedbackNamespaces,
			$wgArticleFeedbackRatingTypes;
		$vars['wgArticleFeedbackSMaxage'] = $wgArticleFeedbackSMaxage;
		$vars['wgArticleFeedbackCategories'] = $wgArticleFeedbackCategories;
		$vars['wgArticleFeedbackBlacklistCategories'] = $wgArticleFeedbackBlacklistCategories;
		$vars['wgArticleFeedbackLotteryOdds'] = $wgArticleFeedbackLotteryOdds;
		$vars['wgArticleFeedbackTracking'] = $wgArticleFeedbackTracking;
		$vars['wgArticleFeedbackOptions'] = $wgArticleFeedbackOptions;
		$vars['wgArticleFeedbackNamespaces'] = $wgArticleFeedbackNamespaces;
		$vars['wgArticleFeedbackWhatsThisPage'] = wfMsgForContent( 'articlefeedback-form-panel-explanation-link' );
		$vars['wgArticleFeedbackRatingTypesFlipped'] = array_flip( $wgArticleFeedbackRatingTypes );
		return true;
	}

	/**
	 * Add the preference in the user preferences with the GetPreferences hook.
	 * @param $user User
	 * @param $preferences
	 */
	public static function getPreferences( $user, &$preferences ) {
		$preferences['articlefeedback-disable'] = array(
			'type' => 'check',
			'section' => 'rendering/advancedrendering',
			'label-message' => 'articlefeedback-disable-preference',
		);
		return true;
	}
	
	protected static function buildRatingMessagesArray() {
		global $wgArticleFeedbackRatingTypes;
		$messages = array();
		foreach ( $wgArticleFeedbackRatingTypes as $key ) {
			foreach ( array( 'label', 'tip', 'tooltip-1', 'tooltip-2', 'tooltip-3', 'tooltip-4', 'tooltip-5' ) as $suffix ) {
				$messages[] = "articlefeedback-field-$key-$suffix";
			}
		}
		return $messages;
	}
}
