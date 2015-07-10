<?php

class TemplateConverter {

	const CONVERSION_MARKER = 'conversion';

	const
		TEMPLATE_VARIABLE_PATTERN = '/{{{([^{}]+|.*{{.*}}.*)?}}}/',
		TEMPLATE_VARIABLE_DATA_PATTERN = '/([^|]+)(\|.*)*/',
		TRANSCLUSION_MARKUP_PATTERN = '/(<(includeonly|onlyinclude|noinclude)>.*?<\/(includeonly|onlyinclude|noinclude)>)/',
		TABLE_ROWS_PATTERN = '/<tr.*?>.*?<\/tr>/s',
		ROW_VALUES_PATTERN = '/<tr.*?><t[d|h].*?>(.*?)<\/t[d|h].*><t[d|h].*?>(.*?)<\/t[d|h]><\/tr>/s';


	private $title; // Title object of the template we're converting

	/**
	 * Names of variables that should be converted to a <title> tag
	 * @var array
	 */
	public static $titleAliases = [
		'name',
		'title',
	];

	/**
	 * Names of variables that should be converted to an <image> tag
	 * @var array
	 */
	public static $imageAliases = [
		'image',
		'picture',
		'photo',
		'mainimage',
	];

	/**
	 * Names of variables that are usually not data and can be ignored
	 * @var array
	 */
	public static $ignoredVariables = [
		'imagewidth',
		'caption',
	];

	/**
	 * @param Title $templateTitle
	 */

	public function __construct( Title $templateTitle ) {
		$this->title = $templateTitle;
	}

	/**
	 * Performs a conversion to a template with a portable infobox
	 *
	 * @param $content
	 * @return string
	 */
	public function convertAsInfobox( $content ) {
		$templateVariables =  $this->getTemplateVariables( $content );
		$content = $this->prepareContent( $content );

		preg_match_all( self::TABLE_ROWS_PATTERN, $content, $rows );
		$values = $this->getVariablesFromRows( $rows );

		$templateVariables = $this->prepareVariableLabels( $values, $templateVariables );

		$draft = $this->prepareDraft( $templateVariables );

		return $draft;
	}

	/**
	 * Prepares draft with infobox template based on passed variables
	 *
	 * @param $variables
	 * @return string
	 */
	public function prepareDraft( $variables ) {
		$draft = "<infobox>\n";

		foreach ( $variables as $variable ) {
			$lcVarName = strtolower( $variable['name'] );
			if ( in_array( $lcVarName, self::$ignoredVariables ) ) {
				continue;
			} elseif ( in_array( $lcVarName, self::$titleAliases ) ) {
				$draft .= $this->createTitleTag( $variable );
			} elseif ( in_array( $lcVarName, self::$imageAliases ) ) {
				$draft .= $this->createImageTag( $variable );
			} else {
				$draft .= $this->createDataTag( $variable );
			}
		}

		$draft .= "</infobox>\n";

		return $draft;
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
	 * Creates a <title> tag.
	 *
	 * @param $variable
	 * @return string
	 */
	public function createTitleTag( $variable ) {
		if ( empty( $variable['default'] ) ) {
			$variable['default'] = '{{PAGENAME}}';
		}
		return "\t<title source=\"{$variable['name']}\"><default>{$variable['default']}</default></title>\n";
	}

	/**
	 * Creates an <image> tag.
	 *
	 * @param $variable
	 * @return string
	 */
	public function createImageTag( $variable ) {
		return "\t<image source=\"{$variable['name']}\"/>\n";
	}

	/**
	 * Creates a <data> tag.
	 *
	 * @param $variable
	 * @return string
	 */
	public function createDataTag( $variable ) {
		if ( empty( $variable['label'] ) ) {
			$variable['label'] = $variable['name'];
		}

		$data = "\t<data source=\"{$variable['name']}\"><label>{$variable['label']}</label>";

		if ( !empty( $variable['default'] ) ) {
			$data .= "<default>{$variable['default']}</default>";
		}

		$data .= "</data>\n";

		return $data;
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
		$dom = $parser->preprocessToDom( $content );
		$content = $frame->expand( $dom, PPFrame::NO_ARGS );
		$content = $parser->doTableStuff( $content );

		return $content;
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
				preg_match( self::TEMPLATE_VARIABLE_PATTERN, $variable[2], $templateName );

				if ( !empty( $templateName[1] ) && !empty( $variable[1] ) ) {
					$templateVariables[$templateName[1]]['label'] = trim( $variable[1] );
				}
			}
		}

		return $templateVariables;
	}

	public function generatePreviewSection( $content ) {
		$variables = $this->getTemplateVariables( $content );

		$preview = "{{" . $this->title->getText() . "\n";
		$docs = $preview;

		foreach ( $variables as $var ) {
			$preview .= "|{$var['name']}=This is a test\n";
			$docs .= "|{$var['name']}=\n";
		}

		$preview .= "}}\n";
		$docs .= "}}\n";

		$return = "<noinclude>\n";
		$return .= wfMessage( 'templatedraft-preview-n-docs' )->rawParams( $docs, $preview )->inContentLanguage()->plain();
		$return .= "\n</noinclude>\n";

		return $return;
	}

	public static function isConversion() {
		global $wgRequest;

		return $wgRequest->getVal( self::CONVERSION_MARKER, false );
	}
}
