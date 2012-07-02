<?php
#
# Page class repersents Page - top level element resulting from page parsing.
#

class POMPage extends POMElement
{
	var $c = array(); # collections array - parsers can add elements to it

	var $templates; # shortcut to $c['templates'], set up if POMTemplateParser was used

	public function POMPage( $text, $parsers = array( 'POMCommentParser', 'POMTemplateParser', 'POMLinkParser' ) )
	{
		$this->addChild( new POMTextNode( $text ) );

		#
		# Here we'll call parsers
		#
		foreach ( $parsers as $parser )
		{
			# workign around no class variables in PHP pre 5.3.0
			call_user_func( array( $parser, 'Parse' ), $this );

			# let's try to add $this->templates
			if ( $parser == 'POMTemplateParser' && array_key_exists( 'templates', $this->c ) )
			{
				$this->templates = $this->c['templates'];
			}
		}
	}
}

