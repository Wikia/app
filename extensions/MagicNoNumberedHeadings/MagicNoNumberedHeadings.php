<?php
/**
 * @copyright Copyright © 2007, Purodha Blissenabch.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
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
 * This extension realizes a new MagicWord __NONUMBEREDHEADINGS__.
 * If an article contains this MagicWord, numbering of the
 * headings is disabled regardless of the user preference setting.
 * 
 * How to use:
 * * include this extension in LocalSettings.php:
 *   require_once($IP.'/extensions/MagicNoNumberedHeadings/MagicNoNumberedHeadings.php');
 * * Add "__NONUMBEREDHEADINGS__" to any article of your choice.
 *
 * @author Purodha Blissenbach
 * @version $Revision: 1.11 $
 */

if (!defined('MEDIAWIKI')) {
        die("This requires the MediaWiki enviroment.");
}

$wgExtensionCredits['parserhook'][] = array(
        'name' => 'MagicNoNumberedHeadings',
        'version' => '$Revision: 1.11 $',
        'author' => 'Purodha Blissenbach',
        'url' => 'http://www.mediawiki.org/wiki/Extension:MagicNoNumberedHeadings',
        'description' => 'Add MagicWord "<nowiki>__NONUMBEREDHEADINGS__</nowiki>".',
);
$wgHooks['MagicWordMagicWords'][] = 'MagicNoNumberedHeadingsMagicWordMagicWords';
$wgHooks['MagicWordwgVariableIDs'][] = 'MagicNoNumberedHeadingsMagicWordwgVariableIDs';
$wgHooks['LanguageGetMagic'][] = 'MagicNoNumberedHeadingsLanguageGetMagic';
$wgHooks['ParserBeforeInternalParse'][] = 'MagicNoNumberedHeadingsParserBeforeInternalParse';

function MagicNoNumberedHeadingsMagicWordMagicWords(&$magicWords)
{
        $magicWords[] = 'MAG_NONUMBEREDHEADINGS';
        return true;
}

function MagicNoNumberedHeadingsMagicWordwgVariableIDs(&$wgVariableIDs)
{
        $wgVariableIDs[] = MAG_NONUMBEREDHEADINGS;
        return true;
}

function MagicNoNumberedHeadingsLanguageGetMagic(&$magicWords, $langCode)
{
        switch($langCode)
        {
                case 'de' :
                        $magicWords[MAG_NONUMBEREDHEADINGS] = array( 0, '__KEINEÜERSCHRIFTENNUMMERIERUNG__', '__NONUMBEREDHEADINGS__' );
                        break;
                case 'ksh' :
                        $magicWords[MAG_NONUMBEREDHEADINGS] = array( 0, '__ÖVERSCHRIFTENITNUMMERIERE__', '__NONUMBEREDHEADINGS__' );
                        break;
                default :
                        $magicWords[MAG_NONUMBEREDHEADINGS] = array( 0, '__NONUMBEREDHEADINGS__' );
        }
        return true;
}

function MagicNoNumberedHeadingsParserBeforeInternalParse($parser, $text, $stripState)
{
        if (MagicWord::get( MAG_NONUMBEREDHEADINGS )->matchAndRemove( $text ) )
        {
                $parser->mOptions->mNumberHeadings = (FALSE);
        }
        return true;
}
