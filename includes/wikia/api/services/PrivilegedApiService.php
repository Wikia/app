<?php
class PrivilegedApiService {
	protected $privileged = [
		'TvApiController' => true,
		'SearchApiController' => [
			'getCombined' => true
		]
	];

	protected function isPrivileged( $controller, $action ){

		if(isset($this->privileged[$controller])){
			$actions = $this->privileged[$controller];
			if(is_array($actions))
			{
				return isset($actions[$action]) && $actions[$action] === true;
			}else{
				return $actions === true;
			}
		}
		return false;
	}

	public function canUse($controller, $action){
		global $wgPrivileged;

	}

	public function checkUse($controller, $action )
	{
		if(! $this->canUse($controller, $action))
		{
			throw new NotFoundApiException();
		}
	}
}