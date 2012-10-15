<?php
#
# Template class represents templates
#
require_once( 'Util.php' );
require_once( 'TemplateParameter.php' );

class POMTemplate extends POMElement
{
	protected $title_triple;

	protected $parameters = array();

	public function POMTemplate( $text )
	{
		$this->children = null; // forcefully ignore children

		# Remove curly braces at the beginning and at the end
		$text = substr( $text, 2, strlen( $text ) - 4 );

		# Split by pipe
		$parts = explode( '|', $text );

		# Check if this is a function call in the form #name:
		$first_part = array_shift( $parts );
		if ( strpos( trim( $first_part ), "#" ) == 0 )
			if ( strpos( $first_part, ":" ) !== False ) {
				$splitted = explode( ':', $first_part, 2 );
				if ( count( $splitted ) == 2 ) {
					$first_part = $splitted[0];
					array_unshift( $parts, $splitted[1] );
				}

			}

		$this->title_triple = new POMUtilTrimTriple( $first_part );

		foreach ( $parts as $part )
		{
			$this->parameters[] = POMTemplateParameter::parse( $part );
		}
	}

	public function getTitle()
	{
		return $this->title_triple->trimmed;
	}

	public function getParametersCount() {
		return count( $this->parameters );
	}

	public function getParameterName( $number ) {
		if ( $number < 0 ) return "";
		if ( $number > count( $this->parameters ) - 1 ) return "";
		$parameter = $this->parameters[$number];
		if ( is_a( $parameter, 'POMTemplateNamedParameter' ) )
			return $parameter->getName();
		else
			return "";
	}

	public function removeParameterByNumber( $number ) {
		if ( $number < 0 ) return;
		if ( $number > count( $this->parameters ) - 1 ) return;
		unset( $this->parameters[$number] );
		$this->parameters = array_values( $this->parameters );
	}

	public function getNumberByName( $name ) {
		$trimmed_name = trim( $name );
		if ( strlen( $trimmed_name ) == 0 )
			throw new WrongParameterNameException( 'Can\'t get parameter with no name' );

		for ( $i = 0; $i < count( $this->parameters ); $i++ ) {
			$parameter = $this->parameters[$i];
			if ( $parameter->getName() == $trimmed_name ) return $i;
		}
	}

	public function getParameterByNumber( $number ) {
		if ( $number < 0 ) return "";
		if ( $number > count( $this->parameters ) - 1 ) return "";
		$parameter = $this->parameters[$number];
		return $parameter->getValue();
	}

	public function getParameter( $name )
	{
		$trimmed_name = trim( $name );
		if ( strlen( $trimmed_name ) == 0 )
		{
			throw new WrongParameterNameException( 'Can\'t get parameter with no name' );
		}

		$number = 1;
		for ( $i = 0; $i < count( $this->parameters ); $i++ )
		{
			$parameter = $this->parameters[$i];

			# checking this in runtime to make sure we cover all post-parsing updates to the list
			if ( is_a( $parameter, 'POMTemplateNamedParameter' ) )
			{
				if ( $parameter->getName() == $trimmed_name )
				{
					return $parameter->getValue();
				}
			}
			elseif ( is_a( $parameter, 'POMTemplateNumberedParameter' ) )
			{
				if ( $number == $trimmed_name )
				{
					return $parameter->getValue();
				}
				$number++;
			}
		}

		return null; # none matched
	}

	public function addParameter( $name, $value ) {
		if ( strlen( trim( $name ) ) == 0 )
			throw new WrongParameterNameException( "Can't set parameter with no name" );

		# add parameter to parameters array
		$this->parameters[] = new POMTemplateNamedParameter( $name, $value );
	}

	public function setParameter( $name, $value,
		$ignore_name_spacing = true,
		$ignore_value_spacing = true,
		$override_name_spacing = false, # when original value exists
		$override_value_spacing = false	# when original value exists
		)
	{
		$trimmed_name = trim( $name );
		if ( strlen( $trimmed_name ) == 0 )
		{
			throw new WrongParameterNameException( "Can't set parameter with no name" );
		}

		if ( $ignore_name_spacing )
		{
			$name = $trimmed_name;
		}

		if ( $ignore_value_spacing )
		{
			$value = trim( $value );
		}

		# first go through named parameters and see if name matches
		for ( $i = 0; $i < count( $this->parameters ); $i++ )
		{
			if ( is_a( $this->parameters[$i], 'POMTemplateNamedParameter' ) &&
				$this->parameters[$i]->getName() == $trimmed_name )
			{
				$this->parameters[$i]->update( $name, $value, $override_name_spacing, $override_value_spacing );
				return;
			}
		}

		# then go through numbered parameters and see if parameter with this number exists
		$number = 1;
		for ( $i = 0; $i < count( $this->parameters ); $i++ )
		{
			if ( is_a( $this->parameters[$i], 'POMTemplateNumberedParameter' ) )
			{
				if ( $number == $trimmed_name )
				{
					$this->parameters[$i]->update( $value, $override_value_spacing );
					return;
				}
				$number++;
			}
		}

		# now, if passed name is numeric, create numbered parameter, otherwise create named parameter
		# add parameter to parameters array
		if ( is_numeric( $trimmed_name ) && ( (int)$trimmed_name ) == $trimmed_name )
		{
			$this->parameters[] = new POMTemplateNumberedParameter( $value );
		}
		else
		{
			$this->parameters[] = new POMTemplateNamedParameter( $name, $value );
		}
	}

	public function asString()
	{
		if ( $this->hidden() ) return "";

		$text = '{{' . $this->title_triple->toString();

		for ( $i = 0; $i < count( $this->parameters ); $i++ )
		{
			// if a function, then the first sep is a :, otherwise |
			$text .= ( ( $i == 0 ) && ( substr( $this->getTitle(), 0, 1 ) == '#' ) ) ? ':' : '|';
			# echo "\n[$i]: ".var_export($this->parameters)."\n\n-----------------------------------\n";
			$text .= $this->parameters[$i]->toString();
		}

		$text .= '}}';

		return $text;
	}
}

class WrongParameterNameException extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct( $message, $code = 0 ) {
        // some code

        // make sure everything is assigned properly
        parent::__construct( $message, $code );
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
