<?php
/**
 * @package MediaWiki
 * @subpackage Top
 *
 * @author Inez Korczynski <inez@wikia.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

global $IP;
require_once("$IP/extensions/wikia/DataProvider/DataProvider.php");

class Top extends SpecialPage
{
        function Top() {
                SpecialPage::SpecialPage("Top", "", false);
        }

        function execute( $par ) {
			global $wgRequest, $wgOut;

			$this->setHeaders();
			$wgOut->setPageTitle( wfMsg($par) );

			if ( empty ( $par ) ) {
				return false;
			}
			$topFiveArray = DataProvider::GetTopFiveArray();
			if ( count ( $topFiveArray ) != 2 || ! isset($topFiveArray[0][$par]) ) {
				return false;
			}

			$wgOut->addHtml("<ul>");
			$results = DataProvider::$topFiveArray[0][$par](25);
			foreach($results as $val) {
				$wgOut->addHtml("<li><a href=\"{$val['url']}\">{$val['text']}</a></li>");
			}

			$wgOut->addHtml("</ul>");
        }
}

?>
