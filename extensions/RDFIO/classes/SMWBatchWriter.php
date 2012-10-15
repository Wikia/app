<?php

/**
 * RDFIOSMWBatchWriter can take data in different formats (RDF/XML, SPARQL query
 * structure etc) and perform write operations on the resulting wiki articles by
 * calling SMWWriter
 * @author samuel.lampa@gmail.com
 * @package RDFIO
 */
class RDFIOSMWBatchWriter {
    protected $m_delete;
    protected $m_unparseddata;
    protected $m_dataformat;
    protected $m_parser;
    protected $m_triples;
    protected $m_tripleindex;
    protected $m_tripleindexflat;
    protected $m_nsprefixes;
    protected $m_importedtriples;
    protected $m_pages;
    protected $m_errors;
    protected $m_haserrors;
    // Previously in Equiv URI Class
    protected $m_wikititlepropertyuris;
    protected $m_usenspintitles_properties = false;
    protected $m_usenspintitles_entities = false;
    protected $m_store;

    function __construct( $importdata, $dataformat ) {
        global $rdfiogExtraNSPrefixes,
        $rdfiogPropertiesToUseAsWikiTitle,
        $rdfiogUseNSPrefixInWikiTitleForProperties,
        $rdfiogUseNSPrefixInWikiTitleForEntities;

        if ( $dataformat == 'triples_array' ) {
            $this->m_triples = $importdata;
        } else {
            $this->m_unparseddata = $importdata;
        }
        $this->m_dataformat = $dataformat;
        $this->m_haserrors = false;
        $this->m_delete = false;
        if ( $this->m_dataformat == 'rdfxml' ) {
            $this->m_unparseddata = $this->cleanupXML( $this->m_unparseddata );
            $this->m_parser = ARC2::getRDFXMLParser();
            $this->parse();
        } elseif ( $this->m_dataformat == 'turtle' ) {
            $this->m_unparseddata = $wgRequest->getText( 'importdata' );
            $this->m_parser = ARC2::getTurtleParser();
            $this->parse();
        }
        $this->extractTripleIndex();
        $this->m_nsprefixes = $this->getNSPrefixMappingFromParser();
        if ( $rdfiogExtraNSPrefixes != '' ) {
            $this->addNamespacePrefixes( $rdfiogExtraNSPrefixes );
        }
        $nsprefixes = $this->m_nsprefixes;
        $this->setNSPrefixes( $nsprefixes );
        $this->setTripleIndex( $this->m_tripleindex );

        // Previously in Equiv URI Class

        if ( isset($rdfiogUsePseudoNamespacesForProperties) ) { // TODO: Change to check options from import screen
            // use parameter set in LocalSettings.php
            $this->m_usenspintitles_properties = $rdfiogUsePseudoNamespacesForProperties;
        }

        if ( isset($rdfiogUsePseudoNamespacesForEntities) ) {
            // use parameter set in LocalSettings.php
            $this->m_usenspintitles_entities = $rdfiogUsePseudoNamespacesForEntities;
        }

        if ( !empty( $rdfiogPropertiesToUseAsWikiTitle ) ) {
            $this->m_wikititlepropertyuris = $rdfiogPropertiesToUseAsWikiTitle;
        } else {
            $this->m_wikititlepropertyuris = array(
            	'http://semantic-mediawiki.org/swivt/1.0#page', // Suggestion for new property
            	'http://www.w3.org/2000/01/rdf-schema#label',
            	'http://purl.org/dc/elements/1.1/title',
            	'http://www.w3.org/2004/02/skos/core#preferredLabel',
            	'http://xmlns.com/foaf/0.1/name'
            	);
        }

        $this->m_store = new RDFIOStore();
    }

    /**
     * Execute Import of data sent to RDFImporter object upon creation.
     */
    public function execute() {
        $this->preparePageHandlers();
        if ( $this->m_delete ) {
            $this->deletePageDataFromWiki();
        } else {
            $this->writePagesToWiki();
        }
    }

    /**
     * Check for namespaces lacking a prefix ("abbreviation"), in the
     * current namespace prefix configuration
     */
    public function checkForNamespacesWithoutPrefix() {
        $nsprefixes = $this->getNSPrefixMapping();
        $existunabbreviatedpropertyuris = in_array( false, $nsprefixes );
        return $existunabbreviatedpropertyuris;
    }

