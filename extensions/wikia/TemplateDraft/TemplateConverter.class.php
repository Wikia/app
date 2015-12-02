<?php

class TemplateConverter {

	const CONVERSION_MARKER = 'conversion';

	private
		$title, // Title object of the template we're converting
		$templateDataExtractor;

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
		$templateVariables = $this->getTemplateDataExtractor()->getTemplateVariablesWithLabels( $content );

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

	public function generatePreviewSection( $content ) {
		$variables = $this->getTemplateDataExtractor()->getTemplateVariables( $content );

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

	protected function getTemplateDataExtractor() {
		if ( empty( $this->templateDataExtractor ) ) {
			$this->templateDataExtractor = new TemplateDataExtractor( $this->title );
		}

		return $this->templateDataExtractor;
	}
}
