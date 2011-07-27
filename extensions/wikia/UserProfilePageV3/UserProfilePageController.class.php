<?php

class UserProfilePageController extends WikiaController {
	const AVATAR_DEFAULT_SIZE = 150;
	const AVATAR_MAX_SIZE = 512000;
	const MAX_TOP_WIKIS = 4;
	
	protected $profilePage = null;
	protected $allowedNamespaces = null;
	protected $title = null;
	
	protected $defaultAvatars = null;
	protected $defaultAvatarPath = 'http://images.wikia.com/messaging/images/';
	
	public function __construct( WikiaApp $app ) {
		$this->app = $app;
		$this->allowedNamespaces = $app->getLocalRegistry()->get( 'UserProfilePageNamespaces' );
		$this->title = $app->wg->Title;
	}

	/**
	 * @brief main entry point
	 *
	 * @requestParam User $user user object
	 * @requestParam string $userPageBody original page body
	 * @requestParam int $wikiId current wiki id
	 */
	public function index() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		// CSS
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/UserProfilePageV3/css/UserProfilePage.scss'));
		
		$user = $this->getVal( 'user' );
		$pageBody = $this->getVal( 'userPageBody' );
		$wikiId = $this->getVal( 'wikiId' );
		
		$namespace = $this->title->getNamespace();
		$isSubpage = $this->title->isSubpage();

		$useOriginalBody = true;

		if( $user instanceof User ) {
			$this->profilePage = F::build( 'UserProfilePage', array( 'user' =>  $user ) );
			if( ( $namespace == NS_USER ) && !$isSubpage ) {
				$this->setVal( 'questions', $this->profilePage->getInterviewQuestions( $wikiId, true ) );
				$this->setVal( 'stuffSectionBody', $pageBody );
				$useOriginalBody = false;
			}

			$this->setVal( 'isUserPageOwner', ( ( $user->getId() == $this->wg->User->getId() ) ? true : false ) );
		}

