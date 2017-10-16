<?php
/**********************************************************************************

Copyright (C) 2006 Bradley Pesicka (teknomunk@bluebottle.com)

Tested on
# MediaWiki: 1.7.1
# PHP: 5.0.5-2ubuntu1.5 (apache2handler)
# MySQL: 4.0.24_Debian-10ubuntu2.3-log

Developed for use by LryicWiki.org (http://www.lyricwiki.org/)

***********************************************************************************
*/

require_once "rdp.php";

class XmlDocument
{
	var $items = Array();
	var $error = "";

	function __construct( $items = Array() )
	{
			$this->items = $items;
	}
	function getError()
	{
		return $this->error;
	}
	function parse( $source )
	{
		$parser = new RecursiveDecentParser($source);

		$stack = Array();
		$nameStack = Array();
		$result = Array();
		$tagData = "";

		array_push($stack,$result);
		array_push($nameStack,null);

		$symbol = "[a-zA-Z0-9:]+";

		if( $parser->accept("<?") )
		{
			# eat XML declarations
		}

		while(!$parser->eof())
		{
			if( $parser->accept("<?") )
			{
				# eat XML declarations
				$parser->accept_upto(">");
				$parser->accept(">");
			}
			else if( $parser->accept("<![CDATA[") )
			{
				$text = $parser->accept_upto("]]>");
				$text = trim($text[0]);
				if( $text != "" )
				{
					$stack[0][] = $text;
				};
			}
			else if( $parser->accept("</") )
			{
				$m = $parser->accept_upto(">");
				$parser->accept(">");
				$tagname = trim($m[0]);
				
				if( $tagname != $nameStack[0] )
				{
					$parser->dumpState();
					var_dump($stack);
					$this->error = "Tag mismatch: expecting `$nameStack[0]' got `$tagname'\n";
					return false;
				};
				
				$curr = $stack[0];
				array_shift($stack);
				$stack[0][strtoupper($nameStack[0])][] = $curr;

				array_shift($nameStack);
			}
			elseif( $parser->accept("<") )
			{
				if( !( $m = $parser->accept_upto(Array(" ",">")) ) )
				{
					$this->error = "no tagname\n";
					return false;
				}
				$parser->accept(" ");
				$tagname = trim($m[0]);

				if( $m = $parser->accept_upto(">") )
				{
					$parser->accept(">");

					$inside = $m[0];

					$sub = substr($inside,strlen($inside)-1);
					if( $sub == "/")
					{
						#echo "selfclosing tag\n";
					}
					else
					{
						$parser->accept(">");
						array_unshift($stack,$tagData);
						array_unshift($nameStack,$tagname);
					}
				}
				else
				{
					var_dump($result);
					$parser->dumpState();
					$this->error = "Invalid syntax in tag\n";
					return false;
				};
			}
			elseif( $m = $parser->accept_upto("<") )
			{
				$m = trim($m[0]);
				if( $m != "" )
				{
					$stack[0][] = $m;
				}
			}
			else if( $parser->accept_regex("/[ \n\t\r]+/") )
			{
			}
			else
			{
				$this->error = "Syntax Error: Unknown character sequence\n";
				var_dump($result);
				$parser->dumpState();
				return false;
			};
		};

		if(isset($_GET['ds']) && (strpos($_GET['ds'],"xml") !== false))
		{
			var_dump($result);
		};

		$this->items = $stack[0];
		$this->error = "Success";
		return true;
	}
	function getItem( $path )
	{
		$parts = explode( "/", $path );
		
		$curr = $this->items;
		foreach( $parts as $part )
		{
			preg_match( "#([a-zA-Z:]*)(|\[([0-9*]*)\])#", $part, $match );

			$tag = strtoupper($match[1]);

			$idx = (integer)$match[2];

			if( $tag )
			{
				if( $match[2] == "*" )
				{
					return $curr[$tag];
				}
				else
				{
					// Check to make sure that it exists before traversing
					if( !( is_array( $curr ) && array_key_exists( $tag, $curr) ) )
					{
						return null;
					}
						
					if( !( is_array( $curr[$tag] ) && array_key_exists( $idx, $curr[$tag] ) ) )
					{
						return null;
					}
						
					$array = $curr[$tag];
					$curr = $array[$idx];
				}
			}
		}

		return $array;
	}
	function count()
	{
			return count($this->items);
	}
};

