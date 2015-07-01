<?php

class PortableInfoboxRenderService extends WikiaService
{
	const LOGGER_LABEL = 'portable-infobox-render-not-supported-type';
	const DESKTOP_THUMBNAIL_WIDTH = 270;
	const MOBILE_THUMBNAIL_WIDTH = 360;
	const MOBILE_TEMPLATE_POSTFIX = '-mobile';

	private $templates = [
		'wrapper' => 'PortableInfoboxWrapper.mustache',
		'title' => 'PortableInfoboxItemTitle.mustache',
		'header' => 'PortableInfoboxItemHeader.mustache',
		'image' => 'PortableInfoboxItemImage.mustache',
		'image-mobile' => 'PortableInfoboxItemImageMobile.mustache',
		'data' => 'PortableInfoboxItemData.mustache',
		'group' => 'PortableInfoboxItemGroup.mustache',
		'comparison' => 'PortableInfoboxItemComparison.mustache',
		'comparison-set' => 'PortableInfoboxItemComparisonSet.mustache',
		'comparison-set-header' => 'PortableInfoboxItemComparisonSetHeader.mustache',
		'comparison-set-item' => 'PortableInfoboxItemComparisonSetItem.mustache',
		'footer' => 'PortableInfoboxItemFooter.mustache',
		'hero-mobile' => 'PortableInfoboxItemHeroMobile.mustache'
	];
	private $templateEngine;

	function __construct()
	{
		$this->templateEngine = (new Wikia\Template\MustacheEngine)
			->setPrefix(dirname(__FILE__) . '/../templates');
	}

	/**
	 * renders infobox
	 *
	 * @param array $infoboxdata
	 * @return string - infobox HTML
	 */
	public function renderInfobox(array $infoboxdata, $theme, $layout)
	{
		wfProfileIn(__METHOD__);
		$infoboxHtmlContent = '';
		$heroData = [];

		foreach ($infoboxdata as $item) {
			$data = $item['data'];
			$type = $item['type'];

			switch ($type) {
				case 'comparison':
					$infoboxHtmlContent .= $this->renderComparisonItem($data['value']);
					break;
				case 'group':
					$infoboxHtmlContent .= $this->renderGroup($data);
					break;
				case 'footer':
					$infoboxHtmlContent .= $this->renderItem('footer', $data);
					break;
				default:
					if ($this->isInfoboxHeroEnabled() && $this->isValidHeroDataItem($item, $heroData)) {
						$heroData[$type] = $data;
						continue;
					}

					if ($this->validateType($type)) {
						$infoboxHtmlContent .= $this->renderItem($type, $data);
					};
			}
		}

		if (!empty($heroData)) {
			$infoboxHtmlContent = $this->renderInfoboxHero($heroData) . $infoboxHtmlContent;
		}

		if (!empty($infoboxHtmlContent)) {
			$output = $this->renderItem('wrapper', ['content' => $infoboxHtmlContent, 'theme' => $theme, 'layout' => $layout]);
		} else {
			$output = '';
		}

		wfProfileOut(__METHOD__);

		return $output;
	}

	/**
	 * renders comparison infobox component
	 *
	 * @param array $comparisonData
	 * @return string - comparison HTML
	 */
	private function renderComparisonItem($comparisonData)
	{
		$comparisonHTMLContent = '';

		foreach ($comparisonData as $set) {
			$setHTMLContent = '';

			foreach ($set['data']['value'] as $item) {
				$type = $item['type'];

				if ($type === 'header') {
					$setHTMLContent .= $this->renderItem(
						'comparison-set-header',
						['content' => $this->renderItem($type, $item['data'])]
					);
				} else {
					if ($this->validateType($type)) {
						$setHTMLContent .= $this->renderItem(
							'comparison-set-item',
							['content' => $this->renderItem($type, $item['data'])]
						);
					}
				}
			}

			$comparisonHTMLContent .= $this->renderItem('comparison-set', ['content' => $setHTMLContent]);
		}

		if (!empty($comparisonHTMLContent)) {
			$output = $this->renderItem('comparison', ['content' => $comparisonHTMLContent]);
		} else {
			$output = '';
		}

		return $output;
	}

	/**
	 * renders group infobox component
	 *
	 * @param array $groupData
	 * @return string - group HTML markup
	 */
	private function renderGroup($groupData)
	{
		$groupHTMLContent = '';
		$dataItems = $groupData['value'];
		$layout = $groupData['layout'];

		foreach ($dataItems as $item) {
			$type = $item['type'];

			if ($this->validateType($type)) {
				$groupHTMLContent .= $this->renderItem($type, $item['data']);
			}
		}

		return $this->renderItem('group', ['content' => $groupHTMLContent, 'layout' => $layout]);
	}

	/**
	 * renders part of infobox
	 *
	 * @param string $type
	 * @param array $data
	 * @return string - HTML
	 */
	private function renderItem($type, array $data)
	{
		//TODO: with validated the performance of render Service and in the next phase we want to refactor it (make
		// it modular) While doing this we also need to move this logic to appropriate image render class
		if ($type === 'image') {
			$data['thumbnail'] = $this->getThumbnailUrl($data['name']);
			$data['key'] = urlencode($data['key']);

			if ($this->isWikiaMobile()) {
				$type = $type . self::MOBILE_TEMPLATE_POSTFIX;
			}
		}

		return $this->templateEngine->clearData()
			->setData($data)
			->render($this->templates[$type]);
	}

	/**
	 * @desc returns the thumbnail url
	 * @param string $title
	 * @return string thumbnail url
	 */
	protected function getThumbnailUrl($title)
	{
		$file = \WikiaFileHelper::getFileFromTitle($title);

		if ($file) {
			return $file->createThumb(
				$this->isWikiaMobile() ?
					self::MOBILE_THUMBNAIL_WIDTH :
					self::DESKTOP_THUMBNAIL_WIDTH
			);
		}

		return '';
	}

	/**
	 * required for testing mobile template rendering
	 * @return bool
	 */
	protected function isWikiaMobile()
	{
		return F::app()->checkSkin('wikiamobile');
	}

	/**
	 * check if item type is supported and logs unsupported types
	 *
	 * @param string $type - template type
	 * @return bool
	 */
	private function validateType($type)
	{
		$isValid = true;

		if (!isset($this->templates[$type])) {
			Wikia\Logger\WikiaLogger::instance()->info(self::LOGGER_LABEL, [
				'type' => $type
			]);

			$isValid = false;
		}

		return $isValid;
	}

	/**
	 * returns true if infobox hero component should be rendered
	 *
	 * @return bool
	 */
	private function isInfoboxHeroEnabled()
	{
		return $this->isWikiaMobile();
	}

	/**
	 * checks if infobox data item is valid hero component data
	 *
	 * @param array $item - infobox data item
	 * @param array $heroData - hero component data
	 * @return bool
	 */
	private function isValidHeroDataItem($item, $heroData)
	{
		$isValid = false;
		$type = $item['type'];

		if (
			$type === 'title' && !array_key_exists('title', $heroData) ||
			$type === 'image' && !array_key_exists('image', $heroData)
		) {
			$isValid = true;
		}

		return $isValid;
	}

	/**
	 * renders infobox hero component
	 *
	 * @param array $data - infobox hero component data
	 * @return string
	 */
	private function renderInfoboxHero($data)
	{
		return array_key_exists('image', $data) ?
			$this->renderItem('hero-mobile', $data) :
			$this->renderItem('title', $data['title']);
	}
}
