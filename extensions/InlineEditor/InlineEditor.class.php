<?php
/**
 * InlineEditor base class, contains all the basic logic of the editor.
 * It handles hooks through static functions, and they can spawn an InlineEditor object using
 * an article object, and then render like a normal page, or as JSON. Reason for this is to be
 * able to pass this object to different hook functions.
 *
 */
class InlineEditor {
	private static $fallbackReason; /// < reason for not using the editor, used for showing a message
	const REASON_BROWSER  = 1;      /// < reason is an incompatible browser
	const REASON_ADVANCED = 2;      /// < reason is editing an 'advanced' page, whatever that may be

	private $section;				/// < Section number to scroll to if the user chooses to edit a specific section
	private $editWarning;           /// < boolean that shows if the editWarning message of the Vector Extension is enabled
	private $article;               /// < Article object to edit
	private $extendedEditPage;      /// < ExtendedEditPage object we're using to handle editor logic
	private $intro;                 /// < Intro message(s) that should be displayed on top

	/**
	 * Main entry point, hooks into MediaWikiPerformAction.
	 * Checks whether or not to spawn the editor, and does so if necessary.
	 */
	public static function mediaWikiPerformAction( $output, $article, $title, $user, $request, $wiki) {
		global $wgHooks, $wgInlineEditorEnableGlobal;
		
		if ( !$user->getOption( 'inline-editor-enabled' ) && !$wgInlineEditorEnableGlobal ) {
			return true;
		}

		// return if the action is not 'edit' or if it's disabled
		if( $wiki->getAction( $request ) != 'edit' ) {
			return true;
		}

		// check if the 'fulleditor' parameter is set either in GET or POST
		if ( $request->getCheck( 'fulleditor' ) ) {
			// hook into the edit page to inject the hidden 'fulleditor' input field again
			$wgHooks['EditPage::showEditForm:fields'][] = 'InlineEditor::showEditFormFields';
			return true;
		}

		// terminate if the browser is not supported
		if ( !self::isValidBrowser() ) {
			self::$fallbackReason = self::REASON_BROWSER;
			return true;
		}
		
		// start the session if needed
		if ( session_id() == '' ) {
			wfSetupSession();
		}
		
		// try to spawn the editor and render the page
		$editor = new InlineEditor( $article );

		// set the section to scroll to		
		if( isset( $_GET['section'] ) ) {
			$editor->setSection( $_GET['section'] );
		}
		elseif( isset( $_POST['section'] ) ) {
			$editor->setSection( $_POST['section'] );
		}
		
		// unset the section variables so the entire page will be edited
		unset( $_GET['section'] );
		unset( $_POST['section'] );
		$request->setVal( 'section', null );
		
		// set a warning when leaving the page if necessary
		$editor->setEditWarning( $user->getOption( 'useeditwarning' ) == 1 );

		if ( $editor->render( $output ) ) {
			return false;
		}
		else {
			// if rendering fails for some reason, terminate and show the advanced page notice
			self::$fallbackReason = self::REASON_ADVANCED;
			
			// don't leave traces of HTML behind
			$output->clearHTML();
			
			return true;
		}
	}

	/**
	 * Hooks into EditPage::showEditForm:initial. Shows a message if there is a fallback reason set.
	 * @param $editPage EditPage
	 */
	public static function showEditForm( &$editPage ) {
		global $wgExtensionAssetsPath, $wgOut, $wgRequest;

		// check for a fallback reason
		if ( isset( self::$fallbackReason ) ) {
			// add the style for fallback message
			$wgOut->addExtensionStyle( $wgExtensionAssetsPath . "/InlineEditor/EditForm.css?0" );

			// show the appropriate message at the top of the page
			switch( self::$fallbackReason ) {
				case self::REASON_BROWSER:
					self::prependFallbackMessage( wfMsgExt( 'inline-editor-redirect-browser', 'parseinline' ) );
					break;
				case self::REASON_ADVANCED:
					self::prependFallbackMessage( wfMsgExt( 'inline-editor-redirect-advanced', 'parseinline' ) );
					break;
			}
		}

		return true;
	}

	/**
	 * Prepends a fallback message at the top of the page.
	 * @param $html string Correct HTML
	 */
	private static function prependFallbackMessage( $html ) {
		global $wgOut;
		$wgOut->prependHTML( '<div class="inlineEditorMessage">' . $html . '</div>' );
	}

