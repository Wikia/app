<?php

class CrosswikiBlock {
	public static function normalizeOptions( $user, &$options ) {
		if( User::isIP( $user ) ) {
			$options['autoblock'] = false;
			$options['noemail'] = false;
		} else {
			$options['anononly'] = false;
		}
	}

	public function __construct( $db = '', $target = '', $proxy = null, $by = null, $expiry = '', $reason = '', $timestamp = '',
	 $autoblock = 0, $options = array(), $id = 0 ) {
		$this->mDb = $db;
		$this->mTarget = $target;
		$this->mProxy = $proxy;
		$this->mBy = $by;
		$this->mExpiry = Block::decodeExpiry( $expiry  );
		$this->mTimestamp = wfTimestamp( TS_MW, $timestamp );
		$this->mReason = $reason;
		$this->mAutoblock = $autoblock;
		$this->mOptions = $options;
		$this->mId = $id;
	}
	
	public static function newFromRow( $row, $db ) {
		$options = array();
		$options['anononly'] = $row->ipb_anon_only;
		$options['nocreate'] = $row->ipb_create_account;
		$options['autoblock'] = $row->ipb_enable_autoblock;
		$options['noemail'] = $row->ipb_block_email;
		return new CrosswikiBlock( $db, $row->ipb_address, null, $row->ipb_by_text, $row->ipb_expiry,
			$row->ipb_reason, $row->ipb_timestamp, $row->ipb_auto, $options, $row->ipb_id );
	}

	public function getDB() {
		return UserRightsProxy::getDB( $this->mDb );
	}

	public function commit() {
		global $wgDBname;
		$dbw = $this->getDB();

		$ipb_id = $dbw->nextSequenceValue('ipblocks_ipb_id_val');
		$values = array(
			'ipb_id' => $ipb_id,
			'ipb_address' => $this->mTarget,
			'ipb_user' => $this->mProxy ? $this->mProxy->getId() : 0,
			'ipb_by' => 0,
			'ipb_by_text' => $this->mBy->getName() . '@' . $wgDBname,
			'ipb_reason' => $this->mReason,
			'ipb_timestamp' => $dbw->timestamp( $this->mTimestamp ),
			'ipb_auto' => $this->mAutoblock,
			'ipb_anon_only' => $this->mOptions['anononly'],
			'ipb_create_account' => $this->mOptions['nocreate'],
			'ipb_enable_autoblock' => $this->mOptions['autoblock'],
			'ipb_expiry' => Block::encodeExpiry( $this->mExpiry, $dbw ),
			'ipb_range_start' => '',
			'ipb_range_end' => '',
			'ipb_deleted'	=> false,
			'ipb_block_email' => $this->mOptions['noemail']
		);
		$dbw->insert( 'ipblocks', $values, __METHOD__, array( 'IGNORE' ) );
		$affected = $dbw->affectedRows();
		$dbw->commit();

		return $affected;
	}
	
	public function remove() {
		$dbw = $this->getDB();

		$dbw->delete( 'ipblocks',
			array( 'ipb_id' => $this->mId ),
			__METHOD__ );
		$affected = $dbw->affectedRows();
		$dbw->commit();

		return $affected;
	}

	public function log( $strexpire ) {
		$logParams = array(
			$strexpire,
			self::formatLogOptions( $this->mOptions ),
		);
		$log = new LogPage( 'block' );
		$log->addEntry( 'block', Title::makeTitleSafe( NS_USER, $this->mTarget . '@' . $this->mDb ),
			  $this->mReason, $logParams );
	}

	public function logUnblock( $reason ) {
		$log = new LogPage( 'block' );
		$log->addEntry( 'unblock', Title::makeTitleSafe( NS_USER, $this->mTarget . '@' . $this->mDb ),
			$reason );
	}

	static function formatLogOptions( $opts ) {
		$r = array();
		if( $opts['anononly'] )
			$r[] = 'anononly';
		if( $opts['nocreate'] )
			$r[] = 'nocreate';
		if( !$opts['autoblock'] )
			$r[] = 'noautoblock';
		if( $opts['noemail'] )
			$r[] = 'blockemail';
		return implode( ',', $r );
	}
	
	static function parseBlockAddress( $addr ) {
		$r = array();
		$bits = explode( '@', $addr, 2 );
		if( count( $bits ) < 2 ) return array( 'error' => 'nowiki' );
		list( $target, $wiki ) = $bits;
		if( !UserRightsProxy::validDatabase( $wiki ) ) {
			return array( 'error' => 'invalidwiki', 'wiki' => $wiki );
		}
		if( preg_match( '/^#[0-9]+$/', $target ) ) {
			return array( 'blockid' => substr( $target, 1 ), 'wiki' => $wiki );
		} elseif( User::isIP( $target ) ) {
			return array( 'ip' => $target, 'wiki' => $wiki );
		} elseif( User::isCreatableName( $target ) ) {
			return array( 'username' => $target, 'wiki' => $wiki );
		} else {
			return array( 'error' => 'invalidusername', 'username' => $target );
		}
	}
	
	static function getBlockRow( $target ) {
		$dbw = UserRightsProxy::getDB( $target['wiki'] );
		$conds = array();
		if( isset( $target['blockid'] ) ) {
			$conds['ipb_id'] = $target['blockid'];
		}
		if( isset( $target['ip'] ) ) {
			$conds['ipb_address'] = $target['ip'];
		}
		if( isset( $target['username'] ) ) {
			$conds['ipb_address'] = $target['username'];
		}
		return $dbw->selectRow( 'ipblocks', '*', $conds, __METHOD__ );
	}
}