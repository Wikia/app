<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );
require_once( $GLOBALS["IP"]."/extensions/wikia/Masthead/Masthead.php" );
require_once( $GLOBALS["IP"]."/extensions/wikia/UserProfile_NY/AvatarClass.php" );

$USER_TEST = (isset ($options['u']) ) ? $options['u'] : "";
$UNLINK_OLD = (isset ($options['remove']) ) ? $options['remove'] : "";
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

function loadAnswersToCheck() {
	global $wgExternalSharedDB, $wgCityId;

	$dbr = wfGetDB (DB_SLAVE, 'stats', $wgExternalSharedDB);
	$namespace = "500";
	$username = "Maintenance script";

	$varAnsEnable = 663;

	$where = array(
		"cv_city_id = city_id",
		"city_public" => 1,
		"cv_variable_id" => $varAnsEnable,
		"cv_city_id > 10000",
		"cv_city_id < 90000",
		"cv_value" => "b:1;"
	);
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

function copyAvatarsToMasthead() {
	global $wgExternalSharedDB, $wgExternalDatawareDB, $wgWikiaLocalSettingsPath ;
	global $wgStylePath, $IP;
	global $USER_TEST;

	$answersWikis = loadAnswersToCheck();
	#echo print_r($answersWikis, true);

	$dbr = wfGetDB (DB_SLAVE, 'stats', $wgExternalSharedDB);
	$namespace = "500";
	$username = "Maintenance script";

	$where = array("user_id > 0");
	if ( $USER_TEST ) {
		$where["user_id"] = $USER_TEST;
	}
	$oRes = $dbr->select(
		array( "user" ),
		array( "user_id, user_name" ),
		$where,
		__METHOD__,
		array( "ORDER BY" => "user_id" )
	);

	$wikiArr = array();
	while ($oRow = $dbr->fetchObject($oRes)) {
		$wikiArr[$oRow->user_id] = $oRow->user_name;
	}
	$dbr->freeResult ($oRes) ;

	if ( !empty($wikiArr) ) {
		foreach ( $wikiArr as $user_id => $user_name ) {
			__log("Processing: " . $user_name . " (" . $user_id . ")");

			# make user 
			$oUser = User::newFromId($user_id);
			if ( !$oUser instanceof User ) {
				__log("Invalid user: $user_name");
				continue;
			}

			# check lang
			$lang = $oUser->getOption('language', 'en');

			$avatar = Masthead::newFromUserID($user_id);
			$path = $avatar->getFullPath();
			$pathny = false;
			if ( !file_exists( $path ) ) {
				$pathEnAnswers = checkNYAvatar($answersWikis['en'], $user_id);
				if ( $pathEnAnswers == 'NULL' ) {
					__log("NY Avatar (en): doesn't exist");
					if ( $lang != 'en' && isset($answersWikis[$lang]) ) {
						$pathLangAnswers = checkNYAvatar($answersWikis[$lang], $user_id);
						if ( $pathLangAnswers == 'NULL' ) {
							__log("NY Avatar ($lang): doesn't exist");
						} else {
							$pathny = $pathEnAnswers;							
						}
					} 
				} else {
					$pathny = $pathEnAnswers;
				}
			} else {
				__log("Avatar: $path exists");
			}
			
			if ( $pathny !== false ) {
				__log("Move $pathny to $path");
				$uploaded = uploadAvatar($avatar, $oUser, $pathny);
				__log("Done with code: " . intval($uploaded));
			}
		}
	}
	unset($wikiArr);
}

function uploadAvatar($oMasthead, $mUser, $nypath) {
	global $wgTmpDirectory, $UNLINK_OLD;
	$filename = wfBasename($nypath);

	if( !isset( $wgTmpDirectory ) || !is_dir( $wgTmpDirectory ) ) {
		$wgTmpDirectory = '/tmp';
	}

	$sTmpFile = sprintf("%s/avatars/%s", $wgTmpDirectory, $filename);
	if ( copy( $nypath, $sTmpFile ) ) {
		$iFileSize = filesize($sTmpFile);
		if ( empty( $iFileSize ) ) {
			__log("Empty file {$input} reported size {$iFileSize}");
			return false;
		}
		
		__log("Temp file set to {$sTmpFile}");

		if ( file_exists( $sTmpFile ) ) {
			$aImgInfo = getimagesize($sTmpFile);

			$aAllowMime = array( 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png', 'image/jpg' );
			if (!in_array($aImgInfo['mime'], $aAllowMime)) {
				__log("Invalid mime type " . $aImgInfo['mime'] . ", allowed: " . implode(',', $aAllowMime));
				return false;
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
			$sFilePath = $oMasthead->getFullPath();

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
				return false;
			}

			if ( !imagepng( $oImg, $sFilePath ) ) {
				__log( sprintf("Cannot save png Avatar: %s", $sFilePath ) );
				return false;
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
				$__path = str_replace($filename, "", $nypath);
				$files = glob($__path . "/answers_" . $mUser->getId() . "_*");
				if ( $files ) {
					foreach ( $files as $file ) {
						__log("Unlink $file");
						unlink($file);
					}
				}
			}			
		}
		else {
			__log(sprintf("File %s doesn't exist", $sTmpFile ));
			return false;
		}
	} else {
		__log("Cannot copy $nypath to $sTmpFile");
		return false;
	}
	
	return true;
}

if ( $options['ny'] == 1 ) {
	getNYAvatar($options['user']);
} else {
	__log("Start... \n");
	__log(print_r($options, true));
	copyAvatarsToMasthead();
	__log("Done... \n");
}
