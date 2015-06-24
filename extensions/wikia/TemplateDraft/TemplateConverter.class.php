<?php

class TemplateConverter {

	const TEMPLATE_VARIABLE_REGEX = '/{{{([^\|}]*?)\|?.*}}}/sU';

	public function convert( $content ) {
		$draft = '<infobox>';

		$variables = $this->findTemplateVariables( $content );

		foreach ( $variables as $variable ) {
			$draft .= $this->createDataTag( $variable );
		}

		$draft .= '</infobox>';

		return $draft;
	}

	public function findTemplateVariables( $content ) {
		$variables = [];

		preg_match_all( self::TEMPLATE_VARIABLE_REGEX, $content, $variables );
		$variables = array_unique( $variables[1] );

		return $variables;
	}

	private function createDataTag( $source, $label = '' ) {
		if ( empty( $label ) ) {
			$label = $source;
		}
		return "<data source='$source'><label>$label</label></data>";
	}
} 
