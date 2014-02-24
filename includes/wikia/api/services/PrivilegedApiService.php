<?php
class PrivilegedApiService {
	protected $privileged = [
		'TvApiController' => true,
		'SearchApiController' => [
			'getCombined' => true
		]
	];

	public function isPrivileged( $controller, $action )
	{
		//if(isset($this->privileged[]))
	}

	public function checkPrivileged()
	{

	}
}