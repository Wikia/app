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
 * --skipupload=1
 * --overwritelang=en
 */
require_once("../../commandLine.inc");

const WIKIA_COM_WIKIS_LIST_MAIN = 'main';
const WIKIA_COM_WIKIS_LIST_ADDITIONAL = 'additional';

$csv = explode("\n", file_get_contents($options['file']));
$putItToAmessage = isset($options['message']) ? true : false;
$skipUpload = isset($options['skipupload']) ? true : false;
$overwrittenLang = isset($options['overwritelang']) ? $options['overwritelang'] : false;

if( $overwrittenLang !== false ) {
	$overwrittenLang = strtolower( substr($overwrittenLang, 0, 2) );
}

array_shift($csv);

if ($putItToAmessage) {
	$mediaWikiMessage = $options['message'];
	loadDataAndUpdateMessage($csv, $mediaWikiMessage, $skipUpload);
} else {
	loadDataAndUpdateDatabase($csv, $skipUpload, $overwrittenLang);
}

function loadDataAndUpdateMessage($csv, $mediaWikiMessage, $skipUpload) {
	$verticalsNames = array('Video Games', 'Entertainment', 'Lifestyle');
	$verticals = array(
		$verticalsNames[0] => array(),
		$verticalsNames[1] => array(),
		$verticalsNames[2] => array()
	);

	$faileduploads = array();
	$okuploads = array();
	foreach ($csv as $line) {
		$element = str_getcsv($line, ',', '"');

		if (
			!empty($element[2])
			&& !empty($element[4])
			&& in_array($element[3], $verticalsNames)
		) {
			$wikiHeadline = $element[1];
			$wikiUrl = $element[2];
			$wikiVertical = $element[3];
			$wikiMainImageUrl = $element[4];
			$wikiImageName = basename($element[4]);
			$wikiDesc = $element[5];

			if( !$skipUpload ) {
				$result = uploadImage($wikiMainImageUrl, $wikiImageName);
				if( $result === true ) {
					$okuploads[] = $wikiImageName;
					echo '.';
				} else {
					$faileduploads[] = $wikiImageName;
					echo '!';
				}
			}

			$wikiUrl = (
				(stripos($wikiUrl, 'http://') === false)
					&& (stripos($wikiUrl, 'https://') === false)
			) ? ('http://' . $wikiUrl) : $wikiUrl;

			$verticals[$wikiVertical][] = '**' . $wikiHeadline . '|' . $wikiUrl . '|' . $wikiImageName . '|' . $wikiDesc;
		}
	}

	if( !$skipUpload ) {
		$totalimages = (count($faileduploads) + count($okuploads));
		echo "\n";
		echo 'Summary for importing images:';
		echo "\n";
		echo 'Total images processed: ' . $totalimages;
		echo "\n";
		echo 'OK uploads: ' . count($okuploads) . '/' . $totalimages;
		echo "\n";
		if (!empty($faileduploads)) {
			echo 'Failed uploads: ' . count($faileduploads) . '/' . $totalimages;
			echo "\n";
			echo 'Failed uploads list:';
			echo "\n";
			foreach ($faileduploads as $filename) {
				echo $filename . "\n";
			}
		}
	} else {
		echo 'Done.'."\n";
	}


	$title = Title::newFromText($mediaWikiMessage, NS_MEDIAWIKI);
	$article = new Article($title);
	$content = parseWikisList(0, $verticalsNames, $verticals)
		. parseWikisList(1, $verticalsNames, $verticals)
		. parseWikisList(2, $verticalsNames, $verticals);
	$summary = "import";
	$article->doEdit($content, $summary);
}

