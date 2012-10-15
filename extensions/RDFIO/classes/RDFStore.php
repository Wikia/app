<?php

/**
 * RDFIOStore contains utility functionality that requires connecting to the
 * ARC based RDF store
 * @author samuel.lampa@gmail.com
 * @package RDFIO
 */
class RDFIOStore {
    protected $m_store;

    function __construct() {
        global $smwgARC2StoreConfig;
        $this->m_arcstore = ARC2::getStore( $smwgARC2StoreConfig );
    }

    /**
     * Get SMWs internal URI for the "Original URI" property used by RDFIO
     * @return string
     */
    function getOrigURIURI() {
        return $this->getURIResolverURI() . 'Property-3AOriginal_URI';
    }

    /**
     * Get SMWs internal URI for corresponding to the "Equivalent URI" property
     * @return string
     */
    function getEquivURIURI() {
        return 'http://www.w3.org/2002/07/owl#sameAs';
    }

    /**
     * Get SMWs internal URI for corresponding to the "Equivalent URI" property,
     * for property pages
     * @return string
     */
    function getEquivURIURIForProperty() {
        return 'http://www.w3.org/2002/07/owl#equivalentProperty';
    }

    /**
     * For a given RDF URI, return it's original URI, as defined in wiki articles
     * by the "Original URI" property
     * @param string $uri
     * @return string $origuri
     */
    function getOrigURIForUri( $uri ) {
        $origuri = '';
        $store = $this->m_arcstore;
        $origuriuri = $this->getOrigURIURI();
        $q = "SELECT ?origuri WHERE { <$uri> <$origuriuri> ?origuri }";
        $rs = $store->query( $q );
        if ( !$store->getErrors() ) {
            $rows = $rs['result']['rows'];
            // @todo FIXME: Handle this case more nicely
            if (count($rows) == 0) {
	            die( "No rows returned" );
            }
            $row = $rows[0];
            $origuri = $row['origuri'];
        } else {
            die( "Error in ARC Store: " . print_r( $store->getErrors(), true ) );
        }
        return $origuri;
    }

    /**
     * For a given RDF URI, return it's corresponding equivalend URIs
     * as defined in wiki articles by the Equivalent URI property
     * @param string $uri
     * @param boolean $is_property
     * @return array $equivuris
     */
    function getEquivURIsForURI( $uri, $is_property = false ) {
        $equivuris = array();
        $store = $this->m_arcstore;
        if ( $is_property ) {
            $equivuriuri = $this->getEquivURIURIForProperty();
        } else {
            $equivuriuri = $this->getEquivURIURI();
        }
        $q = "SELECT ?equivuri WHERE { <$uri> <$equivuriuri> ?equivuri }";
        $rs = $store->query( $q );
        if ( !$store->getErrors() ) {
            $equivuris = $rs['result']['rows'];
            foreach ( $equivuris as $equivuriid => $equivuri ) {
                $equivuris[$equivuriid] = $equivuri['equivuri'];
            }
        } else {
            die( "Error in ARC Store: " . print_r( $store->getErrors(), true ) );
        }
        return $equivuris;
    }

    /**
     * @param string $ouri
     * @return string $uri
     */
    function getURIForOrigURI( $origuri ) {
        $uri = '';
        $store = $this->m_arcstore;
        $origuriuri = $this->getOrigURIURI();
        $q = "SELECT ?uri WHERE { ?uri <$origuriuri> <$origuri> }";
        $rs = $store->query( $q );
        if ( !$store->getErrors() ) {
            if ( $rs !== '' ) {
                $rows = $rs['result']['rows'];
                $row = $rows[0];
                $uri = $row['uri'];
            }
        } else {
            die( "Error in ARC Store: " . print_r( $store->getErrors(), true ) );
        }
        return $uri;
    }

    /**
     * Given an Equivalent URI (ast defined in a wiki article, return the URI used by SMW
     * @param string $equivuri
     * @return string $uri
     */
    function getURIForEquivURI( $equivuri ) {
        $uri = '';
        $store = $this->m_arcstore;
        $equivuriuri = $this->getEquivURIURI();
        $q = "SELECT ?uri WHERE { ?uri <$equivuriuri> <$equivuri> }";
        $rs = $store->query( $q );
        if ( !$store->getErrors() ) {
            $rows = $rs['result']['rows'];
            $row = $rows[0];
            $uri = $row['uri'];
        } else {
            die( "Error in ARC Store: " . print_r( $store->getErrors(), true ) );
        }
        return $uri;
    }

    /**
     * Get the base URI used by SMW to identify wiki articles
     * @return string $uriresolveruri
     */
    function getURIResolverURI() {
        $resolver = SpecialPage::getTitleFor( 'URIResolver' );
        $uriresolveruri = $resolver->getFullURL() . '/';
        return $uriresolveruri;
    }

    /**
     * For a URI that is defined using the "Original URI" property, return the wiki
     * article corresponding to that entity
     * @param string $uri
     * @return string $wikititle;
     */
    function getWikiTitleByOriginalURI( $uri ) {
        $wikititleresolveruri = $this->getURIForOrigURI( $uri );
        $resolveruri = $this->getURIResolverURI();
        $wikititle = str_replace( $resolveruri, '', $wikititleresolveruri );
        $wikititle = str_replace( 'Property-3A', '', $wikititle );
        $wikititle = str_replace( 'Property:', '', $wikititle );
        $wikititle = RDFIOUtils::unXmlifyUris( $wikititle );
        return $wikititle;
    }
}