    /**
     * Get namespaces lacking a prefix, from the current namespace
     * configuration
     * @return array $nsswithoutprefix
     */
    public function getNamespacesWithoutPrefix() {
        $nsprefixes = $this->m_nsprefixes;
        $nsswithoutprefix = array();
        foreach ( $nsprefixes as $namespace => $abbreviation ) {
            if ( $abbreviation == false ) {
                $nsswithoutprefix[] = $namespace;
            }
        }
        return $nsswithoutprefix;
    }

    /**
     * Get URIs for entities (non-properties) which are not abbreviated
     * by a namespace prefix
     */
    public function getUnabbrEntityURIs() {
        $subjecturis = $this->getUniqueSubjectURIs();
        $valueuris = $this->getUniqueValueURIs();
        $entityuris = array_merge( $subjecturis, $valueuris );
        $entityuris = array_unique( $entityuris );
        $unabbreviateduris = array();
        foreach ( $entityuris as $entityuri ) {
            $titlebypropertyuriindex = '';
            $titlebypropertyuriindex = $this->getWikiTitleByPropertyURIIndex( $entityuri );
            if ( $titlebypropertyuriindex == '' ) {
                $nsprefixes = $this->m_nsprefixes;
                $uricontainsns = false;
                foreach ( $nsprefixes as $ns => $nsprefix ) {
                    $nslength = strlen( $ns );
                    if ( substr( $entityuri, 0, $nslength ) === $ns ) {
                        $uricontainsns = true;
                    }
                }
                // If no match was found above:
                if ( !$uricontainsns ) {
                    $unabbreviateduris[] = $entityuri;
                }
            }
        }
        return $unabbreviateduris;
    }

    /**
     * Add namespace prefixes to current namespace prefix configuration
     * @param array $newnsmappings
     */
    public function addNamespacePrefixes( $newnsmappings ) {
        $nsmapping = $this->m_nsprefixes;
        foreach ( $newnsmappings as $namespace => $prefix ) {
            $nsmapping[$namespace] = $prefix;
        }
        $this->m_nsprefixes = $nsmapping;
        // Right now this has to be duplicated (until Equiv URI handler is merged with SMWBatchWriter)
        $this->setNSPrefixes( $nsmapping );
    }

    /**
     * Delete imported facts instead of adding them
     */
    public function executeDelete() {
        $this->m_delete = true;
        $this->execute();
        $this->m_delete = false;
    }

    /**
     * Parse the imported data into ARC2 data structures which are stored in object variables.
     */
    private function parse() {
        $this->m_parser->parse( '', $this->m_unparseddata );
        $this->extractTriples();
    }

