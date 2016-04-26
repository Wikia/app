<?php
/**
 * We want to make this whole thing as seamless as possible to the
 * end-user. Unfortunately, we can't do _all_ of the work in the class
 * because A) included files are not in global scope, but in the scope
 * of their caller, and B) MediaWiki has way too many globals. So instead
 * we'll kinda fake it, and do the requires() inline. <3 PHP
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @author Chad Horohoe <chad@anyonecanedit.org>
 * @file
 * @ingroup Maintenance
 */

if ( !defined( 'RUN_MAINTENANCE_IF_MAIN' ) ) {
	echo "This file must be included after Maintenance.php\n";
	exit( 1 );
}

$wgMaintenanceStartTime = microtime( true );

// Wasn't included from the file scope, halt execution (probably wanted the class)
// If a class is using commandLine.inc (old school maintenance), they definitely
// cannot be included and will proceed with execution
if( !Maintenance::shouldExecute() && $maintClass != 'CommandLineInc' ) {
	return;
}

if ( !$maintClass || !class_exists( $maintClass ) ) {
	echo "\$maintClass is not set or is set to a non-existent class.\n";
	exit( 1 );
}

// Get an object to start us off
/** @var Maintenance $maintenance */
$maintenance = new $maintClass();

// Basic sanity checks and such
$maintenance->setup();

// We used to call this variable $self, but it was moved
// to $maintenance->mSelf. Keep that here for b/c
$self = $maintenance->getName();

// Detect compiled mode
if ( isset( $_SERVER['MW_COMPILED'] ) ) {
	define( 'MW_COMPILED', 1 );
} else {
	# Get the MWInit class
	require_once( "$IP/includes/Init.php" );
	require_once( "$IP/includes/AutoLoader.php" );
}

# Stub the profiler
require_once( MWInit::compiledPath( 'includes/profiler/Profiler.php' ) );
// Wikia change - begin - use normal profiler
require_once( "$IP/StartProfiler.php" );
// Wikia change - end

// Some other requires
if ( !defined( 'MW_COMPILED' ) ) {
	require_once( "$IP/includes/Defines.php" );
}
# Wikia change - comment out the next line since we include DefaultSettings.php
# in LocalSettings.php
#require_once( MWInit::compiledPath( 'includes/DefaultSettings.php' ) );

if ( defined( 'MW_CONFIG_CALLBACK' ) ) {
	# Use a callback function to configure MediaWiki
	MWFunction::call( MW_CONFIG_CALLBACK );
} else {
	if ( file_exists( "$IP/../wmf-config/wikimedia-mode" ) ) {
		// Load settings, using wikimedia-mode if needed
		// @todo FIXME: Replace this hack with general farm-friendly code
		# @todo FIXME: Wikimedia-specific stuff needs to go away to an ext
		# Maybe a hook?
		global $cluster;
		$cluster = 'pmtpa';
		require( MWInit::interpretedPath( '../wmf-config/wgConf.php' ) );
	}
	// Require the configuration (probably LocalSettings.php)
	require( $maintenance->loadSettings() );
}

// Wikia change - begin - attach sink to the profiler (copied from WebStart.php)
if ( $wgProfiler instanceof Profiler ) {
	if ( empty($wgProfilerSendViaScribe) ) {
		$sink = new ProfilerDataUdpSink();
	} else {
		$sink = new ProfilerDataScribeSink();
	}
	$wgProfiler->addSink( $sink );

	// keep the legacy stream of Mediawiki profiler data via UDP
	if ( ( $wgProfiler instanceof ProfilerSimpleDataCollector ) and !( $sink instanceof ProfilerDataUdpSink ) ) {
		$wgProfiler->addSink( new ProfilerDataUdpSink() );
	}
}
Transaction::setEntryPoint(Transaction::ENTRY_POINT_MAINTENANCE);
Transaction::setAttribute(Transaction::PARAM_MAINTENANCE_SCRIPT, $maintClass);
// Wikia change - end

if ( $maintenance->getDbType() === Maintenance::DB_ADMIN &&
	is_readable( "$IP/AdminSettings.php" ) )
{
	require( MWInit::interpretedPath( 'AdminSettings.php' ) );
}
$maintenance->finalSetup();
// Some last includes
require_once( MWInit::compiledPath( 'includes/Setup.php' ) );

// Much much faster startup than creating a title object
$wgTitle = null;

\Wikia\Logger\WikiaLogger::instance()->info("Maintenance script $maintClass started.");

function getMaintenanceRuntimeStatistics( $exception = null ) {
	global $wgMaintenanceStartTime, $maintenance;

	$logContext = [ ];
	if ( is_callable( [ $maintenance, 'getRuntimeStatistics' ] ) ) {
		$logContext = array_merge( $logContext, $maintenance->getRuntimeStatistics() );
	}
	$logContext['status_bool'] = !$exception;
	$logContext['total_time_float'] = microtime( true ) - $wgMaintenanceStartTime;
	if ( $exception ) {
		$logContext['exception'] = $exception;
	}

	return $logContext;
}

// Do the work
try {
	$maintenance->execute();

	// Potentially debug globals
	$maintenance->globals();

	\Wikia\Logger\WikiaLogger::instance()->info( "Maintenance script $maintClass finished.",
		getMaintenanceRuntimeStatistics() );
} catch ( MWException $mwe ) {
	echo( $mwe->getText() );
	\Wikia\Logger\WikiaLogger::instance()->info( "Maintenance script $maintClass failed..",
		getMaintenanceRuntimeStatistics( $mwe ) );
	exit( 1 );
} catch ( Exception $e ) {
	\Wikia\Logger\WikiaLogger::instance()->info( "Maintenance script $maintClass failed.",
		getMaintenanceRuntimeStatistics( $e ) );
}

wfRunHooks( 'RestInPeace' ); // Wikia change - @author macbre
