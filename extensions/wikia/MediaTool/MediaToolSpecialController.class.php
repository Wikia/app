<?

class MediaToolSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('MediaTool');
	}

	public function index() {
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/MediaTool/css/MediaTool.scss'));
	}

}