<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

/*
CREATE TABLE `avatars_migrate` (
  `user_id` int(10) unsigned NOT NULL,
  `old_path` varchar(255) not null default '',
  `city_id` int(8) unsigned not null,
  `new_path` varchar(255) not null default '',
  `removed` boolean default false,
  `date` timestamp NOT NULL default now(),
  PRIMARY KEY (`user_id`, `city_id`),
  KEY (`old_path`),
  KEY (`new_path`)
) ENGINE=InnoDB;
*/

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );
include_once( $GLOBALS["IP"]."/extensions/wikia/Masthead/Masthead.php" );
include_once( $GLOBALS["IP"]."/extensions/wikia/UserProfile_NY/AvatarClass.php" );

$USER_TEST = (isset ($options['u']) ) ? $options['u'] : "";
$UNLINK_OLD = (isset ($options['remove']) ) ? $options['remove'] : "";
$TEST = (isset ($options['test']) ) ? $options['test'] : "";
$USER_FROM = (isset ($options['from']) ) ? $options['from'] : "";
$USER_TO = (isset ($options['to']) ) ? $options['to'] : "";
$ADD_TO_USER_LOG = 1;

function __log($text) {
	echo $text . "\n";
}

function checkNYAvatar($city_id, $user_id) {
	global $IP, $wgWikiaLocalSettingsPath;
	
	$script_path = $_SERVER['PHP_SELF'];
	$path = "SERVER_ID={$city_id} php {$script_path} --ny --user={$user_id} --conf {$wgWikiaLocalSettingsPath}";
	#echo $path . " \n";
	$return = wfShellExec( $path );
	return $return;
}

function getNYAvatar($user_id) {
	global $wgUploadDirectory;
	$avatar = new wAvatar($user_id, 'l');
	$img = $avatar->getAvatarImage();

	if ( $img ) {
		if ( substr($img, 0, 7) != 'default' ) {
			$img = preg_replace("/\?(.*)/", '', $img);
			$img = $wgUploadDirectory . "/avatars/" . trim($img);
		} else {
			$img = "NULL";
		}
	}
	echo $img;
}

function loadAnswersToCheck( $all = 0 ) {
	global $wgExternalSharedDB, $wgCityId;

	$dbr = wfGetDB (DB_SLAVE, 'stats', $wgExternalSharedDB);

	$varAnsEnable = 663;

	$where = array(
		"cv_city_id = city_id",
		"city_public" => 1,
		"cv_variable_id" => $varAnsEnable,
		"cv_value" => "b:1;"
	);
	if ( $all == 1 ) {
		$where[] = "cv_city_id > 10000";
		$where[] = "cv_city_id < 90000";
	}
	$oRes = $dbr->select(
		array( "city_variables", "city_list" ),
		array( "city_id, city_lang" ),
		$where,
		__METHOD__
	);

	$wikiArr = array();
	while ($oRow = $dbr->fetchObject($oRes)) {
		if ( !$wikiArr[$oRow->city_lang] ) {
			$wikiArr[$oRow->city_lang] = $oRow->city_id;
		}
	}
	$dbr->freeResult ($oRes) ;

	return $wikiArr;
}

function loadWikisToCheck() {
	global $wgExternalSharedDB, $wgCityId;

	$dbr = wfGetDB (DB_SLAVE, 'stats', $wgExternalSharedDB);
	$varAnsEnable = 663;

	$wikisWithNYCodes = array(458,462,4541,3236,6164,1657,3828,3829,3827,3603);
	
	$where = array("city_id IN (" . $dbr->makeList( $wikisWithNYCodes ) . ")");
	$oRes = $dbr->select(
		array( "city_list" ),
		array( "city_id, city_url" ),
		$where,
		__METHOD__
	);

	$wikiArr = array();
	while ($oRow = $dbr->fetchObject($oRes)) {
		$wikiArr[$oRow->city_id] = $oRow->city_url;
	}
	$dbr->freeResult ($oRes) ;

	return $wikiArr;
}

