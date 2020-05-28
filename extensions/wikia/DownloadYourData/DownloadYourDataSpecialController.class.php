<?php

namespace DownloadYourData;

use PermissionsError;
use \Wikia\Logger\WikiaLogger;

class DownloadYourDataSpecialController extends \WikiaSpecialPageController {

	const CSV_FILE_NAME = 'fandom_account_data.csv';
	const CSV_CONTENT_TYPE = 'text/csv; charset=UTF-8';

	public function __construct() {
		parent::__construct( 'DownloadYourData' );
	}


	public function index() {
		$user = $this->getUser();
		if ( !$user->isLoggedIn() ) {
			throw new PermissionsError( null, [ [ 'downloadyourdata-anon-error' ] ] );
		}

		if ( $this->request->wasPosted() && $user->matchEditToken( $this->getVal( 'token' ) ) ) {

			$model = new DownloadUserData( $user );
			$username = $this->request->getVal( 'username' );

			if ( $user->isAllowed( 'exportuserdata' ) && !empty( $username ) ) {
				$exportedUser = \User::newFromName( $username );
				if ( !$exportedUser || !$exportedUser->getId() ) {
					$this->error = $this->msg( 'downloadyourdata-user-not-found', $username )->parse();
				}
			} else {
				$exportedUser = $user;
			}

			if ( empty( $this->error ) ) {
				$output = \RequestContext::getMain()->getOutput();

				$output->getRequest()->response()->header(
					'Content-disposition: attachment;filename=' . self::CSV_FILE_NAME );
				$output->getRequest()->response()->header('Content-type: ' . self::CSV_CONTENT_TYPE );

				$output->setArticleBodyOnly( true );

				WikiaLogger::instance()->info( 'Exported user data', [
					'exporting_user' => $user->getName(),
					'exported_user' => $exportedUser->getName(),
				] );

				$output->addHTML( $model->formatAsCsv( $model->getDataForUser( $exportedUser ) ) );

				return false;
			}

		}

		$this->specialPage->setHeaders();

		$this->response->setTemplateEngine( \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->introText = $this->msg( 'downloadyourdata-intro' )->text();
		$this->showUsernameField = $user->isAllowed( 'exportuserdata' );
		$this->usernamePlaceholder = $this->msg( 'downloadyourdata-username-placeholder' )->text();
		$this->editToken = $user->getEditToken();

		$buttonParams = [
			'type' => 'button',
			'vars' => [
				'type' => 'submit',
				'classes' => [ 'wikia-button' ],
				'value' => $this->msg( 'downloadyourdata-button-text' )->escaped(),
				'data' => [],
			]
		];

		$this->submitButton = \Wikia\UI\Factory::getInstance()->init( 'button' )->render( $buttonParams );
	}

}