    /**
     * Prepare page handlers, which represent wiki pages to be written to/deleted from,
     * and the corresponding facts to add/remove
     */
    private function preparePageHandlers() {
        // The page below should not be deleted on delete operations
        if ( !$this->m_delete ) {
            // Add type info to the Original URI property
            $property_hastypeurl = array( array( 'p' => 'Has type', 'v' => 'URL' ) );
            $origuripage = new RDFIOPageHandler( 'Original URI', SMW_NS_PROPERTY, $property_hastypeurl );
            $this->addToPages( $origuripage );
        }

        // Prepare for storing the data to write in internal data structure ($this->m_pages)
        $unique_subject_uris = $this->getUniqueSubjectURIs();
        foreach ( $unique_subject_uris as $subject_uri ) {
            $properties = array();
            // A URIResolver URI indicates that internal titles only are used and we have no Original URI available
            if (  !$this->m_delete && !RDFIOUtils::isURIResolverURI( $subject_uri ) && !RDFIOUtils::isArcUntitledNode( $subject_uri ) ) {
                // Add the Original URI fact to the list of properties
                $properties[0] = $this->createOrigURIPropertyArray( $subject_uri );
                $properties[1] = $this->createEquivURIPropertyArray( $subject_uri );
                $i++;
            }

            $wikititle = $this->getWikiTitleForURI( $subject_uri );
            $triplesforpage = $this->getTriplesForSubject( $subject_uri );

            $i = 2;
            foreach ( $triplesforpage as $triple ) {
                $propertyuri = $triple['p'];
                $valueorig = $triple['o'];
                $valuetype = $triple['o_type'];
                $property = $this->getWikiTitleForURI( $propertyuri, $isproperty = true );
                if ( $valuetype == 'uri' ) {
                    $value = $this->getWikiTitleForURI( $valueorig );
                } else {
                    $value = RDFIOUtils::sanitizeSMWValue( $valueorig );
                }
                $properties[$i] = array( 'p' => $property, 'v' => $value );
                $i++;
            }

            $this->addToPages( new RDFIOPageHandler( $wikititle, NS_MAIN, $properties ) );
        }

        // The data generated below should not be deleted when doing delete operations, and thus,
        // pagehandlers for them should not be prepared on delete.
        if ( !$this->m_delete ) {
            // Prepare property pages
            $unique_property_uris = $this->getUniquePropertyURIs();
            foreach ( $unique_property_uris as $property_uri => $property_uridata ) {
                $wikititle = $this->getWikiTitleForURI( $property_uri, $isproperty = true );

                $type = $this->convertARCTypeToSMWType( $property_uridata['type'], $property_uridata['datatype'] );
                $property_hastype = array( 'p' => 'Has type', 'v' => $type );
                // A URIResolver URI indicates that internal titles only are used and we have no Original URI available
                if ( !RDFIOUtils::isURIResolverURI( $property_uri ) && !RDFIOUtils::isArcUntitledNode( $wikititle ) ) {
                    $property_origuri = $this->createOrigURIPropertyArray( $property_uri );
                    $property_equivuri = $this->createEquivURIPropertyArray( $property_uri );
                    $properties = array( $property_origuri, $property_equivuri, $property_hastype );
                } else {
                    $properties = array( $property_hastype );
                }
                $propertypage = new RDFIOPageHandler( $wikititle, SMW_NS_PROPERTY, $properties );
                $this->addToPages( $propertypage );
            }

            // Prepare value pages
            // TODO: Look for a way to merge with the above code, or otherwise refactor ...
            $unique_value_uris = $this->getUniqueValueURIs();
            foreach ( $unique_value_uris as $unique_value_uri ) {
                $wikititle = $this->getWikiTitleForURI( $unique_value_uri );

                // A URIResolver URI indicates that internal titles only are used and we have no Original URI available
                if ( !RDFIOUtils::isURIResolverURI( $unique_value_uri ) && !RDFIOUtils::isArcUntitledNode( $unique_value_uri ) ) {
                    $value_origuri = $this->createOrigURIPropertyArray( $unique_value_uri );
                    $value_equivuri = $this->createEquivURIPropertyArray( $unique_value_uri );
                    $values = array( $value_origuri, $value_equivuri );
                }
                $valuepage = new RDFIOPageHandler( $wikititle, NS_MAIN, $values );
                $this->addToPages( $valuepage );
            }
        }
    }

    /**
     * Write the pages, with corresponding facts, represented as page handlers, to the wiki
     */
    private function writePagesToWiki() {
        global $wgOut;

        $pages = $this->m_pages;
        foreach ( $pages as $page ) {
            $page->writeOrDeleteDataToWiki();
            if ( $page->hasErrors() ) {
                $errortitle = "Error for wikipage \"" . $page->getWikiTitleFull() . "\"</h3>";
                $wgOut->addHTML( RDFIOUtils::formatErrorHTML( $errortitle, $page->getErrorText() ) );
            }
        }
    }

    /**
     * Delete the facts stored in page handlers, from the wiki
     */
    private function deletePageDataFromWiki() {
        global $wgOut;

        $pages = $this->m_pages;
        foreach ( $pages as $page ) {
            $page->deleteDataFromWiki();
            if ( $page->hasErrors() ) {
                $errortitle = "Error for wikipage \"" . $page->getWikiTitleFull() . "\"</h3>";
                $wgOut->addHTML( RDFIOUtils::formatErrorHTML( $errortitle, $page->getErrorText() ) );
            }
        }
    }

    /**
     * Get generated triples from the ARC2 parser and store in object variable
     */
    private function extractTriples() {
        $triples = $this->m_parser->getTriples();
        $this->m_triples = $triples;
    }

