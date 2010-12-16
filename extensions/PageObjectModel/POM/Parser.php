<?php
#
# Parser is an abstract class for various parsers that will post-process a page.
# All parsers must subclass this class
#

abstract class POMParser
{
	/**
		This is main method for parsers
		It takes a page as argument and processes it adding elements
	*/
	static abstract function Parse(POMPage $page);
}

