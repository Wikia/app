<?php

class IpAnonymizer {
	public const NON_ROUTABLE_IPV6 = '::';

	public function anonymizeIp( string $ip ): void {
		$dbw = wfGetDB( DB_MASTER );
		$this->updateTable( $dbw, 'revision', 'rev_user_text', $ip );
		$this->updateTable( $dbw, 'recentchanges', 'rc_user_text', $ip );
		$this->updateTable( $dbw, 'recentchanges', 'rc_ip_bin', $ip, [], true );
		$this->updateTable( $dbw, 'logging', 'log_user_text', $ip );
		$this->updateTable( $dbw, 'archive', 'ar_user_text', $ip );
		$this->updateTable( $dbw, 'filearchive', 'fa_user_text', $ip );
		$this->updateTable( $dbw, 'image', 'img_user_text', $ip );
		$this->updateTable( $dbw, 'oldimage', 'oi_user_text', $ip );
		$this->updateTable( $dbw, 'ipblocks', 'ipb_address', $ip );
		$this->updateTable( $dbw, 'abuse_filter_log', 'afl_user_text', $ip );
		$this->updateTable( $dbw, 'abuse_filter_log', 'afl_ip', $ip );
		$this->updateTable( $dbw, 'cu_log', 'cul_target_text', $ip );
		$this->updateTable( $dbw, 'cu_changes', 'cuc_user_text', $ip );
		$this->updateTable( $dbw, 'cu_changes', 'cuc_ip', $ip );
		$this->updateTable( $dbw, 'recentchanges', 'rc_title', $ip, [ 'rc_log_type' => [ 'block', 'rights', 'phalanx' ] ] );
		$this->updateTable( $dbw, 'logging', 'log_title', $ip, [ 'log_type' => [ 'block', 'rights', 'phalanx' ] ] );
		if ( $dbw->tableExists( 'cu_changes' ) && $dbw->fieldExists( 'cu_changes', 'cuc_ip_hex' ) ) {
			$dbw->update(
				'cu_changes',
				['cuc_ip_hex' => IP::toHex( self::NON_ROUTABLE_IPV6 ) ],
				[ 'cuc_ip_hex' => IP::toHex( $ip ) ]
			);
		}
	}

	private function updateTable( DatabaseMysqli $dbw,
								  string $table,
								  string $column,
								  string $ip,
								  array $conds = [],
								  bool $binaryColumn = false ): void {
		$ipForCheck = $ip;
		$replacement = self::NON_ROUTABLE_IPV6;

		if ( $binaryColumn ) {
			$ipForCheck = inet_pton( $ip );
			$replacement = inet_pton( self::NON_ROUTABLE_IPV6 );
		}

		if ( $dbw->tableExists( $table ) && $dbw->fieldExists( $table, $column ) ) {
			$conds[$column] = $ipForCheck;
			$dbw->update(
				$table,
				[$column => $replacement],
				$conds
			);
		}
	}
}
