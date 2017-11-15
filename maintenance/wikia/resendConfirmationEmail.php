<?php

require_once __DIR__ . '/../Maintenance.php';

class ResendConfirmationEmail extends Maintenance {
	const BATCH_SIZE = 500;

	public function __construct() {
		parent::__construct();

		$this->addOption( 'from', 'send email to user registered after this date', true, true );
		$this->addOption( 'to', 'send email to user registered before this date', true, true );
		$this->addOption( 'dry-run', 'do not actually send email' );
	}

	public function execute() {
		global $wgExternalSharedDB;

		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$from = $dbr->addQuotes( $dbr->timestamp( $this->getOption( 'from' ) ) );
		$to = $dbr->addQuotes( $dbr->timestamp( $this->getOption( 'to' ) ) );

		$usersCount = 0;
		$emailsCount = 0;

		if ( $this->hasOption( 'dry-run' ) ) {
			$this->output( "Dry-run mode, no changes will be made\n" );
		}

		$offset = 0;
		do {
			$res = $dbr->select(
				'`user`',
				'*',
				[ "user_registration > $from", "user_registration < $to" ],
				__METHOD__,
				[ 'LIMIT' => static::BATCH_SIZE, 'OFFSET' => $offset ]
			);

			foreach ( $res as $row ) {
				$user = User::newFromRow( $row );
				if ( !$user->isEmailConfirmed() ) {
					$emailsCount++;

					$userLang = $user->getGlobalPreference( 'language' );
					if ( !$this->hasOption( 'dry-run' ) ) {
						$user->sendConfirmationMail( 'created',
							Email\Controller\EmailConfirmationController::TYPE, '', true, '', $userLang );
					}
				}

				$usersCount++;
			}

			$offset += static::BATCH_SIZE;
		} while ( $res && $res->numRows() );

		$this->output( "Sent email to $emailsCount users out of $usersCount total\n" );
	}
}

$maintClass = ResendConfirmationEmail::class;
require_once RUN_MAINTENANCE_IF_MAIN;
