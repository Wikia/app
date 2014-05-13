<?php
/**
 * Implements InstantGlobals: fast changing WF variables in JavaScript
 *
 * @author macbre
 */
class InstantGlobalsModule extends ResourceLoaderModule {

	// list of WikiFactory variables which values should be taken from Community Wiki
	private $variables = [
		'wgHighValueCountries',
		'wgAmazonDirectTargetedBuyCountries',
	];

	/**
	 * Get variables values
	 *
	 * @return array
	 */
	private function getVariablesValues() {
		$ret = [];

		foreach($this->variables as $name) {
			$value = WikiFactory::getVarValueByName($name, Wikia::COMMUNITY_WIKI_ID);

			// don't emit "falsy" values
			if (!empty($value)) {
				$ret[$name] = $value;
			}
		}

		return $ret;
	}

	public function getScript(ResourceLoaderContext $context) {
		$items = [];

		foreach($this->getVariablesValues() as $name => $value) {
			$encValue = Xml::encodeJsVar( $value );
			$items[] = "$name=$encValue";
		}

		return 'var ' . join(',', $items);
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
