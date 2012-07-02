<?php

/**
 * Implementation of the logoot algorithm
 *
 * @copyright INRIA-LORIA-ECOO project
 * @author jean-Philippe Muller
 */
class logootEngine implements logoot {
    private $model;

    function __construct( $model ) {
        $this->model = $model;
    }

    /**
     *
     * @param <array or object> $opList operation list or operation object
     */
    public function integrate( $opList ) {
        wfDebugLog( 'p2p', ' - function logootEngine::integrate ' );
        // if it is an operation, we put it in an array, as if it was an op list
        if ( !is_array( $opList ) )$opList = array( $opList );
        foreach ( $opList as $operation ) {
            if ( $operation instanceof LogootIns ) {
                $result = $this->dichoSearch1( $operation->getLogootPosition() );
                wfDebugLog( 'p2p', ' - integrate insert dicho result: ' . $result );
                if ( is_array( $result ) ) {
        /* position array begins at key '1' which corresponds with line1
         * array begins at key '1' which corresponds with line1
         */


                    $this->add( $result[1], $operation->getLogootPosition() );
                    $this->addLine( $result[1], $operation->getLineContent() );

                } else {
                    if ( $result == -1 ) { /* if the value is less than the first element of
                              the array*/

                        $this->add( '1', $operation->getLogootPosition() );
                        $this->addLine( '1', $operation->getLineContent() );

                    }
                    elseif ( $result == -2 ) { /* if the value is greater than the last element of
                              the array*/
                        $line = $this->size();
                        $this->add( $line + 1, $operation->getLogootPosition() );
                        $this->addLine( $line + 1, $operation->getLineContent() );

                    }
                    else { /*the value is found in the array. It should not be, because
         * the logootid has to be unique
         */
                        throw new MWException( __METHOD__ . ' Logoot algorithm error,
                                position exists yet!' );
                    }
                }

            }
            elseif ( $operation instanceof LogootDel ) {
                $result = $this->dichoSearch1( $operation->getLogootPosition() );
                wfDebugLog( 'p2p', ' - integrate delete dicho result: ' . $result );
                if ( is_numeric( $result ) ) {
                    $this->delete( $result );
                    $this->deleteLine( $result );

                }

            }
        }// end foreach
        return $this->model;
    }

    /**
     *Calculate the diff between two texts
     * Returns a list of operations applied on this blobinfo(document model)
     * For each operation (insert or delete), an operation object is created
     * an applied via the 'integrateBlob' function call. These objects are
     *  stored in an array and returned for further implementations.
     *
     * NB: the direct implementation is necessary because the generation of
     * a new position (LogootPosition) is based on the positions of the model
     * (BlobInfo) and so we have to update (immediat integration) this model after
     * each operation (that we get from the difference engine)
     * @global <Object> $wgContLang
     * @param <String> $oldtext
     * @param <String> $newtext
     * @param <Integer> $firstRev if it's the first revision
     * @return <array> list of logootOperation
     */
    public function generate( $oldText, $newText ) {
    // first revision, if model is empty
        if ( count( $this->model->getPositionlist() ) == 0
            && count( $this->model->getPositionlist() ) == 0 ) $firstRev = 1;
        else $firstRev = 0;
        // $blobInfo = $this;

/* explode into lines*/
        $ota = explode( "\n", $oldText  );
        $nta = explode( "\n", $newText  );
        $counter = 0;

        if ( count( $ota ) == 1 && $ota[0] == "" ) unset ( $ota[0] );

        $listOp = array();
        $diffs = new Diff1( $ota, $nta );

/* convert 4 operations into 2 operations*/
        foreach ( $diffs->edits as $operation ) {
            switch ( $operation->type ) {
                case "add":
                    $adds = $operation->closing;
                    ksort( $adds, SORT_NUMERIC );

                    foreach ( $adds as $key => $lineins ) {

                        $lineNb = $key;

                        if ( $firstRev == 1 ) {
                            $posMin = new LogootPosition( array( LogootId::IdMin() ) );
                            $posMax = new LogootPosition( array( LogootId::IdMax() ) );
                            $positions = $this->getLogootPosition( $posMin, $posMax, new Math_BigInteger( "1" ), $sid = session_id() );
                            $position = $positions[0];
                            $firstRev = 0;
                        }
                        else {
                            $start = $this->getPrevPosition( $lineNb );
                            $end = $this->getNextPosition( $lineNb );
                            $positions = $this->getLogootPosition( $start, $end, new Math_BigInteger( "1" ), $sid = session_id() );
                            $position = $positions[0];
                        }
                        $LogootIns = new LogootIns( $position, $lineins );
                        $this->integrate( $LogootIns/*, $clock*/ );

                        $listOp[] = $LogootIns;

                        $counter = $counter + 1;
                    }
                    break;
                case "delete":
                    foreach ( $operation->orig as $key2 => $linedel ) {
                        $lineNb2 = $key2 + $counter;
                        $position = $this->getPosition( $lineNb2 );
                        // $diffElements[]=$linedel;
                        if ( !is_null( $position ) ) {
                            $LogootDel = new LogootDel( $position, $linedel );
                            $this->integrate( $LogootDel/*, $clock*/ );
                            $listOp[] = $LogootDel;
                        }
                        $counter = $counter - 1;
                    }

                    break;
                case "copy":
                    break;
                case "change":
                    foreach ( $operation->orig as $key3 => $linedel1 ) {
                        $lineNb3 = $key3 + $counter;

                        $position = $this->getPosition( $lineNb3 );
                        if ( !is_null( $position ) ) {
                            $LogootDel1 = new LogootDel( $position, $linedel1 );
                            $this->integrate( $LogootDel1/*, $clock*/ );
                            $listOp[] = $LogootDel1;
                        }
                        $counter = $counter - 1;
                    }
                    $adds1 = $operation->closing;
                    ksort( $adds1, SORT_NUMERIC );

                    foreach ( $adds1 as $key1 => $lineins1 ) {


                        $lineNb4 = $key1;
                        if ( $firstRev == 1 ) {
                            $posMin = new LogootPosition( array( LogootId::IdMin() ) );
                            $posMax = new LogootPosition( array( LogootId::IdMax() ) );
                            $positions = $this->getLogootPosition( $posMin, $posMax, new Math_BigInteger( "1" ), $sid = session_id() );
                            $position = $positions[0];
                            $firstRev = 0;
                        }
                        else {
                            $start = $this->getPrevPosition( $lineNb4 );
                            $end = $this->getNextPosition( $lineNb4 );
                            $positions = $this->getLogootPosition( $start, $end, new Math_BigInteger( "1" ), $sid = session_id() );
                            $position = $positions[0];
                        }

                        $LogootIns1 = new LogootIns( $position, $lineins1 );
                        $this->integrate( $LogootIns1/*, $clock*/ );
                        $listOp[] = $LogootIns1;

                        $counter = $counter + 1;

                    }

                    break;
            }
        }

        return $listOp;
    }

    /**
     * generation of a position, logoot algorithm
     * @param <Object> $start is the previous logootPosition
     * @param <Object> $end is the next logootPosition
     * @param <Integer> $N number of positions generated (should be 1 in our case)
     * @param <Object> $sid session id
     * @return <Object> a logootPosition between $start and $end
     */
    private function getLogootPosition( $start, $end, $N, $sid ) {
    $result = array();
        $Id_Max = LogootId::IdMax();
        $Id_Min = LogootId::IdMin();
        $i = 0;

        $pos = array();
        $currentPosition = new LogootPosition( $pos );// voir constructeur

        $inf = new Math_BigInteger( "0" );
        $sup = new Math_BigInteger( "0" );

        $isInf = false;

        while ( true ) {
            $inf = new Math_BigInteger( $start->get( $i )->getInt() );

            if ( $isInf == true )
                $sup = new Math_BigInteger( INT_MAX );
            else
                $sup = new Math_BigInteger( $end->get( $i )->getInt() );

            $tmpVal = $sup->subtract( $inf );
            $tmpVal1 = $tmpVal->subtract( new Math_BigInteger( "1" ) );
            if ( ( $tmpVal1->compare( $N ) ) > 0 ) {
            //				inf = start.get(i).getInteger();
            //				sup = end.get(i).getInteger();
                break;
            }

            $currentPosition->add( $start->get( $i ) );

            $i++;

            if ( $i == $start->size() )
                $start->add( $Id_Min );

            if ( $i == $end->size() )
                $end->add( $Id_Max );

            if ( ( $inf->compare( $sup ) ) < 0 )$isInf = true;

        }

        $binf = $inf->add( new Math_BigInteger( "1" ) );
        $bsup = $sup->subtract( new Math_BigInteger( "1" ) ) ;
        $slot = $bsup->subtract( $binf ) ;
        $stepTmp = $slot->divide( $N );
        $step = $stepTmp[0];// quotient, [1] is the remainder

        $old = clone $currentPosition;

        if ( ( $step->compare( new Math_BigInteger( INT_MAX ) ) ) > 0 ) {
            $lstep = new Math_BigInteger( INT_MAX );

            $r = clone $currentPosition;

            $tmpVal2 = $inf->random( $inf, $sup );
            $r->set( $i, $tmpVal2->toString(), $sid/*, $clock*/ );

            $result[] = $r;// result est une arraylist<Position>
            return $result;
        } else
            $lstep = $step;

        if ( ( $lstep->compare( new Math_BigInteger( "0" ) ) ) == 0 ) {
            $lstep = new Math_BigInteger( "1" );
        }

        $p = clone $currentPosition;

        $p->set( $i, $inf->toString(), $sid/*, $clock*/ );
        $tmpVal3 = (int)$N->toString();
        for ( $j = 0; $j < $tmpVal3; $j++ ) {
            $r = clone $p;
            if ( !( ( $lstep->compare( new Math_BigInteger( "1" ) ) ) == 0 ) ) {

            $tmpVal4 = new Math_BigInteger( $p->get( $i )->getInt() );
            $tmpVal5 = $tmpVal4->add( $lstep );// max
            $tmpVal6 = new Math_BigInteger( $p->get( $i )->getInt() );// min
            $add = $tmpVal6->random( $tmpVal6, $tmpVal5 );

                $r->set( $i, $add->toString(), $sid/*, $clock*/ );
            } else
                $r->add1( $i, new Math_BigInteger( "1" ), $sid/*, $clock*/ );


            $result[] = clone $r;// voir
            $old = clone $r;
            $tmpVal7 = new Math_BigInteger( $p->get( $i )->getInt() );
            $tmpVal7 = $tmpVal7->add( $lstep );
            $p->set( $i, $tmpVal7->toString(), $sid/*,$clock*/ );

        }
        return $result;
    }


    /**
     * to get the previous position (logootPosition)
     * @param <Integer> $lineNumber
     * @return <Object> LogootPosition
     */
    private function getPrevPosition( $lineNumber ) {
        $listIds = $this->model->getPositionList();
        $exists = false;
        $predecessor;


        for ( $i = $lineNumber -1; $i > 0; $i-- ) {
            if ( isset ( $listIds[$i] ) ) {
                $exists = true;
                $predecessor = $i;
                break;
            }
        }

        // if there is a predecessor
        if ( $exists == true ) {
            return $listIds[$predecessor];
        }
        else {
            $posMin = new LogootPosition( array( LogootId::IdMin() ) );
            return $posMin;
        }
    }

    // to get the next position
    private function getNextPosition( $lineNumber ) {
        $listIds = $this->model->getPositionList();

        if ( isset ( $listIds[$lineNumber] ) ) {
            return $listIds[$lineNumber];
        }
        else {
            $posMax = new LogootPosition( array( LogootId::IdMax() ) );
            return $posMax;
        }
    }

    /**
     * to get a position
     * @param <Integer> $lineNumber
     * @return <Object> logootPosition
     */
    function getPosition( $lineNumber ) {
        $listIds = $this->model->getPositionlist();
        return $listIds[$lineNumber];
    }

    /**
     * to add a position the model
     * @param <Integer> $lineNumber
     * @param <Object> $position
     */
    private function add( $lineNumber, $position ) {
        wfDebugLog( 'p2p', ' - function logootEngine::' . __METHOD__ );
        $listIds = $this->model->getPositionlist();

        // position shifting
        $nbLines = count( $listIds );

        for ( $i = $nbLines + 1; $i > $lineNumber; $i-- ) {
            $listIds[$i] = $listIds[$i -1];
        }
        unset ( $listIds[$lineNumber] );
        $listIds[$lineNumber] = $position;

        $this->model->setPositionlist( $listIds );
    }

    /**
     * to add a line to the model
     * @param <Integer> $lineNumber
     * @param <Object> $line
     */
    private function addLine( $lineNumber, $line ) {
        wfDebugLog( 'p2p', ' - function logootEngine::' . __METHOD__ );
        $listLines = $this->model->getLinelist();
        // position shifting
        $nbLines = count( $listLines );

        for ( $i = $nbLines + 1; $i > $lineNumber; $i-- ) {
            $listLines[$i] = $listLines[$i -1];
        }
        unset ( $listLines[$lineNumber] );
        $listLines[$lineNumber] = $line;

        $this->model->setLinelist( $listLines );
        wfDebugLog( 'p2p', ' - line added ' . $line );
    }

    /**
     * to delete a position in the model
     * @param <Integer> $lineNb
     */
    private function delete( $lineNb ) {
        $this->model->setPositionlist(
            $this->array_delete_key( $this->model->getPositionlist(), $lineNb ) );
        $this->keyShifting( $lineNb );
    }

    /**
     * to delete a line in the blobInfo (the model)
     * @param <Integr> $lineNb
     */
    private function deleteLine( $lineNb ) {
        $this->model->setLinelist(
            $this->array_delete_key( $this->model->getLinelist(), $lineNb ) );
        $this->textKeyShifting( $lineNb );
    }

    /**
     * used to remove an element (with the given key) of the array
     * @param <array> $array
     * @param <Integer> $search
     * @return <array> array after element deletion
     */
    private function array_delete_key( $array, $search ) {
        $temp = array();
        foreach ( $array as $key => $value ) {
            if ( $key != $search ) $temp[$key] = $value;
        }
        return $temp;
    }

    /**
     * used to shift the array elements after deletion
     * it only concerns the logootPosition array
     * @param <Integer> $lineNb
     */
    private function keyShifting( $lineNb ) {
        $listIds = $this->model->getPositionlist();
        $tmp = array();
        wfDebugLog( 'p2p', ' keySifitinh, lineNb ' . $lineNb );
        foreach ( $listIds as $key => $value ) {
            wfDebugLog( 'p2p', 'key : ' . $key );
            if ( $key > $lineNb ) {
                $tmp[$key -1] = $value;
            }
            else {
                $tmp[$key] = $value;
            }
        }
        $this->model->setPositionlist( $tmp );
    }

    /**
     * used to shift the array elements after deletion
     * it only concerns the text array
     * @param <Integer> $lineNb
     */
    private function textKeyShifting( $lineNb ) {
        $listLines = $this->model->getLinelist();
        $tmp = array();
        foreach ( $listLines as $key => $value ) {
            if ( $key > $lineNb ) {
                $tmp[$key -1] = $value;
            }
            else {
                $tmp[$key] = $value;
            }
        }
        $this->model->setLinelist( $tmp );
    }

    /**
     * adapted binary search
     * $arr is the positions'array of the document (this blobInfo)
     * "$position" is ressearched in this $arr, the function returns:
     * ->the position in the array if it is found,
     * ->'-1' if $position is before the first element,
     * ->'-2' if $position is after the last element or
     * -> an array with both positions in the array surrounding $position
     * @param <Object> $position LogootPosition
     * @param <function> $fct
     * @return <array or Integer>
     */
    private function dichoSearch1( $position,  $fct = 'dichoComp1' ) {
        wfDebugLog( 'p2p', ' - function logootEngine::dichoSearch ' );
        if ( $position instanceof LogootPosition ) {
            wfDebugLog( 'p2p', ' - position instanceof logootPosition ' );
        } else {
            wfDebugLog( 'p2p', ' - position not instanceof logootPosition ' );
        }
        $arr = $this->model->getPositionlist();

        if ( count( $arr ) == 0 ) {
            return -1;
        } else {
            $gauche = 1;
            $droite = count( $arr );
            $centre = round( ( $droite + $gauche ) / 2 );

            if ( count( $arr ) > 2 ) {
                while ( $centre != $droite && $centre != $gauche ) {

                    if ( $this->$fct( $position, $arr[$centre] ) == -1 ) {
                        $droite = $centre;
                        $centre = floor( ( $droite + $gauche ) / 2 );
                    }
                    if ( $this->$fct( $position, $arr[$centre] ) == 1 ) {
                        $gauche = $centre;
                        $centre = round( ( $droite + $gauche ) / 2 );
                    }
                    if ( $this->$fct( $position, $arr[$centre] ) == 0 ) {
                        return $centre;
                    }

                }
            } else { /*with an array<=2*/
                if ( $this->$fct( $position, $arr[$gauche] ) == 0 ) return $gauche;
                elseif ( $this->$fct( $position, $arr[$droite] ) == 0 )
                    return $droite;
            }

            // if there is no occurence
            ksort( $arr, SORT_NUMERIC );
            reset( $arr );
            $firstElementKey = key( $arr );
            end( $arr );
            $lastElementKey = key( $arr );

            if ( $this->$fct( $position, $arr[$firstElementKey] ) == -1 ) {
                wfDebugLog( 'p2p', '     - the value is less than the first element' );
                return -1; // / if the value is less than the first element of the array
            }
            elseif ( $this->$fct( $position, $arr[$lastElementKey] ) == 1 ) {
                wfDebugLog( 'p2p', '      - the value is greater than the last element' );
                return -2; /* if the value is greater than the last element of the array*/
            }
            else  /*else we return the values surrounding the ressearched
                    value */
                return array( 0 => $gauche, 1 => $droite );
        }
    }

    /**
     * utility function used in the binary search
     * @param <Object> $position1 LogootPosition
     * @param <Object> $position2 LogootPosition
     * @return <Integer> -1, 0 or 1
     */
    private function dichoComp1( $position1, $position2 ) {

    // if both positions are 1 vector Ids
        if ( $position1->size() == 1 && $position2->size() == 1 ) {
            $tab1 = $position1->getThisPosition();
            $tab2 = $position2->getThisPosition();
            if ( $position1->lessThan( $tab1[0], $tab2[0] ) ) {
                return -1;
            }
            if ( $position1->greaterThan( $tab1[0], $tab2[0] ) ) {
                return 1;
            }
            if ( $position1->equals( $tab1[0], $tab2[0] ) ) {
                return 0;
            }
        }
        else {// else if both logootIds are n vectors Ids
            if ( $position1->nLessThan( $position2 ) ) {
                return -1;
            }
            if ( $position1->nGreaterThan( $position2 ) ) {
                return 1;
            }
            if ( $position1->nEquals( $position2 ) ) {
                return 0;
            }
        }
    }

    /**
     * to get a random value between $min and $max
     * @param <gmp_ressource> $min
     * @param <gmp_ressource> $max
     * @return <gmp_ressource> random value
     */
//    private function random ($min,$max) {
//        $min = gmp_add($min, gmp_init("1"));
//        $rdm = gmp_add($min, gmp_mod(gmp_random(2), gmp_sub($max, $min)));
//        return $rdm;
//    }

    /**
     * Size of the logootPosition array
     * @return <Integer>
     */
    private function size() {
        return count( $this->model->getPositionlist() );
    }

    /**
     *
     * @return <Object> model
     */
    public function getModel() {
        return $this->model;
    }
}
