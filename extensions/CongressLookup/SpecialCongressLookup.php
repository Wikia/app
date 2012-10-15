<?php
/**
 * This class creates a page which asks the user for their zip code. It then uses the zip code to
 * look up information about the user's congressional representatives and presents that information
 * to the user.
 */
class SpecialCongressLookup extends UnlistedSpecialPage {
	protected $zip = null;

	public function __construct() {
		// Register special page
		parent::__construct( 'CongressLookup' );
	}

	/**
	 * Handle different types of page requests
	 */
	public function execute( $sub ) {
		global $wgRequest, $wgOut;

		// Pull in query string parameters
		$zip = $wgRequest->getVal( 'zip' );
		if ( !is_null( $zip )) $this->setZip( $zip );
		
		// Setup
		$wgOut->disable();
		$this->sendHeaders();

		$this->buildPage();
	}

	/**
	 * Generate the HTTP response headers for the landing page
	 */
	private function sendHeaders() {
		global $wgCongressLookupSharedMaxAge, $wgCongressLookupMaxAge;
		header( "Content-type: text/html; charset=utf-8" );
		header( "Cache-Control: public, s-maxage=$wgCongressLookupSharedMaxAge, max-age=$wgCongressLookupMaxAge" );
	}
	
	/**
	 * Build the HTML for the page
	 * @return true
	 */
	private function buildPage() {
		global $wgScriptPath;
		$htmlOut = '';

		// Output beginning of the page
		$htmlOut .= <<<HTML
<!DOCTYPE html>
<html lang="en" dir="ltr" class="client-nojs">
HTML;
		$htmlOut .= $this->getHtmlHead();
		$htmlOut .= <<<HTML
<body>
<div id="everything">
<div id="instructions">

HTML;
		$htmlOut .= wfMsgExt( 'congresslookup-text', 'parse' );
		
		$htmlOut .= '</div><div id="contacts">';

		if ( $this->getZip() === false ) {
			$htmlOut .= $this->getZipForm( true );
		} elseif ( !is_null( $this->getZip() )) {
			$htmlOut .= $this->getCongressTables();
		} else {
			$htmlOut .= $this->getZipForm();
		}

		// Output end of the page
		$htmlOut .= "\n</div>\n</div>\n</body>\n</html>\n";

		echo $htmlOut;

		return true;
	}

	/**
	 * Given twitter handle, return an HTML link to the account. Make sure to use rawElement to wrap this.
	 * @param string twitter handle, assumed to be in ascii, without leading at-sign
	 * @return string HTML for the link
	 */
	private function getTwitterHtml( $handle ) {
		return Html::element( 'a', array( 'target' => '_blank', 'href' => 'http://twitter.com/#!/' . $handle ), '@' . $handle );
	}

