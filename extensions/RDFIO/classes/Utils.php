<?php

class RDFIOUtils {
    /**
     * Checks if $uri is an URI Resolver URI (i.e. an URI used by SMW to identify wiki pages)
     * @param string $uri
     * @return boolean $isURIResolverURI
     */
    static function isURIResolverURI( $uri ) {
        $isURIResolverURI = ( preg_match( '/Special:URIResolver/', $uri, $matches ) > 0 );
        return $isURIResolverURI;
    }

    /**
     * Checks if $uri is an ARC untitled identifier
     * @param string $uri
     * @return boolean $isArcUntitledNode
     */
    static function isArcUntitledNode( $uri ) {
        $isArcUntitledNode1 = ( preg_match( '/^Arc/', $uri, $matches ) > 0 );
        $isArcUntitledNode2 = ( preg_match( '/_:arc/', $uri, $matches ) > 0 );
        $isArcUntitledNode = ( $isArcUntitledNode1 || $isArcUntitledNode2 );
        return $isArcUntitledNode;
    }

    /**
     * Checks if a string is a URL (i.e., starts with 'http:')
     * @param $text
     * @return boolean $isURL
     */
    static function isURL( $text ) {
        $isURL = ( preg_match( '/^http(s)?:/', $text, $matches ) > 0 );
        return $isURL;
    }

    /**
     * Extracts the "label", or "local part" of an URI, i.e. it removes
     * its namespace, or base URI
     * @param string $uri
     * @return string
     */
    static function extractLabelFromURI( $uri ) {
        $uriparts = RDFIOUtils::splitURI( $uri );
        $basepart = $uriparts[0];
        $localpart = $uriparts[1];
        if ( $localpart[1] != '' ) {
            return $localpart;
        } else {
            return $basepart;
        }
    }

    /**
     * Customized version of the splitURI($uri) of the ARC2 library (http://arc.semsol.org)
     * Splits a URI into its base part and local part, and returns them as an
     * array of two strings
     * @param string $uri
     * @return array
     */
    static function splitURI( $uri ) {
        global $rdfiogBaseURIs;
        /* ADAPTED FROM ARC2 WITH SOME MODIFICATIONS
         * the following namespaces may lead to conflated URIs,
         * we have to set the split position manually
         */
        if ( strpos( $uri, 'www.w3.org' ) ) {
            $specials = array(
        'http://www.w3.org/XML/1998/namespace',
        'http://www.w3.org/2005/Atom',
        'http://www.w3.org/1999/xhtml',
            );
            if ( $rdfiogBaseURIs != '' ) {
                $specials = array_merge( $specials, $rdfiogBaseURIs );
            }
            foreach ( $specials as $ns ) {
                if ( strpos( $uri, $ns ) === 0 ) {
                    $local_part = substr( $uri, strlen( $ns ) );
                    if ( !preg_match( '/^[\/\#]/', $local_part ) ) {
                        return array( $ns, $local_part );
                    }
                }
            }
        }
        /* auto-splitting on / or # */
        // $re = '^(.*?)([A-Z_a-z][-A-Z_a-z0-9.]*)$';
        if ( preg_match( '/^(.*[\#])([^\#]+)$/', $uri, $matches ) ) {
            return array( $matches[1], $matches[2] );
        }
        if ( preg_match( '/^(.*[\:])([^\:\/]+)$/', $uri, $matches ) ) {
            return array( $matches[1], $matches[2] );
        }
        if ( preg_match( '/^(.*[\/])([^\/]+)$/', $uri, $matches ) ) {
            return array( $matches[1], $matches[2] );
        }        /* auto-splitting on last special char, e.g. urn:foo:bar */
        return array( $uri, '' );

    }

    static function contains( $word, $subject ) {
        $contains = preg_match( "/$word/i", $subject ) > 0;
        return $contains;
    }

    /**
     * Prints out the structure of an array enclosed in <pre> tags. Used for debugging
     * @param array $arrayToShow
     * @param string $title
     */
    static function showArray( $arrayToShow, $title ) {
        echo "<h2>$title</h2><pre style=\"font-size: 12px; font-weight: bold;\">";
        print_r( $arrayToShow );
        echo "</pre>";
    }

