<?php
/**
 * MediaWiki math extension
 *
 * (c) 2002-2012 Tomasz Wegrzanowski, Brion Vibber, Moritz Schubotz and other MediaWiki contributors
 * GPLv2 license; info in main package.
 *
 * Renderer for MathJax
 * @file
 */


/**
 * Takes LaTeX fragments and outputs the source directly to the browser
 *
 * @author Tomasz Wegrzanowski
 * @author Brion Vibber
 * @author Moritz Schubotz
 * @ingroup Parser
 */
class MathMathJax extends MathRenderer {
	function render() {
		# No need to render or parse anything more!
		# New lines are replaced with spaces, which avoids confusing our parser (bugs 23190, 22818)
		$tex = '$ ' . str_replace( "\n", " ", $this->tex ) . ' $';

		$attributes = [
			'class' => 'tex',
			'dir' => 'ltr'
		];

		// Wikia change - mark span tags with an attribute
		// so that mobile-wiki's widget framework can handle them
		$isMobileSkin = ( new WikiaTagBuilderHelper() )->isMobileSkin();
		if ( $isMobileSkin ) {
			$attributes['data-wikia-widget'] = 'math';
			$attributes['data-tex'] = $tex;
			$attributes['class'] = '';
		}

		return Xml::element( 'span',
			$this->getAttributes(
				'span',
				$attributes
			),
			$isMobileSkin ? '' : $tex
		);
	}
}
