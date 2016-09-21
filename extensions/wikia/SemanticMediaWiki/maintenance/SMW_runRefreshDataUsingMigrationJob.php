<?php

// To run this script you must pass wikis by --wikis param separated by |
// Example: --wikis=42|54|67
// All passed wikis need to have SMW extension on
// This 'fake' queue was created to not take over and block all SMW queue.
// SMW_MigrationJob will start another SMW_MigrationJob after finish.

require_once(getenv('MW_INSTALL_PATH') !== false
	? getenv('MW_INSTALL_PATH') . "/maintenance/commandLine.inc"
	: dirname(__FILE__) . '/../../../../maintenance/commandLine.inc');

if (isset($options['wikis'])) {
	$wikis = explode('|', $options['wikis']);
} else {
	print "Cannot start job without wikis (--wikis=1|42|54)!\n---\n";
	exit(1);
}
$wiki = array_shift($wikis);

$task = new SMW_MigrationJob();
(new \Wikia\Tasks\AsyncTaskList())
	->wikiId($wiki)
	->add($task->call('run', $wikis))
	->queue();
