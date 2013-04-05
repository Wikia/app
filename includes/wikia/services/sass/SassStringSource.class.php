<?php

class SassStringSource extends SassSource {

	public function __construct( SassSourceContext $context, $source, $modifiedTime, $humanName = null ) {
		parent::__construct( $context );
		$this->rawSource = $source;
		$this->rawModifiedTime = $modifiedTime;
		$this->humanName = $humanName;
	}

}