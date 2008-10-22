<?php
/**
 * @package MediaWiki
 * @subpackage WidgetsSpecialPage
 *
 * @author Maciej Brencz <macbre@wikia.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        exit( 1 );
}       


class WidgetsSpecialPage extends SpecialPage
{
        function WidgetsSpecialPage() {
                SpecialPage::SpecialPage('Widgets');
        }

	// loads all widgets from ./Widgets subdir and returns list of their names
	function getWidgetsList() {

	    $widgets = array();
	    
	    $dir = dirname(__FILE__).'/../WidgetFramework/Widgets/';
	    if(is_dir($dir)) {
	        if($dh = opendir($dir)) {
	    	    while(($file = readdir($dh)) !== false) {
		        // ignore . .. .svn
			if ($file{0} != '.') {
			    $src = $dir . $file . '/' . $file . '.php';
			    if (file_exists($src)) {
				require_once($src);
				$widgets[] = $file;
			    }
			}
		    }
		    closedir($dh);
		}
	    }

	    return $widgets;
	}
	

	function execute( $par ) {
		global $wgOut, $wgLang, $wgUser, $wgWidgets, $wgExtensionsPath, $wgStyleVersion;

		$this->setHeaders();

		wfLoadExtensionMessages('WidgetsSpecialPage');
		
		// load extension JS/CSS
		$wgOut->addScript('<link rel="stylesheet" type="text/css" href="'.$wgExtensionsPath.'/wikia/WidgetSpecialPage/WidgetsSpecialPage.css?'.$wgStyleVersion.'" />' . "\n");
		$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/WidgetSpecialPage/WidgetsSpecialPage.js?'.$wgStyleVersion.'"></script>' . "\n");
		
		// detect skin
		$skinname = get_class($wgUser->getSkin());
	
		if ( !in_array( $skinname, array('SkinQuartz', 'SkinMonaco')) ) {  
			$wgOut->addHTML( '<div id="widgets-info" class="plainlinks">' . wfMsgExt('widgets-specialpage-info', 'parse') . '</div>' );
		}

		$wgOut->addWikiText(wfMsg('widgets-specialpage-try-dashboard'));

		// get list of widgets and load'em all
		$widgets = $this->getWidgetsList();
		
		//print_pre($widgets); print_pre($wgWidgets); //return;
		
		// user language code
		$langCode = $wgLang->getCode();
		
		$wgOut->addHTML('<!-- '.count($widgets).' widgets avalaible and still counting -->'."\n\n\n");
		
		$wgOut->addHTML('<div id="widgetsSpecialPageList">'."\n");
		
		// print out list of widgets with thumbs icons
		foreach($widgets as $w => $widget) {
		
			$data = $wgWidgets[$widget];
			
			// don't list some widgets on special page
			if ( (isset($data['listable']) && ($data['listable'] == false)) || empty($data['desc']) ) {
			    continue;
			}
			
			$name = isset($data['title'][$langCode]) ? $data['title'][$langCode] : $data['title']['en'];
			$desc = isset($data['desc'][$langCode])  ? $data['desc'][$langCode]  : $data['desc']['en'];

			$thumbClass = $widget . 'Thumb';
		
			$wgOut->addHTML('<dl>'."\n\t".
				'<dt class="' . ($skinname == 'SkinMonaco' ? $thumbClass : '') . '">'.
				($wgUser->isLoggedIn() ? '<div class="add" id="widgets_special_page-' . $widget . '-add"></div>' : '').
				'<div class="widgetsThumb ' . ($skinname == 'SkinQuartz' ? $thumbClass : '')  .'" title="'.htmlspecialchars($name).'"'.
				'>&nbsp;</div></dt>'."\n\t".
				'<dd><h4>'.htmlspecialchars($name).
				'</h4><p>'.htmlspecialchars($desc).'</p></dd>'."\n".'</dl>'.
				"\n\n");
		}
		
		$wgOut->addHTML('</div>');

		
		// print out copyright stuff for graphics used in widget framework
		$wgOut->addHTML('<div class="clearfix"></div><p id="widgetsSpecialPageCopyrights">Widgets are using '.
						  '<a href="http://www.famfamfam.com/lab/icons/silk/">Silk Icons</a> licensed under <a href="http://creativecommons.org/licenses/by/2.5/">Creative Commons Attribution 2.5 License</a> '.
						  'and Tango &amp; Gnome <a href="http://art.gnome.org/themes/icon/">icon themes</a> from <a href="http://www.gnome.org/">Gnome</a></p>');
		}
	}
