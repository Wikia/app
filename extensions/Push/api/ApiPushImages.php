<?php

/**
 * API module to push images to other MediaWiki wikis.
 *
 * @since 0.5
 *
 * @file ApiPushImages.php
 * @ingroup Push
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiPushImages extends ApiBase {

	/**
	 * Associative array containing CookieJar objects (values) to be passed in
	 * order to authenticate to the targets (keys).
	 *
	 * @since 0.5
	 *
	 * @var array
	 */
	protected $cookieJars = array();

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'push' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}

		global $egPushLoginUser, $egPushLoginPass, $egPushLoginUsers, $egPushLoginPasswords;

		$params = $this->extractRequestParams();

		if ( !isset( $params['images'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'images' ) );
		}

		if ( !isset( $params['targets'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'targets' ) );
		}

		PushFunctions::flipKeys( $egPushLoginUsers, 'users' );
		PushFunctions::flipKeys( $egPushLoginPasswords, 'passwds' );

		foreach ( $params['targets'] as &$target ) {
			$user = false;
			$pass = false;

			if ( array_key_exists( $target, $egPushLoginUsers ) && array_key_exists( $target, $egPushLoginPasswords ) ) {
				$user = $egPushLoginUsers[$target];
				$pass = $egPushLoginPasswords[$target];
			}
			elseif ( $egPushLoginUser != '' && $egPushLoginPass != '' ) {
				$user = $egPushLoginUser;
				$pass = $egPushLoginPass;
			}

			if ( substr( $target, -1 ) !== '/' ) {
				$target .= '/';
			}

			$target .= 'api.php';

			if ( $user !== false ) {
				$this->doLogin( $user, $pass, $target );
			}
		}

		foreach ( $params['images'] as $image ) {
			$title = Title::newFromText( $image, NS_FILE );
			if ( !is_null( $title ) && $title->getNamespace() == NS_FILE && $title->exists() ) {
				$this->doPush( $title, $params['targets'] );
			}
		}
	}

	/**
	 * Logs in into a target wiki using the provided username and password.
	 *
	 * @since 0.5
	 *
	 * @param string $user
	 * @param string $password
	 * @param string $target
	 * @param string $token
	 * @param CookieJar $cookie
	 * @param integer $attemtNr
	 */
	protected function doLogin( $user, $password, $target, $token = null, $cookieJar = null, $attemtNr = 0 ) {
		$requestData = array(
			'action' => 'login',
			'format' => 'json',
			'lgname' => $user,
			'lgpassword' => $password
		);

		if ( !is_null( $token ) ) {
			$requestData['lgtoken'] = $token;
		}

		$req = PushFunctions::getHttpRequest( $target,
			array(
				'postData' => $requestData,
				'method' => 'POST',
				'timeout' => 'default'
			)
		);

		if ( !is_null( $cookieJar ) ) {
			$req->setCookieJar( $cookieJar );
		}

		$status = $req->execute();

		$attemtNr++;

		if ( $status->isOK() ) {
			$response = FormatJson::decode( $req->getContent() );

			if ( property_exists( $response, 'login' )
				&& property_exists( $response->login, 'result' ) ) {

				if ( $response->login->result == 'NeedToken' && $attemtNr < 3 ) {
					$this->doLogin( $user, $password, $target, $response->login->token, $req->getCookieJar(), $attemtNr );
				}
				elseif ( $response->login->result == 'Success' ) {
					$this->cookieJars[$target] = $req->getCookieJar();
				}
				else {
					$this->dieUsage( wfMsgExt( 'push-err-authentication', 'parsemag', $target, '' ), 'authentication-failed' );
				}
			}
			else {
				$this->dieUsage( wfMsgExt( 'push-err-authentication', 'parsemag', $target, '' ), 'authentication-failed' );
			}
		}
		else {
			$this->dieUsage( wfMsgExt( 'push-err-authentication', 'parsemag', $target, '' ), 'authentication-failed' );
		}
	}

	/**
	 * Pushes the page content to the target wikis.
	 *
	 * @since 0.5
	 *
	 * @param Title $title
	 * @param array $targets
	 */
	protected function doPush( Title $title, array $targets ) {
		foreach ( $targets as $target ) {
			$token = $this->getEditToken( $title, $target );

			if ( $token !== false ) {
				$doPush = true;

				wfRunHooks( 'PushAPIBeforeImagePush', array( &$title, &$target, &$token, &$doPush ) );

				if ( $doPush ) {
					$this->pushToTarget( $title, $target, $token );
				}
			}
		}
	}

	/**
	 * Obtains the needed edit token by making an HTTP GET request
	 * to the remote wikis API.
	 *
	 * @since 0.5
	 *
	 * @param Title $title
	 * @param string $target
	 *
	 * @return string or false
	 */
	protected function getEditToken( Title $title, $target ) {
		$requestData = array(
			'action' => 'query',
			'format' => 'json',
			'intoken' => 'edit',
			'prop' => 'info',
			'titles' => $title->getFullText(),
		);

		$parts = array();

		foreach ( $requestData as $key => $value ) {
			$parts[] = $key . '=' . urlencode( $value );
		}

		$req = PushFunctions::getHttpRequest( $target . '?' . implode( '&', $parts ),
			array(
				'method' => 'GET',
				'timeout' => 'default'
			)
		);

		if ( array_key_exists( $target, $this->cookieJars ) ) {
			$req->setCookieJar( $this->cookieJars[$target] );
		}

		$status = $req->execute();

		$response = $status->isOK() ? FormatJson::decode( $req->getContent() ) : null;

		$token = false;

		if ( !is_null( $response )
			&& property_exists( $response, 'query' )
			&& property_exists( $response->query, 'pages' )
			&& count( $response->query->pages ) > 0 ) {

			foreach ( $response->query->pages as $key => $value ) {
				$first = $key;
				break;
			}

			if ( property_exists( $response->query->pages->$first, 'edittoken' ) ) {
				$token = $response->query->pages->$first->edittoken;
			}
			elseif ( !is_null( $response ) && property_exists( $response, 'query' ) && property_exists( $response->query, 'error' ) ) {
				$this->dieUsage( $response->query->error->message, 'token-request-failed' );
			}
			else {
				$this->dieUsage( wfMsg( 'push-special-err-token-failed' ), 'token-request-failed' );
			}
		}
		else {
			$this->dieUsage( wfMsg( 'push-special-err-token-failed' ), 'token-request-failed' );
		}

		return $token;
	}

	/**
	 * Pushes the image to the specified wiki.
	 *
	 * @since 0.5
	 *
	 * @param Title $title
	 * @param string $target
	 * @param string $token
	 */
	protected function pushToTarget( Title $title, $target, $token ) {
		global $egPushDirectFileUploads;

		$imagePage = new ImagePage( $title );

		$requestData = array(
			'action' => 'upload',
			'format' => 'json',
			'token' => $token,
			'filename' => $title->getText(),
			'ignorewarnings' => '1'
		);

		if ( $egPushDirectFileUploads ) {
			$requestData['file'] = '@' . $imagePage->getFile()->getPath();
		}
		else {
			$requestData['url'] = $imagePage->getDisplayedFile()->getFullUrl();
		}

		$reqArgs = array(
			'method' => 'POST',
			'timeout' => 'default',
			'postData' => $requestData
		);

		if ( $egPushDirectFileUploads ) {
			if ( !function_exists( 'curl_init' ) ) {
				$this->dieUsage( wfMsg( 'push-api-err-nocurl' ), 'image-push-nocurl' );
			}
			elseif ( !defined( 'CurlHttpRequest::SUPPORTS_FILE_POSTS' ) || !CurlHttpRequest::SUPPORTS_FILE_POSTS ) {
				$this->dieUsage( wfMsg( 'push-api-err-nofilesupport' ), 'image-push-nofilesupport' );
			}
			else {
				$req = new CurlHttpRequest( $target, $reqArgs );
			}
		}
		else {
			$req = PushFunctions::getHttpRequest( $target, $reqArgs );
		}

		if ( array_key_exists( $target, $this->cookieJars ) ) {
			$req->setCookieJar( $this->cookieJars[$target] );
		}

		$status = $req->execute();

		if ( $status->isOK() ) {
			$response = $req->getContent();
			
			$this->getResult()->addValue(
				null,
				null,
				FormatJson::decode( $response )
			);
			
			wfRunHooks( 'PushAPIAfterImagePush', array( $title, $target, $token, $response ) );
		}
		else {
			$this->dieUsage( wfMsg( 'push-special-err-push-failed' ), 'page-push-failed' );
		}
	}

	public function getAllowedParams() {
		return array(
			'images' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				//ApiBase::PARAM_REQUIRED => true,
			),
			'targets' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				//ApiBase::PARAM_REQUIRED => true,
			),
		);
	}

	public function getParamDescription() {
		return array(
			'images' => 'The names of the images to push. Delimitered by |',
			'targets' => 'The urls of the wikis to push to. Delimitered by |',
		);
	}

	public function getDescription() {
		return array(
			'Pushes the content of one ore more pages to one or more target wikis.'
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'images' ),
			array( 'missingparam', 'targets' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=pushimages&images=File:Foo.bar&targets=http://en.wikipedia.org/w',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiPushImages.php 91888 2011-07-11 17:03:52Z jeroendedauw $';
	}

}
