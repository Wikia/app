<?php

use \Wikia\Logger\WikiaLogger;

class PhalanxHooks extends WikiaObject {
	function __construct() {
		parent::__construct();
	}

	/**
	 * Add a link to central:Special:Phalanx from Special:Contributions/USERNAME
	 * if the user has 'phalanx' permission
	 *
	 * @param $id Integer: user ID
	 * @param $nt Title: user page title
	 * @param $links Array: tool links
	 * @return boolean true
	 */
	static public function loadLinks( $id, $nt, &$links ) {
		wfProfileIn( __METHOD__ );

		$user = RequestContext::getMain()->getUser();

		if ( $user->isAllowed( 'phalanx' ) ) {
			$links[] = Linker::makeKnownLinkObj(
				GlobalTitle::newFromText( 'Phalanx', NS_SPECIAL, WikiFactory::COMMUNITY_CENTRAL ),
				'PhalanxBlock',
				wfArrayToCGI(
					[
						'type' => Phalanx::TYPE_USER,
						'wpPhalanxCheckBlocker' => $nt->getText(),
						'target' => $nt->getText(),
					]
				)
			);
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Performs spam check for 3rd party extension. Third parameter will be provided with matching block data
	 *
	 * @param $text string content to check for spam
	 * @param $typeId int block type (see Phalanx::TYPE_* constants)
	 * @param $blockData array array to be provided with matching block details (pass as a reference)
	 * @return boolean spam check result
	 *
	 * @author macbre
	 */
	static public function onSpamFilterCheck($text, $typeId, &$blockData) {
		wfProfileIn( __METHOD__ );

		if ($text === '') {
			wfProfileOut( __METHOD__ );
			return true;
		}

		if (!$typeId) {
			$typeId = PhalanxModel::determineTypeId($text);
		}

		$model = PhalanxModel::newFromType($typeId, $text);

		if (is_null($model)) {
			throw new WikiaException("Unsupported block type passed - #{$typeId}");
		}

		// get type ID -> type mapping
		$types = Phalanx::getAllTypeNames();
		$ret = $model->match($types[$typeId]);

		// pass matching block details
		if ( $ret === false ) {
			$blockData = (array) $model->getBlock();
			wfDebug( __METHOD__ . ": spam check blocked '{$text}'\n" );
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * Add/edit Phalanx block
	 *
	 * @param $data Array contains block information, possible keys: id, author_id, text, type, timestamp, expire, exact, regex, case, reason, lang, ip_hex
	 * @return int id block or false if error
	 *
	 * @author moli
	 */
	static public function onEditPhalanxBlock( &$data ) {
		wfProfileIn( __METHOD__ );

		if ( !isset( $data['id'] ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$phalanx = Phalanx::newFromId( $data['id'] );

		foreach ( $data as $key => $val ) {
			if ( $key == 'id' ) continue;

			$phalanx[ $key ] = $val;
		}

		$typemask = $phalanx['type'];
		if ( is_array( $phalanx['type'] ) ) {
			$typemask = 0;
			foreach ( $phalanx['type'] as $type ) {
				$typemask |= $type;
			}
		}

		// VSTF should not be allowed to block emails in Phalanx
		if ( ($typemask & Phalanx::TYPE_EMAIL ) && !F::app()->wg->User->isAllowed( 'phalanxemailblock' ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$multitext = '';
		if ( isset( $phalanx['multitext'] ) && !empty( $phalanx['multitext'] ) ) {
			$multitext = $phalanx['multitext'];
		}

		unset( $phalanx['multitext'] );

		if ( ( empty( $phalanx['text'] ) && empty( $multitext ) ) || empty( $typemask ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$phalanx['type'] = $typemask;

		if ( $phalanx['lang'] == 'all' ) {
			$phalanx['lang'] = null;
		}

		if ( $phalanx['expire'] === '' || is_null( $phalanx['expire'] ) ) {
			// don't change expire
			unset($phalanx['expire']);
		} else if ( $phalanx['expire'] != 'infinite' ) {
			$expire = strtotime( $phalanx['expire'] );
			if ( $expire < 0 || $expire === false ) {
				wfProfileOut( __METHOD__ );
				return false;
			}
			$phalanx['expire'] = wfTimestamp( TS_MW, $expire );
		} else {
			$phalanx['expire'] = null ;
		}

		if ( empty( $multitext ) ) {
			/* single mode - insert/update record */
			$data['id'] = $phalanx->save();
			$result = $data['id'] ? array( "success" => array( $data['id'] ), "failed" => 0 ) : false;
		}
		else {
			/* non-empty bulk field */
			$bulkdata = explode( "\n", $multitext );
			if ( count($bulkdata) > 0 ) {
				$result = array( 'success' => array(), 'failed' => 0 );
				foreach ( $bulkdata as $bulkrow ) {
					$bulkrow = trim($bulkrow);
					$phalanx['id'] = null;
					$phalanx['text'] = $bulkrow;

					$data['id'] = $phalanx->save();
					if ( $data['id'] ) {
						$result[ 'success' ][] = $data['id'];
					} else {
						$result[ 'failed' ]++;
					}
				}
			} else {
				$result = false;
			}
		}

		if ( $result !== false ) {
			$service = new PhalanxService();
			$ret = $service->reload( $result["success"] );
		} else {
			$ret = $result;
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * Delete Phalanx block
	 *
	 * @param $id Int - block ID
	 * @return boolean true or false if error
	 *
	 * @author moli
	 */
	static public function onDeletePhalanxBlock( $id ) {
		wfProfileIn( __METHOD__ );

		$phalanx = Phalanx::newFromId($id);

		// VSTF should not be allowed to delete email blocks in Phalanx
		if ( ($phalanx->offsetGet( 'type' ) & Phalanx::TYPE_EMAIL ) && !F::app()->wg->User->isAllowed( 'phalanxemailblock' ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$id = $phalanx->delete();
		if ( $id ) {
			$service = new PhalanxService();
			$ids = array( $id );
			$ret = $service->reload( $ids );
		} else {
			$ret = false;
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * Make block ID more visible in user block message (BAC-536)
	 *
	 * @param array $permErrors
	 * @param string $action
	 * @return bool true
	 */
	static public function onAfterFormatPermissionsErrorMessage( Array &$permErrors, $action) {
		foreach($permErrors as &$error) {
			if (isset($error[5]) && is_numeric($error[5])) {
				$error[5] = "<big><strong>$error[5]</strong></big>";
			}
		}

		return true;
	}

	/**
	 * Log cases when Fastly does not pass a "secret" request header with
	 * client original IP.
	 *
	 * @see PLATFORM-317
	 * @see PLATFORM-1473
	 * @author macbre
	 *
	 * @param User $user
	 * @return bool true
	 */
	static public function onGetBlockedStatus( User $user, $shouldLogBlockInStats=false, $global=true ) {
		if (!$global) {
			return true;
		}

		global $wgRequest, $wgClientIPHeader;

		// get the client IP using Fastly-generated request header
		$clientIPFromFastly = $wgRequest->getHeader( $wgClientIPHeader );

		if ( !User::isIP( $clientIPFromFastly ) && !$wgRequest->isWikiaInternalRequest() ) {
			WikiaLogger::instance()->error( 'Phalanx user IP incorrect', [
				'ip_from_fastly' => $clientIPFromFastly,
				'ip_from_user' => $user->getName(),
				'ip_from_request' => $wgRequest->getIP(),
				'user_agent' => $wgRequest->getHeader( 'User-Agent' ),
			] );
		}

		return true;
	}

	/**
	 * Outputs information about users global block and prevents displaying extract from local log which does not contain
	 * information about phalanx block.
	 *
	 * @see PLATFORM-470
	 * @author jcellary
	 *
	 * @param OutputPage $out
	 * @param User $user
	 * @return bool false
	 */
	static public function onContributionsLogEventsList( OutputPage $out, User $user ) {

		$blockedGlobally = $user->mBlockedGlobally;

		if ($blockedGlobally) {
			$message = wfMessage( 'phalanx-sp-contributions-blocked-globally' )->text();
			$message = '<div class="'.LogEventsList::WARN_BOX_DIV_CLASS.'">'.$message.'</div>';
			$out->addHTML($message);
		}

		return !$blockedGlobally; //If blocked globally disable listing local log
	}
}
