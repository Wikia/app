<?php
/**
 * PdfHandlerTask
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

use Wikia\Tasks\Tasks\BaseTask;

class PdfHandlerTask extends BaseTask {
	public function createSmallThumb($page) {

	}

	public function createBigThumb($page) {

	}

	public static function onUploadVerifyFile($upload, $mime, &$error) {
		\Wikia\Logger\WikiaLogger::instance()->error('About to instantiate CreatePdfThumbnailsJob. MIGRATE!');
		return CreatePdfThumbnailsJob::insertJobs($upload, $mime, $error);
	}
}