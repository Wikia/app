<?php

use \Wikia\Logger\WikiaLogger;
use Wikia\Rabbit\ConnectionBase;

class PhalanxHooks {
	const ROUTING_KEY = 'onUpdate';

	protected static $rabbitConnection;

	/**
	 * Add a link to central:Special:Phalanx from Special:Contributions/USERNAME
	 * if the user has 'phalanx' permission
	 *
	 * @param $id Integer: user ID
	 * @param $nt Title: user page title
	 * @param $links array: tool links
	 * @return boolean true
	 */
	static public function loadLinks( $id, $nt, &$links ) {
		wfProfileIn( __METHOD__ );

		$user = RequestContext::getMain()->getUser();

		if ( $user->isAllowed( 'phalanx' ) ) {
			$phalanxTitle = GlobalTitle::newFromText( 'Phalanx', NS_SPECIAL, WikiFactory::COMMUNITY_CENTRAL );
			$phalanxUrl = $phalanxTitle->getFullURL( [
				'type' => Phalanx::TYPE_USER,
				'wpPhalanxCheckBlocker' => $nt->getText(),
				'target' => $nt->getText(),
			] );

			$links[] = Html::element( 'a', [ 'href' => $phalanxUrl ], 'PhalanxBlock' );
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
	 * @return bool spam check result
	 *
	 * @throws WikiaException
	 * @author macbre
	 */
	static public function onSpamFilterCheck( $text, $typeId, &$blockData ) {
		wfProfileIn( __METHOD__ );

		if ( $text === '' ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( !$typeId ) {
			$typeId = PhalanxModel::determineTypeId( $text );
		}

		$model = PhalanxModel::newFromType( $typeId, $text );

		if ( is_null( $model ) ) {
			throw new WikiaException( "Unsupported block type passed - #{$typeId}" );
		}

		// get type ID -> type mapping
		$types = Phalanx::getSupportedTypeNames();
		$ret = $model->match( $types[$typeId] );

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * Add/edit Phalanx block
	 *
	 * @param array $data contains block information, possible keys: id, author_id, text, 
	 * type, timestamp, expire, exact, regex, case, reason, lang
	 * @return int id block or false if error
	 *
	 * @author moli
	 */
	static public function onEditPhalanxBlock( array &$data ) {
		$phalanx = Phalanx::newFromId( $data['id'] );

		foreach ( $data as $key => $val ) {
			if ( $key !== 'id' ) {
				$phalanx[$key] = $val;
			}
		}

		$phalanx['type'] = array_reduce( $phalanx['type'], function ( $typeMask, $type ) {
			return $typeMask | $type;
		}, 0 );


		// SOAP should not be allowed to block emails in Phalanx
		if ( ( $phalanx['type'] & Phalanx::TYPE_EMAIL ) && !F::app()->wg->User->isAllowed( 'phalanxemailblock' ) ) {
			return false;
		}

		$multitext = '';
		if ( !empty( $phalanx['multitext'] ) ) {
			$multitext = $phalanx['multitext'];
		}

		unset( $phalanx['multitext'] );

		if ( ( empty( $phalanx['text'] ) && empty( $multitext ) ) || empty( $phalanx['type'] ) ) {
			return false;
		}

		// SUS-2759: If a filter is meant to apply to all languages, the p_lang field must be NULL
		if ( $phalanx['lang'] === 'all' ) {
			$phalanx['lang'] = null;
		}

		if ( $phalanx['expire'] === '' || is_null( $phalanx['expire'] ) ) {
			// don't change expire
			unset( $phalanx['expire'] );
		} elseif ( $phalanx['expire'] != 'infinite' ) {
			$expire = strtotime( $phalanx['expire'] );
			if ( $expire < 0 || $expire === false ) {
				return false;
			}
			$phalanx['expire'] = wfTimestamp( TS_MW, $expire );
		} else {
			$phalanx['expire'] = null ;
		}

		if ( empty( $multitext ) ) {
			/* single mode - insert/update record */
			$data['id'] = $phalanx->save();
			$blockIds = $data['id'] ? [ $data['id'] ] : false;
		} else {
			$bulkdata = explode( "\n", $multitext );
			$targets = [];

			foreach ( $bulkdata as $bulkrow ) {
				$bulkrow = trim( $bulkrow );
				if ( $bulkrow !== '' ) {
					$targets[] = $bulkrow;
				}
			}

			// SUS-1207: Insert Phalanx bulk filters in single write operation
			$blockIds = $phalanx->insertBulkFilter( $targets );
		}

		if ( !empty( $blockIds ) ) {
			static::notifyPhalanxService( $blockIds );
			return true;
		}

		return false;
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

		$phalanx = Phalanx::newFromId( $id );

		// SOAP should not be allowed to delete email blocks in Phalanx
		if ( ( $phalanx['type'] & Phalanx::TYPE_EMAIL ) && !F::app()->wg->User->isAllowed( 'phalanxemailblock' ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$id = $phalanx->delete();
		if ( $id ) {
			static::notifyPhalanxService( [ $id ] );
			return true;
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

	public static function notifyPhalanxService( array $changedBlockIds ) {
		self::getRabbitConnection()->publish( self::ROUTING_KEY, implode( ",", $changedBlockIds ) );
	}

	/**
	 * Make block ID more visible in user block message (BAC-536)
	 *
	 * @param array $permErrors
	 * @param string $action
	 * @return bool true
	 */
	static public function onAfterFormatPermissionsErrorMessage( Array &$permErrors, $action ) {
		foreach ( $permErrors as &$error ) {
			if ( isset( $error[5] ) && is_numeric( $error[5] ) ) {
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
	static public function onGetBlockedStatus( User $user, $shouldLogBlockInStats = false, $global = true ) {
		if ( ! $global ) {
			return true;
		}

		global $wgRequest, $wgClientIPHeader;

		// get the client IP using Fastly-generated request header
		$clientIPFromFastly = $wgRequest->getHeader( $wgClientIPHeader );

		if ( !User::isIP( $clientIPFromFastly ) && !$wgRequest->isWikiaInternalRequest() ) {
			$userAgent = $wgRequest->getHeader( 'User-Agent' );
			WikiaLogger::instance()->error( 'Phalanx user IP incorrect', [
				'ip_from_fastly' => $clientIPFromFastly,
				'ip_from_user' => $user->getName(),
				'ip_from_request' => $wgRequest->getIP(),
				// SUS-2008, always log user_agent as string
				'user_agent' => $userAgent ?: '',
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

		if ( $blockedGlobally ) {
			$message = wfMessage( 'phalanx-sp-contributions-blocked-globally' )->text();
			$message = '<div class="' . LogEventsList::WARN_BOX_DIV_CLASS . '">' . $message . '</div>';
			$out->addHTML( $message );
		}

		return !$blockedGlobally; // If blocked globally disable listing local log
	}

	/** @return \Wikia\Rabbit\ConnectionBase */
	protected static function getRabbitConnection() {
		global $wgPhalanxQueue;

		if ( !isset( self::$rabbitConnection ) ) {
			self::$rabbitConnection = new ConnectionBase( $wgPhalanxQueue );
		}

		return self::$rabbitConnection;
	}
}
