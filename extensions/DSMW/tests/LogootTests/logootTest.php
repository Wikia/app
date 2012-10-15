<?php
if ( !defined( 'MEDIAWIKI' ) ) { define( 'MEDIAWIKI', true ); }
require_once '../../logootComponent/LogootId.php';
require_once '../../logootComponent/LogootPosition.php';
require_once '../../logootComponent/DiffEngine.php';
require_once '../../logootComponent/logoot.php';
require_once '../../logootComponent/logootEngine.php';
require_once '../../logootComponent/LogootIns.php';
require_once '../../logootComponent/LogootDel.php';
require_once '../../logootComponent/Math/BigInteger.php';
require_once '../../logootModel/boModel.php';
require_once '../../logootModel/dao.php';
require_once '../../logootModel/manager.php';
require_once '../../../../includes/GlobalFunctions.php';
if ( !defined( 'INT_MAX' ) ) { define ( 'INT_MAX', "1000000000000000000000" ); }
if ( !defined( 'INT_MIN' ) ) { define ( 'INT_MIN', "0" ); }

/**
 * Description of Test_1
 *
 * @author mullejea
 */
class logootTest  extends PHPUnit_Framework_TestCase {

    function testIdCompareTo() {
        $id1 = new LogootId( "10000", "10000" );
        $id2 = new LogootId( "1000000", "1000000" );
        $this->assertEquals( '-1', $id1->compareTo( $id2 ) );
        $id1->setInt( "500000" );
        $id1->setSessionId( "500000" );
        $id2->setInt( "20" );
        $id2->setSessionId( "50" );
        $this->assertEquals( '1', $id1->compareTo( $id2 ) );
        $id1->setInt( "10" );
        $id1->setSessionId( "10" );
        $id2->setInt( "10" );
        $id2->setSessionId( "10" );
        $this->assertEquals( '0', $id1->compareTo( $id2 ) );
        $id1->setInt( INT_MIN );
        $id1->setSessionId( "10" );
        $id2->setInt( INT_MAX );
        $id2->setSessionId( "10" );
        $this->assertEquals( '-1', $id1->compareTo( $id2 ) );
        $this->assertEquals( '1', LogootId::IdMax()->compareTo( LogootId::IdMin() ) );      $y = "yop";
    }

    function testPositionCompareTo() {
        $pos = new LogootPosition( array( LogootId::IdMin(), LogootId::IdMin() ) );
        $pos1 = new LogootPosition( array( LogootId::IdMax(), LogootId::IdMax() ) );
        $this->assertEquals( '-1', $pos->compareTo( $pos1 ) );
        $this->assertEquals( '1', $pos1->compareTo( $pos ) );
        $this->assertEquals( '0', $pos->compareTo( $pos ) );
        $this->assertEquals( '0', $pos1->compareTo( $pos1 ) );

        $id1 = new LogootId( "10000", "10000" );
        $id2 = new LogootId( "1000000", "1000000" );
        $id3 = new LogootId( "2000000", "2000000" );
        $position1 = new LogootPosition( array( $id1, $id3 ) );
        $position2 = new LogootPosition( array( $id2 ) );
        $this->assertEquals( '0', $position1->compareTo( $position1 ) );
        $this->assertEquals( '-1', $position1->compareTo( $position2 ) );
        $this->assertEquals( '1', $position2->compareTo( $position1 ) );
    }

    function testVectorMinSize() {
        $id1 = new LogootId( "10000", "10000" );
        $pos = new LogootPosition( array( $id1, $id1, $id1, $id1, $id1 ) );
        $pos1 = new LogootPosition( array( $id1, $id1, $id1 ) );
        $this->assertEquals( '3', $pos->vectorMinSizeComp( $pos1 ) );
    }

    function testVectorSizeComp() {
        $id1 = new LogootId( "10000", "10000" );
        $pos = new LogootPosition( array( $id1, $id1, $id1, $id1, $id1 ) );
        $pos1 = new LogootPosition( array( $id1, $id1, $id1 ) );
        $this->assertEquals( '-1', $pos->vectorSizeComp( $pos1 ) );
        $pos = new LogootPosition( array( $id1, $id1, $id1, $id1, $id1 ) );
        $pos1 = new LogootPosition( array( $id1, $id1, $id1, $id1, $id1 ) );
        $this->assertEquals( '5', $pos->vectorSizeComp( $pos1 ) );
    }

