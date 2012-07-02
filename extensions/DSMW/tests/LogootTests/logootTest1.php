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
if ( !defined( 'INT_MAX' ) ) { define ( 'INT_MAX', "18446744073709551616" ); }
if ( !defined( 'INT_MIN' ) ) { define ( 'INT_MIN', "0" ); }

/**
 * Description of ConflictTest
 *
 * @author mullejea
 */
class logootTest1 extends PHPUnit_Framework_TestCase {

    function testPosGeneration() {

        $int = "5";
        $int1 = "6";
        $sid = "1";
        if ( $int < $int1 ) {
            $id = new LogootId( $int, $sid );
            $id1 = new LogootId( $int1, $sid );
        }
        else {
            $id1 = new LogootId( $int, $sid );
            $id = new LogootId( $int1, $sid );
        }

        $pos = array( $id );
        $pos1 = array( $id1 );
        $start = new LogootPosition( $pos );
        $end = new LogootPosition( $pos1 );

        $model = manager::loadModel( 0 );
        $model->setPositionlist( array( 1 => $start, 2 => $end ) );
        $model->setLinelist( array( 1 => 'start', 2 => 'end' ) );
        $logoot = new logootEngine( $model );

        // insert X
        $oldContent = "start\nend";
        $newContent = "start\nline1\nend";
        $listOp1 = $logoot->generate( $oldContent, $newContent );

        $this->assertLessThan( $end, $listOp1[0]->getLogootPosition() );
        $this->assertGreaterThan( $start, $listOp1[0]->getLogootPosition() );

    }



    function testIntegration() {
        $oldtext = "";
        $fp = fopen( dirname( __FILE__ ) . "/text1.txt", "r" );
        $actualtext = fread( $fp, filesize( dirname( __FILE__ ) . "/text1.txt" ) );
        fclose( $fp );
        $model = manager::loadModel( 0 );
        $logoot = new logootEngine( $model );
        $listOp = $logoot->generate( $oldtext, $actualtext );
        $modelAssert = $logoot->getModel();


        // the file's text has 114 lines!!
        $this->assertEquals( 114, count( $modelAssert->getPositionlist() ) );
        $this->assertEquals( 114, count( $modelAssert->getLinelist() ) );

        // we add 5 lines
        $oldtext = $actualtext;
        $actualtext .= "\nline1\nline2\nline3\nline4\nline5";
        $listOp = $logoot->generate( $oldtext, $actualtext );
        $modelAssert = $logoot->getModel();
        $this->assertEquals( 119, count( $modelAssert->getPositionlist() ) );
        $this->assertEquals( 119, count( $modelAssert->getLinelist() ) );

        // delete 30 lines
        $oldtext = $actualtext;
        $textTab = explode( "\n", $actualtext );
        for ( $i = 0; $i < 30; $i++ ) {
            array_shift( $textTab );
        }
        $actualtext = implode( "\n", $textTab );
        $listOp = $logoot->generate( $oldtext, $actualtext );
        $modelAssert = $logoot->getModel();
        $this->assertEquals( 89, count( $modelAssert->getPositionlist() ) );
        $this->assertEquals( 89, count( $modelAssert->getLinelist() ) );

        // delete 89 lines, it should remain 1 empty line
        $oldtext = $actualtext;
        $actualtext = "";
        $listOp = $logoot->generate( $oldtext, $actualtext );
        $modelAssert = $logoot->getModel();
        $this->assertEquals( 1, count( $modelAssert->getPositionlist() ) );
        $this->assertEquals( 1, count( $modelAssert->getLinelist() ) );
    }

    function testConcIntegration() {


        $oldtext = "";
        $fp = fopen( dirname( __FILE__ ) . "/text2.txt", "r" );
        $conctext = fread( $fp, filesize( dirname( __FILE__ ) . "/text2.txt" ) );
        fclose( $fp );
        $model = manager::loadModel( 0 );
        $logoot = new logootEngine( $model );
        $listOp = $logoot->generate( $oldtext, $conctext );



        // We get the operations list generated on a text 'text1'
        $oldtext = "";
        $fp = fopen( dirname( __FILE__ ) . "/text1.txt", "r" );
        $actualtext = fread( $fp, filesize( dirname( __FILE__ ) . "/text1.txt" ) );
        fclose( $fp );
        $model1 = manager::loadModel( 0 );
        $logoot1 = new logootEngine( $model1 );
        $listOp1 = $logoot1->generate( $oldtext, $actualtext );

        // we integrate the op list into the model generated from the text2
        $modelAssert = $logoot->integrate( $listOp1 );

        $this->assertEquals( 124, count( $modelAssert->getPositionlist() ) );
        $this->assertEquals( 124, count( $modelAssert->getLinelist() ) );

    }

    function testConcDelOpIntegration() {


        $oldtext = "";
        $conctext = "line1\nline2\nline3\nline4";
        $model = manager::loadModel( 0 );
        $logoot = new logootEngine( $model );
        $listOp = $logoot->generate( $oldtext, $conctext );
        // $model has 4 lines created by 4 ins operations

        $tmpMod = $logoot->getModel();
        $this->assertEquals( 4, count( $tmpMod->getPositionlist() ) );
        $this->assertEquals( 4, count( $tmpMod->getLinelist() ) );

        $oldtext = "line1\nline2\nline3\nline4";
        $actualtext = "line1\nline2\nline4";

        $listOp1 = $logoot->generate( $oldtext, $actualtext );

        $tmpMod = $logoot->getModel();
        $this->assertEquals( 3, count( $tmpMod->getPositionlist() ) );
        $this->assertEquals( 3, count( $tmpMod->getLinelist() ) );


        $modelAssert = $logoot->integrate( $listOp1 );
        $this->assertEquals( 3, count( $modelAssert->getPositionlist() ) );
        $this->assertEquals( 3, count( $modelAssert->getLinelist() ) );

    }

}
?>
