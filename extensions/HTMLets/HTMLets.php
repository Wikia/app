<?php
/**
 * HTMLets extension - lets you inline HTML snippets from files in a given directory.
 *
 * Usage: on a wiki page, &lt;htmlet&gt;foobar&lt;/htmlet%gt; will inline the contents (HTML) of the 
 * file <tt>foobar.html</tt> from the htmlets directory. The htmlets directory can be
 * configured using <tt>$wgHTMLetsDirectory</tt>; it defaults to $IP/htmlets, i.e. the
 * directory <tt>htmlets</tt> in the installation root of MediaWiki. 
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @license GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['parserhook'][] = array( 
	'name'           => 'HTMLets', 
	'author'         => 'Daniel Kinzler', 
	'url'            => 'http://mediawiki.org/wiki/Extension:HTMLets',
	'svn-date' => '$LastChangedDate: 2008-05-06 13:59:58 +0200 (wto, 06 maj 2008) $',
	'svn-revision' => '$LastChangedRevision: 34306 $',
	'description'    => 'lets you inline HTML snippets from files',
	'descriptionmsg' => 'htmlets-desc',
);
$wgExtensionMessagesFiles['HTMLets'] =  dirname(__FILE__) . '/HTMLets.i18n.php';

/**
* Pass file content unchanged. May get mangeled by late server pass.
**/
define('HTMLETS_NO_HACK', 'none');

/**
* Normalize whitespace, apply special stripping and escaping to avoid mangeling.
* This will break pre-formated text (pre tags), and may interfere with JavaScript
* code under some circumstances.
**/
define('HTMLETS_STRIP_HACK', 'strip');

/**
* bypass late parser pass using ParserAfterTidy. 
* This will get the file content safely into the final HTML.
* There's no obvious trouble with it, but it just might interfere with other extensions.
**/
define('HTMLETS_BYPASS_HACK', 'bypass');

$wgHTMLetsHack = HTMLETS_BYPASS_HACK; #hack to use to work around bug #8997. see constant declarations.

# This is set by WikiFactory earlier
#$wgHTMLetsDirectory = NULL;

$wgExtensionFunctions[] = "wfHTMLetsExtension";

function wfHTMLetsExtension() {
    global $wgParser;
    $wgParser->setHook( "htmlet", "wfRenderHTMLet" );
}

# The callback function for converting the input text to HTML output
function wfRenderHTMLet( $name, $argv, &$parser ) {
    global $wgHTMLetsDirectory, $wgHTMLetsHack, $IP;

    if (@$argv['nocache']) $parser->disableCache();

    #HACKs for bug 8997
    $hack = @$argv['hack'];
    if ( $hack == 'strip' ) $hack = HTMLETS_STRIP_HACK;
    else if ( $hack == 'bypass' ) $hack = HTMLETS_BYPASS_HACK;
    else if ( $hack == 'none' || $hack == 'no' ) $hack = HTMLETS_NO_HACK;
    else $hack = $wgHTMLetsHack;

    $dir = $wgHTMLetsDirectory;
    if (!$dir) $dir = "$IP/htmlets";

    $name = preg_replace('@[\\\\/!]|^\.+?&#@', '', $name); #strip path separators and leading dots.
    $name .= '.html'; #append html ending, for added security and conveniance

    $f = "$dir/$name";

    if (!preg_match('!^\w+://!', $dir) && !file_exists($f)) {
        $output = '<div class="error">Can\'t find html file '.htmlspecialchars($name).'</div>';
    }
    else {
        $output = file_get_contents($f);
        if ($output === false) $output = '<div class="error">Failed to load html file '.htmlspecialchars($name).'</div>';
    }

    #HACKs for bug 8997
    if ( $hack == HTMLETS_STRIP_HACK ) {
        $output = trim( preg_replace( '![\r\n\t ]+!', ' ', $output ) ); //normalize whitespace
        $output = preg_replace( '!(.) *:!', '\1:', $output ); //strip blanks before colons

        if ( strlen($output) > 0 ) { //escape first char if it may trigger wiki formatting
            $ch = substr( $output, 0, 1);

            if ( $ch == '#' ) $output = '&#35;' . substr( $output, 1);
            else if ( $ch == '*' ) $output = '&#42;' . substr( $output, 1);
            else if ( $ch == ':' ) $output = '&#58;' . substr( $output, 1);
            else if ( $ch == ';' ) $output = '&#59;' . substr( $output, 1);
        }
    }
    else if ( $hack == HTMLETS_BYPASS_HACK ) {
        global $wgHooks;

        if ( !isset($wgHooks['ParserAfterTidy']) || !in_array('wfRenderHTMLetHackPostProcess', $wgHooks['ParserAfterTidy']) ) {
            $wgHooks['ParserAfterTidy'][] = 'wfRenderHTMLetHackPostProcess';
        }

        $output = '<!-- @HTMLetsHACK@ '.base64_encode($output).' @HTMLetsHACK@ -->';
    }

    return $output;
}

function wfRenderHTMLetHackPostProcess( &$parser, &$text ) {
   $text = preg_replace(
        '/<!-- @HTMLetsHACK@ ([0-9a-zA-Z\\+\\/]+=*) @HTMLetsHACK@ -->/esm',
        'base64_decode("$1")',
        $text
   ); 

   return true;
}

