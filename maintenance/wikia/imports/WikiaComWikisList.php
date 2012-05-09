<?
/*
 * How to run this script:
* $ cd /maintenance/wikia/imports
* $ SERVER_ID=80433 php WikiaComWikisList.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php --file='../../../extensions/wikia/WikiaHomePage/text_files/Top 200 wikis - Sheet 1.csv' --message='TestMessageForVisualisation_test'
*/
require_once("../../commandLine.inc");

$csv = explode("\n", file_get_contents($options['file']));
array_shift($csv);
$verticalsNames = array('Video Games', 'Entertainment', 'Lifestyle');
$verticalsProportions = array(50, 40, 10);
$verticals = array(
		$verticalsNames[0] => array(),
		$verticalsNames[1] => array(),
		$verticalsNames[2] => array()
);

$faileduploads = array();
$okuploads = array();
foreach($csv as $line) {
	$element = str_getcsv($line, ',', '"');
	if (
			isset($element[2])
			&& isset($element[3])
			&& in_array($element[2], $verticalsNames)
	) {
		$result = uploadImage($element[3]);
		if($result == 1) {
			$okuploads []= basename($element[3]);
			echo '*';
		} else {
			$faileduploads []= basename($element[3]);
			echo '!';
		}
		
		$element[1] = (
			(stripos($element[1],'http://') === false)
			&& (stripos($element[1],'https://') === false)								 
		)?('http://'.$element[1]):$element[1];

		$verticals[$element[2]][] = '**'.$element[0].'|'.$element[1].'|'.basename($element[3]).'|'.$element[4];
	}
}

$totalimages = (count($faileduploads) + count($okuploads));
echo "\n";
echo 'Summary for importing images:';
echo "\n";
echo 'Total images processed: ' . $totalimages;
echo "\n";
echo 'OK uploads: ' . count($okuploads) . '/' . $totalimages;
echo "\n";
if(!empty($faileduploads)) {
	echo 'Failed uploads: ' . count($faileduploads) . '/' . $totalimages;
	echo "\n";
	echo 'Failed uploads list:';
	echo "\n";
	foreach($faileduploads as $filename) {
		echo $filename . "\n";
	}
}


$title = Title::newFromText($options['message'],NS_MEDIAWIKI);
$article  = new Article( $title );
$content = parseWikisList(0, $verticalsNames, $verticalsProportions, $verticals)
.parseWikisList(1, $verticalsNames, $verticalsProportions, $verticals)
.parseWikisList(2, $verticalsNames, $verticalsProportions, $verticals);
$summary = "import";
$status = $article->doEdit( $content, $summary );

function uploadImage($imageUrl) {
	// disable recentchange hook
	global $wgHooks;
	$wgHooks['RecentChange_save'] = array();
	$wgHooks['RecentChange_beforeSave'] = array();

	$imageName = basename($imageUrl);

	/* prepare temporary file */
	$data = array(
			'wpUpload' => 1,
			'wpSourceType' => 'web',
			'wpUploadFileURL' => $imageUrl
	);
	$upload = F::build( 'UploadFromUrl' );
	$upload->initializeFromRequest( F::build( 'FauxRequest', array( $data, true ) ) );
	$upload->fetchFile();
	$upload->verifyUpload();
	$title = Title::newFromText( $imageName, NS_FILE );
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
			$imageName,
			$imageName,
			File::DELETE_SOURCE
	);
	return $result->ok;
}

function parseWikisList($verticalIndex, $verticalsNames, $verticalsProportions, $verticals) {
	$return = '*'.$verticalsNames[$verticalIndex].'|'.$verticalsProportions[$verticalIndex]."\n";
	foreach($verticals[$verticalsNames[$verticalIndex]] as $line) {
		$return .= $line."\n";
	}
	return $return;
}