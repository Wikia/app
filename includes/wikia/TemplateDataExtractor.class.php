<?php

class TemplateDataExtractor {

	const
		TEMPLATE_VARIABLE_PATTERN = '/{{{([^|{}]+(\|([^{}]*|.*?{{.*?}}.*?))*)?}}}/',
		TEMPLATE_VARIABLE_DATA_PATTERN = '/([^|]+)(\|.*)*/',
		TRANSCLUSION_MARKUP_PATTERN = '/(<(includeonly|onlyinclude|noinclude)>.*?<\/(includeonly|onlyinclude|noinclude)>)/',
		TABLE_ROWS_PATTERN = '/<tr.*?>.*?<\/tr>/s',
		ROW_VALUES_PATTERN = '/<tr.*?><t[d|h].*?>(.*?)<\/t[d|h].*><t[d|h].*?>(.*?)<\/t[d|h]><\/tr>/s';


	private $title; // Title object of the template we're converting

	/**
	 * @param Title $templateTitle
	 */

	public function __construct( Title $templateTitle ) {
		$this->title = $templateTitle;
	}

	/**
	 * Extracts variables used in a content of a template.
	 *
	 * @param $content
	 * @return array
	 */
	public function getTemplateVariables( $content ) {
		preg_match_all( self::TEMPLATE_VARIABLE_PATTERN, $content, $templateVariables );

		$variables = $this->prepareVariables( $templateVariables[1] );

		return $variables;
	}

	/**
	 * Extracts variables used in a content of a template with its labels.
	 * CAUTION: Works only for templates which are build as a table
	 *
	 * @param $content
	 * @return array
	 */
	public function getTemplateVariablesWithLabels( $content ) {
		$templateVariables =  $this->getTemplateVariables( $content );

		$content = $this->prepareContent( $content );
		preg_match_all( self::TABLE_ROWS_PATTERN, $content, $rows );
		$values = $this->getVariablesFromRows( $rows );

		$templateVariables = $this->prepareVariableLabels( $values, $templateVariables );

		return $templateVariables;
	}

	/**
	 * Prepares content in special format.
	 * It doesn't parse template variables to extract them later.
	 *
	 * @param $content
	 * @return string
	 */
	private function prepareContent( $content ) {
		global $wgUser;

		$parser = \ParserPool::get();
		$parser->startExternalParse( $this->title, \ParserOptions::newFromUser( $wgUser ), \Parser::OT_PLAIN );

		$frame = $parser->getPreprocessor()->newFrame();
		$dom = $parser->preprocessToDom( $content, \Parser::PTD_FOR_INCLUSION );
		$content = $frame->expand( $dom, PPFrame::NO_ARGS );
		$content = $parser->doTableStuff( $content );

		return $content;
	}

	/**
	 * Prepares variables from templates
	 *
	 * @param $templateVariables
	 * @return array
	 */
	private function prepareVariables( $templateVariables ) {
		$variables = [];

		foreach ( $templateVariables as $variable ) {
			$variable = $this->removeTransclusionMarkup( $variable );
			list( $variableName, $default ) = $this->getVariableData( $variable );

			if ( isset( $variables[$variableName] ) ) {
				if ( empty( $variables[$variableName]['default'] ) && strlen( $default ) > 1 ) {
					$variables[$variableName]['default'] = substr( $default, 1 );
				}
			} else {
				$variables[$variableName] = [
					'name' => $variableName,
					'label' => '',
					'default' => strlen( $default ) > 1 ? substr( $default, 1 ) : ''
				];
			}

		}

		return $variables;
	}

	/**
	 * Remove tags like includeonly, onlyinclude and noinclude from template variable
	 *
	 * @param $variable
	 * @return string
	 */
	private function removeTransclusionMarkup( $variable ) {
		$variable = preg_replace( self::TRANSCLUSION_MARKUP_PATTERN, '', $variable );

		return $variable;
	}

	/**
	 * Get template variable name and its default value if exists
	 *
	 * @param $variable
	 * @return array
	 */
	private function getVariableData( $variable ) {
		preg_match_all( self::TEMPLATE_VARIABLE_DATA_PATTERN, $variable, $variableData );

		return [ $variableData[1][0], $variableData[2][0] ];
	}

	/**
	 * Check if there is a row with template variable and label.
	 * We assume if there is a table row and in one of the cell is template variable,
	 * text inside second one is treated as a label.
	 *
	 * @param $rows
	 * @return array
	 */
	private function getVariablesFromRows( $rows ) {
		$values = [];

		if ( !empty( $rows[0] ) ) {
			foreach ( $rows[0] as $row ) {
				$row = str_replace( [ "\n", "\r" ], '', $row );
				preg_match( self::ROW_VALUES_PATTERN, $row, $vars );

				if ( !empty( $vars[1] ) && !empty( $vars[2] ) ) {
					unset( $vars[0] );
					$values[] = $vars;
				}
			}
		}

		return $values;
	}

	/**
	 * Check if label for template variable exists and add its value
	 *
	 * @param $templateVariables
	 * @param $content
	 * @return array
	 */
	private function prepareVariableLabels( $variables, $templateVariables ) {
		foreach ( $variables as $variable ) {
			if ( !empty( $variable[2] ) ) {
				preg_match( self::TEMPLATE_VARIABLE_PATTERN, $variable[2], $variableName );
				list( $variableName, $default ) = $this->getVariableData( $variableName[1] );

				if ( !empty( $variableName ) && !empty( $variable[1] ) ) {
					$templateVariables[$variableName]['label'] = trim( $variable[1] );
				}
			}
		}

		return $templateVariables;
	}
}
