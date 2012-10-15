<?php

/**
 * File holding the rendering function for the Storysubmission tag.
 *
 * @file Storysubmission_body.php
 * @ingroup Storyboard
 *
 * @author Jeroen De Dauw
 * 
 * Notice: This class is designed with the idea that only one storysubmission form is placed
 * on a single page, and might not work properly when multiple are placed on a page.
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class TagStorysubmission {
	
	/**
	 * Renders the storybsubmission tag.
	 * 
	 * @param $input
	 * @param array $args
	 * @param Parser $parser
	 * @param $frame
	 * 
	 * @return array
	 */
	public static function render( $input, array $args, Parser $parser, $frame ) {
		wfProfileIn( __METHOD__ );

		global $wgRequest, $wgUser;
		
		$output = self::getFrom( $parser, $args );
		
		wfProfileOut( __METHOD__ );
		
		return array( $output, 'noparse' => true, 'isHTML' => true );
	}
	
	/**
	 * Returns the HTML for a storysubmission form.
	 * 
	 * @param Parser $parser
	 * @param array $args
	 * 
	 * @return HTML
	 */
	private static function getFrom( Parser $parser, array $args ) {
		global $wgUser, $wgStyleVersion, $wgScriptPath, $wgStylePath;
		global $egStoryboardScriptPath, $egStorysubmissionWidth, $egStoryboardMaxStoryLen, $egStoryboardMinStoryLen;
		
		$maxLen = array_key_exists( 'maxlength', $args ) && is_int( $args['maxlength'] ) ? $args['maxlength'] : $egStoryboardMaxStoryLen;
		$minLen = array_key_exists( 'minlength', $args ) && is_int( $args['minlength'] ) ? $args['minlength'] : $egStoryboardMinStoryLen;
		
		efStoryboardAddJSLocalisation( $parser );
		
		// Loading a seperate JS file would be overkill for just these 3 lines, and be bad for performance.
		$parser->getOutput()->addHeadItem(
			Html::linkedStyle( "$egStoryboardScriptPath/storyboard.css?$wgStyleVersion" ) .		
			Html::linkedScript( "$egStoryboardScriptPath/storyboard.js?$wgStyleVersion" ) .						
			Html::linkedScript( "$wgStylePath/common/jquery.min.js?$wgStyleVersion" ) .		
			Html::linkedScript( "$egStoryboardScriptPath/jquery/jquery.validate.js?$wgStyleVersion" ) .
			Html::inlineScript( <<<EOT
$(function() {
	document.getElementById( 'storysubmission-button' ).disabled = true;
	stbValidateStory( document.getElementById('storytext'), $minLen, $maxLen, 'storysubmission-charlimitinfo', 'storysubmission-button' )
	$("#storyform").validate({
		messages: {
			storytitle: {
				remote: jQuery.validator.format( stbMsg( 'storyboard-alreadyexistschange' ) )
			}
		}
	});		
});			
EOT
			)		
		);
		
		$fieldSize = 50;
		
		$width = StoryboardUtils::getDimension( $args, 'width', $egStorysubmissionWidth );
		
		$formBody = "<table width='$width'>";
		
		$defaultName = '';
		$defaultEmail = '';
		
		if ( $wgUser->isLoggedIn() ) {
			$defaultName = $wgUser->getRealName() !== '' ? $wgUser->getRealName() : $wgUser->getName();
			$defaultEmail = $wgUser->getEmail();
		}
		
		$formBody .= '<tr>' .
			Html::element( 'td', array( 'width' => '100%' ), wfMsg( 'storyboard-yourname' ) ) .
			'<td>' .
			Html::input(
				'name',
				$defaultName,
				'text',
				array(
					'size' => $fieldSize,
					'class' => 'required',
					'maxlength' => 255,
					'minlength' => 2
				)
			) . '</td></tr>';
		
		$formBody .= '<tr>' .
			Html::element( 'td', array( 'width' => '100%' ), wfMsg( 'storyboard-location' ) ) .
			'<td>' .
			Html::input(
				'location',
				'',
				'text',
				array(
					'size' => $fieldSize,
					'maxlength' => 255,
					'minlength' => 2
				)
			) . '</td></tr>';
		
		$formBody .= '<tr>' .
			Html::element( 'td', array( 'width' => '100%' ), wfMsg( 'storyboard-occupation' ) ) .
			'<td>' .
			Html::input(
				'occupation',
				'',
				'text',
				array(
					'size' => $fieldSize,
					'maxlength' => 255,
					'minlength' => 4
				)
			) . '</td></tr>';

		$formBody .= '<tr>' .
			Html::element( 'td', array( 'width' => '100%' ), wfMsg( 'storyboard-email' ) ) .
			'<td>' .
			Html::input(
				'email',
				$defaultEmail,
				'text',
				array(
					'size' => $fieldSize,
					'class' => 'required email',
					'size' => $fieldSize,
					'maxlength' => 255
				)
			) . '</td></tr>';
			
		$formBody .= '<tr>' .
			Html::element( 'td', array( 'width' => '100%' ), wfMsg( 'storyboard-storytitle' ) ) .
			'<td>' .
			Html::input(
				'storytitle',
				'',
				'text',
				array(
					'size' => $fieldSize,
					'class' => 'required storytitle',
					'maxlength' => 255,
					'minlength' => 2,
					'remote' => "$wgScriptPath/api.php?format=json&action=storyexists"
				)
			) . '</td></tr>';
		
		$formBody .= '<tr><td colspan="2">' .
			wfMsg( 'storyboard-story' ) .
			Html::element(
				'div',
				array( 'class' => 'storysubmission-charcount', 'id' => 'storysubmission-charlimitinfo' ),
				wfMsgExt( 'storyboard-charsneeded', 'parsemag', $minLen )
			) .
			'<br />' .
			Html::element(
				'textarea',
				array(
					'id' => 'storytext',
					'name' => 'storytext',
					'rows' => 7,
					'class' => 'required',
					'onkeyup' => "stbValidateStory( this, $minLen, $maxLen, 'storysubmission-charlimitinfo', 'storysubmission-button' )",
				),
				null
			) .
			'</td></tr>';
		
		// TODO: add upload functionality

		$formBody .= '<tr><td colspan="2"><input type="checkbox" id="storyboard-agreement" />&#160;' .
			$parser->recursiveTagParse( htmlspecialchars( wfMsg( 'storyboard-agreement' ) ) ) .
			'</td></tr>';
			
		$formBody .= '<tr><td colspan="2">' .
			Html::input( 'storysubmission-button', wfMsg( 'htmlform-submit' ), 'submit', array( 'id' => 'storysubmission-button' ) ) .
			'</td></tr>';
			
		$formBody .= '</table>';
		
		$formBody .= Html::hidden( 'wpStoryEditToken', $wgUser->editToken() );
		
		if ( !array_key_exists( 'language', $args )
			|| !array_key_exists( $args['language'], Language::getLanguageNames() ) ) {
				global $wgContLanguageCode;
			$args['language'] = $wgContLanguageCode;
		}

		$formBody .= Html::hidden( 'lang', $args['language'] );
		
		return Html::rawElement(
			'form',
			array(
				'id' => 'storyform',
				'name' => 'storyform',
				'method' => 'post',
				'action' => SpecialPage::getTitleFor( 'StorySubmission' )->getFullURL(),
				'onsubmit' => 'return stbValidateSubmission( "storyboard-agreement" );'
			),
			$formBody
		);
	}
	
}