<?php
/**
 * To get this working you must
 * - set a valid path to PEAR
 * - check upload size in php.ini: Multipage.tiff needs at least 3M
 * - Upload the image truncated.tiff without PagedTiffHandler being active
 *   Caution: you need to allow tiff for upload:
 *   $wgFileExtensions[] = 'tiff';
 *   $wgFileExtensions[] = 'tif';
 * - Upload multipage.tiff when PagedTiffHandler is active
 */

if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = dirname( __FILE__ ) . '/../../..';
}
require_once( "$IP/maintenance/commandLine.inc" );

// requires PHPUnit 3.4
require_once 'PHPUnit/Framework.php';

error_reporting( E_ALL );

class PagedTiffHandlerTest extends PHPUnit_Framework_TestCase {

	private $handler;
	private $preCheckError = false;

	function upload( $title, $path ) {
		echo "$title seems not to be present in the wiki. Trying to upload from $path.\n";
		$image = wfLocalFile( $title );
		$archive = $image->publish( $path );
		$image->recordUpload( $archive->value, "Test file used for PagedTiffHandler unit test", "No license" );
		if( !$archive->isGood() )
		{
			echo "Something went wrong. Please manually upload $path\n";
			return false;
		} else {
			echo "Upload was successful.\n";
			return $image;
		}
	}

	function setUp( $autoUpload = false ) {
		global $wgTitle;
		$wgTitle = Title::newFromText( 'PagedTiffHandler_UnitTest' );
		
		$this->handler = new PagedTiffHandler();
		
		if ( !file_exists( dirname( __FILE__ ) . '/testImages' ) ) {
			echo "testImages directory cannot be found.\n";
			$this->preCheckError = true;
			return false;
		}

		$this->multipage_path = dirname(__FILE__) . '/testImages/multipage.tiff';
		$this->truncated_path = dirname(__FILE__) . '/testImages/truncated.tiff';
		$this->mhz_path = dirname(__FILE__) . '/testImages/380mhz.tiff';
		$this->test_path = dirname(__FILE__) . '/testImages/test.tif';

		if ( !file_exists( $this->truncated_path ) ) {
			echo "{$this->truncated_path} cannot be found.\n";
			$this->preCheckError = true;
			return false;
		}

		if ( !file_exists( $this->multipage_path ) ) {
			echo "{$this->multipage_path} cannot be found.\n";
			$this->preCheckError = true;
			return false;
		}

		if ( !file_exists( $this->mhz_path ) ) {
			echo "{$this->mhz_path} cannot be found.\n";
			$this->preCheckError = true;
			return false;
		}

		if ( !file_exists( $this->test_path ) ) {
			echo "{$this->test_path} cannot be found.\n";
			$this->preCheckError = true;
			return false;
		}

		$truncatedTitle = Title::newFromText('Image:Truncated.tiff');
		$this->truncated_image = wfFindFile($truncatedTitle);
		if ( !$this->truncated_image && $autoUpload ) {
			$this->truncated_image = $this->upload( $truncatedTitle, $this->truncated_path );

			if ( !$this->truncated_image ) {
				$this->preCheckError = true;
				return false;
			}
		}

		$multipageTitle = Title::newFromText( 'Image:Multipage.tiff' );
		$this->multipage_image = wfFindFile( $multipageTitle );
		if ( !$this->multipage_image && $autoUpload ) {
			$this->multipage_image = $this->upload( $multipageTitle, $this->multipage_path );

			if ( !$this->multipage_image ) {
				$this->preCheckError = true;
				return false;
			}
		}

		$mhzTitle = Title::newFromText( 'Image:380mhz.tiff' );
		$this->mhz_image = wfFindFile( $mhzTitle );
		if ( !$this->mhz_image && $autoUpload ) {
			$this->mhz_image = $this->upload( $multipageTitle, $this->mhz_path );

			if ( !$this->mhz_image ) {
				$this->preCheckError = true;
				return false;
			}
		}

		// force re-reading of meta-data
		$truncated_tiff = $this->handler->getTiffImage( $this->truncated_image, $this->truncated_path );
		$truncated_tiff->resetMetaData(); 

		$multipage_tiff = $this->handler->getTiffImage( $this->multipage_image, $this->multipage_path );
		$multipage_tiff->resetMetaData(); 

		$mhz_tiff = $this->handler->getTiffImage( $this->mhz_image, $this->mhz_path );
		$mhz_tiff->resetMetaData(); 

		return !$this->preCheckError;
	}
	
