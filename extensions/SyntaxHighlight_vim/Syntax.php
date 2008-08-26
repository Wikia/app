<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
/**
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2006, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfSyntax';
$wgExtensionCredits['other'][] = array(
	'name' => 'Syntax',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'description' => 'A syntax highlight library'
);

function wfSyntax() {
	wfUsePHP( 5.1 );
	wfUseMW( '1.6alpha' );
	
	class Syntax {
		private $mIn;
		private $mInFile, $mOutFile;
		private $mVimrc;

		public function __construct( $in, $format = null, $colorscheme = null, $background = null ) {
			$this->mVimrc = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'vimrc.vim';

			$this->mIn = $in;
		}

		public function getOut() {
			$this->genTemp();
			
			if ( ! $handle = fopen( $this->mInFile, 'a' ) )
				die( 'AAAAAAA' );
			if ( fwrite( $handle, $this->mIn ) === false )
				die( 'OOOOOOOOO' );

			$html = $this->run();

			$html = preg_replace( '~^\s*<html>.*?<body.*?<pre>~s', '<pre style="background-color: black; color: gray">', $html );
			$html = preg_replace( '~</p>\s*</body>.*?$~s', '</style>', $html );

			$this->rmTemp();
			
			return $html;
		}

		private function genTemp() {
			$this->mInFile = $this->mktemp();
			$this->mOutFile = $this->mktemp();
		}
		
		private static function mktemp() {
			return rtrim( shell_exec( 'mktemp -u' ), "\n" );
		}
		
		private function rmTemp() {
			unlink( $this->mInFile );
			unlink( $this->mOutFile );
		}

		private function run() {
			shell_exec( "vim -u {$this->mVimrc} -e +'run! syntax/2html.vim' +':w {$this->mOutFile}' +':qa!' {$this->mInFile}" );
			
			return file_get_contents( $this->mOutFile );
		}
	}
}
