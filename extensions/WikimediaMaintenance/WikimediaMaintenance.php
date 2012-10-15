<?php
/*
 * Entry point for WikimediaMaintenance scripts :)
 */

// Detect $IP
$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}

// Require base maintenance class
require_once( "$IP/maintenance/Maintenance.php" );

/**
 * Wikimedia-specific maintenance classes should extend this. This class will
 * override some maintenance setup process to be wmf-specific.
 */
abstract class WikimediaMaintenance extends Maintenance {
	/**
	 * Override the core loadSettings.
	 */
	public function loadSettings() {
		global $IP, $wgNoDBParam, $wgConf, $site, $lang;

		if ( empty( $wgNoDBParam ) ) {
			# Check if we were passed a db name
			if ( isset( $this->mOptions['wiki'] ) ) {
				$db = $this->mOptions['wiki'];
			} else {
				$db = array_shift( $this->mArgs );
			}
			list( $site, $lang ) = $wgConf->siteFromDB( $db );

			# If not, work out the language and site the old way
			if ( is_null( $site ) || is_null( $lang ) ) {
				if ( !$db ) {
					$lang = 'aa';
				} else {
					$lang = $db;
				}
				if ( isset( $this->mArgs[0] ) ) {
					$site = array_shift( $this->mArgs );
				} else {
					$site = 'wikipedia';
				}
			}
		} else {
			$lang = 'aa';
			$site = 'wikipedia';
		}

		putenv( 'wikilang=' . $lang );

		ini_set( 'include_path', ".:$IP:$IP/includes:$IP/languages:$IP/maintenance" );

		if ( $lang == 'test' && $site == 'wikipedia' ) {
			if ( !defined( 'TESTWIKI' ) ) {
				define( 'TESTWIKI', 1 );
			}
		}
		return MWInit::interpretedPath( '../wmf-config/CommonSettings.php' );
	}
}
