<?php
abstract class MarketingToolboxModuleService extends WikiaService {
	const CLASS_NAME_PREFIX = 'MarketingToolboxModule';
	const CLASS_NAME_SUFFIX = 'Service';

	protected $langCode;
	protected $sectionId;
	protected $verticalId;
	protected $skinName;

	public function __construct($langCode, $sectionId, $verticalId) {
		parent::__construct();

		$this->langCode = $langCode;
		$this->sectionId = $sectionId;
		$this->verticalId = $verticalId;
		$this->skinName = RequestContext::getMain()->getSkin()->getSkinName();
	}

	abstract public function getStructuredData($data);

	static public function getModuleByName($name, $langCode, $sectionId, $verticalId) {
		$moduleClassName = self::CLASS_NAME_PREFIX . $name . self::CLASS_NAME_SUFFIX;
		return new $moduleClassName($langCode, $sectionId, $verticalId);
	}

	public function render($data) {
		return $this->getView('index', $data);
	}

	public function loadData($model, $params) {
		$lastTimestamp = $model->getLastPublishedTimestamp(
			$this->langCode,
			$this->sectionId,
			$this->verticalId,
			$params['ts']
		);

		$structuredData = WikiaDataAccess::cache(
			$this->getMemcacheKey($lastTimestamp, $this->skinName),
			6 * 60 * 60,
			function () use( $model, $params ) {
				return $this->loadStructuredData( $model, $params );
			}
		);

		return $structuredData;
	}

	protected function loadStructuredData( $model, $params ) {
		$moduleData = $model->getPublishedData(
			$this->langCode,
			$this->sectionId,
			$this->verticalId,
			$params['ts'],
			$this->getModuleId()
		);

		if( empty($moduleData[$this->getModuleId()]['data']) ) {
			$moduleData = array();
		} else {
			$moduleData = $moduleData[$this->getModuleId()]['data'];
		}

		$structuredData = array();
		if (!empty($moduleData)) {
			$structuredData = $this->getStructuredData($moduleData);
		}

		return $structuredData;
		}

	protected function getModuleId() {
		return static::MODULE_ID;
	}

	protected function getView($viewName, $data) {
		return $this->app->getView(get_class($this), $viewName, $data);
	}

	protected function getImageInfo($fileName, $destSize = 0) {
		return ImagesService::getLocalFileThumbUrlAndSizes($fileName, $destSize, ImagesService::EXT_JPG);
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

	public function purgeMemcache($timestamp) {
		foreach(Skin::getSkinNames() as $key => $skin) {
			$this->app->wg->Memc->delete( $this->getMemcacheKey($timestamp, $key) );
		}
	}

	protected function getMemcacheKey( $timestamp, $skin ) {
		return  wfSharedMemcKey(
			MarketingToolboxModel::CACHE_KEY,
			$timestamp,
			$this->verticalId,
			$this->langCode,
			$this->getModuleId(),
			$skin
		);
	}

	/**
	 * check if it is video module
	 * @return boolean
	 */
	public function isVideoModule() {
		return false;
	}

}
