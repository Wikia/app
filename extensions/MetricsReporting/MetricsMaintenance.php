<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

abstract class MetricsMaintenance extends Maintenance {
	private $db;

	/**
	 * @return DatabaseBase
	 */
	protected function getDB() {
		if ( is_null( $this->db ) ) {
			global $wgMetricsDBserver, $wgMetricsDBname, $wgMetricsDBuser,
				$wgMetricsDBpassword, $wgMetricsDBtype, $wgMetricsDBprefix;
			$this->db = DatabaseBase::factory( $wgMetricsDBtype,
				array(
					'host' => $wgMetricsDBserver,
					'user' => $wgMetricsDBuser,
					'password' => $wgMetricsDBpassword,
					'dbname' => $wgMetricsDBname,
					'tablePrefix' => $wgMetricsDBprefix,
				)
			);
			//$this->db->query( "SET names utf8" );
		}
		return $this->db;
	}
}
