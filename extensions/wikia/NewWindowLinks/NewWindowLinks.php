<?php
/**
 * NewWindowLinks: setup.
 * 
 * Usage:
 * 
 * general: {{ #NewWindowLink: linked resource | link text }}
 * 
 * local links: {{ #NewWindowLink: Special:Version | software and installed extensions }}
 * external links: {{ #NewWindowLink: http://mediawiki.org/ | MediaWiki }}
 * interwiki links: {{ #NewWindowLink: Wikipedia:MediaWiki | Wikipedia article about MediaWiki }}
 * mailto links: {{ #NewWindowLink: mailto:john@example.com | mail John }}
 * 
 * The second parameter - link text - is optional.  If not given, the link to the resource will be used as a link text.
 * 
 * general: {{ #NewWindowLink: linked resource }}
 * 
 * local links: {{ #NewWindowLink: Special:Version }}
 * external links: {{ #NewWindowLink: http://mediawiki.org/ }}
 * interwiki links: {{ #NewWindowLink: Wikipedia:MediaWiki }}
 * mailto links: {{ #NewWindowLink: mailto:john@example.com }}
 * 
 */

/**
 * Extension credits.
 */
$wgExtensionCredits['parserhook'][] = array(
    'path'              => __FILE__,
    'name'              => 'NewWindowLinks',
    'description'       => 'Create links to be opened in a new browser window or tab.',
    'descriptionmsg'    => 'newwindowlinks-desc',
    'version'           => '1.0',
    'author'            => array( '[http://community.wikia.com/wiki/User:Mroszka Michał Roszka (Mix)]', '[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]' ),
    'url'               => 'http://www.mediawiki.org/wiki/Extension:NewWindowLinks',
);

/**
 * Extension functions 
 */

/**
 * Creates a HTML link that will open in a new browser window or tab.
 * 
 * @param object $parser Parser being used
 * @param string $target literal URI or a MediaWiki link for linked resource
 * @param string $label link text
 * @return string HTML
 */
function efParserCreateLink( $parser, $target, $label = null ) {
    // sanitise the input and set defaults
    if ( is_null( $label ) ) {
        $label = $target;
        $label = htmlspecialchars( $label, ENT_NOQUOTES, 'UTF-8' );
    } else {
        $label = preg_replace( "/\b({$parser->mUrlProtocols})/", "$1 ", $label ); // Hack to not parse external links by breaking them
        $label = $parser->recursiveTagParse( $label );
        $label = preg_replace( "/\b({$parser->mUrlProtocols}) /", "$1", $label ); // Put them back together
    }
    $attributes = array( 'target' => '_blank' );

    // WARNING: the order of the statements below does matter!
    // 
    // Also, the Parser::insertStripItem is used to render the HTML inline.
    // See: http://www.mediawiki.org/wiki/Manual:Parser_functions#Parser_interface

        // As of the 1.18.0 MW release Linker::link and Linker::makeExternalLink are static methods.
        // Prior to that release the Linker class have to be instantiated in order to use those methods.
        // See: http://trac.wikia-code.com/browser/wikia/trunk/extensions/wikia/NewWindowLinks/NewWindowLinks.class.php?rev=46348&marks=37-51#L35
        $oLinker = new Linker();

    // Process (or rule out) external targets (literal URIs)
    if ( preg_match( $parser->mExtLinkBracketedRegex, "[{$target}]" ) ) {
        return $parser->insertStripItem( $oLinker->makeExternalLink( $target, $label, false, '', $attributes ) , $parser->mStripState );
    }

    // The target is not a literal URI.  Create a Title object.
    $oTitle = Title::newFromText( $target );

    // Title::newFromText may occasionally return null, which means something is really wrong with the $target.
    if ( is_null( $oTitle ) ) {
    	return $parser->insertStripItem( wfMsg( 'newwindowlinks-invalid-target' ), $parser->mStripState );
    }

    // Process (or rule out) existing local articles.
    if ( $oTitle->exists() ) {
        return $parser->insertStripItem( $oLinker->link( $oTitle, $label, $attributes ), $parser->mStripState );
    }

    // Process (or rule out) interwiki links.
    if ( true !== $oTitle->isLocal() ) {
        return $parser->insertStripItem( $oLinker->makeExternalLink( $oTitle->getFullURL(), $label, false, '', $attributes ), $parser->mStripState );
    }

    // Only non existing local articles remain.
    return $parser->insertStripItem( $oLinker->link( $oTitle, $label, $attributes ), $parser->mStripState );
}

/**
 * Registers a new parser function.
 * 
 * @param object $parser Parser being initialised
 * @return boolean
 */
function efHookParserFirstCallInit( &$parser ) {
    // associate the "NewWindowLink" magic word with the NewWindowLinks::parserCreateLink method.
    $parser->setFunctionHook( 'NewWindowLink', 'efParserCreateLink' );
    // return true so the MediaWiki continues to load extensions.
    return true;
}

/**
 * Internationalisation: messages and magic words.
 */
$wgExtensionMessagesFiles['NewWindowLinks'] = __DIR__ . '/NewWindowLinks.i18n.php';

/**
 * Hooks.
 */
$wgHooks['ParserFirstCallInit'][]   = 'efHookParserFirstCallInit';
