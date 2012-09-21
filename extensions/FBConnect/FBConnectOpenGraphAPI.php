<?php
/**
 * FBConnectAPI uses Facebook REST API which is deprecated and therefore FBConnectAPI::getUserInfo() started to return only part of data we wanted.
 * I created this class only not to "break" FBConnectAPI ;) since it's not our extension. This class simply overwrites getUserInfo() method, uses Facebook SDK3
 * and sends FQL to get needed informations.
 *
 * @author Andrzej 'nAndy' Łukaszewski
 */
class FBConnectOpenGraphAPI extends FBConnectAPI {
	/**
	 * @param int $user facebook user id
	 * @param Array | null $fields
	 * @return Array | null
	 */
	public function getUserInfo($user = 0, $fields = null) {
		if ($user == 0) {
			$user = $this->user();
		}

		if( $user != 0 && !isset($userinfo[$user]) ) {
			try {
			// query the Facebook OpenGraph
				if( is_null($fields) || !is_array($fields) ) {
					$fields = $this->getDefaultQueryFields();
				} else {
					$fields = $this->sanitizeQueryFields($fields);
				}

				$fql = 'SELECT '.$fields.' FROM user WHERE uid='.$user;
				$userData = $this->Facebook()->api(array(
					'method' => 'fql.query',
					'query' => $fql,
				));

				// Cache the data in the $userinfo array
				//avoid Notice: Uninitialized string offset: 0
				$userinfo[$user] = !empty($userData[0]) ? $userData[0] : null;
			} catch( Exception $e ) {
				error_log( 'Failure in the api when requesting ' . $fields . " on uid $user: " . $e->getMessage());
			}
		}

		return isset($userinfo[$user]) ? $userinfo[$user] : null;
	}

	protected function getDefaultQueryFields() {
		$fields = array(
			'first_name',
			'name',
			'sex',
			'timezone',
			'locale',
			'username',
			'proxied_email',
			'contact_email'
		);

		return $this->sanitizeQueryFields($fields);
	}

	protected function sanitizeQueryFields($fields) {
		return join(',', $fields);
	}
}