<?php

/**
 * logootPosition is an array of logootId(s) which is assigned to a line
 * of an article
 *
 * @copyright INRIA-LORIA-ECOO project
 * @author muller jean-philippe
 */

class LogootPosition {
    private $mPosition = array();

    public function __construct( $pos ) {
        $this->mPosition = $pos;
    }

    public function compareTo( $position ) {

        $i = 0;
        $thisPos = $this->mPosition;
        $max = min( $this->size(), $position->size() );

        while ( $i < $max ) {

            if ( $thisPos[$i]->compareTo( $position->mPosition[$i] ) != 0 )
                break;
            $i++;
        }
        if ( $i >= $this->size() && $i >= $position->size() )return 0;

        if ( $i >= $this->size() )return -1;

        if ( $i >= $position->size() )return 1;


        return $thisPos[$i]->compareTo( $position->mPosition[$i] );

    }

    public function getSlot( $position1, $position2, $nb ) {
    $slot = 0;
    $i = 0;
    if ( $position1->compareTo( $position2 ) != -1 )return -1;

    while ( $position1[$i]->compareTo( $position2[$i] ) == 0
        && $i < $position1->size() ) {
        $i++;
    }
    if ( $i >= $position1->size() ) {}
    return $slot;
    }

    public function get( $i ) {// returns a logootId
        if ( $i < $this->size() )
        return $this->mPosition[$i];
        else {
            $Id_Min = new LogootId( INT_MIN, INT_MIN );
            return $Id_Min; }
    }

    public function getThisPosition() {
        return $this->mPosition;
    }

    public function set( $pos, $value, $sid/*, $clock*/ ) {
        if ( $pos < $this->size() ) {
            unset ( $this->mPosition[$pos] );
            $this->mPosition[$pos] = new LogootId( $value, $sid/*,$clock*/ );
        } else {
            $this->mPosition[] = new LogootId( $value, $sid/*,$clock*/ );
        }
    }

    public function add( $id ) {
        $this->mPosition[] = $id;
    }

    public function add1( $pos, $value, $sid/*, $clock*/ ) {
        if ( $pos < $this->size() ) {
            $tmp1 = new Math_BigInteger( $this->get( $pos )->getInt() );
            $tmp = $tmp1->add( $value );
            unset ( $this->mPosition[$pos] );
            $this->mPosition[$pos] = new LogootId( $tmp->toString(), $sid/*,$clock*/ );
        } else {
            $this->mPosition[] = new LogootId( $tmp->toString(), $sid/*,$clock*/ );
        }
    }

   public function size() {
       return count( $this->mPosition );
   }

   public function  __clone() {
       return new LogootPosition( $this->mPosition );
   }

    /**
     * position size comparison, returns size of the smallest position
     */
    function vectorMinSizeComp( $position ) {
        if ( $this->size() > $position->size() ) {
            return $position->size();
        }
        elseif ( $position->size() > $this->size() ) {
            return $this->size();
        }
        else return $this->size();
    }

/**
 * postion size comparison, returns size of the position(if same) or -1
 */
    function vectorSizeComp( $position ) {
        if ( $this->size() > $position->size() ) {
            return -1;
        }
        elseif ( $position->size() > $this->size() ) {
            return -1;
        }
        else return $this->size();
    }

    /**
     * id comparison
     */
    function equals( $id1, $id2 ) {

        if ( $id1->compareTo( $id2 ) == 0 ) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * position comparison (n ids position)
     */
    function nEquals( $position ) {

        // length test
        $eq = 1;
        $size = $this->vectorSizeComp( $position );

        if ( $size == -1 ) {// different size

            $eq = 0;


        }// end if sizecomp
        else {// same size

            for ( $i = 0; $i < $size; $i++ ) {
                if ( $this->equals( $this->mPosition[$i], $position->mPosition[$i] ) == false ) {
                    $eq = 0;
                }
            }// end for
        }
        // fclose($handle);
        return $eq;
    }

    /**
     * id comparison
     */
    function greaterThan( $id1, $id2 ) {

        if ( $id1->compareTo( $id2 ) == 1 ) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * position comparison (n ids position)
     */
    function nGreaterThan( $position ) {

        $lt = 0;
        $size = $this->vectorMinSizeComp( $position );// size of the smallest vector

        for ( $i = 0; $i < $size; $i++ ) {

            if ( $this->greaterThan( $this->mPosition[$i], $position->mPosition[$i] ) == true ) {
                $lt = 1;
            }
        }// end for

        if ( $lt == 0 ) {
            if ( $this->size() > $position->size() ) {
                $lt = 1;
            }
        }
        return $lt;
    }

    // id comparison
    function lessThan( $id1, $id2 ) {

        if ( $id1->compareTo( $id2 ) == -1 ) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * position comparison (n ids position)
     */
    function nLessThan( $position ) {

        $lt = 0;
        $eq = 0;
        $size = $this->vectorMinSizeComp( $position );// size of the smallest vector

        for ( $i = 0; $i < $size; $i++ ) {

            if ( $this->lessThan( $this->mPosition[$i], $position->mPosition[$i] ) == true ) {
                $lt = 1;
            }
            if ( $this->equals( $this->mPosition[$i], $position->mPosition[$i] ) ) {
                $eq = 1;
            }
        }// end for

        if ( $lt == 0 ) {
            if ( $eq == 1 && $this->equals( $this->mPosition[$size -1], $position->mPosition[$size -1] ) ) {
                if ( $position->size() > $this->size() ) {
                    $lt = 1;
                }
            }
        }

        return $lt;
    }

    function toString() {
        $string = "";
        foreach ( $this->mPosition as $id ) {
            $string .= $id->toString() . " ";
        }
        // $string.=$this->mClock." ".$this->mVisibility;
        return $string;
    }

}
