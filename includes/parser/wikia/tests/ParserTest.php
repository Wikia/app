<?php

class ParserTest extends WikiaBaseTest {

    /** @var Parser */
    protected $parser;

    /** @var ParserOptions */
    protected $options;

    public function setUp() {
        parent::setUp();
        $this->parser = new Parser();
        $this->options = new ParserOptions();
    }

    protected function queryDOM( $html, $query ) {
        $dom = ( new DOMDocument() );
        $dom->loadHTML( $html );
        $x = new DOMXPath( $dom );
        return $x->query( $query );
    }

    public function testRefParsingWithNoReferenceTag() {
        $markup = '<ref>test</ref>';

        $html = $this->parser->parse( $markup, new Title(), $this->options )->getText();

        $sups = $this->queryDOM( $html, '//p/sup' );
        $this->assertEquals( 1, $sups->length );
        $error = $this->queryDOM( $html, '//strong[contains(@class, \'error\')]' );
        $this->assertEquals( 1, $error->length );
    }


    public function testPartialParseOptionForRefTag() {
        $markup = '<ref>test</ref>';

        $this->options->setIsPartialParse( true );
        $html = $this->parser->parse( $markup, new Title(), $this->options )->getText();

        $sups = $this->queryDOM( $html, '//p/sup' );
        $this->assertEquals( 1, $sups->length );
        $error = $this->queryDOM( $html, '//strong[contains(@class, \'error\')]' );
        $this->assertEquals( 0, $error->length );
    }
}