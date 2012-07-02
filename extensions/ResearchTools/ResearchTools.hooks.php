<?php
/**
 * Hooks for ResearchTools extension
 *
 * @file
 * @ingroup Extensions
 */

class ResearchToolsHooks {

	/* Protected Static Members */

	protected static $modules = array(
		'ext.researchTools' => array(
			'scripts' => 'ext.researchTools/ext.researchTools.js',
			'styles' => 'ext.researchTools/ext.researchTools.css',
		),
	);

	/* Static Methods */

	/**
	 * LoadExtensionSchemaUpdates hook
	 * @return Boolean: always true
	 */
	public static function loadExtensionSchemaUpdates( $updater = null ) {
		$dir = dirname( __FILE__ ) . '/';

		// Survey tables
		$updater->addExtensionTable(
			'research_tools_surveys', $dir . 'patches/CreateSurveysTable.sql'
		);
		$updater->addExtensionTable(
			'research_tools_survey_questions', $dir . 'patches/CreateSurveyQuestionsTable.sql'
		);
		$updater->addExtensionTable(
			'research_tools_survey_responses', $dir . 'patches/CreateSurveyResponsesTable.sql'
		);
		$updater->addExtensionTable(
			'research_tools_survey_answers', $dir . 'patches/CreateSurveyAnswersTable.sql'
		);

		return true;
	}

	/**
	 * ResourceLoaderRegisterModules hook
	 */
	public static function resourceLoaderRegisterModules( &$resourceLoader ) {
		global $wgExtensionAssetsPath;
		$localpath = dirname( __FILE__ ) . '/modules';
		$remotepath = "$wgExtensionAssetsPath/ResearchTools/modules";
		foreach ( self::$modules as $name => $resources ) {
			$resourceLoader->register(
				$name, new ResourceLoaderFileModule( $resources, $localpath, $remotepath )
			);
		}
		return true;
	}
}
