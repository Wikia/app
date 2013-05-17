<?php
/**
 * @author Sean Colombo
 * @date 20111005
 *
 * Profiler for the API Gate system.
 *
 * NOTE: The "wf" prefix on the function names might seem out of place. The reason
 * for this is that I'm not planning on writing a profiler right away (since MediaWiki
 * has one built in already).
 *
 * TODO: Write profiler for API Gate? (doItLater's public codebase has a decent one)
 *
 * TODO: Once API Gate has its own profiler, refactor the wfProfile* calls to be agProfile* or
 * something else with more consistent naming and just have a MediaWiki-specific class that extends/overrides
 * the ApiGate profiler (that should be a good example of how other systems can do the same).
 * 
 */
 
if ( !function_exists( 'wfProfileIn' ) ) {
	function wfProfileIn( $methodName ) {
	}
}
if ( !function_exists( 'wfProfileOut' ) ) {
	function wfProfileOut( $methodName ) {
	}
}
