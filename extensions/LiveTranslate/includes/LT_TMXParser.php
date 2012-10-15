<?php

/**
 * Parser for translation memory exchange (TXM) data.
 *
 * @since 0.4
 *
 * @file LT_TMXParser.php
 * @ingroup LiveTranslate
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Nicola Asuni < http://evolt.org/node/60511 >
 */
class LTTMXParser extends LTTMParser {
	
	/**
	 * XML parser object.
	 * 
	 * @since 0.4
	 * 
	 * @var resource
	 */
	protected $parser;
	
	/**
	 * The translation memory the parser will store translations in before returning them.
	 * 
	 * @since 0.4
	 * 
	 * @var LTTranslationMemory
	 */
	protected $tm;
	
	/**
	 * The current translation unit.
	 * 
	 * @since 0.4
	 * 
	 * @var LTTMUnit
	 */
	protected $tu;
	
	/**
	 * The language of the current translation unit variant (tuv) node.
	 * 
	 * @since 0.4
	 * 
	 * @var string
	 */
	protected $currentLanguage;
	
	/**
	 * A string to build up translations when a single variant contains multiple segments.
	 * 
	 * @since 0.4
	 * 
	 * @var string
	 */
	protected $currentTranslation;
	
	/**
	 * Boolean to keep track of if the XML parser is inside a segment node.
	 * 
	 * @since 0.4
	 * 
	 * @var boolean
	 */
	protected $insideSegment;
	
	/**
	 * Boolean to keep track of if the XML parser is inside a node that should be ignored.
	 * 
	 * @since 0.4
	 * 
	 * @var boolean
	 */	
	protected $insideIgnoreNode;
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 */
	public function __construct() {
		parent::__construct();
		
		$this->parser = xml_parser_create();
		
		xml_parser_set_option( $this->parser, XML_OPTION_CASE_FOLDING, 0 );
        
		xml_set_object( $this->parser, $this );
        xml_set_element_handler( $this->parser, "startElementHandler", "endElementHandler" );
        xml_set_character_data_handler( $this->parser, "segmentContentHandler" );
	}
	
	/**
	 * Destructor.
	 * 
	 * @since 0.4
	 */
	public function __destruct() {
		xml_parser_free( $this->parser );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see LTTMParser::parse()
	 */
	public function parse( $text ) {
		$this->tm = new LTTranslationMemory();
		
        // Attempt to parse the TMX.
        if( !xml_parse( $this->parser, $text ) ) {
        	// xml_error_string(xml_get_error_code($this->parser))
        	// xml_get_current_line_number($this->parser)) 
        }			
		
		return $this->tm;
	}
	
    /**
     * Sets the start element handler function for the XML parser parser.start_element_handler.
     * 
     * @param resource $parser The first parameter, parser, is a reference to the XML parser calling the handler.
     * @param string $name The second parameter, name, contains the name of the element for which this handler is called. If case-folding is in effect for this parser, the element name will be in uppercase letters. 
     * @param array $attribs The third parameter, attribs, contains an associative array with the element's attributes (if any). The keys of this array are the attribute names, the values are the attribute values. Attribute names are case-folded on the same criteria as element names. Attribute values are not case-folded. The original order of the attributes can be retrieved by walking through attribs the normal way, using each(). The first key in the array was the first attribute, and so on. 
     */
    protected function startElementHandler( $parser, $name, $attribs ) {
        switch( strtolower( $name ) ) {
            case 'tu': 
            	// A new translation unit node has been entered, so create a new translation unit object.
            	$this->tu = new LTTMUnit();
                break;
            case 'tuv':
                if ( array_key_exists( 'xml:lang', $attribs ) ) { 
                	$this->currentLanguage = $attribs['xml:lang'];
                }
                else {
                	// TODO: ignore node or give warning
                }
                break;
            case 'seg':
                $this->currentTranslation = '';
                $this->insideSegment = true;
                break;
            case 'ut' :
            	$this->insideIgnoreNode = true;
            	break;                
        }
    }
    
    /**
     * Sets the end element handler function for the XML parser parser.end_element_handler.
     * 
     * @since 0.4
     * 
     * @param resource $parser The first parameter, parser, is a reference to the XML parser calling the handler.
     * @param string $name The second parameter, name, contains the name of the element for which this handler is called. If case-folding is in effect for this parser, the element name will be in uppercase letters. 
     */
    protected function endElementHandler($parser, $name) {
        switch( strtolower( $name ) ) {
            case 'tu':
            	// We are leaving the translation unit node, so add the translation unit to the translation memory.
            	if ( $this->tu->hasVariants() ) {
            		$this->tm->addTranslationUnit( $this->tu );
            	}
                break;
            case 'tuv':
            	$this->tu->addVariant( $this->currentLanguage, $this->currentTranslation );
                break;
            case 'seg':
            	$this->insideSegment = false;
                break;
            case 'ut' :
            	$this->insideIgnoreNode = false;
            	break;
        }
    }
    
    /**
     * Sets the character data handler function for the XML parser parser.handler.
     * 
     * @since 0.4
     * 
     * @param resource $parser The first parameter, parser, is a reference to the XML parser calling the handler.
     * @param string $data The second parameter, data, contains the character data as a string. 
     */
    protected function segmentContentHandler( $parser, $data ) {
        if ( $this->insideSegment && !$this->insideIgnoreNode ) {
            $this->currentTranslation .= $data;
        }
    }
	
}
