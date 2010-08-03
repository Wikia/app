<?php

/**
 * Trusted hosts file in CDB format.
 * The file can be generated using generate.php
 *
 * You can download Wikimedia's trusted-xff.cdb from:
 *
 * http://noc.wikimedia.org/conf/trusted-xff.cdb
 *
 * For details, see http://meta.wikimedia.org/wiki/XFF_project
 */
$wgTrustedXffFile = dirname(__FILE__).'/trusted-xff.cdb';


/** Registration */
$wgExtensionCredits['other'][] = array(
	'name'           => 'TrustedXFF',
	'svn-date'       => '$LastChangedDate: 2008-12-15 15:30:51 +0100 (pon, 15 gru 2008) $',
	'svn-revision'   => '$LastChangedRevision: 44621 $',
	'description'    => 'Handling of trusted proxy addresses (XFF)',
	'descriptionmsg' => 'trustedxff-desc',
	'author'         => 'Tim Starling',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:TrustedXFF',
);
$wgExtensionMessagesFiles['TrustedXFF'] = dirname(__FILE__) . '/TrustedXFF.i18n.php';
$wgHooks['IsTrustedProxy'][] = 'TrustedXFF::onIsTrustedProxy';

class TrustedXFF {
	static $instance;

	var $cdb;

	static function onIsTrustedProxy( &$ip, &$trusted ) {
		// Don't want to override hosts that are already trusted
		if ( !$trusted ) {
			$trusted = self::getInstance()->isTrusted( $ip );
		}
		return true;
	}

	static function getInstance() {
		if ( !self::$instance ) {
			self::$instance = new TrustedXFF;
		}
		return self::$instance;
	}

	function getCdbHandle() {
		if ( !$this->cdb ) {
			global $wgTrustedXffFile;
			if ( !file_exists( $wgTrustedXffFile ) ) {
				throw new MWException( 'TrustedXFF: hosts file missing. You need to download it.' );
			}
			if ( !function_exists( 'dba_open' ) ) {
				throw new MWException( 'The TrustedXFF extension needs PHP\'s DBA module to work.' );
			}
			$this->cdb = dba_open( $wgTrustedXffFile, 'r-', 'cdb' );
		}
		return $this->cdb;
	}

	function isTrusted( $ip ) {
		$cdb = $this->getCdbHandle();
		// Try single host
		$hex = IP::toHex( $ip );
		$data = dba_fetch( $hex, $cdb );
		if ( $data ) {
			return true;
		}
		// TODO: IPv6 prefixes which aren't feasible to expand
		return false;
	}
}

