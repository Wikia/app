<?php
class SPARQLEndpoint extends SpecialPage {

    protected $m_sparqlendpointconfig;
    protected $m_sparqlendpoint;
    protected $m_sparqlparser;
    protected $m_store;
    protected $m_query;
    protected $m_query_parsed;
    protected $m_querytype;
    protected $m_outputtype;
    protected $m_querybyoriguri;
    protected $m_querybyequivuri;
    protected $m_outputoriguris;
    protected $m_outputequivuris;
    protected $m_haswriteaccess; // User permission
    protected $m_hasdeleteaccess; // User permission

    function __construct() {
        global $wgUser, $rdfiogQueryByOrigURI;

        parent::__construct( 'SPARQLEndpoint' );
        $this->m_sparqlendpointconfig = $this->getSPARQLEndpointConfig();
        $this->m_sparqlendpoint = ARC2::getStoreEndpoint( $this->m_sparqlendpointconfig );
        $this->m_sparqlparser = ARC2::getSPARQLPlusParser();
        $this->m_store = new RDFIOStore();

        $userrights = $wgUser->getRights();
        if ( in_array( 'edit', $userrights ) && in_array( 'createpage', $userrights ) ) {
            $this->m_haswriteaccess = true;
        } else {
            $this->m_haswriteaccess = false;
        }
        if ( in_array( 'edit', $userrights ) && in_array( 'delete', $userrights ) ) {
            $this->m_hasdeleteaccess = true;
        } else {
            $this->m_hasdeleteaccess = false;
        }
    }

    /**
     * The main function
     */
    function execute() {
        global $wgRequest, $wgOut, $wgUser;

        $this->setHeaders();
        $this->handleRequestData();

        $executesparql = true;

        if ( $this->m_query == '' ) {
            $this->printHTMLForm();
        } else {
            $this->ensureSparqlEndpointInstalled();
            $this->convertURIsInQuery();

            if ( $this->m_querytype == 'insert' ) { // TODO
                if ( $this->checkAllowInsert() ) {
                    $this->importTriplesInQuery();
                }
                $this->printHTMLForm();
            } elseif ( $this->m_querytype == 'delete' ) {
                if ( $this->checkAllowDelete() ) {
                    $this->deleteTriplesInQuery();
                }
                // TODO Add a "successfully inserted/deleted" message here
                $this->printHTMLForm();
            } else { // We are querying/outputting data, not editing

                if ( $this->m_outputtype == 'htmltab' ) {
                    $this->printHTMLForm();
                    if ( $wgRequest->getBool( 'showquery', false ) ) {
                        $this->printQueryStructure();
                        $executesparql = false;
                    }
                } elseif ( $this->m_outputtype == 'rdfxml' && $this->m_querytype != 'construct' ) {
                    $errormessage = "RDF/XML can only be used with CONSTRUCT, if constructing triples";
                    $wgOut->addHTML( RDFIOUtils::formatErrorHTML( "Invalid choice", $errormessage ) );
                    $this->printHTMLForm();
                    $executesparql = false;
                } else {
                    $this->prepareCreatingDownloadableFile();
                }

                if ( $executesparql ) {
                    $outputtype = $this->m_outputtype;
                    if ( $outputtype == '' && $this->m_querytype == 'construct' ) {
                        $outputtype = 'rdfxml';
                    }
                    if ( $outputtype == 'rdfxml' || $outputtype == 'xml' || $outputtype == '' ) {
                        // Make sure that ARC outputs data in a format that we can
                        // easily work with programmatically
                        $this->setOutputTypeInPost( 'php_ser' );
                    }

                    // Pass on the request handling to ARC2:s SPARQL Endpoint
                    $this->m_sparqlendpoint->handleRequest();
                    $this->handleSPARQLErrors();
                    $output = $this->m_sparqlendpoint->getResult();

                    if ( $outputtype == 'htmltab' ) {
                        if ( $this->m_outputoriguris ) {
                            $output = $this->convertURIsToOrigURIsInText( $output );
                        }
                        $output = $this->extractPrepareARCHTMLOutput( $output );
                        $wgOut->addHTML( $output );
                    } elseif ( $outputtype == 'rdfxml' ) {
                        $output_structure = unserialize( $output );
                        $tripleindex = $output_structure['result'];
                        $triples = ARC2::getTriplesFromIndex( $tripleindex );
                        if ( $this->m_outputoriguris ) {
                            $triples = $this->convertURIsToOrigURIsInTriples( $triples );
                        }
                        if ( $this->m_outputequivuris ) {
                            # $triples = $this->complementTriplesWithEquivURIsForProperties( $triples );
                            if ( $this->m_filtervocab && ( $this->m_filtervocaburl != '' ) ) {
                                $vocab_p_uri_filter = $this->getVocabPropertyUriFilter();
                                $triples = $this->complementTriplesWithEquivURIs( $triples, $vocab_p_uri_filter );
                            } else {
                                $triples = $this->complementTriplesWithEquivURIs( $triples );
                            }
                        }
                        $output = $this->triplesToRDFXML( $triples );
                        echo $output;
                    } else {
                        $output_structure = unserialize( $output );
                        if ( $this->m_outputoriguris ) {
                            $output_structure = $this->convertURIsToOrigURIsInSPARQLResultSet( $output_structure );
                        }
                        if ( $this->m_outputequivuris ) {
                            $vocab_p_uri_filter = $this->getVocabPropertyUriFilter();
                            $output_structure = $this->complementSPARQLResultRowsWithEquivURIs( $output_structure, $vocab_p_uri_filter );
                        }
                        $output = $this->m_sparqlendpoint->getSPARQLXMLSelectResultDoc( $output_structure );
                        echo $output;
                    }
                }
            }
        }
    }

