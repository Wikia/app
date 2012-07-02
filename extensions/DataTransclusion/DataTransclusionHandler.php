<?php
/**
 * handler code for DataTransclusion extension.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler for Wikimedia Deutschland
 * @copyright © 2010 Wikimedia Deutschland (Author: Daniel Kinzler)
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "Not a valid entry point.\n" );
	die( 1 );
}

/** DataTransclusionHandler implements handlers for a parser tag and a parser function,
* both called record, for fetching a data record from some external source. They are used
* as follows: <record source="SourceName" key="value">SomeTemplate</record> where
* "key" may be any field name defined of a key field for that data source. Similarly:
* {{#record:SomeTemplate|SourceName|key=value}}.
*/
class DataTransclusionHandler {
	static function buildAssociativeArguments ( $params ) {
		// build associative arguments from flat parameter list
		$argv = array();
		$i = 1;
		foreach ( $params as $p ) {
			if ( preg_match( '/^\s*(\S.*?)\s*=\s*(.*?)\s*$/', $p, $m ) ) {
				$k = $m[1];
				$v = preg_replace( '/^"\s*(.*?)\s*"$/', '$1', $m[2] ); // strip any quotes enclosing the value
			} else {
				$v = trim( $p );
				$k = $i;
				$i += 1;
			}

			$argv[$k] = $v;
		}

		return $argv;
	}

	/**
	* Entry point for the {{#record}} parser function.
	* This is a wrapper around handleRecordTag
	*/
	static function handleRecordFunction ( $parser ) {
		$params = func_get_args();
		array_shift( $params ); // first is &$parser, strip it

		// first user-supplied parameter must be category name
		if ( !$params ) {
			return ''; // no category specified, return nothing
		}

		//first parameter is the template name
		$template = array_shift( $params );

		// build associative arguments from flat parameter list
		$argv = DataTransclusionHandler::buildAssociativeArguments( $params );
		$argv[ 0 ] = $template;

		// FIXME: error messages contining special blocks like <nowiki> don't get re-substitutet correctly.
		$text = DataTransclusionHandler::handleRecordTransclusion( $template, $argv, $parser, false );
		return array( $text, 'noparse' => false, 'isHTML' => false );
	}

	static function errorMessage( $key, $asHTML ) {
		$params = func_get_args();
		array_shift( $params ); // $key
		array_shift( $params ); // $asHTML

		if ( $asHTML ) {
			$mode = 'parseinline';
		} else {
			$mode = 'parsemag';
		}

		$m = wfMsgExt( $key, $mode, $params );

		// NOTE: using the key as a css class is done mainely for testing/debugging, but could be useful for scripting and styling too.
		return "<span class=\"error $key\">$m</span>";
	}

	/**
	* Entry point for the <record> tag parser hook. Delegates to handleRecordTransclusion.
	*/
	static function handleRecordTag( $text, $argv, $parser ) {
		return DataTransclusionHandler::handleRecordTransclusion( $text, $argv, $parser, true );
	}

