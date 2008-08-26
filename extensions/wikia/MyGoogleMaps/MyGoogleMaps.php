<?php
/*
 * Author: Inez Korczynski
 */

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'MyGoogleMaps',
	'author' => 'Inez Korczynski',
	'description' => 'Allow users to embeds My Google Maps in article content.'
);

$wgExtensionFunctions[] = 'setupMyGoogleMaps';

function setupMyGoogleMaps() {
	global $wgParser;
	$wgParser->setHook('mygooglemap', 'embedMyGoogleMap');
}

function embedMyGoogleMap($input, $argv, &$parser) {

	$input = trim($input);

	if(empty($input) || $input == '') {
		return 'no_input';
	}

	$xml = simplexml_load_string('<xml>'.$input.'</xml>');

	if(is_object($xml)) {
		if(isset($xml->iframe)) {
			$params = array();

			$_width = (int)$xml->iframe['width'];
			if(is_int($_width)) {
				$params['width'] = $_width;
			} else {
				return false;
			}

			$_height = (int)$xml->iframe['height'];
			if(is_int($_height)) {
				$params['height'] = $_height;
			} else {
				return false;
			}

			$_frameborder = (int)$xml->iframe['frameborder'];
			if(is_int($_frameborder)) {
				$params['frameborder'] = $_frameborder;
			} else {
				return false;
			}

			$_scrolling = (string)$xml->iframe['scrolling'];
			if($_scrolling == 'yes' || $_scrolling == 'no') {
				$params['scrolling'] = $_scrolling;
			} else {
				return false;
			}

			$_marginheight = (int)$xml->iframe['marginheight'];
			if(is_int($_marginheight)) {
				$params['marginheight'] = $_marginheight;
			} else {
				return false;
			}

			$_marginwidth = (int)$xml->iframe['marginwidth'];
			if(is_int($_marginwidth)) {
				$params['marginwidth'] = $_marginwidth;
			} else {
				return false;
			}

			$_src = (string)$xml->iframe['src'];
			if(strpos($_src, 'http://maps.google.com/maps/ms') === 0 && strpos($_src, '<') === false) {
				$params['src'] = $_src;
			} else {
				return false;
			}

			$_href = (string)$xml->small->a['href'];
			if(strpos($_href, 'http://maps.google.com/maps/ms') === 0 && strpos($_href, '<') === false) {
				$params['href'] = $_href;
			} else {
				return false;
			}

			$_style = (string)$xml->small->a['style'];
			if(strpos($_href, '<') === false) {
				$params['style'] = $_style;
			} else {
				return false;
			}

			$_text = (string)$xml->small->a;
			if(strpos($_text, '<') === false) {
				$params['text'] = $_text;
			} else {
				return false;
			}

			if(isset($argv['width'])) {
				if(is_int((int)$argv['width'])) {
					$params['width'] = $argv['width'];
				}
			}

			if(isset($argv['height'])) {
				if(is_int($argv['height'])) {
					$params['height'] = $argv['height'];
				}
			}

			if(isset($argv['text'])) {
				if(strpos($argv['text'], '<') === false) {
					$params['text'] = $argv['text'];
				}
			}

			$tpl = '<iframe width="%s" height="%s" frameborder="%s" scrolling="%s" marginheight="%s" marginwidth="%s" src="%s"></iframe><br /><small><a href="%s" style="%s">%s</a></small>';
			return sprintf($tpl, $params['width'], $params['height'], $params['frameborder'], $params['scrolling'], $params['marginheight'], $params['marginwidth'], $params['src'], $params['href'], $params['style'], $params['text']);
		}
	}
}