    function testEquals() {
         $id1 = new LogootId( "10000", "10000" );
         $id2 = new LogootId( "1000000", "1000000" );
         $pos = new LogootPosition( array( $id1 ) );
         $this->assertFalse( $pos->equals( $id1, $id2 ) );
         $id2 = new LogootId( "10000", "10000" );
         $this->assertTrue( $pos->equals( $id1, $id2 ) );
    }

    function testNEquals() {
         $pos = new LogootPosition( array( LogootId::IdMin(), LogootId::IdMin() ) );
        $pos1 = new LogootPosition( array( LogootId::IdMax(), LogootId::IdMax() ) );
        $this->assertEquals( '0', $pos->nEquals( $pos1 ) );
        $pos1 = new LogootPosition( array( LogootId::IdMin(), LogootId::IdMin() ) );
        $this->assertEquals( '1', $pos->nEquals( $pos1 ) );
        $pos1 = new LogootPosition( array( LogootId::IdMin(), LogootId::IdMin(),
                LogootId::IdMin() ) );
        $this->assertEquals( '0', $pos->nEquals( $pos1 ) );
    }

    function testInsert() {
        $model = manager::loadModel( 0 );
        $logoot = new logootEngine( $model );

        // insert X
        $oldContent = "";
        $newContent = "X";
        $listOp1 = $logoot->generate( $oldContent, $newContent );
        // insert Y
        $oldContent = "X";
        $newContent = "X\nY";
        $listOp2 = $logoot->generate( $oldContent, $newContent );
        // insert Z
        $oldContent = "X\nY";
        $newContent = "X\nY\nZ";
        $listOp3 = $logoot->generate( $oldContent, $newContent );
        $modelAssert = $logoot->getModel();

        // model1 is another page model where we execute the 3 inserts in another order
        $model1 = manager::loadModel( 0 );
        $logoot1 = new logootEngine( $model1 );

        $logoot1->integrate( $listOp2 );
        $logoot1->integrate( $listOp1 );
        $modelAssert1 = $logoot1->integrate( $listOp3 );

        $this->assertEquals( $modelAssert->getPositionlist(), $modelAssert1->getPositionlist() );
        $this->assertEquals( $modelAssert->getLinelist(), $modelAssert1->getLinelist() );
        unset ( $logoot1 );
        unset ( $model1 );

        // model1 is another page model where we execute the 3 inserts in another order
        $model1 = manager::loadModel( 0 );
        $logoot1 = new logootEngine( $model1 );

        $modelAssert1 = $logoot1->integrate( $listOp3 );
        $modelAssert1 = $logoot1->integrate( $listOp2 );
        $modelAssert1 = $logoot1->integrate( $listOp1 );

        $this->assertEquals( $modelAssert->getPositionlist(), $modelAssert1->getPositionlist() );
        $this->assertEquals( $modelAssert->getLinelist(), $modelAssert1->getLinelist() );
        unset ( $logoot1 );
        unset ( $model1 );

        // model1 is another page model where we execute the 3 inserts in another order
        $model1 = manager::loadModel( 0 );
        $logoot1 = new logootEngine( $model1 );

        $modelAssert1 = $logoot1->integrate( $listOp1 );
        $modelAssert1 = $logoot1->integrate( $listOp3 );
        $modelAssert1 = $logoot1->integrate( $listOp2 );

        $this->assertEquals( $modelAssert->getPositionlist(), $modelAssert1->getPositionlist() );
        $this->assertEquals( $modelAssert->getLinelist(), $modelAssert1->getLinelist() );
        unset ( $logoot1 );
        unset ( $model1 );

        // model1 is another page model where we execute the 3 inserts in another order
        $model1 = manager::loadModel( 0 );
        $logoot1 = new logootEngine( $model1 );

        $modelAssert1 = $logoot1->integrate( $listOp2 );
        $modelAssert1 = $logoot1->integrate( $listOp3 );
        $modelAssert1 = $logoot1->integrate( $listOp1 );

        $this->assertEquals( $modelAssert->getPositionlist(), $modelAssert1->getPositionlist() );
        $this->assertEquals( $modelAssert->getLinelist(), $modelAssert1->getLinelist() );
        unset ( $logoot1 );
        unset ( $model1 );

        // model1 is another page model where we execute the 3 inserts in another order
        $model1 = manager::loadModel( 0 );
        $logoot1 = new logootEngine( $model1 );

        $modelAssert1 = $logoot1->integrate( $listOp3 );
        $modelAssert1 = $logoot1->integrate( $listOp1 );
        $modelAssert1 = $logoot1->integrate( $listOp2 );

        $this->assertEquals( $modelAssert->getPositionlist(), $modelAssert1->getPositionlist() );
        $this->assertEquals( $modelAssert->getLinelist(), $modelAssert1->getLinelist() );
        unset ( $logoot1 );
        unset ( $model1 );


    }

