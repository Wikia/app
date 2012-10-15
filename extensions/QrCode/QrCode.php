<?php
/**
 * QrCode.php
 * Written by David Raison
 * @license: LGPL (GNU Lesser General Public License) http://www.gnu.org/licenses/lgpl.html
 *
 * @file QrCode.php
 * @ingroup QrCode
 *
 * @author David Raison
 *
 * Uses the phpqrcode library written by Dominik Dzienia (C) 2010,
 * which is, in turn, based on C libqrencode library
 * Copyright (C) 2006-2010 by Kentaro Fukuchi
 * http://megaui.net/fukuchi/works/qrencode/index.en.html
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is a MediaWiki extension, and must be run from within MediaWiki.' );
}

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'QrCode',
	'version' => '0.12',
	'author' => array( 'David Raison' ), 
	'url' => 'https://www.mediawiki.org/wiki/Extension:QrCode',
	'descriptionmsg' => 'qrcode-desc'
);

$wgAutoloadClasses['QRcode'] = dirname(__FILE__) . '/phpqrcode/qrlib.php';
$wgExtensionMessagesFiles['QrCode'] = dirname(__FILE__) .'/QrCode.i18n.php';
$wgExtensionMessagesFiles['QrCodeMagic'] = dirname(__FILE__) .'/QrCode.i18n.magic.php';

$wgHooks['ParserFirstCallInit'][] = 'efQrcodeRegisterFunction';
$wgJobClasses['uploadQrCode'] = 'UploadQrCodeJob';

function efQrcodeRegisterFunction( Parser &$parser ) {
	$parser->setFunctionHook( 'qrcode', 'newQrCode' );
	return true;
}

// Defaults (overwritten by LocalSettings.php and possibly also by the function call's arguments)
$wgQrCodeECC = 'L';	// L,M,Q,H
$wgQrCodeSize = 4;	// pixel size of black squares
$wgQrCodeBoundary = 2;	// margin around qrcode
$wgQrCodeForceScheme = false;	// use protocol the author uses

// not changeable 
define('QRCODEBOT','QrCode generator');	// if a user changes this, the name won't be protected anymore
$wgReservedUsernames[] = QRCODEBOT;	// Unless we removed the var from his influence

/**
 * Create a new QrCode instance every time we need one,
 * in order to prevent data corruption and to adhere more strictly
 * to OOP patterns.
 */
function newQrCode() {
	$params = func_get_args();
	$parser = array_shift($params);	// we'll need the parser later

	// Handling "Undefined variable" notices
	$margin = $ecc = $size = $label = $scheme = false;

	foreach( $params as $pair ) {
		$firstEqual = strpos( $pair, '=' );
		$tmpKey = substr( $pair, 0, $firstEqual );
		if ( $tmpKey != 'parser' ) {	// don't let users overwrite the parser object
			$$tmpKey = substr( $pair, $firstEqual + 1 );
		}
	}

	$newQrCode = new MWQrCode( $parser, $ecc, $size, $margin, $scheme );
	return $newQrCode->showCode( $label );
}

// @todo FIXME: Move classes out of the init file.

/**
 * Class that handles QrCode generation and MW file handling.
 *
 */
class MWQrCode {
	/**
	 * @var Parser
	 */
	private $_parser;	// simply a link to the parser object

	/**
	 * @var Title
	 */
	private $_title;	// the current page's title object
	private $_label;	// contents of the qrcode
	private $_dstFileName;	// what the file will be named?
	private $_uploadComment;	// comment to be added to the upload
	private $_ecc;			// error correction
	private $_size;			// qrcode size
	private $_margin;		// qrcode margin
	private $_scheme;		// force the protocol to be http or https?

	/**
	 * Set qrcode properties
	 *
	 * @param $parser Parser
	 */
	public function __construct( $parser, $ecc = false, $size = false, $margin = false, $scheme = false ) {
		global $wgQrCodeECC, $wgQrCodeSize, $wgQrCodeBoundary, $wgQrCodeForceScheme;
		$this->_parser = $parser;
		$this->_title = $parser->getTitle();
		$this->_ecc = ( $ecc ) ? $ecc : $wgQrCodeECC;
		$this->_size = ( $size ) ? $size : $wgQrCodeSize;
		$this->_margin = ( $margin ) ? $margin : $wgQrCodeBoundary;
		$this->_scheme = ( $scheme ) ? $scheme : $wgQrCodeForceScheme;
	}

