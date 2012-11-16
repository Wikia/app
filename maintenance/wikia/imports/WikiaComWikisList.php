<?
/**
 * How to run this script:
 * $ cd /maintenance/wikia/imports
 * for English version:
 * $ SERVER_ID=80433 php WikiaComWikisList.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php --file='../../../extensions/wikia/WikiaHomePage/text_files/Top wikis for wikia.com - Ready for upload.csv'
 * for German version:
 * $ SERVER_ID=111264 php WikiaComWikisList.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php --file='../../../extensions/wikia/WikiaHomePage/text_files/Top wikis for de.wikia.com.csv'
 * Optional parameter
 * --message='TestMessageForVisualisation_test'
 * --overwritelang=en
 * --skipupload
 * --addimageuploadtask
 */
require_once("../../commandLine.inc");
global $wgEnableSpecialPromoteExt, $wgEnablePromoteImageReviewExt;

$putItToAmessage = isset($options['message']) ? true : false;

$params = new stdClass();
$params->csvContent = explode("\n", file_get_contents($options['file']));
$params->overwrittenLang = isset($options['overwritelang']) ? $options['overwritelang'] : false;
$params->skipUpload = isset($options['skipupload']) ? true : false;
$params->addImageUploadTask = isset($options['addimageuploadtask']) ? true : false;

if( $params->overwrittenLang !== false ) {
	$params->overwrittenLang = strtolower( substr($params->overwrittenLang, 0, 2) );
}

if( empty($wgEnableSpecialPromoteExt) ) {
	include_once('../../../extensions/wikia/SpecialPromote/UploadVisualizationImageFromFile.class.php');
}

if( true === $params->addImageUploadTask && empty($wgEnablePromoteImageReviewExt) ) {
	include_once('../../../extensions/wikia/ImageReview/modules/PromoteImage/PromoteImageReviewTask.php');
}

if( $putItToAmessage ) {
	echo 'Importing wikis to a MediaWiki message...'."\n";
	$params->mediaWikiMessage = $options['message'];
	$import = new WikiaComWikisListImport($params);
	$import->loadDataAndUpdateMessage();
} else {
	echo 'Importing wikis to database...'."\n";
	$import = new WikiaComWikisListImport($params);
	$import->loadDataAndUpdateDatabase();
}

class WikiaComWikisListImport {
	const SPREADSHEET_FIRST_ADD_IMG_IDX = 6;
	const SPREADSHEET_LAST_ADD_IMG_IDX = 5;

	protected $options = null;
	protected $verticalsNames = array('Video Games', 'Entertainment', 'Lifestyle');
	protected $wikisAdded = array();
	protected $wikisNotAdded = array();
	protected $wikisUpdated = array();
	protected $wikisPerVertical = array();
	protected $faileduploads = array('main-images' => array(), 'slider-images' => array());
	protected $okuploads = array('main-images' => array(), 'slider-images' => array());
	protected $fileexists = array('main-images' => array(), 'slider-images' => array());

	public function __construct($options) {
		$this->options = $options;
		array_shift($this->options->csvContent);
	}

	protected function areAllRequiredWikiDataForMediaWikiMessageSet($data) {
		wfProfileIn(__METHOD__);

		if( !empty($data[2]) && !empty($data[4]) && in_array($data[3], $this->verticalsNames) ) {
			$res = true;
		} else {
			$res = false;
		}
		wfProfileOut(__METHOD__);
		return $res;
	}

	protected function areAllRequiredWikiDataForDatabaseSet($data) {
		wfProfileIn(__METHOD__);

		if( !empty($data[2]) && !empty($data[4]) ) {
			$res = true;
		} else {
			$res = false;
		}
		wfProfileOut(__METHOD__);
		return $res;
	}