	/**
	* Fetches a records and renders it, according to the given array of parameters.
	* Common implementation for parser tag and parser function.
	*/
	static function handleRecordTransclusion( $template, $argv, $parser, $asHTML, $templateText = null ) {
		// find out which data source to use...
		if ( empty( $argv['source'] ) ) {
			if ( empty( $argv[1] ) ) {
				wfDebugLog( 'DataTransclusion', "no source specified\n" );
				return DataTransclusionHandler::errorMessage( 'datatransclusion-missing-source', $asHTML );
			} else {
				$sourceName = $argv[1];
			}
		} else {
			$sourceName = $argv['source'];
		}

		$source = DataTransclusionHandler::getDataSource( $sourceName );
		if ( empty( $source ) ) {
			wfDebugLog( 'DataTransclusion', "unknown source: $sourceName\n" );
			return DataTransclusionHandler::errorMessage( 'datatransclusion-unknown-source', $asHTML, $sourceName );
		}

		// find out how to render the record
		if ( !empty( $argv['template'] ) ) {
			$template = $argv['template'];
		} elseif ( $template === null || $template === false ) {
			if ( empty( $argv[0] ) ) {
				wfDebugLog( 'DataTransclusion', "missing 'template' argument\n" );
				return DataTransclusionHandler::errorMessage( 'datatransclusion-missing-argument-template', $asHTML );
			} else {
				$template = $argv[0];
			}
		}

		// find key
		$by = false;
		$key = false;
		$keyFields = $source->getKeyFields();
		foreach ( $keyFields as $k ) {
			if ( isset( $argv[ $k ] ) ) {
				$by = $k;
				$key = $argv[ $k ];
				break; //XXX: could keep running and complain about multiple keys
			}
		}

		if ( !$by ) {
			global $wgContLang;
			wfDebugLog( 'DataTransclusion', "no key specified\n" );
			return DataTransclusionHandler::errorMessage( 'datatransclusion-missing-key', $asHTML, $sourceName,
				$wgContLang->commaList( $keyFields ), count( $keyFields ) );
		}

		// collect options
		$options = array();
		$optionNames = $source->getOptionNames();
		if ( $optionNames ) {
			foreach ( $optionNames as $n ) {
				if ( isset( $argv[ $n ] ) ) {
					$options[ $n ] = $argv[ $n ];
				}
			}
		}

		// load the record
		$record = $source->fetchRecord( $by, $key, $options );
		if ( empty( $record ) ) {
			wfDebugLog( 'DataTransclusion', "no record found matching $by=$key in $sourceName\n" );
			return DataTransclusionHandler::errorMessage( 'datatransclusion-record-not-found', $asHTML, $sourceName, $by, $key );
		}

		// render the record into wiki text
		if ( $template === "#dump" ) {
			$t = null;
		} else {
			$t = Title::newFromText( $template, NS_TEMPLATE );
			if ( empty( $t ) ) {
				wfDebugLog( 'DataTransclusion', "illegal template name: $template\n" );
				return DataTransclusionHandler::errorMessage( 'datatransclusion-bad-template-name', $asHTML, $template );
			}
		}

		$handler = new DataTransclusionHandler( $parser, $source, $t, $templateText );

		$record = $handler->normalizeRecord( $record, $argv );
		$text = $handler->render( $record );

		if ( $text === false ) {
			wfDebugLog( 'DataTransclusion', "template not found: $template\n" );
			return DataTransclusionHandler::errorMessage( 'datatransclusion-unknown-template', $asHTML, $template );
		}

		// set parser output expiry
		$expire = $source->getCacheDuration();
		if ( $expire !== false && $expire !== null ) {
			$parser->getOutput()->updateCacheExpiry( $expire ); // NOTE: this works only since r67185 //TESTME (how?)
		}

		if ( $asHTML && $parser ) { // render into HTML if desired
			$html = $parser->recursiveTagParse( $text );
			return $html;
		} else {
			return $text;
		}
	}

	function __construct( $parser, $source, $template, $templateText = null ) {
		$this->template = $template;
		$this->source = $source;
		$this->parser = $parser;
		$this->templateText = $templateText;
	}

	function render( $record ) {
		if ( empty( $this->templateText ) && $this->template === null ) {
			// magic record dump
			$t = null;

			$this->templateText = "\n{|";
			$this->templateText .= "|--\n";
			$this->templateText .= "! key !! value\n";
			foreach ( $record as $k => $v ) {
				$this->templateText .= "|--\n";
				$this->templateText .= "| $k || {{{{$k}}}}\n";
			}
			$this->templateText .= "|}\n";
		}

		if ( $this->templateText ) {
			// explicit template content set. Used for testing and debugging.
			if ( is_string( $this->templateText ) ) {
				$text = $this->templateText;
			} else {
				$text = $this->templateText->getContent();
			}

			$text = $this->parser->replaceVariables( $text, $record, true );
			return $text;
		}

		/*
		// NOTE: using replaceVariables is streight forward, but inefficient.
		$article = new Article( $this->template );

		if ( !$article->exists() ) {
			return false;
		}

		$text = $article->getContent();
		$text = $this->parser->replaceVariables( $text, $record, true );
		//NOTE: would need extra work to record template inclusion to be recorded in the ParserOutput and consequently in the database.
		*/

		// NOTE: braceSubstitution caches pre-parsed templates. Much nicer.
		// TODO: but how to check if the template exists? calling $article->exists() every time is slow.
		//	 once we test for that agin, re-enable the test case for the datatransclusion-unknown-template failure mode
		$frame = $this->parser->getPreprocessor()->newFrame( );

		if ( $this->template->getNamespace() == NS_TEMPLATE ) $n = "";
		else $n = $this->template->getNsText() . ":";

		$piece = array();
		$piece ['title'] = $n . $this->template->getText();
		$piece['parts'] = $this->parser->getPreprocessor()->newPartNodeArray( $record ); // works since MW r67821
		$piece['lineStart'] = false; //XXX: ugly. can't know here whether the brace was at the start of a line

		$ret = $this->parser->braceSubstitution( $piece, $frame );
		//NOTE: braceSubstitution() causes the template inclusion to be recorded in the ParserOutput and consequently in the database.

		$text = $ret[ 'text' ];

		return $text;
	}

