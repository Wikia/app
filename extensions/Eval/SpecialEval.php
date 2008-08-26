<?php
if ( ! defined( 'MEDIAWIKI' ) ) die();
/**
 * An special page extension that provides a public interface to PHP's eval()
 * function, supersecure, install it on your production servers, no really!
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfSpecialEval';
$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Eval',
	'author'         => 'Ævar Arnfjörð Bjarmason',
	'description'    => 'adds [[Special:Eval|an interface]] to the <code>eval()</code> function',
	'descriptionmsg' => 'eval-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Eval',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Eval'] = $dir . 'SpecialEval.i18n.php';
$wgExtensionAliasesFiles['Eval'] = $dir . 'SpecialEval.alias.php';

function wfSpecialEval() {
	wfUsePHP( 5.0 );
	wfUseMW( '1.6alpha' );

	global $IP;

	class Evaluate extends SpecialPage {
		public function __construct() {

			SpecialPage::SpecialPage( 'Eval' );
		}

		function getDescription() {
			return wfMsg( 'eval' );
		}

		public function execute( $par ) {
			global $wgOut, $wgRequest, $wgUseTidy;
			wfLoadExtensionMessages( 'Eval' );

			$this->setHeaders();

			$code = isset( $par ) ? $par : $wgRequest->getText( 'code' );
			$escape = $wgRequest->getBool( 'escape' );

			$eform = new EvaluateForm( $code, $escape );

			if ( trim( $code ) === '' )
				$eform->execute();
			else {
				$eform->execute();

				$eout = new EvaluateOutput( $code, $escape );
				$eout->execute();
			}
		}
	}

	class EvaluateForm {
		private $mCode, $mEscape;

		public function __construct( $code, $escape ) {
			$this->mCode =& $code;
			$this->mEscape =& $escape;
		}

		public function execute() {
			global $wgOut, $wgTitle;

			$wgOut->addHTML(
				Xml::openElement( 'form',
					array(
						'id' => 'specialeval',
						'method' => 'get',
						'action' => $wgTitle->escapeLocalUrl()
					)
				) .
					# Gotta use open and close here to
					# avoid <textarea /> which breaks
					Xml::openElement( 'textarea',
						array(
							'cols' => 40,
							'rows' => 10,
							'name' => 'code',
						)
					) .
					$this->mCode . 
					Xml::closeElement( 'textarea' ) .
					' ' .
					Xml::element( 'br', null, '' ) .
					Xml::element( 'input',
						array(
							'type' => 'checkbox',
							'name' => 'escape',
							'id' => 'escape'
						) + ( $this->mEscape ? array( 'checked' => 'checked' ) : array() ),
						''
					) .
					Xml::element( 'label',
						array(
							'for' => 'escape'
						),
						wfMsg( 'eval_escape' )
					) .
					Xml::element( 'br', null, '' ) .
					Xml::element( 'input',
						array(
							'type' => 'submit',
							'value' => wfMsg( 'eval_submit' )
						),
						''
					) .
					Xml::element('input',
						array(
							'type' => 'hidden',
							'name' => 'title',
							'value' => 'Special:Eval'
						),
						''
					) .
				Xml::closeElement( 'form' )
			);
		}

	}

	class EvaluateOutput {
		private $mCode, $mEscape;
		private $mErr;

		public function __construct( &$code, &$escape ) {
			$this->mCode =& $code;
			$this->mEscape =& $escape;
		}

		public function execute() {
			ob_start();
			eval( $this->mCode );

			$this->mErr = ob_get_clean();
			$this->summary();
		}

		private function summary() {
			global $wgOut;

			if ( $this->mCode !== '' )
				$this->code();

			if ( $this->mErr !== '' ) {
				$this->mErr =  preg_replace( '/^<br \/>/', '', $this->mErr );
				$wgOut->addHTML( Xml::element( 'h2', null, wfMsg( 'eval_out' ) ) );
				if ( $this->mEscape )
					$this->mErr =
						wfOpenElement( 'pre' ) .
						htmlspecialchars( $this->mErr ) .
						wfCloseElement( 'pre ' );
				$wgOut->addHTML( $this->mErr );
			}
		}

		private function code() {
			global $wgOut;

			if ( ! class_exists( 'GeSHi' ) )
				require_once '../extensions/geshi/geshi.php';

			$geshi = new Geshi( $this->mCode, 'php' );
			$geshi->enable_line_numbers( GESHI_NORMAL_LINE_NUMBERS );
			$geshi->set_header_type( GESHI_HEADER_DIV );

			$wgOut->addHTML(
				Xml::element( 'h2', null, wfMsg( 'eval_code' ) ) .
				$geshi->parse_code()
			);
		}
	}

	SpecialPage::addPage( new Evaluate );
}
