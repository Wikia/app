<?php
/**
 * A special page for uploading Avatars
 * This page is a big hack -- its just the image upload page with some changes to
 * upload the actual avatar files.  The avatars are not held as MediaWiki images, but
 * rather based on the user_id and in multiple sizes
 *
 * Requirements: Need writable directory $wgUploadPath/avatars
 *
 * @file
 * @ingroup Extensions
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialUploadAvatar extends SpecialUpload {
	var $avatarUploadDirectory;

	/**
	 * Constructor
	 */
	public function __construct( $request = null ) {
		global $wgRequest;

		SpecialPage::__construct( 'UploadAvatar', 'upload', false/* listed? */ );
		$this->loadRequest( is_null( $request ) ? $wgRequest : $request );
	}

	/**
	 * Let the parent handle most of the request, but specify the Upload
	 * class ourselves
	 */
	protected function loadRequest( $request ) {
		parent::loadRequest( $request );
		$this->mUpload = new UploadAvatar();
		$this->mUpload->initializeFromRequest( $request );
	}

	/**
	 * Show the special page. Let the parent handle most stuff, but handle a
	 * successful upload ourselves
	 *
	 * @param $params Mixed: parameter(s) passed to the page or null
	 */
	public function execute( $params ) {
		global $wgRequest, $wgOut, $wgUser, $wgUserProfileScripts;

		$wgOut->addExtensionStyle( $wgUserProfileScripts . '/UserProfile.css' );
		parent::execute( $params );
		$wgOut->setPageTitle( wfMsg( 'user-profile-picture-title' ) );

		if ( $this->mUploadSuccessful ) {
			// Cancel redirect
			$wgOut->redirect( '' );

			$this->showSuccess( $this->mUpload->mExtension );
		}
	}

	/**
	 * Show some text and linkage on successful upload.
	 * @access private
	 */
	function showSuccess( $ext ) {
		global $wgUser, $wgOut, $wgContLang, $wgDBname, $wgUploadPath, $wgUploadAvatarInRecentChanges;

		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		$log = new LogPage( wfMsgForContent( 'user-profile-picture-log' ) );
		if ( !$wgUploadAvatarInRecentChanges ) {
			$log->updateRecentChanges = false;
		}
		$log->addEntry(
			wfMsgForContent( 'user-profile-picture-log' ),
			$wgUser->getUserPage(),
			wfMsgForContent( 'user-profile-picture-log-entry' )
		);

		$output = '<h1>' . wfMsg( 'user-profile-picture-title' ) . '</h1>';
		$output .= UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-picture' ) );
		$output .= '<div class="profile-info">';
		$output .= '<p class="profile-update-title">' . wfMsg( 'user-profile-picture-yourpicture' ) . '</p>';
		$output .= '<p>' . wfMsg( 'user-profile-picture-yourpicturestext' ) . '</p>';

		$output .= '<table cellspacing="0" cellpadding="0" style="margin-top:20px;">';
		$output .= '<tr>
			<td valign="top" style="color:#797979;font-size:12px;font-weight:bold;padding-bottom:20px;">' . wfMsg( 'user-profile-picture-large' ) . '</td>
			<td style="padding-bottom:20px;">
				<img src="' . $wgUploadPath . '/avatars/' . $wgDBname . '_' . $wgUser->mId . '_l.' . $ext . '?ts=' . rand() . '" alt="" border="0" />
			</td>
		</tr>';
		$output .= '<tr>
			<td valign="top" style="color:#797979;font-size:12px;font-weight:bold;padding-bottom:20px;">' . wfMsg( 'user-profile-picture-medlarge' ) . '</td>
			<td style="padding-bottom:20px;">
				<img src="' . $wgUploadPath . '/avatars/' . $wgDBname . '_' . $wgUser->mId . '_ml.' . $ext . '?ts=' . rand() . '" alt="" border="0" />
			</td>
		</tr>';
		$output .= '<tr>
			<td valign="top" style="color:#797979;font-size:12px;font-weight:bold;padding-bottom:20px;">' . wfMsg( 'user-profile-picture-medium' ) . '</td>
			<td style="padding-bottom:20px;">
				<img src="' . $wgUploadPath . '/avatars/' . $wgDBname . '_' . $wgUser->mId . '_m.' . $ext . '?ts=' . rand() . '" alt="" border="0" />
			</td>
		</tr>';
		$output .= '<tr>
			<td valign="top" style="color:#797979;font-size:12px;font-weight:bold;padding-bottom:20px;">' . wfMsg( 'user-profile-picture-small' ) . '</td>
			<td style="padding-bottom:20px;">
				<img src="' . $wgUploadPath . '/avatars/' . $wgDBname . '_' . $wgUser->mId . '_s.' . $ext . '?ts' . rand() . '" alt="" border="0" />
			</td>
		</tr>';
		$output .= '<tr>
			<td>
				<input type="button" onclick="javascript:history.go(-1)" class="site-button" value="' . wfMsg( 'user-profile-picture-uploaddifferent' ) . '" />
			</td>
		</tr>';
		$output .= '</table>';
		$output .= '</div>';

		$wgOut->addHTML( $output );
	}

	/**
	 * Displays the main upload form, optionally with a highlighted
	 * error message up at the top.
	 *
	 * @param string $msg as HTML
	 * @access private
	 */
	protected function getUploadForm( $message = '', $sessionKey = '', $hideIgnoreWarning = false ) {
		global $wgOut, $wgUser, $wgLang, $wgUploadDirectory, $wgRequest, $wgUseCopyrightUpload;

		$cols = intval( $wgUser->getOption( 'cols' ) );
		$ew = $wgUser->getOption( 'editwidth' );
		if ( $ew ) {
			$ew = ' style="width:100%"';
		} else {
			$ew = '';
		}

		if ( '' != $message ) {
			$sub = wfMsg( 'uploaderror' );
			$wgOut->addHTML( "<h2>{$sub}</h2>\n" .
				"<h4 class='error'>{$message}</h4>\n" );
		}
		$sk = $wgUser->getSkin();

		$sourcefilename = wfMsg( 'sourcefilename' );
		$destfilename = wfMsg( 'destfilename' );

		$fd = wfMsg( 'filedesc' );
		$ulb = wfMsg( 'uploadbtn' );

		$iw = wfMsg( 'ignorewarning' );

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Upload' );
		$action = $titleObj->escapeLocalURL();

		$encDestFile = htmlspecialchars( $this->mDesiredDestName );
		$source = null;

		if ( $wgUseCopyrightUpload ) {
			$source = "
				<td align='right' nowrap='nowrap'>" . wfMsg( 'filestatus' ) . ":</td>
				<td><input tabindex='3' type='text' name=\"wpUploadCopyStatus\" value=\"" .
				htmlspecialchars( $this->mUploadCopyStatus ) . "\" size='40' /></td>
				</tr><tr>
				<td align='right'>" . wfMsg( 'filesource' ) . ":</td>
				<td><input tabindex='4' type='text' name='wpUploadSource' value=\"" .
				htmlspecialchars( $this->mUploadSource ) . "\" style='width:100px' /></td>
				";
		}

		$watchChecked = $wgUser->getOption( 'watchdefault' )
			? 'checked="checked"'
			: '';

		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		$output = '<h1>' . wfMsg( 'user-profile-picture-title' ) . '</h1>';
		$output .= UserProfile::getEditProfileNav( wfMsg( 'user-profile-section-picture' ) );
		$output .= '<div class="profile-info">';

		if ( $this->getAvatar( 'l' ) != '' ) {
			$output .= '<table>
				<tr>
					<td>
						<p class="profile-update-title">' . wfMsg( 'user-profile-picture-currentimage' ) . '</p>
					</td>
				</tr>';
				$output .= '<tr>
					<td>' . $this->getAvatar( 'l' ) . '</td>
				</tr>
			</table>';
		}

		$output .= '<form id="upload" method="post" enctype="multipart/form-data" action="">
			<table border="0">
				<tr>
					<td>
						<p class="profile-update-title">' . wfMsg( 'user-profile-picture-choosepicture' ) . '</p>
						<p style="margin-bottom:10px;">' . wfMsg( 'user-profile-picture-picsize' ) . '</p>
						<input tabindex="1" type="file" name="wpUploadFile" id="wpUploadFile" size="36"/>
						</td>
				</tr>
				<tr>' . $source . '</tr>
				<tr>
					<td>
						<input tabindex="5" type="submit" name="wpUpload" class="site-button" value="' . $ulb . '" />
					</td>
				</tr>
			</table>
			</form>' . "\n";

		$output .= '</div>';

		return $output;
	}

	function getAvatar( $size ) {
		global $wgUser, $wgDBname, $wgUploadDirectory, $wgUploadPath;
		$files = glob( $wgUploadDirectory . '/avatars/' . $wgDBname . '_' . $wgUser->getID() . '_' . $size . "*" );
		if ( isset( $files[0] ) && $files[0] ) {
			return "<img src=\"{$wgUploadPath}/avatars/" . basename( $files[0] ) . '" alt="" border="0" />';
		}
	}
}

