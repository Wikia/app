<?php
/**
 * File holding the SpecialStory class defining a special page to view a specific story for permalink purpouses.
 *
 * @file Story_body.php
 * @ingroup Storyboard
 * @ingroup SpecialPage
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class SpecialStory extends IncludableSpecialPage {

	public function __construct() {
		parent::__construct( 'Story' );
	}

	public function execute( $title ) {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgRequest, $wgUser;

		$title = str_replace( '_', ' ', $title );

		if ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
			if ( $wgUser->isAllowed( 'storyreview' ) ) {
				// If the user is allowed to actually modify the story, save it.
				$this->saveStory();
			} else {
				// If the user is not allowed to modify stories, show an error.
				$wgOut->addWikiMsg( 'storyboard-cantedit' );
			}
		}

		// Redirect the user when the redirect parameter is set.
		if ( $wgRequest->getVal( 'returnto' ) && !$wgRequest->getCheck( 'action' ) ) {
 			$titleObj = Title::newFromText( $wgRequest->getVal( 'returnto' ) );
			$wgOut->redirect( $titleObj->getFullURL() );
		} elseif ( trim( $title ) != '' || $wgRequest->getIntOrNull( 'id' ) ) {
			$this->queryAndShowStory( $title );
		} else {
			$wgOut->setPageTitle( wfMsg( 'storyboard-viewstories' ) );
			$wgOut->addWikiMsg( 'storyboard-nostorytitle' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Queries for the requested story and shows it in either display or edit mode when it's found.
	 */
	private function queryAndShowStory( $title ) {
		global $wgOut, $wgRequest, $wgUser;

		$hasTitle = trim( $title ) != '';

		$dbr = wfGetDB( DB_SLAVE );

		// If an id is provided, query for the story title and redirect to have a nicer url,
		// or continue with function execution to display an error that there is no such story.
		if ( !$hasTitle ) {
			$story = $dbr->selectRow(
				'storyboard',
				array(
					'story_title',
				),
				array( 'story_id' => $wgRequest->getIntOrNull( 'id' ) )
			);
			if ( $story ) {
				$wgOut->redirect( $this->getTitle( $story->story_title )->getFullURL() );
				return;
			}
		} else {
			// If a title is provided, query the story info.
			$story = $dbr->selectRow(
				'storyboard',
				array(
					'story_id',
					'story_author_id',
					'story_author_name',
					'story_author_location',
					'story_author_occupation',
					'story_author_email',
					'story_author_image',
					'story_image_hidden',
					'story_title',
					'story_text',
					'story_created',
					'story_modified',
					'story_state',
					'story_lang_code',
				),
				array( 'story_title' => $title )
			);
		}

		// If there is such a story, display it, or the edit form.
		// If there isn't, display an error message.
		if ( $story ) {
			$isEdit = $wgRequest->getVal( 'action' ) == 'edit';

			if ( $isEdit && $wgUser->isAllowed( 'storyreview' ) ) {
				$this->showStoryForm( $story );
			} else {
				$wgOut->setPageTitle( $story->story_title );

				if ( $isEdit ) {
					$wgOut->addWikiMsg( 'storyboard-cantedit' );
				}

				if ( $story->story_state == Storyboard_STORY_PUBLISHED ) {
					$this->showStory( $story );
				}
				elseif ( !$isEdit ) {
					$wgOut->addWikiMsg( 'storyboard-storyunpublished' );

					if ( $wgUser->isAllowed( 'storyreview' ) ) {
						$wgOut->addWikiMsg(
							'storyboard-canedit',
							$this->getTitle( $story->story_title )->getFullURL( array( 'action' => 'edit' ) )
						);
					}
				}
			}
		}
		else {
			$wgOut->addWikiMsg( 'storyboard-nosuchstory' );
		}
	}

	/**
	 * Ouputs the story in regular display mode.
	 *
	 * @param $story
	 *
	 * TODO: Improve layout, add social sharing stuff, add story meta data and show edit stuff for people with stroyreview permission.
	 */
	private function showStory( $story ) {
		global $wgOut, $wgLang, $wgUser, $egStoryboardScriptPath;

		$wgOut->addStyle( $egStoryboardScriptPath . '/storyboard.css' );

		if ( $story->story_author_image != '' && $story->story_image_hidden != 1 ) {
			$story->story_author_image = htmlspecialchars( $story->story_author_image );
			$wgOut->addHTML( "<img src=\"$story->story_author_image\" class='story-image'>" );
		}

		$wgOut->addWikiText( $story->story_text );

		// If the user that submitted the story was logged in, create a link to his/her user page.
		if ( $story->story_author_id ) {
			$user = User::newFromId( $story->story_author_id );
			$userPage = $user->getUserPage();
			$story->story_author_name = '[[' . $userPage->getFullText() . '|' . $story->story_author_name . ']]';
		}

		$wgOut->addWikiText(
			htmlspecialchars( wfMsgExt(
				'storyboard-submittedbyon',
				'parsemag',
				$story->story_author_name,
				$wgLang->time( $story->story_created ),
				$wgLang->date( $story->story_created )
			) )
		);

		// FIXME: this button is a temporary solution untill the SkinTemplateNavigation on special pages issue is fixed.
		if ( $wgUser->isAllowed( 'storyreview' ) ) {
			$editMsg = htmlspecialchars( wfMsg( 'edit' ) );
			$editUrl = htmlspecialchars( $this->getTitle( $story->story_title )->getLocalURL( 'action=edit' ) );
			$wgOut->addHtml(
				"<button type='button' onclick='window.location=\"$editUrl\"'>$editMsg</button>"
			);
		}
	}

	/**
	 * Outputs a form to edit the story with. Code based on <storysubmission>.
	 *
	 * @param $story
	 */
	private function showStoryForm( $story ) {
		global $wgOut, $wgLang, $wgRequest, $wgUser, $wgScriptPath, $wgContLanguageCode;
		global $egStoryboardScriptPath, $egStorysubmissionWidth, $egStoryboardMaxStoryLen, $egStoryboardMinStoryLen;

		$wgOut->setPageTitle( $story->story_title );

		efStoryboardAddJSLocalisation();

		$wgOut->addStyle( $egStoryboardScriptPath . '/storyboard.css' );
		$wgOut->includeJQuery();
		$wgOut->addScriptFile( $egStoryboardScriptPath . '/jquery/jquery.validate.js' );
		$wgOut->addScriptFile( $egStoryboardScriptPath . '/storyboard.js' );

		$fieldSize = 50;

		$width = $egStorysubmissionWidth;

		$maxLen = $wgRequest->getVal( 'maxlength' );
		if ( !is_int( $maxLen ) ) $maxLen = $egStoryboardMaxStoryLen;

		$minLen = $wgRequest->getVal( 'minlength' );
		if ( !is_int( $minLen ) ) $minLen = $egStoryboardMinStoryLen;

		$formBody = "<table width=\"$width\">";

		// The current value will be selected on page load with jQuery.
		$formBody .= '<tr>' .
			'<td width="100%"><label for="storystate">' .
				htmlspecialchars( wfMsg( 'storyboard-storystate' ) ) .
			'</label></td><td>' .
			Html::rawElement(
				'select',
				array(
					'name' => 'storystate',
					'id' => 'storystate'
				),
				'<option value="' . Storyboard_STORY_UNPUBLISHED . '">' . htmlspecialchars( wfMsg( 'storyboard-option-unpublished' ) ) . '</option>' .
				'<option value="' . Storyboard_STORY_PUBLISHED . '">' . htmlspecialchars( wfMsg( 'storyboard-option-published' ) ) . '</option>' .
				'<option value="' . Storyboard_STORY_HIDDEN . '">' . htmlspecialchars( wfMsg( 'storyboard-option-hidden' ) ) . '</option>'
			) .
		'</td></tr>';

		$languages = Language::getLanguageNames( false );

		$currentLang = array_key_exists( $story->story_lang_code, $languages ) ? $story->story_lang_code : $wgContLanguageCode;

		$options = array();
		ksort( $languages );

		foreach ( $languages as $code => $name ) {
			$display = wfBCP47( $code ) . ' - ' . $name;
			$options[$display] = $code;
		}

		$languageSelector = new HTMLSelectField( array(
			'name' => 'language',
			'options' => $options
		) );

		$formBody .= '<tr>' .
			Html::element( 'td', array( 'width' => '100%' ), wfMsg( 'storyboard-language' ) ) .
			'<td>' .
			$languageSelector->getInputHTML( $currentLang ) .
			'</td></tr>';

		$formBody .= '<tr>' .
			Html::element( 'td', array( 'width' => '100%' ), wfMsg( 'storyboard-authorname' ) ) .
			'<td>' .
			Html::input(
				'name',
				$story->story_author_name,
				'text',
				array(
					'size' => $fieldSize,
					'class' => 'required',
					'minlength' => 2,
					'maxlength' => 255
				)
			) . '</td></tr>';

		$formBody .= '<tr>' .
			Html::element( 'td', array( 'width' => '100%' ), wfMsg( 'storyboard-authorlocation' ) ) .
			'<td>' . Html::input(
				'location',
				$story->story_author_location,
				'text',
				array(
					'size' => $fieldSize,
					'maxlength' => 255,
					'minlength' => 2
				)
			) . '</td></tr>';

		$formBody .= '<tr>' .
			Html::element( 'td', array( 'width' => '100%' ), wfMsg( 'storyboard-authoroccupation' ) ) .
			'<td>' . Html::input(
				'occupation',
				$story->story_author_occupation,
				'text',
				array(
					'size' => $fieldSize,
					'maxlength' => 255,
					'minlength' => 4
				)
			) . '</td></tr>';

		$formBody .= '<tr>' .
			Html::element( 'td', array( 'width' => '100%' ), wfMsg( 'storyboard-authoremail' ) ) .
			'<td>' . Html::input(
				'email',
				$story->story_author_email,
				'text',
				array(
					'size' => $fieldSize,
					'maxlength' => 255,
					'class' => 'required email'
				)
			) . '</td></tr>';

		$formBody .= '<tr>' .
			'<td width="100%"><label for="storytitle">' .
				htmlspecialchars( wfMsg( 'storyboard-storytitle' ) ) .
			'</label></td><td>' .
			Html::input(
				'storytitle',
				$story->story_title,
				'text',
				array(
					'size' => $fieldSize,
					'maxlength' => 255,
					'minlength' => 2,
					'id' => 'storytitle',
					'class' => 'required storytitle',
					'remote' => "$wgScriptPath/api.php?format=json&action=storyexists&currentid=$story->story_id"
				)
			) . '</td></tr>';

		$formBody .= '<tr><td colspan="2">' .
			wfMsg( 'storyboard-thestory' ) .
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
				$story->story_text
			) .
			'</td></tr>';

		$returnTo = $wgRequest->getVal( 'returnto' );
		$query = "id=$story->story_id";
		if ( $returnTo ) $query .= "&returnto=$returnTo";

		$formBody .= '<tr><td colspan="2">' .
			Html::input( '', wfMsg( 'htmlform-submit' ), 'submit', array( 'id' => 'storysubmission-button' ) ) .
			"&#160;&#160;<span class='editHelp'>" .
			Html::element(
				'a',
				array( 'href' => $this->getTitle()->getLocalURL( $query ) ),
				wfMsgExt( 'cancel', array( 'parseinline' ) )
			) .
			'</span>' .
			'</td></tr>';

		$formBody .= '</table>';

		$formBody .= Html::hidden( 'wpEditToken', $wgUser->editToken() );
		$formBody .= Html::hidden( 'storyId', $story->story_id );

		$formBody = '<fieldset><legend>' .
			htmlspecialchars( wfMsgExt(
				'storyboard-createdandmodified',
				'parsemag',
				$wgLang->time( $story->story_created ),
				$wgLang->date( $story->story_created ),
				$wgLang->time( $story->story_modified ),
				$wgLang->date( $story->story_modified )
			) ) .
		'</legend>' . $formBody . '</fieldset>';

		$query = "id=$story->story_id";
		if ( $returnTo ) $query .= "&returnto=$returnTo";

		$formBody = Html::rawElement(
			'form',
			array(
				'id' => 'storyform',
				'name' => 'storyform',
				'method' => 'post',
				'action' => $this->getTitle()->getLocalURL( $query ),
			),
			$formBody
		);

		$wgOut->addHTML( $formBody );

		$state = htmlspecialchars( $story->story_state );
		$wgOut->addInlineScript( <<<EOT
jQuery(document).ready(function() {
	jQuery('#storystate option[value="$state"]').attr('selected', 'selected');

	jQuery("#storyform").validate({
		messages: {
			storytitle: {
				remote: jQuery.validator.format( stbMsg( 'storyboard-alreadyexistschange' ) )
			}
		}
	});
});

$(
	function() {
		stbValidateStory( document.getElementById('storytext'), $minLen, $maxLen, 'storysubmission-charlimitinfo', 'storysubmission-button' )
	}
);
jQuery(document).ready(function(){
	jQuery("#storyform").validate();
});
EOT
		);
	}

	/**
	 * Saves the story after a story edit form has been submitted.
	 */
	private function saveStory() {
		global $wgOut, $wgRequest, $wgUser;

		$dbw = wfGetDB( DB_MASTER );

		$dbw->update(
			'storyboard',
			array(
				'story_author_name' => $wgRequest->getText( 'name' ),
				'story_author_location' => $wgRequest->getText( 'location' ),
				'story_author_occupation' => $wgRequest->getText( 'occupation' ),
				'story_author_email' => $wgRequest->getText( 'email' ),
				'story_title' => $wgRequest->getText( 'storytitle' ),
				'story_text' => $wgRequest->getText( 'storytext' ),
				'story_modified' => $dbw->timestamp( time() ),
				'story_state' => $wgRequest->getIntOrNull( 'storystate' ),
				'story_lang_code' => $wgRequest->getText( 'wplanguage' )
			),
			array(
				'story_id' => $wgRequest->getText( 'storyId' ),
			)
		);
	}
}