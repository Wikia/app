<?php
/**
 * Special page which enables deleting translations of translatable pages
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2012, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Special page which enables deleting translations of translatable pages
 *
 * @ingroup SpecialPage PageTranslation
 */
class SpecialPageTranslationDeletePage extends UnlistedSpecialPage {
	// Basic form parameters both as text and as titles
	protected $text;

	/**
	 * @var Title
	 */
	protected $title;

	// Other form parameters
	/// 'check' or 'perform'
	protected $subaction;

	/// There must be reason for everything.
	protected $reason;

	/// Allow skipping non-translation subpages.
	protected $doSubpages = false;

	/**
	 * @var TranslatablePage
	 */
	protected $page;

	/// Contains the language code if we are working with translation page
	protected $code;

	protected $sectionPages;

	protected $translationPages;

	/**
	 * User instance.
	 *
	 * @var User
	 */
	protected $user;

	public function __construct() {
		parent::__construct( 'PageTranslationDeletePage' );
	}

	public function execute( $par ) {
		global $wgOut, $wgRequest, $wgUser;

		// Yes, the use of getVal() and getText() is wanted, see bug 20365
		$this->text = $wgRequest->getVal( 'wpTitle', $par );
		$this->title = Title::newFromText( $this->text );
		$this->reason = $wgRequest->getText( 'reason' );
		// Checkboxes that default being checked are tricky
		$this->doSubpages = $wgRequest->getBool( 'subpages', !$wgRequest->wasPosted() );

		$this->user = $wgUser;

		if ( $this->doBasicChecks() !== true ) {
			return;
		}

		// Real stuff starts here
		if ( TranslatablePage::isSourcePage( $this->title ) ) {
			$wgOut->setPagetitle( wfMsg( 'pt-deletepage-full-title', $this->title->getPrefixedText() ) );

			$this->code = '';
			$this->page = TranslatablePage::newFromTitle( $this->title );
		} else {
			$page = TranslatablePage::isTranslationPage( $this->title );
			if ( $page ) {
				$wgOut->setPagetitle( wfMsg( 'pt-deletepage-lang-title', $this->title->getPrefixedText() ) );

				list( , $this->code ) = TranslateUtils::figureMessage( $this->title->getText() );
				$this->page = $page;
			} else {
				$wgOut->showErrorPage( 'pt-deletepage-invalid-title', 'pt-deletepage-invalid-text' );
				return;
			}
		}

		if ( !$this->user->isAllowed( 'pagetranslation' ) ) {
			$wgOut->permissionRequired( 'pagetranslation' );
			return;
		}

		// Is there really no better way to do this?
		$subactionText = $wgRequest->getText( 'subaction' );
		switch ( $subactionText ) {
		case wfMsg( 'pt-deletepage-action-check' ):
			$subaction = 'check'; break;
		case wfMsg( 'pt-deletepage-action-perform' ):
			$subaction = 'perform'; break;
		case wfMsg( 'pt-deletepage-action-other' ):
			$subaction = ''; break;
		default:
			$subaction = '';
		}

		if ( $subaction === 'check' && $this->checkToken() && $wgRequest->wasPosted() ) {
			$this->showConfirmation();
		} elseif ( $subaction === 'perform' && $this->checkToken() && $wgRequest->wasPosted() ) {
			$this->performAction();
		} else {
			$this->showForm();
		}

	}

	/**
	 * Do the basic checks whether moving is possible and whether
	 * the input looks anywhere near sane.
	 * @return bool
	 */
	protected function doBasicChecks() {
		global $wgOut;
		# Check for database lock
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}

		if ( $this->title === null ) {
			$wgOut->showErrorPage( 'notargettitle', 'notargettext' );
			return false;
		}

		if ( !$this->title->exists() ) {
			$wgOut->showErrorPage( 'nopagetitle', 'nopagetext' );
			return false;
		}

		# Check rights
		$permErrors = $this->title->getUserPermissionsErrors( 'delete', $this->user );
		if ( !empty( $permErrors ) ) {
			$wgOut->showPermissionsErrorPage( $permErrors );
			return false;
		}

