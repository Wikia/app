<?php

/**
 * @copyright INRIA-LORIA-ECOO project
 * @author muller jean-philippe
 */
interface Clock {
    public function load();

    public function store();

    public function getValue();

    public function setValue( $i );

    public function incrementClock();
}

/**
 * Persistent clock
 *
 * @copyright INRIA-LORIA-ECOO project
 * @author muller jean-philippe
 */
class DSMWPersistentClock implements Clock {

    public $mClock;


    public function __construct() {
      ;

    }

    public function __destruct() {
        $this->mClock = 0;
    }

    public function getValue() {
        return $this->mClock;
    }

    public function setValue( $i ) {
        $this->mClock = $i;
    }

    public function incrementClock() {
        $this->mClock = $this->mClock + 1;
    }

    function load() {
    $db = wfGetDB( DB_SLAVE );
        $this->mClock = $db->selectField( 'p2p_params', 'value' );
}

function store() {

        $dbw = wfGetDB( DB_MASTER );
        $dbw->update( 'p2p_params', array(
            'value'        => $this->mClock,
            ), '*', __METHOD__ );

    }

}
