<?php
class WysiwygParser extends Parser {

	/**
	 * Tag hook handler for 'pre'.
	 */
	function renderPreTag( $text, $attribs ) {
		// Backwards-compatibility hack
		$content = StringUtils::delimiterReplace( '<nowiki>', '</nowiki>', '$1', $text, 'i' );

		$attribs = Sanitizer::validateTagAttributes( $attribs, 'pre' );
		$attribs['wasHtml'] = 1;
		return wfOpenElement( 'pre', $attribs ) .
			Xml::escapeTagsOnly( $content ) .
			'</pre>';
	}

	# macbre: fixes RT #14031
	# catch ONLY raw external links
	function magicLinkCallback( $m ) {
		if ( isset( $m[1] ) && strval( $m[1] ) !== '' ) {
			# Skip anchor
			return $m[0];
		} elseif ( isset( $m[2] ) && strval( $m[2] ) !== '' ) {
			# Skip HTML element
			return $m[0];
		} elseif ( isset( $m[3] ) && strval( $m[3] ) !== '' ) {
			# Free external link
			return $this->makeFreeExternalLink( $m[0] );
		} else {
			return $m[0];
		}
	}

	var $mEmptyLineCounter = 0;

	# These next three functions open, continue, and close the list
	# element appropriate to the prefix character passed into them.
	#
	var $mListLevel = 0;
	var $mLast;
	var $bulletLevel = 0;

	/* private */ function openList( $char ) {
		$lastSection = $this->mLastSection;
		$result = $this->closeParagraph();
		if ( ':' == $char) {
			if ( substr($this->mCurrentPrefix, -1) == ':' && $this->mLastCommonPrefix ) {
				$this->mListLevel = strlen($this->mCurrentPrefix);
				$style = ' style="margin-left:'.($this->mListLevel*40).'px"';

				if ($this->mEmptyLineCounter%2 == 1) {
					$style .= ' _new_lines_before="1"';
				}

				if ($this->mListLevel > 1) {
					if ($this->mLast != 'close' && !empty($result)) {
						//
					}
					else if ( ($result == '') &&  !($this->mEmptyLineCounter%2 == 1) ) {
						$result .= '<!--NEW_LINE_1-->';
					}
					$result .= "<p{$style}>";
				}
				else {
					$result .= "<p{$style}>";
				}
				$this->mLast = 'open';
			}
			else {
				$result = '';

				// reset mLastSection for intended bullet lists
				$this->mLastSection = $lastSection;
			}
		}
		else if ( '*' == $char || '#' == $char ) {
			$indentLevel = strspn($this->mCurrentPrefix, ':');
			$style = ($indentLevel > 0 && $this->bulletLevel == 0) ? ' style="margin-left:'.($indentLevel*40).'px"' : '';

			if ($this->mEmptyLineCounter%2 == 1) {
				$style .= ' _wysiwyg_new_line="true"';
			}

			$style .= ' _wysiwyg_line_start="true"';

			$result .= '<' . ($char == '*' ? 'ul' : 'ol') . $style . '><li>';
			$this->bulletLevel++;
		}
		else if ( ';' == $char ) {
			$indentLevel = strspn($this->mCurrentPrefix, ':');
			if ($this->mEmptyLineCounter%2 == 1) {
				$attr = ' _wysiwyg_new_line="true"';
			}
			else {
				$attr = '';
			}
			$result .= '<p class="definitionTerm" style="margin-left: '.($indentLevel*40).'px"'.$attr.'>';
		}
		else { $result = '<!-- ERR 1 -->'; }

		return $result;
	}

	/* private */ function nextItem( $char ) {
		if ( ':' == $char ) {
			$this->mListLevel = strlen($this->mCurrentPrefix);
			$style = ' style="margin-left:'.($this->mListLevel*40).'px"';
			if ($this->mLast == 'close') {
				$this->mLast = 'next';
				return "<p{$style}>";
			}
			else {
				$this->mLast = 'next';
				return "</p><p{$style}>";
			}
		}
		else if ( '*' == $char || '#' == $char ) { return '</li><li>'; }
		else if ( ';' == $char ) {
			$indentLevel = strspn($this->mCurrentPrefix, ':');
			return '</p><p class="definitionTerm" style="margin-left: '.($indentLevel*40).'px">';
		}
		return '<!-- ERR 2 -->';
	}

	/* private */ function closeList( $char ) {

		if ( ':' == $char ) {
			if ( $this->mLast != 'close' ) {
				$this->mLast = 'close';
				$text = '</p>';
			}
			else {
				return '';
			}
		}
		else if ( '*' == $char ) { $text = '</li></ul>'; $this->bulletLevel--; $this->mLast = 'close'; }
		else if ( '#' == $char ) { $text = '</li></ol>'; $this->bulletLevel--; $this->mLast = 'close'; }
		else {	return '<!-- ERR 3 -->'; }
		return $text."\n";
	}
	/**#@-*/

	/**
	 * Parse headers and return html
	 *
	 * @private
	 */
	function doHeadings($text) {
		$fname = 'Parser::doHeadings';
		wfProfileIn($fname);
		for($i = 6; $i >= 1; --$i) {
			$h = str_repeat('=', $i);
			$text = preg_replace_callback( "/(\\s*)^$h(.+)$h(\\s*)$/mi",
				 create_function(
				 	'$matches', '$refId = Wysiwyg_SetRefId(\'heading\', array(\'level\' => '.$i.', \'linesBefore\' => count(explode("\n", $matches[1]))-1, \'linesAfter\' => count(explode("\n", $matches[3]))), false, true); return "$matches[1]<h'.$i.' refid=$refId>$matches[2]</h'.$i.'>";'
				 ),$text );
		}
		wfProfileOut($fname);
		return $text;
	}

	function formatHeadings( $text, $isMain=true ) {
		return $text;
	}

	function __construct( $conf = array() ) {
		parent::__construct($conf);

		// load hooks from $wgParser
		global $wgParser;
		$this->mTagHooks = & $wgParser->mTagHooks;
		$this->mStripList = & $wgParser->mStripList;
	}

}
