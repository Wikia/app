<?php

use Wikia\Service\User\Attributes\UserAttributes;
use Wikia\DependencyInjection\Injector;

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

	public function __construct() {
		parent::__construct();
		global $UPPNamespaces;
		$this->allowedNamespaces = $UPPNamespaces;
		$this->title = $this->wg->Title;
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

		if ( $this->title instanceof Title ) {
			$namespace = $this->title->getNamespace();
			$isSubpage = $this->title->isSubpage();
		} else {
			$namespace = $this->wg->NamespaceNumber;
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

		$this->setRequest( new WikiaRequest( $this->wg->Request->getValues() ) );
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

		$this->setVal( 'isBlocked', ( $user->isBlocked( true, false ) || $user->isBlockedGlobally() ) );
		$this->setVal( 'zeroStateCssClass', ( $userData[ 'showZeroStates' ] ) ? 'zero-state' : '' );

		$this->setVal( 'user', $userData );
		$this->setVal( 'deleteAvatarLink', SpecialPage::getTitleFor( 'RemoveUserAvatar' )->getFullURL( 'av_user=' . $userData[ 'name' ] ) );
		$this->setVal( 'canRemoveAvatar', $sessionUser->isAllowed( 'removeavatar' ) );
		$this->setVal( 'isUserPageOwner', $isUserPageOwner );

		$canEditProfile = $isUserPageOwner || $sessionUser->isAllowed( 'editprofilev3' );
		// if user is blocked locally (can't edit anything) he can't edit masthead too
		$canEditProfile = $sessionUser->isAllowed( 'edit' ) ? $canEditProfile : false;
		// if user is blocked globally he can't edit
		$blockId = $sessionUser->getBlockId();
		$canEditProfile = empty( $blockId ) ? $canEditProfile : false;
		$this->setVal( 'canEditProfile', $canEditProfile );
		$this->setVal( 'isWikiStaff', $sessionUser->isAllowed( 'staff' ) );
		$this->setVal( 'canEditProfile', ( $isUserPageOwner || $sessionUser->isAllowed( 'staff' ) || $sessionUser->isAllowed( 'editprofilev3' ) ) );

		$this->fetchDiscussionPostsNumberFrom($user);

		if ( !empty( $this->title ) ) {
			$this->setVal( 'reloadUrl', htmlentities( $this->title->getFullURL(), ENT_COMPAT, 'UTF-8' ) );
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

		$this->setRequest( new WikiaRequest( $this->wg->Request->getValues() ) );
		$user = UserProfilePageHelper::getUserFromTitle();

		/**
		 * @var $sessionUser User
		 */
		$sessionUser = $this->wg->User;
		$canRename = $sessionUser->isAllowed( 'renameprofilev3' );
		$canProtect = $sessionUser->isAllowed( 'protect' );
		$canDelete = $sessionUser->isAllowed( 'deleteprofilev3' );
		$isUserPageOwner = ( $user instanceof User && !$user->isAnon() && $user->getId() == $sessionUser->getId() ) ? true : false;

		$editQuery = [ 'action' => 'edit' ];

		// check if this is an older version of the page
		$oldid = $this->wg->Request->getInt( 'oldid', 0 );
		if ( $oldid ) {
			$editQuery[ 'oldid' ] = $oldid;
		}

		$actionButtonArray = [ ];
		$canSessionUserEdit = $this->title->userCan( 'edit', $sessionUser );
		if ( $namespace == NS_USER ) {
			// profile page
			$actionButtonArray = [
				'action' => [
					'href'      => $this->title->getLocalURL( $editQuery ),
					'text'      => $canSessionUserEdit ? wfMessage( 'user-action-menu-edit-profile' )->escaped() : wfMessage( 'viewsource' )->escaped(),
					'id'        => 'ca-edit',
					'accesskey' => $canSessionUserEdit ? wfMessage( 'accesskey-ca-edit' )->escaped() : wfMessage( 'accesskey-ca-viewsource' )->escaped(),
				],
				'image'  => $canSessionUserEdit ? MenuButtonController::EDIT_ICON : MenuButtonController::LOCK_ICON,
				'name'   => 'editprofile',
			];
		} else {
			if ( $namespace == NS_USER_TALK && empty( $this->wg->EnableWallExt ) ) {
				// talk page
				/**
				 * @var $title Title
				 */
				$title = Title::newFromText( $user->getName(), NS_USER_TALK );

				if ( $title instanceof Title ) {
					// sometimes title isn't created, I've tried to reproduce it on my devbox and I couldn't
					// checking if $title is instance of Title is a quick fix -- if it isn't no action button will be shown
					if ( $isUserPageOwner || $this->wg->Request->getVal( 'oldid' ) ) {
						$actionButtonArray = [
							'action' => [
								'href'      => $this->title->getLocalURL( $editQuery ),
								'text'      => $canSessionUserEdit ? wfMessage( 'user-action-menu-edit' )->escaped() : wfMessage( 'viewsource' )->escaped(),
								'id'        => 'ca-edit',
								'accesskey' => $canSessionUserEdit ? wfMessage( 'accesskey-ca-edit' )->escaped() : wfMessage( 'accesskey-ca-viewsource' )->escaped(),
							],
							'image'  => $canSessionUserEdit ? MenuButtonController::EDIT_ICON : MenuButtonController::LOCK_ICON,
							'name'   => 'editprofile',
						];
					} else {
						$actionButtonArray = [
							'action'   => [
								'href'      => $title->getLocalURL( array_merge( $editQuery, [ 'section' => 'new' ] ) ),
								'text'      => $canSessionUserEdit ? wfMessage( 'user-action-menu-leave-message' )->escaped() : wfMessage( 'viewsource' )->escaped(),
								'id'        => 'ca-addsection',
								'accesskey' => $canSessionUserEdit ? wfMessage( 'accesskey-ca-addsection' )->escaped() : wfMessage( 'accesskey-ca-viewsource' )->escaped(),
							],
							'image'    => $canSessionUserEdit ? MenuButtonController::MESSAGE_ICON :MenuButtonController::LOCK_ICON,
							'name'     => 'leavemessage',
							'dropdown' => [
								'edit' => [
									'href'      => $this->title->getFullURL( $editQuery ),
									'text'      => wfMessage( 'user-action-menu-edit' )->escaped(),
									'id'        => 'ca-edit',
									'accesskey' => wfMessage( 'accesskey-ca-edit' )->escaped(),
								],
							],
						];
					}
				}
			} else {
				if ( defined( 'NS_BLOG_ARTICLE' ) && $namespace == NS_BLOG_ARTICLE && $isUserPageOwner ) {
					// blog page

					$actionButtonArray = [
						'action' => [
							'href' => SpecialPage::getTitleFor( 'CreateBlogPage' )->getLocalURL( !empty( $this->wg->CreateBlogPagePreload ) ? 'preload=$wgCreateBlogPagePreload' : '' ),
							'text' => wfMessage( 'blog-create-post-label' )->escaped(),
						],
						'image'  => MenuButtonController::BLOG_ICON,
						'name'   => 'createblogpost',
					];
				}
			}
		}

		if ( in_array( $namespace, [ NS_USER, NS_USER_TALK ] ) ) {
			// profile & talk page
			if ( $canRename ) {
				/**
				 * @var $specialMovePage Title
				 */
				$specialMovePage = SpecialPage::getTitleFor( 'MovePage' );
				$renameUrl = $specialMovePage->getLocalURL() . '/' . $this->title->__toString();
				$actionButtonArray[ 'dropdown' ][ 'rename' ] = [
					'href'      => $renameUrl,
					'text'      => wfMessage( 'user-action-menu-rename' )->escaped(),
					'id'        => 'ca-move',
					'accesskey' => wfMessage( 'accesskey-ca-move' )->escaped(),
				];
			}

			if ( $canProtect ) {
				$protectStatus = $this->title->isProtected() ? 'unprotect' : 'protect';

				$actionButtonArray[ 'dropdown' ][ 'protect' ] = [
					'href'      => $this->title->getLocalURL( [ 'action' => $protectStatus ] ),
					'text'      => wfMessage( 'user-action-menu-' . $protectStatus )->escaped(),
					'id'        => 'ca-protect',
					'accesskey' => wfMessage( 'accesskey-ca-protect' )->escaped(),
				];
			}

			if ( $canDelete ) {
				$actionButtonArray[ 'dropdown' ][ 'delete' ] = [
					'href'      => $this->title->getLocalURL( [ 'action' => 'delete' ] ),
					'text'      => wfMessage( 'user-action-menu-delete' )->escaped(),
					'id'        => 'ca-delete',
					'accesskey' => wfMessage( 'accesskey-ca-delete' )->escaped(),
				];
			}

			$actionButtonArray[ 'dropdown' ][ 'history' ] = [
				'href'      => $this->title->getLocalURL( [ 'action' => 'history' ] ),
				'text'      => wfMessage( 'user-action-menu-history' )->escaped(),
				'id'        => 'ca-history',
				'accesskey' => wfMessage( 'accesskey-ca-history' )->escaped(),
			];
		}

		wfRunHooks( 'UserProfilePageAfterGetActionButtonData', [ &$actionButtonArray, $namespace, $canRename, $canProtect, $canDelete, $isUserPageOwner ] );

		$actionButton = F::app()->renderView( 'MenuButton', 'Index', $actionButtonArray );
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

			$this->setVal( 'body', ( string )$this->sendSelfRequest( 'renderLightbox', [ 'tab' => $selectedTab, 'userId' => $userId ] ) );

			if ( !empty( $this->wg->AvatarsMaintenance ) ) {
				$this->setVal( 'avatarsDisabled', true );
				$this->setVal( 'avatarsDisabledMsg', wfMessage( 'user-identity-avatars-maintenance' )->text() );
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
			[ 'id' => 'avatar', 'name' => wfMessage( 'user-identity-box-avatar' )->escaped() ],
			[ 'id' => 'about', 'name' => wfMessage( 'user-identity-box-about-me' )->escaped() ],
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
			} else {
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

		try {
			$this->checkWriteRequest();
		} catch ( \BadRequestException $bre ) {
			$this->setTokenMismatchError();
			wfProfileOut( __METHOD__ );
			return;
		}

		$user = User::newFromId( $this->getVal( 'userId' ) );
		$isAllowed = ( $this->wg->User->isAllowed( 'editprofilev3' ) || intval( $user->getId() ) === intval( $this->wg->User->getId() ) );

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
			return;
		}

		if ( !empty( $userData->avatarData ) ) {
			$status = $this->saveUsersAvatar( $user->getId(), $userData->avatarData );
			if ( $status !== true ) {
				$this->setVal( 'errorMsg', $errorMsg );
				$this->setVal( 'status', 'error' );
				wfProfileOut( __METHOD__ );
				return;
			}
		}

		wfProfileOut( __METHOD__ );
		return;
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
	private function saveUsersAvatar( $userId = null, $data = null ) {
		wfProfileIn( __METHOD__ );

		if ( is_null( $userId ) ) {
			$user = User::newFromId( $this->getVal( 'userId' ) );
		} else {
			$user = User::newFromId( $userId );
		}

		$isAllowed = (
			$this->app->wg->User->isAllowed( 'editprofilev3' ) ||
			$user->getId() == $this->wg->User->getId()
		);

		if ( is_null( $data ) ) {
			$data = json_decode( $this->getVal( 'data' ) );
		}

		$success = true;

		if ( $isAllowed && isset( $data->source ) && isset( $data->file ) ) {
			switch ( $data->source ) {
				case 'sample':
					// remove old avatar file
					Masthead::newFromUser( $user )->removeFile( false );

					// store the full URL of the predefined avatar and skip an upload via service (PLATFORM-1494)
					$user->setGlobalAttribute( AVATAR_USER_OPTION_NAME, Masthead::getDefaultAvatarUrl( $data->file ) );
					$user->saveSettings();
					break;
				case 'uploaded':
					$url = $this->saveAvatarFromUrl( $user, $data->file );
					if ( $url === '' ) {
						$success = false;
					}
					break;
				default:
					break;
			}

			$this->clearAttributeCache( $userId );
		}

		wfProfileOut( __METHOD__ );
		return $success;
	}

	private function clearAttributeCache( $userId ) {
		/** @var UserAttributes $attributeService */
		$attributeService = Injector::getInjector()->get( UserAttributes::class );
		$attributeService->clearCache( $userId );
	}

	/**
	 * @brief Gets avatar from url, saves it on server and resize it if needed then returns path
	 *
	 * @param User $user user object
	 * @param string $url url to user's avatar
	 * @param string $errorMsg reference to a string variable where errors messages are returned
	 *
	 * @return string
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function saveAvatarFromUrl( User $user, $url ) {
		wfProfileIn( __METHOD__ );

		$userId = $user->getId();

		$errorNo = $this->uploadByUrl(
			$url,
			[
				'userId'    => $userId,
				'username'  => $user->getName(),
				'user'      => $user,
				'localPath' => '',
			]
		);

		$localPath = $this->getLocalPath( $user );
		$res = '';
		if ( $errorNo == UPLOAD_ERR_OK ) {
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
			$uploadError = $this->wg->Request->getUploadError( $avatarUploadFiled );

			if ( $uploadError != 0 ) {
				$thumbnail = $uploadError;
			} else {
				$fileName = $this->wg->Request->getFileTempname( $avatarUploadFiled );
				$fileuploader = new WikiaTempFilesUpload();
				$thumbnail = $this->storeInTempImage( $fileName, $fileuploader );
			}

			if ( false === $thumbnail || is_int( $thumbnail ) ) {
				$result = [ 'success' => false, 'error' => $this->validateUpload( $thumbnail ) ];
				$this->setVal( 'result', $result );
				return;
			}

			$this->setVal( 'result', $result );

			$avatarUrl = $thumbnail->url;
			// look for an occurrence of a ? to know if we should append the query string with a ? or a &
			$avatarUrl .= ( preg_match( '/\?/', $avatarUrl ) ? '&' : '?' ) . 'cb=' . date( 'U' );

			$result = [ 'success' => true, 'avatar' => $avatarUrl ];
			$this->setVal( 'result', $result );

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

		if ( $status->ok ) {
			$width = min( self::AVATAR_DEFAULT_SIZE, $file->width );
			$height = min( self::AVATAR_DEFAULT_SIZE, $file->height );

			$thumbnail = $file->transform( [
				'height' => $height,
				'width'  => $width,
			] );
		} else {
			$errors = $status->getErrorsArray();
			$errMsg = 'Unable to upload temp file fo avatar. Error(s): ';
			foreach ( $errors as $error ) {
				$errMsg .= $error[ 0 ] . ', ';
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
	 * @param WebRequest $request WebRequest instance
	 * @param array $userData user data array; contains: user id (key: userId), full page url (fullPageUrl), user name (username)
	 * @param String $input name of file input in form
	 * @param String $errorMsg optional string containing details on what went wrong if there is an UPLOAD_ERR_EXTENSION
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

		$errorMsg = '';

		if ( class_exists( 'Masthead' ) ) {
			/**
			 * @var $oAvatarObj Masthead
			 */
			$oAvatarObj = Masthead::newFromUser( $userData[ 'user' ] );
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
	 * @param String $url the full URL of an image to download and apply as the user's Avatar
	 * @param array $userData user data array; contains: user id (key: userId), full page url (fullPageUrl), user name (username)
	 * @param String $errorMsg optional string containing details on what went wrong if there is an UPLOAD_ERR_EXTENSION
	 *
	 * @return Integer error code of operation
	 */
	public function uploadByUrl( $url, $userData ) {
		try {
			$this->checkWriteRequest();
		} catch ( \BadRequestException $bre ) {
			$this->setTokenMismatchError();
			return UPLOAD_ERR_CANT_WRITE;
		}

		// start by presuming there is no error
		// $errorNo = UPLOAD_ERR_OK;
		$user = $userData[ 'user' ];
		if ( class_exists( 'Masthead' ) ) {
			/**
			 * @var $oAvatarObj Masthead
			 */
			$oAvatarObj = Masthead::newFromUser( $user );
			$localPath = $this->getLocalPath( $user );
			$errorNo = $oAvatarObj->uploadByUrl( $url );
		} else {
			$errorNo = UPLOAD_ERR_EXTENSION;
		}

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

		$this->setVal( 'avatarName', $user->getGlobalAttribute( AVATAR_USER_OPTION_NAME ) );
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

		$this->defaultAvatars = [ ];
		$images = getMessageForContentAsArray( 'blog-avatar-defaults' );

		if ( is_array( $images ) ) {
			foreach ( $images as $image ) {
				$hash = FileRepo::getHashPathForLevel( $image, 2 );
				$this->defaultAvatars[] = [ 'name' => $image, 'url' => $this->defaultAvatarPath . $thumb . $hash . $image ];
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

		if ( !empty( $userData[ 'fbPage' ] ) ) {
			$userData[ 'fbPage' ] = str_replace( self::FBPAGE_BASE_URL, '', $userData[ 'fbPage' ] );
		}

		$this->setVal( 'user', $userData );

		$this->setVal( 'charLimits', [
			'name'       => UserIdentityBox::USER_NAME_CHAR_LIMIT,
			'location'   => UserIdentityBox::USER_LOCATION_CHAR_LIMIT,
			'occupation' => UserIdentityBox::USER_OCCUPATION_CHAR_LIMIT,
			'gender'     => UserIdentityBox::USER_GENDER_CHAR_LIMIT,
		] );

		if ( !empty( $userData[ 'birthday' ][ 'month' ] ) ) {
			$this->setVal( 'days', cal_days_in_month( CAL_GREGORIAN, $userData[ 'birthday' ][ 'month' ], 2000 /* leap year */ ) );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Gets wikiId from request and hides from faviorites wikis
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onHideWiki() {
		$result = [ 'success' => false ];
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

			$result = [ 'success' => $success, 'wikis' => $userIdentityBox->getTopWikis() ];
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
		$result = [ 'success' => true, 'wikis' => $userIdentityBox->getTopWikis( true ) ];

		$this->setVal( 'result', $result );
	}

	public function getClosingModal() {
		wfProfileIn( __METHOD__ );

		$userId = $this->getVal( 'userId' );
		$user = $this->wg->User;

		if ( !$user->isAnon() ) {
			$this->setVal( 'body', ( string )$this->sendSelfRequest( 'renderClosingModal', [ 'userId' => $userId ] ) );
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

	public function fetchDiscussionPostsNumberFrom( $user ) {
		global $wgEnableDiscussionPostsCountInUserIdentityBox;

		$this->setVal( 'discussionPostsCountInUserIdentityBoxEnabled', $wgEnableDiscussionPostsCountInUserIdentityBox );
		if ( $wgEnableDiscussionPostsCountInUserIdentityBox ) {
			$discussionInfo = UserIdentityBoxDiscussionInfo::createFor( $user );

			$this->setVal( 'discussionActive', $discussionInfo->isDiscussionActive() );
			$this->setVal( 'discussionPostsCount', $discussionInfo->getDiscussionPostsCount() );
			$this->setVal( 'discussionAllPostsByUserLink',
				$discussionInfo->getDiscussionAllPostsByUserLink() );
		}
	}

	/**
	 * @throws BadRequestException
	 * @return bool
	 */
	public function removeavatar() {
		wfProfileIn( __METHOD__ );
		$this->checkWriteRequest();

		$this->setVal( 'status', false );

		// macbre: avatars operations are disabled during maintenance
		global $wgAvatarsMaintenance;
		if ( !empty( $wgAvatarsMaintenance ) ) {
			$this->setVal( 'error', wfMessage( 'user-identity-avatars-maintenance' )->escaped() );
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( !$this->wg->User->isAllowed( 'removeavatar' ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( $this->request->getVal( 'avUser' ) ) {
			$avUser = User::newFromName( $this->request->getVal( 'avUser' ) );
			if ( $avUser->getId() !== 0 ) {
				$avatar = Masthead::newFromUser( $avUser );
				if ( $avatar->removeFile( true ) ) {
					$this->clearAttributeCache( $avUser->getId() );
					$this->setVal( 'status', 'ok' );
					wfProfileOut( __METHOD__ );
					return true;
				}
			}
		}

		$this->setVal( 'error', wfMessage( 'user-identity-remove-fail' )->escaped() );

		wfProfileOut( __METHOD__ );
		return true;
	}
}

