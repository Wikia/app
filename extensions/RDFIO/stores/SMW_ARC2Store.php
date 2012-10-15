<?php

if ( !defined( 'MEDIAWIKI' ) ) {
    die( 'Not a valid entry point.' );
}

global $IP;

require_once( "$IP/extensions/SemanticMediaWiki/includes/storage/SMW_SQLStore2.php" );

/**
 * SMWARC2Store extends SMWSQLStore2 and forwards all update/delete to ARC2 via SPARQL+
 * queries. The class was based on JosekiStore in the SparqlExtension, which in turn is
 * losely based on/insipred by RAPStore.
 * @author samuel.lampa@gmail.com
 * @package RDFIO
 */
class SMWARC2Store extends SMWSQLStore2 {
    protected $arc2store;

    public function __construct() {
        parent::__construct();
        global $wgDBserver, $wgDBname, $wgDBuser, $wgDBpassword, $smwgARC2StoreConfig;

        /* instantiation */
        $this->arc2store = ARC2::getStore( $smwgARC2StoreConfig );
    }

    /**
     * wraps removeDataForURI
     * @param $subject
     */
    function deleteSubject( Title $subject ) {
        $subject_uri = SMWExporter::expandURI( $this->getURI( $subject ) );
        $this->removeDataForURI( $subject_uri );

        return parent::deleteSubject( $subject );
    }

    /**
     * deletes triples that have $uri as subject
     * @param $uri
     */
    function removeDataForURI( $uri ) {
        $sparqlUpdateText = "DELETE { <" . $uri . "> ?x ?y . }";
        wfDebugLog( 'SPARQL_LOG', "===DELETE===\n" . $sparqlUpdateText );
        $response = $this->do_arc2_query( $sparqlUpdateText );
        return $response;
    }

    /**
     * Does update. First deletes, then inserts.
     * @param $data
     */
    function updateData( SMWSemanticData $data ) {
        $export = SMWExporter::makeExportData( $data );
        $subject_uri = SMWExporter::expandURI( $export->getSubject()->getUri() );

        // remove subject from triple store
        $this->removeDataForURI( $subject_uri );

        $triple_list = $export->getTripleList();

        $sparqlUpdateText = "INSERT INTO <> {\n";

        foreach ( $triple_list as $triple ) {

            $subject = $triple[0];
            $predicate = $triple[1];
            $object = $triple[2];

            $obj_str = "";
            $sub_str = "";
            $pre_str = "";

            if ( $object instanceof SMWExpLiteral ) {
            	// @todo FIXME: Add escaping for results of getLexicalForm()?
                $obj_str = "\"" . $object->getLexicalForm() . "\"" . ( ( $object->getDatatype() == "" ) ? "" : "^^<" . $object->getDatatype() . ">" );
            } elseif ( $object instanceof SMWExpResource ) {
                $obj_str = "<" . SMWExporter::expandURI( $object->getUri() ) . ">";
            } else {
                $obj_str = "\"\"";
            }

            if ( $subject instanceof SMWExpResource ) {
                $sub_str = "<" . SMWExporter::expandURI( $subject->getUri() ) . ">";
            }

            if ( $predicate instanceof SMWExpResource ) {
                $pre_str = "<" . SMWExporter::expandURI( $predicate->getUri() ) . ">";
            }

            $sparqlUpdateText .= $sub_str . " " . $pre_str . " " . $obj_str . " .\n";
        }
        $sparqlUpdateText .= "}\n";

        // echo "<p style='background: #ccddff'><pre>SPARQL Update text:" . $this->unhtmlify( $sparqlUpdateText ) . " ... tjohoo</pre></p>";
        // var_dump();
        // TODO Debug-code

        wfDebugLog( 'SPARQL_LOG', "===INSERT===\n" . $sparqlUpdateText );

        $response = $this->do_arc2_query( $sparqlUpdateText );

        return parent::updateData( $data );
    }

    /**
     * Insert new pages into endpoint. Used to import data.
     * @param $title
     */
    function insertData( Title $title, $pageid ) {
        $newpage = SMWDataValueFactory::newTypeIDValue( '_wpg' );
        $newpage->setValues( $title->getDBkey(), $title->getNamespace(), $pageid );
        $semdata = $this->getSemanticData( $newpage );
        $this->updateData( $semdata );
    }

    /**
     * Move/rename page
     * @param $oldtitle
     * @param $newtitle
     * @param $pageid
     * @param $redirid
     */
    function changeTitle( Title $oldtitle, Title $newtitle, $pageid, $redirid = 0 ) {

        // Save it in parent store now!
        // We need that so we get all information correctly!
        $result = parent::changeTitle( $oldtitle, $newtitle, $pageid, $redirid );

        // delete old stuff
        $old_uri = SMWExporter::expandURI( $this->getURI( $oldtitle ) );
        $this->removeDataForURI( $old_uri );

        $newpage = SMWDataValueFactory::newTypeIDValue( '_wpg' );
        $newpage->setValues( $newtitle->getDBkey(), $newtitle->getNamespace(), $pageid );
        $semdata = $this->getSemanticData( $newpage );
        $this->updateData( $semdata );

        $oldpage = SMWDataValueFactory::newTypeIDValue( '_wpg' );
        $oldpage->setValues( $oldtitle->getDBkey(), $oldtitle->getNamespace(), $redirid );
        $semdata = $this->getSemanticData( $oldpage );
        $this->updateData( $semdata, false );

        return $result;
    }

    /**
     * no setup required
     * @param unknown_type $verbose
     */
    function setup( $verbose = true ) {
        return parent::setup( $verbose );
    }


    function drop( $verbose = true ) {
        return parent::drop();
    }

    /**
     * Communicates with joseki update service via post
     * TODO: Deprecated, replaced by do_arc2_query
     * @param $requestString
     */
    function do_arc2_post( $requestString ) {
        $postdata = http_build_query(
        array(
                'request' => $requestString
        )
        );
        $opts = array( 'http' =>
        array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
        )
        );

        $context  = stream_context_create( $opts );
        $result = file_get_contents( SPARQL_ENDPOINT_UPDATE_URL, false, $context );
        return $result;
    }


    /**
     * Communicates with ARC2 RDF Store
     * @param $requestString
     */
    function do_arc2_query( $requestString ) {

        $q = $requestString;
        $rs = $this->arc2store->query( $q );
        $result = $rs;

        // echo( "<pre>" . $this->unhtmlify( $requestString ) . "</pre>" );
        // echo( "<pre>ERRORS:<br>");
        // print_r($this->arc2store->getErrors());
        // echo("</pre>");

        return $result;
    }

    /**
     * Convert '<' and '>' to '&lt;' and '&gt;' instead
     * @param string $instring
     * @return string $outstring
     */
    function unhtmlify( $instring ) {
        $outstring = str_replace( '<', '&lt;', $instring );
        $outstring = str_replace( '>', '&gt;', $outstring );
        return $outstring;
    }

    /**
     * Having a title of a page, what is the URI that is described by that page?
     * The result still requires expandURI()
     * @param string $title
     * @return string $uri
     */
    protected function getURI( $title ) {
        $uri = "";
        if ( $title instanceof Title ) {
            $dv = SMWDataValueFactory::newTypeIDValue( '_wpg' );
            $dv->setTitle( $title );
            $exp = $dv->getExportData();
            $uri = $exp->getSubject()->getUri();
        } else {
            // There could be other types as well that we do NOT handle here
        }

        return $uri; // still requires expandURI()
    }
}