function getAnswersAvatar($answersWikis, $user_id, $lang) {
	$pathny = false;
	$city_id = $answersWikis['en'];
	$pathEnAnswers = checkNYAvatar($city_id, $user_id);
	if ( $pathEnAnswers == 'NULL' ) {
		__log("NY Avatar (en): doesn't exist");
		if ( $lang != 'en' && isset($answersWikis[$lang]) ) {
			$city_id = $answersWikis[$lang];
			$pathLangAnswers = checkNYAvatar($city_id, $user_id);
			if ( $pathLangAnswers == 'NULL' ) {
				__log("NY Avatar ($lang): doesn't exist");
			} else {
				$pathny = $pathEnAnswers;							
			}
		} 
	} else {
		$pathny = $pathEnAnswers;
	}
	
	return array($pathny, $city_id);
}

function getNYWikisAvatar($wikis, $user_id) {
	$city_id = 0;
	$pathny = false;
	if (!empty($wikis) ) {
		foreach ( $wikis as $cid => $city_url ) {
			$city_id = $cid;
			$pathEnAnswers = checkNYAvatar($city_id, $user_id);
			if ( $pathEnAnswers != 'NULL' ) {
				$pathny = $pathEnAnswers;
				break;
			} else {
				__log("NY Avatar on ({$city_url}): doesn't exist");
			}
		}
	}
	return array($pathny, $city_id);
}

function copyAvatarsToMasthead() {
	global $wgExternalSharedDB, $wgExternalDatawareDB, $wgWikiaLocalSettingsPath ;
	global $wgStylePath, $IP;
	global $USER_FROM, $USER_TO, $USER_TEST;

	$allUsers = array();
	$answersWikis = loadAnswersToCheck();
	$allAnswersWikis = loadAnswersToCheck(1);
	$nycodeWikis = loadWikisToCheck();
	
	buildUserList($allAnswersWikis, $allUsers);
	buildUserList(array_keys($nycodeWikis), $allUsers);

#	echo print_r($allUsers, true);
#	exit;

	$cnt = 1;
	if ( !empty($allUsers) ) {
		foreach ( $allUsers as $user_id => $listAvatars ) {
			if ( count($listAvatars) > 1 ) {
				__log("$user_id: " . implode(", ", $listAvatars ) . " \n");
				$cnt++;
			}
		}
	}
	__log ("$cnt users to check \n");
	exit;
	
	__log( "Found: " . count($allUsers) );
	if ( !empty($allUsers) ) {
		foreach ( $allUsers as $user_id => $listAvatars ) {
			__log("Processing: ".$user_id . ")");

			# make user 
			$oUser = User::newFromId($user_id);
			if ( !$oUser instanceof User ) {
				__log("Invalid user: $user_id");
				continue;
			}

			# check lang
			$lang = $oUser->getOption('language', 'en');

			$avatar = Masthead::newFromUserID($user_id);
			$path = $avatar->getFullPath();
			$city_id = 0;
			$pathny = $uploaded = false;
			if ( !file_exists( $path ) ) {
				list($pathny, $city_id) = getAnswersAvatar($answersWikis, $user_id, $lang);

				if ( $pathny !== false && $city_id > 0 ) {
					__log("Move Answers Avatar $pathny to $path");
					$uploaded = uploadAvatar($avatar, $oUser, $pathny, $city_id);
					__log("Done with code: " . intval($uploaded));
				} else {
					if ( !empty($nycodeWikis) ) {
						list($pathny, $city_id) = getNYWikisAvatar($nycodeWikis, $user_id);
						if ( $pathny !== false && $city_id > 0 ) {
							__log("Move Wikia NY code Avatar $pathny to $path");
							$uploaded = uploadAvatar($avatar, $oUser, $pathny, $city_id);
						}
					}
				}
				
			} else {
				__log("Avatar: $path exists");
			}
		}
	}
	unset($allUsers);
}