    /**
     * Get generated triple index from the ARC2 parser and store in object variable
     */
    private function extractTripleIndex() {
        $this->m_tripleindex = ARC2::getSimpleIndex( $this->m_triples, false );
        $this->m_tripleindexflat = ARC2::getSimpleIndex( $this->m_triples, true );
    }

    /**
     * Add a page handler to the current SMWBatchWriter
     * @param RDFIOPageHandler $page
     */
    private function addToPages( $page ) {
        $this->m_pages[] = $page;
    }

    /**
     * Get all triples with a given subject
     * @param string $subjecturi
     * @return array $triples
     */
    function getTriplesForSubject( $subjecturi ) {
        $reconstructedIndex = array( $subjecturi => $this->m_tripleindex[$subjecturi] );
        $triples = ARC2::getTriplesFromIndex( $reconstructedIndex );
        return $triples;
    }

    /**
     * Get a list of unique subject URI:s from the internally stored triple index
     * @return array
     */
    function getUniqueSubjectURIs() {
        return array_keys( $this->m_tripleindex );
    }

    /**
     * Get a list of unique property URI:s and corresponding type info, from the
     * internally stored triple index
     * @return array $properties
     */
    function getUniquePropertyURIs() {
        $tripleindex = $this->m_tripleindex;
        $properties = array();
        foreach ( $tripleindex as $cur_props ) {
            foreach ( $cur_props as $cur_prop => $cur_propdata ) {
                $properties[$cur_prop] = array(
                	'type' => $cur_propdata[0]['type'],
                	'datatype' => $cur_propdata[0]['datatype']
                ); // Only the type info is interesting here
            }
        }
        return $properties;
    }

    /**
     * Get an array of unique URIs occuring as values in imported data
     * @return array $value_uris
     */
    function getUniqueValueURIs() {
        $tripleindex = $this->m_tripleindex;
        $value_uris_data = array();
        foreach ( $tripleindex as $cur_props ) {
            foreach ( $cur_props as $cur_prop => $cur_propdatas ) {
                foreach ( $cur_propdatas as $cur_propdata ) {
                    $value = $cur_propdata['value'];
                    $valuetype = $cur_propdata['type'];
                    $valuedatatype = $cur_propdata['datatype'];
                    if ( $valuetype == 'uri' ) {
                        $value_uris_data[$value] = array(
                			'type' => $valuetype,
                			'datatype' => $valuedatatype
                        );
                    }
                }
            }
        }
        $value_uris = array_keys( $value_uris_data );
        return $value_uris;
    }

    /**
     * Create a property array with "Original URI" as property,
     * and $uri as subject
     * @param string $uri
     * @return array $origuripropertyarray
     */
    function createOrigURIPropertyArray( $uri ) {
        $origuripropertyarray = array(
            'p' => 'Original URI',
            'v' => $uri );
        return $origuripropertyarray;
    }

    /**
     * Create a property array with "Equivalent URI" as property,
     * and $uri as subject
     * @param string $uri
     * @return array $equivuripropertyarray
     */
    function createEquivURIPropertyArray( $uri ) {
        $equivuripropertyarray = array(
            'p' => 'Equivalent URI',
            'v' => $uri );
        return $equivuripropertyarray;
    }

    /**
     * Convert an entity type identifier used by ARC, to one used by SMW
     * (Example: "uri" --> "Page")
     * @param string $arctype
     * @param string $arcdatatype
     *
     */
    function convertARCTypeToSMWType( $arctype, $arcdatatype ) {
        if ( $arctype == 'uri' ) {
            return 'Page';
        } elseif ( $arctype == 'literal' ) {
            if ( $arcdatatype == 'http://www.w3.org/2001/XMLSchema#decimal' ) {
                return 'Number';
            } else {
                return 'String';
            }
        } else {
            $this->addError( 'Unknown entity type in SMWBatchWriter.php:convertARCTypeToSMWType' );
        }
        // TODO: Expand with more options
    }

    /**
     * Get the currently configured namespace prefix mapping
     * @return array
     */
    function getNSPrefixMapping() {
        return $this->m_nsprefixes;
    }

