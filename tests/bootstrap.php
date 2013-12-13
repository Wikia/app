<?php
$wgRunningUnitTests = true; // don't include DevBoxSettings when running unit tests
$wgDevelEnvironment = true;
require_once __DIR__ . '/../maintenance/commandLine.inc';

function wfMsgExtStub() {
	return '';
}
function wfMsgRealStub() {
	return '';
}
function wfGetDBStub() {
	throw new WikiaException('No DB in unit tests');
}

if ($wgRunningUnitTests && $wgNoDBUnits) {
	rename_function('wfMsgExt', 'wfMsgExt_orig');
	rename_function('wfMsgReal', 'wfMsgReal_orig');
	rename_function('wfGetDB', 'wfGetDB_orig');
	rename_function('wfMsgExtStub', 'wfMsgExt');
	rename_function('wfMsgRealStub', 'wfMsgReal');
	rename_function('wfGetDBStub', 'wfGetDB');
}

require_once 'Zend/Exception.php';
require_once 'Zend/Config.php';
require_once 'Zend/Config/Exception.php';
