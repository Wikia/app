<?php

class PageLayoutBuilderHelper {
	/*
	 * @author Tomasz Odrobny
	 * @params Title
	 * @return Parser
	 */
	
	public static function rteIsCustom($name, $params, $frame, $wikitextIdx) {
		global $wgPLBwidgets;
		if (isset($wgPLBwidgets[$name])) {
			return false;
		}
		return true;
	}
}