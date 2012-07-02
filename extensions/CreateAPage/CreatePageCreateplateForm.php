<?php
/**
 * This class takes care for the createplate loader form
 *
 * @file
 */
class CreatePageCreateplateForm {
	var $mCreateplatesLocation;
	var $mTitle, $mNamespace, $mCreateplate;
	var $mRedLinked;

	// constructor
	function __construct( $par = null ) {
		global $wgRequest;

		$this->mCreateplatesLocation = 'Createplate-list';

		if ( $wgRequest->getVal( 'action' ) == 'submit' ) {
			$this->mTitle = $wgRequest->getVal( 'Createtitle' );
			$this->mCreateplate = $wgRequest->getVal( 'createplates' );
			// for preview in red link mode
			if ( $wgRequest->getCheck( 'Redlinkmode' ) ) {
				$this->mRedLinked = true;
			}
		} else {
			// title override
			if ( $wgRequest->getVal( 'Createtitle' ) != '' ) {
				$this->mTitle = $wgRequest->getVal( 'Createtitle' );
				$this->mRedLinked = true;
			} else {
				$this->mTitle = '';
			}
			// URL override
			$this->mCreateplate = $wgRequest->getVal( 'createplates' );
		}
	}

	function makePrefix( $title ) {
		$title = str_replace( '_', ' ', $title );
		return $title;
	}

	// show form
	function showForm( $err, $content_prev = false, $formCallback = null ) {
		global $wgOut, $wgUser, $wgRequest;

		if ( $wgRequest->getCheck( 'wpPreview' ) ) {
			$wgOut->setPageTitle( wfMsg( 'preview' ) );
		} else {
			if ( $this->mRedLinked ) {
				$wgOut->setPageTitle( wfMsg( 'editing', $this->makePrefix( $this->mTitle ) ) );
			} else {
				$wgOut->setPageTitle( wfMsg( 'createpage-title' ) );
			}
		}

		if ( $wgUser->isLoggedIn() ) {
			$token = htmlspecialchars( $wgUser->editToken() );
		} else {
			$token = EDIT_TOKEN_SUFFIX;
		}
		$titleObj = SpecialPage::getTitleFor( 'CreatePage' );
		$action = $titleObj->escapeLocalURL( 'action=submit' );

		if ( $wgRequest->getCheck( 'wpPreview' ) ) {
			$wgOut->addHTML(
				'<div class="previewnote"><p>' .
				wfMsg( 'previewnote' ) .
				'</p></div>'
			);
		} else {
			$wgOut->addHTML( wfMsg( 'createpage-title-additional' ) );
		}

		if ( $err != '' ) {
			$wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
			$wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
		}

		// show stuff like on normal edit page, but just for red links
		if ( $this->mRedLinked ) {
			if( $wgUser->isLoggedIn() ) {
				$wgOut->addWikiMsg( 'newarticletext' );
			} else {
				$wgOut->addWikiMsg( 'newarticletextanon' );
			}
			if( $wgUser->isAnon() && !$wgRequest->getCheck( 'wpPreview' ) ) {
				$wgOut->addWikiMsg( 'anoneditwarning' );
			}
		}

		// Add CSS & JS
		$wgOut->addModuleStyles( 'ext.createAPage' );
		$wgOut->addModuleScripts( 'ext.createAPage' );
		/*if( $wgUser->getOption( 'disablelinksuggest' ) != true ) {
			$wgOut->addHTML( '<div id="wpTextbox1_container" class="yui-ac-container"></div> ');
			$wgOut->addScriptFile( $wgScriptPath . '/extensions/LinkSuggest/LinkSuggest.js' );
		}*/

		$alternateLink = '<a href="#" onclick="CreateAPage.goToNormalEditMode(); return false;">' .
			wfMsg( 'createpage-here' ) . '</a>';
		$wgOut->addHTML(
			'<div id="createpage_subtitle" style="display:none">' .
				wfMsg( 'createpage-alternate-creation', $alternateLink ) .
			'</div>'
		);

		if ( $wgRequest->getCheck( 'wpPreview' ) ) {
			$this->showPreview( $content_prev, $wgRequest->getVal( 'Createtitle' ) );
		}

		$html = "
<form name=\"createpageform\" enctype=\"multipart/form-data\" method=\"post\" action=\"{$action}\" id=\"createpageform\">
	<div id=\"createpage_messenger\" style=\"display:none; color:red\"></div>
		<noscript>
		<style type=\"text/css\">
			#loading_mesg, #image_upload {
				display: none;
			}
		</style>
		</noscript>";

