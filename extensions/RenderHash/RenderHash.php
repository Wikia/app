<?php

$wgHooks['PageRenderingHash'][] = 'renderHashAppend';
$wgRenderHashAppend = '';

/**
 * Hook to append a configured value to the hash, so that parser cache
 * storage can be kept separate for some class of activity.
 *
 * @param string $hash in-out parameter; user's page rendering hash
 * @return bool true to continue, false to abort operation
 */
function renderHashAppend( &$hash ) {
	global $wgRenderHashAppend;
	$hash .= $wgRenderHashAppend;
	return true;
}

