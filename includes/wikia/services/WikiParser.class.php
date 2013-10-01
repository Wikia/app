<?php

class WikiParser {

	protected $text;

	public function setText( $text ) {
		$this->text = $text;
	}

	public function getText() {
		return $this->text;
	}

	public function parse() {
//		$str = $this->prepare( $this->text );
		$text = $this->text;
		//explode sections
		preg_match_all( '|==(?<section>.*)==|sU', $text, $sections );

		print_r( $sections );
		die;

		return $str;
	}

	protected function prepare( $str ) {
		$result = strip_tags( $str );

		return $result;
	}

	protected function explodeSections() {

	}
}
