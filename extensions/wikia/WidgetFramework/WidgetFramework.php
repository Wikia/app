<?php
/*
 * Widget Framework
 * @author Inez Korczyński
 */
if(!defined('MEDIAWIKI')) {
	die(1);
}

$wgExtensionCredits['specialpage'][] = array(
    'name' => 'WidgetFramework',
    'author' => 'Inez Korczyński',
);

/**
 * IMPORTANT: If you want to make any changes in this class or in any part of widget
 * framework (also JS) then you need to discuss it with me.
 *
 * @author Inez Korczynski <inez@wikia.com>
 */
class WidgetFramework {

	// PRIVATE FIELDS

	protected static $instance = false;

	protected $skinname = null;

	private $config;

	// PRIVATE METHODS

	protected function __construct() {
		global $wgUser;

		switch (get_class($wgUser->getSkin())) {
		case "SkinMonaco":
			$this->skinname = 'monaco';
			break;
		case "SkinQuartz":
			$this->skinname = 'quartz';
			break;
		default:
			# This is a generalization, but we don't really care
			# most of the times -- widgets are only displayed on
			# Quartz and Monaco.
			# We do care for things like Special:WidgetDashboard
			$this->skinname = 'monobook';
		}

		$this->loadConfig();
	}

	private function loadConfig() {
		global $wgUser;

		if($wgUser->isLoggedIn()) {
			$this->config = unserialize($wgUser->getOption('widgets'));
		}

		if(empty($this->config) && !is_array($this->config)) {
			if($this->skinname == "monaco") {
				$this->config = array(
					1 => array(
						array('type' => 'WidgetSidebar', 'id' => 202),
						array('type' => 'WidgetWikiaToolbox', 'id' => 203),
						array('type' => 'WidgetWikiaPartners', 'id' => 204),
						array('type' => 'WidgetCommunity', 'id' => 101),
						array('type' => 'WidgetAdvertiser', 'id' => 102),
						array('type' => 'WidgetLanguages', 'id' => 103),
						array('type' => 'WidgetRelatedCommunities', 'id' => 104),
					),
				);
			} else if($this->skinname == "quartz") {
				$this->config = array(
					1 => array(
						array('type' => 'WidgetCommunity', 'id' => 101),
						array('type' => 'WidgetLanguages', 'id' => 103),
						array('type' => 'WidgetRelatedCommunities', 'id' => 104),
						array('type' => 'WidgetTopContent', 'id' => 201),
						array('type' => 'WidgetSidebar', 'id' => 202),
						array('type' => 'WidgetWikiaToolbox', 'id' => 203),
						array('type' => 'WidgetWikiaPartners', 'id' => 204),
						array('type' => 'WidgetGamespot', 'id' => 205),
						array('type' => 'WidgetAdvertiser', 'id' => 206),
					),
				);
			}
		}

		// TEMPORARY FIX BY INEZ START
		global $isWidgetCommunity, $isWidgetSidebar, $isWidgetWikiaToolbox, $isWidgetLanguages;
		$isWidgetCommunity = $isWidgetSidebar = $isWidgetWikiaToolbox = $isWidgetLanguages = false;

		if (!function_exists('tempFunc')) {
			function tempFunc($item, $key) {
				if($item == 'WidgetCommunity') {
					global $isWidgetCommunity;
					$isWidgetCommunity = true;
				} else if($item == 'WidgetSidebar') {
					global $isWidgetSidebar;
					$isWidgetSidebar = true;
				} else if($item == 'WidgetWikiaToolbox') {
					global $isWidgetWikiaToolbox;
					$isWidgetWikiaToolbox = true;
				} else if($item == 'WidgetLanguages') {
					global $isWidgetLanguages;
					$isWidgetLanguages = true;
				}
			}
		}

		array_walk_recursive($this->config[1], 'tempFunc');

		if(!$isWidgetCommunity) {
			$this->config[1][] = array('type' => 'WidgetCommunity', 'id' => 101);
		}
		if(!$isWidgetSidebar) {
			$this->config[1][] = array('type' => 'WidgetSidebar', 'id' => 202);
		}
		if(!$isWidgetWikiaToolbox) {
			$this->config[1][] = array('type' => 'WidgetWikiaToolbox', 'id' => 203);
		}
		if(!$isWidgetLanguages) {
			$this->config[1][] = array('type' => 'WidgetLanguages', 'id' => 103);
		}
		// TEMPORARY FIX BY INEZ STOP

		if(!isset($this->config[3])) {
			$this->config[3] = array(
						array('type' => 'WidgetActiveTalkPages', 'id' => 301),
						array('type' => 'WidgetShoutBox', 'id' => 302),
						array('type' => 'WidgetMostVisited', 'id' => 303)
					);
		}
		if(!isset($this->config[4])) {
			$this->config[4] = array(
						array('type' => 'WidgetNeedHelp', 'id' => 401),
						array('type' => 'WidgetWatchlist', 'id' => 402),
						array('type' => 'WidgetSlideshow', 'id' => 403)
					);
		}
		if(!isset($this->config[5])) {
			$this->config[5] = array(
						array('type' => 'WidgetTopVoted', 'id' => 501),
						array('type' => 'WidgetReferrers', 'id' => 502)
					);
		}
	}

