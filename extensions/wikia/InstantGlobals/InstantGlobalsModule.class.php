<?php
/**
 * Implements InstantGlobals: fast changing WF variables in JavaScript
 *
 * Emits Wikia.InstantGlobals key / value object.
 *
 * @author macbre
 */
class InstantGlobalsModule extends ResourceLoaderModule {

	/**
	 * Get variables values
	 *
	 * @return object key / value list variables
	 */
	private function getVariablesValues() {
		$ret = [];

		$variables = [];

		wfRunHooks( 'InstantGlobalsGetVariables', [ &$variables ] );

		foreach($variables as $name) {
			$value = WikiFactory::getVarValueByName($name, Wikia::COMMUNITY_WIKI_ID);

			// don't emit "falsy" values
			if (!empty($value)) {
				$ret[$name] = $value;
			}
		}

		return (object) $ret;
	}

	public function getScript(ResourceLoaderContext $context) {
		$variables = $this->getVariablesValues();

		return sprintf('Wikia.InstantGlobals = %s', json_encode($variables));
	}

	/**
	 * @return bool
	 */
	public function supportsURLLoading() {
		return false;
	}

	/**
	 * Load this module from the shared domain
	 *
	 * @return String
	 */
	public function getSource() {
		return 'common';
	}
}