	function runTest() {
		global $wgLanguageCode;
		// do not execute test if preconditions check returned false;
		if ( $this->preCheckError ) {
			return false;
		}

		// ---- Metdata initialization
		$this->handler->getMetadata( $this->multipage_image, $this->multipage_path );
		$this->handler->getMetadata( $this->truncated_image, $this->truncated_path );


		// ---- Metadata handling
		// getMetadata
		$metadata =  $this->handler->getMetadata( false, $this->multipage_path );
		$this->assertTrue( strpos( $metadata, '"page_count";i:7' ) !== false );
		$this->assertTrue( $this->handler->isMetadataValid( $this->multipage_image, $metadata ) );

		$metadata =  $this->handler->getMetadata( false, $this->mhz_path );
		$this->assertTrue( strpos( $metadata, '"page_count";i:1' ) !== false );
		$this->assertTrue( $this->handler->isMetadataValid( $this->mhz_image, $metadata ) );

		// getMetaArray
		$metaArray = $this->handler->getMetaArray( $this->mhz_image );
		if ( !empty( $metaArray['errors'] ) ) $this->fail( join('; ', $metaArray['error']) );
		$this->assertEquals( $metaArray['page_count'], 1 );

		$this->assertEquals( strtolower( $metaArray['page_data'][1]['alpha'] ), 'true' );

		$metaArray = $this->handler->getMetaArray( $this->multipage_image );
		if ( !empty( $metaArray['errors'] ) ) $this->fail( join('; ', $metaArray['error']) );
		$this->assertEquals( $metaArray['page_count'], 7 );

		$this->assertEquals( strtolower( $metaArray['page_data'][1]['alpha'] ), 'false' );
		$this->assertEquals( strtolower( $metaArray['page_data'][2]['alpha'] ), 'true' );

		$interp = $metaArray['exif']['PhotometricInterpretation'];
		$this->assertTrue( $interp == 2 || $interp == 'RGB' ); //RGB

		// ---- Parameter handling and lossy parameter
		// validateParam
		$this->assertTrue( $this->handler->validateParam( 'lossy', '0' ) );
		$this->assertTrue( $this->handler->validateParam( 'lossy', '1' ) );
		$this->assertTrue( $this->handler->validateParam( 'lossy', 'false' ) );
		$this->assertTrue( $this->handler->validateParam( 'lossy', 'true' ) );
		$this->assertTrue( $this->handler->validateParam( 'lossy', 'lossy' ) );
		$this->assertTrue( $this->handler->validateParam( 'lossy', 'lossless' ) );

		$this->assertTrue( $this->handler->validateParam( 'width', '60000' ) );
		$this->assertTrue( $this->handler->validateParam( 'height', '60000' ) );
		$this->assertTrue( $this->handler->validateParam( 'page', '60000' ) );

		$this->assertFalse( $this->handler->validateParam( 'lossy', '' ) ); 
		$this->assertFalse( $this->handler->validateParam( 'lossy', 'quark' ) );

		$this->assertFalse( $this->handler->validateParam( 'width', '160000' ) );
		$this->assertFalse( $this->handler->validateParam( 'height', '160000' ) );
		$this->assertFalse( $this->handler->validateParam( 'page', '160000' ) );

		$this->assertFalse( $this->handler->validateParam( 'width', '0' ) );
		$this->assertFalse( $this->handler->validateParam( 'height', '0' ) );
		$this->assertFalse( $this->handler->validateParam( 'page', '0' ) );

		$this->assertFalse( $this->handler->validateParam( 'width', '-1' ) );
		$this->assertFalse( $this->handler->validateParam( 'height', '-1' ) );
		$this->assertFalse( $this->handler->validateParam( 'page', '-1' ) );

		// normaliseParams
		// here, boxfit behavior is tested
		$params = array( 'width' => '100', 'height' => '100', 'page' => '4' );
		$this->assertTrue( $this->handler->normaliseParams( $this->multipage_image, $params ) );
		$this->assertEquals( $params['height'], 75 );

		// lossy and lossless
		$params = array('width'=>'100', 'height'=>'100', 'page'=>'1');
		$this->handler->normaliseParams($this->multipage_image, $params );
		$this->assertEquals($params['lossy'], 'lossy');

		$params = array('width'=>'100', 'height'=>'100', 'page'=>'2');
		$this->handler->normaliseParams($this->multipage_image, $params );
		$this->assertEquals($params['lossy'], 'lossless');

		// single page
		$params = array('width'=>'100', 'height'=>'100', 'page'=>'1');
		$this->handler->normaliseParams($this->mhz_image, $params );
		$this->assertEquals($params['lossy'], 'lossless');

		// makeParamString
		$this->assertEquals(
			$this->handler->makeParamString(
				array(
					'width' => '100',
					'page' => '4',
					'lossy' => 'lossless'
				)
			),
			'lossless-page4-100px'
		);

		// ---- File upload checks and Thumbnail transformation
		// check
		// TODO: check other images
		$status = $this->handler->verifyUpload( $this->multipage_path );
		$this->assertTrue( $status->isGood() );

		$status = $this->handler->verifyUpload( $this->truncated_path );
		$this->assertFalse( $status->isGood() );
		$this->assertTrue( $status->hasMessage( 'tiff_bad_file' ) );

		// doTransform
		$this->handler->doTransform( $this->multipage_image, $this->test_path, 'Test.tif', array( 'width' => 100, 'height' => 100 ) ); 
		$error = $this->handler->doTransform( wfFindFile( Title::newFromText( 'Image:Truncated.tiff' ) ), $this->truncated_path, 'Truncated.tiff', array( 'width' => 100, 'height' => 100 ) );
		$this->assertEquals( $error->textMsg, wfMsg( 'thumbnail_error', wfMsg( 'tiff_bad_file' ) ) );

		// ---- Image information
		// getThumbType
		$type = $this->handler->getThumbType( '.tiff', 'image/tiff', array( 'lossy' => 'lossy' ) );
		$this->assertEquals( $type[0], 'jpg' );
		$this->assertEquals( $type[1], 'image/jpeg' );

		$type = $this->handler->getThumbType( '.tiff', 'image/tiff', array( 'lossy' => 'lossless' ) );
		$this->assertEquals( $type[0], 'png' );
		$this->assertEquals( $type[1], 'image/png' );

		// getLongDesc
		if ( $wgLanguageCode == 'de' ) {
			$this->assertEquals( $this->handler->getLongDesc( $this->multipage_image ), wfMsg( 'tiff-file-info-size', '1.024', '768', '2,64 MB', 'image/tiff', '7' ) );
		} else {
			// English
			$this->assertEquals( $this->handler->getLongDesc( $this->multipage_image ), wfMsg( 'tiff-file-info-size', '1,024', '768', '2.64 MB', 'image/tiff', '7' ) );
		}
		
		// pageCount
		$this->assertEquals( $this->handler->pageCount( $this->multipage_image ), 7 );
		$this->assertEquals( $this->handler->pageCount( $this->mhz_image ), 1 );

		// getPageDimensions
		$this->assertEquals( $this->handler->getPageDimensions( $this->multipage_image, 0 ), array( 'width' => 1024, 'height' => 768 ) );
		$this->assertEquals( $this->handler->getPageDimensions( $this->multipage_image, 1 ), array( 'width' => 1024, 'height' => 768 ) );
		$this->assertEquals( $this->handler->getPageDimensions( $this->multipage_image, 2 ), array( 'width' => 640, 'height' => 564 ) );
		$this->assertEquals( $this->handler->getPageDimensions( $this->multipage_image, 3 ), array( 'width' => 1024, 'height' => 563 ) );
		$this->assertEquals( $this->handler->getPageDimensions( $this->multipage_image, 4 ), array( 'width' => 1024, 'height' => 768 ) );
		$this->assertEquals( $this->handler->getPageDimensions( $this->multipage_image, 5 ), array( 'width' => 1024, 'height' => 768 ) );
		$this->assertEquals( $this->handler->getPageDimensions( $this->multipage_image, 6 ), array( 'width' => 1024, 'height' => 768 ) );
		$this->assertEquals( $this->handler->getPageDimensions( $this->multipage_image, 7 ), array( 'width' => 768, 'height' => 1024 ) );

		$this->assertEquals( $this->handler->getPageDimensions( $this->mhz_image, 0 ), array( 'width' => 643, 'height' => 452 ) );

		// return dimensions of last page if page number is too high
		$this->assertEquals( $this->handler->getPageDimensions( $this->multipage_image, 8 ), array( 'width' => 768, 'height' => 1024 ) );
		$this->assertEquals( $this->handler->getPageDimensions( $this->mhz_image, 1 ), array( 'width' => 643, 'height' => 452 ) );

		// isMultiPage
		$this->assertTrue( $this->handler->isMultiPage( $this->multipage_image ) );
		$this->assertTrue( $this->handler->isMultiPage( $this->mhz_image ) );

		// formatMetadata
		$formattedMetadata = $this->handler->formatMetadata( $this->multipage_image );

		foreach (  $formattedMetadata['collapsed'] as $k => $e ) {
			if ( $e['id'] == 'exif-photometricinterpretation' ) {
				$this->assertEquals( $e['value'], 'RGB' ); 
			}
		}
	}

}
$wgShowExceptionDetails = true;

$t = new PagedTiffHandlerTest();
$t->setUp( true );
$t->runTest();

echo "OK.\n";