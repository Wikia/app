<?php

/**
 * Class for the 'describe' parser hooks.
 *
 * @since 0.4.3
 *
 * @file Validator_Describe.php
 * @ingroup Validator
 *
 * @licence GNU GPL v2+
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ValidatorDescribe extends ParserHook {
	/**
	 * Field to store the value of the language parameter.
	 *
	 * @since 0.4.10
	 *
	 * @var string
	 */
	protected $language;

	/**
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */
	public static function staticInit( Parser &$wgParser ) {
		$className = __CLASS__;
		$instance = new $className();
		return $instance->init( $wgParser );
	}

	/**
	 * Gets the name of the parser hook.
	 * @see ParserHook::getName
	 *
	 * @since 0.4.3
	 *
	 * @return string
	 */
	protected function getName() {
		return 'describe';
	}

	/**
	 * Returns an array containing the parameter info.
	 * @see ParserHook::getParameterInfo
	 *
	 * @since 0.4.3
	 *
	 * @return array of Parameter
	 */
	protected function getParameterInfo( $type ) {
		$params = array();

		$params['hooks'] = new ListParameter( 'hooks' );
		$params['hooks']->setDefault( array_keys( ParserHook::getRegisteredParserHooks() ) );
		$params['hooks']->setMessage( 'validator-describe-par-hooks' );
		$params['hooks']->addAliases( 'hook' );

		$params['pre'] = new Parameter( 'pre', Parameter::TYPE_BOOLEAN );
		$params['pre']->setDefault( 'off' );
		$params['pre']->setMessage( 'validator-describe-par-pre' );

		$params['language'] = new Parameter( 'language' );
		$params['language']->setDefault( $GLOBALS['wgLanguageCode'] );
		$params['language']->setMessage( 'validator-describe-par-language' );

 		return $params;
	}

	/**
	 * Returns the list of default parameters.
	 * @see ParserHook::getDefaultParameters
	 *
	 * @since 0.4.3
	 *
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return array( 'hooks' );
	}

	/**
	 * Renders and returns the output.
	 * @see ParserHook::render
	 *
	 * @since 0.4.3
	 *
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function render( array $parameters ) {
		$this->language = $parameters['language'];

		$parts = array();

		// Loop over the hooks for which the docs should be added.
		foreach ( $parameters['hooks'] as $hookName ) {
			$parserHook = $this->getParserHookInstance( $hookName );

			if ( $parserHook === false ) {
				$parts[] = wfMsgExt( 'validator-describe-notfound', 'parsemag', $hookName );
			}
			else {
				$parts[] = $this->getParserHookDescription( $hookName, $parameters, $parserHook );
			}
		}

		return $this->parseWikitext( implode( "\n\n", $parts ) );
	}

	/**
	 * Returns the wikitext description for a single parser hook.
	 *
	 * @since 0.4.3
	 *
	 * @param string $hookName
	 * @param array $parameters
	 * @param ParserHook $parserHook
	 *
	 * @return string
	 */
	protected function getParserHookDescription( $hookName, array $parameters, ParserHook $parserHook ) {
		global $wgLang;

		$descriptionData = $parserHook->getDescriptionData( ParserHook::TYPE_TAG ); // TODO
		$this->sortParameters( $descriptionData['parameters'], $descriptionData['defaults'] );

		$description =
			( $parameters['pre'] ? '== ' : '<h2>' ) .
			$hookName .
			( $parameters['pre'] ? ' ==' : '</h2>' );

		if ( $parameters['pre'] ) {
			$description .= "\n<!-- " . $this->msg( 'validator-describe-autogen' ) . ' -->';
		}

		$description .= "\n\n";

		if ( $descriptionData['message'] !== false ) {
			$description .= $this->msg( 'validator-describe-descriptionmsg', $this->msg( $descriptionData['message'] ) );
			$description .= "\n\n";
		}
		elseif ( $descriptionData['description'] !== false ) {
			$description .= wfMsgExt( 'validator-describe-descriptionmsg', $descriptionData['description'] );
			$description .= "\n\n";
		}

		if ( count( $descriptionData['names'] ) > 1 ) {
			$aliases = array();

			foreach ( $descriptionData['names'] as $name ) {
				if ( $name != $hookName ) {
					$aliases[] = $name;
				}
			}

			$description .= $this->msg( 'validator-describe-aliases', $wgLang->listToText( $aliases ), count( $aliases ) );
			$description .= "\n\n";
		}

		if ( $parserHook->forTagExtensions || $parserHook->forParserFunctions ) {
			if ( $parserHook->forTagExtensions && $parserHook->forParserFunctions ) {
				$description .= $this->msg( 'validator-describe-bothhooks' );
			}
			elseif ( $parserHook->forTagExtensions ) {
				$description .= $this->msg( 'validator-describe-tagextension' );
			}
			else { // if $parserHook->forParserFunctions
				$description .= $this->msg( 'validator-describe-parserfunction' );
			}

			$description .= "\n\n";
		}

		$description .= $this->getParameterTable( $descriptionData['parameters'], $descriptionData['defaults'], $parameters['pre'] );

		if ( $parserHook->forTagExtensions || $parserHook->forParserFunctions ) {
			$description .= $this->getSyntaxExamples( $hookName, $descriptionData['parameters'], $parserHook, $descriptionData['defaults'], $parameters['pre'] );
		}

		if ( $parameters['pre'] ) {
			$description = '<pre>' . $description . '</pre>';
		}

		return $description;
	}

	/**
	 * Sorts the provided parameters array to match the default parameter order.
	 *
	 * @since 0.4.3
	 *
	 * @param array of Parameter $parameters
	 * @param array of string $defaults
	 */
	protected function sortParameters( array &$parameters, array $defaults ) {
		$sort = array();
		$count = 9000;

		foreach ( $parameters as $parameter ) {
			$position = array_search( $parameter->getName(), $defaults );

			if ( $position === false ) {
				$count++;
				$sort[$count] = $parameter;
			}
			else {
				$sort[$position] = $parameter;
			}
		}

		ksort( $sort );
		$parameters = array_values( $sort );
	}

	/**
	 * Returns the wikitext for some syntax examples.
	 *
	 * @since 0.4.3
	 *
	 * @param string $hookName
	 * @param array $parameters
	 * @param ParserHook $parserHook
	 * @param array $defaults
	 * @param boolean $pre
	 *
	 * @return string
	 */
	protected function getSyntaxExamples( $hookName, array $parameters, ParserHook $parserHook, array $defaults, $pre ) {
		$result = "\n\n" .
			( $pre ? '=== ' : '<h3>' ) .
			wfMsg( 'validator-describe-syntax' ) .
			( $pre ? ' ===' : '</h3>' );

		$params = array();
		$requiredParams = array();
		$plainParams = array();

		foreach ( $parameters as $parameter ) {
			$params[$parameter->getName()] = '{' . $parameter->getTypeMessage() . '}';
			$plainParams[$parameter->getName()] = $parameter->getTypeMessage();

			if ( $parameter->isRequired() ) {
				$requiredParams[$parameter->getName()] = '{' . $parameter->getTypeMessage() . '}';
			}
		}

		$preOpen = $pre ? '&lt;pre&gt;' : '<pre>';
		$preClose = $pre ? '&lt;/pre&gt;' : '</pre>';

		if ( $parserHook->forTagExtensions ) {
			$result .= "\n\n'''" . $this->msg( 'validator-describe-tagmin' ) . "'''\n\n";

			$result .= "$preOpen<nowiki>\n" . Xml::element(
				$hookName,
				$requiredParams
			) . "\n</nowiki>$preClose";

			$result .= "\n\n'''" . $this->msg( 'validator-describe-tagmax' ) . "'''\n\n";

			// TODO: multiline when long
			$result .= "$preOpen<nowiki>\n" . Xml::element(
				$hookName,
				$params
			) . "\n</nowiki>$preClose";

			if ( count( $defaults ) > 0 ) {
				$result .= "\n\n'''" . $this->msg( 'validator-describe-tagdefault' ) . "'''\n\n";
				$contents = '';
				foreach ( $plainParams as $name => $type ) {
					$contents = '{' . $name . ', ' . $type . '}';
					break;
				}

				$result .= "$preOpen<nowiki>\n" . Xml::element(
					$hookName,
					array_slice( $params, 1 ),
					$contents
				) . "\n</nowiki>$preClose";
			}
		}

		if ( $parserHook->forParserFunctions ) {
			$result .= "\n\n'''" . $this->msg( 'validator-describe-pfmin' ) . "'''\n\n";

			$result .= "$preOpen<nowiki>\n" .
				$this->buildParserFunctionSyntax( $hookName, $requiredParams )
				. "\n</nowiki>$preClose";

			$result .= "\n\n'''" . $this->msg( 'validator-describe-pfmax' ) . "'''\n\n";

			$result .= "$preOpen<nowiki>\n" .
				$this->buildParserFunctionSyntax( $hookName, $params )
				. "\n</nowiki>$preClose";

			if ( count( $defaults ) > 0 ) {
				$result .= "\n\n'''" . $this->msg( 'validator-describe-pfdefault' ) . "'''\n\n";

				$result .= "$preOpen<nowiki>\n" .
					$this->buildParserFunctionSyntax( $hookName, $plainParams, $defaults )
					. "\n</nowiki>$preClose";
			}
		}

		return $result;
	}

	/**
	 * Builds the wikitext syntax for a parser function.
	 *
	 * @since 0.4.3
	 *
	 * @param string $functionName
	 * @param array $parameters Parameters (keys) and their type (values)
	 * @param array $defaults
	 *
	 * @return string
	 */
	protected function buildParserFunctionSyntax( $functionName, array $parameters, array $defaults = array() ) {
		$arguments = array();

		foreach ( $parameters as $name => $type ) {
			if ( in_array( $name, $defaults ) ) {
				$arguments[] = '{' . $name . ', ' . $type . '}';
			}
			else {
				$arguments[] = "$name=$type";
			}
		}

		$singleLine = count( $arguments ) <= 3;
		$delimiter = $singleLine ? '|' : "\n| ";
		$wrapper = $singleLine ? '' : "\n";

		return "{{#$functionName:$wrapper" . implode( $delimiter, $arguments ) . $wrapper . '}}';
	}

	/**
	 * Returns the wikitext for a table listing the provided parameters.
	 *
	 * @since 0.4.3
	 *
	 * @param array $parameters
	 * @param array $defaults
	 * @param boolean $pre
	 *
	 * @return string
	 */
	protected function getParameterTable( array $parameters, array $defaults, $pre ) {
		$tableRows = array();

		foreach ( $parameters as $parameter ) {
			$tableRows[] = $this->getDescriptionRow( $parameter, $defaults );
		}

		$table = '';

		if ( count( $tableRows ) > 0 ) {
			$tableRows = array_merge( array(
			"! #\n" .
			'!' . $this->msg( 'validator-describe-header-parameter' ) ."\n" .
			'!' . $this->msg( 'validator-describe-header-aliases' ) ."\n" .
			'!' . $this->msg( 'validator-describe-header-type' ) ."\n" .
			'!' . $this->msg( 'validator-describe-header-default' ) ."\n" .
			'!' . $this->msg( 'validator-describe-header-description' )
			), $tableRows );

			$table = implode( "\n|-\n", $tableRows );

			$h3 =
				( $pre ? '=== ' : '<h3>' ) .
				$this->msg( 'validator-describe-parameters' ) .
				( $pre ? ' ===' : '</h3>' );

			$table = "$h3\n\n" .
					'{| class="wikitable sortable"' . "\n" .
					$table .
					"\n|}";
		}

		return $table;
	}

	/**
	 * Returns the wikitext for a table row describing a single parameter.
	 *
	 * @since 0.4.3
	 *
	 * @param IParamDefinition $parameter
	 * @param array $defaults
	 *
	 * @return string
	 */
	protected function getDescriptionRow( IParamDefinition $parameter, array $defaults ) {
		$aliases = $parameter->getAliases();
		$aliases = empty( $aliases ) ?  '-' : implode( ', ', $aliases );

		$description = $parameter->getMessage();
		if ( $description === false ) {
			$description = $parameter->getDescription();
			if ( $description === false ) $description = '-';
		}
		else {
			$description = $this->msg( $description );
		}

		$type = $parameter->getTypeMessage();

		$number = 0;
		$isDefault = false;

		foreach ( $defaults as $default ) {
			$number++;

			if ( $default == $parameter->getName() ) {
				$isDefault = true;
				break;
			}
		}

		$default = $parameter->isRequired() ? "''" . $this->msg( 'validator-describe-required' ) . "''" : $parameter->getDefault();

		if ( is_array( $default ) ) {
			$default = implode( ', ', $default );
		}
		elseif ( is_bool( $default ) ) {
			$default = $default ? 'yes' : 'no';
		}

		if ( $default === '' ) $default = "''" . $this->msg( 'validator-describe-empty' ) . "''";

		if ( !$isDefault ) {
			$number = '-';
		}

		return <<<EOT
| {$number}
| {$parameter->getName()}
| {$aliases}
| {$type}
| {$default}
| {$description}
EOT;
	}

	/**
	 * Returns an instance of the class handling the specified parser hook,
	 * or false if there is none.
	 *
	 * @since 0.4.3
	 *
	 * @param string $parserHookName
	 *
	 * @return mixed ParserHook or false
	 */
	protected function getParserHookInstance( $parserHookName ) {
		$className = ParserHook::getHookClassName( $parserHookName );
		return $className !== false && class_exists( $className ) ? new $className() : false;
	}

	/**
	 * @see ParserHook::getMessage()
	 */
	public function getMessage() {
		return 'validator-describe-description';
	}

	/**
	 * Message function that takes into account the language parameter.
	 *
	 * @since 0.4.10
	 *
	 * @param string $key
	 * @param array $args
	 *
	 * @return string
	 */
	protected function msg() {
		$args = func_get_args();
		$key = array_shift( $args );
		return wfMsgReal( $key, $args, true, $this->language );
	}
}
