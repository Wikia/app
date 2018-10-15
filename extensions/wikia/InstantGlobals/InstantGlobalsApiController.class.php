<?php

class InstantGlobalsApiController extends WikiaController {

	const NEWS_AND_STORIES_HOOK = 'InstantGlobalsGetNewsAndStoriesVariables';
	const FANDOM_CREATOR_HOOK = 'InstantGlobalsGetFandomCreatorVariables';

	/**
	 * @return array
	 */
	public function getNewsAndStoriesVariables() {
		$instantGlobals = $this->getInstantGlobals(self::NEWS_AND_STORIES_HOOK);

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		$this->response->setData( $instantGlobals );
	}

	public function getFandomCreatorVariables() {
		$instantGlobals = $this->getInstantGlobals(self::FANDOM_CREATOR_HOOK);

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		$this->response->setData( $instantGlobals );
	}

	/**
	 * Get variables values
	 *
	 * @return array key / value list variables
	 */
	private function getInstantGlobals(string $hookName) {
		$ret = [];
		$variables = [];

		Hooks::run( $hookName, [&$variables] );

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
