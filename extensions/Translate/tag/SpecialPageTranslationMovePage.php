<?php
/**
 * Contains class to override Special:MovePage for page translation.
 *
 * @file
 * @author Niklas Laxström
 * @copyright  Copyright © 2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Overrides Special:Movepage to to allow renaming a page translation page and
 * all related translations and derivative pages.
 *
 * @ingroup SpecialPage
 * @ingroup PageTranslation
 */
class SpecialPageTranslationMovePage extends UnlistedSpecialPage {
	// Basic form parameters both as text and as titles
	protected $newText, $newTitle, $oldText, $oldTitle;

	// Other form parameters
	/**
	 * 'check' or 'perform'
	 */
	protected $subaction;

	/**
	 * There must be reason for everything.
	 */
	protected $reason;

	/**
	 * Allow skipping non-translation subpages.
	 */
	protected $moveSubpages;


	/**
	 * TranslatablePage instance.
	 */
	protected $page;

	/**
	 * User instance.
	 */
	protected $user;

	/**
	 * Whether MovePageForm extends SpecialPage
	 */
	protected $old;

	public function __construct( $old ) {
		parent::__construct( 'Movepage' );
		$this->old = $old;
	}

	/*
	 * Partially copies from SpecialMovepage.php, because it cannot be
	 * extented in other ways.
	 */
	public function execute( $par ) {
		global $wgOut, $wgRequest, $wgUser;

		// Yes, the use of getVal() and getText() is wanted, see bug 20365
		$this->oldText = $wgRequest->getVal( 'wpOldTitle', $par );
		$this->newText = $wgRequest->getText( 'wpNewTitle' );

		$this->oldTitle = Title::newFromText( $this->oldText );
		$this->newTitle = Title::newFromText( $this->newText );

		$this->reason = $wgRequest->getText( 'reason' );
		// Checkboxes that default being checked are tricky
		$this->moveSubpages = $wgRequest->getBool( 'subpages', !$wgRequest->wasPosted() );

		$this->user = $wgUser;

		if ( $this->doBasicChecks() !== true ) {
			return;
		}

		// Real stuff starts here
		$page = TranslatablePage::newFromTitle( $this->oldTitle );
		if ( $page->getMarkedTag() !== false ) {
			$this->page = $page;

			$wgOut->setPagetitle( wfMsg( 'pt-movepage-title', $this->oldText ) );
			$link = $this->user->getSkin()->link( $this->oldTitle );


			if ( !$this->user->isAllowed( 'pagetranslation' ) ) {
				$wgOut->permissionRequired( 'pagetranslation' );
				return;
			}

			// Is there really no better way to do this?
			$subactionText = $wgRequest->getText( 'subaction' );
			switch ( $subactionText ) {
			case wfMsg( 'pt-movepage-action-check' ):
				$subaction = 'check'; break;
			case wfMsg( 'pt-movepage-action-perform' ):
				$subaction = 'perform'; break;
			case wfMsg( 'pt-movepage-action-other' ):
				$subaction = ''; break;
			default:
				$subaction = '';
			}

			if ( $subaction === 'check' && $this->checkToken() && $wgRequest->wasPosted() ) {
				$blockers = $this->checkMoveBlockers( );
				if ( count( $blockers ) ) {
					$this->showErrors( $blockers );
					$this->showForm();
				} else {
					$this->showConfirmation();
				}
			} elseif ( $subaction === 'perform' && $this->checkToken() && $wgRequest->wasPosted() ) {
				$this->performAction();
			} else {
				$this->showForm();
			}

		} else {
			// Delegate... don't want to reimplement this
			if ( $this->old ) {
				$this->doOldNormalMovePage();
			} else {
				$this->doNormalMovePage( $par );
			}
		}
	}