    static function showErrorMessage( $title, $message ) {
        global $wgOut;
        $errorhtml = RDFIOUtils::formatErrorHTML( $title, $message );
        $wgOut->addHTML( $errorhtml );
    }

    /**
     * Format an error message with HTML, based on a message title and the message
     * @param string $title
     * @param string $message
     * @return string $errorhtml
     */
    static function formatErrorHTML( $title, $message ) {
        $errorhtml = '<div style="margin: .4em 0; padding: .4em .7em; border: 1px solid #D8000C; background-color: #FFBABA;">
                	 <h3>' . $title . '</h3>
                	 <p>' . $message . '</p>
                	 </div>';
        return $errorhtml;
    }

    /**
     * Extract everything between <body> and </body> in a string
     * @param string $html
     * @return string $html
     */
    static function extractHTMLBodyContent( $html ) {
        $foundmatch = preg_match( '#<body[^\>]*>(.*?)</body>#Us', $html, $match );
        if ( $foundmatch ) {
            $html = $match[1];
        }
        // Convert any table to sortable wiki table
        return $html;
    }

    /**
     * Add css class attributes which make tables styled and sortable inside the wiki
     * @param string $html
     * @return string $html
     */
    static function wikifyTables( $html ) {
        $html = preg_replace( '#<table[^\>]*?>#U', '<table class="wikitable sortable">', $html );
        return $html;
    }

    /**
     * Extract URIs from a string
     * @param string $text
     * @return $array $uris
     */
    static function extractURIs( $text ) {
        $uris = array();
        preg_match_all( '/http:[^\s<>"]+/', $text, $uris );
        return $uris[0];
    }

    /**
     * Convert to character identifiers used to make URLs XML compliant
     * @param string $text
     * @return string $text
     */
    static function xmlifyUris( $text ) { // TODO Used anywhere?
        $text = str_replace( '#', '-23', $text );
        $text = str_replace( ':', '-3A', $text );
        $text = str_replace( '?', '-3F', $text );
        $text = str_replace( ' ', '-20', $text );
        return $text;
    }

    /**
     * Convert back character identifiers used to make URLs XML compliant
     * @param string $text
     * @return string $text
     */
    static function unXmlifyUris( $text ) { // TODO Used anywhere?
        $text = str_replace( '-23', '#', $text );
        $text = str_replace( '-3A', ':', $text );
        $text = str_replace( '-3F', '?', $text );
        $text = str_replace( '-2D', '-', $text );
        $text = str_replace( '-20', ' ', $text );
        $text = str_replace( '-3D', '=', $text );
        return $text;
    }

    /**
     * @param string $text
     * @return string $text
     */
    static function skipUnallowedCharsInURLsInValue( $text ) { // TODO Used anywhere?
        $text = str_replace( ' ', '', $text );
        $text = str_replace( '#', '-23', $text );
        $text = str_replace( '_', '-20', $text );
        return $text;
    }

    /**
     * @param string $text
     * @return string $text
     */
    static function restoreUnallowedCharsInValue( $text ) { // TODO Used anywhere?
        $text = str_replace( '-23', '#', $text );
        $text = str_replace( '-20', '_', $text );
        return $text;
    }

    /**
     * Remove characters which don't work in wiki titles
     * @param string $uri
     * @return string $title
     */
    static function sanitizeWikiTitle( $title ) {
        # $uri = SMWExporter::encodeURI( $uri );
        // Optimally we should rely on SMWExporter::encodeURI
        // but seems we cannot. TODO: Think through if this is true
        $title = str_replace( '#', '-23', $title );
        $title = str_replace( '[', '', $title );
        $title = str_replace( ']', '', $title );
        # $title = preg_replace( '/[\[\]]/', '', $title );
        return $title;
    }

    /**
     * Remove characters which don't work in smw values
     * @param string $value
     * @return string $value
     */
    static function sanitizeSMWValue( $value ) {
        # $uri = SMWExporter::encodeURI( $uri );
        // Optimally we should rely on SMWExporter::encodeURI
        // but seems we cannot. TODO: Think through if this is true
        $value = str_replace( '[', '', $value );
        $value = str_replace( ']', '', $value );
        return $value;
    }
}
