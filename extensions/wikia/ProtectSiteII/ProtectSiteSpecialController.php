<?php

class ProtectSiteSpecialController extends WikiaSpecialPageController {

	const MAX_EXPIRY_TIME_SECONDS = 60 * 60 * 12; // 12 hours
	const INVALID_EXPIRY = 'Invalid expiry time';

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

		$active = $this->model->getProtectionSettings( $this->wg->CityId );

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
			'type' => 'text',
			'label' => $this->msg( 'protectsite-label-reason' )->escaped(),
			'name' => 'reason',
		];

		$inputs[] = [
			'type' => 'checkbox',
			'label' => $this->msg( "protectsite-label-prevent-anons-only" )->escaped(),
			'name' => 'prevent_anons_only',
			'checked' => ProtectSiteModel::isPreventAnonsOnlyFlagSet( $active ) ?: null,
		];

		$inputs[] = [
			'type' => 'checkbox',
			'label' => $this->msg( "protectsite-label-suppress-expiry" )->escaped(),
			'name' => 'suppress_expiry',
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

		$context = $this->getContext();
		$request = $context->getRequest();
		$user = $context->getUser();

		$request->assertValidWriteRequest( $user );

		if ( !$user->isAllowed( 'protectsite' ) ) {
			throw new PermissionsError( 'protectsite' );
		}

		if ( $user->isBlocked() ){
			throw new UserBlockedError( $user->getBlock() );
		}

		$protection = 0;

		foreach ( ProtectSiteModel::getValidActions() as $action ) {
			if ( $request->getCheck( $action ) ) {
				$protection |= ProtectSiteModel::PROTECT_ACTIONS[$action];
			}
		}

		$anonsOnly = $request->getCheck( 'prevent_anons_only' );

		if ( $anonsOnly ) {
			$protection |= ProtectSiteModel::PREVENT_ANONS_ONLY;
		}

		$reason = $request->getVal( 'reason', '' );

		$model = new ProtectSiteModel();
		$title = Title::makeTitle( NS_SPECIAL, 'Allpages' );
		$log = new LogPage( 'protect' );

		$target = SpecialPage::getTitleFor( 'ProtectSite' );

		$this->response->setCode( 303 );
		$this->response->setHeader( 'Location', $target->getFullURL() );

		if ( $protection && $protection ^ ProtectSiteModel::PREVENT_ANONS_ONLY ) {
			$expiry = $request->getVal( 'expiry', '1 hour' );

			$now = time();
			$expiresAt = strtotime( "+$expiry" );

			if ( $expiresAt - $now > static::MAX_EXPIRY_TIME_SECONDS && !$user->isAllowed( 'protectsite-nolimit' ) ) {
				BannerNotificationsController::addConfirmation(
					$context->msg( 'protectsite-expiry-invalid' )->escaped(),
					BannerNotificationsController::CONFIRMATION_ERROR
				);
				return false;
			}

			if ( !$request->getCheck( 'suppress_expiry' ) ) {
				$reason = empty( $reason ) ? $expiry : "$expiry: $reason";
			}

			$model->updateProtectionSettings( $this->wg->CityId, $protection, $expiresAt );
			$log->addEntry( 'protect', $title, $reason, [ $expiry ], $user);
		} else {
			$model->unprotect( $this->wg->CityId );
			$log->addEntry( 'unprotect', $title, $reason, [], $user );
		}
	}
}
