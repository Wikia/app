<?php

class WikiVideoPage extends WikiPage {
	public function getActionOverrides() {
		return array( 'revert' => 'RevertVideoAction' );
	}

}
