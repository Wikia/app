<?php

class WidgetTagRenderer extends WidgetFramework {

	private $count = 1000;
	private $markers = array();

	protected static $instanceTagRenderer = false;

	public static function getInstance() {
		if( !(self::$instanceTagRenderer instanceof WidgetTagRenderer) ) {
                        self::$instanceTagRenderer = new WidgetTagRenderer();
                }
                return self::$instanceTagRenderer;
	}


        public function renderTag( $input, $args, $parser ) {

		// there must be something between tags
		if ( empty($input) ) {
			return '';
		}

		// we support only quartz & monaco skin in this feature
		if ( ($this->skinname != 'monaco') && ($this->skinname != 'quartz') && $this->skinname != 'oasis' ) {
			return '';
		}

		$widgetType = 'Widget' . Sanitizer::escapeId($input, 0);

		// try to load widget
		if ( $this->load($widgetType) == false ) {
			return '';
		}

		// seek for style attribute (RT #19092)
		if (isset($args['style'])) {
			$style = ' style="' . htmlspecialchars($args['style']) . '"';
			unset($args['style']);
		}
		else {
			$style = '';
		}

		// create array for getParams method of widget framework
		$id = 'widget_' . $this->count;

		$widget = array(
			'type'  => $widgetType,
			'id'    => $id,
			'param' => $args,
			'widgetTag' => true
		);

		// configure widget
		$widgetParams = $this->getParams($widget);

		// set additional params
		$widgetParams['skinname'] = $this->skinname;

		// inform widget he's rendered by WidgetTag
		$widgetParams['_widgetTag'] = true;

		// try to display it using widget function
		$output = $widgetType($id, $widgetParams);

		// Add any required javascript for the widget
		$output .= $this->getJavascript($widget);

		// wrap widget content
		$output = $this->wrap($widget, $output);

		// so count returned widgets
		$this->count++;

		// wrap widget HTML
		$output = "<div class=\"widgetTag reset\"{$style}>{$output}</div>";

		// use markers to avoid RT #20855 when widget' HTML is multiline
		global $wgParser;
		$marker = $wgParser->uniqPrefix() . "-WIDGET-{$this->count}-\x7f";
		$this->markers[$marker] = $output;

		return $marker;
	}

	function replaceMarkers($text) {
		return strtr($text, $this->markers);
	}
}
