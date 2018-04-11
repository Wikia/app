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
		return Xml::element( 'span',
			$this->getAttributes(
				'span',
				array(
					'class' => 'tex',
					'dir' => 'ltr'
				)
			),
			'$ ' . str_replace( "\n", " ", $this->tex ) . ' $'
		);
	}
}
