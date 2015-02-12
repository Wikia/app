<?php
abstract class UserWikisFilterDecorator extends UserWikisFilter {
	protected $filter;

	public function __construct( UserWikisFilter $filter ) {
		$this->filter = $filter;
	}

}
