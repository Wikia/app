<?php

/**
 * WikiaGlobalVariableMock encapsulates all the necessary steps required
 * to mock a global variable in Mediawiki world.
 *
 * Supports setting both a real global variable and the value in main
 * RequestContext instance.
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class WikiaGlobalVariableMock {

	protected static $contextVariablesMap = array(
		'wgRequest' => 'request',
		'wgTitle' => 'title',
		'wgOut' => 'output',
		'wgUser' => 'user',
		'wgLang' => 'lang',
		'wgSkin' => 'skin',
	);

	protected $variable;
	protected $value;
	protected $contextVariable;

	protected $enabled;
	protected $oldValue;
	protected $oldContextValue;

	/**
	 * @param $variable string Global variable name
	 * @param $value mixed Mocked value
	 */
	public function __construct( $variable, $value ) {
		$this->variable = $variable;
		$this->value = $value;
		$this->enable();
	}

	private function getContextVariable() {
		return !empty(self::$contextVariablesMap[$this->variable])
			? self::$contextVariablesMap[$this->variable] : null;
	}

	/**
	 * Mock the variable
	 */
	public function enable() {
		if ( $this->enabled ) {
			return;
		}

		// set it in main request context
		if ( ($contextVariable = $this->getContextVariable()) ) {
			$context = RequestContext::getMain();
			$refl = new ReflectionObject($context);
			$reflProp = $refl->getProperty($contextVariable);
			$reflProp->setAccessible(true);
			$this->oldContextValue = $reflProp->getValue($context);
			$reflProp->setValue($context,$this->value);
		}

		// set it in global scope
		$exists = array_key_exists( $this->variable, $GLOBALS );
		$this->oldValue = array(
			'exists' => $exists,
			'value' => $exists ? $GLOBALS[$this->variable] : null,
		);
		$GLOBALS[$this->variable] = $this->value;

		$this->enabled = true;
	}

	/**
	 * Revert any changes done to the variable
	 */
	public function disable() {
		if ( !$this->enabled ) {
			return;
		}

		// revert changes in main request context
		if ( ($contextVariable = $this->getContextVariable()) ) {
			$context = RequestContext::getMain();
			$refl = new ReflectionObject($context);
			$reflProp = $refl->getProperty($contextVariable);
			$reflProp->setAccessible(true);
			$reflProp->setValue($context,$this->oldContextValue);
		}

		// set it in global scope
		$exists = $this->oldValue['exists'];
		$oldValue = $this->oldValue['value'];
		if ( $exists ) {
			$GLOBALS[$this->variable] = $oldValue;
		} else {
			unset($GLOBALS[$this->variable]);
		}
	}

}