	public function loadDataAndUpdateMessage() {
		wfProfileIn(__METHOD__);

		$verticals = array(
			$this->verticalsNames[0] => array(),
			$this->verticalsNames[1] => array(),
			$this->verticalsNames[2] => array()
		);

		foreach($this->options->csvContent as $line) {
			$element = str_getcsv($line, ',', '"');

			if( $this->areAllRequiredWikiDataForMediaWikiMessageSet($element) ) {
				$wikiUrl = $element[2];
				$wikiDomain = trim( str_replace('http://', '', $wikiUrl), '/');
				$wikiId = WikiFactory::DomainToID($wikiDomain);

				$wikiHeadline = $element[1];
				$wikiVertical = $element[3];
				$wikiMainImageUrl = $element[4];
				$wikiDesc = $element[5];
				$spreadSheetImageName = basename($element[4]);
				$wikiImageName = $this->getCorpDestImageName($wikiUrl, $spreadSheetImageName);

				if( !$this->options->skipUpload ) {
					$this->uploadImage($wikiMainImageUrl, $wikiImageName, $wikiId);
				}

				$wikiUrl = (
					(stripos($wikiUrl, 'http://') === false)
						&& (stripos($wikiUrl, 'https://') === false)
				) ? ('http://' . $wikiUrl) : $wikiUrl;

				$verticals[$wikiVertical][] = '**' . $wikiHeadline . '|' . $wikiUrl . '|' . $wikiImageName . '|' . $wikiDesc;
			}
		}

		$title = Title::newFromText($this->options->mediaWikiMessage, NS_MEDIAWIKI);
		$article = new Article($title);
		$content = $this->parseWikisList(0, $verticals) . $this->parseWikisList(1, $verticals) . $this->parseWikisList(2, $verticals);
		$summary = "automated import";
		$article->doEdit($content, $summary);

		$this->uploadImagesOnWikis();
		$this->displayStatus();

		wfProfileOut(__METHOD__);
	}

	public function loadDataAndUpdateDatabase() {
		global $wgCityId;
		wfProfileIn(__METHOD__);

		if( !$this->options->overwrittenLang ) {
			$wikisVisualizationLangCode = WikiFactory::getVarValueByName('wgLanguageCode', $wgCityId);
		} else {
			$wikisVisualizationLangCode = $this->options->overwrittenLang;
		}

		echo "\n";
		echo 'Uploading wikis for "'.$wikisVisualizationLangCode.'" visualization: ';
		echo "\n";

		foreach( $this->options->csvContent as $line ) {
			$element = str_getcsv($line, ',', '"');

			if( $this->areAllRequiredWikiDataForDatabaseSet($element) ) {
				$wikiDomain = trim( str_replace('http://', '', $element[2]), '/');
				$wikiId = WikiFactory::DomainToID($wikiDomain);

				$spreadSheetImageName = basename($element[4]);
				$wikiMainImageUrl = $element[4];
				$wikiMainImageName = $this->getCorpDestImageName($wikiDomain, $spreadSheetImageName);
				$sliderImages = $this->getSliderImages( array_slice($element, self::SPREADSHEET_FIRST_ADD_IMG_IDX, self::SPREADSHEET_LAST_ADD_IMG_IDX) );

				$wikiHeadline = !empty($element[1]) ? $element[1] : '';
				$wikiDesc = !empty($element[5]) ? $element[5] : wfMsg( 'wikiahome-import-script-no-description' );

				if( !$this->options->skipUpload ) {
					//upload main image
					$this->uploadImage($wikiMainImageUrl, $wikiMainImageName, $wikiId);

					//upload slider images
					$sliderUploadedImages = $this->uploadSliderImages($wikiDomain, $sliderImages, $wikiId);
				}

				if( $wikiId > 0 ) {
					$wikiCityVertical = HubService::getComscoreCategory($wikiId);

					$sliderUploadedImages = (!empty($sliderUploadedImages)) ? json_encode($sliderUploadedImages) : null;
					$this->addToVisualizationTable(
						array(
							'city_id' => $wikiId,
							'city_lang_code' => $wikisVisualizationLangCode,
							'city_vertical' => $wikiCityVertical,
							'city_headline' => $wikiHeadline,
							'city_description' => $wikiDesc,
							'city_main_image' => $wikiMainImageName,
							'city_images' => $sliderUploadedImages,
						)
					);
				} else {
					$this->wikisNotAdded[] = $wikiDomain.' ('.$wikiId.') ';
				}

			}
		}

		$this->uploadImagesOnWikis();
		$this->displayStatus();

		wfProfileOut(__METHOD__);
	}

	protected function parseWikisList($verticalIndex, $verticals) {
		wfProfileIn(__METHOD__);
		$return = '*' . $this->verticalsNames[$verticalIndex] . "\n";
		foreach( $verticals[$this->verticalsNames[$verticalIndex]] as $line ) {
			$return .= $line . "\n";
		}

		wfProfileOut(__METHOD__);
		return $return;
	}

