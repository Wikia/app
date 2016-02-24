<?php

/**
 * Implements memcache-based local user blocks
 *
 * Temporary solution used during Uncyclopedia migration to apply user block for short periods (few seconds)
 *
 * @see PLATFORM-1055
 * @author macbre
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'MemcacheUserBlock',
	'description' => 'Implements memcache-based local user blocks',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/MemcacheUserBlock'
);

$wgAutoloadClasses['MemcacheUserBlock'] = __DIR__ . '/MemcacheUserBlock.class.php';

$wgHooks['UserIsBlockedFrom'][] = 'MemcacheUserBlock::onUserIsBlockedFrom';
