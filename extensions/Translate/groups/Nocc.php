<?php
/**
 * Support NOCC: http://nocc.sourceforge.net.
 *
 * @addtogroup Extensions
 *
 * @author Siebrand Mazeland
 * @copyright Copyright © 2009, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class NoccMessageGroup extends MessageGroupOld {
	protected $label = 'NOCC (webmail client)';
	protected $id    = 'out-nocc';
	protected $type  = 'nocc';

	protected   $fileDir  = '__BUG__';

	public function getPath() { return $this->fileDir; }
	public function setPath( $value ) { $this->fileDir = $value; }

	protected $codeMap = array(
		'sr-el' => 'sr',
	);

	protected $optional = array(
		'lang_locale', 'lang_dir',
	);

	protected $ignored = array(
		'charset',
	);

	public $header = '<?php
/**
 * Language configuration file for NOCC
 *
 * Copyright 2001 Nicolas Chalanset <nicocha@free.fr>
 * Copyright 2001 Olivier Cahagne <cahagn_o@epita.fr>
 *
 * This file is part of NOCC. NOCC is free software under the terms of the
 * GNU General Public License. You should have received a copy of the license
 * along with NOCC.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    NOCC
 * @subpackage Translations
 * @license    http://www.gnu.org/licenses/ GNU General Public License
 * @version    SVN: $Id: Nocc.php 53612 2009-07-21 17:58:35Z nikerabbit $
 */';

	public function getMessageFile( $code ) {
		if ( isset( $this->codeMap[$code] ) ) {
			$code = $this->codeMap[$code];
		}
		return "$code.php";
	}

	protected function getFileLocation( $code ) {
		return $this->fileDir . '/' . $this->getMessageFile( $code );
	}

	public function getReader( $code ) {
		return new PhpVariablesFormatReader( $this->getFileLocation( $code ) );
	}

	public function getWriter() {
		return new PhpVariablesFormatWriter( $this );
	}

	public function getChecker() {
		$checker = new MessageChecker( $this );
		$checker->setChecks( array(
			array( $checker, 'printfCheck' ),
			array( $checker, 'braceBalanceCheck' ),
		) );
		return $checker;
	}
}