function saveDataInDB($user_id, $city_id, $__files, $sFilePath) {
	global $wgStatsDB, $UNLINK_OLD;
	$dbs = wfGetDB(DB_MASTER, array(), $wgStatsDB);
	$data = array(
		'user_id' 		=> $user_id,
		'old_path' 		=> $__files,
		'city_id' 		=> $city_id,
		'new_path' 		=> $sFilePath,
		'removed' 		=> $UNLINK_OLD ? 1 : 0
	);
	$dbs->insert( 'avatars_migrate', $data, __METHOD__ );
}

function uploadAvatar($oMasthead, $mUser, $nypath, $city_id) {
	global $wgTmpDirectory, $UNLINK_OLD, $TEST;
	
	$result = false;
	$filename = wfBasename($nypath);
	$sFilePath = $oMasthead->getFullPath();

	$user_id = $mUser->getId();
	$__path = str_replace($filename, "", $nypath);
	$__files = $__path . "/*_" . $user_id . "_*";
	
	if ( $TEST === 1 ) {
		saveDataInDB($user_id, $city_id, $__files, $sFilePath);
		return true;
	}

	if( !isset( $wgTmpDirectory ) || !is_dir( $wgTmpDirectory ) ) {
		$wgTmpDirectory = '/tmp';
	}

	$sTmpFile = sprintf("%s/avatars/%s", $wgTmpDirectory, $filename);
	if ( copy( $nypath, $sTmpFile ) ) {
		$iFileSize = filesize($sTmpFile);
		if ( empty( $iFileSize ) ) {
			__log("Empty file {$input} reported size {$iFileSize}");
			return $result;
		}
		
		__log("Temp file set to {$sTmpFile}");

		if ( file_exists( $sTmpFile ) ) {
			$aImgInfo = getimagesize($sTmpFile);

			$aAllowMime = array( 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png', 'image/jpg' );
			if (!in_array($aImgInfo['mime'], $aAllowMime)) {
				__log("Invalid mime type " . $aImgInfo['mime'] . ", allowed: " . implode(',', $aAllowMime));
				return $result;
			}

			switch ($aImgInfo['mime']) {
				case 'image/gif':
					$oImgOrig = @imagecreatefromgif($sTmpFile);
					break;
				case 'image/pjpeg':
				case 'image/jpeg':
				case 'image/jpg':
					$oImgOrig = @imagecreatefromjpeg($sTmpFile);
					break;
				case 'image/x-png':
				case 'image/png':
					$oImgOrig = @imagecreatefrompng($sTmpFile);
					break;
			}
			$aOrigSize = array('width' => $aImgInfo[0], 'height' => $aImgInfo[1]);

			/**
			 * generate new image to png format
			 */
			$addedAvatars = array();

			/**
			 * calculate new image size - should be 100 x 100
			 */
			$iImgW = AVATAR_DEFAULT_WIDTH;
			$iImgH = AVATAR_DEFAULT_HEIGHT;
			/* WIDTH > HEIGHT */
			if ( $aOrigSize['width'] > $aOrigSize['height'] ) {
				$iImgH = $iImgW * ( $aOrigSize['height'] / $aOrigSize['width'] );
			}
			/* HEIGHT > WIDTH */
			if ( $aOrigSize['width'] < $aOrigSize['height'] ) {
				$iImgW = $iImgH * ( $aOrigSize['width'] / $aOrigSize['height'] );
			}

			/* empty image with thumb size on white background */
			$oImg = @imagecreatetruecolor($iImgW, $iImgH);
			$white = imagecolorallocate($oImg, 255, 255, 255);
			imagefill($oImg, 0, 0, $white);

			imagecopyresampled(
				$oImg,
				$oImgOrig,
				floor ( ( AVATAR_DEFAULT_WIDTH - $iImgW ) / 2 ) /*dx*/,
				floor ( ( AVATAR_DEFAULT_HEIGHT - $iImgH ) / 2 ) /*dy*/,
				0 /*sx*/,
				0 /*sy*/,
				$iImgW /*dw*/,
				$iImgH /*dh*/,
				$aOrigSize['width']/*sw*/,
				$aOrigSize['height']/*sh*/
			);

			/**
			 * save to new file ... but create folder for it first
			 */
			if ( !is_dir( dirname( $sFilePath ) ) && !wfMkdirParents( dirname( $sFilePath ) ) ) {
				__log( sprintf("Cannot create directory %s", dirname( $sFilePath ) ) );
				return $result;
			}

			if ( !imagepng( $oImg, $sFilePath ) ) {
				__log( sprintf("Cannot save png Avatar: %s", $sFilePath ) );
				return $result;
			}

			/* remove tmp file */
			imagedestroy($oImg);

			$sUserText = $mUser->getName();
			$mUserPage = Title::newFromText( $sUserText, NS_USER );

			if ( $ADD_TO_USER_LOG == 1 ) {
				$oLogPage = new LogPage( AVATAR_LOG_NAME );
				$oLogPage->addEntry( 'avatar_chn', $mUserPage, '');
			}
			unlink($sTmpFile);

			/**
			 * notify image replication system
			 */
			$newAvatarPath = $oMasthead->getLocalPath();
			__log(sprintf("New avatar path -> %s", $newAvatarPath));
			global $wgEnableUploadInfoExt;
			if( $wgEnableUploadInfoExt ) {
				UploadInfo::log( $mUserPage, $sFilePath, $newAvatarPath );
			}
			$errorNo = UPLOAD_ERR_OK;

			if ( !empty($newAvatarPath) ) {
				/* set user option */
				__log(sprintf("Set %s = %s in user preferences", AVATAR_USER_OPTION_NAME, $newAvatarPath));
				$mUser->setOption( AVATAR_USER_OPTION_NAME, $newAvatarPath );
				$mUser->saveSettings();
			}

			if ( $UNLINK_OLD ) {
				$files = glob($__files);
				if ( $files ) {
					foreach ( $files as $file ) {
						__log("Unlink $file");
						unlink($file);
					}
				}
			}
			saveDataInDB($user_id, $city_id, $__files, $sFilePath);
			$result = true;
		}
		else {
			__log(sprintf("File %s doesn't exist", $sTmpFile ));
			return $result;
		}
	} else {
		__log("Cannot copy $nypath to $sTmpFile");
		return $result;
	}
	
	return $result;
}

function buildUserList($answersWikis, &$allUsers) {
	if ( !empty($answersWikis) ) {
		foreach ( $answersWikis as $id => $city_id ) {
			$uploadDirectory = WikiFactory::getVarValueByName( "wgUploadDirectory", $city_id );
			if ( !file_exists($uploadDirectory) ) {
				continue;
			}
			$files = glob($uploadDirectory . "/avatars/*_*_l.*");
			if ( empty($files) ) { 
				continue;
			}
			foreach ($files as $file) {
				if ( preg_match('/(.*)?\_(.*)?\_l\.(.*)/', $file, $m) ) {
					if ( !empty($m) && isset($m[2]) ) {
						if ( empty($allUsers[$m[2]]) ) { 
							$allUsers[$m[2]] = array();
						}
						if ( !in_array( $m[0], $allUsers[$m[2]] ) ) {
							$allUsers[$m[2]][] = $m[0];
						}
					}
				}
			}
		}
	}
}

if ( isset($options['ny']) && $options['ny'] == 1 ) {
	getNYAvatar($options['user']);
} else {
	__log("Start... \n");
	__log(print_r($options, true));
	copyAvatarsToMasthead();
	__log("Done... \n");
}