    /**
     * Take care of data from the request object and store
     * in class variables
     */
    function handleRequestData() {
        global $wgRequest,
               $rdfiogQueryByOrigURI,
               $rdfiogQueryByEquivURI,
               $rdfiogOutputOrigURIs,
               $rdfiogOutputEquivURIs;

        $this->m_query = $wgRequest->getText( 'query' );

        if ( $rdfiogQueryByOrigURI == '' ) {
          $this->m_querybyoriguri = $wgRequest->getBool( 'origuri_q' ); // No default value, as to not overwrite configurable setting in LocalSettings.php
        } else {
          $this->m_querybyoriguri = $rdfiogQueryByOrigURI;
        }

        if ( $rdfiogQueryByEquivURI == '' ) {
          $this->m_querybyequivuri = $wgRequest->getBool( 'equivuri_q' );
        } else {
          $this->m_querybyequivuri = $rdfiogQueryByEquivURI;
        }

        if ( $rdfiogOutputOrigURIs == '' ) {
            $this->m_outputoriguris = $wgRequest->getBool( 'origuri_o' );
        } else {
            $this->m_outputoriguris = $rdfiogOutputOrigURIs;
        }

        if ( $rdfiogOutputEquivURIs == '' ) {
            $this->m_outputequivuris = $wgRequest->getBool( 'equivuri_o' );
        } else {
            $this->m_outputequivuris = $rdfiogOutputEquivURIs;
        }

        $this->m_filtervocab = $wgRequest->getBool( 'filtervocab', false );
        $this->m_filtervocaburl = $wgRequest->getText( 'filtervocaburl' );
        $this->m_outputtype = $wgRequest->getText( 'output' );
        if ( $this->m_query !== '' ) {
            $this->m_sparqlparser->parse( $this->m_query, '' );
            $this->m_query_parsed = $this->m_sparqlparser->getQueryInfos();
            if ( array_key_exists( 'query', $this->m_query_parsed ) ) {
                $this->m_querytype = $this->m_query_parsed['query']['type'];
            }
        }
    }

    function ensureSparqlEndpointInstalled() {
        if ( !$this->m_sparqlendpoint->isSetUp() ) {
            $this->m_sparqlendpoint->setUp(); /* create MySQL tables */
        }
    }

    /**
     * If option is so chosen, convert URIs in the query to
     * their corresponding "Original URIs" or "Equivalent URIs"
     */
    function convertURIsInQuery() {
        if ( $this->m_querybyoriguri ) {
            $this->convertOrigURIsToInternalURIsInQuery();
        } elseif ( $this->m_querybyequivuri ) {
            $query_structure = $this->m_query_parsed;
            $triple = $query_structure['query']['pattern']['patterns'][0]['patterns'][0];
            $s = $triple['s'];
            $p = $triple['p'];
            $o = $triple['o'];
            $s_type = $triple['s_type'];
            $p_type = $triple['p_type'];
            $o_type = $triple['o_type'];
            if ( $s_type === 'uri' ) {
                $triple['s'] = 's';
                $triple['s_type'] = 'var';
                $newtriple = $this->createEquivURITriple( $s, 's' );
                $query_structure['query']['pattern']['patterns'][0]['patterns'][] = $newtriple;
            }
            if ( $p_type === 'uri' ) {
                $triple['p'] = 'p';
                $triple['p_type'] = 'var';
                $newtriple = $this->createEquivURITriple( $p, 'p', true );
                $query_structure['query']['pattern']['patterns'][0]['patterns'][] = $newtriple;
            }
            if ( $o_type === 'uri' ) {
                $triple['o'] = 'o';
                $triple['o_type'] = 'var';
                $newtriple = $this->createEquivURITriple( $o, 'o' );
                $query_structure['query']['pattern']['patterns'][0]['patterns'][] = $newtriple;
            }
            // restore the first triple into its original location
            $query_structure['query']['pattern']['patterns'][0]['patterns'][0] = $triple;
            require_once( __DIR__ . "/bundle/ARC2_SPARQLSerializerPlugin.php" );
            $sparqlserializer = new ARC2_SPARQLSerializerPlugin();
            $query = $sparqlserializer->toString( $query_structure );

            $this->setQueryInPost( $query );
            # $this->convertEquivURIsToInternalURIsInQuery(); // TODO DEPRECATED
        }
    }

