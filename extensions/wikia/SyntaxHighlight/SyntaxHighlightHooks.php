<?php
use Wikia\Util\Statistics\BernoulliTrial;

class SyntaxHighlightHooks {

	/**
	 * Whether we should override GeSHi
	 * Sampled at 1% in production
	 * @return bool
	 */
	public static function shouldReplaceGeshi() {
		global $wgDevelEnvironment, $wgRunningUnitTests;

		return $wgDevelEnvironment || $wgRunningUnitTests || ( new BernoulliTrial( 0.01 ) )->shouldSample();
	}

	/**
	 * Hook: ParserFirstCallInit
	 * Register handlers for <source> and <syntaxhighlight> tags with the MW parser
	 *
	 * @param Parser $parser
	 * @return bool
	 */
	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'source', 'SyntaxHighlightHooks::onRenderSyntaxHighlightTag' );
		$parser->setHook( 'syntaxhighlight', 'SyntaxHighlightHooks::onRenderSyntaxHighlightTag' );

		return true;
	}

	/**
	 * Process <source> and <syntaxhighlight> tags in wikitext
	 *
	 * @param string $content
	 * @param array $attributes
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @return string
	 */
	public static function onRenderSyntaxHighlightTag( string $content, array $attributes, Parser $parser, PPFrame $frame ): string {
		if ( !isset( $attributes['lang'] ) ) {
			return Wikia::errorbox( 'No language specified for syntax highlight' );
		}

		// Replace strip markers (For e.g. {{#tag:syntaxhighlight|<nowiki>...}})
		$content = $parser->mStripState->unstripNoWiki( $content );

		return static::addModuleAndWrapCode( $parser->getOutput(), $attributes['lang'], $content );
	}

	/**
	 * Hook: ShowRawCssJs
	 * Prepare MediaWiki CSS and JS pages for syntax highlighting
	 *
	 * @param string $content
	 * @param Title $title
	 * @param OutputPage $out
	 * @return bool
	 */
	public static function onShowRawCssJs( string $content, Title $title, OutputPage $out ): bool {
		$matches= [];
		preg_match( '!\.(css|js)$!u', $title->getText(), $matches );
		$lang = array_pop( $matches );

		$html = static::addModuleAndWrapCode( $out, $lang, $content );
		$out->addHTML( $html );

		return false;
	}

	/**
	 * Escape and wrap the user-provided code in a <pre> tag, and add extension module to output
	 *
	 * @param OutputPage|ParserOutput $out
	 * @param string $lang
	 * @param string $content
	 * @return string
	 */
	protected static function addModuleAndWrapCode( $out, string $lang, string $content ): string {
		if ( F::app()->checkSkin( 'oasis' ) && SassUtil::isThemeDark() ) {
			$out->addModules( 'ext.syntaxHighlight.dark' );
		} else {
			$out->addModules( 'ext.syntaxHighlight.light' );
		}

		return Html::element( 'pre', [ 'class' => "source $lang", 'dir' => 'ltr' ], $content );
	}
}
