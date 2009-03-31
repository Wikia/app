<?php
/**
 * CSS extension - A parser-function for adding CSS files, article or inline rules to articles
 *
 * See http://www.mediawiki.org/wiki/Extension:CSS for installation and usage details
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Aran Dunkley [http://www.organicdesign.co.nz/nad User:Nad]
 * @copyright © 2007 Aran Dunkley
 * @licence GNU General Public Licence 2.0 or later
 */

if (!defined('MEDIAWIKI')) die('Not an entry point.');

define('CSS_VERSION', '1.0.6, 2008-10-27');

$wgCSSMagic                    = "css";
$wgExtensionFunctions[]        = 'wfSetupCSS';
$wgHooks['LanguageGetMagic'][] = 'wfCSSLanguageGetMagic';

$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'CSS',
	'author'         => '[http://www.organicdesign.co.nz/nad User:Nad]',
	'description'    => 'A parser-function for adding CSS files, article or inline rules to articles',
	'descriptionmsg' => 'css-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:CSS',
	'version'        => CSS_VERSION,
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['CSS'] = $dir . 'CSS.i18n.php';

class CSS {

	function CSS() {
		global $wgParser, $wgCSSMagic;
		$wgParser->setFunctionHook($wgCSSMagic, array($this, 'magicCss'));
		}

	function magicCss(&$parser, $css) {
		global $wgOut, $wgRequest, $wgTitle;
		$parser->mOutput->mCacheTime = -1;
		$url = false;
		if (ereg('\\{', $css)) {

			# Inline CSS
			$css = htmlspecialchars(trim(Sanitizer::checkCss($css)));
			$parser->mOutput->addHeadItem( <<<EOT
<style type="text/css">
/*<![CDATA[*/
{$css}
/*]]>*/
</style>
EOT
			);
		} elseif ($css{0} == '/') {

			# File
			$url = $css;

		} else {

			# Article?
			$title = Title::newFromText($css);
			if (is_object($title)) {
				$url = $title->getLocalURL('action=raw&ctype=text/css');
				$url = str_replace("&", "&amp;", $url);
			}
		}
		if ($url) $wgOut->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"$url\" />");
		return '';
	}

	# Needed in some versions to prevent Special:Version from breaking
	function __toString() { return 'CSS'; }
}

/**
 * Called from $wgExtensionFunctions array when initialising extensions
 */
function wfSetupCSS() {
	global $wgCSS;
	$wgCSS = new CSS();
}

/**
 * Needed in MediaWiki >1.8.0 for magic word hooks to work properly
 */
function wfCSSLanguageGetMagic(&$magicWords, $langCode = 0) {
	global $wgCSSMagic;
	$magicWords[$wgCSSMagic] = array($langCode, $wgCSSMagic);
	return true;
}
