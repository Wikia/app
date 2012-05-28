<?

class MediaToolSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('MediaTool');
	}

	public function index() {
		// @todo move to the right place
		$this->wg->Out->addHTML( F::build('JSSnippets')->addToStack( array( "/extensions/wikia/MediaTool/js/MediaTool.js" ), array(), 'MediaTool.init' ) );

		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/MediaTool/css/MediaTool.scss'));

		$response = F::app()->sendRequest(
			'MediaToolController',
			'getModalContent',
			array()
		);

		$this->setVal("content", $response);
	}

}