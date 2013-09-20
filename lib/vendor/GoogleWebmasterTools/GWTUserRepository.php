<?php


/**
 * Class GWTUserRepository
 */
class GWTUserRepository {
	/**
	 * @var DatabaseMysql|null
	 */
	private $databaseConnection;

	/**
	 * @param null $db
	 */
	public function  __construct( $db = null ) {
		if ( $db == null ) {
			global $wgExternalSharedDB;
			$app = F::app();
			$db = wfgetDB( DB_MASTER, array(), $wgExternalSharedDB);
		}
		$this->databaseConnection = $db;
	}

	/**
	 * @param $resultObject
	 * @return GWTUser
	 */
	private function materialize( $resultObject ) {
		return new GWTUser( $resultObject->user_id, $resultObject->user_name, $resultObject->user_password, $resultObject->wikis_number );
	}

	/**
	 * @param ResultWrapper $queryResult
	 * @return GWTUser[]
	 */
	private function materializeList( $queryResult ) {
		$list = array();
		while ( $obj = $queryResult->fetchObject() ) {
			$list[] = $this->materialize($obj);
		}
		return $list;
	}

	/**
	 * @return GWTUser[]
	 */
	public function all() {
		$result = $this->databaseConnection->select("webmaster_user_accounts", array("user_id", "user_name", "user_password", "wikis_number"));
		return $this->materializeList($result);
	}

	/**
	 * @param $count
	 * @return GWTUser[]
	 */
	public function allCountLt( $count ) {
		$result = $this->databaseConnection->select("webmaster_user_accounts"
			, array("user_id", "user_name", "user_password", "wikis_number")
			, "wikis_number < " . $count );
		return $this->materializeList($result);
	}

	/**
	 * @param $email
	 * @return null|GWTUser
	 */
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

	/**
	 * @param $id
	 * @return GWTUser
	 */
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

	/**
	 * Insert user. Throws if user (email) exists.
	 * @param $email
	 * @param $password
	 * @return GWTUser
	 * @throws GWTException
	 */
	public function create( $email, $password ) {
		if ( $this->exists($email) ) {
			throw new GWTException( "User exists in database." );
		}
		return $this->insert( $email, $password);
	}

	/**
	 * Returns false if user exists
	 * @param $email
	 * @param $password
	 * @return bool|GWTUser
	 */
	public function tryCreate( $email, $password ) {
		if ( $this->exists($email) ) {
			return false;
		}
		return $this->insert( $email, $password);
	}

	/**
	 * @param $email
	 * @return bool
	 */
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

	/**
	 * @param $username
	 * @param $password
	 * @return GWTUser
	 * @throws Exception
	 */
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

	/**
	 * @param GWTUser $gwtUserObject
	 * @throws GWTException
	 */
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

	/**
	 * @param $email
	 * @throws GWTException
	 */
	public function deleteByEmail( $email ) {
		$result = $this->databaseConnection->delete("webmaster_user_accounts"
			, array("user_name" => $email));
		if( !$result ) throw new GWTException("Cannot delete user by email ( email = " . $email . " ) ");
	}

	/**
	 * @param $user_id
	 * @throws GWTException
	 */
	public function deleteById( $user_id ) {
		$result = $this->databaseConnection->delete("webmaster_user_accounts"
			, array("user_id" => $user_id));
		if( !$result ) throw new GWTException("Cannot delete user by id ( id = " . $user_id . " ) ");
	}

	/**
	 * @return int
	 */
	private function generateUserId(  ) {
		$res = $this->databaseConnection->select("webmaster_user_accounts",
			array('max(user_id) as maxid'),
			array(),
			__METHOD__
		);
		return (int) $res->fetchObject()->maxid + 1;
	}
}
