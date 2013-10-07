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
	static public function update( $data, $updateCache = false ) {
		global $wgExternalSharedDB, $wgMemc;
		$result = false;
		wfProfileIn( __METHOD__ );

		if ( ( $data['type'] & Phalanx::TYPE_USER ) && User::isIP( $data['text'] ) ) {
			$data['ip_hex'] = IP::toHex( $data['text'] );
		}

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

			$dbw->commit();

			if ( $updateCache ) {
				self::updateCache($oldData, $data);
			}
			self::logEdit($oldData,$data);
			self::reload($data[ 'id' ]);
		}

		wfProfileOut( __METHOD__ );
		return $result ;
	}

	/**
	 * save
	 *
	 * @return boolean: true on success, false on failure
	 */
	static public function save( $data, $updateCache = true ) {
		global $wgExternalSharedDB, $wgMemc;
		$result = false;
		wfProfileIn( __METHOD__ );

		if ( ( $data['type'] & Phalanx::TYPE_USER ) && User::isIP( $data['text'] ) ) {
			$data['ip_hex'] = IP::toHex( $data['text'] );
		}

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->insert(
			'phalanx',
			self::convertDataToDB( $data ),
			__METHOD__
		);

		if ( $dbw->affectedRows() ) {
			$data['id'] = $result = $dbw->insertId();

			$dbw->commit();

			if ( $updateCache ) {
				self::updateCache(null, $data);
			}
			self::logAdd($data);
			self::reload($data[ 'id' ]);
		}

		wfProfileOut( __METHOD__ );
		return $result ;
	}

	/**
	 * AJAX creation/update
	 */
	static public function setBlock() {
		global $wgRequest, $wgUser;

		wfProfileIn( __METHOD__ );

		$id = $wgRequest->getVal( 'id', false ); // only set for update
		$filter = $wgRequest->getText( 'wpPhalanxFilter' );
		$filterbulk = $wgRequest->getText( 'wpPhalanxFilterBulk' );
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
		if ( (empty( $filter ) && empty( $filterbulk )) || empty( $typemask ) ) {
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

		if( empty($filterbulk) ) {
			//single mode
			if( !$id  ) {
				$status = PhalanxHelper::save( $data );
				$reason = $status ? wfMsg( 'phalanx-block-success' ) : wfMsg( 'phalanx-block-failure' );
			} else {
				$data['id'] = $id;
				$status = PhalanxHelper::update( $data );
				$reason = $status ? wfMsg( 'phalanx-modify-success' ) : wfMsg( 'phalanx-block-failure' );
			}
		}
		else {
			// non-empty bulk field
			$bulkdata = explode("\n", $filterbulk);
			if( count($bulkdata) ) {
				$reasons = array('s' => 0, 'f' => 0);
				foreach($bulkdata as $bulkrow)
				{
					$bulkrow = trim($bulkrow);
					$data['text'] = $bulkrow;

					$bstatus = PhalanxHelper::save( $data );
					if($bstatus) {
						$reasons[ 's' ] ++;
					} else {
						$reasons[ 'f' ] ++;
					}

				}
				$status = true;
				$reason = "[" . $reasons['s'] . "] success and [" . $reasons['f'] . "] fails";
			}
			else
			{
				$status = false;
				$reason = "nothing to block";
			}
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
		$id = $wgRequest->getInt( 'id' );
		return array(
			"error" => self::removeFilter( $id ),
			"text" => wfMsg( 'phalanx-unblock-message', $id )
		);
	}


	static public function removeFilter( $blockId, $updateCache = true ) {
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

		$dbw->commit();

		if ( $updateCache ) {
			self::updateCache($data, null);
		}
		self::logDelete($data);
		self::reload($blockId);

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

		$newDataShort = false;
		if ( $newData ) {
			$newDataShort = array(
				$newData['id'],
				$newData['text'],
				  ($newData['exact'] ? Phalanx::FLAG_EXACT : 0)
				+ ($newData['regex'] ? Phalanx::FLAG_REGEX : 0)
				+ ($newData['case'] ? Phalanx::FLAG_CASE : 0)
			);
		}

		$id = intval( $oldData ? $oldData['id'] : $newData['id'] );

		$memcClient = is_callable(array($wgMemc,'getClient')) ? $wgMemc->getClient() : false;
		// Iterate through each affected cache case and update
		foreach ($list as $moduleId => $list2) {
			foreach ($list2 as $lang => $props) {
				if (empty($lang) || $lang == 'all') $lang = null;

				$remove = !empty($props['remove']);
				$save = !empty($props['save']);

				$sLang = $lang ? $lang : 'all';

				// update full format
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
				if ( $memcClient ) {
					unset($memcClient->_dupe_cache[$key]);
				}

				// update short format (only for user)
				if ( $moduleId == Phalanx::TYPE_USER ) {
					$key = 'phalanx:' . $moduleId . ':' . $sLang . ':short';
					$blocksData = $wgMemc->get($key);
					if (empty($blocksData)) {
						Phalanx::getFromFilterShort($moduleId, $lang, true /*use master to avoid lag - change was a moment ago*/);
					} else {
						if ($remove && !$save) {
							unset($blocksData['blocks'][$id]); // remove block
						} else if ($save) {
							$blocksData['blocks'][$id] = $newDataShort; // add or overwrite block
						}
						$wgMemc->set($key,$blocksData);
					}
					if ( $memcClient ) {
						unset($memcClient->_dupe_cache[$key]);
					}
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

			$filter = null;
			$result = Phalanx::findBlocked( $text, $filters, true, $filter );
			if ( $result['blocked'] == true ) {
				$data[$module][] = $filter;
			}

			if ( !empty( $data[$module] ) ) {
				$output .= Xml::element( 'h2', null, $name );

				$output .= Xml::openElement( 'ul' );

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

		if ( $data['type'] & Phalanx::TYPE_EMAIL ) {
			$logType = 'phalanxemail';
		} else {
			$logType = 'phalanx';
		}

		$log = new LogPage( $logType );
		$log->addEntry( $action, $title, wfMsgExt( 'phalanx-rule-log-details', array( 'parsemag', 'content' ),
			$data['text'], $types, $data['reason'] ) );
		// Workaround lack of automatic COMMIT in Ajax requests
		$db = wfGetDB( DB_MASTER );
		$db->commit();
	}

	/**
	 * Reload Phalanx II service to keep service in sync with blocks added from old Phalanx
	 *
	 * @param int|null $id block ID to be reloaded (or null to reload all blocks)
	 * @return bool true if the request was successful
	 */
	static private function reload($id = null) {
		wfProfileIn(__METHOD__);

		$service = new PhalanxService();
		$res = $service->reload(!is_null($id) ? [$id] : []) === 1;

		if ($res === false) {
			Wikia::log(__METHOD__, false, 'reload failed', true);
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

}
