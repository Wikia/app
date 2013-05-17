<?php


class GWTUserRepository {
	private $databaseConnection;

	public function  __construct( $db = null ) {
		if ( $db == null ) {
			global $wgExternalSharedDB;
			$app = F::app();
			$db = wfgetDB( DB_MASTER, array(), $wgExternalSharedDB);
		}
		$this->databaseConnection = $db;
	}

	private function materialize( $resultObject ) {
		return new GWTUser( $resultObject->user_id, $resultObject->user_name, $resultObject->user_password, $resultObject->wikis_number );
	}

	private function materializeList( $queryResult ) {
		$list = array();
		while ( $obj = $queryResult->fetchObject() ) {
			$list[] = $this->materialize($obj);
		}
		return $list;
	}

	public function all() {
		$result = $this->databaseConnection->select("webmaster_user_accounts", array("user_id", "user_name", "user_password", "wikis_number"));
		return $this->materializeList($result);
	}

	public function allCountLt( $count ) {
		$result = $this->databaseConnection->select("webmaster_user_accounts"
			, array("user_id", "user_name", "user_password", "wikis_number")
			, "wikis_number < " . $count );
		return $this->materializeList($result);
	}

	public function getByEmail( $email ) {
		$result = $this->databaseConnection->select("webmaster_user_accounts"
			, array("user_id", "user_name", "user_password", "wikis_number")
			, array("user_name" => $email) );
		$list = $this->materializeList($result);
		if( count($list) == 0 ) {
			return null;
		}
		return $list[0];
	}

	public function getById( $id ) {
		$result = $this->databaseConnection->select("webmaster_user_accounts"
			, array("user_id", "user_name", "user_password", "wikis_number")
			, array("user_id" => $id) );
		$list = $this->materializeList($result);
		if( count($list) == 0 ) {
			return null;
		}
		return $list[0];
	}

	public function create( $email, $password ) {
		if ( $this->exists($email) ) {
			throw new GWTException( "User exists in database." );
		}
		return $this->insert( $email, $password);
	}

	public function tryCreate( $email, $password ) {
		if ( $this->exists($email) ) {
			return false;
		}
		return $this->insert( $email, $password);
	}

	private function exists( $email ) {
		$res = $this->databaseConnection->select("webmaster_user_accounts",
			array('user_id'),
			array(
				"user_name" => $email,
			),
			__METHOD__
		);
		if ( $res->fetchObject() ) return true;
		return false;
	}

	public function insert( $username, $password ) {
		$user_id = $this->generateUserId(  );
		if( !$this->databaseConnection->insert("webmaster_user_accounts", array(
			"user_id" => $user_id,
			"user_name" => $username,
			"user_password" => $password,
			"wikis_number" => 0,
		)) ) {
			throw new Exception("can't insert user id = " . $user_id . " name = " . $username);
		}
		return new GWTUser( $user_id, $username, $password, 0 );
	}

	public function update( $gwtUserObject ) {
		$res = $this->databaseConnection->update("webmaster_user_accounts",
			array(
				"user_id" => $gwtUserObject->getId(),
				"user_name" => $gwtUserObject->getEmail(),
				"user_password" => $gwtUserObject->getPassword(),
				"wikis_number" => $gwtUserObject->getCount(),
			),
			array(
				"user_id" => $gwtUserObject->getId(),
			));
		if( !$res ) throw new GWTException("Failed to update " . $gwtUserObject->getId());
	}

	public function deleteByEmail( $email ) {
		$result = $this->databaseConnection->delete("webmaster_user_accounts"
			, array("user_name" => $email));
		if( !$result ) throw new GWTException("Cannot delete user by email ( email = " . $email . " ) ");
	}

	public function deleteById( $user_id ) {
		$result = $this->databaseConnection->delete("webmaster_user_accounts"
			, array("user_id" => $user_id));
		if( !$result ) throw new GWTException("Cannot delete user by id ( id = " . $user_id . " ) ");
	}

	private function generateUserId(  ) {
		$res = $this->databaseConnection->select("webmaster_user_accounts",
			array('max(user_id) as maxid'),
			array(),
			__METHOD__
		);
		return $res->fetchObject()->maxid + 1;
	}
}
