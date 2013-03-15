<?php
abstract class MarketingToolboxModuleService extends WikiaService {
	const CLASS_NAME_PREFIX = 'MarketingToolboxModule';
	const CLASS_NAME_SUFFIX = 'Service';

	protected $langCode;
	protected $sectionId;
	protected $verticalId;

	public function __construct($langCode, $sectionId, $verticalId) {
		parent::__construct();

		$this->langCode = $langCode;
		$this->sectionId = $sectionId;
		$this->verticalId = $verticalId;
	}

	static public function getModuleByName($name, $langCode, $sectionId, $verticalId) {
		$moduleClassName = self::CLASS_NAME_PREFIX . $name . self::CLASS_NAME_SUFFIX;
		return new $moduleClassName($langCode, $sectionId, $verticalId);
	}

	public function render($data) {
		return $this->getView('index', $data);
	}

	public function loadData($model, $params) {
		$lastTimestamp = $model->getLastPublishedTimestamp(
			$params['lang'],
			$model::SECTION_HUBS,
			$params['vertical_id'],
			$params['ts']
		);

		$structuredData = WikiaDataAccess::cache(
				$this->wf->SharedMemcKey(
					$model::CACHE_KEY,
					$lastTimestamp,
					$this->verticalId,
					$params['lang'],
					$this->getModuleId()
				),
				6 * 60 * 60,
				function () use( $model, $params ) {
					return $this->loadStructuredData( $model, $params );
				}
		);

		return $structuredData;
	}

	protected function loadStructuredData( $model, $params ) {
		$moduleData = $model->getPublishedData(
			$params['lang'],
			MarketingToolboxModel::SECTION_HUBS,
			$this->verticalId,
			$params['ts'],
			$this->getModuleId()
		);

		if( empty($moduleData[$this->getModuleId()]['data']) ) {
			$moduleData = array();
		} else {
			$moduleData = $moduleData[$this->getModuleId()]['data'];
		}

		return $this->getStructuredData($moduleData);
	}

	protected function getModuleId() {
		return static::MODULE_ID;
	}

	protected function getView($viewName, $data) {
		return $this->app->getView(get_class($this), $viewName, $data);
	}

	protected function getImageInfo($fileName, $destSize = 0) {
		return ImagesService::getLocalFileThumbUrlAndSizes($fileName, $destSize);
	}

	/**
	 * @desc Creates sponsored image markup which is then passed to wfMessage()
	 * 
	 * @param $imageTitleText
	 * @return string
	 */
	protected function getSponsoredImageMarkup($imageTitleText) {
		$sponsoredImageInfo = $this->getImageInfo($imageTitleText);
		return Xml::element('img', array(
			'alt' => $sponsoredImageInfo->title,
			'class' => 'sponsored-image',
			'height' => $sponsoredImageInfo->height,
			'src' => $sponsoredImageInfo->url,
			'width' => $sponsoredImageInfo->width,
		), '', true);
	}

	/**
	 * @param Array $params
	 * @return array
	 */
	protected function prepareParameters($params) {
		return $params;
	}

	protected function addProtocolToLink($link) {
		if (strpos($link, 'http://') === false && strpos($link, 'https://') === false) {
			$link = 'http://' . $link;
		}

		return $link;
	}
}