    /**
     * Get from the ARC2 parser, an array index, of namespace prefixes, and the
     * corresponding full namespaces.
     * @return array
     */
    function getNSPrefixMappingFromParser() {
        return $this->m_parser->nsp;
    }

    /**
     * Cleanup some unfortunate combination of tags and linebreaks, that breaks the ARC2 parser
     * @param string $xmldata
     * @return boolean
     */
    private function cleanupXML( $xmldata ) {
        // Cleaning up unfortunate line breaks, which tend to bread RDFXML parser
        $xmldata = str_replace( ">\r\n", '>', $xmldata );
        $xmldata = str_replace( ">\n", '>', $xmldata );
        return $xmldata;
    }

    /**
     * Add an $errormessage to the objects current errors
     * @param unknown_type $errormessage
     */
    private function addError( $errormessage ) {
        $this->m_errors[] = $errormessage;
        $this->m_haserrors = true;
    }

    /**
     * Check if current object contains errors
     * @return boolean
     */
    public function hasErrors() {
        return $this->m_haserrors;
    }

    /**
     * Get an array with current errors
     * @return array
     */
    public function getErrors( ) {
        return $this->m_errors;
    }

    /**
     * Get a textual representation of current errors
     * @return string $errortext
     */
    public function getErrorText() {
        $errors = $this->m_errors;
        $errortext = '';
        $i = 1;
        foreach ( $errors as $error ) {
            $errortext .= "$error\n";
            $i++;
        }
        return $errortext;
    }


    //////////// / PREVIOUSLY THE EQUIV URI CLASS //////////////////////


    /**
     * Takes an ARC2 ns prefix mapping array and stores in class variable
     * @param array $nsprefixmapping
     */
    public function setNSPrefixes( $nsprefixmapping ) {
        $this->m_nsprefixes = $nsprefixmapping;
    }

    /**
     * Takes an ARC2 triple index and stores in class variable
     * @param array $tripleindex
     */
    public function setTripleIndex( $tripleindex ) {
        $this->m_tripleindex = $tripleindex;
    }

    /**
     * Converts a (full) URI into a string suitable for use as wiki title
     * @param string $uri
     * @param boolean $isproperty
     * @return string $wikititle
     */
    public function getWikiTitleForURI( $uri, $isproperty = false ) {
        // URI resolver URIs should never be used as original URI, and therefore is not
        // checked for.
        if ( !RDFIOUtils::isURIResolverURI( $uri ) ) {
            $titleByStoredOriginalUri = $this->getWikiTitleByStoredOriginalUri( $uri );
        }

        if ( $titleByStoredOriginalUri != '' ) {
            $wikititle = $titleByStoredOriginalUri;
        } else {
            $titlebypropertyuriindex = $this->getWikiTitleByPropertyURIIndex( $uri );
            if ( $titlebypropertyuriindex != '' ) {
                $wikititle = $titlebypropertyuriindex;
            } elseif ( ( $this->m_usenspintitles_entities && !$isproperty ) ||
            ( $this->m_usenspintitles_properties && $isproperty ) ) {
                $wikititle = $this->abbreviateNSFromURI( $uri );
            } else {
                $wikititle = RDFIOUtils::extractLabelFromURI( $uri );
            }
            $wikititle = RDFIOUtils::sanitizeWikiTitle( $wikititle );
        }
        if ( !RDFIOUtils::isURL( $wikititle ) ) {
            $wikititle = ucfirst( $wikititle );
        }
        return $wikititle;
    }

    /**
     * Check the wiki for an article with the $origuri set as "Original URI" through
     * the "Original URI" property, and return the title of that article.
     * @param string $origuri
     * @return string $wikititle
     */
    public function getWikiTitleByStoredOriginalUri( $origuri ) {
        $wikititle = $this->m_store->getWikiTitleByOriginalURI( $origuri );
        return $wikititle;
    }

    /**
     * Convert a namespace into its corresponding prefix, using prefix definitions
     * submitted in imported RDF/XML, if available.
     * @param string $ns
     * @return string $prefix
     */
    function getPrefixForNS( $ns ) {
        // Namespace prefis definitions are stored in the 'nsp' array
        // of the (RDF/XML) parser object, since import.
        $prefix = $this->m_nsprefixes[$ns];
        if ( $prefix == '' ) $prefix = $ns;
        return $prefix;
    }

