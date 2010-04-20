<?php

class ReorderWidgets {

	static public function WF($widgets) {
error_log(__METHOD__);

		global $wgReorderWidgets;
		if (empty($wgReorderWidgets) || !is_array($wgReorderWidgets)) return true;

		foreach ($wgReorderWidgets as $command) {
			ReorderWidgets::runCommand($command, $widgets);
		}

		return true;
	}

	static private function runCommand($command, &$widgets) {
error_log(__METHOD__ . ": {$command}");

		if (preg_match("/^(add|remove)\s+(Widget[^ ]*)\s*(.*)$/", $command, $matches)) {
error_log(__METHOD__ . ": " . print_r($matches, true));

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
error_log(__METHOD__ . ": {$widget}+{$params}");

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
error_log(__METHOD__ . ": {$widget}");

		$widgets = array_diff($widgets, array($widget));
	}
}
