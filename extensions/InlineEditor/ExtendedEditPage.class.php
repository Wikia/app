<?php
/**
 * This is basically an EditPage with some specific functions for the InlineEditor. This
 * allows retrieval of wikitext, summary and a submit URL, and handles when to fall back
 * to the full/traditional editor.
 */
class ExtendedEditPage extends EditPage {

	/**
	 * Inits the edit page for the InlineEditor.
	 * This is largely a copy-paste from EditPage::edit(), with some specific changes.
	 */
	public function initInlineEditor( $inlineEditor ) {
		global $wgRequest, $wgOut;

		wfProfileIn( __METHOD__ );

		$intro = '';

		$this->importFormData( $wgRequest );

		if ( !empty( $this->section ) ) return false;

		// @todo: refactor this piece in EditPage.php to (a) different function(s)
		// so that this is not an ugly copy-paste

		if ( wfReadOnly() && $this->save ) {
			// Force preview
			$this->save = false;
			$this->preview = true;
		}

		$permErrors = $this->getEditPermissionErrors();
		if ( $permErrors ) {
			wfDebug( __METHOD__ . ": User can't edit\n" );
			$this->readOnlyPage( $this->getContent( false ), true, $permErrors, 'edit' );
			wfProfileOut( __METHOD__ );
			return false;
		} else {
			if ( $this->save ) {
				$this->formtype = 'save';
			} elseif ( $this->preview ) {
				$this->formtype = 'preview';
			} elseif ( $this->diff ) {
				$this->formtype = 'diff';
			} else { # First time through
				$this->firsttime = true;
				if ( $this->previewOnOpen() ) {
					$this->formtype = 'preview';
				} else {
					$this->formtype = 'initial';
				}
			}
		}

		// If they used redlink=1 and the page exists, redirect to the main article
		if ( $wgRequest->getBool( 'redlink' ) && $this->mTitle->exists() ) {
			$wgOut->redirect( $this->mTitle->getFullURL() );
		}

		$this->isConflict = false;
		// css / js subpages of user pages get a special treatment
		$this->isCssJsSubpage       = $this->mTitle->isCssJsSubpage();
		$this->isCssSubpage         = $this->mTitle->isCssSubpage();
		$this->isJsSubpage          = $this->mTitle->isJsSubpage();
		$this->isWrongCaseCssJsPage = $this->isWrongCaseCssJsPage();

		// catch the HTML that the intro throws
		// if anything is thrown, fall back to the normal editor
		$wgOut->clearHTML();
		if ( $this->formtype == 'initial' || $this->firsttime ) {
			$this->showIntro();
			$intro .= $wgOut->getHTML();
			$wgOut->clearHTML();
		}

		if ( 'initial' == $this->formtype || 'preview' == $this->formtype || $this->firsttime ) {
			if ( $this->initialiseForm() !== false ) {
				// first init some other stuff (below)
			}
			else {
				wfProfileOut( __METHOD__ );
				return false;
			}
		}
		elseif ( 'save' == $this->formtype ) {
			// attemptSave does a redirect *itself* when it's succesful!
			$this->attemptSave();
			if ( $this->isConflict ) {
				wfProfileOut( __METHOD__ );
				return false;
			}
			else {
				// first init some other stuff (below)
			}
		}
		else {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( true );

		if ( $this->showHeader() === false ) {
			$wgOut->clearHTML();
			wfProfileOut( __METHOD__ );
			return false;
		}

		$intro .= $wgOut->getHTML();
		$wgOut->clearHTML();

		$inlineEditor->setIntro( $intro );

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * Get the wikitext to render the page from
	 * @return string
	 */
	public function getWikiText() {
		return $this->textbox1;
	}

	/**
	 * Get the summary to show in the input field
	 * @return string
	 */
	public function getSummary() {
		return $this->summary;
	}

	public function getMinorEdit() {
		return $this->minoredit;
	}

	public function getWatchThis() {
		return $this->watchthis;
	}

	/**
	 * Get the URL to submit to, with some options in the URL that are usually hidden fields
	 * @return string
	 */
	public function getSubmitUrl() {
		global $wgUser;
		$options = array(
			'action'      => 'edit',
			'wpEditToken' => $wgUser->editToken(),
			'wpEdittime'  => $this->edittime,
			'wpStarttime' => $this->starttime
		);

		if ( $this->scrolltop ) $options['wpScrolltop'] = 1;

		return $this->mTitle->getLocalURL( $options );
	}
}
