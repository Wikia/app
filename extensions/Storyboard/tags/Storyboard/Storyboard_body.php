<?php

/**
 * File holding the rendering function for the Storyboard tag.
 *
 * @file Storyboard_body.php
 * @ingroup Storyboard
 *
 * @author Jeroen De Dauw
 * @author Roan Kattouw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class TagStoryboard {

	/**
	 * Renders the storyboard tag.
	 * 
	 * @param $input
	 * @param array $args
	 * @param Parser $parser
	 * @param $frame
	 * 
	 * @return array
	 */
	public static function render( $input, array $args, Parser $parser, $frame ) {
		global $wgScriptPath, $wgStylePath, $wgStyleVersion, $wgContLanguageCode;
		global $egStoryboardScriptPath, $egStoryboardWidth, $egStoryboardHeight;
		
		efStoryboardAddJSLocalisation( $parser );
		
		// TODO: Combine+minfiy JS files, add switch to use combined+minified version
		$parser->getOutput()->addHeadItem(
			Html::linkedStyle( "$egStoryboardScriptPath/storyboard.css?$wgStyleVersion" ) .				
			Html::linkedScript( "$wgStylePath/common/jquery.min.js?$wgStyleVersion" ) .			
			Html::linkedScript( "$egStoryboardScriptPath/jquery/jquery.ajaxscroll.js?$wgStyleVersion" ) .	
			Html::linkedScript( "$egStoryboardScriptPath/tags/Storyboard/storyboard.js?$wgStyleVersion" ) .
			Html::linkedScript( "$egStoryboardScriptPath/storyboard.js?$wgStyleVersion" )			
		);
		
		$width = StoryboardUtils::getDimension( $args, 'width', $egStoryboardWidth );
		$height = StoryboardUtils::getDimension( $args, 'height', $egStoryboardHeight );

		$languages = Language::getLanguageNames();
		
		if ( array_key_exists( 'language', $args ) && array_key_exists( $args['language'], $languages )  ) {
			$language = $args['language'];
		} else {
			$language = $wgContLanguageCode;
		}

		$parser->getOutput()->addHeadItem(
			Html::inlineScript( "var storyboardLanguage = '$language';" )
		);
		
		$output = Html::element( 'div', array(
				'class' => 'storyboard',
				'style' => "height: $height; width: $width;"
			)
		);
		
		return array( $output, 'noparse' => true, 'isHTML' => true );
	}
	
}