<?php
$wgRunningUnitTests = true; // don't include DevBoxSettings when running unit tests
$wgDevelEnvironment = true;

class FakeCache {
	public function __call($a, $b) {
		return '';
	}
}

require_once __DIR__ . '/../maintenance/commandLine.inc';

class MessageStub extends Message {
	public function toString() {
		throw new WikiaException('No messaging in unit tests');
	}
}

function wfMsgExtStub() {
	return '';
}
function wfMsgRealStub() {
	return '';
}
function wfGetDBStub() {
	throw new WikiaException('No DB in unit tests');
}

function sno_callback($className) {
	if ($className == 'Message') {
		$className = 'MessageStub';
	}

	return $className;
}

if ($wgRunningUnitTests && $wgNoDBUnits) {
	rename_function('wfMsgExt', 'wfMsgExt_orig');
	rename_function('wfMsgReal', 'wfMsgReal_orig');
	rename_function('wfGetDB', 'wfGetDB_orig');
	rename_function('wfMsgExtStub', 'wfMsgExt');
	rename_function('wfMsgRealStub', 'wfMsgReal');
	rename_function('wfGetDBStub', 'wfGetDB');

	$wgMemc = new FakeCache();
	$messageMemc = null;
	$parserMemc = null;

	set_new_overload('sno_callback');
}

require_once 'Zend/Exception.php';
require_once 'Zend/Config.php';
require_once 'Zend/Config/Exception.php';
