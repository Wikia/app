<?php
/**
 * Extension:Livelets - Allows articles to be transcluded which load after the main page content and can update dynamically with Ajax
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Aran Dunkley, Jack Henderson
 * @licence GNU General Public Licence 2.0 or later
 * Started: 2007-10-06
 *     1.0: 2010-08-25
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

define( 'LIVELETS_VERSION', '1.1.0, 2012-01-19' );

# Settings for the event-driven live method
$wgLiveletsUseSWF = false;     # Set this to true to use SWF to make livelets fully event-driven (no polling for change)
$wgLiveletsSwfBg  = '#ffffff'; # The background colour of the embedded SWF
$wgLiveletsPort   = '1729';    # The port that Livelets.pl can be reached on (using $wgServer:$wgLiveletsPort)

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Livelets',
	'author' => '[http://www.organicdesign.co.nz/User:Nad Aran Dunkley], [http://www.organicdesign.co.nz/User:Jack Jack Henderson]',
	'descriptionmsg' => 'livelets-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Livelets',
	'version' => LIVELETS_VERSION
);

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['Livelets'] =  "$dir/Livelets.i18n.php";
$wgExtensionMessagesFiles['LiveletsMagic'] =  "$dir/Livelets.i18n.magic.php";

// @todo FIXME: Move class to a separate file.
class Livelets {

	var $container_id = 0;
	var $request_id = 0;

	function __construct() {
		global $wgHooks, $wgExtensionFunctions;

		# Call the setup method at extension setup time
		$wgExtensionFunctions[] = array( $this, 'setup' );

		# Bypass ajax dispatcher if this is a livelet ajax request
		if( array_key_exists( 'action', $_GET ) && $_GET['action'] == 'ajax' && $_GET['rs'] == 'livelets' ) {

			# Extract the data from the ajax request
			list( $title, $this->request_id ) = $_GET['rsargs'];

			# Adjust the request so that it bypasses the ajax dispatcher and executes with action=render
			$_GET = $_REQUEST = array( 'title' => $title, 'action' => 'render' );

			# Add a hook to replace the wikitext with just the requested livelet's content
			$wgHooks['ArticleAfterFetchContent'][] = $this;
		}
	}


	# Called at extension setup time
	function setup() {
		global $wgOut, $wgParser, $wgLiveletsUseSwf;

		# Activate the parser-function
		$wgParser->setFunctionHook( 'live', array( $this, 'renderContainer' ) );

		# Embed the SWF if enabled (SWF must be requested from Livelets.pl)
		if ( $wgLiveletsUseSwf ) {
			global $wgServer, $wgLiveletsPort, $wgLiveletsSwfBg;
			$swf = "$wgServer:$wgLiveletsPort/Livelets.swf";
			$wgOut->addHTML("<object type=\"application/x-shockwave-flash\" data=\"$swf\" width=\"1\" height=\"1\">
				<param name=\"movie\" value=\"$swf\" /><param name=\"bgcolor\" value=\"$wgLiveletsSwfBg\"/></object>");
		}
	}
	# Render livelet container
	function renderContainer( &$parser ) {
		global $wgTitle, $wgJsMimeType, $wgLiveletsDefaultContent;

		# Ensure the livelets are all numbered so they can be referred to by the ajax request
		$id = $this->container_id++;

		# Render a container with a 'livelet-loading' div that will be replaced
		$loading = "<div class='livelet-loading'></div>";
		$html = "<div class='livelet' id='livelet-$id'>$loading</div>";

		# Append an ajax call to collect the content for this container
		$title  = $wgTitle->getPrefixedText();
		$script = "sajax_do_call('livelets',['$title','$id'],document.getElementById('livelet-$id'))";
		$html  .= "<script type='$wgJsMimeType'>$script</script>";

		return array( $html, 'isHTML' => true, 'noparse' => true );
	}


	# This early hook called from the Ajax bypass whereby the parser has yet to process wikitext
	function onArticleAfterFetchContent( &$article, &$content ) {
		# Replace the wikitext with just the content of the requested livelet
		foreach( $this->examineBraces( $content ) as $brace ) {
			if ( $brace['NAME'] == "#live:" && --$this->request_id < 0 ) {
				$len = strlen( 'live' );
				$content = substr( $content, $brace['OFFSET'] + $len + 4, $brace['LENGTH'] - $len - 6 );
				break;
			}
		}

		return true;
	}

	# Extract recursive braces belonging to templates and parserfunctions
	function examineBraces( &$content ) {
		$braces = array();
		$depths = array();
		$depth = 1;
		$index = 0;
		while( preg_match( '/\\{\\{\\s*([#a-z0-9_]*:?)|\\}\\}/is', $content, $match, PREG_OFFSET_CAPTURE, $index ) ) {
			$index = $match[0][1] + 2;
			if( $match[0][0] == '}}' ) {
				$brace =& $braces[$depths[$depth-1]];
				$brace['LENGTH'] = $match[0][1] - $brace['OFFSET'] + 2;
				$brace['DEPTH']  = $depth--;
			} else {
				$depths[$depth++] = count( $braces );
				$braces[] = array(
					'NAME'   => $match[1][0],
					'OFFSET' => $match[0][1]
				);
			}
		}
		return $braces;
	}
}

# Instantiate a global instance of the extension
$wgLivelets = new Livelets();
