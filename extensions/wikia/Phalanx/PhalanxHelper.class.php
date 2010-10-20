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

		//get data before update - we need it for cache update
		$oldData = Phalanx::getFromId($data['id']);

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

			self::updateCache($oldData, $data);
			self::logEdit($oldData,$data);
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
			$data['id'] = $result = $dbw->insertId();

			$dbw->immediateCommit();

			self::updateCache(null, $data);
			self::logAdd($data);
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

		self::updateCache($data, null);
		self::logDelete($data);

		$result = array(
			'error' => false,
			'text' => wfMsg( 'phalanx-unblock-message', $data['id'] ),
		);

		wfProfileOut( __METHOD__ );
		return $result;
	}
	
	/**
	 * Updates Phalanx rules cache after one changing one rule (add, modify or delete)  
	 * 
	 * @param $oldData mixed Old rule data or null if adding a rule
	 * @param $newData mixed New rule data or null if removing a rule
	 */
	static public function updateCache( $oldData, $newData ) {
		global $wgMemc, $wgPhalanxSupportedLanguages;
		
		$allLanguages = array_keys( $wgPhalanxSupportedLanguages );
		if (array_search('all',$allLanguages)) {
			array_unshift($allLanguages, 'all');
		}
		
		$list = array();
		
		// Find where the rule was removed from?
		if ($oldData) {
			$lang = $oldData['lang'] ? $oldData['lang'] : null;
			$langs = $lang ? array( $lang ) : $allLanguages;
			$type = $oldData['type'];
			for ($i=1; $type>0; $i<<=1, $type>>=1) {
				if ($type & 1) {
					foreach ($langs as $l) {
						$list[$i][$l]['remove'] = true;
					}
				}
			}
		}
		
		// Find where the rule will be added to?
		if ($newData) {
			$lang = $newData['lang'] ? $newData['lang'] : null;
			$langs = $lang ? array( $lang ) : $allLanguages;
			$type = $newData['type'];
			for ($i=1; $type>0; $i<<=1, $type>>=1) {
				if ($type & 1) {
					foreach ($langs as $l) {
						$list[$i][$l]['save'] = true;
					}
				}
			}
		}
		
		$id = intval( $oldData ? $oldData['id'] : $newData['id'] );

		// Iterate through each affected cache case and update
		foreach ($list as $moduleId => $list2) {
			foreach ($list2 as $lang => $props) {
				if (empty($lang) || $lang == 'all') $lang = null;
				
				$remove = !empty($props['remove']);
				$save = !empty($props['save']);
				
				$sLang = $lang ? $lang : 'all';
				$key = 'phalanx:' . $moduleId . ':' . $sLang;
				Phalanx::clearCache($moduleId,$sLang); // clear local cache 
				$blocksData = $wgMemc->get($key);
				
				if (empty($blocksData)) {
					Phalanx::getFromFilter($moduleId, $lang, true /*use master to avoid lag - change was a moment ago*/);
				} else {
					if ($remove && !$save) {
						unset($blocksData['blocks'][$id]); // remove block
					} else if ($save) {
						$blocksData['blocks'][$id] = $newData; // add or overwrite block
					}
					$wgMemc->set($key,$blocksData);
				}
			}
		}

		Phalanx::setLastUpdate();
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
		$link_unblock = wfMsg('phalanx-link-unblock');
		$link_modify = wfMsg('phalanx-link-modify');
		$link_stats = wfMsg('phalanx-link-stats');

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
						Xml::element( 'a', array( 'href' => $phalanxUrl, 'class' => 'unblock' ), $link_unblock ) . ' &bull; ' .
						Xml::element( 'a', array( 'href' => $phalanxUrl, 'class' => 'modify' ), $link_modify ) . ' &bull; ' .
						Xml::element( 'a', array( 'href' => $statsUrl, 'class' => 'stats' ), $link_stats ) . ' &bull; ' .
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
	
	static public function logAdd( $data ) {
		self::logUniversal( 'add', $data );
	}
	
	static public function logEdit( $old, $data ) {
		self::logUniversal( 'edit', $data );
	}
	
	static public function logDelete( $data ) {
		self::logUniversal( 'delete', $data );
	}
	
	static public function logUniversal( $action, $data ) {
		$title = Title::newFromText('PhalanxStats/' . $data['id'],NS_SPECIAL);
		$types = implode(',', Phalanx::getTypeNames($data['type']));
		$log = new LogPage( 'phalanx' );
		$log->addEntry( $action, $title, wfMsgExt( 'phalanx-rule-log-details', array( 'parsemag', 'content' ), 
			$data['text'], $types, $data['reason'] ) );
		// Workaround lack of automatic COMMIT in Ajax requests
		$db = wfGetDB( DB_MASTER );
		$db->immediateCommit();
	}
	
}
