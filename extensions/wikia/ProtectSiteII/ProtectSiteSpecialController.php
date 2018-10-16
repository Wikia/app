<?php

class ProtectSiteSpecialController extends WikiaSpecialPageController {

	/** @var ProtectSiteModel $model */
	private $model;

	public function __construct() {
		parent::__construct( 'ProtectSite', 'protectsite' );
		$this->model = new ProtectSiteModel();
	}

	public function index() {

		$this->setHeaders();
		$this->checkPermissions();
		$this->checkIfUserIsBlocked();

		$active = $this->model->getProtectionSettings();

		$inputs = [
			[
				'type' => 'checkbox',
				'label' => $this->msg( 'protectsite-label-prevent-users' )->escaped(),
				'attributes' => [
					'name' => 'prevent_users',
					'checked' => ProtectSiteModel::isPreventUsersFlagSet( $active ) ?: null
				],
			]
		];

		foreach ( ProtectSiteModel::PROTECT_ACTIONS as $action ) {
			// For grepping - possible message keys used here:
			// protectsite-label-prevent-edit
			// protectsite-label-prevent-create
			// protectsite-label-prevent-move
			// protectsite-label-prevent-upload
			$inputs[] = [
				'type' => 'checkbox',
				'label' => $this->msg( "protectsite-label-prevent-$action" )->escaped(),
				'attributes' => [
					'name' => $action,
					'checked' => ProtectSiteModel::isActionFlagSet( $active, $action ) ?: null,
				],
			];
		}

		$inputs[] = [
			'type' => 'hidden',
			'name' => 'token',
			'value' => $this->getUser()->getEditToken(),
		];

		$form = [
			'method' => 'POST',
			'action' => self::getFullUrl( 'saveProtectionSettings' ),
			'legend' => $this->msg( 'protectsite-legend' )->escaped(),
			'inputs' => $inputs,
			'submits' => [
				'attributes' => [
					'value' => $this->msg( 'protectsite-save' )->escaped(),
				],
			],
		];

		$htmlForm = $this->app->renderView( WikiaStyleGuideFormController::class, 'index', [
			'form' => $form
		] );

		$this->response->setBody( $htmlForm );
	}

	public function saveProtectionSettings() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$this->checkWriteRequest();

		$protection = 0;

		foreach ( array_keys( ProtectSiteModel::PROTECT_ACTIONS ) as $action ) {
			if ( $this->request->getCheck( $action ) ) {
				$protection |= ProtectSiteModel::PROTECT_ACTIONS[$action];
			}
		}

		if ( $this->request->getCheck( 'prevent_users' ) ) {
			$protection |= ProtectSiteModel::PREVENT_USERS_FLAG;
		}

		$model = new ProtectSiteModel();
		$title = Title::makeTitle( NS_SPECIAL, 'Allpages' );
		$log = new LogPage( 'protect' );

		if ( $protection ^ ProtectSiteModel::PREVENT_USERS_FLAG ) {
			$expiry = $this->request->getVal( 'expiry' );
			$expiresAt = strtotime( "+$expiry" );

			$model->updateProtectionSettings( $protection, $expiresAt );
			$log->addEntry( 'protect', $title, $expiry, [], $this->getContext()->getUser() );
		} else {
			$model->unprotect();
			$log->addEntry( 'unprotect', $title, '', [], $this->getContext()->getUser() );
		}
	}
}
