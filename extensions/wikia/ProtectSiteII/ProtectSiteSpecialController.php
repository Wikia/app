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

		$inputs = [];

		foreach ( ProtectSiteModel::getValidActions() as $action ) {
			// For grepping - possible message keys used here:
			// protectsite-label-prevent-edit
			// protectsite-label-prevent-create
			// protectsite-label-prevent-move
			// protectsite-label-prevent-upload
			$inputs[] = [
				'type' => 'checkbox',
				'label' => $this->msg( "protectsite-label-prevent-$action" )->escaped(),
				'name' => $action,
				'checked' => ProtectSiteModel::isActionFlagSet( $active, $action ) ?: null,
			];
		}

		$inputs[] = [
			'type' => 'text',
			'label' => $this->msg( 'protectsite-label-expiry' )->escaped(),
			'name' => 'expiry',
			'value' => '1 hour',
		];

		$inputs[] = [
			'type' => 'checkbox',
			'label' => $this->msg( "protectsite-label-suppress-expiry" )->escaped(),
			'name' => 'suppress_expiry',
		];

		$inputs[] = [
			'type' => 'text',
			'label' => $this->msg( 'protectsite-label-reason' )->escaped(),
			'name' => 'reason',
		];

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

		$user = $this->getContext()->getUser();

		if ( !$user->isAllowed( 'protectsite' ) ) {
			throw new PermissionsError( 'protectsite' );
		}

		if ( $user->isBlocked() ){
			throw new ForbiddenException();
		}

		$protection = 0;

		foreach ( ProtectSiteModel::getValidActions() as $action ) {
			if ( $this->request->getCheck( $action ) ) {
				$protection |= ProtectSiteModel::PROTECT_ACTIONS[$action];
			}
		}

		$reason = $this->request->getVal( 'reason', '' );

		$model = new ProtectSiteModel();
		$title = Title::makeTitle( NS_SPECIAL, 'Allpages' );
		$log = new LogPage( 'protect' );

		if ( $protection ) {
			$expiry = $this->request->getVal( 'expiry' );
			$expiresAt = strtotime( "+$expiry" );

			$model->updateProtectionSettings( $protection, $expiresAt );
			$log->addEntry( 'protect', $title, $this->getReason( $expiry, $reason ), [], $user);
		} else {
			$model->unprotect();
			$log->addEntry( 'unprotect', $title, $reason, [], $user );
		}

		$target = SpecialPage::getTitleFor( 'ProtectSite' );

		$this->response->setCode( 303 );
		$this->response->setHeader( 'Location', $target->getFullURL() );
	}

	private function getReason( string $expiry, string $reason ): string {
		if ( !empty( $reason ) ) {
			return "$expiry: $reason";
		}

		return $expiry;
	}
}
