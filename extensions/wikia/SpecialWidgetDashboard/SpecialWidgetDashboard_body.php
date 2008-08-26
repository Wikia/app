<?php
/**
 * @package MediaWiki
 * @subpackage WidgetDahboard
 *
 * @author Inez Korczynski
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class SpecialWidgetDashboard extends SpecialPage {

	function SpecialWidgetDashboard() {
		global $wgMessageCache;
		$wgMessageCache->addMessage('widgetdashboard', 'WidgetDashboard');
		SpecialPage::SpecialPage("WidgetDashboard");
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		$this->setHeaders();

		if(WidgetFramework::getInstance()->GetSkin() == 'monaco') {
			$wgOut->addHTML('<div class="sidebar widget_sidebar widget_dashboard">');
			$wgOut->addHTML('<div id="sidebar_3" class="sidebar" style="display:inline; float: left; width: 15.45em; margin-right: 8px; padding-bottom: 75px">');
			$wgOut->addHTML(WidgetFramework::getInstance()->Draw(3));
			$wgOut->addHTML('</div>');
			$wgOut->addHTML('<div id="sidebar_4" class="sidebar" style="display:inline; float: left; width: 15.45em; padding-bottom: 75px">');
			$wgOut->addHTML(WidgetFramework::getInstance()->Draw(4));
			$wgOut->addHTML('</div>');
			$wgOut->addHTML('<div id="sidebar_5" class="sidebar" style="display:inline; float: left; width: 15.45em; margin-left: 8px; padding-bottom: 75px">');
			$wgOut->addHTML(WidgetFramework::getInstance()->Draw(5));
			$wgOut->addHTML('</div>');
			$wgOut->addHTML('</div>');
			$wgOut->addHTML('<div style="clear:both"></div>');
		} else if(WidgetFramework::getInstance()->GetSkin() == 'quartz') {
			$wgOut->addHTML('<ul class="widgets dashboard widgets_vertical" id="dashboard_3">');
			$wgOut->addHTML(WidgetFramework::getInstance()->Draw(3));
			$wgOut->addHTML('</ul>');
			$wgOut->addHTML('<ul class="widgets dashboard widgets_vertical" id="dashboard_4">');
			$wgOut->addHTML(WidgetFramework::getInstance()->Draw(4));
			$wgOut->addHTML('</ul>');
			$wgOut->addHTML('<ul class="widgets dashboard widgets_vertical" id="dashboard_5">');
			$wgOut->addHTML(WidgetFramework::getInstance()->Draw(5));
			$wgOut->addHTML('</ul>');
		} else {
			$wgOut->addHTML('<p>Widget Dashboard works best with one of the new skins, eg. <a href="./Special:WidgetDashboard?useskin=monaco">Monaco</a>.</p>');
			$wgOut->addHTML('<p>Please change <a href="./Special:Preferences">your preferences</a> to use this tool.</p>');
		}

	}
}
