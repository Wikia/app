<?php
abstract class UserWikisFilterDecorator extends UserWikisFilter {
	private $filter;

	public function __construct( UserWikisFilter $filter ) {
		$this->filter = $filter;
	}

}
