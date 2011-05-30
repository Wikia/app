<?php
/**
 * Contains logic for special page Special:AdvancedTranslate
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * This special page helps with the translations of %MediaWiki features that are
 * not in the main messages array (special page aliases, magic words, namespace names).
 *
 * @ingroup SpecialPage TranslateSpecialPage
 */
class SpecialMagic extends SpecialPage {
	/**
	 * Message prefix for translations
	 * @todo Remove.
	 */
	const MSG = 'translate-magic-';

	const MODULE_MAGIC     = 'words';
	const MODULE_SPECIAL   = 'special';
	const MODULE_NAMESPACE = 'namespace';

	/**
	 * List of supported modules
	 */
	private $aModules = array(
		self::MODULE_SPECIAL,
		self::MODULE_NAMESPACE,
		self::MODULE_MAGIC
	);

	/**
	 * Page options
	 */
	private $options = array();
	private $defaults = array();
	private $nondefaults = array();

	public function __construct() {
		parent::__construct( 'Magic' );
	}

	/**
	 * @see SpecialPage::getDescription
	 */
	function getDescription() {
		return wfMsg( self::MSG . 'pagename' );
	}

	/**
	 * Returns HTML5 output of the form
	 * GLOBALS: $wgLang, $wgScript
	 */
	protected function getForm() {
		global $wgLang, $wgScript;

		$form = Xml::tags( 'form',
			array(
				'action' => $wgScript,
				'method' => 'get'
			),

			'<table><tr><td>' .
				wfMsgHtml( 'translate-page-language' ) .
			'</td><td>' .
				TranslateUtils::languageSelector( $wgLang->getCode(), $this->options['language'] ) .
			'</td></tr><tr><td>' .
				wfMsgHtml( 'translate-magic-module' ) .
			'</td><td>' .
				$this->moduleSelector( $this->options['module'] ) .
			'</td></tr><tr><td colspan="2">' .
				Xml::submitButton( wfMsg( self::MSG . 'submit' ) ) . ' ' .
				Xml::submitButton( wfMsg( 'translate-magic-cm-export' ), array( 'name' => 'export' ) ) .
			'</td></tr></table>' .
			Html::hidden( 'title', $this->getTitle()->getPrefixedText() )
		);
		return $form;
	}

	/**
	 * Helper function get module selector.
	 *
	 * @param $selectedId \string Which value should be selected by default
	 * @return \string HTML5-compatible select-element.
	 */
	protected function moduleSelector( $selectedId ) {
		$selector = new HTMLSelector( 'module', 'module', $selectedId );
		foreach ( $this->aModules as $code ) {
			$selector->addOption( wfMsg( self::MSG . $code ), $code );
		}
		return $selector->getHTML();
	}

	protected function setup( $parameters ) {
		global $wgUser, $wgRequest;

		$defaults = array(
			/* str  */ 'module'   => '',
			/* str  */ 'language' => $wgUser->getOption( 'language' ),
			/* bool */ 'export'   => false,
			/* bool */ 'savetodb' => false,
		);

		/**
		 * Place where all non default variables will end.
		 */
		$nondefaults = array();

		/**
		 * Temporary store possible values parsed from parameters.
		 */
		$options = $defaults;
		foreach ( $options as $v => $t ) {
			if ( is_bool( $t ) ) {
				$r = $wgRequest->getBool( $v, $options[$v] );
			} elseif ( is_int( $t ) ) {
				$r = $wgRequest->getInt( $v, $options[$v] );
			} elseif ( is_string( $t ) ) {
				$r = $wgRequest->getText( $v, $options[$v] );
			}
			wfAppendToArrayIfNotDefault( $v, $r, $defaults, $nondefaults );
		}

		$this->defaults    = $defaults;
		$this->nondefaults = $nondefaults;
		$this->options     = $nondefaults + $defaults;
	}

	/**
	 * The special page running code
	 * GLOBALS: $wgRequest, $wgOut, $wgUser
	 */
	public function execute( $parameters ) {
		global $wgUser, $wgOut, $wgRequest;

		$this->setup( $parameters );
		$this->setHeaders();

		$wgOut->addHTML( $this->getForm() );

		if ( !$this->options['module'] ) {
			return;
		}
		switch ( $this->options['module'] ) {
			case 'alias':
			case self::MODULE_SPECIAL:
				$o = new SpecialPageAliasesCM( $this->options['language'] );
				break;
			case self::MODULE_MAGIC:
				$o = new MagicWordsCM( $this->options['language'] );
				break;
			case self::MODULE_NAMESPACE:
				$o = new NamespaceCM( $this->options['language'] );
				break;
			default:
				throw new MWException( "Unknown module {$this->options['module']}" );
		}

		if ( $wgRequest->wasPosted() && $this->options['savetodb'] ) {
			if ( !$wgUser->isAllowed( 'translate' ) ) {
				$wgOut->permissionRequired( 'translate' );
			} else {
				$errors = array();
				$o->loadFromRequest( $wgRequest );
				$o->validate( $errors );
				if ( $errors ) {
					$wgOut->wrapWikiMsg( '<div class="error">$1</div>',
						'translate-magic-notsaved' );
					$this->outputErrors( $errors );
					$wgOut->addHTML( $o->output() );
					return;
				} else {
					$o->save( $wgRequest );
					$wgOut->wrapWikiMsg( '<strong><b>$1</b></strong>', 'translate-magic-saved' );
					$wgOut->addHTML( $o->output() );
					return;
				}
			}
		}

		if ( $this->options['export'] ) {
			$output = $o->export();
			if ( $output === '' ) {
				$wgOut->addWikiMsg( 'translate-magic-nothing-to-export' );
				return;
			}
			$result = Xml::element( 'textarea', array( 'rows' => '30' ), $output );
			$wgOut->addHTML( $result );
			return;
		}

		$wgOut->addWikiMsg( self::MSG . 'help' );
		$errors = array();
		$o->validate( $errors );
		if ( $errors ) $this->outputErrors( $errors );
		$wgOut->addHTML( $o->output() );
	}

	protected function outputErrors( $errors ) {
		global $wgLang, $wgOut;
		$count = $wgLang->formatNum( count( $errors ) );
		$wgOut->addWikiMsg( 'translate-magic-errors', $count );
		$wgOut->addHTML( '<ol>' );
		foreach ( $errors as $error ) {
			$wgOut->addHTML( "<li>$error</li>" );
		}
		$wgOut->addHTML( '</ol>' );
	}
}
