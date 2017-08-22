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
		$pluginOptionWhitelist = FacebookTagConstants::SUPPORTED_TAG_ATTRIBUTES +
								 FacebookTagConstants::FB_PLUGIN_OPTS[$this->tagName];
		$tagAttributes = Sanitizer::validateAttributes( $attributes, $pluginOptionWhitelist );

		// used as selector by JS to determine if there are any widgets to render on the page
		$tagAttributes += [
			'data-type' => 'xfbml-tag'
		];

		return Html::element( "fb:{$this->tagName}", $tagAttributes );
	}
}