function loadDataAndUpdateDatabase($csv, $skipUpload, $overwrittenLang) {
	global $wgCityId;

	$faileduploads = array('main-images' => array(), 'slider-images' => array());
	$fileexists = array('main-images' => array(), 'slider-images' => array());
	$okuploads = array('main-images' => array(), 'slider-images' => array());
	$wikisAddedToTable = array();
	$wikisUpdated = array();
	$wikisNotAddedToTable = array();

	if( !$overwrittenLang ) {
		$wikisVisualizationLangCode = WikiFactory::getVarValueByName('wgLanguageCode', $wgCityId);
	} else {
		$wikisVisualizationLangCode = $overwrittenLang;
	}

	echo "\n";
	echo 'Uploading wikis for "'.$wikisVisualizationLangCode.'" visualization: ';
	echo "\n";

	foreach ($csv as $line) {
		$element = str_getcsv($line, ',', '"');

		if (!empty($element[2]) && !empty($element[4])) {
			$wikiDomain = trim( str_replace('http://', '', $element[2]), '/');
			$imageUrl = $element[4];
			$imageName = basename($imageUrl);

			$sliderImages = array();
			for ($i = 6; $i < 11; $i++) {
				if (!empty($element[$i])) {
					$sliderImages[] = $element[$i];
				}
			}

			$wikiHeadline = !empty($element[1]) ? $element[1] : '';
			$wikiDesc = !empty($element[5]) ? $element[5] : wfMsg( 'wikiahome-import-script-no-description' );
			$error = false;

			if( !$skipUpload ) {
			//upload main image
				$result = uploadImage($imageUrl, $imageName);
				if ($result['status'] === true) {
					$okuploads['main-images'][] = $imageName;
					echo '.';
				} else {
					if (!empty($result['errors'][0]['message']) && $result['errors'][0]['message'] === 'filerenameerror') {
						$fileexists['main-images'][] = $imageName;
						echo '!';
					} else {
						$faileduploads['main-images'][] = $imageName;
						$error = true;
						echo '.';
					}
				}
			//end of upload main image
			}

			if( !$skipUpload ) {
			//upload slider images
				$index = 1;
				$sliderUploadedImages = array();

				foreach ($sliderImages as $sliderImage) {
					if (!empty($sliderImage)) {
						$sliderImageName = basename($sliderImage);
						$result = uploadImage($sliderImage, $sliderImageName);
						if ($result['status'] === true) {
							$okuploads['slider-images'][] = $sliderImageName;
							$sliderUploadedImages[] = $sliderImageName;
							echo '.';
						} else {
							if (!empty($result['errors'][0]['message']) && $result['errors'][0]['message'] === 'filerenameerror') {
								$fileexists['slider-images'][] = $sliderImageName;
								echo '!';
							} else {
								$faileduploads['slider-images'][] = $sliderImageName;
								$error = true;
								echo '!';
							}
						}
						$index++;
					}
				}
			//end of upload slider images
			}

			if (!$error) {
				$wikiId = WikiFactory::DomainToID($wikiDomain);

				if ($wikiId) {
					$sliderUploadedImages = (!empty($sliderUploadedImages)) ? json_encode($sliderUploadedImages) : null;
					addToVisualizationTable(
						array(
							'city_id' => $wikiId,
							'city_lang_code' => $wikisVisualizationLangCode,
							'city_headline' => $wikiHeadline,
							'city_description' => $wikiDesc,
							'city_main_image' => $imageName,
							'city_images' => $sliderUploadedImages,
						),
						$wikisAddedToTable,
						$wikisUpdated,
						$wikisNotAddedToTable
					);
				} else {
					$wikisNotAddedToTable[] = $wikiDomain.' ('.$wikiId.') ';
				}
			}
		}
	}

	$totalwikis = (count($wikisAddedToTable) + count($wikisUpdated) + count($wikisNotAddedToTable));
	echo "\n";
	echo '== Summary for importing wikis: ==';
	echo "\n";
	echo 'Total wikis processed: ' . $totalwikis;
	echo "\n";
	echo 'Added in this run: ' . count($wikisAddedToTable) . '/' . $totalwikis;
	echo "\n";
	echo 'Updated in this run: ' . count($wikisUpdated) . '/' . $totalwikis;
	echo "\n";

	if (!empty($wikisNotAddedToTable)) {
		echo 'Failed: ' . count($wikisNotAddedToTable) . '/' . $totalwikis;
		echo "\n";
		echo 'Failed wikis url list:';
		echo "\n";
		foreach ($wikisNotAddedToTable as $url) {
			echo $url . "\n";
		}
	}

	if( !$skipUpload ) {
		$okMainImagesUpload = count($okuploads['main-images']);
		$failedMainUploads = count($faileduploads['main-images']);
		$mainFileExists = count($fileexists['main-images']);
		$totalMainImages = ($okMainImagesUpload + $failedMainUploads + $mainFileExists);

		$okSliderImagesUpload = count($okuploads['slider-images']);
		$failedSliderUploads = count($faileduploads['slider-images']);
		$sliderFileExists = count($fileexists['slider-images']);
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

		if (!empty($faileduploads['slider-images']) || !empty($faileduploads['slider-images'])) {
			echo 'Failed uploads: ' . ($failedMainUploads + $failedSliderUploads) . '/' . ($totalMainImages + $totalSliderImages);
			echo "\n";
			echo 'Failed uploads list:';
			echo "\n";
			foreach ($faileduploads['main-images'] as $filename) {
				echo $filename . "\n";
			}
			foreach ($faileduploads['slider-images'] as $filename) {
				echo $filename . "\n";
			}
		}
	}
}

