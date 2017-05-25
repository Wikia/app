<?php

require_once __DIR__ . '/WikiaLoggerFake.php';

/**
 * Class UpdateThumbnailTaskTest
 *
 * @group MediaFeatures
 */
class UpdateThumbnailTaskTest extends WikiaBaseTest {

	public function setUp() {
		parent::setUp();
		$this->mockStaticMethod("\\Wikia\\Logger\\WikiaLogger", "instance", new WikiaLoggerFake());
	}

	public function testThumbnailUploadOnNonExistingFile() {
		$result = $this->callRetryThumbUpload(null);
		$errors = $result->getErrorsArray();

		$this->assertFalse($result->isGood());
		$this->assertContains("File not found on wiki", $errors[0][0]);
	}

	public function testThumbnailUploadOnForeignFile() {
		$file = $this->getVideoFileMock(false);

		$result = $this->callRetryThumbUpload($file);
		$errors = $result->getErrorsArray();

		$this->assertFalse($result->isGood());
		$this->assertContains("Cannot update foreign video thumbnail", $errors[0][0]);
	}

	public function testThumbnailUploadSuccess() {
		$file = $this->getVideoFileMock();
		$helper = $this->getVideoHandlerHelperMock($this->getStatusMock());

		$result = $this->callRetryThumbUpload($file, $helper);

		$this->assertTrue($result->isGood());
	}

	public function testThumbnailUploadFailure() {
		$file = $this->getVideoFileMock();
		$helper = $this->getVideoHandlerHelperMock($this->getStatusMock(false));

		$result = $this->callRetryThumbUpload($file, $helper);

		$this->assertFalse($result->isGood());
	}

	private function callRetryThumbUpload($file, $videoHandlerHelper = null) {
		$title = $this->getTitleMock();
		$this->mockStaticMethod("WikiaFileHelper", "getVideoFileFromTitle", $file);

		$task = new UpdateThumbnailTask($videoHandlerHelper);

		return $task->retryThumbUpload($title, 0, UpdateThumbnailTask::DEFAULT_PROVIDER, 0);
	}

	private function getVideoFileMock($isLocal = true) {
		$file = $this->getMockBuilder("File")
			->disableOriginalConstructor()
			->setMethods(["isLocal", "getVideoId", "getSha1", "getThumbUrl"])
			->getMock();
		$file->expects($this->any())
			->method("isLocal")
			->will($this->returnValue($isLocal));
		$file->expects($this->any())
			->method("getVideoId")
			->will($this->returnValue(0));
		$file->expects($this->any())
			->method("getSha1")
			->will($this->returnValue("barSha1"));
		$file->expects($this->any())
			->method("getThumbUrl")
			->will($this->returnValue("http://foo.wikia.com/bar.jpg"));

		return $file;
	}

	private function getTitleMock($text = "Foo title") {
		$title = $this->getMockBuilder("Title")
			->disableOriginalConstructor()
			->setMethods(["getText"])
			->getMock();
		$title->expects($this->any())
			->method("getText")
			->will($this->returnValue($text));

		return $title;
	}

	private function getVideoHandlerHelperMock($resetStatus) {
		$helper = $this->getMockBuilder("VideoHandlerHelper")
			->disableOriginalConstructor()
			->setMethods(["resetVideoThumb"])
			->getMock();
		$helper->expects($this->any())
			->method("resetVideoThumb")
			->will($this->returnValue($resetStatus));

		return $helper;
	}

	private function getStatusMock($isGood = true) {
		$status = $this->getMockBuilder("Status")
			->disableOriginalConstructor()
			->setMethods(["isGood", "getMessage"])
			->getMock();
		$status->expects($this->any())
			->method("isGood")
			->will($this->returnValue($isGood));
		$status->expects($this->any())
			->method("getMessage")
			->will($this->returnValue("foo message"));

		return $status;
	}

}