	protected function getCorpDestImageName($wikiUrl, $origImageName, $index = false) {
		wfProfileIn(__METHOD__);

		$wikiDomain = trim( str_replace('http://', '', $wikiUrl), '/');
		$wikiDb = WikiFactory::DomainToDB($wikiDomain);

		if( !empty($wikiDb) ) {
			if( $index === false ) {
				$resultName = UploadVisualizationImageFromFile::VISUALIZATION_MAIN_IMAGE_NAME;
				$resultNameArr = explode('.', $resultName);
				$resultName = $resultNameArr[0].','.$wikiDb.UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_EXT;
			} else {
				$resultName = UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME.'-'.$index.','.$wikiDb.UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_EXT;
			}
		} else {
			$resultName = $origImageName;
		}

		wfProfileOut(__METHOD__);
		return $resultName;
	}

	protected function displayStatus() {
		wfProfileIn(__METHOD__);

		if( !$this->options->skipUpload ) {
			$okMainImagesUpload = count($this->okuploads['main-images']);
			$failedMainUploads = count($this->faileduploads['main-images']);
			$mainFileExists = count($this->fileexists['main-images']);
			$totalMainImages = ($okMainImagesUpload + $failedMainUploads + $mainFileExists);

			$okSliderImagesUpload = count($this->okuploads['slider-images']);
			$failedSliderUploads = count($this->faileduploads['slider-images']);
			$sliderFileExists = count($this->fileexists['slider-images']);
			$totalSliderImages = ($okSliderImagesUpload + $failedSliderUploads + $sliderFileExists);

			echo "\n";
			echo '== Summary for importing images: ==';
			echo "\n";
			echo 'Total main images processed: ' . $totalMainImages;
			echo "\n";
			echo 'OK uploads: ' . $okMainImagesUpload . '/' . $totalMainImages;
			echo "\n";
			echo 'Total slider images processed: ' . $totalSliderImages;
			echo "\n";
			echo 'OK uploads: ' . $okSliderImagesUpload . '/' . $totalSliderImages;
			echo "\n";

			if( !empty($this->faileduploads['slider-images']) || !empty($this->faileduploads['slider-images']) ) {
				echo 'Failed uploads: ' . ($failedMainUploads + $failedSliderUploads) . '/' . ($totalMainImages + $totalSliderImages);
				echo "\n";
				echo 'Failed uploads list:';
				echo "\n";
				foreach( $this->faileduploads['main-images'] as $filename ) {
					echo $filename . "\n";
				}
				foreach( $this->faileduploads['slider-images'] as $filename ) {
					echo $filename . "\n";
				}
			}

			$this->faileduploads = array('main-images' => array(), 'slider-images' => array());
			$this->okuploads = array('main-images' => array(), 'slider-images' => array());
		}

		$totalwikis = (count($this->wikisAdded) + count($this->wikisUpdated) + count($this->wikisNotAdded));
		echo "\n";
		echo '== Summary for importing wikis: ==';
		echo "\n";
		echo 'Total wikis processed: ' . $totalwikis;
		echo "\n";
		echo 'Added in this run: ' . count($this->wikisAdded) . '/' . $totalwikis;
		echo "\n";
		echo 'Updated in this run: ' . count($this->wikisUpdated) . '/' . $totalwikis;
		echo "\n";

		if( !empty($this->wikisNotAdded) ) {
			echo 'Failed: ' . count($this->wikisNotAdded) . '/' . $totalwikis;
			echo "\n";
			echo 'Failed wikis url list:';
			echo "\n";
			foreach( $this->wikisNotAdded as $url ) {
				echo $url . "\n";
			}
		}

		echo 'Done.'."\n";

		wfProfileOut(__METHOD__);
	}

	protected function uploadImage($imageUrl, $imageName, $wikiId, $isSliderImage = false) {
		wfProfileIn(__METHOD__);

		$success = false;

		//fb#45624
		$user = F::build('User', array('WikiaBot'), 'newFromName');
		$user = ($user instanceof User) ? $user : null;
		$imageData = new stdClass();
		$imageData->name = $imageName;
		$imageData->description = $imageData->comment = wfMsg('wikiahome-image-auto-uploaded-comment');

		$result = ImagesService::uploadImageFromUrl($imageUrl, $imageData, $user);

		if( $isSliderImage ) {
			$statusArrayKey = 'slider-images';
		} else {
			$statusArrayKey = 'main-images';
		}

		if( $result['status'] === true ) {
			$this->okuploads[$statusArrayKey][] = array('city_id' => $wikiId, 'id' => $result['page_id'], 'name' => $imageName);
			echo '.';
			$success = true;
		} else {
			if (!empty($result['errors'][0]['message']) && $result['errors'][0]['message'] === 'filerenameerror') {
				$this->fileexists[$statusArrayKey][] = $imageName;
				echo '!';
			} else {
				$this->faileduploads[$statusArrayKey][] = $imageName;
				echo '.';
			}
		}

		wfProfileOut(__METHOD__);
		return $success;
	}

