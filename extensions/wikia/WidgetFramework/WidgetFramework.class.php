<?php
/**
 * @author Inez Korczynski <inez@wikia.com>
 */
class WidgetFramework {

	// PRIVATE FIELDS
	protected static $instance = false;
	protected $skinname = null;
	private $config;

	/**
	 * @static
	 * @return WidgetFramework
	 */
	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new WidgetFramework();
		}
		return self::$instance;
	}

	protected function __construct() {
		switch (get_class(RequestContext::getMain()->getSkin())) {
			case "SkinOasis":
				$this->skinname = 'oasis';
				break;
			default:
				# This is a generalization, but we don't really care
				# most of the times -- widgets are only displayed on
				# Quartz and Monaco.
				# We do care for things like Special:WidgetDashboard
				$this->skinname = 'monobook';
		}
	}

	protected function load($name) {
		wfProfileIn(__METHOD__);

		if(file_exists(dirname(__FILE__) . '/Widgets/' . $name . '/' . $name . '.php')) {
			require_once(dirname(__FILE__) . '/Widgets/' . $name . '/' . $name . '.php');
			$ret = true;
		} else {
			$ret = false;
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	protected function getParams($widget) {
		global $wgWidgets;
		$params = array();
		if(isset($wgWidgets[$widget['type']]['params'])) {
			foreach($wgWidgets[$widget['type']]['params'] as $key => $val) {
				if(isset($widget['param']) && isset($widget['param'][$key])) {
					$params[$key] = $widget['param'][$key];
				} else {
					$params[$key] = $val['default'];
				}
			}
		}
		return $params;
	}

	protected function getAssets($widget) {
		wfProfileIn(__METHOD__);

		$name = $widget['type'];
		$assets = array();

		if(file_exists(dirname(__FILE__) . '/Widgets/' . $name . '/' . $name . '.js')) {
			$assets[] = "/extensions/wikia/WidgetFramework/Widgets/{$name}/{$name}.js";
		}

		if(file_exists(dirname(__FILE__) . '/Widgets/' . $name . '/' . $name . '.css')) {
			$assets[] = "/extensions/wikia/WidgetFramework/Widgets/{$name}/{$name}.css";
		}

		if (!empty($assets)) {
			$jsOut = JSSnippets::addToStack( $assets );
		}
		else {
			$jsOut = '';
		}

		wfProfileOut(__METHOD__);
		return $jsOut;
	}

	protected function wrap($widget, $widgetOut, $skin = null) {
		global $wgWidgets, $wgUser, $wgLang, $wgStylePath;

		if(is_array($widgetOut)) {
			if(!empty($widgetOut['nowrap'])) {
				$nowrap = true;
			}
			if(isset($widgetOut['body'])) {
				$body = $widgetOut['body'];
			}
			if(isset($widgetOut['title'])) {
				$title = $widgetOut['title'];
			}
			if(isset($widgetOut['reload'])) {
				$reload = ($widgetOut['reload'] === true);
			}
		} else {
			$body = $widgetOut;
		}

		if (!empty($reload)) {
		    return true;
		}

		if(!empty($nowrap)) {
			return $body;
		}

		$contentLang = false;
		if ( !empty( $wgWidgets[$widget['type']]['contentlang'] ) ) {
			$contentLang = true;
		}

		if(empty($title)) {
			if ( empty( $contentLang ) ) {
				$title = wfMsg( $wgWidgets[$widget['type']]['title'] );
			} else {
				$title = wfMsgForContent( $wgWidgets[$widget['type']]['title'] );
			}
		}

		$closeable = false;
		$editable = false;

		if($wgUser->isLoggedIn()) {
			if(!empty($wgWidgets[$widget['type']]['closeable'])) {
				$closeable = true;
			}
			if(!empty($wgWidgets[$widget['type']]['editable'])) {
				$editable = true;
			}
		}

		// Close and Edit buttons make no sense for tags
		if (!empty($widget['widgetTag'])) {
			$closeable = $editable = false;
		}

		if($body == '') {
			return '';
		}

		// generate xHTML valid nodes ID (refs RT #9584 and #17185)
		if (empty($widget['widgetTag'])) {
			$widget['id'] = 'widget_' . $widget['id'];
		}

		if($this->skinname=='oasis') {
			global $wgBlankImgUrl;
			$closeButton = ($closeable) ? "<img src=\"$wgBlankImgUrl\" id=\"{$widget['id']}_close\" class=\"sprite-small close\" />" : '&nbsp;';
			$editButton  = ($editable) ? "<img src=\"$wgBlankImgUrl\" id=\"{$widget['id']}_edit\" class=\"sprite-small settings\" />" : '&nbsp;';
			$editForm  = ($editable) ? "<dd style=\"display: none;\" class=\"shadow widget_contents\" id=\"{$widget['id']}_editform\"></dd>" : '';
			return "<dl class=\"widget {$widget['type']}\" id=\"{$widget['id']}\"><dt class=\"color1 widget_title\" id=\"{$widget['id']}_header\"><span class=\"widgetToolbox\">{$closeButton}{$editButton}</span>{$title}</dt><dd class=\"shadow widget_contents\" id=\"{$widget['id']}_content\">{$body}</dd>{$editForm}</dl>";
		} else {
			// ..should never occur
		}
	}

	private function DrawOne($widget, $wrap = true) {
		global $wgWidgets;
		$params = $this->getParams($widget);
		$params['skinname'] = $this->skinname;

		$widgetOut = $wgWidgets[$widget['type']]['callback']('widget_' . $widget['id'], $params);
		$widgetOut .= $this->getAssets($widget);
		if($wrap) {
			return $this->wrap($widget, $widgetOut);
		} else {
			return $widgetOut;
		}
	}

	public function Draw($sidebar) {
		global $wgWidgets;
		$output = array();
		if(isset($this->config[$sidebar])) {
			foreach($this->config[$sidebar] as $widget) {
				if($this->load($widget['type'])) {
					$output[] = $this->DrawOne($widget);
				} else {
					// ..should never occur
				}
			}
		}
		return implode('', $output);
	}

	/**
	 * @return array
	 * @author Maciej Brencz
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	public static function callAPI($params) {
		wfProfileIn(__METHOD__);

		try {
			$api = new ApiMain(new FauxRequest($params));
			$api->execute();
			$output = $api->getResultData();
		} catch(Exception $e) {
			$output = array();
		}

		wfProfileOut( __METHOD__ );
		return $output;
	}

	/**
	 * @return string
	 * @author Inez Korczynski <inez@wikia.com>
	 */
	public static function wrapLinks($links) {
		wfProfileIn(__METHOD__);

		$out = '';
		if(is_array($links) && count($links) > 0) {
			$out = '<ul>';
			foreach($links as $link) {
				$out .= '<li>';
				$out .= '<a href="'.htmlspecialchars($link['href']).'"'.(isset($link['title']) ? ' title="'.htmlspecialchars($link['title']).'"' : '').(!empty($link['nofollow']) ? ' rel="nofollow"' : '').'>'.htmlspecialchars($link['name']).'</a>';
				if(isset($link['desc'])) {
					$out .= '<br/>'.$link['desc'];
				}
				$out .= '</li>';
			}
			$out .= '</ul>';
		}

		wfProfileOut( __METHOD__ );
		return $out;
	}

	/**
	 * @return string
	 * @author Maciej Brencz
	 */
	public static function moreLink($link) {
		return '<div class="widgetMore"><a href="'.htmlspecialchars($link).'">'.wfMsg('moredotdotdot').'</a></div>';
	}

	/**
	 * @return string
	 * @author Inez Korczyński
	 * @author Maciej Brencz
	 */
	public static function getArticle($title, $ns = NS_MAIN ) {
		wfProfileIn(__METHOD__);

		$titleObj = Title::newFromText($title, $ns);
		if ( !is_object($titleObj) ) {
			wfProfileOut(__METHOD__);
			return false;
		}
		$revision = Revision::newFromTitle( $titleObj );
		if(is_object($revision)) {
			wfProfileOut(__METHOD__);
			return $revision->getText();
		}

		wfProfileOut(__METHOD__);
		return false;
	}

}