	/**
	 * Get an HTML table of data for the user's congressional representatives
	 * @return string HTML for the table
	 */
	private function getCongressTables() {
		global $wgCongressLookupErrorPage, $wgRequest;
		
		$myRepresentatives = CongressLookupDB::getRepresentative( $this->zip );
		$mySenators = CongressLookupDB::getSenators( $this->zip );

		$congressTable = '';
		
		$congressTable .= Html::element( 'h4', array(), wfMsg( 'congresslookup-your-reps' ) );

		if ( $myRepresentatives ) {
			foreach ( $myRepresentatives as $myRepresentative ) {
				$congressTable .= "\n" . Html::openElement( 'table', array (
					'class' => 'person',
				) );
	
				$congressTable .= "\n" . Html::rawElement( 'tr', array(),
					Html::element( 'td',  array ( 'class' => 'name' ), $myRepresentative['name'] )
			   	);
	
				$congressTable .= "\n" . Html::rawElement( 'tr', array(),
					Html::element( 'td', array(), wfMsg( 'congresslookup-phone', $myRepresentative['phone'] ) )
			   	);
	
				if ( $myRepresentative['twitter'] ) {
					$congressTable .= "\n" . Html::rawElement( 'tr', array(),
						Html::rawElement( 'td', array(), wfMsg( 'congresslookup-twitter', self::getTwitterHtml( $myRepresentative['twitter'] ) ) )
					);
				}
	
				$congressTable .= "\n" . Html::rawElement( 'tr', array(),
					Html::rawElement( 'td', array(),
						Html::element( 'a', array (
							'href' => $myRepresentative['contactform'],
							'target' => '_blank',
							),
							wfMsg( 'congresslookup-contact-form' )
						)
					)
				);
	
				$congressTable .= Html::rawElement( 'tr', array(), 
				Html::rawElement( 'td', array(), $this->getSocialMedia( $myRepresentative ) ) );
				$congressTable .= "\n" . Html::closeElement( 'table' );
			}
			if ( count( $myRepresentatives ) > 1 ) {
				$congressTable .= HTML::element( 'p', array( 'class' => 'note' ), wfMsg( 'congresslookup-multiple-house-reps' ));
			}
		} else {
			$congressTable .= Html::element( 'p', array(), wfMsg( 'congresslookup-no-house-rep' ) );
		}
		foreach ( $mySenators as $senator ) {
			$congressTable .= "\n" . Html::openElement( 'table', array (
				'class' => 'person',
			) );

			$congressTable .= "\n" . Html::rawElement( 'tr', array(),
				Html::element( 'td',  array ( 'class' => 'name' ), $senator['name'] )
			);

			$congressTable .= "\n" . Html::rawElement( 'tr', array(),
				Html::element( 'td', array(), wfMsg( 'congresslookup-phone', $senator['phone'] ) )
			);

			/*
			$congressTable .= "\n" . Html::rawElement( 'tr', array(),
				Html::element( 'td', array(), wfMsg( 'congresslookup-fax', $senator['fax'] ) )
			);
			*/
			
			if ( $senator['twitter'] ) {
				$congressTable .= "\n" . Html::rawElement( 'tr', array(),
					Html::rawElement( 'td', array(), wfMsg( 'congresslookup-twitter', self::getTwitterHtml( $senator['twitter'] ) ) )
				);
			}

			$congressTable .= "\n" . Html::rawElement( 'tr', array(),
				Html::rawElement( 'td', array(),
					Html::element( 'a', array (
						'href' => $senator['contactform'],
						'target' => '_blank',
					),
					wfMsg( 'congresslookup-contact-form' )
					)
				)
			);

			$congressTable .= Html::rawElement( 'tr', array(), 
				Html::rawElement( 'td', array(), $this->getSocialMedia( $senator ) ) );
			$congressTable .= "\n" . Html::closeElement( 'table' );
		}
		if ( count( $mySenators ) == 0 ) {
			$congressTable .= Html::element( 'p', array(), wfMsg( 'congresslookup-no-senators' ) );
		}
		
		$errorPage = SpecialPage::getTitleFor( $wgCongressLookupErrorPage );
		$errorUrl = $errorPage->getLocalURL( array( 'zip' => $wgRequest->getVal( 'zip' ) ) );

		$congressTable .= Html::openElement( 'p' );
		$congressTable .= Html::element( 
			'a', 
			array ( 'href' => $errorUrl ),
			wfMsg( 'congresslookup-report-errors' ) 
		);
		$congressTable .= Html::closeElement( 'p' );
		
		return $congressTable;
	}
	
	/**
	 * Get HTML for a Zip Code form
	 * @return string HTML
	 */
	private function getZipForm( $isError=false ) {
		$htmlOut = <<<HTML
<div id="sopaZipForm" class="sopaActionDiv">
HTML;
		$htmlOut .= Html::element( 'h4', array(), wfMsg( 'congresslookup-contact-your-reps' ));
		if ( $isError ) {
			$htmlOut .= Html::element( 'p', array( 'class' => 'error' ), wfMsg( 'congresslookup-zipcode-error' ));
		}
		$htmlOut .= Html::openElement( 'form', array(
			'action' => wfScript(),
			'method' => 'get',
		) );
		$htmlOut .= Html::hidden( 'title', $this->getTitle()->getPrefixedText() );
		$htmlOut .= <<<HTML
		<label for="zip">Your zip code:</label>
		<input type="text" maxlength="10" size="5" name="zip" id="zip"/>
		<input type="submit" value="Look up" name="submit"/>
	</form>
</div>
HTML;
		return $htmlOut;
	}
	
