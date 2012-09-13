<?php

class WidgetTagRenderer extends WidgetFramework {

	private $count = 1;
	private $markers = array();

	protected static $instanceTagRenderer = false;

	/**
	 * @static
	 * @return WidgetTagRenderer
	 */
	public static function getInstance() {
		if( !(self::$instanceTagRenderer instanceof WidgetTagRenderer) ) {
	        self::$instanceTagRenderer = new WidgetTagRenderer();
        }
        return self::$instanceTagRenderer;
	}

	/**
	 * @param $input
	 * @param $args
	 * @param Parser $parser
	 * @return string
	 */
	public function renderTag( $input, $args, Parser $parser ) {
		wfProfileIn(__METHOD__);

		// there must be something between tags
		if ( empty($input) ) {
			wfProfileOut(__METHOD__);
			return '';
		}

		// we support only the Oasis skin for this feature
		if ( !( F::app()->checkSkin( 'oasis' ) ) ) {
			wfProfileOut(__METHOD__);
			return '';
		}

		$widgetType = 'Widget' . Sanitizer::escapeId($input, 0);

		// try to load widget
		if ( $this->load($widgetType) == false ) {
			wfProfileOut(__METHOD__);
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
		$id = 'widget_' . $this->count++;

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

		// Add any required javascript and CSS for the widget
		#$output .= $this->getAssets($widget);

		// wrap widget content
		$output = $this->wrap($widget, $output);

		// wrap widget HTML
		$output = "<div class=\"widgetTag\"{$style}>{$output}</div>";

		// use markers to avoid RT #20855 when widget' HTML is multiline
		$marker = $parser->uniqPrefix() . "-WIDGET-{$this->count}-\x7f";
		$this->markers[$marker] = $output;

		wfProfileOut(__METHOD__);
		return $marker;
	}

	/**
	 * @param $text
	 * @return string
	 */
	function replaceMarkers($text) {
		return strtr($text, $this->markers);
	}
}
