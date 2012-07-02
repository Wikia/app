<?php
/**
 * Classes for parsing XML representing wiki pages and their template calls
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class DTWikiTemplate {
	private $mName = null;
	private $mFields = array();

	public function DTWikiTemplate( $name ) {
		$this->mName = $name;
	}

	function addField( $name, $value ) {
		$this->mFields[$name] = $value;
	}

	function createText() {
		$multi_line_template = false;
		$text = '{{' . $this->mName;
		foreach ( $this->mFields as $field_name => $field_val ) {
			if ( is_numeric( $field_name ) ) {
				$text .= "|$field_val";
			} else {
				$text .= "\n|$field_name=$field_val";
				$multi_line_template = true;
			}
		}
		if ( $multi_line_template )
			$text .= "\n";
		$text .= '}}' . "\n";
		return $text;
	}
}

class DTWikiPage {
	private $mPageName = null;
	private $mElements = array();

	public function DTWikiPage( $name ) {
		$this->mPageName = $name;
	}

	function getName() {
		return $this->mPageName;
	}

	function addTemplate( $template ) {
		$this->mElements[] = $template;
	}

	function addFreeText( $free_text ) {
		$this->mElements[] = $free_text;
	}

	function createText() {
		$text = "";
		foreach ( $this->mElements as $elem ) {
			if ( $elem instanceof DTWikiTemplate ) {
				$text .= $elem->createText();
			} else {
				$text .= $elem;
			}
		}
		return $text;
	}
}

class DTXMLParser {
	var $mDebug = false;
	var $mSource = null;
	var $mCurFieldName = null;
	var $mCurFieldValue = '';
	var $mCurTemplate = null;
	var $mCurPage = null; // new DTWikiPage();
	var $mPages = array();

	function __construct( $source ) {
		$this->mSource = $source;
	}

	function debug( $text ) {
		// print "$text. ";
	}

	function throwXMLerror( $text ) {
		print htmlspecialchars( $text );
	}

	function doParse() {
		$parser = xml_parser_create( "UTF-8" );

		# case folding violates XML standard, turn it off
		xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, false );

		xml_set_object( $parser, $this );
		xml_set_element_handler( $parser, "in_start", "" );

		$offset = 0; // for context extraction on error reporting
		do {
			$chunk = $this->mSource->readChunk();
			if ( !xml_parse( $parser, $chunk, $this->mSource->atEnd() ) ) {
				wfDebug( "WikiImporter::doImport encountered XML parsing error\n" );
				// return new WikiXmlError( $parser, wfMsgHtml( 'import-parse-failure' ), $chunk, $offset );
			}
			$offset += strlen( $chunk );
		} while ( $chunk !== false && !$this->mSource->atEnd() );
		xml_parser_free( $parser );
	}

	function donothing( $parser, $x, $y = "" ) {
		# $this->debug( "donothing" );
	}


	function in_start( $parser, $name, $attribs ) {
		// $this->debug( "in_start $name" );
		$pages_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_pages' ) );
		if ( $name != $pages_str ) {
			print( "Expected '$pages_str', got '$name'" );
		}
		xml_set_element_handler( $parser, "in_pages", "out_pages" );
	}

	function in_pages( $parser, $name, $attribs ) {
		$this->debug( "in_pages $name" );
		$page_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_page' ) );
		if ( $name == $page_str ) {
			$title_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_title' ) );
			if ( array_key_exists( $title_str, $attribs ) ) {
				$this->mCurPage = new DTWikiPage( $attribs[$title_str] );
			xml_set_element_handler( $parser, "in_page", "out_page" );
			} else {
				return $this->throwXMLerror( "'$title_str' attribute missing for page" );
			}
		} else {
			return $this->throwXMLerror( "Expected <$page_str>, got <$name>" );
		}
	}

	function out_pages( $parser, $name ) {
		$this->debug( "out_pages $name" );
		$pages_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_pages' ) );
/*
		if( $name != $pages_str ) {
			return $this->throwXMLerror( "Expected </pages>, got </$name>" );
		}
*/
		xml_set_element_handler( $parser, "donothing", "donothing" );
	}

	function in_category( $parser, $name, $attribs ) {
		$this->debug( "in_category $name" );
		$page_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_page' ) );
		if ( $name == $page_str ) {
			if ( array_key_exists( $title_str, $attribs ) ) {
				$this->mCurPage = new DTWikiPage( $attribs[$title_str] );
			xml_set_element_handler( $parser, "in_page", "out_page" );
			} else {
				return $this->throwXMLerror( "'$title_str' attribute missing for page" );
			}
		} else {
			return $this->throwXMLerror( "Expected <$page_str>, got <$name>" );
		}
	}

	function out_category( $parser, $name ) {
		$this->debug( "out_category $name" );
		if ( $name != "category" ) {
			return $this->throwXMLerror( "Expected </category>, got </$name>" );
		}
		xml_set_element_handler( $parser, "donothing", "donothing" );
	}

	function in_page( $parser, $name, $attribs ) {
		$this->debug( "in_page $name" );
		$template_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_template' ) );
		$name_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_name' ) );
		$free_text_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_freetext' ) );
		if ( $name == $template_str ) {
			if ( array_key_exists( $name_str, $attribs ) ) {
				$this->mCurTemplate = new DTWikiTemplate( $attribs[$name_str] );
			xml_set_element_handler( $parser, "in_template", "out_template" );
			} else {
				return $this->throwXMLerror( "'$name_str' attribute missing for template" );
			}
		} elseif ( $name == $free_text_str ) {
			xml_set_element_handler( $parser, "in_freetext", "out_freetext" );
			xml_set_character_data_handler( $parser, "freetext_value" );
		} else {
			return $this->throwXMLerror( "Expected <$template_str>, got <$name>" );
		}
	}

	function out_page( $parser, $name ) {
		$this->debug( "out_page $name" );
		$page_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_page' ) );
		if ( $name != $page_str ) {
			return $this->throwXMLerror( "Expected </$page_str>, got </$name>" );
		}
		$this->mPages[] = $this->mCurPage;
		xml_set_element_handler( $parser, "in_pages", "out_pages" );
	}

	function in_template( $parser, $name, $attribs ) {
		$this->debug( "in_template $name" );
		$field_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_field' ) );
		if ( $name == $field_str ) {
			$name_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_name' ) );
			if ( array_key_exists( $name_str, $attribs ) ) {
				$this->mCurFieldName = $attribs[$name_str];
			// $this->push( $name );
			$this->workRevisionCount = 0;
			$this->workSuccessCount = 0;
			$this->uploadCount = 0;
			$this->uploadSuccessCount = 0;
			xml_set_element_handler( $parser, "in_field", "out_field" );
			xml_set_character_data_handler( $parser, "field_value" );
			} else {
				return $this->throwXMLerror( "'$name_str' attribute missing for field" );
			}
		} else {
			return $this->throwXMLerror( "Expected <$field_str>, got <$name>" );
		}
	}

	function out_template( $parser, $name ) {
		$this->debug( "out_template $name" );
		$template_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_template' ) );
		if ( $name != $template_str ) {
			return $this->throwXMLerror( "Expected </$template_str>, got </$name>" );
		}
		$this->mCurPage->addTemplate( $this->mCurTemplate );
		xml_set_element_handler( $parser, "in_page", "out_page" );
	}

	function in_field( $parser, $name, $attribs ) {
		// xml_set_element_handler( $parser, "donothing", "donothing" );
	}

	function out_field( $parser, $name ) {
		$this->debug( "out_field $name" );
		$field_str = str_replace( ' ', '_', wfMsgForContent( 'dt_xml_field' ) );
		if ( $name == $field_str ) {
			$this->mCurTemplate->addField( $this->mCurFieldName, $this->mCurFieldValue );
			$this->mCurFieldValue = '';
		} else {
			return $this->throwXMLerror( "Expected </$field_str>, got </$name>" );
		}
		xml_set_element_handler( $parser, "in_template", "out_template" );
	}

	function field_value( $parser, $data ) {
		$this->mCurFieldValue .= $data;
	}

	function in_freetext( $parser, $name, $attribs ) {
		// xml_set_element_handler( $parser, "donothing", "donothing" );
	}

	function out_freetext( $parser, $name ) {
		xml_set_element_handler( $parser, "in_page", "out_page" );
	}

	function freetext_value( $parser, $data ) {
		$this->mCurPage->addFreeText( $data );
	}

}