	/**
	 * Get HTML for social media links
	 * @return string HTML for social media links
	 */
	private function getSocialMedia( $senator ) {
		// Update links here. Currently pointing to example.com
		$shareOptions = array(
			array(
				"url" =>  "https://www.facebook.com/sharer.php?u=http://tinyurl.com/7vq4o8g&t=$1",
				"img" => "//upload.wikimedia.org/wikipedia/commons/2/2a/WP_SOPA_sm_icon_facebook_dedede.png",
				"name" => "Facebook"
			),
			array(
				"url" => "https://plus.google.com/share?url=https://wikimediafoundation.org/wiki/SOPA/Blackoutpage",
				"img" => "//upload.wikimedia.org/wikipedia/commons/0/08/WP_SOPA_sm_icon_gplus_dedede.png",
				"name" => "Google+"
			),
			array(
				"url" => "https://twitter.com/intent/tweet?text=$1",
				"img" => "//upload.wikimedia.org/wikipedia/foundation/4/45/WP_SOPA_sm_icon_twitter_dedede.png",
				"name" => "Twitter"
			)
		);	

		$htmlShare = '';
		foreach( $shareOptions as $option ) {
			$htmlShare .= Html::rawElement( 'div',
				array(
					'class' => 'sopaSocial'
				),
				Html::rawElement( 'a',
					array(
						'href' => str_replace( '$1', $this->formatDoneText( $senator ), $option['url'] ),
						'style' => 'text-decoration: none'
					),
					Html::rawElement( 'img',
						array(
							'src' => $option['img'],
							'height' => '33',
							'width' => '33',
							'border' => '0',
						),
						''
					) 
				) .
				Html::rawElement( 'br' ) .
				Html::rawElement( 'a',
					array(
						'href' => $option['url'],
						'style' => 'text-decoration: none'
					),
					$option['name']
				)
			);
		}
		$htmlOut = Html::rawElement( 'div',
			array( 
				'id' => 'sopaShareOptions',
				'class' => 'sopaActionDiv'
			),
				Html::rawElement( 'p',
					array(), 'Done? Tell the world!'
				) . 
				Html::rawElement( 'div', 
					array(),
					$htmlShare) .
				Html::rawElement( 'div',
					array(
						'style' => 'clear: both;'
					), ''
				) . 
				Html::rawElement( 'hr' )
			);

		return $htmlOut;
	}
	
	private function formatDoneText( $rep ) {
		$name = trim( preg_replace( '/\[.*\]/', '', $rep['name'] ) );
		return urlencode( "I just contacted $name to oppose #SOPA/#PIPA - Join me! http://tinyurl.com/7vq4o8g #wikipediablackout" );
	}	
	/**
	 * Setter for $this->zip
	 * 
	 * In the event that $zip is invalid, set the value of $this->zip to false.
	 * @param $zip
	 */
	public function setZip( $zip ) {
		if ( !$this->isValidZip( $zip )) {
			$this->zip = false;
		} else { 		
			$this->zip = $zip;
		}
	}
	
	public function getZip() {
		return $this->zip;
	}
	
	/**
	 * Make sure the zip code entered was valid-ish
	 * @param $zip
	 * @return bool
	 */
	public function isValidZip( $zip ) {
		$zipPieces = explode( '-', $zip, 2 );
		
		if ( strlen( $zipPieces[0] ) != 5 || !is_numeric( $zipPieces[0] )) {
			return false;
		}
		
		if ( isset( $zipPieces[1] )) {
			if ( strlen( $zipPieces[1] ) != 4 || !is_numeric( $zipPieces[1] )) {
				return false;
			}
		}
		
		return true;
	}
	
