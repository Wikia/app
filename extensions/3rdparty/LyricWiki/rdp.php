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

class RecursiveDecentParser
{
	var $source = "";
	var $pos = 0;

	function __construct( $source )
	{
		$this->source = $source;
		$this->reset();
	}

	function reset()
	{
		$this->pos = 0;
	}
	function accept($string)
	{
		# fail on empty string
		if( $string == "" )
		{
			return false;
		}
		
		if( substr($this->source,$this->pos,strlen($string)) == $string )
		{
			$this->pos += strlen($string);
			return true;
		}
		else
		{
			return false;
		}
	}
	function accept_upto($string)
	{
		# fail on empty string
		if( $string == "" )
		{
			return false;
		}
		
		#var_dump($string);
		if( is_array($string) )
		{
			#echo "accept_upto Array\n";
			$end = strlen($this->source);
			foreach( $string as $str )
			{
				$temp = strpos($this->source,$str,$this->pos);
				$end = ( $temp < $end ) ? $temp : $end;
				#echo "checking `$str',end=$end\n";
			}
		}
		else
		{
			$end = strpos($this->source,$string,$this->pos);
			#echo "checking `$string',end=$end,pos={$this->pos}\n";
		}
		if( $end === false )
		{
			return false;
		}
		else
		{
			$result = substr($this->source,$this->pos,$end-$this->pos);
			$this->pos = $end;
			#var_dump($result);
			return Array(0=>$result);
		}
	}

	function accept_regex($pattern)
	{
		preg_match( $pattern, $this->source, $matches, PREG_OFFSET_CAPTURE, $this->pos );
		if( $matches[0][1] == $this->pos )
		{
			$result = Array();
			foreach($matches as $idx=>$items)
			{
				$result[$idx] = $items[0];
			}

			# fail on empty string
			if( $result[0] == "" )
			{
				return false;
			}
			
			$this->pos += strlen($result[0]);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function dumpState()
	{
		echo substr($this->source,0,$this->pos)."|".substr($this->source,$this->pos)."\n";
	}
	function eof()
	{
		return ( $this->pos == strlen($this->source) );
	}
}

