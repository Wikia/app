<?php
#
# Set of classes representing various types of template parameters 
#
require_once( 'Util.php' );

abstract class POMTemplateParameter
{
	abstract function toString();

	static function parse( $text )
	{

		$pair = explode( '=', $text, 2 );

		# if it's a name/value pair, create POMTemplateNamedParameter, otherwise, create POMTemplateNumberedParameter
		# if neither can be created, return POMTemplateInvalidParameter
		if ( count( $pair ) > 1 )
		{
			$name = $pair[0];
			$value = $pair[1];

			$name_triple = new POMUtilTrimTriple( $name );

			if ( strlen( $name_triple->trimmed ) <= 0 )
			{
				# ignore parameters with empty name
				return new POMTemplateInvalidParameter( $text );
			}

			return new POMTemplateNamedParameter( $name, $value );
		}
		else
		{
			return new POMTemplateNumberedParameter( $text );
		}
	}
}

class POMTemplateNamedParameter extends POMTemplateParameter
{
	private $name_triple;
	private $value_triple;

	function __construct( $name, $value )
	{
		$this->name_triple = new POMUtilTrimTriple( $name );
		$this->value_triple = new POMUtilTrimTriple( $value );
	}

	function update( $name, $value, $override_name_spacing = false, $override_value_spacing = false )
	{
		$name_triple = new POMUtilTrimTriple( $name );
		$value_triple = new POMUtilTrimTriple( $value );

		if ( $override_name_spacing )
		{
			$this->name_triple = $name_triple;
		}
		else
		{
			$this->name_triple->trimmed = $name_triple->trimmed;
		}

		if ( $override_value_spacing )
		{
			$this->value_triple = $value_triple;
		}
		else
		{
			$this->value_triple->trimmed = $value_triple->trimmed;
		}
	}

	function getName()
	{
		return $this->name_triple->trimmed;
	}

	function getValue()
	{
		return $this->value_triple->trimmed;
	}

	function getNameTriple()
	{
		return $this->name_triple;
	}

	function getValueTriple()
	{
		return $this->value_triple;
	}

	function toString()
	{
		return $this->name_triple->toString() . '=' . $this->value_triple->toString();
	}
}


class POMTemplateNumberedParameter extends POMTemplateParameter
{
	private $value_triple;

	function __construct( $value )
	{
		$this->value_triple = new POMUtilTrimTriple( $value );
	}

	function update( $value, $override_value_spacing = false )
	{
		$value_triple = new POMUtilTrimTriple( $value );

		if ( $override_value_spacing )
		{
			$this->value_triple = $value_triple;
		}
		else
		{
			$this->value_triple->trimmed = $value_triple->trimmed;
		}
	}

	function getName()
	{
		return '';
	}
	
	function getValue()
	{
		return $this->value_triple->trimmed;
	}

	function getValueTriple()
	{
		return $this->value_triple;
	}

	function toString()
	{
		return $this->value_triple->toString();
	}

}

/**
 * Represents parameters that need to be preserved, but not parsed
 */
class POMTemplateInvalidParameter extends POMTemplateParameter
{
	private $text;

	function __construct( $text )
	{
		$this->text = $text;
	}

	function toString()
	{
		return $this->text;
	}
}