		// Let the caller know it's safe to continue
		return true;
	}

	/**
	 * Checks token. Use before real actions happen. Have to use wpEditToken
	 * for compatibility for SpecialMovepage.php.
	 * @return bool
	 */
	protected function checkToken() {
		global $wgRequest;
		return $this->user->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) );
	}

	/**
	 * The query form.
	 */
	protected function showForm() {
		global $wgOut;

		$wgOut->addWikiMsg( 'pt-deletepage-intro' );

		$subaction = array( 'name' => 'subaction' );
		$formParams = array( 'method' => 'post', 'action' => $this->getTitle( $this->text )->getLocalURL() );

		$form = array();
		$form[] = Xml::fieldset( wfMsg( 'pt-deletepage-any-legend' ) );
		$form[] = Html::openElement( 'form', $formParams );
		$form[] = Html::hidden( 'wpEditToken', $this->user->editToken() );
		$this->addInputLabel( $form, wfMsg( 'pt-deletepage-current' ), 'wpTitle', 30, $this->text );
		$this->addInputLabel( $form, wfMsg( 'pt-deletepage-reason' ), 'reason', 60, $this->reason );
		$form[] = Xml::submitButton( wfMsg( 'pt-deletepage-action-check' ), $subaction );
		$form[] = Xml::closeElement( 'form' );
		$form[] = Xml::closeElement( 'fieldset' );
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

		$wgOut->addWikiMsg( 'pt-deletepage-intro' );

		$target = $this->title;
		$count = 1; // Base page

		$wgOut->wrapWikiMsg( '== $1 ==', 'pt-deletepage-list-pages' );
		if ( !$this->singleLanguage() ) {
			$this->printChangeLine( $this->title );
		}

		$wgOut->wrapWikiMsg( '=== $1 ===', 'pt-deletepage-list-translation' );
		$translationPages = $this->getTranslationPages();
		foreach ( $translationPages as $old ) {
			$count++;
			$this->printChangeLine( $old );
		}

		$wgOut->wrapWikiMsg( '=== $1 ===', 'pt-deletepage-list-section' );
		$sectionPages = $this->getSectionPages( $target );
		foreach ( $sectionPages as $old ) {
			$count++;
			$this->printChangeLine( $old );
		}

		$wgOut->wrapWikiMsg( '=== $1 ===', 'pt-deletepage-list-other' );
		$subpages = $this->getSubpages();
		foreach ( $subpages as $old ) {
			if ( TranslatablePage::isTranslationPage( $old ) ) continue;
			if ( $this->doSubpages ) { $count++; }
			$this->printChangeLine( $old, $this->doSubpages );
		}

		$wgOut->addWikiText( "----\n" );
		$wgOut->addWikiMsg( 'pt-deletepage-list-count', $wgLang->formatNum( $count ) );

		$br = Html::element( 'br' );
		$readonly =  array( 'readonly' => 'readonly' );

		$subaction = array( 'name' => 'subaction' );
		$formParams = array( 'method' => 'post', 'action' => $this->getTitle( $this->text )->getLocalURL() );

		$form = array();
		if ( $this->singleLanguage() ) {
			$form[] = Xml::fieldset( wfMsg( 'pt-deletepage-lang-legend' ) );
		} else {
			$form[] = Xml::fieldset( wfMsg( 'pt-deletepage-full-legend' ) );
		}
		$form[] = Html::openElement( 'form', $formParams );
		$form[] = Html::hidden( 'wpEditToken', $this->user->editToken() );
		$this->addInputLabel( $form, wfMsg( 'pt-deletepage-current' ), 'wpTitle', 30, $this->text, $readonly );
		$this->addInputLabel( $form, wfMsg( 'pt-deletepage-reason' ), 'reason', 60, $this->reason );
		$form[] = Xml::checkLabel( wfMsg( 'pt-deletepage-subpages' ), 'subpages', 'mw-subpages', $this->doSubpages, $readonly ) . $br;
		$form[] = Xml::submitButton( wfMsg( 'pt-deletepage-action-perform' ), $subaction );
		$form[] = Xml::submitButton( wfMsg( 'pt-deletepage-action-other' ), $subaction );
		$form[] = Xml::closeElement( 'form' );
		$form[] = Xml::closeElement( 'fieldset' );
		$wgOut->addHTML( implode( "\n", $form ) );
	}

	/**
	 * @param $title Title
	 * @param $enabled bool
	 */
	protected function printChangeLine( $title, $enabled = true ) {
		global $wgOut;
		if ( $enabled ) {
			$wgOut->addWikiText( '* ' . $title->getPrefixedText() );
		} else {
			$wgOut->addWikiText( '* <s>' . $title->getPrefixedText() . '</s>' );
		}
	}

	protected function performAction() {
		$jobs = array();
		$target = $this->title;
		$base = $this->title->getPrefixedText();

		$translationPages = $this->getTranslationPages();
		foreach ( $translationPages as $old ) {
			$jobs[$old->getPrefixedText()] = DeleteJob::newJob( $old, $base, !$this->singleLanguage(), $this->user );
		}

		$sectionPages = $this->getSectionPages();
		foreach ( $sectionPages as $old ) {
			$jobs[$old->getPrefixedText()] = DeleteJob::newJob( $old, $base, !$this->singleLanguage(), $this->user );
		}

		if ( !$this->doSubpages ) {
			$subpages = $this->getSubpages();
			foreach ( $subpages as $old ) {
				if ( TranslatablePage::isTranslationPage( $old ) ) {
					continue;
				}

				$jobs[$old->getPrefixedText()] = DeleteJob::newJob( $old, $base, !$this->singleLanguage(), $this->user );
			}
		}

		Job::batchInsert( $jobs );

		$cache = wfGetCache( CACHE_DB );
		$cache->set( wfMemcKey( 'pt-base', $target->getPrefixedText() ), array_keys( $jobs ), 60 * 60 * 6 );


		if ( !$this->singleLanguage() ) {
			$this->page->removeTags();
		}

		MessageGroups::clearCache();
		MessageIndexRebuildJob::newJob()->insert();

		global $wgOut;
		$wgOut->addWikiMsg( 'pt-deletepage-started' );
	}

	/**
	 * Returns all section pages, including those which are currently not active.
	 * @return TitleArray.
	 */
	protected function getSectionPages() {
		if ( !isset( $this->sectionPages ) ) {
			$base = $this->page->getTitle()->getPrefixedDBKey();

			$dbw = wfGetDB( DB_MASTER );
			if ( $this->singleLanguage() ) {
				$like = $dbw->buildLike( "$base/", $dbw->anyString(), "/{$this->code}" );
			} else {
				$like = $dbw->buildLike( "$base/", $dbw->anyString() );
			}

			$fields = array( 'page_namespace', 'page_title' );
			$titleCond = 'page_title ' . $like;
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
		if ( $this->singleLanguage() ) {
			return array( $this->title );
		}

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
		return $this->title->getSubpages();
	}

	/**
	 * @return bool
	 */
	protected function singleLanguage() {
		return $this->code !== '';
	}
}
