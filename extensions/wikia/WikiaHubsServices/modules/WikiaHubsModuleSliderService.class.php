<?
class WikiaHubsModuleSliderService extends WikiaHubsModuleEditableService {
	const MODULE_ID = 1;

	public function getFormFields() {
		$fields = array();

		$model = new WikiaHubsSliderModel();
		$slidesCount = $model->getSlidesCount();

		for ($i = 1; $i <= $slidesCount; $i++) {
			$fields['photo' . $i] = array(
				'type' => 'hidden',
				'validator' => new WikiaValidatorFileTitle(
					array(
						'required' => true
					),
					array('wrong-file' => 'wikia-hubs-validator-wrong-file')
				),
				'attributes' => array(
					'class' => 'required wmu-file-name-input'
				),
				'class' => 'hidden'
			);

			$fields['strapline' . $i] = array(
				'label' => wfMessage('wikia-hubs-module-slider-strapline')->text(),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'wikia-hubs-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required'
				)
			);

			$fields['shortDesc' . $i] = array(
				'label' => wfMessage('wikia-hubs-module-slider-short-description')->text(),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'wikia-hubs-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required'
				)
			);

			$fields['longDesc' . $i] = array(
				'label' => wfMessage('wikia-hubs-module-slider-long-description')->text(),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'wikia-hubs-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required'
				)
			);

			$fields['url' . $i] = array(
				'label' => wfMessage('wikia-hubs-module-slider-url')->text(),
				'validator' => new WikiaValidatorRestrictiveUrl(
					array(
						'required' => true
					),
					array(
						'wrong' => 'wikia-hubs-validator-wrong-url'
					)
				),
				'attributes' => array(
					'class' => 'required wikiaUrl'
				),
				'class' => 'borderNone'
			);
		}

		return $fields;
	}

	public function renderEditor($data) {
		$sliderModel = new WikiaHubsSliderModel();
		$data['slidesCount'] = $sliderModel->getSlidesCount();
		$data['photos'] = array();

		$model = new EditHubModel();
		$imageSize = $model->getThumbnailSize();
		for ($i = 1; $i <= $data['slidesCount']; $i++) {
			$photo = $data['form']->getField('photo' . $i);
			if (!empty($photo['value'])) {
				$imageData = $this->getImageInfo($photo['value'], $imageSize);
				$data['photos'][$i]['url'] = $imageData->getUrlGenerator()->url();
				$data['photos'][$i]['imageWidth'] = $imageData->getWidth();
				$data['photos'][$i]['imageHeight'] = $imageData->getHeight();
			}
		}

		return parent::renderEditor($data);
	}

	public function filterData($data) {
		$data = parent::filterData($data);

		$model = new WikiaHubsSliderModel();
		$slidesCount = $model->getSlidesCount();

		for ($i = 1; $i <= $slidesCount; $i++) {
			if (!empty($data['url' . $i])) {
				$data['url' . $i] = $this->addProtocolToLink($data['url' . $i]);
			}
		}

		return $data;
	}

	public function getStructuredData($data) {
		$structuredData = array();

		if( !empty( $data ) ) {

			$model = new WikiaHubsSliderModel();
			$slidesCount =  $model->getSlidesCount();

			for( $i = 1; $i <= $slidesCount; $i++ ) {
				$structuredData['slides'][] = [
					'photoUrl' => $this->getImageInfo($data['photo'.$i])->getUrlGenerator()->url(),
					'strapline' => $data['strapline'.$i],
					'shortDesc' => $data['shortDesc'.$i],
					'longDesc' => $data['longDesc'.$i],
					'url' => $data['url'.$i],
					'photoName' => $data['photo'.$i],
				];
			}
		}

		return $structuredData;
	}

	public function render($structureData) {
		$data['wikitextslider'] = $this->getWikitext($structureData);

		return parent::render($data);
	}

	public function getWikitext($data) {
		$galleryText = '<gallery type="slider" orientation="mosaic">';
		foreach($data['slides'] as $slide) {
			$galleryText .= "\n" . implode('|',array(
					$this->app->wg->ContLang->getNsText( NS_FILE ) . ':' . $slide['photoName'],
					"'''" . $slide['strapline'] . "'''",
					'link=' . $slide['url'],
					'linktext=' . $slide['longDesc'],
					'shorttext=' . $slide['shortDesc']
				)
			);
		}
		$galleryText .= "\n</gallery>";
		return $galleryText;
	}

	/**
	 * Remove slides from
	 * @param $data
	 * @return mixed
	 */
	protected function filterCommercialData( $data ) {
		$service = $this->getLicensedWikisService();
		$data['slides'] = array_values( array_filter( $data['slides'], function( $element ) use($service) {
				return $service->isCommercialUseAllowedByUrl($element['url']);
			} ) );
		return $data;
	}
}