class UploadAvatar extends UploadFromFile {
	public $mExtension;

	function createThumbnail( $imageSrc, $imageInfo, $imgDest, $thumbWidth ) {
		list( $origWidth, $origHeight, $typeCode ) =  $imageInfo;

		if ( $origWidth < $thumbWidth ) {
			$thumbWidth = $origWidth;
		}
		$thumbHeight = ( $thumbWidth * $origHeight / $origWidth );
		$border = ' -bordercolor white  -border  0x';
		if ( $thumbHeight < $thumbWidth ) {
			$border = ' -bordercolor white  -border  0x' . ( ( $thumbWidth - $thumbHeight ) / 2 );
		}
		if ( $typeCode == 2 ) {
			exec( 'convert -size ' . $thumbWidth . 'x' . $thumbWidth . ' -resize ' . $thumbWidth . ' -crop ' . $thumbWidth . 'x' . $thumbWidth . '+0+0   -quality 100 ' . $border . ' ' . $imageSrc . ' ' . $this->avatarUploadDirectory . '/' . $imgDest . '.jpg' );
		}
		if ( $typeCode == 1 ) {
			exec( 'convert -size ' . $thumbWidth . 'x' . $thumbWidth . ' -resize ' . $thumbWidth . ' -crop ' . $thumbWidth . 'x' . $thumbWidth . '+0+0 ' . $imageSrc . ' ' . $border . ' ' . $this->avatarUploadDirectory . '/' . $imgDest . '.gif' );
		}
		if ( $typeCode == 3 ) {
			exec( 'convert -size ' . $thumbWidth . 'x' . $thumbWidth . ' -resize ' . $thumbWidth . ' -crop ' . $thumbWidth . 'x' . $thumbWidth . '+0+0 ' . $imageSrc . ' ' . $this->avatarUploadDirectory . '/' . $imgDest . '.png' );
		}
	}

