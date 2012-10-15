<?php
if ( !defined( 'MEDIAWIKI' ) ) {
// Eclipse helper - will be ignored in production
    require_once( 'ApiQueryBase.php' );
}

/**
 * Description of ApiQueryPatch
 * return the patch contain given by the parameter patchId
 *
 * @copyright INRIA-LORIA-ECOO project
 * @author hantz & Morel Émile
 */
class ApiQueryPatch extends ApiQueryBase {
    public function __construct( $query, $moduleName ) {
        parent :: __construct( $query, $moduleName, 'pa' );
    }
    public function execute() {
        $this->run();
    }

    public function encodeRequest( $request ) {
        $req = str_replace(
            array( '-', '#', "\n", ' ', '/', '[', ']', '<', '>', '&lt;', '&gt;', '&amp;', '\'\'', '|', '&', '%', '?', '{', '}' ),
            array( '-2D', '-23', '-0A', '-20', '-2F', '-5B', '-5D', '-3C', '-3E', '-3C', '-3E', '-26', '-27-27', '-7C', '-26', '-25', '-3F', '-7B', '-7D' ), $request );
        return $req;
    }
    private function run() {
        global $wgServerName, $wgScriptPath;

        $params = $this->extractRequestParams();
        wfDebugLog( 'p2p', 'ApiQueryPatch params ' . $params['patchId'] );

        $array = array( 1 => 'id', 2 => 'onPage', 3 => 'operation', 4 => 'previous', 5 => 'siteID', 6 => 'mime', 7 => 'size', 8 => 'url', 9 => 'DateAtt', 10 => 'siteUrl', 11 => 'causal' );
        $array1 = array( 1 => 'patchID', 2 => 'onPage', 3 => 'hasOperation', 4 => 'previous', 5 => 'siteID', 6 => 'mime', 7 => 'size', 8 => 'url', 9 => 'DateAtt', 10 => 'siteUrl', 11 => 'causal' );

        $query = '';

        for ( $j = 1; $j <= count( $array1 ); $j++ ) {
            $query = $query . '?' . $array1[$j] . '
';
        }

        $res = utils::getSemanticQuery( '[[patchID::' . $params['patchId'] . ']]', $query );

        $count = $res->getCount();
        for ( $i = 0; $i < $count; $i++ ) {
            $row = $res->getNext();
            if ( $row === false ) break;
            for ( $j = 1; $j <= count( $array ); $j++ ) {
                if ( $j == 3 ) {
                    $col = $row[$j]->getContent();// SMWResultArray object
                    foreach ( $col as $object ) {// SMWDataValue object
                        $wikiValue = $object->getWikiValue();
                        $op[] = $wikiValue;
                    }
                    $results[$j] = $op;
                }
                else {
                    $col = $row[$j]->getContent();// SMWResultArray object
                    foreach ( $col as $object ) {// SMWDataValue object
                        $wikiValue = $object->getWikiValue();
                        $results[$j] = $wikiValue;
                    }
                }
            }
        }
        $result = $this->getResult();
        // $data = str_replace('"', '', $data);

        // $data = explode('!',$data);

        if ( $results[1] ) {
            for ( $i = 1; $i <= count( $array ); $i++ ) {
                if ( $results[$i] != null ) {
                if ( $i == 2 ) {
                    $title = trim( $results[$i], ":" );
                    $result->addValue( array( 'query', $this->getModuleName() ), $array[$i], $title );
                }
                elseif ( $i == 3 ) {
                    $op = $results[$i];
                    $result->setIndexedTagName( $op, $array[$i] );
                    $result->addValue( 'query', $this->getModuleName(), $op );
                }
		else
		    $result->addValue( array( 'query', $this->getModuleName() ), $array[$i], $results[$i] );
                }
            }
        }
    }

    public function getAllowedParams() {
        global $wgRestrictionTypes, $wgRestrictionLevels;

        return array (
        'patchId' => array (
        ApiBase :: PARAM_TYPE => 'string',
        ),
        );
    }

    public function getParamDescription() {
        return array(
        'patchId' => 'which patch id must be returned',
        );
    }

    public function getDescription() {
        return 'Return information of patch.';
    }

    public function getExamples() {
        return array(
        'api.php?action=query&meta=patch&papatchId=1&format=xml',
        );
    }

    public function getVersion() {
        return __CLASS__ . ': $Id: ApiQueryPatch.php 77753 2010-12-05 00:44:17Z jeroendedauw $';
    }
}
