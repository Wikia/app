<?php
/* SNMPquery.php - Fri Dec  4 00:28:58 PST 2009, rururudy
 * Beerware (2009)
 *
 * Example inline:
 *  <snmp mode=get host=4.2.2.1 community=public oid=.1.3.6.1.2.1.1.3.0>Uptime: </snmp>
 *
 * Example in a template where the IP is a variable:
 *    {{ #snmpget:  {{{ip}}}|{{{community}}}|.1.3.6.1.2.1.1.3.0| '''Uptime:''' }}
 *    {{ #snmpwalk: {{{ip}}}|{{{community}}}|.1.3.6.1.4.1.14988.1.1.1.1.1.4|<br>'''Signal Strength:'''|dBm}}
 *
 * Note:  All my queries are on a fast network, so I set the time out to 50ms... if you have
 * a bunch of queries on one page and one SNMPd server is down, the page will take forever to
 * load if you don't keep that timeout low.... I found 20ms was too short for some servers.
 *
 * Developed for MonkeyBrains.net
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgExtensionCredits['parserhook'][] = array(
	'path'        => __FILE__,
	'name'        => 'SNMPquery',
	'author'      => 'Rudy Rucker, Jr.',
	'url'         => 'https://www.mediawiki.org/wiki/Extension:SNMPquery',
	'descriptionmsg' => 'snmpquery-desc',
	'version'     => '0.1.1',
);

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['SNMPquery'] = $dir . '/SNMPquery.i18n.php';
$wgExtensionMessagesFiles['SNMPqueryMagic'] = $dir . '/SNMPquery.i18n.magic.php';

# Define a setup function
$wgHooks['ParserFirstCallInit'][] = 'SNMP_Setup';

function SNMP_Setup() {
	global $wgParser;
	# Set a function hook associating the "example" magic word with our function
	$wgParser->setFunctionHook( 'snmpget', 'SNMPget_Render' );
	$wgParser->setFunctionHook( 'snmpwalk', 'SNMPwalk_Render' );
	$wgParser->setHook( 'snmp', 'SNMP_Tag' );
	return true;
}

function SNMPwalk_Render( &$parser, $snmphost = '127.0.0.1', $com = 'public',
							$snmpoid = 'SNMPv2-SMI::mib-2.1.6.0', $prefix, $suffix ) {
	$arr = snmpwalk( $snmphost, $com, $snmpoid, 50000 );
	$result = '';
	foreach ( $arr as $value ) {
		if ( isset( $prefix ) ) {
			$result .= "$prefix ";
		}
		$result .= clean_Result( $value ) . " ";
		if ( isset( $suffix ) ) {
			$result .= $suffix;
		}
	}
	return $result;
}

function SNMPget_Render( &$parser, $snmphost = '127.0.0.1', $com = 'public',
							$snmpoid = 'SNMPv2-SMI::mib-2.1.6.0', $prefix = '' ) {
	$result = snmpget( $snmphost, $com, $snmpoid, 50000 );
	if ( !$result ) {
		return false;
	}
	return ( "$prefix " . clean_Result( $result ) );
}

function clean_Result( $snmpvalue ) {
	if ( $snmpvalue ) {
		$snmpvalue = preg_replace( '/STRING: "(.*)"/', '${1}', $snmpvalue );
		$snmpvalue = preg_replace( '/Timeticks: \((\d+)\) (.*)/', '${2}', $snmpvalue );
		$snmpvalue = preg_replace( '/Gauge: (.*)$/', '${1}', $snmpvalue );
		$snmpvalue = preg_replace( '/INTEGER: (.*)$/', '${1}', $snmpvalue );
		return $snmpvalue;
	}
	return false;
}

/* doesn't work well for templates, eg <snmp host="{{{ip}}}" />  */
function SNMP_Tag ( $text, $args, $parser ) {
	$snmphost = '127.0.0.1';
	$com = 'public';
	$snmpoid = 'system.SysContact.0';
	$mode = 'get';
	foreach ( $args as $name => $value ) {
		if ( $name == 'host' ) {
			$snmphost = $value;
		} elseif ( $name == 'oid' ) {
			$snmpoid = $value;
		} elseif ( $name == 'community' ) {
			$com = $value;
		} elseif ( $name == 'mode' ) {
			$mode = $value;
		}
	}
	if ( $mode == 'walk' ) {
		return SNMPwalk_Render( $parser, $snmphost, $com, $snmpoid, $text );
	} else {
		return SNMPget_Render( $parser, $snmphost, $com, $snmpoid, $text );
	}
}
