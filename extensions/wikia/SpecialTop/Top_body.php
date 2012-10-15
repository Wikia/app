<?php
/**
 * @package MediaWiki
 * @subpackage Top
 *
 * @author Inez Korczynski <inez@wikia.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// TODO: use autoloader instead
global $IP;
require_once("$IP/extensions/wikia/DataProvider/DataProvider.php");

class Top extends SpecialPage
{
        function __construct() {
			parent::__construct("Top", "", false);
        }

        function execute( $par ) {
			global $wgOut;

			$this->setHeaders();
			$topFiveArray = DataProvider::GetTopFiveArray();

			if ( empty ( $par ) ) {
				//no sub gets generic title
				$wgOut->setPageTitle( "Top" );

				//use array keys of known modules to build menu to them
				$wgOut->addHtml("<ul>");
				foreach($topFiveArray[0] as $sub=>$junk) {
					$wgOut->addHtml("<li><a href=\"".
						SpecialPage::getTitleFor( 'Top', $sub )->getLocalUrl() .
						"\">". wfMsg($sub) . "</a></li>");
				}
				$wgOut->addHtml("</ul>");
				return false;
			}

			if ( count ( $topFiveArray ) != 2 || ! isset($topFiveArray[0][$par]) ) {
				$wgOut->setPageTitle( "Error" ); // par wasnt in known module list, so cant use for title
				return false;
			}

			//we can trust par for use in title now
			$wgOut->setPageTitle( wfMsg($par) );

			$wgOut->addHtml("<ul>");
			$results = DataProvider::$topFiveArray[0][$par](25);
			if ( is_array( $results ) ) {
				foreach($results as $val) {
					$wgOut->addHtml("<li><a href=\"{$val['url']}\">{$val['text']}</a></li>");
				}
			}
			$wgOut->addHtml("</ul>");
        }
}
