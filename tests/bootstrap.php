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

if ( wfIsHHVM() ) {
	function set_new_overload() {
		// No-op
	}
	function unset_new_overload() {
		// No-op
	}
}

if ($wgRunningUnitTests && $wgNoDBUnits) {
	Patchwork\replace( 'wfMsgExt', 'wfMsgExt_orig' );
	Patchwork\replace( 'wfMsgReal', 'wfMsgReal_orig' );
	Patchwork\replace( 'wfGetDB', 'wfGetDB_orig' );
	Patchwork\replace( 'wfMsgExtStub', 'wfMsgExt' );
	Patchwork\replace( 'wfMsgRealStub', 'wfMsgReal' );
	Patchwork\replace( 'wfGetDBStub', 'wfGetDB' );

	$wgMemc = new FakeCache();
	$messageMemc = null;
	$parserMemc = null;

	if ( wfIsHHVM() ) {
		Patchwork\replace( 'Message::toString', function () {
			throw new WikiaException( 'No messaging in unit tests' );
		} );
	}

	set_new_overload('sno_callback');
}

require_once 'Zend/Exception.php';
require_once 'Zend/Config.php';
require_once 'Zend/Config/Exception.php';
