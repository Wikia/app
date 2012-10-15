<?php

/**
 * Static class for hooks handled by the Survey extension.
 *
 * @since 0.1
 *
 * @file Survey.hooks.php
 * @ingroup Survey
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class SurveyHooks {
	
	/**
	 * Register the survey tag extension when the parser initializes.
	 * 
	 * @since 0.1
	 * 
	 * @param Parser $parser
	 * 
	 * @return true
	 */
	public static function onParserFirstCallInit( Parser &$parser ) {
		$parser->setHook( 'survey', __CLASS__ . '::onSurveyRender' );
		return true;
	}
	
	/**
	 * Render the survey tag.
	 * 
	 * @since 0.1
	 * 
	 * @param mixed $input
	 * @param array $args
	 * @param Parser $parser
	 * @param PPFrame $frame
	 */
	public static function onSurveyRender( $input, array $args, Parser $parser, PPFrame $frame ) {
		$tag = new SurveyTag( $args, $input );
		return $tag->render( $parser );
	}
	
	/**
	 * Schema update to set up the needed database tables.
	 *
	 * @since 0.1
	 *
	 * @param DatabaseUpdater $updater
	 *
	 * @return true
	 */
	public static function onSchemaUpdate( DatabaseUpdater $updater ) {
		global $wgDBtype;

		$updater->addExtensionUpdate( array(
			'addTable',
			'surveys',
			dirname( __FILE__ ) . '/sql/Survey.sql',
			true
		) );
		
		$updater->addExtensionUpdate( array(
			'addIndex',
			'surveys',
			'surveys_survey_title',
			dirname( __FILE__ ) . '/sql/AddMissingIndexes.sql',
			true
		) );

		return true;
	}
	
	/**
	 * Hook to add PHPUnit test cases.
	 * 
	 * @since 0.1
	 * 
	 * @param array $files
	 */
	public static function registerUnitTests( array &$files ) {
		$testDir = dirname( __FILE__ ) . '/test/';
		
		$files[] = $testDir . 'SurveyQuestionTest.php';
		
		return true;
	}
	
	/**
	 * Hook to insert things into article headers.
	 *
	 * @since 0.1
	 *
	 * @param Article &$article
	 * @param boolean $outputDone
	 * @param boolean $useParserCache
	 *
	 * @return true
	 */
	public static function onArticleViewHeader( Article &$article, &$outputDone, &$useParserCache ) {
		if ( !Survey::has( array( 'enabled' => 1 ) ) ) {
			return true;
		}
		
		$surveys = Survey::select(
			array(
				'id', 'namespaces', 'ratio', 'expiry', 'min_pages'
			),
			array(
				'enabled' => 1,
				'user_type' => Survey::getTypesForUser( $GLOBALS['wgUser'] )
			)
		);
		
		foreach ( $surveys as /* Survey */ $survey ) {
			
			if ( count( $survey->getField( 'namespaces' ) ) == 0 ) {
				$nsValid = true;
			}
			else {
				$nsValid = in_array( $article->getTitle()->getNamespace(), $survey->getField( 'namespaces' ) );
			}
			
			if ( $nsValid ) {
				$GLOBALS['wgOut']->addWikiText( Xml::element( 
					'survey',
					array(
						'id' => $survey->getId(),
						'ratio' => $survey->getField( 'ratio' ),
						'expiry' => $survey->getField( 'expiry' ),
						'min-pages' => $survey->getField( 'min_pages' ),
					)
				) );
			}
		}
		
		return true;
	}
	
	/**
	 * Adds a link to Admin Links page.
	 * 
	 * @since 0.1
	 * 
	 * @return true
	 */
	public static function addToAdminLinks( &$admin_links_tree ) {
		$section = new ALSection( 'Survey' );
		$row = new ALRow( 'smw' );
	    $row->addItem( AlItem::newFromSpecialPage( 'Surveys' ) );
		$section->addRow( $row );
		$admin_links_tree->addSection( $section, 'Survey' );
	    return true;
	}
	
}