	/**
	 * Do the basic checks whether moving is possible and whether
	 * the input looks anywhere near sane.
	 */
	protected function doBasicChecks() {
		global $wgOut;
		# Check for database lock
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if ( $this->oldTitle === null ) {
			$wgOut->showErrorPage( 'notargettitle', 'notargettext' );
			return;
		}

		if ( !$this->oldTitle->exists() ) {
			$wgOut->showErrorPage( 'nopagetitle', 'nopagetext' );
			return;
		}

		# Check rights
		$permErrors = $this->oldTitle->getUserPermissionsErrors( 'move', $this->user );
		if ( !empty( $permErrors ) ) {
			$wgOut->showPermissionsErrorPage( $permErrors );
			return;
		}

		// Let the caller know it's safe to continue
		return true;
	}

	protected function doNormalMovePage( $par ) {
		$sp = new MovePageForm();
		$sp->execute( $par );
	}

	protected function doOldNormalMovePage() {
		global $wgRequest;
		$form = new MovePageForm( $this->oldTitle, $this->newTitle );
		if ( 'submit' == $wgRequest->getVal( 'action' ) && $this->checkToken() && $wgRequest->wasPosted() ) {
			$form->doSubmit();
		} else {
			$form->showForm( '' );
		}
	}

	/**
	 * Checks token. Use before real actions happen. Have to use wpEditToken
	 * for compatibility for SpecialMovepage.php.
	 */
	protected function checkToken() {
		global $wgRequest;
		return $this->user->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) );
	}

	/**
	 * Pretty-print the list of errors.
	 * @param $errors Array with message key and parameters
	 */
	protected function showErrors( array $errors ) {
		global $wgOut, $wgLang;
		if ( count( $errors ) ) {
			$wgOut->addHTML( Html::openElement( 'div', array( 'class' => 'error' ) ) );
			$wgOut->addWikiMsg( 'pt-movepage-blockers', $wgLang->formatNum( count( $errors ) ) );
			$wgOut->addHTML( '<ul>' );
			foreach ( $errors as $error ) {
				// I have no idea what the parser is doing, but this is mad.
				// <li>$1</li> doesn't work.
				$wgOut->wrapWikiMsg( "<li>$1", $error );
			}
			$wgOut->addHTML( '</ul></div>' );
		}
	}

	/**
	 * The query form.
	 */
	protected function showForm() {
		global $wgOut;

		$wgOut->addWikiMsg( 'pt-movepage-intro' );

		$br = Html::element( 'br' );
		$subaction = array( 'name' => 'subaction' );
		$disabled =  array( 'disabled' => 'disabled' );
		$formParams = array( 'method' => 'post', 'action' => $this->getTitle( $this->oldText )->getLocalURL() );

		$form = array();
		$form[] = Xml::fieldset( wfMsg( 'pt-movepage-legend' ) );
		$form[] = Html::openElement( 'form', $formParams );
		$form[] = Html::hidden( 'wpEditToken', $this->user->editToken() );
		$form[] = Html::hidden( 'wpOldTitle', $this->oldText );
		$this->addInputLabel( $form, wfMsg( 'pt-movepage-current' ), 'wpOldTitleFake', 30, $this->oldText, $disabled );
		$this->addInputLabel( $form, wfMsg( 'pt-movepage-new' ), 'wpNewTitle', 30, $this->newText );
		$this->addInputLabel( $form, wfMsg( 'pt-movepage-reason' ), 'reason', 60, $this->reason );
		$form[] = Xml::checkLabel( wfMsg( 'pt-movepage-subpages' ), 'subpages', 'mw-subpages', $this->moveSubpages ) . $br;
		$form[] = Xml::submitButton( wfMsg( 'pt-movepage-action-check' ), $subaction );
		$form[] = Html::closeElement( 'form' );
		$form[] = Html::closeElement( 'fieldset' );
		$wgOut->addHTML( implode( "\n", $form ) );
	}

	/**
	 * Shortcut for keeping the code at least a bit readable. Adds label and input into $form array.
	 * @param $form \list{String} Array where input element and label is appended.
	 * @param $label \string Label text.
	 * @param $name \string Name attribute.
	 * @param $size \int Size attribute of the input element. Default false.
	 * @param $text \string Text of the value attribute. Default false.
	 * @param $attribs \array Extra attributes. Default empty array.
	 */
	protected function addInputLabel( &$form, $label, $name, $size = false , $text = false, $attribs = array() ) {
		$br = Html::element( 'br' );
		list( $label, $input ) = Xml::inputLabelSep( $label, $name, $name, $size, $text, $attribs );
		$form[] = $label . $br;
		$form[] = $input . $br;
	}

	/**
	 * The second form, which still allows changing some things.
	 * Lists all the action which would take place.
	 */
	protected function showConfirmation() {
		global $wgOut, $wgLang;

		$wgOut->addWikiMsg( 'pt-movepage-intro' );

		$base = $this->oldTitle->getPrefixedText();
		$target = $this->newTitle;
		$count = 1; // Base page

		$wgOut->wrapWikiMsg( '== $1 ==', 'pt-movepage-list-pages' );
		$this->printChangeLine( $base, $this->oldTitle, $target );

		$wgOut->wrapWikiMsg( '=== $1 ===', 'pt-movepage-list-translation' );
		$translationPages = $this->getTranslationPages();
		foreach ( $translationPages as $old ) {
			$count++;
			$this->printChangeLine( $base, $old, $target );
		}

		$wgOut->wrapWikiMsg( '=== $1 ===', 'pt-movepage-list-section' );
		$sectionPages = $this->getSectionPages();
		foreach ( $sectionPages as $old ) {
			$count++;
			$this->printChangeLine( $base, $old, $target );
		}

		$wgOut->wrapWikiMsg( '=== $1 ===', 'pt-movepage-list-other' );
		$subpages = $this->getSubpages();
		foreach ( $subpages as $old ) {
			if ( TranslatablePage::isTranslationPage( $old ) ) continue;
			if ( $this->moveSubpages ) { $count++; }
			$this->printChangeLine( $base, $old, $target, $this->moveSubpages );
		}

		$wgOut->addWikiText( "----\n" );
		$wgOut->addWikiMsg( 'pt-movepage-list-count', $wgLang->formatNum( $count ) );

		$br = Html::element( 'br' );
		$disabled =  array( 'disabled' => 'disabled' );
		$subaction = array( 'name' => 'subaction' );
		$formParams = array( 'method' => 'post', 'action' => $this->getTitle( $this->oldText )->getLocalURL() );

		$form = array();
		$form[] = Xml::fieldset( wfMsg( 'pt-movepage-legend' ) );
		$form[] = Html::openElement( 'form', $formParams );
		$form[] = Html::hidden( 'wpEditToken', $this->user->editToken() );
		// Apparently HTML spec says that disabled elements are not submitted... ARGH!
		$form[] = Html::hidden( 'wpOldTitle', $this->oldText );
		$form[] = Html::hidden( 'wpNewTitle', $this->newText );
		$this->addInputLabel( $form, wfMsg( 'pt-movepage-current' ), 'wpOldTitleFake', 30, $this->oldText, $disabled );
		$this->addInputLabel( $form, wfMsg( 'pt-movepage-new' ), 'wpNewTitleFake', 30, $this->newText, $disabled );
		$this->addInputLabel( $form, wfMsg( 'pt-movepage-reason' ), 'reason', 60, $this->reason );
		$form[] = Html::hidden( 'subpages', $this->moveSubpages );
		$form[] = Xml::checkLabel( wfMsg( 'pt-movepage-subpages' ), 'subpagesFake', 'mw-subpages', $this->moveSubpages, $disabled ) . $br;
		$form[] = Xml::submitButton( wfMsg( 'pt-movepage-action-perform' ), $subaction );
		$form[] = Xml::submitButton( wfMsg( 'pt-movepage-action-other' ), $subaction );
		$form[] = Html::closeElement( 'form' );
		$form[] = Html::closeElement( 'fieldset' );
		$wgOut->addHTML( implode( "\n", $form ) );
	}

	protected function printChangeLine( $base, $old, $target, $enabled = true ) {
		global $wgOut;

		$to = $this->newPageTitle( $base, $old, $target );

		if ( $enabled ) {
			$wgOut->addWikiText( '* ' . $old->getPrefixedText() . ' → ' . $to );
		} else {
			$wgOut->addWikiText( '* ' . $old->getPrefixedText() );
		}
	}

	protected function performAction() {
		$jobs = array();

		$target = $this->newTitle;
		$base = $this->oldTitle->getPrefixedText();
		$oldLatest = $this->oldTitle->getLatestRevId();

		$translationPages = $this->getTranslationPages();
		foreach ( $translationPages as $old ) {
			$to = $this->newPageTitle( $base, $old, $target );
			$jobs[$old->getPrefixedText()] = MoveJob::newJob( $old, $to, $base, $this->user );
		}

		$sectionPages = $this->getSectionPages();
		foreach ( $sectionPages as $old ) {
			$to = $this->newPageTitle( $base, $old, $target );
			$jobs[$old->getPrefixedText()] = MoveJob::newJob( $old, $to, $base, $this->user );
		}

		if ( $this->moveSubpages ) {
			$subpages = $this->getSubpages();
			foreach ( $subpages as $old ) {
				if ( TranslatablePage::isTranslationPage( $old ) ) {
					continue;
				}

				$to = $this->newPageTitle( $base, $old, $target );
				$jobs[$old->getPrefixedText()] = MoveJob::newJob( $old, $to, $base, $this->user );
			}
		}

		Job::batchInsert( $jobs );

		global $wgMemc;
		$wgMemc->set( wfMemcKey( 'pt-base', $base ), array_keys( $jobs ), 60 * 60 * 6 );

		MoveJob::forceRedirects( false );

		$errors = $this->oldTitle->moveTo( $this->newTitle, true, $this->reason, false );
		if ( is_array( $errors ) ) {
			$this->showErrors( $errors );
		}

		MoveJob::forceRedirects( true );

		$newTpage = TranslatablePage::newFromTitle( $this->newTitle );
		$newTpage->addReadyTag( $this->newTitle->getLatestRevId( Title::GAID_FOR_UPDATE ) );

		if ( $newTpage->getMarkedTag() === $oldLatest ) {
			$newTpage->addMarkedTag( $this->newTitle->getLatestRevId( Title::GAID_FOR_UPDATE ) );
		}

		MessageGroups::clearCache();
		// TODO: defer or make faster
		MessageIndexRebuilder::execute();

		global $wgOut;
		$wgOut->addWikiMsg( 'pt-movepage-started' );
	}

	protected function checkMoveBlockers() {
		$blockers = array();

		$target = $this->newTitle;

		if ( !$target ) {
			$blockers[] = array( 'pt-movepage-block-base-invalid' );
			return $blockers;
		}

		if ( $target->getNamespace() == NS_MEDIAWIKI || $target->getNamespace() == NS_TRANSLATIONS ) {
			$blockers[] = array( 'immobile-target-namespace', $target->getNsText() );
			return $blockers;
		}

		$base = $this->oldTitle->getPrefixedText();

		if ( $target->exists() ) {
			$blockers[] = array( 'pt-movepage-block-base-exists', $target->getPrefixedText() );
		} else {
			$errors = $this->oldTitle->isValidMoveOperation( $target, true, $this->reason );
			if ( is_array( $errors ) ) $blockers = array_merge( $blockers, $errors );
		}

		// Don't spam the same errors for all pages if base page fails
		if ( $blockers ) return $blockers;

		$translationPages = $this->getTranslationPages();
		foreach ( $translationPages as $old ) {
			$new = $this->newPageTitle( $base, $old, $target );
			if ( !$new ) {
				$blockers[] = array( 'pt-movepage-block-tp-invalid', $old->getPrefixedText() );
			} elseif ( $new->exists() ) {
				$blockers[] = array( 'pt-movepage-block-tp-exists', $old->getPrefixedText(), $new->getPrefixedText() );
			} else {
				$errors = $old->isValidMoveOperation( $target, false );
				if ( is_array( $errors ) ) $blockers = array_merge( $blockers, $errors );
			}
		}

		$sections = $this->getSectionPages();
		foreach ( $sections as $old ) {
			$new = $this->newPageTitle( $base, $old, $target );
			if ( !$new ) {
				$blockers[] = array( 'pt-movepage-block-section-invalid', $old->getPrefixedText() );
			} elseif ( $new->exists() ) {
				$blockers[] = array( 'pt-movepage-block-section-exists', $old->getPrefixedText(), $new->getPrefixedText() );
			} else {
				$errors = $old->isValidMoveOperation( $target, false );
				if ( is_array( $errors ) ) $blockers = array_merge( $blockers, $errors );
			}
		}

		if ( $this->moveSubpages ) {
			$subpages = $this->getSubpages();
			foreach ( $subpages as $old ) {
				if ( TranslatablePage::isTranslationPage( $old ) ) {
					continue;
				}

				$new = $this->newPageTitle( $base, $old, $target );

				if ( !$new ) {
					$blockers[] = array( 'pt-movepage-block-subpage-invalid', $old->getPrefixedText() );
				} elseif ( $new->exists() ) {
					$blockers[] = array( 'pt-movepage-block-subpage-exists', $old->getPrefixedText(), $new->getPrefixedText() );
				} else {
					$errors = $old->isValidMoveOperation( $target, false );
					if ( is_array( $errors ) ) $blockers = array_merge( $blockers, $errors );
				}
			}
		}

		return $blockers;
	}

	/**
	 * Makes old title into a new title by replacing $base part of old title
	 * with $target.
	 * @param $base String Title::getPrefixedText() of the base page.
	 * @param $old Title The title to convert.
	 * @param $target Title The target title for the base page.
	 * @return Title
	 */
	protected function newPageTitle( $base, Title $old, Title $target ) {
		$search = preg_quote( $base, '~' );

		if ( $old->getNamespace() == NS_TRANSLATIONS ) {
			$new = $old->getText();
			$new = preg_replace( "~^$search~", $target->getPrefixedText(), $new, 1 );
			return Title::makeTitleSafe( NS_TRANSLATIONS, $new );
		} else {
			$new = $old->getPrefixedText();
			$new = preg_replace( "~^$search~", $target->getPrefixedText(), $new, 1 );
			return Title::newFromText( $new );
		}
	}

	/**
	 * Returns all section pages, including those which are currently not active.
	 * @return TitleArray.
	 */
	protected function getSectionPages() {
		if ( !isset( $this->sectionPages ) ) {
			$base = $this->page->getTitle()->getPrefixedDBKey();

			$dbw = wfGetDB( DB_MASTER );
			$fields = array( 'page_namespace', 'page_title' );
			$titleCond = 'page_title ' . $dbw->buildLike( "$base/", $dbw->anyString() );
			$conds = array( 'page_namespace' => NS_TRANSLATIONS, $titleCond );
			$result = $dbw->select( 'page', $fields, $conds, __METHOD__ );
			$this->sectionPages = TitleArray::newFromResult( $result );
		}
		return $this->sectionPages;
	}

	/**
	 * Returns only translation subpages.
	 * @return Array of titles.
	 */
	protected function getTranslationPages() {
		if ( !isset( $this->translationPages ) ) {
			$this->translationPages = $this->page->getTranslationPages();
		}
		return $this->translationPages;
	}

	/**
	 * Returns all subpages, if the namespace has them enabled.
	 * @return Empty array or TitleArray
	 */
	protected function getSubpages() {
		return $this->page->getTitle()->getSubpages();
	}
}