	/**
	 * Checks if the browser is supported.
	 * This function is borrowed from EditPage::checkUnicodeCompliantBrowser().
	 */
	private static function isValidBrowser() {
		global $wgInlineEditorBrowserBlacklist;
		if ( empty( $_SERVER["HTTP_USER_AGENT"] ) ) {
			// No User-Agent header sent? Trust it by default...
			return true;
		}
		$currentbrowser = $_SERVER["HTTP_USER_AGENT"];
		foreach ( $wgInlineEditorBrowserBlacklist as $browser ) {
			if ( preg_match( $browser, $currentbrowser ) ) {
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Add the preference in the user preferences with the GetPreferences hook.
	 * @param $user
	 * @param $preferences
	 */
	public static function getPreferences( $user, &$preferences ) {
		global $wgInlineEditorEnableGlobal, $wgInlineEditorAdvancedGlobal;
		if( !$wgInlineEditorEnableGlobal ) {
			$preferences['inline-editor-enabled'] = array(
				'type' => 'check',
				'section' => 'editing/labs',
				'label-message' => 'inline-editor-enable-preference',
			);
		}
		if( !$wgInlineEditorAdvancedGlobal ) {
			$preferences['inline-editor-advanced'] = array(
				'type' => 'check',
				'section' => 'editing/labs',
				'label-message' => 'inline-editor-advanced-preference',
			);
		}
		return true;
	}
	
	/**
	 * Entry point for the 'Preview' function through ajax.
	 * No real point in securing this, as nothing is actually saved.
	 * @param $json string JSON object from the client
	 * @param $pageName string The page we're editing
	 * @return string HTML
	 */
	public static function ajaxPreview( $json, $pageName ) {
		$title   = Title::newFromText( $pageName );
		$article = new Article( $title );

		$editor = new InlineEditor( $article );
		return $editor->preview( $json );
	}

	/**
	 * Add a 'fulleditor' hidden input field to the normal edit page
	 * @param $editpage EditPage
	 * @param $output OutputPage
	 */
	public static function showEditFormFields( &$editpage, &$output ) {
		$output->addHTML(
			HTML::rawElement( 'input', array( 'name' => 'fulleditor', 'type' => 'hidden', 'value' => '1' ) )
		);
		return true;
	}

	/**
	 * Constructor which takes only an Article object
	 * @param $article Article
	 */
	public function __construct( $article ) {
		$this->article = $article;
	}

	/**
	 * Render the editor.
	 * Spawns an ExtendedEditPage which is an EditPage with some specific logic for this editor.
	 * This is supplied with wikitext generated using InlineEditorText, from the posted JSON.
	 * If the page is being saved, the ExtendedEditPage will terminate the script itself, else
	 * the editing interface will show as usual.
	 * @param $output OutputPage
	 */
	public function render( $output ) {
		global $wgHooks, $wgRequest, $wgExtensionAssetsPath;

		// if the page is being saved, retrieve the wikitext from the JSON
		if ( $wgRequest->wasPosted() ) {
			$request = FormatJson::decode( $wgRequest->getVal( 'json' ), true );
			$text = InlineEditorText::restoreObject( $request, $this->article );
			$wgRequest->setVal( 'wpTextbox1', $text->getWikiOriginal() );
		}
		else {
			// create an InlineEditorText object which generates the HTML and JSON for the editor
			$text = new InlineEditorText( $this->article );
		}

		// try to initialise, or else return false, which will spawn an 'advanced page' notice
		$this->extendedEditPage = new ExtendedEditPage( $this->article );
		if ( $this->extendedEditPage->initInlineEditor( $this ) ) {
			// IMPORTANT: if the page was being saved, the script has been terminated by now!!
			
			// have the different kind of editors register themselves
			wfRunHooks( 'InlineEditorDefineEditors', array( &$this, &$output ) );
			
			// don't do any marking if this is an advanced page
			if( $this->isAdvancedPage() ) $text->setDisableMarking( true );

			// load the wikitext into the InlineEditorText object
			$text->loadFromWikiText( $this->extendedEditPage->getWikiText() );

			// add a large <div> around the marked wikitext to denote the editing position
			$parserOutput = $text->getFullParserOutput();
			$parserOutput->setText( '<div id="editContent">' . $parserOutput->getText() . '</div>' );

			// put the marked output into the page
			$output->addParserOutput( $parserOutput );
			$output->setPageTitle( $parserOutput->getTitleText() );
			
			// render all the javascript, styles, etc.
			$this->renderScripts( $output );
			$this->renderInitialState( $output, $text );
			$this->renderScroll( $output, $parserOutput );
			$this->renderEditWarning( $output );
			$this->renderOpenFullEditor( $output );
			
			// hook into SiteNoticeBefore to display the two boxes above the title
			// @todo: fix this in core, make sure that anything can be inserted above the title, outside #siteNotice
			$wgHooks['SiteNoticeBefore'][]  = array( $this, 'siteNoticeBefore' );
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Get the Article being edited
	 * @return Article
	 */
	public function getArticle() {
		return $this->article;
	}
	
	/**
	 * Set the section number to scroll to
	 * @param $section
	 */
	public function setSection( $section ) {
		$this->section = $section;
	}
	
	/**
	 * Set whether or not to use the editWarning utility of the Vector Extension
	 * @param $value Boolean
	 */
	public function setEditWarning( $value ) {
		$this->editWarning = $value;
	}
	
	/**
	 * Set the intro message(s) that should be displayed on top of the page.
	 * @param $intro String
	 */
	public function setIntro( $intro ) {
		$this->intro = $intro;
	}
	
	/**
	 * Check if the page is 'advanced'. For now, that means it has to be in an allowed namespace.
	 * @return bool
	 */
	private function isAdvancedPage() {
		global $wgInlineEditorAllowedNamespaces;
		if ( !empty( $wgInlineEditorAllowedNamespaces )
			&& !in_array( $this->article->getTitle()->getNamespace(), $wgInlineEditorAllowedNamespaces ) ) {
				return true;
		}
		return false;
	}
	
	/**
	 * Render the basic javascript, styles, etc.
	 *
	 * @param $output OutputPage
	 */
	private function renderScripts( OutputPage $output ) {
		// include the required JS and CSS files
		$output->addModules( array( 'jquery.inlineEditor', 'jquery.inlineEditor.editors.basic' ) );
		
		if( class_exists( 'WikiEditorHooks' ) ) {
			$output->addModules( array( 'jquery.wikiEditor' ) );
			
			if( WikiEditorHooks::isEnabled( 'toolbar' ) ) {
				$output->addModules( array( 'jquery.wikiEditor.toolbar', 'jquery.wikiEditor.toolbar.config' ) );
			}
			
			if( WikiEditorHooks::isEnabled( 'dialogs' ) ) {
				$output->addModules( array( 'jquery.wikiEditor.dialogs', 'jquery.wikiEditor.dialogs.config' ) );
			}
		}
	}
	
	/**
	 * Render the javascript for the initial state
	 *
	 * @param $output OutputPage
	 * @param $text InlineEditorText Use this text object to generate the initial state
	 */
	private function renderInitialState( OutputPage $output, InlineEditorText $text ) {
		// convert the text object into an initial state to send
		$initial = InlineEditorText::initialState( $text );
		
		// add the initial JSON state in Javascript, and then initialise the editor
		$initialJSON = FormatJson::encode( $initial );
		$output->addInlineScript(
			'jQuery( document ).ready( function() {
				jQuery.inlineEditor.addInitialState( ' . $initialJSON . ' );
				jQuery.inlineEditor.init();
			} );'
		);
	}
	
	/**
	 * Render the scroll javascript if needed
	 *
	 * @param $output OutputPage
	 * @param $parserOutput ParserOutput
	 */
	private function renderScroll( OutputPage $output, ParserOutput $parserOutput ) {
		$scrollAnchor = $this->getScrollAnchor( $parserOutput );
		if( $scrollAnchor !== null ) {
			$output->addInlineScript(
				'jQuery( document ).ready( function() {
					$( "html,body" ).animate( { scrollTop: $( "#' . $scrollAnchor .'" ).offset().top }, "slow" );
				} );'
			);
		}
	}
	
	/**
	 * Render the edit warning script
	 *
	 * @param $output OutputPage
	 * @param $parserOutput ParserOutput
	 */
	private function renderEditWarning( OutputPage $output ) {
	  	if ( $this->editWarning ) {
			$output->addInlineScript(
				'jQuery( document ).ready( function() {
					jQuery.inlineEditor.enableEditWarning();
				} );'
			);	
		}
	}
	
	/**
	 * On new pages, open the editor right away.
	 */
	private function renderOpenFullEditor( OutputPage $output ) {
		if ( !$this->article->exists() ) {
			$output->addInlineScript(
				'jQuery( document ).ready( function() {
					jQuery.inlineEditor.show( "inline-editor-root" );
				} );'
			);	
		}
	}
	
	/**
	 * Get an anchor to scroll to, or null
	 * @param $parserOutput ParserOutput
	 * @return string or null
	 */
	private function getScrollAnchor( $parserOutput ) {
		if( isset( $this->section ) ) {
			// retrieve the sections from the original wikimedia parser
			$sections = $parserOutput->getSections();

			// find the corresponding name of the section to scroll to
			foreach( $sections as $section ) {
				if( $section['index'] == $this->section ){
					return $section['anchor'];
				}
			}
		}
		return null;
	}

	/**
	 * Pass JSON into an InlineEditorText object and return combined JSON (HTML + sentence representation)
	 * @param $json string
	 * @return string
	 */
	public function preview( $json ) {
		// decode the JSON
		$request = FormatJson::decode( $json, true );
		
		// load the JSON to a text object and perform the edit
		$text = InlineEditorText::restoreObject( $request, $this->article );
		$text->doEdit( $request['lastEdit']['id'], $request['lastEdit']['text'] );
		
		// get the next state
		$subseq = InlineEditorText::subsequentState( $text );
		
		// send back the JSON
		return FormatJson::encode( $subseq );
	}

	/**
	 * Hooks into SiteNoticeBefore. Renders the edit interface above the title of the page.
	 * @param $siteNotice string
	 */
	public function siteNoticeBefore( &$siteNotice ) {
		$form = Html::rawElement( 'form', array(
			'id' => 'editForm',
			'method' => 'POST',
			'action' => $this->extendedEditPage->getSubmitUrl() ), $this->renderEditBox() . $this->renderAdvancedBox());
		
		$siteNotice = Html::rawElement( 'div', array( 'id' => 'inlineEditorBox' ), $this->renderIntroBox() . $form );
		return false;
	}

	/**
	 * Renders a simple box with a message, if needed.
	 * @return string HTML
	 */
	private function renderIntroBox() {
		if( strlen( $this->intro ) <= 0 ) return '';
		
		return Html::rawElement( 'div', array( 'id' => 'introbox' ), $this->intro );
	}

	/**
	 * Renders the edit box, which is the main box with the publish button.
	 * @return string HTML
	 */
	private function renderEditBox() {
		global $wgUser;
		
		if( $this->article->exists() ) {
			$top  = wfMsgExt( 'inline-editor-editbox-top', 'parseinline' );
		}
		else {
			$top  = wfMsgExt( 'inline-editor-editbox-top-new', 'parseinline' );
		}
		$top .= '<hr/>';

		$summary  = wfMsgExt( 'inline-editor-editbox-changes-question', 'parseinline' );
		$summary .= Html::input( 'wpSummary', $this->extendedEditPage->getSummary(), 'text', array(
			'class' => 'summary',
			'maxlength' => 250,
			'spellcheck' => 'true',
			'tabindex' => 1,
			) );
		$summary .= Html::rawElement( 'div', array( 'class' => 'example' ),
			wfMsgExt( 'inline-editor-editbox-changes-example', 'parseinline' ) );
		$summary .= '<hr/>';

		$terms    = Html::rawElement( 'div', array( 'class' => 'terms' ),
			// @todo FIXME: Create a link to content language copyrightpage with plain content
			//              link description.
			wfMsgExt( 'inline-editor-editbox-publish-terms', 'parseinline', '[[' . wfMsgForContent( 'copyrightpage' ) . ']]' ) );
		$publish  = Html::rawElement( 'div', array( 'class' => 'side' ),
			wfMsgExt( 'inline-editor-editbox-publish-notice', 'parseinline' ) . $terms );
		$publish .= Html::rawElement( 'a', array( 
			'id'        => 'publish', 
			'href'      => '#',
			'accesskey' => wfMsg( 'accesskey-save' ),
			'title'     => $wgUser->getSkin()->titleAttrib( 'save', 'withaccess' ),
			), wfMsgExt( 'inline-editor-editbox-publish-caption', 'parseinline' ) );
		$publish .= HTML::rawElement( 'input', array( 'id' => 'json', 'name' => 'json', 'type' => 'hidden' ) );

		return Html::rawElement( 'div', array( 'id' => 'editbox' ), $top . $summary . $publish );
	}
	
	/**
	 * Renders the advanced edit box if needed, or else some hidden form fields.
	 * @return string HTML
	 */
	private function renderAdvancedBox() {
		global $wgUser, $wgInlineEditorAdvancedGlobal;
		
		if( $wgUser->getOption( 'inline-editor-advanced' ) || $wgInlineEditorAdvancedGlobal ) {
			$box = '';
			
			$minorLabel = wfMsgExt( 'minoredit', array( 'parseinline' ) );
			if ( $wgUser->isAllowed( 'minoredit' ) ) {
				$attribs = array(
					//'tabindex'  => ++$tabindex,
					'accesskey' => wfMsg( 'accesskey-minoredit' ),
					'id'        => 'wpMinoredit',
				);
				$minorCheckbox =
					Xml::check( 'wpMinoredit', $this->extendedEditPage->getMinorEdit(), $attribs ) .
					"&#160;<label for='wpMinoredit' id='mw-editpage-minoredit'" .
					Xml::expandAttributes( array( 'title' => $wgUser->getSkin()->titleAttrib( 'minoredit', 'withaccess' ) ) ) .
					">{$minorLabel}</label>";
					
				$box .= Html::rawElement( 'div', array( 'class' => 'boxelement' ), $minorCheckbox );
			}
			
			$watchLabel = wfMsgExt( 'watchthis', array( 'parseinline' ) );
			if ( $wgUser->isLoggedIn() ) {
				$attribs = array(
					//'tabindex'  => ++$tabindex,
					'accesskey' => wfMsg( 'accesskey-watch' ),
					'id'        => 'wpWatchthis',
				);
				$watchCheckbox =
					Xml::check( 'wpWatchthis', $this->extendedEditPage->getWatchThis() , $attribs ) .
					"&#160;<label for='wpWatchthis' id='mw-editpage-watch'" .
					Xml::expandAttributes( array( 'title' => $wgUser->getSkin()->titleAttrib( 'watch', 'withaccess' ) ) ) .
					">{$watchLabel}</label>";
				
				$box .= Html::rawElement( 'div', array( 'class' => 'boxelement' ), $watchCheckbox );
			}
			
			$box .= Html::rawElement( 'div', array( 'class' => 'boxelement' ), '<span id="editCounter">#0</span>' );
			
			$box .= Html::rawElement( 'div', array( 'class' => 'boxelement' ), Html::rawElement( 'a', array( 
					'id'        => 'undo',
					'href'      => '#',
					'accesskey' => wfMsg( 'accesskey-inline-editor-undo' ),
					'title'     => $wgUser->getSkin()->titleAttrib( 'inline-editor-undo', 'withaccess' ),
				), wfMsgExt( 'inline-editor-undo', array( 'parseinline' ) ) ) );
			
			$box .= Html::rawElement( 'div', array( 'class' => 'boxelement' ), Html::rawElement( 'a', array( 
					'id'        => 'redo',
					'href'      => '#',
					'accesskey' => wfMsg( 'accesskey-inline-editor-redo' ),
					'title'     => $wgUser->getSkin()->titleAttrib( 'inline-editor-redo', 'withaccess' ),
				), wfMsgExt( 'inline-editor-redo', array( 'parseinline' ) ) ) );
			
			// have other extensions add elements
			wfRunHooks( 'InlineEditorRenderAdvancedBox', array( &$this, &$box ) );
			
			return Html::rawElement( 'div', array( 'id' => 'advancedbox' ), $box );
		}
		else {
			$hidden = '';
			$hidden .= Html::input( 'wpMinoredit', $this->extendedEditPage->getMinorEdit(), 'hidden');
			$hidden .= Html::input( 'wpWatchthis', $this->extendedEditPage->getWatchThis(), 'hidden');
			return $hidden;
		}
	}
}
