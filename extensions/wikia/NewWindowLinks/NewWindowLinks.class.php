<?php
/**
 * NewWindowLinks: the main class.
 */
class NewWindowLinks {
    /**
     * Registers a new parser function.
     * 
     * @param object $parser Parser being initialised
     * @return boolean
     */
    static public function hookParserFirstCallInit( &$parser ) {
        // associate the "NewWindowLink" magic word with the NewWindowLinks::parserCreateLink method.
        $parser->setFunctionHook( 'NewWindowLink', 'NewWindowLinks::parserCreateLink' );
        // return true so the MediaWiki continues to load extensions.
        return true;
    }
    /**
     * Creates a HTML link that will open in a new browser window or tab.
     * 
     * @param object $parser Parser being used
     * @param string $target literal URI or a MediaWiki link for linked resource
     * @param string $label link text
     * @return string HTML
     */
    static public function parserCreateLink( $parser, $target, $label = null ) {
        // sanitise the input and set defaults
        if ( is_null( $label ) ) { $label = $target; }
        $label = htmlspecialchars( $label, ENT_NOQUOTES, 'UTF-8' );
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
            return $parser->insertStripItem( $oLinker->makeExternalLink( $target, $label, true, '', $attributes ) , $parser->mStripState );
        }
        
        // The target is not a literal URI.  Create a Title object.
        $oTitle = Title::newFromText( $target );
        
        // Process (or rule out) existing local articles.
        if ( $oTitle->exists() ) {
            return $parser->insertStripItem( $oLinker->link( $oTitle, $label, $attributes ), $parser->mStripState );
        }
        
        // Process (or rule out) interwiki links.
        if ( true !== $oTitle->isLocal() ) {
            return $parser->insertStripItem( $oLinker->makeExternalLink( $oTitle->getFullURL(), $label, true, '', $attributes ), $parser->mStripState );
        }
        
        // Only non existing local articles remain.
        return $parser->insertStripItem( $oLinker->link( $oTitle, $label, $attributes ), $parser->mStripState );
    }
}