	protected function load($name) {
		if(file_exists(dirname(__FILE__) . '/Widgets/' . $name . '/' . $name . '.php')) {
			require_once(dirname(__FILE__) . '/Widgets/' . $name . '/' . $name . '.php');
			return true;
		} else {
			return false;
		}
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

	protected function wrap($widget, $widgetOut, $skin = null) {
		global $wgWidgets, $wgUser, $wgLang;

		if(is_array($widgetOut)) {
			if(isset($widgetOut['title'])) {
				$title = $widgetOut['title'];
			}
			if(!empty($widgetOut['nowrap'])) {
				$nowrap = true;
			}
			if(isset($widgetOut['body'])) {
				$body = $widgetOut['body'];
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

		if(empty($title)) {
			$title = isset($wgWidgets[$widget['type']]['title'][$wgLang->getCode()]) ? $wgWidgets[$widget['type']]['title'][$wgLang->getCode()] : $wgWidgets[$widget['type']]['title']['en'];
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

		if($body == '') {
			return '';
		}

		if($this->skinname == 'monaco') {
			$closeButton = ($closeable) ? "<div id=\"{$widget['id']}_close\" class=\"close\"><span></span></div>" : '';
			$editButton  = ($editable) ? "<div id=\"{$widget['id']}_edit\" class=\"edit\"><span></span></div>" : '';
			$editForm  = ($editable) ? "<dd style=\"display: none;\" class=\"shadow widget_contents\" id=\"{$widget['id']}_editform\"></dd>" : '';
			return "<dl class=\"widget {$widget['type']}\" id=\"{$widget['id']}_wg\"><dt class=\"color1 widget_title\" id=\"{$widget['id']}_header\"><div class=\"widgetToolbox\">{$closeButton}{$editButton}</div>{$title}</dt><dd class=\"shadow widget_contents\" id=\"{$widget['id']}_content\">{$body}</dd>{$editForm}</dl>";
		} else if($this->skinname == 'quartz') {
			$closeButton = ($closeable) ? "<span id=\"{$widget['id']}_close\" class=\"closeButton\">x</span>" : '';
			$editButton  = ($editable) ? "<span id=\"{$widget['id']}_edit\" class=\"editButton\">Edit</span>" : '';
			$editForm  = ($editable) ? "<div style=\"display: none;\" class=\"widgetContent\" id=\"{$widget['id']}_editform\"></div>" : '';
			return "<li class=\"widget {$widget['type']}\" id=\"{$widget['id']}_wg\"><div class=\"sidebar clearfix\" id=\"{$widget['id']}\"><h1 id=\"{$widget['id']}_header\">$title</h1><div class=\"widgetContent {$widget['type']}\" id=\"{$widget['id']}_content\">{$body}</div>{$editForm}</div><div class=\"widgetToolbox\">{$editButton}{$closeButton}</div></li>";
		} else {
			// ..should never occur
		}
	}

	private function getFreeId() {
		$ids = array();
		foreach($this->config as $_sidebar) {
			foreach($_sidebar as $_widget) {
				$ids[] = $_widget['id'];
			}
		}
		$idsDiff = array_diff(range(1,150), $ids);
		return array_pop(array_reverse($idsDiff));
	}

	private function DrawOne($widget, $wrap = true) {
		global $wgWidgets;
		$params = $this->getParams($widget);
		$params['skinname'] = $this->skinname;
		$widgetOut = $wgWidgets[$widget['type']]['callback']($widget['id'],$params);
		if($wrap) {
			return $this->wrap($widget, $widgetOut);
		} else {
			return $widgetOut;
		}
	}

	// PUBLIC METHODS

	public function SetSkin($skinname) {
		$this->skinname = $skinname;
	}

	public function GetSkin() {
		return $this->skinname;
	}

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new WidgetFramework();
		}
		return self::$instance;
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

	public function Add($type, $sidebar, $index) {
		global $wgWidgets;
		if($this->load($type)) {
			$id = $this->getFreeId();
			$widget = array('type' => $type, 'id' => $id);
			if(!isset($this->config[$sidebar])) {
				$this->config[$sidebar] = array();
			}
			$this->config[$sidebar][] = $widget;
			$this->Reorder($id, $sidebar, $index);
			if(empty($wgWidgets[$type]['nofetch'])) {
				return $this->DrawOne($widget);
			}
			return true;
		} else {
			return false;
		}
	}

	public function Reorder($id, $sidebar, $index) {
		if(!empty($id) && !empty($sidebar) && !empty($index)) {
			foreach($this->config as $key1 => $val1) {
				foreach($val1 as $key2 => $val2) {
					if($id == $val2['id']) {
						$widget = $val2;
						unset($this->config[$key1][$key2]);
						if(isset($this->config[$sidebar])) {
							$sidebarList = $this->config[$sidebar];
						} else {
							$sidebarList = array();
						}
						if($index > count($sidebarList)) {
							$sidebarList[] = $widget;
						} else {
							$sidebarList1 = array_slice($sidebarList, 0, $index - 1);
							$sidebarList2 = array_slice($sidebarList, $index - 1);
							$sidebarList = array_merge($sidebarList1, array($widget));
							$sidebarList = array_merge($sidebarList, $sidebarList2);
						}
						$this->config[$sidebar] = $sidebarList;
						return true;
					}
				}
			}
		}
		return false;
	}

	public function Save() {
		global $wgUser;
		$wgUser->setOption('widgets', serialize($this->config));
		$wgUser->saveSettings();

		$dbw = wfGetDB( DB_MASTER );
		$dbw->commit(); // macbre: $dbw->close() was causing fatal error in MW1.13

		return true;
	}

	public function Delete($id) {

		global $wgWidgets;

		if(!empty($id)) {
			foreach($this->config as $key1 => $val1) {
				foreach($val1 as $key2 => $val2) {
					if($id == $val2['id']) {
						$type = $val2['type'];
						$this->load( $type );
						if ($wgWidgets[$type]['closeable'] == true) {
							unset($this->config[$key1][$key2]);
							return true;
						}
						else {
							return false;
						}
					}
				}
			}
		}
		return false;
	}

	public function GetEditForm($id) {
		global $wgWidgets;
		if(!empty($id)) {
			foreach($this->config as $key1 => $val1) {
				foreach($val1 as $key2 => $widget) {
					if($id == $widget['id']) {
						if($this->load($widget['type'])) {
							$params = $this->getParams($widget);
							$out  = "<form onsubmit='return false;' id=\"{$widget['id']}_editor\">";
							foreach($wgWidgets[$widget['type']]['params'] as $key => $val) {
								$out .= '<label for="' . $widget['id'] . '_editor_' . $key  . '">' . wfMsg(!empty($val['msg']) ? $val['msg'] : $key) . ':</label>';
								switch($val['type']) {
									case 'text':
										$out .= "<input id=\"{$widget['id']}_editor_{$key}\" name=\"{$key}\" type=\"text\" value=\"{$params[$key]}\"><br/><br/>";
										break;
									case 'select':
										$out .= "<select id=\"{$widget['id']}_editor_{$key}\" name=\"{$key}\">";
										while(list($key1, $val1) = each($val['values'])) {
											$out .= "<option value=\"{$key1}\"".(($key1 == $params[$key]) ? ' selected="selected"' : "").">{$val1}</option>";
										}
										$out .= "</select><br/><br/>";
										break;
									case 'checkbox':
										$out .= "<input id=\"{$widget['id']}_editor_{$key}\" name=\"{$key}\" class=\"checkbox\" type=\"checkbox\"".($params[$key] ? ' checked="checked"' : '')." /><br/><br/>";
										break;
								}
							}

							$out .= "<input id=\"{$widget['id']}_save\" class=\"editor_button\" type=\"button\" value=\"".wfMsg('saveprefs')."\">";
							$out .= "<input id=\"{$widget['id']}_cancel\" class=\"editor_button\" type=\"button\" value=\"".wfMsg('Cancel')."\">";
							$out .= "</form>";
							return $out;
						}
					}
				}
			}
		}
		return false;
	}

	public function Configure($id) {
		global $wgWidgets, $wgRequest;
		if(!empty($id)) {
			foreach($this->config as $key1 => $val1) {
				foreach($val1 as $key2 => $widget) {
					if($id == $widget['id']) {
						$this->load($widget['type']);
						$params = $this->getParams($widget);
						foreach($wgWidgets[$widget['type']]['params'] as $key => $val) {
							$paramName = $key;
							$paramDefaultValue = $val['default'];
							if($val['type'] == 'checkbox') {
								$value = $wgRequest->getCheck($paramName, $paramDefaultValue);
							} else if($val['type'] == 'text') {
								$value = $wgRequest->getText($paramName, $paramDefaultValue);
							} else if($val['type'] == 'select') {
								$value = $wgRequest->getInt($paramName, $paramDefaultValue);
							}

							if((isset($widget['param'][$paramName]) && $widget['param'][$paramName] != $value && $wgRequest->getText($paramName) != '') || ($paramDefaultValue != $value)) {
								$this->config[$key1][$key2]['param'][$paramName] = $value;
							}
						}
						return true;
					}
				}
			}
		}
		return false;
	}

	public function GetWidgetBody($id) {
		global $wgWidgets;
		if(!empty($id)) {
			foreach($this->config as $key1 => $val1) {
				foreach($val1 as $key2 => $widget) {
					if($id == $widget['id']) {
						if($this->load($widget['type'])) {
							$widgetOut = $this->DrawOne($widget, false);
							$response = array();
							if(is_array($widgetOut)) {
								if(isset($widgetOut['title'])) {
									$response['title'] = $widgetOut['title'];
								}
								if(isset($widgetOut['body'])) {
									$response['body'] = $widgetOut['body'];
								}
							} else {
								$response['body'] = $widgetOut;
							}
							$response['type'] = $widget['type'];
							return $response;
						}
					}
				}
			}
		}
		return false;
	}
}

$wgAjaxExportList[] = 'WidgetFrameworkAjax';
function WidgetFrameworkAjax() {
	global $wgRequest, $wgUser;
	$response = array();
	$actionType = $wgRequest->getVal('actionType');

	// Widget Add
	if($actionType == 'add' && $wgUser->isLoggedIn()) {
		$output = WidgetFramework::getInstance()->SetSkin($wgRequest->getText('skin'));
		$output = WidgetFramework::getInstance()->Add(
										$wgRequest->getText('type'),
										$wgRequest->getInt('sidebar'),
										$wgRequest->getInt('index'));

		if($output){
			WidgetFramework::getInstance()->Save();
			if($output === true) {
				$response = array('success' => true, 'reload' => true);
			} else {
				$response = array('success' => true, 'widget' => $output);
			}
		} else {
			$response = array('success' => false);
		}
	}

	// Widget Reorder
	if($actionType == 'reorder' && $wgUser->isLoggedIn()) {
		$status = WidgetFramework::getInstance()->Reorder(
										$wgRequest->getInt('id'),
										$wgRequest->getInt('sidebar'),
										$wgRequest->getInt('index'));

		if($status) {
			WidgetFramework::getInstance()->Save();
			$response = array('success' => true);
		} else {
			$response = array('success' => false);
		}
	}

	// Widget Delete
	if($actionType == 'delete' && $wgUser->isLoggedIn()) {
		$status = WidgetFramework::getInstance()->Delete($wgRequest->getInt('id'));
		if($status) {
			WidgetFramework::getInstance()->Save();
			$response = array('success' => true);
		} else {
			$response = array('success' => false);
		}
	}

	// Widget Editform
	if($actionType == 'editform' && $wgUser->isLoggedIn()) {
		$status = WidgetFramework::getInstance()->GetEditForm($wgRequest->getInt('id'));
		if($status) {
			$response = array('success' => true, 'content' => $status);
		} else {
			$response = array('success' => false);
		}
	}

	// Save widget parameters
	if($actionType == 'configure') {
		$status = WidgetFramework::getInstance()->Configure($wgRequest->getInt('id'));
		if($status) {
			WidgetFramework::getInstance()->Save();
			$response = WidgetFramework::getInstance()->GetWidgetBody($wgRequest->getInt('id'));
			$response = array_merge(array('success' => true), $response);
		} else {
			$response = array('success' => false);
		}
	}

	return new AjaxResponse(Wikia::json_encode($response));
}

/**
 * @return array
 * @author Maciej Brencz
 * @author Inez Korczynski <inez@wikia.com>
 */
function WidgetFrameworkCallAPI($params) {
	wfProfileIn(__METHOD__);
	$output = array();
	try {
		$api = new ApiMain(new FauxRequest($params));
		$api->execute();
		$output = $api->getResultData();
	} catch(Exception $e) { };
	wfProfileOut( __METHOD__ );
	return $output;
}

/**
 * @return string
 * @author Inez Korczynski <inez@wikia.com>
 */
function WidgetFrameworkWrapLinks($links) {
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
function WidgetFrameworkMoreLink($link) {
	wfProfileIn(__METHOD__);
	$out = '<div class="widgetMore"><a href="'.htmlspecialchars($link).'">'.wfMsg('moredotdotdot').'</a></div>';
	wfProfileOut( __METHOD__ );
	return $out;
}

/**
 * @return string
 * @author Inez Korczyński
 * @author Maciej Brencz
 */
function WidgetFrameworkGetArticle($title, $ns) {
	$titleObj = Title::newFromText($title, $ns);
	if ( !is_object($titleObj) ) {
		return false;
	}
	$revision = Revision::newFromTitle( $titleObj );
	if(is_object($revision)) {
		return $revision->getText();
	}
	return false;
}