	/**
	 * Create the thumbnails and delete old files
	 */
	public function performUpload( $comment, $pageText, $watch, $user ) {
		global $wgUploadDirectory, $wgOut, $wgUser, $wgDBname;

        $this->avatarUploadDirectory = $wgUploadDirectory . '/avatars';

		$imageInfo = getimagesize( $this->mTempPath );
		switch ( $imageInfo[2] ) {
			case 1:
				$ext = 'gif';
				break;
			case 2:
				$ext = 'jpg';
				break;
			case 3:
				$ext = 'png';
				break;
			default:
				return Status::newFatal( 'filetype-banned-type' );
		}

		$dest = $this->avatarUploadDirectory;

		$avatar = new wAvatar( $wgUser->getID(), 'l' );
		if ( strpos( $avatar->getAvatarImage(), 'default_' ) !== false ) {
			$stats = new UserStatsTrack( $wgUser->getID(), $wgUser->getName() );
			$stats->incStatField( 'user_image' );
		}

		$this->createThumbnail( $this->mTempPath, $imageInfo, $wgDBname . '_' . $wgUser->mId . '_l', 75 );
		$this->createThumbnail( $this->mTempPath, $imageInfo, $wgDBname . '_' . $wgUser->mId . '_ml', 50 );
		$this->createThumbnail( $this->mTempPath, $imageInfo, $wgDBname . '_' . $wgUser->mId . '_m', 30 );
		$this->createThumbnail( $this->mTempPath, $imageInfo, $wgDBname . '_' . $wgUser->mId . '_s', 16 );

		if ( $ext != 'jpg' ) {
			if ( is_file( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_s.jpg' ) ) {
				unlink( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_s.jpg' );
			}
			if ( is_file( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_m.jpg' ) ) {
				unlink( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_m.jpg' );
			}
			if ( is_file( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_l.jpg' ) ) {
				unlink( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_l.jpg' );
			}
			if ( is_file( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_ml.jpg' ) ) {
				unlink( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_ml.jpg' );
			}
		}
		if ( $ext != 'gif' ) {
			if ( is_file( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_s.gif' ) ) {
				unlink( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_s.gif' );
			}
			if ( is_file( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_m.gif' ) ) {
				unlink( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_m.gif' );
			}
			if ( is_file( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_l.gif' ) ) {
				unlink( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_l.gif' );
			}
			if ( is_file( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_ml.gif' ) ) {
				unlink( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_ml.gif' );
			}
		}
		if ( $ext != 'png' ) {
			if ( is_file( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_s.png' ) ) {
				unlink( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_s.png' );
			}
			if ( is_file( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_m.png' ) ) {
				unlink( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_m.png' );
			}
			if ( is_file( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_l.png' ) ) {
				unlink( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_l.png' );
			}
			if ( is_file( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_ml.png' ) ) {
				unlink( $this->avatarUploadDirectory . '/' . $wgDBname . '_' . $wgUser->mId . '_ml.png' );
			}
		}
		global $wgMemc;
		$key = wfMemcKey( 'user', 'profile', 'avatar', $wgUser->getID(), 's' );
		$data = $wgMemc->delete( $key );

		$key = wfMemcKey( 'user', 'profile', 'avatar', $wgUser->getID(), 'm' );
		$data = $wgMemc->delete( $key );

		$key = wfMemcKey( 'user', 'profile', 'avatar', $wgUser->getID() , 'l' );
		$data = $wgMemc->delete( $key );

		$key = wfMemcKey( 'user', 'profile', 'avatar', $wgUser->getID() , 'ml' );
		$data = $wgMemc->delete( $key );

		$this->mExtension = $ext;
		return Status::newGood();
	}

	/**
	 * Don't verify the upload, since it all dangerous stuff is killed by
	 * making thumbnails
	 */
	public function verifyUpload() {
		return array( 'status' => self::OK );
	}

	/**
	 * Only needed for the redirect; needs fixage
	 */
	public function getTitle() {
		return Title::makeTitle( NS_FILE, 'Avatar.jpg' );
	}

	/**
	 * We don't overwrite stuff, so don't care
	 */
	public function checkWarnings() {
		return array();
	}

}