	protected function uploadSliderImages($wikiDomain, $sliderImages, $wikiId) {
		wfProfileIn(__METHOD__);
		$uploadedImages = array();

		$index = 1;
		foreach( $sliderImages as $sliderImageUrl ) {
			if( !empty($sliderImageUrl) ) {
				$wikiSliderImageUrl = $sliderImageUrl;
				$spreadSheetImageName = basename($sliderImageUrl);
				$wikiSliderImageName = $this->getCorpDestImageName($wikiDomain, $spreadSheetImageName, $index);

				if( $this->uploadImage($wikiSliderImageUrl, $wikiSliderImageName, $wikiId, true) ) {
					$uploadedImages[] = $wikiSliderImageName;
				}
				$index++;
			}
		}

		wfProfileOut(__METHOD__);
		return $uploadedImages;
	}

	protected function getSliderImages(Array $spreadsheetColumns) {
		wfProfileIn(__METHOD__);
		$sliderImages = array();

		foreach($spreadsheetColumns as $imgUrl) {
			if( !empty($imgUrl) ) {
				$sliderImages[] = $imgUrl;
			}
		}

		wfProfileOut(__METHOD__);
		return $sliderImages;
	}

	protected function addToVisualizationTable($wikiData) {
		global $wgSharedKeyPrefix;
		wfProfileIn(__METHOD__);

		$wikiId = intval($wikiData['city_id']);
		$wikiVertical = $wikiData['city_vertical'];

		if( isset($this->wikisPerVertical[$wikiVertical->cat_name]) ) {
			$this->wikisPerVertical[$wikiVertical->cat_name]++;
		} else {
			$this->wikisPerVertical[$wikiVertical->cat_name] = 1;
		}

		$db = wfGetDb(DB_MASTER, array(), $wgSharedKeyPrefix);
		$row = $db->selectRow('wikicities.city_visualization',
			array('city_id'),
			array('city_id' => $wikiId)
		);

		if (false === $row) {
			$res = $db->insert('wikicities.city_visualization', array(
				'city_id' => $wikiId,
				'city_lang_code' => $wikiData['city_lang_code'],
				'city_vertical' => $wikiVertical->cat_id,
				'city_headline' => $wikiData['city_headline'],
				'city_description' => $wikiData['city_description'],
				'city_main_image' => $wikiData['city_main_image'],
				'city_images' => $wikiData['city_images'],
			));

			if( $res ) {
				$this->wikisAdded[] = $wikiId;
			} else {
				$this->wikisNotAdded[] = $wikiId;
			}
		} else {
			$res = $db->update(
				'wikicities.city_visualization',
				array(
					'city_vertical' => $wikiVertical->cat_id,
					'city_headline' => $wikiData['city_headline'],
					'city_description' => $wikiData['city_description'],
					'city_main_image' => $wikiData['city_main_image'],
					'city_images' => $wikiData['city_images'],
				),
				array(
					'city_id' => $wikiId,
				)
			);

			if( $res ) {
				$this->wikisUpdated[] = $wikiId;
			} else {
				$this->wikisNotAdded[] = $wikiId;
			}
		}

		wfProfileOut(__METHOD__);
	}

	protected function uploadImagesOnWikis() {
		global $wgCityId;
		wfProfileIn(__METHOD__);

		if( !$this->options->skipUpload && $this->options->addImageUploadTask ) {
			$taskAdditionList = array();
			foreach($this->okuploads['main-images'] as $image) {
				$targetWikiId = $image['city_id'];
				$targetWikiDbName = WikiFactory::IDtoDB($targetWikiId);
				$image['name'] = str_replace(',' . $targetWikiDbName, '', $image['name']);
				$taskAdditionList[$targetWikiId][$wgCityId][] = $image;
			}

			foreach($this->okuploads['slider-images'] as $image) {
				$targetWikiId = $image['city_id'];
				$targetWikiDbName = WikiFactory::IDtoDB($targetWikiId);
				$image['name'] = str_replace(',' . $targetWikiDbName, '', $image['name']);
				$taskAdditionList[$targetWikiId][$wgCityId][] = $image;
			}

			$task = new PromoteImageReviewTask();
			$task->createTask(
				array(
					'upload_list' => $taskAdditionList,
				),
				TASK_QUEUED
			);
		}

		wfProfileOut(__METHOD__);
	}

}
