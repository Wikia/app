<?php
if ( !defined( 'MEDIAWIKI' ) ) {
// Eclipse helper - will be ignored in production
    require_once( 'ApiQueryBase.php' );
}


/**
 * Description of ApiQueryPatch
 * return the changeSet which has the previous changeSet given by
 * the parametere changeSet
 *
 * @copyright INRIA-LORIA-ECOO project
 * @author hantz
 */
class ApiQueryChangeSet extends ApiQueryBase {
    public function __construct( $query, $moduleName ) {
        parent :: __construct( $query, $moduleName, 'cs' );
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
        wfDebugLog( 'p2p', 'ApiQueryChangeSet' );
        $params = $this->extractRequestParams();


        $res = utils::getSemanticQuery( '[[inPushFeed::PushFeed:' . $params['pushName'] . ']][[previousChangeSet::' . $params['changeSet'] . ']]', '?changeSetID
?hasPatch' );
        $count = $res->getCount();
        for ( $i = 0; $i < $count; $i++ ) {

            $row = $res->getNext();
            if ( $row === false ) break;
            $changesetId = $row[1];
            $col = $changesetId->getContent();// SMWResultArray object
            foreach ( $col as $object ) {// SMWDataValue object
                $wikiValue = $object->getWikiValue();
                $results[1] = $wikiValue;
            }
            $hasPatch = $row[2];
            $col = $hasPatch->getContent();// SMWResultArray object
            foreach ( $col as $object ) {// SMWDataValue object
                $wikiValue = $object->getWikiValue();
                $patches[] = $wikiValue;
            }
            $results[2] = $patches;
        }

        $result = $this->getResult();

        $CSID = $results[1];
        wfDebugLog( 'p2p', '  -> CSID : ' . $CSID );
        if ( $CSID ) {
            $data = $results[2];

            $result->setIndexedTagName( $data, 'patch' );
            $result->addValue( array( 'query', $this->getModuleName() ), 'id', $CSID );
            $result->addValue( 'query', $this->getModuleName(), $data );
        }
    }

    public function getAllowedParams() {
        global $wgRestrictionTypes, $wgRestrictionLevels;

        return array (
        'pushName' => array (
        ApiBase :: PARAM_TYPE => 'string',
        ),
        'changeSet' => array (
        ApiBase :: PARAM_TYPE => 'string',
        ),

        );
    }

    public function getParamDescription() {
        return array(
        'pushName' =>  'name of the related push feed',
        'changeSet' =>  'last changeSet (id) ',
        );
    }

    public function getDescription() {
        return 'retunr the previous changeset of the changeset parameter';
    }

    public function getExamples() {
        return array(
        'api.php?action=query&meta=changeSet&cspushName=push&cschangeSet=localhost/wiki12&format=xml',
        );
    }

    public function getVersion() {
        return __CLASS__ . ': $Id: ApiQueryChangeSet.php 77753 2010-12-05 00:44:17Z jeroendedauw $';
    }
}