		if( $useOriginalBody ) {
			$this->response->setBody( $pageBody );
		} else {
			$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . '/wikia/UserProfilePageV3/js/UserProfilePage.js' );
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );

		// suppress rail
		$this->wg->SuppressRail = true;
	}
	
	/**
	 * @brief Renders new user identity box
	 * 
	 * @desc Creates array of user's data and passes it to the template
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function renderUserIdentityBox() {
		$this->app->wf->ProfileIn( __METHOD__ );

		// Website links icon shade
		//$this->setVal( 'linkIconShade', ( SassUtil::isThemeDark('color-links') ) ? 'light' : 'dark');
		//$this->setVal( 'linkIconShadeZeroState', ( SassUtil::isThemeDark() ) ? 'dark' : 'light');
		
		$this->setVal( 'wgBlankImgUrl', $this->wg->BlankImgUrl );
		
		$sessionUser = $this->wg->User;
		$user = $this->getUserFromTitle($this->title);
		$userIdentityBox = F::build('UserIdentityBox', array($this->app, $user, self::MAX_TOP_WIKIS));
		$userData = $userIdentityBox->setData();
		
		if( !empty($userData['registration']) ) {
			$userData['registration'] = $this->wg->Lang->date($userData['registration']);
		}
		
		$this->setVal( 'user', $userData );
		$this->setVal( 'deleteAvatarLink', F::build('SpecialPage', array('RemoveUserAvatar'), 'getTitleFor')->getFullUrl('av_user='.$userData['name']) );
		$this->setVal( 'isUserPageOwner', ( ( $user->getId() == $sessionUser->getId() ) ? true : false ) );
		$this->setVal( 'isWikiStaff', ( $sessionUser->isAllowed('staff') ? true : false ) );
		$this->setVal( 'canRemoveAvatar', $sessionUser->isAllowed('removeavatar') );
		
		$this->app->wg->Out->addScript('<script type="'.$this->app->wg->JsMimeType.' src="'.$this->app->wg->StylePath.'/common/jquery/jquery.aim.js?'.$this->app->wg->StyleVersion.'"></script>');
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	/**
	 * @brief Gets lightbox data
	 * 
	 * @requestParam string $userId user's unique id
	 * @requestParam string $tab current tab
	 */
	public function getLightboxData() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$selectedTab = $this->getVal('tab');
		$userId = $this->getVal('userId');
		$wikiId = $this->wg->CityId;
		$user = $this->wg->User;
		
		if( !$user->isAnon() ) {
			$this->profilePage = F::build( 'UserProfilePage', array( 'user' =>  $user ) );

			$this->setVal( 'body', (string) $this->sendSelfRequest( 'renderLightbox', array( 'tab' => $selectedTab, 'userId' => $userId ) ) );
			$this->setVal( 'interviewQuestions', $this->profilePage->getInterviewQuestions( $wikiId, false, true ) );
		} else {
			throw new WikiaException( 'User not logged in' );
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	/**
	 * @brief Renders lightbox
	 * 
	 * @requestParam string $userId user's unique id
	 * @requestParam string $tab current tab
	 * 
	 * @desc Mainly passes two variables to the template: tabs, selectedTab but also if it's about tab or avatar uses private method to pass more data
	 */
	public function renderLightbox() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$selectedTab = $this->getVal('tab');
		$userId = $this->getVal('userId');
		$sessionUser = $this->wg->User;
		
		$tabs = array(
			array( 'id' => 'avatar', 'name' => 'Avatar' ),
			array( 'id' => 'about', 'name' => 'About Me' ),
			//array( 'id' => 'interview', 'name' => 'User Interview' ), //not yet --nAndy, 2011-06-15
		);
		
		$this->renderAvatarLightbox($userId);
		$this->renderAboutLightbox($userId);
		
		$this->setVal( 'tabs', $tabs );
		$this->setVal( 'selectedTab', $selectedTab );
		$this->setVal( 'isUserPageOwner', ( ( $userId == $sessionUser->getId() ) ? true : false ) );
		
		$this->setVal( 'wgBlankImgUrl', $this->wg->BlankImgUrl );
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	public function saveInterviewAnswers() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$user = F::build('User', array($this->getVal('userId')), 'newFromId');
		$wikiId = $this->wg->CityId;
		
		$answers = json_decode( $this->getVal( 'answers' ) );
		
		$status = 'error';
		$errorMsg = $this->wf->msg( 'userprofilepage-interview-save-internal-error' );
		
		if( !$user->isAnon() && is_array( $answers ) ) {
			$this->profilePage = F::build( 'UserProfilePage', array( 'user' => $user) );
			
			if( !$this->profilePage->saveInterviewAnswers( $wikiId, $answers ) ) {
				$status = 'error';
				$errorMsg = $this->wf->msg( 'userprofilepage-interview-save-internal-error' );
			}
			else {
				$status = 'ok';
			}
		}
		
		$this->setVal( 'status', $status );
		if( $status == 'error' ) {
			$this->setVal( 'errorMsg', $errorMsg );
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	/**
	 * @brief Recives data from AJAX call, validates and saves new user data
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function saveUserData() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$user = F::build('User', array($this->getVal('userId')), 'newFromId');
		$isAllowed = ( $this->app->wg->User->isAllowed('staff') || intval($user->getID()) === intval($this->app->wg->User->getID()) );
		$userData = json_decode($this->getVal('data'));
		
		$status = 'error';
		$errorMsg = $this->wf->msg('user-identity-box-saving-internal-error');
		
		if( $isAllowed && is_object($userData) ) {
			$userIdentityBox = F::build('UserIdentityBox', array($this->app, $user, self::MAX_TOP_WIKIS));
			
			if( !empty($userData->website) && 0 !== strpos($userData->website, 'http') ) {
				$userData->website = 'http://'.$userData->website;
			}
			
			if( !$userIdentityBox->saveUserData($userData) ) {
				$status = 'error';
				$errorMsg = $this->wf->msg('userprofilepage-interview-save-internal-error');
			} else {
				$status = 'ok';
			}
		}
		
		if( $isAllowed && is_null($userData) ) {
			$errorMsg = $this->wf->msg('user-identity-box-saving-error');
		}
		
		$this->setVal('status', $status);
		if( $status === 'error' ) {
			$this->setVal('errorMsg', $errorMsg);
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	/**
	 * @brief Validates and saves new user's avatar
	 *
	 * @param integer $userId id of user which avatar is going to be saved; taken from request if not given
	 * @param object $data data object with source of file and url/name of avatar's file; taken from request if not given
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function saveUsersAvatar($userId = null, $data = null) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		if( is_null($userId) ) {
			$user = F::build('User', array($this->getVal('userId')), 'newFromId');
		} else {
			$user = F::build('User', array($userId), 'newFromId');
		}
		
		$isAllowed = ( $this->app->wg->User->isAllowed('staff') || intval($user->getID()) === intval($this->app->wg->User->getID()) );
		
		if( is_null($data) ) {
			$data = json_decode($this->getVal('data'));
		}
		
		$errorMsg = $this->wf->msg('userprofilepage-interview-save-internal-error');
		$result = array('success' => true, 'error' => $errorMsg);
		
		if( $isAllowed && isset($data->source) && isset($data->file) ) {
			$userIdentityBox = F::build('UserIdentityBox', array($this->app, $user, self::MAX_TOP_WIKIS));
			
			switch($data->source) {
				case 'sample':
					$userData->avatar = $data->file;
					break;
				case 'facebook':
					$userData->avatar = $this->saveFacebookAvatar($user, $data->file, $errorMsg);
					break;
				default:
					$result = array('success' => false, 'error' => $errorMsg);
					$errorMsg = $this->wf->msg('userprofilepage-interview-save-internal-error');
					break;
			}
			
			if( $userData->avatar === false || !$userIdentityBox->saveUserData($userData) ) {
				$result = array('success' => false, 'error' => $errorMsg);
			} else {
				$result = array('success' => true, 'avatar' => F::build('AvatarService', array($user, self::AVATAR_DEFAULT_SIZE, false, true), 'getAvatarUrl'));
			}
		}
		
		$this->setVal('result', $result);
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	/**
	 * @brief Gets avatar from url, saves it on server and resize it if needed then returns path
	 * 
	 * @param User $user user object
	 * @param string $url url to user's facebook avatar
	 * @param string $errorMsg reference to a string variable where errors messages are returned
	 * 
	 * @return string | boolean
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function saveFacebookAvatar(User $user, $url, &$errorMsg) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$userId = $user->getID();
		$localPath = F::build('ImageOperationsHelper', array($this->app))->getLocalPath($userId);
		
		$errorNo = $this->uploadByUrl(
			$url, 
			array(
				'userId' => $userId,
				'username' => $user->getName(),
				'localPath' => $localPath,
			),
			$errorMsg 
		);
		
		if ( $errorNo != UPLOAD_ERR_OK ) {
			$this->validateUpload($errorNo, $status, $errorMsg);
			
			$this->app->wf->ProfileOut( __METHOD__ );
			return false;
		} else {
			$this->app->wf->ProfileOut( __METHOD__ );
			return $localPath;
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return false;
	}
	
	/**
	 * @brief Submits avatar form
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onSubmitUsersAvatar() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$user = F::build('User', array($this->getVal('userId')), 'newFromId');
		
		$errorMsg = $this->wf->msg('userprofilepage-interview-save-internal-error');
		$result = array('success' => false, 'error' => $errorMsg);
		
		if( !$user->isAnon() && $this->request->wasPosted() ) {
			$avatarUploadFiled = 'UPPLightboxAvatar';
			$fileName = $this->app->wg->request->getFileName($avatarUploadFiled);
			$userId = $user->getID();
			$localPath = F::build('ImageOperationsHelper', array($this->app))->getLocalPath($userId);
			
			$errorNo = $this->uploadFile(
				$this->app->wg->request, array(
					'userId' => $userId,
					'username' => $user->getName(),
					'localPath' => $localPath,
				), 
				$avatarUploadFiled, 
				$errorMsg 
			);
			
			if ( $errorNo != UPLOAD_ERR_OK ) {
				$this->validateUpload($errorNo, $status, $errorMsg);
			} else {
				$this->purgeOldAvatars($user);
				
				$userIdentityBox = F::build('UserIdentityBox', array($this->app, $user, self::MAX_TOP_WIKIS));
				$userData->avatar = $localPath;
				
				if( !$userIdentityBox->saveUserData($userData) ) {
					$errorMsg = $this->wf->msg('userprofilepage-interview-save-internal-error');
					$result = array('success' => false, 'error' => $errorMsg);
				} else {
					$result = array('success' => true, 'avatar' => F::build( 'AvatarService', array($user->getName(), self::AVATAR_DEFAULT_SIZE ), 'getAvatarUrl'));
				}
			}
		} else {
			$errorMsg = $this->wf->msg('user-identity-box-avatar-anon-user-error');
			$result = array('success' => false, 'error' => $errorMsg);
		}
		
		$this->setVal('result', $result);
		
		if( false === $this->response->hasContentType() ) {
			$this->response->setContentType('text/html; charset=utf-8');
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	/**
	 * @brief Validates file upload (whenever it's regular upload or by-url upload) and sets status and errorMsg
	 * 
	 * @param integer $errorNo variable being checked
	 * @param string $status status depends on value of $errorNo can be returned as 'error' or 'success'
	 * @param string $errorMsg error message for humans
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function validateUpload($errorNo, &$status, &$errorMsg) {
		switch( $errorNo ) {
			case UPLOAD_ERR_NO_FILE:
				$status = 'error';
				$errorMsg = $this->wf->msg('user-identity-box-avatar-error-nofile');
				break;
				
			case UPLOAD_ERR_CANT_WRITE:
				$status = 'error';
				$errorMsg = $this->wf->msg('user-identity-box-avatar-error-cantwrite');
				break;
				
			case UPLOAD_ERR_FORM_SIZE:
				$status = 'error';
				$errorMsg = $this->wf->msg('user-identity-box-avatar-error-size', (int)(self::AVATAR_MAX_SIZE/1024));
				break;
				
			case UPLOAD_ERR_EXTENSION:
				$status = 'error';
				break;
				
			default:
				$error = wfMsg('user-identity-box-avatar-error-cantwrite');
		}
	}
	
	/**
	 * @brief Uses Squid to purge avatar data on varnishes
	 * 
	 * @param User $user user object
	 */
	private function purgeOldAvatars($user) {
		if ( $this->app->wg->UseSquid ) {
			// FIXME: is there a way to know what sizes will be used w/o hardcoding them here?
			$avatarUrl = $user->getOption('avatar');
			$urls = array(
				$this->getPurgeUrl($avatarUrl, ''),
				$this->getThumbnailPurgeUrl($avatarUrl, 20), # user-links & history dropdown
				$this->getThumbnailPurgeUrl($avatarUrl, 50), # article-comments
				$this->getThumbnailPurgeUrl($avatarUrl, 100), # user-profile
				$this->getThumbnailPurgeUrl($avatarUrl, 150), # user-profile v3
			);
			F::build('SquidUpdate', array($urls), 'purge');
		}
	}
	
	/**
	 * @brief the basic URL (without image server rewriting, cachebuster, etc.) of the avatar. This can be sent to squid to purge it.
	 *
	 * @param string $url an url for user's avatar; got from User::getOption('avatar')
	 * @param string $thumb if defined will be added as part of base path; default empty string ""
	 *
	 * @return string
	 */
	private function getPurgeUrl($url, $thumb = '') {
		if($url) {
			//if default avatar we glue with messaging.wikia.com
			//if uploaded avatar we glue with common avatar path
			if( strpos( $url, '/' ) !== false ) {
				//uploaded file, we are adding common/avatars path
				$url = $this->app->wg->BlogAvatarPath.rtrim($thumb, '/').$url;
			} else {
				//default avatar, path from messaging.wikia.com
				$hash = F::build('FileRepo', array($url, 2), 'getHashPathForLevel');
				$url = $this->defaultAvatarPath.$thumb.$hash.$url;
			}
		} else {
			$defaults = $this->getDefaultAvatars( trim( $thumb,  "/" ) . "/" );
			$url = array_shift( $defaults );
		}
		
		return $url;
	}
	
	/**
	 * @brief Get the URL in a generic form (ie: images.wikia.com) to be used for purging thumbnails.
	 *
	 * @param string $avatarUrl an url for user's avatar; got from User::getOption('avatar')
	 * @param integer $width the width of the thumbnail (height will be same propotion to width as in unscaled image)
	 * 
	 * @return string url to avatar on the purgable hostname
	 * 
	 * @author Sean Colombo
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getThumbnailPurgeUrl($avatarUrl, $width) {
		$url = $this->getPurgeUrl( $avatarUrl, '/thumb/' );
		
		$file = array_pop( explode( "/", $url ) );
		return sprintf( "%s/%dpx-%s", $url, $width, $file );
	}
	
	/**
	 * @brief Saves the file on the server
	 * 
	 * @param Request $request    WebRequest instance
	 * @param array $userData     user data array; contains: user id (key: userId), full page url (fullPageUrl), user name (username)
	 * @param String $input       name of file input in form
	 * @param $errorMsg           optional string containing details on what went wrong if there is an UPLOAD_ERR_EXTENSION
	 *
	 * @return Integer an error code of operation
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function uploadFile($request, $userData, $input, &$errorMsg='') {
		$this->app->wf->ProfileIn(__METHOD__);
		
		$wgTmpDirectory = $this->app->wg->TmpDirectory;
		
		if( !isset( $wgTmpDirectory ) || !is_dir( $wgTmpDirectory ) ) {
			$wgTmpDirectory = '/tmp';
		}
		
		$errorNo = $this->wg->request->getUploadError( $input );
		if ( $errorNo != UPLOAD_ERR_OK ) {
			$this->app->wf->ProfileOut(__METHOD__);
			return $errorNo;
		}
		$iFileSize = $request->getFileSize( $input );
		
		if( empty( $iFileSize ) ) {
			/**
			 * file size = 0
			 */
			$this->app->wf->ProfileOut(__METHOD__);
			return UPLOAD_ERR_NO_FILE;
		}
		
		$sTmpFile = $wgTmpDirectory.'/'.substr(sha1(uniqid($userData['userId'])), 0, 16);
		$sTmp = $request->getFileTempname($input);
		
		if( move_uploaded_file( $sTmp, $sTmpFile )  ) {
			$errorNo = F::build('ImageOperationsHelper', array($this->app, self::AVATAR_DEFAULT_SIZE, self::AVATAR_DEFAULT_SIZE))->postProcessImageInternal($sTmpFile, $userData, $errorNo, $errorMsg);
			//$errorNo = $this->postProcessImageInternal($sTmpFile, $userData, $errorNo, $errorMsg);
		} else {
			$errorNo = UPLOAD_ERR_CANT_WRITE;
		}
		
		$this->app->wf->ProfileOut(__METHOD__);
		return $errorNo;
	}
	
	/**
	 * @desc While this is technically downloading the URL, the function's purpose is to be similar
	 * to uploadFile, but instead of having the file come from the user's computer, it comes
	 * from the supplied URL.
	 *
	 * @param String $url        the full URL of an image to download and apply as the user's Avatar i.e. user's facebook avatar
	 * @param array $userData    user data array; contains: user id (key: userId), full page url (fullPageUrl), user name (username)
	 * @param $errorMsg          optional string containing details on what went wrong if there is an UPLOAD_ERR_EXTENSION
	 * 
	 * @return Integer error code of operation
	 */
	public function uploadByUrl($url, $userData, &$errorMsg='') {
		$this->app->wf->ProfileIn(__METHOD__);
		
		//start by presuming there is no error
		$errorNo = UPLOAD_ERR_OK;
		$wgTmpDirectory = $this->app->wg->TmpDirectory;
		
		if( !isset($wgTmpDirectory) || !is_dir($wgTmpDirectory) ) {
			$wgTmpDirectory = '/tmp';
		}
		
		//pull the image from the URL and save it to a temporary file
		$sTmpFile = $wgTmpDirectory.'/'.substr(sha1(uniqid($userData['userId'])), 0, 16);
		
		$imgContent = F::build('Http', array($url), 'get');
		if( !file_put_contents($sTmpFile, $imgContent) ) {
			$this->app->wf->ProfileOut( __METHOD__ );
			return UPLOAD_ERR_CANT_WRITE;
		}
		//$errorNo = $this->postProcessImageInternal($sTmpFile, $userData, $errorNo, $errorMsg);
		$errorNo = F::build('ImageOperationsHelper', array($this->app, self::AVATAR_DEFAULT_SIZE, self::AVATAR_DEFAULT_SIZE))->postProcessImageInternal($sTmpFile, $userData, $errorNo, $errorMsg);
		
		$this->app->wf->ProfileOut(__METHOD__);
		return $errorNo;
	}
	
	/**
	 * @brief Passes more data to the template to render avatar modal box
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function renderAvatarLightbox($userId) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$user = F::build('User', array($userId), 'newFromId');
		
		$this->setVal( 'defaultAvatars', $this->getDefaultAvatars() );
		$this->setVal( 'isUploadsPossible', $this->wg->EnableUploads && $this->wg->User->isAllowed( 'upload' ) && is_writeable( $this->wg->UploadDirectory ) );
		$this->setVal( 'avatarName', $user->getOption('avatar') );
		$this->setVal( 'userId', $userId );
		$this->setVal( 'avatarMaxSize', self::AVATAR_MAX_SIZE );
		$this->setVal( 'avatar', F::build( 'AvatarService', array( $user->getName(), self::AVATAR_DEFAULT_SIZE ), 'renderAvatar' ) );
		$this->setVal( 'fbAvatarConnectButton', '<fb:login-button perms="user_about_me" onlogin="UserProfilePage.fbConnectAvatar();">'.$this->app->wf->Msg('user-identity-box-connect-to-fb').'</fb:login-button>' );
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	/**
	 * @brief Gets an array of sample avatars
	 * 
	 * @desc Method based on Masthead::getDefaultAvatars()
	 * 
	 * @param string $thumb a thumb
	 * 
	 * @return array multidimensional array with default avatars defined on messaging.wikia.com
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getDefaultAvatars($thumb = '') {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		//parse message only once per request
		if( empty($thumb) && is_array($this->defaultAvatars) && count($this->defaultAvatars) > 0 ) {
			$this->app->wf->ProfileOut( __METHOD__ );
			return $this->defaultAvatars;
		}
		
		$this->defaultAvatars = array();
		$images = $this->app->runFunction('getMessageAsArray', 'blog-avatar-defaults');
		
		if( is_array($images) ) {
			foreach( $images as $image ) {
				$hash = F::build('FileRepo', array($image, 2), 'getHashPathForLevel');
				$this->defaultAvatars[] = array('name' => $image, 'url' => $this->defaultAvatarPath.$thumb.$hash.$image);
			}
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return $this->defaultAvatars;
	}
	
	/**
	 * @brief Passes more data to the template to render about modal box
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function renderAboutLightbox($userId) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$user = F::build('User', array($userId), 'newFromId');
		
		$userIdentityBox = F::build('UserIdentityBox', array($this->app, $user, self::MAX_TOP_WIKIS));
		$userData = $userIdentityBox->setData(self::MAX_TOP_WIKIS);
		
		if( !is_null($userData['registration']) ) {
			$userData['registration'] = $this->wg->Lang->date($userData['registration']);
		}
		$this->setVal('user', $userData);
		$this->setVal('months', $this->getMonths());
		$this->setVal( 'fbConnectButton', '<fb:login-button perms="user_about_me,user_birthday,user_location,user_work_history,user_website" onlogin="UserProfilePage.fbConnect();">'.$this->app->wf->Msg('user-identity-box-connect-to-fb').'</fb:login-button>' );
		
		if( !empty($userData['birthday']['month']) ) {
			$this->setVal('days', $this->getDays($userData['birthday']['month']));
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	/**
	 * Gets an multi-demensional array of months
	 */
	private function getMonths() {
		return array(
			array('no' => '01', 'month' => $this->wf->Msg('user-identity-box-about-date-01')),
			array('no' => '02', 'month' => $this->wf->Msg('user-identity-box-about-date-02')),
			array('no' => '03', 'month' => $this->wf->Msg('user-identity-box-about-date-03')),
			array('no' => '04', 'month' => $this->wf->Msg('user-identity-box-about-date-04')),
			array('no' => '05', 'month' => $this->wf->Msg('user-identity-box-about-date-05')),
			array('no' => '06', 'month' => $this->wf->Msg('user-identity-box-about-date-06')),
			array('no' => '07', 'month' => $this->wf->Msg('user-identity-box-about-date-07')),
			array('no' => '08', 'month' => $this->wf->Msg('user-identity-box-about-date-08')),
			array('no' => '09', 'month' => $this->wf->Msg('user-identity-box-about-date-09')),
			array('no' => '10', 'month' => $this->wf->Msg('user-identity-box-about-date-10')),
			array('no' => '11', 'month' => $this->wf->Msg('user-identity-box-about-date-11')),
			array('no' => '12', 'month' => $this->wf->Msg('user-identity-box-about-date-12')),
		);
	}
	
	/**
	 * @brief Returns amount of days in given month
	 * 
	 * @param integer $month number of month in year (1 = Jan, 2 = Feb...)
	 * 
	 * @return integer 0 if input was invalid (i.e. $month = 0 or $month = 45)
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getDays($month) {
		$month = intval($month);
		$daysInMonth = array(0, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		
		if( isset($daysInMonth[$month]) ) {
			return $daysInMonth[$month];
		}
		
		return 0;
	}
	
	/**
	 * @brief Get user object from given title
	 * 
	 * @return User
	 * 
	 * @author ADi
	 */
	private function getUserFromTitle( Title $title ) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$user = null;
		
		if( in_array( $title->getNamespace(), $this->allowedNamespaces ) ) {
			// get "owner" of this user / user talk / blog page
			$parts = explode('/', $title->getText());
		}
		else if( ( $title->getNamespace() == NS_SPECIAL ) && ( $title->isSpecial( 'Following' ) || $title->isSpecial( 'Contributions' ) ) ) {
			$target = $this->getVal( 'target' );
			if ($target != '') {
				// Special:Contributions?target=FooBar (RT #68323)
				$parts = array( $target );
			}
			else {
				// get user this special page referrs to
				$parts = explode( '/', $this->getVal( 'title', false ) );
				
				// remove special page name
				array_shift( $parts );
			}
		}
		
		if( isset( $parts[0] ) && ( $parts[0] != '' ) ) {
			$user = F::build('User', array(str_replace( '_', ' ', $parts[0] )), 'newFromName' );
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return $user;
	}
	
	/**
	 * @brief hook handler
	 */
	public function onSkinTemplateOutputPageBeforeExec( $skin, $template ) {
		$this->app->wf->ProfileOut( __METHOD__ );
		
		$this->setRequest( new WikiaRequest( $this->app->wg->Request->getValues() ) );
		
		$title = $this->app->wg->Title;
		$user = $this->getUserFromTitle( $title );
		
		if( $user instanceof User ) {
			$response = $this->app->sendRequest(
			  'UserProfilePage',
			  'index',
			  array(
			    'user' => $user,
			    'userPageBody' => $template->data['bodytext'],
			    'wikiId' => $this->app->wg->CityId
			  ));

			$template->data['bodytext'] = (string) $response;
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return true;
	}
	
	/**
	 * @brief Gets facebook user data from database or tries to connect via FB API and get those data then returns it as a JSON data
	 * 
	 * @desc Checks if user is logged-in only because we decided to put facebook connect button only for owners of a profile; staff can not see the button
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onFacebookConnect() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$user = $this->app->wg->User;
		$result = array('success' => false);
		
		if( !$user->isAnon() ) {
			$avatar = (bool) $this->getVal('avatar');
			$fb_ids = F::build('FBConnectDB', array($user), 'getFacebookIDs');
			$fbConnectAPI  = F::build('FBConnectAPI');
			
			if( count($fb_ids) > 0 ) {
				$fbUserId = $fb_ids[0];
			} else {
				$fbUserId = $fbConnectAPI->user();
			}
			
			if( $fbUserId > 0 ) {
				if( $avatar === true ) {
					$userFbData = $fbConnectAPI->getUserInfo(
						$fbUserId,
						array('pic_big') 
					);
					
					$data->source = 'facebook';
					$data->file = $userFbData['pic_big'];
					$this->saveUsersAvatar($user->getID(), $data);
					
					$this->app->wf->ProfileOut( __METHOD__ );
					return true;
					
				} else {
					$userFbData = $fbConnectAPI->getUserInfo(
						$fbUserId,
						array('name, current_location, hometown_location, work_history, profile_url, sex, birthday_date, pic_big, website')
					);
					$userFbData = $this->cleanFbData($userFbData);
				}
				
				$result = array('success' => true, 'fbUser' => $userFbData);
			} else {
				$result = array('success' => false, 'error' => $this->app->wf->Msg('user-identity-box-invalid-fb-id-error'));
			}
		} else {
			$result = array('success' => false, 'error' => $this->wf->Msg('userprofilepage-interview-save-internal-error'));
		}
		
		$this->setVal('result', $result);
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	/**
	 * @brief Clears all data recivied from Facebook so all of them are strings
	 * 
	 * @param array $fbData facebook user data recivied from FBConnectAPI::getUserInfo()
	 * 
	 * @return array
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function cleanFbData($fbData) {
		unset($fbData['uid']);
		
		foreach($fbData as $key => $data) {
			if( !is_string($data) ) {
				switch($key) {
					case 'work_history':
						$fbData['work_history'] = $this->extractFbFirstField($fbData['work_history'], 'position');
						break;
					case 'current_location':
						$fbData['current_location'] = $this->extractFbFirstField($fbData['current_location'], 'city');
						break;
				}
			}
		}
		
		if( !empty($fbData['website']) ) {
			$websites = nl2br($fbData['website']);
			$websites = explode('<br />', $websites);
			$fbData['website'] = ( isset($websites[0]) ? $websites[0] : '');
		}
		
		if( empty($fbData['current_location']) ) {
			$this->extractFbFirstField($fbData['hometown_location'], 'city');
		} else {
			unset($fbData['hometown_location']);
		}
		
		return $fbData;
	}
	
	/**
	 * @brief Searches for a string data to return
	 * 
	 * @param array | string    $fbData data from facebook
	 * @param string            $field of an array which we want to find and return
	 * 
	 * @return string
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function extractFbFirstField($fbData, $field = null) {
		if( is_null($field) ) {
			return '';
		}
		
		if( !empty($fbData[$field]) && is_string($fbData[$field]) ) {
			return $fbData[$field];
		}
		
		if( !empty($fbData[0][$field]) ) {
			return $fbData[0][$field];
		}
		
		return '';
	}
	
	/**
	 * @brief Gets wikiId from request and hides from faviorites wikis
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski 
	 */
	public function onHideWiki() {
		$result = array('success' => false);
		$userId = intval( $this->getVal('userId') );
		$wikiId = intval( $this->getVal('wikiId') );
		
		$user = F::build('User', array($userId), 'newFromId');
		$isAllowed = ( $this->app->wg->User->isAllowed('staff') || intval($user->getID()) === intval($this->app->wg->User->getID()) );
		
		if( $isAllowed && $wikiId > 0 ) {
			$userIdentityBox = F::build('UserIdentityBox', array($this->app, $user, self::MAX_TOP_WIKIS));
			$result = array( 'success' => $userIdentityBox->hideWiki($wikiId) );
		}
		
		$this->setVal('result', $result);
	}
	
	/**
	 * @brief Gets fav wikis information and passes it as JSON
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski 
	 */
	public function onRefreshFavWikis() {
		$result = array('success' => false);
		$userId = intval( $this->getVal('userId') );
		
		$user = F::build('User', array($userId), 'newFromId');
		
		$userIdentityBox = F::build('UserIdentityBox', array($this->app, $user, self::MAX_TOP_WIKIS));
		$result = array( 'success' => true, 'wikis' => $userIdentityBox->getTopWikis(true) );
		
		$this->setVal('result', $result);
	}
	
	public function getClosingModal() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		$userId = $this->getVal('userId');
		$user = $this->wg->User;
		
		if( !$user->isAnon() ) {
			$this->setVal( 'body', (string) $this->sendSelfRequest('renderClosingModal', array('userId' => $userId)) );
		} else {
			throw new WikiaException( 'User not logged in' );
		}
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
	public function renderClosingModal() {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		//we want only the template for now...
		
		$this->app->wf->ProfileOut( __METHOD__ );
	}
	
}