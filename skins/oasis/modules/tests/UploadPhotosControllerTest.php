<?
class UploadPhotosControllerTest extends WikiaBaseTest {
	public function testUploadMessage() {
		$method = new ReflectionMethod(
			'UploadPhotosController', 'uploadMessage'
		);

		$method->setAccessible(TRUE);

		$this->assertEquals(
			'This file is bigger than the server is configured to allow.', $method->invoke(new UploadPhotosController, UploadBase::FILE_TOO_LARGE, [])
		);
	}
}