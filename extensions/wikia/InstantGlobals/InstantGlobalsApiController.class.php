<?php

class InstantGlobalsApiController extends WikiaController {
	/**
	 * @return array
	 */
	public function getNewsAndStoriesVariables() {
		$instantGlobals = $this->getNewsAndStoriesVariablesValues();

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		$this->response->setData( $instantGlobals );
	}

	/**
	 * Get news&stories variables values
	 *
	 * @return object key / value list variables
	 */
	private function getNewsAndStoriesVariablesValues() {
		$ret = [];
		$variables = [];

		Hooks::run( 'InstantGlobalsGetNewsAndStoriesVariables', [&$variables] );

		foreach ( $variables as $name ) {
			$value = WikiFactory::getVarValueByName( $name, Wikia::COMMUNITY_WIKI_ID );

			// don't emit "falsy" values
			if ( !empty( $value ) ) {
				$ret[$name] = $value;
			}
		}

		return $ret;
	}
}
