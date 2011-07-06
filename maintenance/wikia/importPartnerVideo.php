<?php

$optionsWithArgs = array( 'u', 'f' );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

if ( count( $args ) == 0 || isset( $options['help'] ) ) {
	print <<<EOT
Import video from a partner

Usage: php importPartnerVideo.php [options...] <partner>

Options:
  -u <user>         Username
  -f <filename>     Import video from specified file instead of API
  -d                Debug mode
  
Args:
  provider          Partner to import video from. Int defined in VideoPage.php

If the specified user does not exist, it will be created.

EOT;
	exit( 1 );
}

$userName = isset( $options['u'] ) ? $options['u'] : 'Maintenance script';
$filename = isset( $options['f'] ) ? $options['f'] : null;
$debug = isset($options['d']);

// INPUT VALIDATION

$wgUser = User::newFromName( $userName );
if ( !$wgUser ) {
	die("Invalid username\n");
}
if ( $wgUser->isAnon() ) {
//	$wgUser->addToDatabase();
}

if (!empty($filename)) {
	if (!is_file($filename)) {
		die("Invalid filename\n");
	}
}

// CONFIG SETTINGS

$provider = strtolower($args[0]);
switch ($provider) {
	case VideoPage::V_SCREENPLAY:
		$url = '';
		break;
	default:
		die("unknown provider $provider. aborting.\n");		
}

// BEGIN MAIN

print("Starting import for provider $provider ({$wgWikiaVideoProviders[$provider]})...\n");

// open file
if ($filename) {
	$file = file_get_contents($filename);
	if ($file === false) {
		print "Error reading file $filename\n";
		exit( 1 );
	}
}
else {
	$file = @Http::get( $url );
	if ($file === false) {
		print "Error reading URL $url\n";
		exit( 1 );
	}
}


importFromPartner($provider, $file);

// END OF MAIN

// HELPER FUNCTIONS

function importFromPartner($provider, $file) {
	$numCreated = 0;
	
	switch ($provider) {
		case VideoPage::V_SCREENPLAY:
			$numCreated = importFromScreenplay($file);
			break;
		default:
	}
	
	print "Created $numCreated articles!\n\n";
}

function importFromScreenplay($file) {
	$articlesCreated = 0;
	
	$doc = new DOMDocument( '1.0', 'UTF-8' );
	@$doc->loadXML( $file );
	$titles = $doc->getElementsByTagName('Title');
	$numTitles = $titles->length;
	print("Found $numTitles titles...\n");
	for ($i=0; $i<$numTitles; $i++) {
		$title = $titles->item($i);
		$titleName = $title->getElementsByTagName('TitleName')->item(0)->textContent;
		$year = $title->getElementsByTagName('Year')->item(0)->textContent;
		$clips = $title->getElementsByTagName('Clip');
		$numClips = $clips->length;
		for ($j=0; $j<$numClips; $j++) {
			$clipData = array('titleName'=>$titleName, 'year'=>$year);
		
			$clip = $clips->item($j);
			$clipData['eclipId'] = $clip->getElementsByTagName('EclipId')->item(0)->textContent;
			$clipData['trailerType'] = $clip->getElementsByTagName('TrailerType')->item(0)->textContent;
			$clipData['trailerVersion'] = $clip->getElementsByTagName('TrailerVersion')->item(0)->textContent;
			$clipData['description'] = $clip->getElementsByTagName('Description')->item(0)->textContent;

			$encodes = $clip->getElementsByTagName('Encode');
			$numEncodes = $encodes->length;
			for ($k=0; $k<$numEncodes; $k++) {				
				$encode = $encodes->item($k);
				$url = html_entity_decode( $encode->getElementsByTagName('Url')->item(0)->textContent );					
				$bitrateCode = $encode->getElementsByTagName('EncodeBitRateCode')->item(0)->textContent;
				$formatCode = $encode->getElementsByTagName('EncodeFormatCode')->item(0)->textContent;
				switch ($formatCode) {
					case VideoPage::SCREENPLAY_ENCODEFORMATCODE_JPEG:
						switch ($bitrateCode) {
							case VideoPage::SCREENPLAY_MEDIUM_JPEG_BITRATE_ID:
								$clipData['medJpegUrl'] = $url;
								break;
							case VideoPage::SCREENPLAY_LARGE_JPEG_BITRATE_ID:
								$clipData['lrgJpegUrl'] = $url;
								break;
							default:
						}
						break;
					case VideoPage::SCREENPLAY_ENCODEFORMATCODE_MP4:
						switch ($bitrateCode) {
							case VideoPage::SCREENPLAY_STANDARD_BITRATE_ID:
							case VideoPage::SCREENPLAY_STANDARD_43_BITRATE_ID:
								$clipData['stdBitrateCode'] = $bitrateCode;
								$clipData['stdMp4Url'] = $url;
								break;
							case VideoPage::SCREENPLAY_HIGHDEF_BITRATE_ID:
								$clipData['hdMp4Url'] = $url;
								break;
							default:
						}
						break;
					default:
				}
			}
			
			$clipData['name'] = generateNameForPartnerVideo(VideoPage::V_SCREENPLAY, $clipData);
			$msg = '';
			$articlesCreated += createVideoPageForPartnerVideo(VideoPage::V_SCREENPLAY, $clipData, $msg);
			if ($msg) {
				print "ERROR: $msg\n";
			}
		}
	}
	
	return $articlesCreated;
}

function generateNameForPartnerVideo($provider, array $data) {
	$name = '';
	
	switch ($provider) {
		case VideoPage::V_SCREENPLAY:
			$description = ($data['description']) ? $data['description'] : "{$data['trailerType']} {$data['trailerVersion']} ({$data['eclipId']})";
			$name = sprintf("%s (%s) - %s", $data['titleName'], $data['year'], $description);
			break;
		default:
	}
	
	return $name;
}

function createVideoPageForPartnerVideo($provider, array $data, &$msg) {
	global $debug;
	
	$id = null;
	$name = null;
	$metadata = null;	

	switch ($provider) {
		case VideoPage::V_SCREENPLAY:
			$id = $data['eclipId'];
			$name = $data['name'];

			if (empty($data['stdBitrateCode'])) {
				$msg = "no video encoding exists for $name: clip $id";
				return 0;
			}
			
			$doesHdExist = (int) !empty($data['hdMp4Url']);
			$metadata = array($data['stdBitrateCode'], $doesHdExist);
			break;
		default:
			$msg = "unsupported provider $provider";
			return 0;
	}

	$title = Title::makeTitleSafe(NS_VIDEO, $name);	
	if(is_null($title)) {
		$msg = "article title was null: clip id $id";
		return 0;
	}
	if($title->exists()) {
		$msg = "article named $name already exists: clip id $id";
		return 0;
	}	

	$video = new VideoPage( $title );
	if ($video instanceof VideoPage) {
		$video->loadFromPars( $provider, $id, $metadata );
		$video->setName( $name );
		if ($debug) {
			print "parsed partner clip id $id. name: $name. data: " . implode(',', $metadata) . "\n";
		}
		else {
			$video->save();
			print "created article {$video->getID()} from partner clip id $id\n";
		}
		return 1;
	}
	
	return 0;
}