		$html .= '
		<input type="hidden" name="wpEditToken" value="' . $token . '" />
		<input type="hidden" name="wpCreatePage" value="true" />';

		$wgOut->addHTML( $html );
		// adding this for CAPTCHAs and the like
		if( is_callable( $formCallback ) ) {
			call_user_func_array( $formCallback, array( &$wgOut ) );
		}

		$parsedTemplates = $this->getCreateplates();
		$showField = '';
		if ( !$parsedTemplates ) {
			$showField = ' style="display: none";';
		}

		if ( !$wgRequest->getCheck( 'wpPreview' ) ) {
			$wgOut->addHTML(
				'<fieldset id="cp-chooser-fieldset"' . $showField . '>
				<legend>' . wfMsg( 'createpage-choose-createplate' ) .
				'<span style="font-size: small; font-weight: normal; margin-left: 5px">[<a id="cp-chooser-toggle" title="toggle" href="#">'
				. wfMsg( 'createpage-hide' ) . '</a>]</span>
				</legend>' . "\n"
			);
			$wgOut->addHTML( '<div id="cp-chooser" style="display: block;">' . "\n" );
		}
		$this->produceRadioList( $parsedTemplates );
	}

	/**
	 * Get the list of createplates from a MediaWiki namespace page,
	 * parse the content into an array and return it.
	 *
	 * @return Mixed: array on success, boolean false if the message is empty
	 */
	function getCreateplates() {
		$createplates_txt = wfMsgForContent( $this->mCreateplatesLocation );
		if ( $createplates_txt != '' ) {
			$lines = preg_split( "/[\n]+/", $createplates_txt );
		}

		$createplates = array();
		if ( !empty( $lines ) ) {
			// each createplate is listed in a new line, has two required and one optional
			// parameter, all separated by pipes
			foreach ( $lines as $line ) {
				if ( preg_match( "/^[^\|]+\|[^\|]+\|[^\|]+$/", $line ) ) {
					// three parameters
					$line_pars = preg_split( "/\|/", $line );
					$createplates[] = array(
						'page' 	=> $line_pars[0],
						'label' => $line_pars[1],
						'preview' => $line_pars[2]
					);
				} elseif( preg_match( "/^[^\|]+\|[^\|]+$/", $line ) ) {
					// two parameters
					$line_pars = preg_split( "/\|/", $line );
					$createplates[] = array(
						'page' 	=> $line_pars[0],
						'label' => $line_pars[1]
					);
				}
			}
		}

		if ( empty( $createplates ) ) {
			return false;
		} else {
			return $createplates;
		}
	}

	// return checked createplate
	function getChecked( $createplate, $current, &$checked ) {
		if ( !$createplate ) {
			if ( !$checked ) {
				$this->mCreateplate = $current;
				$checked = true;
				return 'checked';
			}
			return '';
		} else {
			if ( $createplate == $current ) {
				$this->mCreateplate = $current;
				return 'checked';
			} else {
				return '';
			}
		}
	}

	/**
	 * Produce a list of radio buttons from the given createplate array and
	 * output the generated HTML.
	 *
	 * @param $createplates Array: array of createplates
	 */
	function produceRadioList( $createplates ) {
		global $wgOut, $wgRequest, $wgServer, $wgScript;

		// this checks radio buttons when we have no JavaScript...
		$selected = false;
		if ( $this->mCreateplate != '' ) {
			$selected = $this->mCreateplate;
		}
		$checked = false;
		$check = array();
		foreach ( $createplates as $createplate ) {
			$check[$createplate['page']] = $this->getChecked(
				$selected, $createplate['page'], $checked
			);
		}

		if ( $this->mRedLinked ) {
			global $wgParser, $wgUser;
			$parserOptions = ParserOptions::newFromUser( $wgUser );
			$parserOptions->setEditSection( false );
			$rtitle = Title::newFromText( $this->mTitle );
			$parsedInfo = $wgParser->parse(
				wfMsg( 'createpage-about-info' ), $rtitle, $parserOptions
			);
			$aboutinfo = str_replace( '</p>', '', $parsedInfo->mText );
			$aboutinfo .= wfMsg(
				'createpage-advanced-text',
				'<a href="' . $wgServer . $wgScript . '" id="wpAdvancedEdit">' .
					wfMsg( 'createpage-advanced-edit' ) . '</a>'
			) . '</p>';
		} else {
			$aboutinfo = '';
		}

		$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$tmpl->set_vars(array(
			'data' => $createplates,
			'selected' => $check,
			'createtitle' => $this->makePrefix( $this->mTitle ),
			'ispreview' => $wgRequest->getCheck( 'wpPreview' ),
			'isredlink' => $this->mRedLinked,
			'aboutinfo' => $aboutinfo,
		));

		$wgOut->addHTML( $tmpl->render( 'templates-list' ) );
	}

	/**
	 * Check whether the given page exists.
	 *
	 * @param $given String: name of the page whose existence we're checking
	 * @param $ajax Boolean: are we in AJAX mode? Defaults to false.
	 * @return Mixed: string (error message) if the title is missing, the page
	 *                exists and we're not in AJAX mode
	 */
	function checkArticleExists( $given, $ajax = false ) {
		global $wgOut;

		if ( $ajax ) {
			$wgOut->setArticleBodyOnly( true );
		}

		if ( empty( $given ) && !$ajax ) {
			return wfMsg( 'createpage-give-title' );
		}

		$title = Title::newFromText( $given );
		if ( is_object( $title ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$exists = $dbr->selectField(
				'page',
				'page_title',
				array(
					'page_title' => $title->getDBkey(),
					'page_namespace' => $title->getNamespace()
				),
				__METHOD__
			);
			if ( $exists != '' ) {
				if ( $ajax ) {
					$wgOut->addHTML( 'pagetitleexists' );
				} else {
					// Mimick the way AJAX version displays things and use the
					// same two messages. 2 are needed for full i18n support.
					return wfMsg( 'createpage-article-exists' ) . ' ' .
						Linker::linkKnown( $title, '', array(), array( 'action' => 'edit' ) ) .
						wfMsg( 'createpage-article-exists2' );
				}
			}
			if ( !$ajax ) {
				return false;
			}
		} else {
			if ( !$ajax ) {
				return wfMsg( 'createpage-title-invalid' );
			}
		}
	}

	/**
	 * Try to submit the form.
	 *
	 * @return Mixed: boolean false on failure, nothing on success; if
	 *                everything went well, the user is redirected to their new
	 *                page
	 */
	function submitForm() {
		global $wgOut, $wgRequest, $wgServer, $wgScript, $wgScriptPath;

		// check if we are editing in red link mode
		if ( $wgRequest->getCheck( 'wpSubmitCreateplate' ) ) {
			$mainform = new CreatePageCreateplateForm();
			$mainform->showForm( '' );
			$mainform->showCreateplate();
			return false;
		} else {
			$valid = $this->checkArticleExists( $wgRequest->getVal( 'Createtitle' ) );
			if ( $valid != '' ) {
				// no title? this means overwriting Main Page...
				$mainform = new CreatePageCreateplateForm();
				$mainform->showForm( $valid );
				$editor = new CreatePageMultiEditor( $this->mCreateplate );
				$editor->generateForm( $editor->glueArticle() );
				return false;
			}

			if ( $wgRequest->getCheck( 'wpSave' ) ) {
				$editor = new CreatePageMultiEditor( $this->mCreateplate );
				$rtitle = Title::newFromText( $wgRequest->getVal( 'Createtitle' ) );
				$rarticle = new Article( $rtitle, $rtitle->getArticleID() );
				$editpage = new EditPage( $rarticle );
				$editpage->mTitle = $rtitle;
				$editpage->mArticle = $rarticle;
				$editpage->textbox1 = CreateMultiPage::unescapeBlankMarker( $editor->glueArticle() );

				$editpage->minoredit = $wgRequest->getCheck( 'wpMinoredit' );
				$editpage->watchthis = $wgRequest->getCheck( 'wpWatchthis' );
				$editpage->summary = $wgRequest->getVal( 'wpSummary' );
				$_SESSION['article_createplate'] = $this->mCreateplate;
				// pipe tags to pipes
				wfCreatePageUnescapeKnownMarkupTags( $editpage->textbox1 );
				$editpage->attemptSave();
				return false;
			} elseif( $wgRequest->getCheck( 'wpPreview' ) ) {
				$mainform = new CreatePageCreatePlateForm();
				$editor = new CreatePageMultiEditor( $this->mCreateplate, true );
				$content = $editor->glueArticle( true, false );
				$content_static = $editor->glueArticle( true );
				$mainform->showForm( '', $content_static );
				$editor->generateForm( $content );
				return false;
			} elseif( $wgRequest->getCheck( 'wpAdvancedEdit' ) ) {
				$editor = new CreatePageMultiEditor( $this->mCreateplate );
				$content = CreateMultiPage::unescapeBlankMarker( $editor->glueArticle() );
				wfCreatePageUnescapeKnownMarkupTags( $content );
				$_SESSION['article_content'] = $content;
				$wgOut->redirect(
					$wgServer . $wgScript . '?title=' .
					$wgRequest->getVal( 'Createtitle' ) .
					'&action=edit&createpage=true'
				);
			} elseif( $wgRequest->getCheck( 'wpImageUpload' ) ) {
				$mainform = new CreatePageCreatePlateForm();
				$mainform->showForm( '' );
				$editor = new CreatePageMultiEditor( $this->mCreateplate );
				$content = $editor->glueArticle();
				$editor->generateForm( $content );
			} elseif( $wgRequest->getCheck( 'wpCancel' ) ) {
				if ( $wgRequest->getVal( 'Createtitle' ) != '' ) {
					$wgOut->redirect( $wgServer . $wgScript . '?title=' . $wgRequest->getVal( 'Createtitle' ) );
				} else {
					$wgOut->redirect( $wgServer . $wgScript );
				}
			}
		}
	}

	// display the preview in another div
	function showPreview( $content, $title ) {
		global $wgOut, $wgUser, $wgParser;

		$parserOptions = ParserOptions::newFromUser( $wgUser );
		$parserOptions->setEditSection( false );
		$rtitle = Title::newFromText( $title );

		if ( is_object( $rtitle ) ) {
			wfCreatePageUnescapeKnownMarkupTags( $content );
			$pre_parsed = $wgParser->preSaveTransform(
				$content, $rtitle, $wgUser, $parserOptions, true
			);
			$output = $wgParser->parse( $pre_parsed, $rtitle, $parserOptions );
			$wgOut->addParserOutputNoText( $output );
			$wgOut->addHTML(
				"<div id=\"createpagepreview\">
					$output->mText
					<div id=\"createpage_preview_delimiter\" class=\"actionBar actionBarStrong\">" .
						wfMsg( 'createpage-preview-end' ) .
					'</div>
				</div>'
			);
		}
	}

	function showCreateplate( $isInitial = false ) {
		if ( $this->mCreateplate ) {
			$editor = new CreatePageMultiEditor( $this->mCreateplate );
		} else {
			$editor = new CreatePageMultiEditor( 'Blank' );
		}
		$editor->mRedLinked = false;
		if ( $this->mRedLinked ) {
			$editor->mRedLinked = true;
		}
		$editor->mInitial = false;
		if ( $isInitial ) {
			$editor->mInitial = true;
		}
		$editor->generateForm();
	}
}