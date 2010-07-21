<?php
/**
 * PhalanxHelper
 *
 * CRUD helper functions
 * AJAX handlers
 * Testing auxiliary functions
 */
class PhalanxHelper {

	static public function convertDataToDB( $data ) {
		$db_data = array();
		foreach( $data as $key => $field  ) {
			$db_data[ 'p_' . $key ] = $field;
		}

		return $db_data;
	}

	/**
	 * update
	 *
	 * @return boolean: true on success, false on failure
	 */
	static public function update( $data ) {
		global $wgExternalSharedDB, $wgMemc;
		$result = false;
		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->update(
			'phalanx',
			self::convertDataToDB( $data ),
			array( 'p_id' => $data[ 'id' ] ),
			__METHOD__
		);

		if ( $dbw->affectedRows() ) {
			$result = true ;

			$dbw->immediateCommit();

			//update cache
			$modulesId = $data['type'];
			$lang = $data['lang'] ? $data['lang'] : null;

			//iterate for each module for which block is saved
			for ($bit = $modulesId&1, $moduleId=1; $modulesId; $modulesId>>=1, $bit = $modulesId&1, $moduleId<<=1) {
				if (!$bit) continue;	//skip not used modules
				$key = 'phalanx:' . $moduleId . ':' . ($lang ? $lang : 'all');
				$blocksData = $wgMemc->get($key);
				//cache miss, fill it from DB (getFromFilter() will update the cache)
				if (empty($blocksData)) {
					Phalanx::getFromFilter($moduleId, $lang, true /*use master to avoid lag - an insert was a moment ago*/);
				} else {	//update cache
					$blocksData['blocks'][$data['id']] = $data;
					$wgMemc->set($key, $blocksData);
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $result ;
	}

	/**
	 * save
	 *
	 * @return boolean: true on success, false on failure
	 */
	static public function save( $data ) {
		global $wgExternalSharedDB, $wgMemc;
		$result = false;
		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->insert(
			'phalanx',
			self::convertDataToDB( $data ),
			__METHOD__
		);

		if ( $dbw->affectedRows() ) {
			$result = true ;
			$data['id'] = $dbw->insertId();

			$dbw->immediateCommit();

			//update cache
			$modulesId = $data['type'];
			$lang = $data['lang'] ? $data['lang'] : null;

			//iterate for each module for which block is saved
			for ($bit = $modulesId&1, $moduleId=1; $modulesId; $modulesId>>=1, $bit = $modulesId&1, $moduleId<<=1) {
				if (!$bit) continue;	//skip not used modules
				$key = 'phalanx:' . $moduleId . ':' . ($lang ? $lang : 'all');
				$blocksData = $wgMemc->get($key);
				//cache miss, fill it from DB (getFromFilter() will update the cache)
				if (empty($blocksData)) {
					Phalanx::getFromFilter($moduleId, $lang, true /*use master to avoid lag - an insert was a moment ago*/);
				} else {	//update cache
					$blocksData['blocks'][$data['id']] = $data;	//add new block
					$wgMemc->set($key, $blocksData);
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $result ;
	}

	/**
	 * AJAX creation/update
	 */
	static public function setBlock() {
		global $wgRequest, $wgUser;

		wfProfileOut( __METHOD__ );

		$id = $wgRequest->getVal( 'id', false ); // only set for update
		$filter = $wgRequest->getText( 'wpPhalanxFilter' );
		$regex = $wgRequest->getCheck( 'wpPhalanxFormatRegex' ) ? 1 : 0;
		$exact = $wgRequest->getCheck( 'wpPhalanxFormatExact' ) ? 1 : 0;
		$case = $wgRequest->getCheck( 'wpPhalanxFormatCase' ) ? 1 : 0;
		$expiry = $wgRequest->getText( 'wpPhalanxExpire' );
		$types = $wgRequest->getArray( 'wpPhalanxType' );
		$reason = $wgRequest->getText( 'wpPhalanxReason' );
		$lang = $wgRequest->getVal( 'wpPhalanxLanguages', null );

		$typemask = 0;
		foreach( $types as $type ) {
			$typemask |= $type;
		}

		//validation
		if ( empty( $filter ) || empty( $typemask ) ) {
			wfProfileOut( __METHOD__ );
			return array( 'error' => true, 'text' => wfMsg( 'phalanx-block-failure' ) );
		}

		if ( $lang == 'all' ) {
			$lang = null;
		}

		if ($expiry != 'infinite') {
			$expire = strtotime( $expiry );
			if ( $expire < 0 || $expire === false ) {
				wfProfileOut( __METHOD__ );
				return false;
			}
			$expire = wfTimestamp( TS_MW, $expire );
		} else {
			$expire = null ;
		}

		$data = array(
			'text' => $filter,
			'exact' => $exact,
			'case' => $case,
			'regex' => $regex,
			'timestamp' => wfTimestampNow(),
			'expire' => $expire,
			'author_id' => $wgUser->getId(),
			'reason' => $reason,
			'lang' => $lang,
			'type' => $typemask
		);

		if( !$id  ) {
			$status = PhalanxHelper::save( $data );
			$reason = $status ? wfMsg( 'phalanx-block-success' ) : wfMsg( 'phalanx-block-failure' );
		} else {
			$data['id'] = $id;
			$status = PhalanxHelper::update( $data );
			$reason = $status ? wfMsg( 'phalanx-modify-success' ) : wfMsg( 'phalanx-block-failure' );
		}

		wfProfileOut( __METHOD__ );
		return array(
			'error' => !$status,
			'text'  => $reason
		);
	}


	static public function getOneBlock($id) {
		global $wgLang;

		$data = Phalanx::getFromId( $id );
		if( empty( $data ) ) {
			return array('error' => true);
		}

		$time = $wgLang->timeanddate( wfTimestamp( TS_MW, $data['timestamp'] ), true );

		return array(
			'data' => $data,
			'error' => false,
			'time' => $time,
			'button' => wfMsg( 'phalanx-edit-block' ),
			'text' => wfMsg( 'phalanx-modify-warning', $data['id'] )
		);
	}

	static public function removeSingleBlock() {
		global $wgRequest;
		$id = $wgRequest->getVal( 'id' );
		return array(
			"error" => self::removeFilter( $id ),
			"text" => wfMsg( 'phalanx-unblock-message', $id )
		);
	}


	static public function removeFilter( $blockId ) {
		global $wgExternalSharedDB, $wgUser, $wgMemc;
		wfProfileIn( __METHOD__ );

		// todo this will need to be changed

		//get data before deletion - we need it for cache update
		$data = Phalanx::getFromId($blockId);

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->delete(
			'phalanx',
			array('p_id' => intval($blockId)),
			__METHOD__
		);

		if ( !$dbw->affectedRows() ) {
			wfProfileOut( __METHOD__ );
			return array('error' => true);
		}

		$dbw->immediateCommit();

		//update cache
		$modulesId = $data['type'];
		$lang = $data['lang'] ? $data['lang'] : null;

		//iterate for each module for which block is saved
		for ($bit = $modulesId&1, $moduleId=1; $modulesId; $modulesId>>=1, $bit = $modulesId&1, $moduleId<<=1) {
			if (!$bit) continue;	//skip not used modules
			$key = 'phalanx:' . $moduleId . ':' . ($lang ? $lang : 'all');
			$blocksData = $wgMemc->get($key);

			//cache miss, fill it from DB (getFromFilter() will update the cache)
			if (empty($blocksData)) {
				Phalanx::getFromFilter($moduleId, $lang, true /*use master to avoid lag - deletion was a moment ago*/);
			} else {	//update cache
				unset($blocksData['blocks'][$data['id']]);	//remove block
				$wgMemc->set($key, $blocksData);
			}
		}

		$result = array(
			'error' => false,
			'text' => wfMsg( 'phalanx-unblock-message', $data['id'] ),
		);

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * testBlock
	 *
	 * performs a test of all available filters and returns matching filters
	 *
	 * @param $text String to match
	 * @return String with HTML to display via AJAX
	 *
	 * @author tor <tor@wikia-inc.com>
	 */
	public static function testBlock( $text ) {
		$data = array();
		$output = '';

		$aModules = Phalanx::$typeNames;

		foreach ( $aModules as $module => $name ) {
			$filters = Phalanx::getFromFilter( $module );
			$data[$module] = array();

			if ( empty( $filters ) ) {
				continue;
			}

			foreach( $filters as $filter ) {
				$result = Phalanx::isBlocked( $text, $filter );
				if ( $result['blocked'] == true ) {
					$data[$module][] = $filter;
				}
			}

			if ( !empty( $data[$module] ) ) {
				$output .= Xml::element( 'h2', null, $name );

				foreach ( $data[$module] as $match ) {
					$phalanxUrl = Title::newFromText( 'Phalanx', NS_SPECIAL )->getFullUrl( array( 'id' => $match['id'] ) );
					$statsUrl = Title::newFromText( 'PhalanxStats', NS_SPECIAL )->getFullUrl() . '/' . $match['id'];

					$line = htmlspecialchars( $match['text'] ) . ' &bull; ' .
						Xml::element( 'a', array( 'href' => $phalanxUrl, 'class' => 'unblock' ), 'unblock' ) . ' &bull; ' .
						Xml::element( 'a', array( 'href' => $phalanxUrl, 'class' => 'modify' ), 'modify' ) . ' &bull; ' .
						Xml::element( 'a', array( 'href' => $statsUrl, 'class' => 'stats' ), 'stats' ) . ' &bull; ' .
						'#' . $match['id'];
					$output .= Xml::tags( 'li', null, $line );
				}

				$output .= Xml::closeElement( 'ul' );
			}
		}

		if ( empty( $output ) ) {
			$output = 'No matches found.';
		}

		return $output;
	}
}