	/**
	 * Look for the requested qrcode file. If we don't have the code on file,
	 * first generate then publish it.
	 */
	public function showCode( $label = false ){
		// Check for a provided label and use the page URL as default (but force protocol if requested)
		if ( $label ) {
			$this->_label = $label;	// should we sanitize this?
			$this->_uploadComment = $label;	
		} else {
			$url = parse_url($this->_title->getFullURL());
			$url['scheme'] = ( $this->_scheme ) ? $this->_scheme : $url['scheme'];
			//$this->_label = http_build_url($url);	// http_build_url is part of pecl_http >= 0.21.0 :(
			$this->_label = $url['scheme'] . '://' 
				. $url['host'] 
				. ( ( isset($url['port']) ) ? $url['port'] : '' )
				. ( ( isset($url['path']) ) ? $url['path'] : '' )
				. ( ( isset($url['query']) ) ? '?' . $url['query'] : '' )
				. ( ( isset($url['fragment']) ) ? '#' . $url['fragment'] : '' );
			$this->_uploadComment = 'Encoded URL for '.$this->_title->getFullText();
		}

		// Use this page's title as part of the filename (Also regenerates qrcodes when the label changes).
		$this->_dstFileName = 'QR-'.md5($this->_label).'.png';
		$file = wfFindFile( $this->_dstFileName );	// Shortcut for RepoGroup::singleton()->findFile() 

		if( $file && $file->isVisible() ){
			wfDebug( "QrCode::showCode: Requested file ".$this->_dstFileName." already exists. Displaying image.\n");
			return $this->_displayImage( $file );
		} else {
			wfDebug( "QrCode::showCode: Requested file ".$this->_dstFileName." is new and needs to be generated.\n");
			$this->_generate();
			return;
		}
	}
	
	/**
	 * This only creates the wikitext to display an image.
	 *
	 * @param $file File
	 *
	 * @return wikitext for image display
	 */
	private function _displayImage( $file ){
		$ft = $file->getTitle();
		return '[['.$ft->getFullText().']]';
	}

	/**
	 * Generate the qrcode using the phpqrcode library
	 * Then queue the generation of the image in the jobqueue.
	 * @return boolean result of job insertion.
	 */
	private function _generate(){
		global $wgTmpDirectory;
		$tmpName = tempnam( $wgTmpDirectory, 'qrcode' );

		QRcode::png( $this->_label, $tmpName, $this->_ecc, $this->_size, $this->_margin );
		wfDebug( "QrCode::_generate: Generated qrcode file $tmpName containing \"".$this->_label."\" with ecc ".$this->_ecc
			.", ".$this->_size." and boundary ".$this->_margin.".\n" );

		$jobParams = array( 'tmpName' => $tmpName, 'dstName' => $this->_dstFileName, 'comment' => $this->_uploadComment );
		$job = new UploadQrCodeJob( $this->_title, $jobParams );
		if( $job->insert() ) {
			return true;
		}	
	}
}

class UploadQrCodeJob extends Job {
	public function __construct( $title, $params, $id = 0 ) {
		wfDebug("QrCodeDebug::Creating Job\n");
		$this->_dstFileName = $params['dstName'];
		$this->_tmpName = $params['tmpName'];
		$this->_uploadComment = $params['comment'];
		$this->title = $title;
		parent::__construct( 'uploadQrCode', $title, $params, $id );
	}

	/**
	 * Handle the mediawiki file upload process
	 * @return boolean status of file "upload"
	 */
	public function run() {
		global $wgOut;

		$mUpload = new UploadFromFile();
		
		wfDebug("QrCodeDebug::".$this->_dstFileName." ".$this->_tmpName."\n");
		// $mUpload->initialize( $this->_dstFileName, $this->_tmpName, null );	// pre 1.17
		$mUpload->initializePathInfo( $this->_dstFileName, $this->_tmpName, null );	// we don't know the filesize, how could we?
		wfDebug("QrCodeDebug:: Intialization finished\n");
		$pageText = 'QrCode '.$this->_dstFileName.', generated on '.date( "r" )
                        .' by the QrCode Extension for page [['.$this->title->getFullText().']].';

		wfDebug( 'QrCodeJob::run: Uploading qrcode, c: '.$this->_uploadComment . ' t: ' . $pageText."\n" );
		$status = $mUpload->performUpload( $this->_uploadComment, $pageText, false, $this->_getBot() );
		
		if ( $status->isGood() ) {
			return true;
		} else {
			$wgOut->addWikiText( $status->getWikiText() );
			return false;
		}
	}

	/**
	 * Create or select a bot user to attribute the code generation to
	 * @return user object
	 * @note there doesn't seem to be a decent method for checking if a user already exists
	 * */
	private function _getBot(){
		$bot = User::createNew( QRCODEBOT );
		if( $bot != null ){
			wfDebug( 'QrCode::_getBot: Created new user '.QRCODEBOT."\n" );
			//$bot->setPassword( '' );   // doc says empty password disables, but this triggers an exception
		} else {
			$bot = User::newFromName( QRCODEBOT );
		}   

		if( !$bot->isAllowed( 'bot' ) ) {	// User::isBot() has been deprecated
			$bot->addGroup( 'bot' );
			wfDebug( 'QrCode::_getBot: Added user '.QRCODEBOT.' to the Bot group'."\n" );
		}

		return $bot;
	 }
	
}
