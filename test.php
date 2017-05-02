<?php
class FooBar {
	public function test() {
		global $wgOut;

		$wgOut->addHTML('czesc');
	}
}
