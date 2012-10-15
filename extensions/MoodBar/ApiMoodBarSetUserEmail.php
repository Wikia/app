<?php


class ApiMoodBarSetUserEmail extends ApiBase {

	public function execute() {
		global $wgUser, $wgAuth, $wgEnableEmail, $wgEmailAuthentication;

		if ( $wgUser->isAnon() ) {
			$this->dieUsage( "You don't have permission to do that", 'permission-denied' );
		}

		$params = $this->extractRequestParams();

		$error = false;

		switch ( $params['mbaction']) {

			case 'setemail':
				if ( !$wgAuth->allowPropChange( 'emailaddress' ) ) {
					$error =  wfMsgExt( 'cannotchangeemail', 'parseinline' );
				} else {
					//only set email if user does not have email on profile yet
					if ( !$wgUser->getEmail() ) {

						if ( !isset( $params['email'] ) || !Sanitizer::validateEmail( $params['email'] ) ) {
							$error = wfMsgExt( 'invalidemailaddress', 'parseinline' ) ;
						}
						else {
							list( $status, $info ) = self::trySetUserEmail( $wgUser, $params['email'] );

							// Status Object
							if ( $status !== true ) {
								$error =  $status->getWikiText( $info );
							} else {
								$wgUser->saveSettings();
							}
						}

					}
				}
				break;

			case 'resendverification':
				//only sends the email if the email has not been verified
				if ( $wgEnableEmail && $wgEmailAuthentication && $wgUser->getEmail() && !$wgUser->isEmailConfirmed() ) {
					$status = $wgUser->sendConfirmationMail( 'set' );
					if ( !$status->isGood() ) {
						$error =  $status->getWikiText( 'mailerror' );
					}
				}
				break;

			default:
				throw new MWApiMoodBarSetUserEmailInvalidActionException( "Action {$params['mbaction']} not implemented" );
		}

		if ( $error === false ) {
			$result = array( 'result' => 'success' );
		} else {
			$result = array( 'result' => 'error', 'error' => $error );
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	/**
	 * Temporary solution, will use Preference::trySetUserEmail in 1.19
	 */
	private static function trySetUserEmail( User $user, $newaddr ) {
		global $wgEnableEmail, $wgEmailAuthentication;
		$info = ''; // none

		if ( $wgEnableEmail ) {
			$oldaddr = $user->getEmail();
			if ( ( $newaddr != '' ) && ( $newaddr != $oldaddr ) ) {
				$user->setEmail( $newaddr );
				if ( $wgEmailAuthentication ) {
					$type = $oldaddr != '' ? 'changed' : 'set';
					$result = $user->sendConfirmationMail( $type );
					if ( !$result->isGood() ) {
						return array( $result, 'mailerror' );
					}
					$info = 'eauth';
				}
			} elseif ( $newaddr != $oldaddr ) { // if the address is the same, don't change it
				$user->setEmail( $newaddr );
			}
		}

		return array( true, $info );
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getAllowedParams() {
		return array(
			'mbaction' => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => array(
					'setemail',
					'resendverification',
				),
			),

			'email' => array(
				ApiBase::PARAM_TYPE => 'string'
			),

			'token' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
		);
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiMoodBarSetUserEmail.php 103224 2011-11-15 21:24:44Z bsitu $';
	}

	public function getParamDescription() {
		return array(
			'mbaction' => 'The action to take',
			'email' => 'the email which a user sets or resends verification to'
		);
	}

	public function getDescription() {
		return 'Sets the profile email for a user or resends the verification email to a user';
	}
}

class MWApiMoodBarSetUserEmailInvalidActionException extends MWException {};
