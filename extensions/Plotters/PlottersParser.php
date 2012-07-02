<?php

/**
 * Plotters parser. Parses arguments and data for the Plotters extension.
 *
 * @file
 * @ingroup Extensions
 * @author Ryan Lane, rlane32+mwext@gmail.com
 * @copyright © 2009 Ryan Lane
 * @license GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
        echo( "not a valid entry point.\n" );
        die( 1 );
}

class PlottersParser {

	var $arguments;
	var $argumentArray;
	var $dataArray;

	function __construct( $input = "", $argv = Array() ) {
		$this->parseArguments( $argv );
		$this->parseData( $input );
	}

	function getArguments() {
		return $this->argumentArray;
	}

	function getData() {
		return $this->dataArray;
	}

	function setData( $data ) {
		$this->dataArray = $data;
	}

	function parseArguments( $argv ) {
		// Parse arguments, set defaults, and do sanity checks
		$this->argumentArray = array ( "renderer" => "generic", "preprocessors" => array(), "preprocessorarguments" => array(),
			"script" => "", "scriptarguments" => array(), "datasep" => ",", "width" => "300", "height" => "300", "labels" => array(),
			"name" => "plot", "tableclass" => "wikitable" );
		if ( isset( $argv["renderer"] ) ) {
			//TODO: limit this to supported renderers
			$this->argumentArray["renderer"] = preg_replace( '/[^A-Z0-9]/i', '', $argv["renderer"] );
		}
		if ( isset( $argv["preprocessors"] ) ) {
			// Sanitize scripts - alphanumerics only
			$this->argumentArray["preprocessors"] = explode( ',', $argv["preprocessors"] );
			foreach ( $this->argumentArray["preprocessors"] as &$preprocessor ) {
				$preprocessor = preg_replace( '/[^A-Z0-9]/i', '', $preprocessor );
			}

			if ( isset( $argv["preprocessorarguments"] ) ) {
				// Replace escaped separators
				$argv["preprocessorarguments"] = preg_replace( "/\\\:/", '§UNIQ§', $argv["preprocessorarguments"] );
				$argv["preprocessorarguments"] = preg_replace( "/\\\,/", '§UNIQ2§', $argv["preprocessorarguments"] );
	
				// Parse and sanitize arguments
				$arguments = explode( ':', $argv["preprocessorarguments"] );
				foreach ( $arguments as $argument ) {
					$subargumentarr = explode( ',', $argument );
					foreach ( $subargumentarr as &$singleargument ) {
						// Fix escaped separators
						$singleargument = preg_replace( "/§UNIQ§/", ":", $singleargument );
						$singleargument = preg_replace( "/§UNIQ2§/", ",", $singleargument );
						$singleargument = htmlentities( $singleargument, ENT_QUOTES );
					}
					$this->argumentArray["preprocessorarguments"][] = $subargumentarr;
				}
			}

			// If there are less preprocessorarguments than preprocessors, we want to ensure that we
			// have enough arrays, as later code will expect an array to exist for each preprocessor
			$preproccount = count( $this->argumentArray["preprocessors"] );
			$preprocargcount = count( $this->argumentArray["preprocessorarguments"] );
			if ( $preproccount > $preprocargcount ) {
				for ( $i = $preprocargcount; $i < $preproccount; $i++ ) {
					$this->argumentArray["preprocessorarguments"][] = array();
				}
			}
		}
		if ( isset( $argv["script"] ) ) {
			// Sanitize scripts - alphanumerics only
			$this->argumentArray["script"] = preg_replace( '/[^A-Z0-9]/i', '', $argv["script"] );
		}
		if ( isset( $argv["scriptarguments"] ) ) {
			// Replace escaped separators
			$argv["scriptarguments"] = preg_replace( "/\\\,/", '§UNIQ§', $argv["scriptarguments"] );

			// Parse and sanitize arguments
			$arguments = explode( ',', $argv["scriptarguments"] );
			foreach ( $arguments as $argument ) {
				// Fix escaped separators
				$argument = preg_replace( "/§UNIQ§/", ",", $argument );
				$argument = htmlentities( $argument, ENT_QUOTES );
				$this->argumentArray["scriptarguments"][] = $argument;
			}
			Plotters::debug( 'plot script argument values: ', $this->argumentArray["scriptarguments"] );
		}
		if ( isset( $argv["datasep"] ) ) {
			$this->argumentArray["datasep"] = $argv["datasep"];
		}
		if ( isset( $argv["width"] ) ) {
			$this->argumentArray["width"] = preg_replace( '/[^0-9]/', '', $argv["width"] );
		}
		if ( isset( $argv["height"] ) ) {
			$this->argumentArray["height"] = preg_replace( '/[^0-9]/', '', $argv["height"] );
		}
		if ( isset( $argv["labels"] ) ) {
			// Replace escaped separators
			$argv["labels"] = preg_replace( "/\\\,/", '§UNIQ§', $argv["labels"] );

			// Parse and sanitize arguments
			$labels = explode( ',', $argv["labels"] );
			foreach ( $labels as $label ) {
				// Fix escaped separators
				$label = preg_replace( "/§UNIQ§/", ",", $label );
				$label = htmlentities( $label, ENT_QUOTES );
				$this->argumentArray["labels"][] = $label;
			}
		}
		if ( isset( $argv["name"] ) ) {
			// Sanitize names - alphanumerics only
			$this->argumentArray["name"] = preg_replace( '/[^A-Z0-9]/i', '', $argv["name"] );
		}
		if ( isset( $argv["tableclass"] ) ) {
			// Sanitize tableclass - alphanumerics only
			$this->argumentArray["tableclass"] = preg_replace( '/[^A-Z0-9]/i', '', $argv["tableclass"] );
		}
	}

	function parseData( $input ) {
		$this->dataArray = array();

		Plotters::debug( 'plot script input: ', $this->argumentArray["scriptarguments"] );
		if ( trim( $input ) == '' ) {
			return;
		}

		// Replace escaped separators
		$sep = $this->argumentArray["datasep"];
		$input = preg_replace( "/\\\\$sep/", '§UNIQ§', $input );

		// Parse and sanitize data
		$lines = preg_split( "/\n/", $input, -1, PREG_SPLIT_NO_EMPTY );
		foreach ( $lines as $line ) {
			$values = explode( $sep, $line );
			foreach ( $values as &$value ) {
				// Fix escaped separators
				$value = preg_replace( "/§UNIQ§/", "$sep", $value );
				$value = htmlentities( $value, ENT_QUOTES );
			}
			$this->dataArray[] = $values;
			Plotters::debug( 'plot data values: ', $values );
		}
	}
}
