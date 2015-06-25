<?php

class TemplateConverter {

	const TEMPLATE_VARIABLE_REGEX = '/{{{([^\|}]*?)\|?(.*)}}}/sU';

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
	 * Performs a conversion to a template with a portable infobox.
	 *
	 * @param $content
	 * @return string
	 */
	public function convertAsInfobox( $content ) {
		$draft = "<infobox>\n";

		$variables = $this->getTemplateVariables( $content );

		foreach ( $variables as $variable ) {
			if ( in_array( $variable['name'], self::$titleAliases ) ) {
				$draft .= $this->createTitleTag( $variable );
			} elseif ( in_array( $variable['name'], self::$imageAliases ) ) {
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
		$templateVariables = [];

		preg_match_all( self::TEMPLATE_VARIABLE_REGEX, $content, $templateVariables );
		$variables = $this->prepareVariables( $templateVariables );

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

		foreach( $templateVariables[1] as $key => $variableName ) {
			if ( isset( $variables[$variableName] ) ) {
				if ( empty( $variables[$variableName]['default'] ) && strlen( $templateVariables[2][$key] ) > 1 ) {
					$variables[$variableName]['default'] = substr( $templateVariables[2][$key], 1 );
				}
			} else {
				$variables[$variableName] = [
					'name' => $variableName,
					'label' => '',
					'default' => strlen( $templateVariables[2][$key] ) > 1 ? substr( $templateVariables[2][$key], 1 ) : ''
				];
			}
		}

		return $variables;
	}
} 
