<?php

/**
 * logootId is used to compose a logootPosition, necessary for the
 * logoot algorithm
 *
 * @copyright INRIA-LORIA-ECOO project
 * @author muller jean-philippe
 */
class LogootId {
    private $mInt;
    private $mSessionId;

    public function __construct( $int, $sessionId/*, $clock*/ ) {
        $this->mInt = $int;
        $this->mSessionId = $sessionId;

    }

    public static function IdMin() {
        $IdMin = new LogootId( INT_MIN, INT_MIN/*, INT_MIN*/ );
        return $IdMin;
    }

    public static function IdMax() {
        $IdMax = new LogootId( INT_MAX, INT_MAX/*, INT_MAX*/ );
        return $IdMax;
    }

    public function getSessionId() {
        return $this->mSessionId;
    }

    public function setSessionId( $sessionId ) {
        $this->mSessionId = $sessionId;
    }

    public function getInt() {
        return $this->mInt;
    }

    public function setInt( $int ) {
        $this->mInt = $int;
    }

    public function compareTo( $id ) {
        $logid = $id;

        $val1 = new Math_BigInteger( $this->mInt );
        $val2 = new Math_BigInteger( $logid->mInt );

        if ( ( $val1->compare( $val2 ) ) < 0 )
            return -1;
        else if ( ( $val1->compare( $val2 ) ) > 0 )
            return 1;
        else if ( strcmp( $this->mSessionId, $logid->mSessionId ) < 0 )
            return -1;
        else if ( strcmp( $this->mSessionId, $logid->mSessionId ) > 0 )
            return 1;
        return 0;
    }

    public function toString() {
        return "(" . $this->mInt . ":" . $this->mSessionId . ")";
    }

    public function __clone() {
        return new LogootId( $this->mInt, $this->mSessionId );
    }

//    public function gmpToStr(){
//        return $this->setInt(gmp_strval($this->mInt));
//    }


}
