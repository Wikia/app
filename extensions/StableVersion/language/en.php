<?php
/**
 * English language file for the 'StableVersion' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
			'stableversion_this_is_stable' => 'This is the stable version of this article. You can also look at the <a href="$1">latest draft version</a>.',
			'stableversion_this_is_stable_nourl' => 'This is the stable version of this article.',
			'stableversion_this_is_draft_no_stable' => 'You are looking at a draft version of this article; there is no stable version of this article yet.',
			'stableversion_this_is_draft' => 'This is a draft version of this article. You can also look at the <a href="$1">stable version</a>.',
			'stableversion_this_is_old' => 'This is an old version of this article. You can also look at the <a href="$1">stable version</a>, or the <a href="$2">latest draft version</a>.',
			'stableversion_reset_stable_version' => 'Click <a href="$1">here</a> to remove this as stable version!',
			'stableversion_set_stable_version' => 'Click <a href="$1">here</a> to set this as stable version!',
			'stableversion_set_ok' => 'The stable version has been successfully set.',
			'stableversion_reset_ok' => 'The stable version has been successfully removed. This article has no stable version right now.',
			'stableversion_return' => 'Return to <a href="$1">$2</a>',
			
			'stableversion_reset_log' => 'Stable version has been removed.',
			'stableversion_logpage' => 'Stable version log',
			'stableversion_logpagetext' => 'This is a log of changes to stable versions',
			'stableversion_logentry' => '',
			'stableversion_log' => 'Revision #$1 is now the stable version.',
			'stableversion_before_no' => 'There was no stable revision before.',
			'stableversion_before_yes' => 'The last stable revision was #$1.',
			'stableversion_this_is_stable_and_current' => 'This is both the stable and the latest version.',
			'stableversion_noset_directional' => '(Cannot set or reset in directional history)',
	)
);