    function testInsertDelete() {
        $model = manager::loadModel( 0 );
        $logoot = new logootEngine( $model );

        // insert Y
        $oldContent = "";
        $newContent = "Y";
        $listOp1 = $logoot->generate( $oldContent, $newContent );
        // insert X below Y
        $oldContent = "Y";
        $newContent = "X\nY";
        $listOp2 = $logoot->generate( $oldContent, $newContent );
        // delete X
        $oldContent = "X\nY";
        $newContent = "Y";
        $listOp3 = $logoot->generate( $oldContent, $newContent );
        $modelAssert = $logoot->getModel();

        // model1 is another page model where we execute the 3 inserts in another order
        $model1 = manager::loadModel( 0 );
        $logoot1 = new logootEngine( $model1 );

        $logoot1->integrate( $listOp1 );
        $logoot1->integrate( $listOp2 );
        $modelAssert1 = $logoot1->integrate( $listOp3 );

        $this->assertEquals( $modelAssert->getPositionlist(), $modelAssert1->getPositionlist() );
        $this->assertEquals( $modelAssert->getLinelist(), $modelAssert1->getLinelist() );
        unset ( $logoot1 );
        unset ( $model1 );

        // model1 is another page model where we execute the 3 inserts in another order
        $model1 = manager::loadModel( 0 );
        $logoot1 = new logootEngine( $model1 );

        $modelAssert1 = $logoot1->integrate( $listOp2 );
        $modelAssert1 = $logoot1->integrate( $listOp1 );
        $modelAssert1 = $logoot1->integrate( $listOp3 );

        $this->assertEquals( $modelAssert->getPositionlist(), $modelAssert1->getPositionlist() );
        $this->assertEquals( $modelAssert->getLinelist(), $modelAssert1->getLinelist() );
        unset ( $logoot1 );
        unset ( $model1 );

    }

    function testManyIdPosition() {
        $model = manager::loadModel( 0 );
        $logoot = new logootEngine( $model );
        $oldContent = "";

        for ( $i = 0; $i < 500; $i++ ) {// 500 inserts
        // insert X
        if ( $i == 0 ) $newContent = $i;
        else $newContent = $oldContent . "\n" . $i;
        $listOp1 = $logoot->generate( $oldContent, $newContent );
        $this->assertEquals( 1, count( $listOp1 ) );

        $oldContent = $newContent;
        }
        $modelAssert = $logoot->getModel();

        $this->assertEquals( 500, count( $modelAssert->getPositionlist() ) );
        $this->assertEquals( 500, count( $modelAssert->getLinelist() ) );

        $listPos = $modelAssert->getPositionlist();
        for ( $j = 1; $j < 500; $j++ ) {
            $testpos = $listPos[$j];
            $testpos1 = $listPos[$j + 1];
            $this->assertEquals( '-1', $testpos->compareTo( $testpos1 ) );
            $this->assertEquals( '1', $testpos1->compareTo( $testpos ) );
        }
   }

   function testManyInsDel() {
        $model = manager::loadModel( 0 );
        $logoot = new logootEngine( $model );
        $oldContent = "";

        for ( $i = 0; $i < 500; $i++ ) {// 500 inserts / 499 deletion
        // insert X
        $newContent = $i;
        $listOp1 = $logoot->generate( $oldContent, $newContent );
        if ( $i == 0 ) $this->assertEquals( 1, count( $listOp1 ) ); // ins first line
        else $this->assertEquals( 2, count( $listOp1 ) );

        $oldContent = $newContent;
        }
        $modelAssert = $logoot->getModel();

        $this->assertEquals( 1, count( $modelAssert->getPositionlist() ) );
   }
}
?>