    /**
     * Get an array of property URIs from the specified ontology,
     * to function as a filter
     * @return array $vocab_p_uri_filter
     */
    function getVocabPropertyUriFilter() {
        $vocaburl = $this->m_filtervocaburl;
        $RDFXMLParser = ARC2::getRDFXMLParser();
        $RDFXMLParser->parse( $vocaburl );
        $vocabtriples = $RDFXMLParser->getTriples();
        $vocab_p_uri_filter = array();
        foreach ( $vocabtriples as $vocabtriple ) {
            $p = $vocabtriple['p'];
            $o = $vocabtriple['o'];
            // For OWL vocabularies:
            if ( $p === 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type' &&
            $o === 'http://www.w3.org/2002/07/owl#ObjectProperty' ) {
                $vocab_p_uri = $vocabtriple['s'];
                $vocab_p_uri_filter[] = $vocab_p_uri;
            }
        }
        return $vocab_p_uri_filter;
    }

    /**
     * Create an RDF triple that links a wiki page to its corresponding
     * equivalent URI
     * @param string $uri
     * @param string $varname
     * @param boolean $isproperty
     * @return array $equivuritriple
     */
    function createEquivURITriple( $uri, $varname, $isproperty = false ) {
        if ( $isproperty ) {
            $equivuriuri = $this->m_store->getEquivURIURIForProperty();
        } else {
            $equivuriuri = $this->m_store->getEquivURIURI();
        }
        $equivuritriple = array(
        	'type' => 'triple',
        	's' => $varname,
        	'p' => $equivuriuri,
        	'o' => $uri,
        	's_type' => 'var',
        	'p_type' => 'uri',
        	'o_type' => 'uri',
        	'o_datatype' => '',
        	'o_lang' => ''
        );
        return $equivuritriple;
    }

    /**
     * Check if writing to wiki is allowed, and handle a number
     * of exceptions to that, by showing error messages etc
     */
    function checkAllowInsert() {
        global $wgRequest, $wgUser, $wgOut, $rdfiogAllowRemoteEdit;
        if ( $rdfiogAllowRemoteEdit == '' ) {
            $rdfiogAllowRemoteEdit = false;
        }
        if ( !$wgUser->matchEditToken( $wgRequest->getText( 'token' ) ) &&
             !$rdfiogAllowRemoteEdit ) {
            $errortitle = "Error";
            $errormessage = "Cross-site request forgery detected!";
            $wgOut->addHTML( RDFIOUtils::formatErrorHTML( $errortitle, $errormessage ) );
            return false;
        } else {
            if ( $this->m_haswriteaccess ) {
                return true;
            } else {
                $errortitle = "Permission error";
                $errormessage = "The current user lacks access either to edit or create pages (or both) in this wiki.";
                $wgOut->addHTML( RDFIOUtils::formatErrorHTML( $errortitle, $errormessage ) );
                return false;
            }
        }
    }

    /**
     * Check if deleting from wiki is allowed, and handle a number
     * of exceptions to that, by showing error messages etc
     */
    function checkAllowDelete() {
        global $wgRequest, $wgUser, $wgOut, $rdfiogAllowRemoteEdit;
        if ( !$wgUser->matchEditToken( $wgRequest->getText( 'token' ) ) &&
             !$rdfiogAllowRemoteEdit ) {
            die( 'Cross-site request forgery detected!' );
        } else {
            if ( $this->m_hasdeleteaccess || $rdfiogAllowRemoteEdit ) {
                return true;
            } else {
                $errortitle = "Permission error";
                $errormessage = "The current user lacks access either to edit or delete pages (or both) in this wiki.";
                $wgOut->addHTML( RDFIOUtils::formatErrorHTML( $errortitle, $errormessage ) );
                return false;
            }
        }
    }

    /**
     * Print out the datastructure of the query in preformatted text
     */
    function printQueryStructure() {
        global $wgOut;
        $wgOut->addHTML( "<h3>Query structure</h3><pre>" . print_r( $this->m_query_parsed, true ) . "</pre>" );
    }

