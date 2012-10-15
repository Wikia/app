<?php

class ReverseImporter {
	var $mText = '';
	var $mWikiText = '';

        function __construct( $text ) {
                $this->mText = $text;
        }

        /*
         * adjustPreParse
         *
         * modifies HTML to fit our standard
         */
        function adjustPreParse() {
                /* ... */
        }

	/*
	 * adjustPostParse
	 *
	 * modifies wikitext to remove any quirks the parser failed to catch
	 */
        function adjustPostParse() {
                /* ... */
        }

        /*
         * parse
         * 
         * @return string of adjusted wikitext
         */
        function parse() {
                $this->adjustPreParse();
                $this->mWikiText = $this->parseInternal( $text );
                $this->adjustPostParse();

                return $this->mWikiText;
        }

        /* 
         * simple wrapper for RTEReverseParser
         *
         * @return string of wikitext
         */
        function parseInternal() {
                $parser = new RTEReverseParser();
                return $parser->parse( $this->mText );
        }

        /*
         * get the contributor for imported edit
         *
         * @return mixed User object or null
         */
        function getUser() {
                return null;
        }
}
