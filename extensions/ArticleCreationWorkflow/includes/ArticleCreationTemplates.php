<?php

/**
 * Object for creating HTML template
 */
class ArticleCreationTemplates {

	/**
	 * Retrieves an ArticleCreationLanding page for the given page title.
	 * @param $page String: The page name passed on the URL.
	 * @return String HTML
	 */
	public static function getLandingPage( $page ) {
		$action = wfMessage( 'ac-action-indicator' )->escaped();
		global $wgUser, $wgArticleCreationButtons;

		$title = Title::newFromText( $page );

		$html = '';
		$buttons = array();
		if ( ! $title->userCan('create') || ! $title->userCan('edit') ) {
			$html .= wfMessage( 'ac-landing-login-required' )->parse();
			$buttons = $wgArticleCreationButtons['anonymous'];
		} else {
			$buttons = $wgArticleCreationButtons['logged-in'];
		}

		$buttons = self::formatButtons( $buttons, $page );

		$html .= <<<HTML
			<span class="article-creation-heading">$action</span>
			<div id="article-creation-panel">
				$buttons
			</div>
HTML;

		return $html;
	}

	/**
	 * Formats a set of buttons from an array.
	 * @param $description Associative array. Keys are button names,
	 *  Values are associative arrays suitable to pass to formatButton
	 * @param $page String: The page name passed on the URL.
	 * @return String HTML
	 * @see ArticleCreationTemplates::formatButton
	 */
	public static function formatButtons( $description, $page ) {
		$buttons = '';

		foreach ( $description as $button => $info ) {
			$buttons .= self::formatButton(
				$button,
				$info,
				$page
			);
		}

		return $buttons;
	}

	/**
	 * Formats a single button.
	 * @param $button String name of the button.
	 * @param $info Associative array. Valid keys:
	 * title: (required) Message key to use for the button's major text.
	 * text: (required) Message key for help message to display on the
	 *	lower part of the button.
	 * color: (default: blue) The colour to show the button in
	 * tooltip: Associative array with keys title and text, message keys.
	 * 	For a tooltip that is displayed when the button is hovered over.
	 *	Both messages will be parsed as Wikitext before display.
	 * interstitial: HTML to be passed through jquery.localize() for an
	 *	interstitial to be shown before going ahead with the action.
	 * 	Should contain a button with the class ac-action-button that
	 * 	proceeds with the action.
	 * 	*MAY* also contain a checkbox with the class ac-dismiss-interstitial
	 *	that will be used to dismiss that interstitial.
	 * @param $page String: The page name passed on the URL.
	 * @return String HTML
	 */
	public static function formatButton( $button, $info, $page ) {
		global $wgArticleCreationConfig, $wgScript, $wgUser;
		
		// Figure out title
		if ( empty($info['title'] ) ) {
			throw new MWException( "Buttons require a title" );
		}

		$buttonTitle = wfMessage($info['title'])->escaped();

		// Figure out help text
		if ( !empty($info['text']) ) {
			$buttonText = wfMessage($info['text'])->escaped();
		} else {
			$buttonText = '';
		}

		// Ensure colour is set correctly
		$color = 'blue';
		if ( !empty($info['color']) ) {
			$color = $info['color'];
		}

		// Work out tooltips
		$tips = '';
		if ( !empty($info['tooltip'] ) ) {
			$tips .= self::formatTooltip(
				$info['tooltip']['title'],
				$info['tooltip']['text']
			);
		}

		if ( ! empty($info['interstitial'] ) ) {
			$content = $info['interstitial'];
			$tips .= self::formatInterstitial( $content );
		}

		// Get the action URL
		$target = htmlspecialchars( $wgArticleCreationConfig['action-url'][$button] );

		$replacements = array(
			'{{SCRIPT}}' => $wgScript,
			'{{USER}}' => $wgUser,
			'{{PAGE}}' => $page,
		);

		$target = strtr( $target, $replacements );

		return <<<HTML
		<div class="ac-button-wrap">
			<a class="ac-article-button ac-button ac-button-$color ac-article-$button" data-ac-button="$button" href="$target">
				<div class="ac-arrow ac-arrow-forward">&nbsp;</div>
				<div class="ac-button-text">
					<div class="ac-button-title">$buttonTitle</div>	
					<div class="ac-button-body">$buttonText</div>
				</div>
			</a>
			$tips
		</div>
HTML;
	}

	/**
	 * Formats a tooltip for a button.
	 * @param $titleMsg Message key for the title text of the tooltip. Will be parsed.
	 * @param $bodyMsg Message key for the tooltip content. Will be parsed.
	 * @return String HTML
	 */
	public static function formatTooltip( $titleMsg, $bodyMsg ) {
		if ( ! $titleMsg ) {
			return '';
		}

		$title = wfMessage( $titleMsg )->parse();

		if ( $bodyMsg ) {
			$contents = wfMessage( $bodyMsg )->parse();
		} else {
			$contents = '';
		}

		return <<<HTML
			<div class="mw-ac-tip mw-ac-tooltip" style="display: none;">
				<div class="mw-ac-tooltip-pointy"></div>
				<div class="mw-ac-tooltip-innards">
					<div class="mw-ac-tooltip-title">$title</div>
					<div class="mw-ac-tooltip-body">$contents</div>
				</div>
			</div>
HTML;
	}

	/**
	 * Formats an interstitial tooltip shown when certain buttons are clicked.
	 * @param $content String HTML content, to be passed through jQuery.localize() on the client side.
	 * @return String HTML
	 */
	public static function formatInterstitial( $content ) {
		if ( ! $content ) {
			return '';
		}

		return <<<HTML
			<div class="mw-ac-tip mw-ac-interstitial" style="display: none;">
				<div class="mw-ac-tooltip-pointy"></div>
				<div class="mw-ac-tooltip-innards">
				$content
				</div>
			</div>
HTML;
	}
	
	/**
	 * Stub for a replacement Missing Page.
	 * @param $article Article object for the page that was requested.
	 * @return String HTML
	 */
	public static function showMissingPage( $article ) {
		$link = wfMessage( 'ac-link-create-article' )->params( 
					SpecialPage::getTitleFor( 'ArticleCreationLanding', $article->getTitle()->getPrefixedText() 
					)->getPrefixedText() )->parse();
		return <<<HTML
				<div>
					$link
				</div>
HTML;
	}
	
}