    /**
     * Do preparations for getting outputted data as a downloadable file
     * rather than written to the current page
     */
    function prepareCreatingDownloadableFile() {
        global $wgOut;
        // Disable MediaWikis theming
        $wgOut->disable();
        // Enables downloading as a stream, which is important for large dumps
        wfResetOutputBuffers();
        // Send headers telling that this is a special content type
        // and potentially is to be downloaded as a file
        $this->sendHeadersForOutputType( $this->m_outputtype );
    }

    /**
     * Print out the HTML Form
     */
    function printHTMLForm() {
        global $wgOut;
        $wgOut->addScript( $this->getHTMLFormScript() );
        $wgOut->addHTML( $this->getHTMLForm( $this->m_query ) );
    }

    /**
     * Extract the main content form ARC:s SPARQL result HTML
     * and do some processing (wikify tables)
     * @param string $output
     * @return string $html
     */
    function extractPrepareARCHTMLOutput( $output ) {
        $html = RDFIOUtils::extractHTMLBodyContent( $output );
        $html = RDFIOUtils::wikifyTables( $html );
        $html = "<h3>Result:</h3><div style='font-size: 11px;'>" . $html . "</div>";
        return $html;
    }

    /**
     * After a query is parsed, import the parsed data to the wiki
     */
    function importTriplesInQuery() {
        $triples = $this->m_query_parsed['query']['construct_triples'];
        $rdfImporter = new RDFIOSMWBatchWriter( $triples, 'triples_array' );
        $rdfImporter->execute();
    }

    /**
     * After a query is parsed, delete the parsed data from the wiki
     */
    function deleteTriplesInQuery() {
        $triples = $this->m_query_parsed['query']['construct_triples'];
        $rdfImporter = new RDFIOSMWBatchWriter( $triples, 'triples_array' );
        $rdfImporter->executeDelete();
    }

    /**
     * Die and display current errors
     */
    function handleSPARQLErrors() {
        global $wgOut;
        $sparqlEndpointErrors = $this->m_sparqlendpoint->getErrors();
        if ( count( $sparqlEndpointErrors ) > 0 ) {
            $errormessage = '';
            if ( is_array( $sparqlEndpointErrors ) ) {
                foreach ( $sparqlEndpointErrors as $sparqlEndpointError ) {
                    $errormessage .= "<p>$sparqlEndpointError</p>";
                }
            } else {
                $errormessage = "<p>$sparqlEndpointErrors</p>";
            }
            RDFIOUtils::showErrorMessage( "SPARQL Error", $errormessage );
        }
    }

    /**
     * For each URI in the (unparsed) query that is set by an "Original URI" property in
     * the wiki, replace it with the page's corresponding URI Resolver URI
     */
    function convertOrigURIsToInternalURIsInQuery() {
        $query = $this->m_query;
        $origuris = RDFIOUtils::extractURIs( $this->m_query ); // TODO: Use parsed query instead
        $count = count( $origuris );
        if ( $count > 1 || ( $count > 0 && !RDFIOUtils::contains( "URIResolver", $origuris[0] ) ) ) { // The first URI is the URI Resolver one, which always is there
            foreach ( $origuris as $origuri ) {
                $uri = $this->m_store->getURIForOrigURI( $origuri );
                if ( $uri != '' ) {
                    // Replace original uri:s into SMW:s internal URIs
                    // (The "http://.../Special:URIResolver/..." ones)
                    $query = str_replace( $origuri, $uri, $this->m_query );
                }
            }
            $this->setQueryInPost( $query );
        }
    }

    /**
     * For each URI in the (unparsed) query that is set by an "Equivalent URI" property in
     * the wiki, replace it with the page's corresponding URI Resolver URI
     */
    function convertEquivURIsToInternalURIsInQuery() {
        $equivuris = RDFIOUtils::extractURIs( $this->m_query ); // TODO: Use parsed query instead
        $count = count( $equivuris );
        if ( count( $equivuris ) > 1 ) { // The first URI is the URI Resolver one, which always is there
                                        // TODO: Create a more robust check
            foreach ( $equivuris as $equivuri ) {
                $uri = $this->m_store->getURIForEquivURI( $equivuri );
                if ( $uri != '' ) {
                    // Replace original uri:s into SMW:s internal URIs
                    // (The "http://.../Special:URIResolver/..." ones)
                    $query = str_replace( $equivuri, $uri, $this->m_query );
                }
            }
            $this->setQueryInPost( $query );
        }
    }

    /**
     * Convert all URI Resolver URIs which have a corresponding Original URI,
     * to that Original URI.
     * @param array $triples
     * @return array $triples
     */
    function convertURIsToOrigURIsInTriples( $triples ) {
        $variables = array( 's', 'p', 'o' );
        foreach ( $triples as $tripleid => $triple ) {
            foreach ( $variables as $variableid => $variable ) {
                $tripletypestr = $variable . "_type";
                $type = $triple[$tripletypestr];
                if ( $type === "uri" ) {
                    $uri = $triple[$variable];
                    $origuri = $this->m_store->getOrigURIForURI( $uri );
                    if ( $origuri != '' ) {
                        $triples[$tripleid][$variable] = $origuri;
                    }
                }
            }
        }
        return $triples;
    }

