<?php

/**
 * Used to seperated the data access layer
 *
 * @copyright INRIA-LORIA-ECOO project
 * 
 * @author CUCUTEANU
 */
class DSMWRevisionManager {

    /**
     *
     * @param <String> $rev_id Revision id
     * @return boModel
     */
    static function loadModel( $rev_id ) {
        try {
            if ( $rev_id != 0 ) {
                $dao = new dao();
                return $dao->loadModel( $rev_id );
            }
            else {
                return new boModel();
            }
        } catch ( Exception $e ) {
        	die($e->getMessage());
            throw new MWException( __METHOD__ . ' db access problems,
if this page existed before the DSMW installation,
maybe it has not been processed by DSMW' );
        }

    }

    /**
     *
     * @param <String> $rev_id
     * @param <String> $sessionId
     * @param <Object> $model boModel
     * @param <Object> $blobCB=0 (should have been a causal barrier object but
     * not used yet)
     */
    static function storeModel( $rev_id, $sessionId, $model, $blobCB ) {
        wfDebugLog( 'p2p', ' -> store model into revid : ' . $rev_id . ' sessionid : ' . $sessionId . ' model : ' . $model->getText() );
        try {
            $dao = new dao();
            $dao->storeModel( $rev_id, $sessionId, $model, $blobCB );
        } catch ( Exception $e ) {
        	die($e->getMessage());
            throw new MWException( __METHOD__ . ' db access problems' );
        }
    }
    
}

/**
 * DAO used to load and store the boModel
 *
 * @copyright INRIA-LORIA-ECOO project
 * 
 * @author Jean-Philippe Muller
 */
class dao {

    /**
	 * To get the model of the given revision
	 * --> A model is the logootPosition array corresponding to this revision
	 * @param <Integer> $rev_id
	 * @return <Object> model object
	 */
    function loadModel( $rev_id ) {
        wfProfileIn( __METHOD__ );
        
        $dbr = wfGetDB( DB_SLAVE );
        
        $model1 = $dbr->selectField(
        	'model',
        	'blob_info',
        	 array(
        		'rev_id' => $rev_id
        	),
        	__METHOD__
        );
        
        if ( $model1 === false ) {
        	throw new MWException( __METHOD__ . ': This page has not been processed by DSMW' );
        }
            
        $model = unserialize( $model1 );
        
        wfProfileOut( __METHOD__ );
        
        return $model;
    }

	/**
     * integrate model to DB
     * @param <Integer> $rev_id
     * @param <String> $sessionId
     * @param <object> $model
     * @param <Object> $blobCB (should have been a causal barrier object but
     * not used yet)
     */
    function storeModel( $rev_id, $sessionId, $model, $blobCB ) {
    	wfProfileIn( __METHOD__ );
    	
        $model1 = serialize( $model );
        
        $dbw = wfGetDB( DB_MASTER );
        $dbw->insert( 'model', array(
            'rev_id'        => $rev_id,
            'session_id'    => $sessionId,
            'blob_info'     => $model1,
            'causal_barrier'  => $blobCB,
            ), __METHOD__ );


        wfProfileOut( __METHOD__ );
    }

}

/**
 * Model of a wiki page.
 * Represented by a list of page's lines and a list of the logootPositions
 * associated to each line
 *
 * @copyright INRIA-LORIA-ECOO project
 * @author Muller Jean-Philippe
 */
class boModel {
	
    private $positionList = array();
    private $lineList = array();

    public function setPositionlist( $positionList ) {
        $this->positionList = $positionList;
    }

    public function setLinelist( $lineList ) {
        $this->lineList = $lineList;
    }

    public function getPositionlist() {
        return $this->positionList;
    }

    public function getLinelist() {
        return $this->lineList;
    }

    /**
	 * Transforms the text array into a string.
	 * 
	 * @return string
	 */
    public function getText() {
    	return implode( "\n", $this->lineList );
    }
    
}
