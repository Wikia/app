<?php 
/**
 * @ingroup timedmedia
 * @author dale
 */
class TestVideoThumbnail extends ApiTestCaseVideoUpload {
	
	/**
	 * Once video files are uploaded test thumbnail generating
	 * 
	 * @dataProvider mediaFilesProvider
	 */
	function testApiThumbnails( $file ){
		// Upload the file to the mediaWiki system 
		$result = $this->uploadFile( $file);
		
		// Do a API request and check for valid thumbnails:
		$fileName = basename( $file['filePath'] );
		$params = array(
			'action' => 'query',
			'titles' => 'File:' . $fileName,
			'prop' => 'imageinfo',		
			'iiprop'	=> "url|size|thumbmime",
		);
		
		// Do a request for a small ( 200px ) thumbnail
		list($result,,) = $this->doApiRequest(
			array_merge( $params, array( 
					'iiurlwidth' => '200' 
				) 
			) 
		);
		
		// Check The thumbnail output: 
		$this->assertTrue( isset( $result['query'] ) );
		
		$page = current( $result['query']['pages'] );
		$this->assertTrue( isset( $page['imageinfo'] ) );
		
		$imageInfo = current( $page['imageinfo'] );
		
		// Make sure we got a 200 wide pixel image: 
		$this->assertEquals( 200, ( int )$imageInfo['thumbwidth'] );
		
		// Thumbnails should be image/jpeg:
		$this->assertEquals( 'image/jpeg', $imageInfo['thumbmime'] );

		// Make sure the thumbnail url is valid and the correct size ( assuming php has getimagesize function)
		if( function_exists( 'getimagesize' ) ){
			list($width ,,,) = getimagesize ( $imageInfo[ 'thumburl'] );
			$this->assertEquals( 200, $width );
		}
		
		
		/** 
		 * We combine tests because fixtures don't play well with dataProvider 
		 * see README for more info
		 */
		
		// Test a larger thumbnail with 1 second time offset
		list( $result,, ) = $this->doApiRequest(
			array_merge( $params, array( 
					'iiurlwidth' => '600',
					'iiurlparam' => '1'
				)
			)
		);
		$page = current( $result['query']['pages'] );
		$imageInfo = current( $page['imageinfo'] );
		// Thumb should max out at source size ( no upscale )
		$targetWidth = ( ( int )$file['width'] < 600 ) ? ( int )$file['width'] : 600;
		$this->assertEquals( $targetWidth, ( int )$imageInfo['thumbwidth'] );		
		if( function_exists( 'getimagesize' ) ){
			list( $srcImageWidth ,,,) = getimagesize ( $imageInfo[ 'thumburl'] ); 					
			$this->assertEquals( $targetWidth, $srcImageWidth );
		}		
	}
}