    /**
     * Convert all URI Resolver URIs which have a corresponding Original URI,
     * to that Original URI.
     * @param array $triples
     * @return array $triples
     */
    function convertURIsToOrigURIsInSPARQLResultSet( $output_structure ) {
        $variables = $output_structure['result']['variables'];
        $rows = $output_structure['result']['rows'];
        # $predvarname = $this->getPredicateVariableName();
        foreach ( $rows as $rowid => $row ) {
            foreach ( $variables as $variable ) {
                $typekey = "$variable type";
                $type = $row[$typekey];
                if ( $type === 'uri' ) {
                    $uri = $row[$variable];
                    $origuri = $this->m_store->getOrigURIForURI( $uri );
                    if ( $origuri != '' ) {
                        $output_structure['result']['rows'][$rowid][$variable] = $origuri;
                    }
                }
            }
        }
        return $output_structure;
    }

    /**
     * For all property URIs, add triples using equivalent uris for the,
     * current property uri
     * @param array $triples
     * @return array $triples
     */
    function addEquivUrisForProperties( $triples ) {
        $variables = array( 's', 'p', 'o' );
        $newtriples = array();
        foreach ( $triples as $tripleid => $triple ) {
            $propertyuri = $triple['p'];
            $equivuris = $this->m_store->getEquivURIsForURI( $propertyuri, true );
            foreach ( $equivuris as $equivuri ) {
                $newtriple = array(
                    's' => $triple['s'],
                	'p' => $equivuri,
                    'o' => $triple['o']
                );
                $newtriples[] = $newtriple;
            }
        }
        $triples = array_merge( $triples, $newtriples );
        return $triples;
    }

    /**
     * For all property URIs and all subject and objects which have URIs,
     * add triples using equivalent uris for these URIs (in all combinations
     * thereof). If $p_uris_filter is set, allow only triples with properties
     * included in this filter array
     * @param array $triples
     * @param array $p_uris_filter
     * @return array $triples
     */
    function complementTriplesWithEquivURIs( $triples, $p_uris_filter = '' ) {
        $variables = array( 's', 'p', 'o' );
        $newtriples = array();
        foreach ( $triples as $tripleid => $triple ) {
            // Subject
            $s_equivuris = array( $triple['s'] );
            if ( $triple['s_type'] === 'uri' ) {
                $s_uri = $triple['s'];
                $s_equivuris_temp = $this->m_store->getEquivURIsForURI( $s_uri );
                if ( count( $s_equivuris_temp ) > 0 ) {
                    $s_equivuris = $s_equivuris_temp;
                }
            }

            // Property
            $propertyuri = $triple['p'];
            $p_equivuris = array( $triple['p'] );
            $p_equivuris_temp = $this->m_store->getEquivURIsForURI( $propertyuri, true );
            if ( count( $p_equivuris_temp ) > 0 ) {
                if ( $p_uris_filter != '' ) {
                    // Only include URIs that occur in the filter
                    $p_equivuris_temp = array_intersect( $p_equivuris_temp, $p_uris_filter );
                }
                if ( $p_equivuris_temp != '' ) {
                    $p_equivuris = $p_equivuris_temp;
                }
            }

            // Object
            $o_equivuris = array( $triple['o'] );
            if ( $triple['o_type'] === 'uri' ) {
                $o_uri = $triple['o'];
                $o_equivuris_temp = $this->m_store->getEquivURIsForURI( $o_uri );
                if ( count( $o_equivuris_temp ) > 0 ) {
                    $o_equivuris = $o_equivuris_temp;
                }
            }

            // Generate triples
            foreach ( $s_equivuris as $s_equivuri ) {
                foreach ( $p_equivuris as $p_equivuri ) {
                    foreach ( $o_equivuris as $o_equivuri ) {
                        $newtriple = array(
                    		's' => $s_equivuri,
                			'p' => $p_equivuri,
                    		'o' => $o_equivuri
                        );
                        $newtriples[] = $newtriple;
                    }
                }
            }
        }
        return $newtriples;
    }

