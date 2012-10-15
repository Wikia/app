<?php
/**
 * To get this working you must
 * - set a valid path to PEAR
 * - check upload size in php.ini: Multipage.tiff needs at least 3M
 * - Either upload multipage.tiff when PagedTiffHandler is active or
 * - -  set $egSeleniumTiffTestUploads = true.
 * - if $wgSeleniumTiffTestsUploads = true, please remember to obtain
 * - - all missing test images. See
 * - - testImages/SOURCES.txt for further information
 * - set the locale to English
 */

require_once(dirname( __FILE__ ) . '/PagedTiffHandlerTestCases.php');

class PagedTiffHandlerSeleniumTestSuite extends SeleniumTestSuite {

	public $egSeleniumTiffTestUploads = false;
	public $egSeleniumTiffTestCheckPrerequistes = true;

	public function __construct( $name = 'PagedTiffHandler Test Suite') {
		parent::__construct( $name );
	}

	public function addTests() {
		if ( $this->egSeleniumTiffTestCheckPrerequistes ) {
			parent::addTest( new SeleniumCheckPrerequisites() );
		}

		if ( $this->egSeleniumTiffTestUploads ) {
			parent::addTest( new SeleniumUploadBrokenTiffTest(
				'caspian.tif',
				'The uploaded file contains errors.' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'cramps.tif' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'cramps-tile.tif' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'dscf0013.tif' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'fax2d.tif' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'g3test.tif' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'Jello.tif' ) );
			parent::addTest( new SeleniumUploadBrokenTiffTest(
				'jim___ah.tif',
				'The reported file size does not match' .
				' the actual file size.' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'jim___cg.tif' ) );
			parent::addTest( new SeleniumUploadBrokenTiffTest(
				'jim___dg.tif', 'The reported file size does' .
				' not match the actual file size.' ) );
			parent::addTest( new SeleniumUploadBrokenTiffTest(
				'jim___gg.tif', 'The reported file size does' .
				' not match the actual file size.' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'ladoga.tif' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'off_l16.tif' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'off_luv24.tif' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'off_luv24.tif' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'oxford.tif' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'pc260001.tif' ) );
			parent::addTest( new SeleniumUploadBrokenTiffTest(
				'quad-jpeg.tif', 'The uploaded file could not' .
				' be processed. ImageMagick is not available.' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'quad-lzw.tif' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'quad-tile.tif' ) );
			parent::addTest( new SeleniumUploadBrokenTiffTest(
				'smallliz.tif', 'The uploaded file could not' .
				' be processed. ImageMagick is not available.' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'strike.tif' ) );
			parent::addTest( new SeleniumUploadBrokenTiffTest(
				'text.tif', 'The uploaded file contains errors.' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'ycbcr-cat.tif' ) );
			parent::addTest( new SeleniumUploadBrokenTiffTest(
				'zackthecat.tif', 'The uploaded file could not' .
				' be processed. ImageMagick is not available.' ) );
			parent::addTest( new SeleniumUploadWorkingTiffTest(
				'multipage.tiff' ) );
		}
		//parent::addTest( new SeleniumUploadWorkingTiffTest( 'multipage.tiff' ) );

		parent::addTest( new SeleniumEmbedTiffInclusionTest() );
		parent::addTest( new SeleniumEmbedTiffThumbRatioTest() );
		parent::addTest( new SeleniumEmbedTiffBoxFitTest() );

		parent::addTest( new SeleniumEmbedTiffPage2InclusionTest() );
		parent::addTest( new SeleniumEmbedTiffPage2ThumbRatioTest() );
		parent::addTest( new SeleniumEmbedTiffPage2BoxFitTest() );

		parent::addTest( new SeleniumEmbedTiffNegativePageParameterTest() );
		parent::addTest( new SeleniumEmbedTiffPageParameterTooHighTest() );

		parent::addTest( new SeleniumDisplayInCategoryTest() );
		parent::addTest( new SeleniumDisplayInGalleryTest() );

		if ( $this->egSeleniumTiffTestUploads ) {
			parent::addTest( new SeleniumDeleteTiffTest(
				'cramps.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'cramps-tile.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'dscf0013.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'fax2d.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'g3test.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'Jello.tif' ) );
			//parent::addTest( new SeleniumDeleteTiffTest(
				//'jim___ah.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'jim___cg.tif' ) );
			//parent::addTest( new SeleniumDeleteTiffTest(
				//'jim___dg.tif' ) );
			//parent::addTest( new SeleniumDeleteTiffTest(
				//'jim___gg.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'ladoga.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'off_l16.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'off_luv24.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'off_luv24.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'oxford.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'pc260001.tif' ) );
			//parent::addTest( new SeleniumDeleteTiffTest(
				//'quad-jpeg.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'quad-lzw.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'quad-tile.tif' ) );
			//parent::addTest( new SeleniumDeleteTiffTest(
				//'smallliz.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'strike.tif' ) );
			//parent::addTest( new SeleniumDeleteTiffTest(
				//'text.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'ycbcr-cat.tif' ) );
			//parent::addTest( new SeleniumDeleteTiffTest(
				//'zackthecat.tif' ) );
			parent::addTest( new SeleniumDeleteTiffTest(
				'multipage.tiff' ) );
		}
	}
}

