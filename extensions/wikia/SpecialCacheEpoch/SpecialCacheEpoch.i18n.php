<?php

$messages = array();

$messages['en'] = array(
	'cacheepoch-desc' => 'Provides an interface for changing wgCacheEpoch per wiki.',
	'cacheepoch' => 'Cache Epoch interface',
	'cacheepoch-header' => 'Increase wgCacheEpoch',
	'cacheepoch-value' => 'Current value of wgCacheEpoch is "$1". Press the button to set it to current timestamp.',
	'cacheepoch-submit' => 'Update the value',
	'cacheepoch-updated' => 'wgCacheEpoch updated to "$1".',
	'cacheepoch-not-updated' => 'Failed to update wgCacheEpoch.',
	'cacheepoch-wf-reason' => 'Value updated via Special:CacheEpoch',
	'cacheepoch-no-wf' => 'WikiFactory is not enabled on this wiki. Unable to alter wgCacheEpoch.',
);

$messages['qqq'] = array(
	'cacheepoch-desc' => '{{desc}}',
	'cacheepoch-wf-reason' => 'Log message for administrators only. Do not change "Special:CacheEpoch"',
);
