<?php

class ReorderWidgets {

	static public function WF($widgets) {
		global $wgReorderWidgets;
		if (empty($wgReorderWidgets) || !is_array($wgReorderWidgets)) return true;

		foreach ($wgReorderWidgets as $command) {
			ReorderWidgets::runCommand($command, $widgets);
		}

		return true;
	}

	static private function runCommand($command, &$widgets) {
		if (preg_match("/^(add|remove)\s+(Widget[^ ]*)\s*(.*)$/", $command, $matches)) {
			switch ($matches[1]) {
			case "remove":
				self::cmdRemove($matches[2], $widgets);
				break;
			case "add":
			default:
				self::cmdAdd($matches[2], $matches[3], $widgets);
				break;
			}
		}
	}

	static private function cmdAdd($widget, $params, &$widgets) {
		$params = trim($params);
		switch ($params) {
			case "first":
				array_unshift($widgets, $widget);
				break;
			case "last":
			default:
				array_push($widgets, $widget);
				break;
		}
	}

	static private function cmdRemove($widget, &$widgets) {
		$widgets = array_diff($widgets, array($widget));
	}
}
