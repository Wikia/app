<?
class MarketingToolboxModuleSliderService extends MarketingToolboxModuleService {
	const MODULE_ID = 1;

	protected function getFormFields() {
		$fields = array();

		$model = new MarketingToolboxSliderModel();
		$slidesCount = $model->getSlidesCount();

		for ($i = 1; $i <= $slidesCount; $i++) {
			$fields['photo' . $i] = array(
				'type' => 'hidden',
				'validator' => new WikiaValidatorFileTitle(
					array(
						'required' => true
					),
					array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
				),
				'attributes' => array(
					'class' => 'required wmu-file-name-input'
				),
				'class' => 'hidden'
			);

			$fields['shortDesc' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-slider-short-description'),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required'
				)
			);

			$fields['longDesc' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-slider-long-description'),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required'
				)
			);

			$fields['url' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-slider-url'),
				'validator' => new WikiaValidatorToolboxUrl(
					array(
						'required' => true
					),
					array(
						'wrong' => 'marketing-toolbox-validator-wrong-url'
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
		$sliderModel = new MarketingToolboxSliderModel();
		$data['slidesCount'] = $sliderModel->getSlidesCount();
		$data['photos'] = array();

		$model = new MarketingToolboxModel();
		$imageSize = $model->getThumbnailSize();
		for ($i = 1; $i <= $data['slidesCount']; $i++) {
			if (!empty($data['values']['photo' . $i])) {
				$imageData = ImagesService::getLocalFileThumbUrlAndSizes($data['values']['photo' . $i], $imageSize);
				$data['photos'][$i]['url'] = $imageData->url;
				$data['photos'][$i]['imageWidth'] = $imageData->width;
				$data['photos'][$i]['imageHeight'] = $imageData->height;
			}
		}

		return parent::renderEditor($data);
	}

	public function getStructuredData($data) {
		return $data;
	}
	
	public function render($structureData) {
		//TODO: removed mocked data once FB#98041 is done
		$data['wikitextslider'] =
<<<POLLS
<gallery type="slider" orientation="mosaic">
New-super-mario-bros-u.jpg|'''Game Tips for New Super Mario Bros. U'''|link=http://mario.wikia.com/wiki/User_blog:TheBlueRogue/New_Super_Mario_Bros._U_Game_Tips|linktext=Defeat the Koopas and save Princess Peach!|shorttext=Mario Bros. U 
Medal-of-Honor-Warfighter-Zero-Dark-Thirty-Map-Pack-Trailer_1.jpg|'''Zero Dark Thirty Map Pack'''|link=http://medalofhonor.wikia.com/wiki/Zero_Dark_Thirty_Map_Pack|linktext=What are you waiting for? Join the manhunt now.|shorttext=MOH: Warfighter
Street-Fighter-X-Mega-Man.jpg|'''Meet the Character: Mega Man'''|link=http://megaman.wikia.com/wiki/Mega_Man_%28character%29|linktext=Streetfighter X Mega Man is out today. For free.|shorttext=Mega Man 
Crysis3_hero_041612.jpg|'''The 7 Wonders of Crysis 3'''|link=http://crysis.wikia.com/wiki/File:The_7_Wonders_of_Crysis_3|link=http://crysis.wikia.com/wiki/File:The_7_Wonders_of_Crysis_3|linktext=Episode 1 of this new video series packs a punch|shorttext=7 Wonders of Crysis 3
Far-Cry-3.jpg|'''Far Cry Walkthrough'''|link=http://farcry.wikia.com/wiki/Category:Far_Cry_3_Missions|linktext=Survival tips for a dangerous island.|shorttext=Far Cry 3
</gallery>
POLLS;

		return parent::render($data);
	}

	public function filterData($data) {
		$data = parent::filterData($data);

		$model = new MarketingToolboxSliderModel();
		$slidesCount = $model->getSlidesCount();

		for ($i = 1; $i <= $slidesCount; $i++) {
			if (!empty($data['url' . $i])) {
				$data['url' . $i] = $this->addProtocolToLink($data['url' . $i]);
			}
		}

		return $data;
	}

	public function getStructuredData($data) {
		$model = new MarketingToolboxSliderModel();
		$slidesCount =  $model->getSlidesCount();
		$structuredData = array();

		if( !empty( $data ) ) {
			for( $i = 1; $i <= $slidesCount; $i++ ) {
				$imageData = ImagesService::getLocalFileThumbUrlAndSizes($data['photo'.$i]);
				$structuredData['slides'][] = array(
									'photoUrl' => $imageData->url,
									'shortDesc' => $data['shortDesc'.$i],
									'longDesc' => $data['longDesc'.$i],
									'url' => $data['url'.$i],
									'photoName' => $data['photo'.$i],
									'photoAlt' => $imageData->title
								);
			}
		}

		return $structuredData;
	}
}