    /**
     * Use a "natural language" property, such as dc:title or similar, as wiki title
     * @param string $subject
     * @return string $title
     */
    function getWikiTitleByPropertyURIIndex( $subject ) {
        // Looks through, in order, the uri:s in $this->m_wikititlepropertyuris
        // to see if any of them is set for $subject. if so, return corresponding
        // value as title.
        $title = '';
        foreach ( $this->m_wikititlepropertyuris as $wikititlepropertyuri ) {
            $title = $this->m_tripleindex[$subject][$wikititlepropertyuri][0]['value'];
            if ( $title != '' ) {
                // When we have found a "$wikititlepropertyuri" that matches,
                // return the value immediately
                return $title;
            }
        }
        return $title;
    }

    /**
     * Abbreviate the base URI into a "pseudo-wiki-title-namespace"
     * @param string $uri
     * @return string $uri
     */
    public function abbreviateNSFromURI( $uri ) {
        $prefixes = $this->m_nsprefixes;

        foreach ( $prefixes as $ns => $prefix ) {
            $nslength = strlen( $ns );
            $uricontainsns = substr( $uri, 0, $nslength ) === $ns;
            if ( $uricontainsns ) {
                $basepart = $prefix;
                $localpart = substr( $uri, $nslength );
            }
        }

        if ( $basepart == '' &&  $localpart == '' ) {
            $uriParts = RDFIOUtils::splitURI( $uri );
            $basepart = $uriParts[0];
            $localpart = $uriParts[1];
        }

        if ( $localpart == '' ) {
            $uri = $basepart;
        } elseif ( substr( $basepart, 0, 1 ) == '_' ) {
            // Change ARC:s default "random string", to indicate more clearly that
            // it lacks title
            $uri = str_replace( 'arc', 'untitled', $localpart );
        } elseif ( substr( $basepart, 0, 7 ) == 'http://' ) {
            // If the abbreviation does not seem to have succeeded,
            // fall back to use only the local part
            $uri = $localpart;
        } elseif ( substr( $basepart, -1 ) == ':' ) {
            // Don't add another colon
            $uri = $basepart . $localpart;
        } elseif ( $basepart == false || $basepart == '' ) {
            $uri = $localpart;
        } else {
            $uri = $basepart . ':' . $localpart;
        }

        return $uri;
    }

    /**
     * Abbreviate the base URI into a "pseudo-wiki-title-namespace"
     * @param string $uri
     * @return string $uri
     */
    public function abbreviateNSFromURIOld( $uri ) {
        $uriParts = RDFIOUtils::splitURI( $uri );
        $basepart = $uriParts[0];
        $localpart = $uriParts[1];

        if ( $localpart == '' ) {
            $uri = $basepart;
        } elseif ( substr( $basepart, 0, 1 ) == '_' ) {
            // Change ARC:s default "random string", to indicate more clearly that
            // it lacks title
            $uri = str_replace( 'arc', 'untitled', $localpart );
        } else {
            $basepart = $this->getPrefixForNS( $basepart );
            if ( substr( $basepart, 0, 7 ) == 'http://' ) {
                // If the abbreviation does not seem to have succeeded,
                // fall back to use only the local part
                $uri = $localpart;
            } elseif ( substr( $basepart, -1 ) == ':' ) {
                // Don't add another colon
                $uri = $basepart . $localpart;
            } else {
                $uri = $basepart . ':' . $localpart;
            }
        }
        return $uri;
    }

    /**
     * Set the object parameter whether to use namespace prefixes
     * in wiki titles, for properties
     * @param boolean $usenspintitles_properties
     */
    public function setUseNSPInTitlesForProperties( $usenspintitles_properties ) {
        $this->m_usenspintitles_properties = $usenspintitles_properties;
    }

    /**
     * Set the object parameter whether to use namespace prefixes
     * in wiki titles, for entities (non-properties)
     * @param boolean $usenspintitles_entities
     */
    public function setUseNSPInTitlesForEntities( $usenspintitles_entities ) {
        $this->m_usenspintitles_entities = $usenspintitles_entities;
    }
}
