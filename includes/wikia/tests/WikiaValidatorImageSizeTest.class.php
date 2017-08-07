<?php

use PHPUnit\Framework\TestCase;

class WikiaValidatorImageSizeTest extends TestCase {

	/**
	 * @param $options
	 * @param $image
	 * @param $expectedResult
	 * 
	 * @dataProvider imagesDataProvider
	 */
	public function testIsValid($options, $image, $expectedResult) {
		$fileMock = $this->createMock( WikiaLocalFile::class );
		$fileMock->expects($this->once())
			->method('getWidth')
			->will($this->returnValue($image['width']));
		$fileMock->expects($this->once())
			->method('getHeight')
			->will($this->returnValue($image['height']));
		$fileMock->expects($this->once())
			->method('getMimeType')
			->will($this->returnValue($image['mimeType']));

		/** @var $validator WikiaValidatorImageSize */
		$validator = $this->getMock('WikiaValidatorImageSize', array('getFileFromName', 'isFileNameValid'), array($options));
		$validator->expects($this->once())
			->method('getFileFromName')
			->will($this->returnValue($fileMock));
		$validator->expects($this->once())
			->method('isFileNameValid')
			->will($this->returnValue(true));
		
		$this->assertEquals($expectedResult, $validator->isValid('Example_image_name'));
	}
	
	public function imagesDataProvider() {
		return array(
			//all good - image sizes are lower than max limits
			array(
				'validatorOptions' => array(
					'maxWidth' => 85,
					'maxHeight' => 15,
				),
				'imageParams' => array(
					'width' => 60, 
					'height' => 10, 
					'mimeType' => 'image/jpeg',
				),
				'result' => true
			),
			//all good - image sizes are higher than min limits
			array(
				'validatorOptions' => array(
					'minWidth' => 85,
					'minHeight' => 15,
				),
				'imageParams' => array(
					'width' => 100,
					'height' => 25,
					'mimeType' => 'image/jpeg',
				),
				'result' => true
			),
			//all good - image sizes are the same as limits
			array(
				'validatorOptions' => array(
					'maxWidth' => 85,
					'maxHeight' => 15,
				),
				'imageParams' => array(
					'width' => 85,
					'height' => 15,
					'mimeType' => 'image/jpeg',
				),
				'result' => true
			),
			array(
				'validatorOptions' => array(
					'minWidth' => 85,
					'minHeight' => 15,
				),
				'imageParams' => array(
					'width' => 85,
					'height' => 15,
					'mimeType' => 'image/jpeg',
				),
				'result' => true
			),
			//all good - image sizes are OK we're testing if the mime types are correct
			array(
				'validatorOptions' => array(
					'maxWidth' => 85,
					'maxHeight' => 15,
				),
				'imageParams' => array(
					'width' => 60,
					'height' => 10,
					'mimeType' => 'image/gif',
				),
				'result' => true
			),
			array(
				'validatorOptions' => array(
					'maxWidth' => 85,
					'maxHeight' => 15,
				),
				'imageParams' => array(
					'width' => 60,
					'height' => 10,
					'mimeType' => 'image/pjpeg',
				),
				'result' => true
			),
			array(
				'validatorOptions' => array(
					'maxWidth' => 85,
					'maxHeight' => 15,
				),
				'imageParams' => array(
					'width' => 60,
					'height' => 10,
					'mimeType' => 'image/png',
				),
				'result' => true
			),
			//bad - image sizes are higher than max limits
			array(
				'validatorOptions' => array(
					'maxWidth' => 85,
					'maxHeight' => 15,
				),
				'imageParams' => array(
					'width' => 100,
					'height' => 20,
					'mimeType' => 'image/jpeg',
				),
				'result' => false
			),
			//bad - image sizes are lower than min limits
			array(
				'validatorOptions' => array(
					'minWidth' => 85,
					'minHeight' => 15,
				),
				'imageParams' => array(
					'width' => 60,
					'height' => 10,
					'mimeType' => 'image/jpeg',
				),
				'result' => false
			),
			//bad - not an image
			array(
				'validatorOptions' => array(
					'maxWidth' => 85,
					'maxHeight' => 15,
				),
				'imageParams' => array(
					'width' => 0,
					'height' => 0,
					'mimeType' => 'text/html',
				),
				'result' => false
			),
		);
	}
	
}
