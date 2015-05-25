<?php

class UserProfilePageController extends WikiaController {
	const AVATAR_DEFAULT_SIZE = 150;
	const AVATAR_MAX_SIZE = 512000;
	const MAX_TOP_WIKIS = 4;

	const FBPAGE_BASE_URL = 'https://www.facebook.com/';

	/**
	 * @var $profilePage UserProfilePage
	 */
	protected $profilePage = null;
	protected $allowedNamespaces = null;
	protected $title = null;

	protected $defaultAvatars = null;
	protected $defaultAvatarPath = 'http://images.wikia.com/messaging/images/';

	public function __construct( WikiaApp $app = null ) {
		global $UPPNamespaces;
		if( is_null( $app ) ) {
			$app = F::app();
		}
		$this->app = $app;
		$this->allowedNamespaces = $UPPNamespaces;
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
		wfProfileIn( __METHOD__ );

		/**
		 * @var $user User
		 */
		$user = $this->getVal( 'user' );

		$pageBody = $this->getVal( 'userPageBody' );

		if ($this->title instanceof Title) {
			$namespace = $this->title->getNamespace();
			$isSubpage = $this->title->isSubpage();
		} else {
			$namespace = $this->app->wg->NamespaceNumber;
			$isSubpage = false;
		}

		$useOriginalBody = true;

		if ( $user instanceof User ) {
			$this->profilePage = new UserProfilePage( $user );
			if ( $namespace == NS_USER && !$isSubpage ) {
				// we'll implement interview section later
				// $this->setVal( 'questions', $this->profilePage->getInterviewQuestions( $wikiId, true ) );
				$this->setVal( 'stuffSectionBody', $pageBody );
				$useOriginalBody = false;
			}

			$this->setVal( 'isUserPageOwner', ( ( $user->getId() == $this->wg->User->getId() ) ? true : false ) );
		}

		if ( $useOriginalBody ) {
			$this->response->setBody( $pageBody );
		}

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$this->overrideTemplate( 'WikiaMobileIndex' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Renders new user identity box
	 *
	 * @desc Creates array of user's data and passes it to the template
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function renderUserIdentityBox() {
		wfProfileIn( __METHOD__ );

		$this->setVal( 'wgBlankImgUrl', $this->wg->BlankImgUrl );

		$this->response->addAsset( 'extensions/wikia/UserProfilePageV3/css/UserProfilePage.scss' );
		$this->response->addAsset( 'extensions/wikia/UserProfilePageV3/js/UserProfilePage.js' );

		$sessionUser = $this->wg->User;

		$this->setRequest( new WikiaRequest( $this->app->wg->Request->getValues() ) );
		$user = UserProfilePageHelper::getUserFromTitle();
		/**
		 * @var $userIdentityBox UserIdentityBox
		 */
		$userIdentityBox = new UserIdentityBox( $user );
		$isUserPageOwner = ( !$user->isAnon() && $user->getId() == $sessionUser->getId() ) ? true : false;

		if ( $isUserPageOwner ) {
			// this is a small trick to remove some
			// probably cache/session lag. before, I used
			// phalanx to block my user globally. but just
			// after I blocked him the session user object
			// still returned false when I called on it getBlockedStatus()
			// in the same time user object retrieved from title
			// returned id of user block. after more or less an hour
			// both instances of User object returned me id of user block
			// when I called getBlockedStatus() on them
			$sessionUser = $user;
		}

		$userData = $userIdentityBox->getFullData();

		$this->setVal( 'isBlocked', ( $user->isBlocked() || $user->isBlockedGlobally() ) );
		$this->setVal( 'zeroStateCssClass', ( $userData['showZeroStates'] ) ? 'zero-state' : '' );

		$this->setVal( 'user', $userData );
		$this->setVal( 'deleteAvatarLink', SpecialPage::getTitleFor( 'RemoveUserAvatar' )->getFullUrl( 'av_user=' . $userData['name'] ) );
		$this->setVal( 'canRemoveAvatar', $sessionUser->isAllowed( 'removeavatar' ) );
		$this->setVal( 'isUserPageOwner', $isUserPageOwner );

		$canEditProfile = $isUserPageOwner || $sessionUser->isAllowed( 'editprofilev3' );
		// if user is blocked locally (can't edit anything) he can't edit masthead too
		$canEditProfile = $sessionUser->isAllowed( 'edit' ) ? $canEditProfile : false;
		// if user is blocked globally he can't edit
		$blockId = $sessionUser->getBlockId();
		$canEditProfile = empty($blockId) ? $canEditProfile : false;
		$this->setVal( 'canEditProfile', $canEditProfile );
		$this->setVal( 'isWikiStaff', $sessionUser->isAllowed( 'staff' ) );
		$this->setVal( 'canEditProfile', ( $isUserPageOwner || $sessionUser->isAllowed( 'staff' ) || $sessionUser->isAllowed( 'editprofilev3' ) ) );

		if ( !empty( $this->title ) ) {
			$this->setVal( 'reloadUrl', htmlentities( $this->title->getFullUrl(), ENT_COMPAT, 'UTF-8' ) );
		} else {
			$this->setVal( 'reloadUrl', '' );
		}

		$this->response->addAsset( 'resources/wikia/modules/aim.js' );

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$this->overrideTemplate( 'WikiaMobileRenderUserIdentityBox' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Renders new action button
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function renderActionButton() {
		wfProfileIn( __METHOD__ );

		$namespace = $this->title->getNamespace();

		$this->setRequest( new WikiaRequest( $this->app->wg->Request->getValues() ) );
		$user = UserProfilePageHelper::getUserFromTitle();

		/**
		 * @var $sessionUser User
		 */
		$sessionUser = $this->wg->User;
		$canRename = $sessionUser->isAllowed( 'renameprofilev3' );
		$canProtect = $sessionUser->isAllowed( 'protect' );
		$canDelete = $sessionUser->isAllowed( 'deleteprofilev3' );
		$isUserPageOwner = ( $user instanceof User && !$user->isAnon() && $user->getId() == $sessionUser->getId() ) ? true : false;

		$editQuery = array( 'action' => 'edit' );

		// check if this is an older version of the page
		$oldid = $this->app->wg->Request->getInt( 'oldid', 0 );
		if ( $oldid ) {
			$editQuery['oldid'] = $oldid;
		}

		$actionButtonArray = array();
		if ( $namespace == NS_USER ) {
			// profile page
			$actionButtonArray = array(
				'action' => array(
					'href' => $this->title->getLocalUrl( $editQuery ),
					'text' => wfMessage( 'user-action-menu-edit-profile' )->escaped(),
					'id' => 'ca-edit',
					'accesskey' => wfMessage( 'accesskey-ca-edit' )->escaped(),
				),
				'image' => MenuButtonController::EDIT_ICON,
				'name' => 'editprofile',
			);
		} else {
			if ( $namespace == NS_USER_TALK && empty( $this->app->wg->EnableWallExt ) ) {
				// talk page
				/**
				 * @var $title Title
				 */
				$title = Title::newFromText( $user->getName(), NS_USER_TALK );

				if ( $title instanceof Title ) {
					// sometimes title isn't created, I've tried to reproduce it on my devbox and I couldn't
					// checking if $title is instance of Title is a quick fix -- if it isn't no action button will be shown
					if ( $isUserPageOwner || $this->app->wg->Request->getVal( 'oldid' ) ) {
						$actionButtonArray = array(
							'action' => array(
								'href' => $this->title->getLocalUrl( $editQuery ),
								'text' => wfMessage( 'user-action-menu-edit' )->escaped(),
								'id' => 'ca-edit',
								'accesskey' => wfMessage( 'accesskey-ca-edit' )->escaped(),
							),
							'image' => MenuButtonController::EDIT_ICON,
							'name' => 'editprofile',
						);
					} else {
						$actionButtonArray = array(
							'action' => array(
								'href' => $title->getLocalUrl( array_merge( $editQuery, array( 'section' => 'new' ) ) ),
								'text' => wfMessage( 'user-action-menu-leave-message' )->escaped(),
								'id' => 'ca-addsection',
								'accesskey' => wfMessage( 'accesskey-ca-addsection' )->escaped(),
							),
							'image' => MenuButtonController::MESSAGE_ICON,
							'name' => 'leavemessage',
							'dropdown' => array(
								'edit' => array(
									'href' => $this->title->getFullUrl( $editQuery ),
									'text' => wfMessage( 'user-action-menu-edit' )->escaped(),
									'id' => 'ca-edit',
									'accesskey' => wfMessage( 'accesskey-ca-edit' )->escaped(),
								)
							),
						);
					}
				}
			} else {
				if (defined( 'NS_BLOG_ARTICLE' ) && $namespace == NS_BLOG_ARTICLE && $isUserPageOwner ) {
					// blog page
					global $wgCreateBlogPagePreload;

					$actionButtonArray = array(
						'action' => array(
							'href' => SpecialPage::getTitleFor( 'CreateBlogPage' )->getLocalUrl( !empty( $wgCreateBlogPagePreload ) ? 'preload=$wgCreateBlogPagePreload' : '' ),
							'text' => wfMessage( 'blog-create-post-label' )->escaped(),
						),
						'image' => MenuButtonController::BLOG_ICON,
						'name' => 'createblogpost',
					);
				}
			}
		}

		if ( in_array( $namespace, array( NS_USER, NS_USER_TALK ) ) ) {
			// profile & talk page
			if ( $canRename ) {
				/**
				 * @var $specialMovePage Title
				 */
				$specialMovePage = SpecialPage::getTitleFor( 'MovePage' );
				$renameUrl = $specialMovePage->getLocalUrl() . '/' . $this->title->__toString();
				$actionButtonArray['dropdown']['rename'] = array(
					'href' => $renameUrl,
					'text' => wfMessage( 'user-action-menu-rename' )->escaped(),
					'id' => 'ca-move',
					'accesskey' => wfMessage( 'accesskey-ca-move' )->escaped(),
				);
			}

			if ( $canProtect ) {
				$protectStatus = $this->title->isProtected() ? 'unprotect' : 'protect';

				$actionButtonArray['dropdown']['protect'] = array(
					'href' => $this->title->getLocalUrl( array( 'action' => $protectStatus ) ),
					'text' => wfMessage( 'user-action-menu-' . $protectStatus )->escaped(),
					'id' => 'ca-protect',
					'accesskey' => wfMessage( 'accesskey-ca-protect' )->escaped(),
				);
			}

			if ($canDelete) {
				$actionButtonArray['dropdown']['delete'] = array(
					'href' => $this->title->getLocalUrl( array( 'action' => 'delete' ) ),
					'text' => wfMessage( 'user-action-menu-delete' )->escaped(),
					'id' => 'ca-delete',
					'accesskey' => wfMessage( 'accesskey-ca-delete' )->escaped(),
				);
			}

			$actionButtonArray['dropdown']['history'] = array(
				'href' => $this->title->getLocalUrl( array( 'action' => 'history' ) ),
				'text' => wfMessage( 'user-action-menu-history' )->escaped(),
				'id' => 'ca-history',
				'accesskey' => wfMessage( 'accesskey-ca-history' )->escaped(),
			);
		}

		wfRunHooks( 'UserProfilePageAfterGetActionButtonData', array( &$actionButtonArray, $namespace, $canRename, $canProtect, $canDelete, $isUserPageOwner ) );

		$actionButton = wfRenderModule( 'MenuButton', 'Index', $actionButtonArray );
		$this->setVal( 'actionButton', $actionButton );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Gets lightbox data
	 *
	 * @requestParam string $userId user's unique id
	 * @requestParam string $tab current tab
	 *
	 * @author ADi
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getLightboxData() {
		wfProfileIn( __METHOD__ );

		$selectedTab = $this->getVal( 'tab' );
		$userId = $this->getVal( 'userId' );
		$sessionUser = $this->wg->User;
		$canEditProfile = $sessionUser->isAllowed( 'editprofilev3' );

		// checking if user is blocked locally
		$isBlocked = !$sessionUser->isAllowed( 'edit' );
		// checking if user is blocked globally
		$isBlocked = empty( $isBlocked ) ? $sessionUser->getBlockId() : $isBlocked;

		if ( ( $sessionUser->isAnon() && !$canEditProfile ) || $isBlocked ) {
			throw new WikiaException( wfMessage( 'userprofilepage-invalid-user' )->escaped() );
		} else {
			$this->profilePage = new UserProfilePage( $sessionUser );

			$this->setVal( 'body', ( string )$this->sendSelfRequest( 'renderLightbox', array( 'tab' => $selectedTab, 'userId' => $userId ) ) );

			if ( !empty( $this->wg->AvatarsMaintenance ) ) {
				$this->setVal( 'avatarsDisabled', true );
				$this->setVal( 'avatarsDisabledMsg', wfMessage('user-identity-avatars-maintenance')->text() );
			}
		}

		wfProfileOut( __METHOD__ );
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
		wfProfileIn( __METHOD__ );

		$selectedTab = $this->getVal( 'tab' );
		$userId = $this->getVal( 'userId' );

		$tabs = [
			['id' => 'avatar', 'name' => wfMessage('user-identity-box-avatar')->escaped()],
			['id' => 'about', 'name' => wfMessage('user-identity-box-about-me')->escaped()],
		];

		$this->renderAvatarLightbox( $userId );
		$this->renderAboutLightbox( $userId );

		$this->setVal( 'tabs', $tabs );
		$this->setVal( 'selectedTab', $selectedTab );

		$this->setVal( 'wgBlankImgUrl', $this->wg->BlankImgUrl );

		wfProfileOut( __METHOD__ );
	}

	public function saveInterviewAnswers() {
		wfProfileIn( __METHOD__ );

		$user = User::newFromId( $this->getVal( 'userId' ) );
		$wikiId = $this->wg->CityId;

		$answers = json_decode( $this->getVal( 'answers' ) );

		$status = 'error';
		$errorMsg = wfMessage( 'userprofilepage-interview-save-internal-error' )->escaped();

		if ( !$user->isAnon() && is_array( $answers ) ) {
			$this->profilePage = new UserProfilePage( $user );

			if ( !$this->profilePage->saveInterviewAnswers( $wikiId, $answers ) ) {
				$status = 'error';
				$errorMsg = wfMessage( 'userprofilepage-interview-save-internal-error' )->escaped();
			}
			else {
				$status = 'ok';
			}
		}

		$this->setVal( 'status', $status );
		if ( $status == 'error' ) {
			$this->setVal( 'errorMsg', $errorMsg );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Receives data from AJAX call, validates and saves new user data
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function saveUserData() {
		wfProfileIn( __METHOD__ );

		$user = User::newFromId( $this->getVal( 'userId' ) );
		$isAllowed = ( $this->app->wg->User->isAllowed( 'editprofilev3' ) || intval( $user->getId() ) === intval( $this->app->wg->User->getId() ) );

		$userData = json_decode( $this->getVal( 'data' ) );

		$status = 'error';
		$errorMsg = wfMessage( 'user-identity-box-saving-internal-error' )->escaped();

		if ( $isAllowed && is_object( $userData ) ) {
			/**
			 * @var $userIdentityBox UserIdentityBox
			 */
			$userIdentityBox = new UserIdentityBox( $user );

			if ( !empty( $userData->website ) && strpos( $userData->website, 'http' ) !== 0 ) {
				$userData->website = 'http://' . $userData->website;
			}

			if ( !empty( $userData->fbPage ) && strpos( $userData->fbPage, self::FBPAGE_BASE_URL ) !== 0 ) {
				$userData->fbPage = self::FBPAGE_BASE_URL . $userData->fbPage;
			}

			if ( !$userIdentityBox->saveUserData( $userData ) ) {
				$status = 'error';
				$errorMsg = wfMessage( 'userprofilepage-interview-save-internal-error' )->escaped();
			} else {
				$status = 'ok';
			}
		}

		if ( $isAllowed && is_null( $userData ) ) {
			$errorMsg = wfMessage( 'user-identity-box-saving-error' )->escaped();
		}

		$this->setVal( 'status', $status );
		if ( $status === 'error' ) {
			$this->setVal( 'errorMsg', $errorMsg );
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( !empty( $userData->avatarData ) ) {
			$status = $this->saveUsersAvatar( $user->getID(), $userData->avatarData );
			if ( $status !== true ) {
				$this->setVal( 'errorMsg', $errorMsg );
				wfProfileOut( __METHOD__ );
				return true;
			}
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

	/**
	 * @brief Validates and saves new user's avatar
	 *
	 * @param integer $userId id of user which avatar is going to be saved; taken from request if not given
	 * @param object $data data object with source of file and url/name of avatar's file; taken from request if not given
	 *
	 * @return bool
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function saveUsersAvatar( $userId = null, $data = null ) {
		wfProfileIn( __METHOD__ );

		if ( is_null( $userId ) ) {
			$user = User::newFromId( $this->getVal( 'userId' ) );
		} else {
			$user = User::newFromId( $userId );
		}

		$isAllowed = (
			$this->app->wg->User->isAllowed('editprofilev3') ||
			$user->getId() == $this->app->wg->User->getId()
		);

		if ( is_null( $data ) ) {
			$data = json_decode( $this->getVal( 'data' ) );
		}

		if ( $isAllowed && isset( $data->source ) && isset( $data->file ) ) {
			switch ( $data->source ) {
				case 'sample':
					// remove old avatar file
					Masthead::newFromUser( $user )->removeFile( false );
					$user->setOption( 'avatar', $data->file );
					break;
				case 'uploaded':
					$errorMsg = wfMessage( 'userprofilepage-interview-save-internal-error' )->escaped();
					$avatar = $this->saveAvatarFromUrl( $user, $data->file, $errorMsg );
					$user->setOption( 'avatar', $avatar );
					break;
				default:
					break;
			}

			// TODO: $user->getTouched() get be used to invalidate avatar URLs instead
			$user->setOption( 'avatar_rev', date( 'U' ) );
			$user->saveSettings();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @brief Gets avatar from url, saves it on server and resize it if needed then returns path
	 *
	 * @param User $user user object
	 * @param string $url url to user's avatar
	 * @param string $errorMsg reference to a string variable where errors messages are returned
	 *
	 * @return string | boolean
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function saveAvatarFromUrl( User $user, $url, &$errorMsg ) {
		wfProfileIn( __METHOD__ );

		$userId = $user->getId();

		$errorNo = $this->uploadByUrl(
			$url,
			array(
				'userId' => $userId,
				'username' => $user->getName(),
				'user' => $user,
				'localPath' => '',
			),
			$errorMsg
		);

		$localPath = $this->getLocalPath( $user );

		if ( $errorNo != UPLOAD_ERR_OK ) {
			$res = false;
		} else {
			$res = $localPath;
		}
		wfProfileOut( __METHOD__ );
		return $res;
	}

	/**
	 * @brief Submits avatar form and genarate url for preview
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onSubmitUsersAvatar() {

		$this->response->setContentType( 'text/html; charset=utf-8' );

		$user = User::newFromId( $this->getVal( 'userId' ) );

		$errorMsg = wfMessage( 'userprofilepage-interview-save-internal-error' )->escaped();
		$result = [ 'success' => false, 'error' => $errorMsg ];

		if ( !$user->isAnon() && $this->request->wasPosted() ) {
			$avatarUploadFiled = 'UPPLightboxAvatar';
			$uploadError = $this->app->wg->Request->getUploadError( $avatarUploadFiled );

			if ( $uploadError != 0 ) {
				$thumbnail = $uploadError;
			} else {
				$fileName = $this->app->wg->Request->getFileTempName( $avatarUploadFiled );
				$fileuploader = new WikiaTempFilesUpload();
				$thumbnail = $this->storeInTempImage( $fileName, $fileuploader );
			}

			if ( false === $thumbnail || is_int( $thumbnail ) ) {
				$result = [ 'success' => false, 'error' => $this->validateUpload( $thumbnail ) ];
				$this->setVal( 'result', $result ) ;
				return;
			}

			$this->setVal( 'result', $result );

			$avatarUrl = $thumbnail->url;
			// look for an occurrence of a ? to know if we should append the query string with a ? or a &
			$avatarUrl .= ( preg_match( '/\?/', $avatarUrl ) ? '&' : '?' ) . 'cb=' . date( 'U' );

			$result = [ 'success' => true, 'avatar' => $avatarUrl ];
			$this->setVal('result', $result);

			return;
		}

		$result = [ 'success' => false, 'error' => $errorMsg ];
		$this->setVal( 'result', $result );
	}

	/**
	 * @param $fileName String
	 * @param $fileuploader WikiaTempFilesUpload
	 * @return bool|int|MediaTransformOutput
	 */
	protected function storeInTempImage( $fileName, $fileuploader ) {
		wfProfileIn( __METHOD__ );

		if ( filesize( $fileName ) > self::AVATAR_MAX_SIZE ) {
			wfProfileOut( __METHOD__ );
			return UPLOAD_ERR_FORM_SIZE;
		}

		$tempName = $fileuploader->tempFileName( $this->wg->User );
		$title = Title::makeTitle( NS_FILE, $tempName );
		$localRepo = RepoGroup::singleton()->getLocalRepo();

		/**
		 * @var $ioh ImageOperationsHelper
		 */
		$ioh = new ImageOperationsHelper();

		$out = $ioh->postProcessFile( $fileName );
		if ( $out !== true ) {
			wfProfileOut( __METHOD__ );
			return $out;
		}

		$file = new FakeLocalFile( $title, $localRepo );
		$status = $file->upload( $fileName, '', '' );

		if( $status->ok ) {
			$width = min( self::AVATAR_DEFAULT_SIZE, $file->width );
			$height = min( self::AVATAR_DEFAULT_SIZE, $file->height );

			$thumbnail = $file->transform( [
				'height' => $height,
				'width' => $width,
			] );
		} else {
			$errors = $status->getErrorsArray();
			$errMsg = 'Unable to upload temp file fo avatar. Error(s): ';
			foreach( $errors as $error ) {
				$errMsg .= $error[0] . ', ';
			}
			$errMsg = rtrim( $errMsg, ', ' );

			wfDebugLog( __METHOD__, $errMsg );
			$thumbnail = false;
		}

		wfProfileOut( __METHOD__ );
		return $thumbnail;
	}

	/**
	 * @brief Validates file upload (whenever it's regular upload or by-url upload) and sets status and errorMsg
	 *
	 * @param integer $errorNo variable being checked
	 *
	 * @return String
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function validateUpload( $errorNo ) {
		switch ( $errorNo ) {
			case UPLOAD_ERR_NO_FILE:
				return wfMessage( 'user-identity-box-avatar-error-nofile' )->escaped();
				break;

			case UPLOAD_ERR_CANT_WRITE:
				return wfMessage( 'user-identity-box-avatar-error-cantwrite' )->escaped();
				break;

			case UPLOAD_ERR_FORM_SIZE:
				return wfMessage( 'user-identity-box-avatar-error-size', ( int )( self::AVATAR_MAX_SIZE / 1024 ) )->escaped();
				break;
			case UPLOAD_ERR_EXTENSION;
				return wfMessage( 'userprofilepage-avatar-error-type', $this->wg->Lang->listToText( ImageOperationsHelper::getAllowedMime() ) )->escaped();
				break;
			case ImageOperationsHelper::UPLOAD_ERR_RESOLUTION:
				return wfMessage( 'userprofilepage-avatar-error-resolution' )->escaped();
				break;
			default:
				return wfMessage( 'user-identity-box-avatar-error' )->escaped();
		}
	}

	/**
	 * @brief get Local Path to avatar
	 */
	private function getLocalPath( $user ) {
		/**
		 * @var $oAvatarObj Masthead
		 */
		$oAvatarObj = Masthead::newFromUser( $user );
		return $oAvatarObj->getLocalPath();
	}

	/**
	 * @brief Saves the file on the server
	 *
	 * @param WebRequest $request    WebRequest instance
	 * @param array $userData     user data array; contains: user id (key: userId), full page url (fullPageUrl), user name (username)
	 * @param String $input       name of file input in form
	 * @param String $errorMsg           optional string containing details on what went wrong if there is an UPLOAD_ERR_EXTENSION
	 *
	 * @return Integer an error code of operation
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function uploadFile( $request, $userData, $input, &$errorMsg = '' ) {
		wfProfileIn( __METHOD__ );

		$errorNo = $this->wg->Request->getUploadError( $input );

		if ( $errorNo != UPLOAD_ERR_OK ) {
			wfProfileOut( __METHOD__ );
			return $errorNo;
		}

		$errorMsg = "";

		if ( class_exists( 'Masthead' ) ) {
			/**
			 * @var $oAvatarObj Masthead
			 */
			$oAvatarObj = Masthead::newFromUser( $userData['user'] );
			$errorNo = $oAvatarObj->uploadFile( $this->wg->Request, 'UPPLightboxAvatar', $errorMsg );


		} else {
			$errorNo = UPLOAD_ERR_EXTENSION;
		}

		wfProfileOut( __METHOD__ );
		return $errorNo;
	}

	/**
	 * @desc While this is technically downloading the URL, the function's purpose is to be similar
	 * to uploadFile, but instead of having the file come from the user's computer, it comes
	 * from the supplied URL.
	 *
	 * @param String $url        the full URL of an image to download and apply as the user's Avatar
	 * @param array $userData    user data array; contains: user id (key: userId), full page url (fullPageUrl), user name (username)
	 * @param String $errorMsg          optional string containing details on what went wrong if there is an UPLOAD_ERR_EXTENSION
	 *
	 * @return Integer error code of operation
	 */
	public function uploadByUrl( $url, $userData, &$errorMsg = '' ) {
		wfProfileIn( __METHOD__ );

		//start by presuming there is no error
		//$errorNo = UPLOAD_ERR_OK;
		$user = $userData['user'];
		if ( class_exists( 'Masthead' ) ) {
			/**
			 * @var $oAvatarObj Masthead
			 */
			$oAvatarObj = Masthead::newFromUser( $user );
			$localPath = $this->getLocalPath( $user );
			$errorNo = $oAvatarObj->uploadByUrl( $url );
			/**
			 * @var $userIdentityBox UserIdentityBox
			 */
			$userIdentityBox = new UserIdentityBox( $user );
			$userData = $userIdentityBox->getFullData();
			$userData['avatar'] = $localPath;
			$userIdentityBox->saveUserData( $userData );
		} else {
			$errorNo = UPLOAD_ERR_EXTENSION;
		}

		wfProfileOut( __METHOD__ );
		return $errorNo;
	}

	/**
	 * @brief Passes more data to the template to render avatar modal box
	 *
	 * @param int $userId
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function renderAvatarLightbox( $userId ) {
		wfProfileIn( __METHOD__ );

		$user = User::newFromId( $userId );

		$this->setVal( 'defaultAvatars', $this->getDefaultAvatars() );
		$this->setVal( 'isUploadsPossible',
			$this->wg->EnableUploads &&
			$this->wg->User->isAllowed( 'upload' ) &&
			empty( $this->wg->AvatarsMaintenance )
		);

		$this->setVal( 'avatarName', $user->getOption( 'avatar' ) );
		$this->setVal( 'userId', $userId );
		$this->setVal( 'avatarMaxSize', self::AVATAR_MAX_SIZE );
		$this->setVal( 'avatar', AvatarService::renderAvatar( $user->getName(), self::AVATAR_DEFAULT_SIZE ) );

		wfProfileOut( __METHOD__ );
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
	private function getDefaultAvatars( $thumb = '' ) {
		wfProfileIn( __METHOD__ );

		// parse message only once per request
		if ( empty( $thumb ) && is_array( $this->defaultAvatars ) && count( $this->defaultAvatars ) > 0 ) {
			wfProfileOut( __METHOD__ );
			return $this->defaultAvatars;
		}

		$this->defaultAvatars = array();
		$images = getMessageForContentAsArray( 'blog-avatar-defaults' );

		if ( is_array( $images ) ) {
			foreach ( $images as $image ) {
				$hash = FileRepo::getHashPathForLevel( $image, 2 );
				$this->defaultAvatars[] = array( 'name' => $image, 'url' => $this->defaultAvatarPath . $thumb . $hash . $image );
			}
		}

		wfProfileOut( __METHOD__ );
		return $this->defaultAvatars;
	}

	/**
	 * @brief Passes more data to the template to render about modal box
	 *
	 * @param int $userId
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function renderAboutLightbox( $userId ) {
		wfProfileIn( __METHOD__ );

		$user = User::newFromId( $userId );

		/**
		 * @var $userIdentityBox UserIdentityBox
		 */
		$userIdentityBox = new UserIdentityBox( $user );

		$userData = $userIdentityBox->getFullData();

		if ( !empty( $userData['fbPage'] ) ) {
			$userData['fbPage'] = str_replace( self::FBPAGE_BASE_URL, '', $userData['fbPage'] );
		}

		$this->setVal( 'user', $userData );

		$this->setVal( 'charLimits', [
			'name' => UserIdentityBox::USER_NAME_CHAR_LIMIT,
			'location' => UserIdentityBox::USER_LOCATION_CHAR_LIMIT,
			'occupation' => UserIdentityBox::USER_OCCUPATION_CHAR_LIMIT,
			'gender' => UserIdentityBox::USER_GENDER_CHAR_LIMIT,
		] );

		if ( !empty( $userData['birthday']['month'] ) ) {
			$this->setVal( 'days', cal_days_in_month( CAL_GREGORIAN, $userData['birthday']['month'], 2000 /* leap year */ ) );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Gets wikiId from request and hides from faviorites wikis
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onHideWiki() {
		$result = array( 'success' => false );
		$userId = intval( $this->getVal( 'userId' ) );
		$wikiId = intval( $this->getVal( 'wikiId' ) );

		$user = User::newFromId( $userId );
		$isAllowed = ( $this->app->wg->User->isAllowed( 'editprofilev3' ) || intval( $user->getId() ) === intval( $this->app->wg->User->getId() ) );

		if ( $isAllowed && $wikiId > 0 ) {
			/**
			 * @var $userIdentityBox UserIdentityBox
			 */
			$userIdentityBox = new UserIdentityBox( $user );
			$success = $userIdentityBox->hideWiki( $wikiId );

			$result = array( 'success' => $success, 'wikis' => $userIdentityBox->getTopWikis() );
		}

		$this->setVal( 'result', $result );
	}

	/**
	 * @brief Gets fav wikis information and passes it as JSON
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onRefreshFavWikis() {
		$userId = intval( $this->getVal( 'userId' ) );
		$user = User::newFromId( $userId );
		$userIdentityBox = new UserIdentityBox( $user );
		$result = array( 'success' => true, 'wikis' => $userIdentityBox->getTopWikis( true ) );

		$this->setVal( 'result', $result );
	}

	public function getClosingModal() {
		wfProfileIn( __METHOD__ );

		$userId = $this->getVal( 'userId' );
		$user = $this->wg->User;

		if ( !$user->isAnon() ) {
			$this->setVal( 'body', ( string )$this->sendSelfRequest( 'renderClosingModal', array( 'userId' => $userId ) ) );
		} else {
			throw new WikiaException( 'User not logged in' );
		}

		wfProfileOut( __METHOD__ );
	}

	public function renderClosingModal() {
		wfProfileIn( __METHOD__ );

		// we want only the template for now...

		wfProfileOut( __METHOD__ );
	}

	public function removeavatar() {
		wfProfileIn( __METHOD__ );
		$this->setVal( 'status', false );

		// macbre: avatars operations are disabled during maintenance
		global $wgAvatarsMaintenance;
		if ( !empty( $wgAvatarsMaintenance ) ) {
			$this->setVal( 'error', wfMessage( 'user-identity-avatars-maintenance' )->escaped() );
			wfProfileOut( __METHOD__ );
			return true;
		}

		if (!$this->app->wg->User->isAllowed( 'removeavatar' ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( $this->request->getVal( 'avUser' ) ) {
			$avUser = User::newFromName( $this->request->getVal( 'avUser' ) );
			if ( $avUser->getID() !== 0 ) {
				$avatar = Masthead::newFromUser( $avUser );
				if ( $avatar->removeFile( true ) ) {
					wfProfileOut( __METHOD__ );
					$this->setVal( 'status', "ok" );
					return true;
				}
			}
		}

		$this->setVal( 'error', wfMessage( 'user-identity-remove-fail' )->escaped() );

		wfProfileOut( __METHOD__ );
		return true;
	}

}
