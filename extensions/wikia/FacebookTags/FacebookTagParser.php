<?php

class FacebookTagParser extends AbstractInvokableParserHook {
	/** @var string $tagName */
	private $tagName;

	public function __construct( string $tagName ) {
		if ( isset( FacebookTagConstants::TAG_FALLBACKS[$tagName] ) ) {
			$this->tagName = FacebookTagConstants::TAG_FALLBACKS[$tagName];
			return;
		}

		$this->tagName = $tagName;
	}

	public function parse( $content, array $attributes, Parser $parser, PPFrame $frame ): string {
		$tagAttributes = $this->buildTagAttributes( $attributes );

		return Html::element( 'iframe', $tagAttributes );
	}

	private function buildTagAttributes( array $attributes ): array {
		$attributeWhitelist = FacebookTagConstants::SUPPORTED_TAG_ATTRIBUTES;
		$tagAttributes = Sanitizer::validateAttributes( $attributes, $attributeWhitelist );

		$queryParameters = $this->buildQueryParameters( $attributes );
		$fbUrl = sprintf( FacebookTagConstants::FB_API_URL, $this->tagName, $queryParameters );

		$tagAttributes += [
			'src' => Sanitizer::cleanUrl( $fbUrl ),
			'scrolling' => 'no',
			'frameborder' => 0,
			'allowTransparency' => 'true',
		];

		return $tagAttributes;
	}

	private function buildQueryParameters( array $attributes ): string {
		$pluginOptionWhitelist = FacebookTagConstants::FB_PLUGIN_OPTS[$this->tagName];
		$validatedAttributes = Sanitizer::validateAttributes( $attributes, $pluginOptionWhitelist );

		return wfArrayToCGI( $validatedAttributes );
	}
}