    function complementSPARQLResultRowsWithEquivURIs( $output_structure, $p_uris_filter = '' ) {
        $predvarname = $this->getPredicateVariableName();
        $variables = $output_structure['result']['variables'];
        $rows = $output_structure['result']['rows'];

        $predvarname = 'p'; // TODO DO a real check up
        $newrows_total = array();
        foreach ( $rows as $rowid => $row ) {
            $newrows = array();
            foreach ( $variables as $variable ) {
                $typekey = "$variable type";
                $type = $row[$typekey];
                $uri = $row[$variable];
                $equivuris = array();
                if ( $type === 'uri' ) {
                    $equivuris = $this->m_store->getEquivURIsForURI( $uri );
                    if ( $variable == $predvarname ) {
                        $equivuris = array_intersect( $equivuris, $p_uris_filter );
                    }
                }
                if ( count( $newrows ) < 1 ) {
                    if ( count( $equivuris ) > 0 ) {
                        foreach ( $equivuris as $equivuri ) {
                            $newrows[] = array( $variable => $equivuri, $typekey => 'uri' );
                        }
                    } else {
                        $newrows[] = array( $variable => $uri, $typekey => 'uri' );
                    }
                } else {
                    foreach ( $newrows as $newrowid => $newrow ) {
                        if ( count( $equivuris ) > 0 ) {
                            foreach ( $equivuris as $equivuri ) {
                                $newrowcontent = array( $variable => $equivuri, $typekey => 'uri' );
                                $newrows[$newrowid] = array_merge( $newrow, $newrowcontent );
                            }
                        } else {
                            $newrowcontent = array( $variable => $uri, $typekey => 'uri' );
                            $newrows[$newrowid] = array_merge( $newrow, $newrowcontent );
                        }
                    }
                }
            }
            $newrows_total = array_merge( $newrows_total, $newrows );
        }
        $output_structure['result']['rows'] = $newrows_total;
        return $output_structure;
    }

    /**
     * Convert an ARC triple index array structure into RDF/XML
     * @param array $tripleindex
     * @return string $rdfxml
     */
    function tripleIndexToRDFXML( $tripleindex ) {
        $ser = ARC2::getRDFXMLSerializer(); // TODO: Choose format depending on user choice
        // Serialize into RDF/XML, since it will contain
        // all URIs in un-abbreviated form, so that they
        // can easily be replaced by search-and-replace
        $rdfxml = $ser->getSerializedIndex( $tripleindex );
        if ( $ser->getErrors() ) {
            die( "ARC Serializer Error: " . $ser->getErrors() );
        }
        return $rdfxml;
    }

    /**
     * Convert an ARC triples array into RDF/XML
     * @param array $triples
     * @return string $rdfxml
     */
    function triplesToRDFXML( $triples ) {
        $ser = ARC2::getRDFXMLSerializer(); // TODO: Choose format depending on user choice
        // Serialize into RDF/XML, since it will contain
        // all URIs in un-abbreviated form, so that they
        // can easily be replaced by search-and-replace
        $rdfxml = $ser->getSerializedTriples( $triples );
        if ( $ser->getErrors() ) {
            die( "ARC Serializer Error: " . $ser->getErrors() );
        }
        return $rdfxml;
    }

    /**
     * Convert all URI Resolver URIs which have a corresponding Original URI,
     * to that Original URI.
     * @param string $text
     * @return string $text
     */
    function convertURIsToOrigURIsInText( $text ) {
        $uris = RDFIOUtils::extractURIs( $text );
        if ( $uris != '' ) {
            foreach ( $uris as $uri ) {
                $origuri = $this->m_store->getOrigURIForURI( $uri );
                if ( $origuri != '' ) {
                    $text = str_replace( $uri, $origuri, $text );
                }
            }
        }
        return $text;
    }

    function getPredicateVariableName() {
        $predvarname = $this->m_query_parsed['vars'][1];
        return $predvarname;
    }

    /**
     * Get a configuration array for initializing the ARCs
     * SPARQL endpoint
     */
    private function getSPARQLEndpointConfig() {
        global $wgDBserver, $wgDBname, $wgDBuser, $wgDBpassword, $smwgARC2StoreConfig;
        $epconfig = array(
            'db_host' => $wgDBserver, /* optional, default is localhost */
            'db_name' => $wgDBname,
            'db_user' => $wgDBuser,
            'db_pwd' =>  $wgDBpassword,
            'store_name' => $smwgARC2StoreConfig['store_name'],
            'endpoint_features' =>
        array(
            'select',
            'construct',
            'ask',
            'describe',
        # 'load',
        # 'insert', // This is not needed, since it is done via SMWWriter instead
        # 'delete', // This is not needed, since it is done via SMWWriter instead
        # 'dump' /* dump is a special command for streaming SPOG export */
        ),
            'endpoint_timeout' => 60, /* not implemented in ARC2 preview */
        # 'endpoint_read_key' => '', /* optional */
        # 'endpoint_write_key' => 'somekey', /* optional */
        # 'endpoint_max_limit' => 250, /* optional */
        );
        return $epconfig;
    }

