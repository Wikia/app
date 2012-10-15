<?php
/*
 * @author Inez Korczynski
 *
 * This is one time use script
 */
require_once( "../commandLine.inc" );
$dbw = wfGetDB(DB_MASTER);
$res = $dbw->query("select user_id from user HAVING(select count(*) from widgets WHERE wt_user=user_id) < 5 limit 25;"); // TODO: delete limit
$user_ids = array();
while($row = $dbw->fetchObject($res)) {
	$user_ids[] = $row->user_id;
}

$dir = '../../extensions/wikia/WidgetFramework/Widgets/';
if(is_dir($dir)) {
	if($dh = opendir($dir)) {
		while(($file = readdir($dh)) !== false) {
			if(filetype($dir.$file) == 'dir') {
				if(file_exists($dir.$file.'/'.$file.'.php')) {
					require_once($dir.$file.'/'.$file.'.php');
				}
			}
		}
	}
	closedir($dh);
}

function MyCmp($a, $b) {
	if(!isset($a['params'])) {
		$a['params']['position'] = 1000;
	}
	if(!isset($a['params']['position'])) {
		$a['params']['position'] = 1000;
	}
	if(!isset($b['params'])) {
		$b['params']['position'] = 1000;
	}
	if(!isset($b['params']['position'])) {
		$b['params']['position'] = 1000;
	}
	if($a['params']['position'] == $b['params']['position']) {
		return 0;
	}
	return $a['params']['position'] < $b['params']['position'] ? -1 : 1;
}

foreach($user_ids as $user_id) {
	$user_widgets = array();
	$res = $dbw->query("SELECT wt_id, wt_class FROM widgets WHERE wt_level = 2 and wt_user = {$user_id}");
	while($row = $dbw->fetchObject($res)) {
		$widget = array('type' => $row->wt_class);
		$res2 = $dbw->query("SELECT * FROM widgets_extra WHERE we_widget_id = {$row->wt_id}");
		while($row2 = $dbw->fetchObject($res2)) {
			$widget['params'][$row2->we_name] = $row2->we_value;
		}
		$user_widgets[] = $widget;
	}
	$user_widgets1 = array();
	foreach($user_widgets as $widget) {
		if(isset($widget['params']) && isset($widget['params']['column'])) {
			$column = $widget['params']['column'];
			unset($widget['params']['column']);
			$user_widgets1[$column][] = $widget;
		} else {
			$user_widgets1[1][] = $widget;
		}
	}

	foreach($user_widgets1 as $key => $sidebar) {
		usort($sidebar, "MyCmp");
		foreach($sidebar as $_key => $_val) {
			unset($sidebar[$_key]['params']['position']);
			if(isset($sidebar[$_key]['params']) && count($sidebar[$_key]['params']) == 0) {
				unset($sidebar[$_key]['params']);
			}
		}
		$user_widgets1[$key] = $sidebar;
	}
	foreach($user_widgets1 as $sidebar_key => $sidebar_value) {
		foreach($user_widgets1[$sidebar_key] as $widget_key => $widget_value) {
			$type = $widget_value['type'];
			if(isset($wgWidgets[$type])) {
				if(isset($user_widgets1[$sidebar_key][$widget_key]['params'])) {
					foreach($user_widgets1[$sidebar_key][$widget_key]['params'] as $param_key => $param_value) {
					}
				}
			}
		}
	}


	if(count($user_widgets1) > 0) {
		echo $user_id."\n";
		print_r($user_widgets1);
	}



}









/*
$res = $dbw->query("SELECT * FROM widgets WHERE wt_level = 2 LIMIT 5");
while($row = $dbw->fetchObject($res)) {
	print_pre($row);
}
*/
?>