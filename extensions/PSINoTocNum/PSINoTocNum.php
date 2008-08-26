<?php
/**
 * @copyright Copyright © 2007, Benedikt Meuthrath, PSI AG
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 * This MediaWiki extension is funded by PSI AG. http://www.psi.de
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, version 2
 * of the License.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * See the GNU General Public License for more details.
 */

/**
 * This extension realizes a new MagicWord __NOTOCNUM__.
 * If an article contains this MagicWord numbering in the
 * table of contents (TOC) is disabled by extra CSS.
 *
 * How to use:
 * * include this extension in LocalSettings.php:
 *   require_once("extensions/PSINoTocNum.php");
 * * Add "__NOTOCNUM__" to any article.
 *
 * @author Benedikt Meuthrath
 * @version $Revision: 1.4 $
 */

if (!defined('MEDIAWIKI')) {
	die("This can not be run from command line");
}

$wgExtensionCredits['parserhook'][] = array(
	'name'        => 'PSINoTocNum',
	'version'     => '$Revision: 1.4 $',
	'author'      => 'Benedikt Meuthrath',
        'url'         => 'http://www.mediawiki.org/wiki/Extension:PSINoTocNum',
        'description' => 'New MagicWord "<nowiki>__NOTOCNUM__</nowiki>".',
	'descriptionmsg' => 'psinotocnum-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['PSINoTocNum'] = $dir . 'PSINoTocNum.i18n.php';


$wgHooks['MagicWordMagicWords'][] = 'PSINoTocNumMagicWordMagicWords';
$wgHooks['MagicWordwgVariableIDs'][] = 'PSINoTocNumMagicWordwgVariableIDs';
$wgHooks['LanguageGetMagic'][] = 'PSINoTocNumLanguageGetMagic';
$wgHooks['ParserBeforeInternalParse'][] = 'PSINoTocNumParserBeforeInternalParse';

function PSINoTocNumMagicWordMagicWords(&$magicWords) {
	$magicWords[] = 'MAG_NOTOCNUM';

	return true;
}

function PSINoTocNumMagicWordwgVariableIDs(&$wgVariableIDs) {
	$wgVariableIDs[] = MAG_NOTOCNUM;

	return true;
}

function PSINoTocNumLanguageGetMagic(&$magicWords, $langCode) {
	$magicWords[MAG_NOTOCNUM] = array( 0, "__NOTOCNUM__" );

	return true;
}

function PSINoTocNumParserBeforeInternalParse($parser, $text, $stripState) {
	if (MagicWord::get( MAG_NOTOCNUM )->matchAndRemove( $text ) ) {
		global $wgOut;
		$wgOut->addScript('
			<style type="text/css"><!-- .tocnumber {display:none;} --></style>
		');
	}

	return true;
}