    /**
     * Set headers appropriate to the filetype specified in $outputtype
     * @param string $outputtype
     */
    private function sendHeadersForOutputType( $outputtype ) {
        global $wgRequest;
        // Provide a sane filename suggestion
        $basefilename = 'SPARQLOutput_';
        switch( $outputtype )
        {
            case 'xml':
                $wgRequest->response()->header( "Content-type: application/xml; charset=utf-8" );
                $filename = urlencode( $basefilename . wfTimestampNow() . '.xml' );
                $wgRequest->response()->header( "Content-disposition: attachment;filename={$filename}" );
                break;
            case 'rdfxml':
                $wgRequest->response()->header( "Content-type: application/xml; charset=utf-8" );
                $filename = urlencode( $basefilename . wfTimestampNow() . '.rdf.xml' );
                $wgRequest->response()->header( "Content-disposition: attachment;filename={$filename}" );
                break;
            case 'json':
                $wgRequest->response()->header( "Content-type: text/html; charset=utf-8" );
                $filename = urlencode( $basefilename . wfTimestampNow() . '.json.txt' );
                $wgRequest->response()->header( "Content-disposition: attachment;filename={$filename}" );
                break;
            case 'turtle':
                $wgRequest->response()->header( "Content-type: text/html; charset=utf-8" );
                $filename = urlencode( $basefilename . wfTimestampNow() . '.turtle.txt' );
                $wgRequest->response()->header( "Content-disposition: attachment;filename={$filename}" );
                break;
            case 'htmltab':
                // For HTML table we are taking care of the output earlier
                # $wgRequest->response()->header( "Content-type: text/html; charset=utf-8" );
                # $filename = urlencode( $basefilename . wfTimestampNow() . '.html' );
                break;
            case 'tsv':
                $wgRequest->response()->header( "Content-type: text/html; charset=utf-8" );
                $filename = urlencode( $basefilename . wfTimestampNow() . '.tsv.txt' );
                $wgRequest->response()->header( "Content-disposition: attachment;filename={$filename}" );
                break;
            default:
                $wgRequest->response()->header( "Content-type: application/xml; charset=utf-8" );
                $filename = urlencode( $basefilename . wfTimestampNow() . '.xml' );
                $wgRequest->response()->header( "Content-disposition: attachment;filename={$filename}" );
        }

    }