	function normalizeRecord( $record, $args ) {
		$rec = array();

		// add source meta info, so we can render links back to the source,
		// provide license info, etc
		$info = $this->source->getSourceInfo();
		foreach ( $info as $f => $v ) {
			if ( is_array( $v ) || is_object( $v ) || is_resource( $v ) ) {
				continue;
			}

			$rec[ $f ] = $this->sanitizeValue( $v );
		}

		if ( $args ) {
			// add arguments
			foreach ( $args as $f => $v ) {
				if ( is_int( $f ) || is_array( $v ) || is_object( $v ) || is_resource( $v ) ) {
					continue;
				}

				$rec[ $f ] = $this->sanitizeValue( $v );
			}
		}

		// copy record fields, add missing values
		$fields = $this->source->getFieldNames();
		foreach ( $fields as $f ) {
			if ( isset( $record[ $f ] ) ) {
				$v = $record[ $f ];
			} else {
				$v = '';
			}

			$rec[ $f ] = $this->sanitizeValue( $v );
		}

		return $rec;
	}

	protected static $sanitizerSubstitution = array(
		# '!&!' => '&amp;',  #breaks URLs. not really needed when parsed as wiki-text...
		'!&(#?x?[\w\d]+);!' => '&amp;$1;',
		'!<!' => '&lt;',
		'!>!' => '&gt;',
		'!\[!' => '&#91;',
		'!\]!' => '&#93;',
		'!\{!' => '&#123;',
		'!\}!' => '&#125;',
		'!\'!' => '&#39;', //NOTE: &apos; doesn't work, mediawiki escapes it. maybe because it'S not in HTML 4.
		'!\|!' => '&#124;',
		'!^\*!m' => '&#42;',
		'!^#!m' => '&#35;',
		'!^:!m' => '&#58;',
		'!^;!m' => '&#59;',
		'![\r\n]!' => ' ',
		'!^ !m' => '&#32;',
		'!^-!m' => '&#45;',
		'!^=!m' => '&#61;',
	);

	static function sanitizeValue( $v ) {
		// XXX: would be nicer to use <nowiki> - or better, insert substitution chunks directly into the parser state. would still need html escpaing though
		// XXX: could use wfEscapeWikiText() - but it doesn't cover everything, it seems
		$find = array_keys( self::$sanitizerSubstitution );
		$subst = array_values( self::$sanitizerSubstitution );

		$v = preg_replace( $find, $subst, $v );
		return $v;
	}

	static function getDataSource( $name ) {
		global $wgDataTransclusionSources;
		if ( empty( $wgDataTransclusionSources[ $name ] ) ) {
			return false;
		}

		$source = $wgDataTransclusionSources[ $name ];

		if ( is_array( $source ) ) { // if the source is an array, use it to instantiate the sourece object
			$spec = $source;
			$spec[ 'name' ] = $name;

			if ( !isset( $spec[ 'class' ] ) ) {
				throw new MWException( "\$wgDataTransclusionSources['$name'] must specifying a class name in the 'class' field." );
			}

			$c = $spec[ 'class' ];
			$obj = new $c( $spec ); // pass spec array as constructor argument
			if ( !$obj ) {
				throw new MWException( "failed to instantiate \$wgDataTransclusionSources['$name'] as new $c." );
			}

			wfDebugLog( 'DataTransclusion', "created instance of $c as source \"$name\"\n" );
			$source = $obj;

			if ( isset( $spec[ 'cache' ] ) ) { // check if a cache should be used
				$c = $spec[ 'cache' ];
				if ( !is_object( $c ) ) { // cache may be specified as a string
					$c = wfGetCache( $c ); // $c should be one of the CACHE_* constants
				}

				$source = new CachingDataTransclusionSource( $obj, $c, @$spec['cache-duration'] ); // apply caching wrapper

				wfDebugLog( 'DataTransclusion', "wrapped source \"$name\" in an instance of CachingDataTransclusionSource\n" );
			}

			$wgDataTransclusionSources[ $name ] = $source; // replace spec array by actual object, for later re-use
		}

		if ( !is_object( $source ) ) {
			throw new MWException( "\$wgDataTransclusionSources['$name'] must be an array or an object." );
		}

		return $source;
	}

}
