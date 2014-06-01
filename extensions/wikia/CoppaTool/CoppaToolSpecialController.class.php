<?php
/**
 * COPPA Tool special page
 * @author grunny
 */

class CoppaToolSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'CoppaTool', 'coppatool' );
	}

	public function index() {
		wfProfileIn( __METHOD__ );
		if ( !$this->getUser()->isAllowed( 'coppatool' ) ) {
			wfProfileOut( __METHOD__ );
			$this->displayRestrictionError();
			return false;
		}

		$this->specialPage->setHeaders();

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->userName = trim( $this->getVal( 'username', $this->getPar() ) );
		$this->isIP = false;
		$this->validUser = false;

		if ( IP::isIPAddress( $this->userName ) ) {
			$this->userName = IP::sanitizeIP( $this->userName );
			$this->isIP = true;
			$this->validUser = true;
		} else {
			$userObj = User::newFromName( $this->userName );
			if ( !$userObj || $userObj->getId() === 0 ) {
				$this->validUser = false;
			} else {
				$this->userName = $userObj->getName();
				$this->validUser = true;
			}
		}

		$this->userForm = $this->app->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => [
			'isInvalid' => $this->validUser || $this->userName === '' ? false : true,
			'errorMsg' => $this->validUser || $this->userName === '' ?  '' : $this->msg( 'coppatool-nosuchuser', $this->userName )->escaped(),
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'username',
					'isRequired' => true,
					'label' => $this->msg( 'coppatool-label-username' )->escaped(),
					'value' => $this->userName,
				],
				[
					'type' => 'submit',
					'value' => $this->msg( 'coppatool-submit' )->escaped(),
				]
			],
			'method' => 'GET',
			'action' => $this->getTitle()->getLocalUrl(),
		] ] );

		if ( $this->validUser ) {
			$this->getOutput()->addModules( 'ext.coppaTool' );
			$this->buttons = [];
			$this->blankImgUrl = wfBlankImgUrl();
			$this->formHeading = $this->msg( 'coppatool-form-header' )->escaped();
			if ( !$this->isIP ) {
				$this->buttons[] = [
					'buttonAction' => 'disable-account',
					'buttonLink' => Html::element(
						'a',
						[ 'href' => '#' ],
						$this->msg( 'coppatool-disable' )->escaped()
					),
					'done' => $userObj->getOption( 'disabled', false ),
				];
				$this->buttons[] = [
					'buttonAction' => 'blank-profile',
					'buttonLink' => Html::element(
						'a',
						[ 'href' => '#' ],
						$this->msg( 'coppatool-blank-user-profile' )->escaped()
					),
				];
				$this->buttons[] = [
					'buttonAction' => 'delete-userpages',
					'buttonLink' => Html::element(
						'a',
						[ 'href' => '#' ],
						$this->msg( 'coppatool-delete-user-pages' )->escaped()
					),
				];
			} else {
				$this->buttons[] = [
					'buttonAction' => 'phalanx-ip',
					'buttonLink' => Linker::link(
						Title::newFromText( 'Phalanx', NS_SPECIAL ),
						$this->msg( 'coppatool-phalanx-ip' )->escaped(),
						[ 'target' => '_blank' ],
						[
							'type' => Phalanx::TYPE_USER,
							'wpPhalanxCheckBlocker' => $this->userName,
							'target' => $this->userName,
						],
						[ 'known', 'noclasses' ]
					),
				];
				$this->buttons[] = [
					'buttonAction' => 'rename-ip',
					'buttonLink' => Html::element(
						'a',
						[ 'href' => '#' ],
						$this->msg( 'coppatool-rename-ip' )->escaped()
					),
				];
			}
		}

		wfProfileOut( __METHOD__ );
	}

}