    /**
     * Get the HTML for the main SPARQL querying form. If $query is set, use it to prefill the main textarea
     * @param string $query
     * @return string $htmlForm
     */
    private function getHTMLForm( $query = '' ) {
        global $wgArticlePath, $wgUser, $wgRequest;

        $uriResolverURI = $this->m_store->getURIResolverURI();

        $defaultQuery = "@PREFIX w : <$uriResolverURI> .\n\nSELECT ?s ?p ?o\nWHERE { ?s ?p ?o }\nLIMIT 25";

        if ( $query == '' ) {
            $query = $defaultQuery;
        }

        $checked_origuri_q = $wgRequest->getBool( 'origuri_q', false ) == 1 ? ' checked="true" ' : '';
        $checked_origuri_o = $wgRequest->getBool( 'origuri_o', false ) == 1 ? ' checked="true" ' : '';
        $checked_equivuri_q = $wgRequest->getBool( 'equivuri_q', false ) == 1 ? ' checked="true" ' : '';
        $checked_equivuri_o = $wgRequest->getBool( 'equivuri_o', false ) == 1 ? ' checked="true" ' : '';
        $checked_filtervocab = $wgRequest->getBool( 'filtervocab', false ) == 1 ? ' checked="true" ' : '';
        $checked_allowwrite = $wgRequest->getBool( 'allowwrite', false ) == 1 ? ' checked="true" ' : '';
        $checked_showquery = $wgRequest->getBool( 'showquery', false ) == 1 ? ' checked="true" ' : '';

        $selected_output_html = $wgRequest->getText( 'output', '' ) == 'htmltab' ? ' selected="selected" ' : '';
        $selected_output_rdfxml = $wgRequest->getText( 'output', '' ) == 'rdfxml' ? ' selected="selected" ' : '';

        // Make the HTML format selected by default
        if ( $selected_output_rdfxml == '' ) {
            $selected_output_html = ' selected="selected" ';
        }

        $htmlForm = '<form method="post" action="' . str_replace( '/$1', '', $wgArticlePath ) . '/Special:SPARQLEndpoint"
            name="createEditQuery">
            <div style="font-size: 10px">

            <table border="0"><tbody>
            <tr><td colspan="3">Enter SPARQL query:</td><tr>
            <tr><td colspan="3"><textarea cols="80" rows="9" name="query">' . $query . '</textarea></td></tr>
            <tr>
            <td style="vertical-align: top; border-right: 1px solid #ccc;">

            <table border="0" style="background: transparent; font-size: 11px;">
            <tr><td width="160" style="text-align: right">Query by original URIs:</td>
            <td>
			<input type="checkbox" name="origuri_q" value="1" ' . $checked_origuri_q . '/>
            </td></tr>
            <tr><td style="text-align: right">Query by Equivalent URIs:</td>
            <td>
			<input type="checkbox" name="equivuri_q" value="1" ' . $checked_equivuri_q . '/>
            </td></tr>
            </table>

            </td>
            <td width="170" style="vertical-align: top; border-right: 1px solid #ccc;">

            <table border="0" style="font-size: 11px; background: transparent;">
            <tr><td style="text-align: right">Output original URIs:</td>
            <td>
			<input type="checkbox" name="origuri_o" value="1" ' . $checked_origuri_o . '/>
            </td></tr>
            <tr><td style="text-align: right">Output Equivalent URIs:</td>
            <td>
			<input type="checkbox" name="equivuri_o" id="outputequivuri" value="1" ' . $checked_equivuri_o . ' onChange="toggleDisplay(\'byontology\');" />
            </td></tr>
            </table>

            </td>
            <td width="260" style="vertical-align: top;">

            <table border="0" style="font-size: 11px; background: transparent;" >
            <tr><td style="text-align: right" width="180">Output format:</td>
            <td style="vertical-align: top">
            <select id="output" name="output" onChange="toggleDisplay(\'byontology\');" >
              <!-- <option value="" >default</option> -->
              <!-- <option value="json" >JSON</option> -->
              <!-- <option value="plain" >Plain</option> -->
              <!-- <option value="php_ser" >Serialized PHP</option> -->
              <!-- <option value="turtle" >Turtle</option> -->
              <option value="htmltab" ' . $selected_output_html . '>HTML</option>
              <option value="xml" >XML Resultset</option>
              <option value="rdfxml" ' . $selected_output_rdfxml . '>RDF/XML</option>
              <!-- <option value="infos" >Query Structure</option> -->
              <!-- <option value="tsv" >TSV</option> -->
            </select>
            </td></tr>
            <tr>
            <td colspan="2">
            <span style="font-family: arial, helvetica, sans-serif; font-size: 10px; color: #777;">(RDF/XML requires creating triples using <a href="http://www.w3.org/TR/rdf-sparql-query/#construct">CONSTRUCT</a>)</span>
            </td>
            </table>

            </td>
            </tr>
            <tr>
            <td colspan="3">

            <div id="byontology" style="display: none; background: #ffd; border: 1px solid #ee7;">
            <table border="0" style="font-size: 11px; background: transparent;" >
            <tr><td style="text-align: right;">Filter by vocabulary:</td>
            <td>
			<input type="checkbox" name="filtervocab" value="1" ' . $checked_filtervocab . '/>
            </td>
            <td style="text-align: right">Vocabulary URL:</td>
            <td>
			<input type="text" name="filtervocaburl" size="48" />
            </td></tr>
            <tr>
            <td>&#160;</td>
            <td>&#160;</td>
            <td>&#160;</td>
            <td>
            <span style="font-family: arial, helvetica, sans-serif; font-size: 10px; color: #777">Example: http://xmlns.com/foaf/spec/index.rdf</span>
            </td></tr>
			</table>
			</div>

            </td>
            </table>
			</div>

            <input type="submit" value="Submit">' . Html::Hidden( 'token', $wgUser->editToken() ) . '
            </form>';
        return $htmlForm;
    }

    /**
     * Get the javascript used for some functionality in the main SPARQL
     * querying HTML form
     * @return string $htmlFormScript
     */
    private function getHTMLFormScript() {
        $htmlFormScript = "<script type=\"text/javascript\">
        function toggleDisplay(id1) {
        	var bostyle = document.getElementById(id1).style.display;
        	var fmtsel = document.getElementById('output');
        	var fmt = fmtsel.options[fmtsel.selectedIndex].value;
        	var outsel = document.getElementById('outputequivuri');
        	if ( outsel.checked && fmt.match('rdfxml') ) {
				document.getElementById(id1).style.display = 'block';
			} else {
				document.getElementById(id1).style.display = 'none';
			}
    	}
	 	</script>";
        return $htmlFormScript;
    }

    /**
     * Get the query parameter from the request object
     * @return string $query
     */
    function getQuery() {
        $query = $wgRequest->getText( 'query' );
        return $query;
    }

    /**
     * Update the query variable in the $_POST object.
     * Useful for passing on parsing to ARC, since $_POST is what ARC reads
     * @param string $query
     */
    function setQueryInPost( $query ) {
        // Set the query in $_POST, so that ARC will grab the modified query
        $_POST['query'] = $query;
    }

    /**
     * Update the output (type) variable in the $_POST object.
     * Useful for passing on parsing to ARC, since $_POST is what ARC reads
     * @param string $type
     */
    function setOutputTypeInPost( $type ) {
        $_POST['output'] = $type;
    }
}