function parseWikisList($verticalIndex, $verticalsNames, $verticals) {
	$return = '*' . $verticalsNames[$verticalIndex] . "\n";
	foreach ($verticals[$verticalsNames[$verticalIndex]] as $line) {
		$return .= $line . "\n";
	}
	return $return;
}

function uploadImageForDB($imageUrl, $uploadType = WIKIA_COM_WIKIS_LIST_MAIN, $index = 0) {
	switch ($uploadType) {
		case WIKIA_COM_WIKIS_LIST_ADDITIONAL:
			$dstImageName = UploadVisualizationImageFromFile::VISUALIZATION_MAIN_IMAGE_NAME;
			break;
		case WIKIA_COM_WIKIS_LIST_MAIN:
		default:
			$dstImageName = implode('-',
				array(
					UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME,
					$index,
				)
			) . UploadVisualizationImageFromFile::VISUALIZATION_ADDITIONAL_IMAGES_EXT;
			break;
	}

	return uploadImage($imageUrl, $dstImageName);
}

function uploadImage($imageUrl, $dstImageName) {
	// disable recentchange hook
	global $wgHooks;
	$wgHooks['RecentChange_save'] = array();
	$wgHooks['RecentChange_beforeSave'] = array();

	/* prepare temporary file */
	$data = array(
		'wpUpload' => 1,
		'wpSourceType' => 'web',
		'wpUploadFileURL' => $imageUrl
	);

	$upload = F::build('UploadFromUrl');
	$upload->initializeFromRequest(F::build('FauxRequest', array($data, true)));
	$upload->fetchFile();
	$upload->verifyUpload();

	// create destination file
	$title = Title::newFromText($dstImageName, NS_FILE);
	$file = F::build(
		'WikiaLocalFile',
		array(
			$title,
			RepoGroup::singleton()->getLocalRepo()
		)
	);

	/* real upload */
	$result = $file->upload(
		$upload->getTempPath(),
		$dstImageName,
		$dstImageName,
		File::DELETE_SOURCE
	);

	return array(
		'status' => $result->ok,
		'errors' => $result->errors,
	);
}

function addToVisualizationTable($wikiData, &$wikisAddedToTable, &$wikisUpdated, &$wikisNotAddedToTable) {
	global $wgSharedKeyPrefix;

	$wikiId = intval($wikiData['city_id']);

	$db = wfGetDb(DB_MASTER, array(), $wgSharedKeyPrefix);
	$row = $db->selectRow('wikicities.city_visualization',
		array('city_id'),
		array('city_id' => $wikiId)
	);

	if (false === $row) {
		$res = $db->insert('wikicities.city_visualization', array(
			'city_id' => $wikiId,
			'city_lang_code' => $wikiData['city_lang_code'],
			'city_headline' => $wikiData['city_headline'],
			'city_description' => $wikiData['city_description'],
			'city_main_image' => $wikiData['city_main_image'],
			'city_images' => $wikiData['city_images'],
		));

		if ($res) {
			$wikisAddedToTable[] = $wikiId;
		} else {
			$wikisNotAddedToTable[] = $wikiId;
		}
	} else {
		$res = $db->update(
			'wikicities.city_visualization',
			array(
				'city_headline' => $wikiData['city_headline'],
				'city_description' => $wikiData['city_description'],
				'city_main_image' => $wikiData['city_main_image'],
				'city_images' => $wikiData['city_images'],
			),
			array(
				'city_id' => $wikiId,
			)
		);

		if ($res) {
			$wikisUpdated[] = $wikiId;
		} else {
			$wikisNotAddedToTable[] = $wikiId;
		}
	}
}