	public function getHtmlHead() {
		global $wgCongressLookupBlackOnWhite;
		
		if ( $wgCongressLookupBlackOnWhite ) {
			$html_head = <<<HTML
<head>
<title>Wikipedia, the free encyclopedia</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="generator" content="MediaWiki 1.18wmf1" />
<style type="text/css">
body {
	/*color: #dedede;*/
	color: #343434;
	margin: 2em;
	font-family:Times New Roman;
	background: white url('//upload.wikimedia.org/wikipedia/commons/0/03/POSTSOPA_Landing_W-2.jpg')  no-repeat 0 130px; 
}
h3{
    font-size: 1.5em;
    text-align:center;
    margin-bottom: 0.5em;
    /*color: #ffffff;*/
    color: #000000;
    font-weight: bold;
}

h4 { 
  font-weight: bold;
  /*color: #ffffff;*/
  color: #000000;
}
a:link, a:visited {
	/*color: #dedede;*/
	color: #343434;
}
a:hover, a:active {
	/*color: #ffffff;*/
	color: #000000;
}
div#everything {
	width: 920px;
	margin: 0 auto;
}
div#instructions {
	position: absolute;
	top: 47px;
	left: 460px;
	text-align: left;
	width: 500px;
	padding: 20px;
	background-color: #ffffff;
	filter:alpha(opacity=90);
	-moz-opacity:0.90;
	-khtml-opacity: 0.90;
	opacity: 0.90;
}
div#instructions p {
  text-align:justify;
}
div#contacts {
	position: absolute;
	top: 50px;
	left: 80px;
	width: 320px;
	background-color: #161616;
	padding: 5px 20px 20px 20px;
	filter:alpha(opacity=90);
	-moz-opacity:0.90;
	-khtml-opacity: 0.90;
	opacity: 0.90;
	color: #ffffff;
}
div#contacts h4 {
	color: #ffffff;
}
div#contacts form {
	margin-bottom: 1em;
}
div#contacts a:link, div#contacts a:visited {
	color: #dedede;
}
div#contacts a:hover, div#contacts a:active {
	color: #ffffff;
}
table.person {
	margin-bottom: 1em;
	margin-left: 20px;
	border: none;
}
table.person td.name {
	font-weight: bold;
}
p {
	margin: 1em 0;
}
p.quote {
	font-family: georgia, serif;
	font-size: 14px;
	color: #cccccc;
	margin-left: 20px;
}
p.note {
	margin-top: 0;
}
h3 {
	font-weight: normal;
	font-size: 20px;
}
h4 {
	font-weight: normal;
	font-size: 17px;
}
.sopaBigHeadline {
  font-size: 1.5em;
  margin-bottom: 0.5em;
}
.sopaSectionHeadline {
  font-size: 1.2em;
  margin-bottom: 0.2em;
}
.sopaSocial {
  float: left;
  text-align: center;
  margin-right: 12px;
  margin-bttom: 3px;
  font-size: small;
}
.sopaActionHead {
  font-weight: bold
}
</style>
</head>
HTML;
		} else {
			$html_head = <<<HTML
<head>
<title>Wikipedia, the free encyclopedia</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="generator" content="MediaWiki 1.18wmf1" />
<style type="text/css">
body {
	color: #dedede;
	margin: 2em;
	font-family:Times New Roman;
	background: black url('//upload.wikimedia.org/wikipedia/commons/9/98/WP_SOPA_Splash_Full.jpg') no-repeat 0 130px;
}
h3{
    font-size: 1.5em;
    text-align:center;
    margin-bottom: 0.5em;
    color: #ffffff;
    font-weight: bold;
}

h4 { 
  font-weight: bold;
  color: #ffffff;
}
a:link, a:visited {
	color: #dedede;
}
a:hover, a:active {
	color: #ffffff;
}
div#everything {
	width: 920px;
	margin: 0 auto;
}
div#instructions {
	position: absolute;
	top: 47px;
	left: 460px;
	text-align: left;
	width: 500px;
	padding: 20px;
}
div#instructions p {
  text-align:justify;
}
div#contacts {
	position: absolute;
	top: 50px;
	left: 80px;
	width: 320px;
	background-color: #161616;
	padding: 5px 20px 20px 20px;
	filter:alpha(opacity=90);
	-moz-opacity:0.90;
	-khtml-opacity: 0.90;
	opacity: 0.90;
}
div#contacts form {
	margin-bottom: 1em;
}
table.person {
	margin-bottom: 1em;
	margin-left: 20px;
	border: none;
}
table.person td.name {
	font-weight: bold;
}
p {
	margin: 1em 0;
}
p.quote {
	font-family: georgia, serif;
	font-size: 14px;
	color: #cccccc;
	margin-left: 20px;
}
p.note {
	margin-top: 0;
}
h3 {
	font-weight: normal;
	font-size: 20px;
}
h4 {
	font-weight: normal;
	font-size: 17px;
}
.sopaBigHeadline {
  font-size: 1.5em;
  margin-bottom: 0.5em;
}
.sopaSectionHeadline {
  font-size: 1.2em;
  margin-bottom: 0.2em;
}
.sopaSocial {
  float: left;
  text-align: center;
  margin-right: 12px;
  margin-bttom: 3px;
  font-size: small;
}
.sopaActionHead {
  font-weight: bold
}
</style>
</head>
HTML;
		}
		
		return $html_head;
	}
}
