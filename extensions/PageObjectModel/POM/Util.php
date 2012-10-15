<?php
#
# Set of classes representing various types of template parameters 
#

class POMUtilTrimTriple
{
	public $leading_space;
	public $trimmed;
	public $trailing_space;

	function __construct( $text )
	{
		$this->trimmed = trim( $text );
		if ( strlen( $this->trimmed ) > 0 )
		{
			$this->leading_space = substr( $text, 0, strpos( $text, $this->trimmed ) );
			if ( strpos( $text, $this->trimmed ) + strlen( $this->trimmed ) < strlen( $text ) )
			{
				$this->trailing_space = substr( $text, strpos( $text, $this->trimmed ) + strlen( $this->trimmed ) );
			}
			else
			{
				$this->trailing_space = '';
			}
		}
		else
		{
			$this->leading_space = '';
			$this->trailing_space = $text;
		}
	}

	function toString()
	{
		return $this->leading_space . $this->trimmed . $this->trailing_space;
	}
}
