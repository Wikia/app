<?php

class WidgetTagRenderer extends WidgetFramework {

	private $count = 1;

	public static function getInstance() {
		if( !(self::$instance instanceof WidgetTagRenderer) ) {
                        self::$instance = new WidgetTagRenderer();
                }
                return self::$instance;
	}	


        public function renderTag( $input, $args, $parser ) {

		// there must be something between tags
		if ( empty($input) ) {
			return '';
		}

		// we support only quartz & monaco skin in this feature
		if ( ($this->skinname != 'monaco') && ($this->skinname != 'quartz') ) {
			return '';
		}

		$widgetType = 'Widget' . Sanitizer::escapeId($input, 0);

		// try to load widget
		if ( $this->load($widgetType) == false ) {
			return '';
		}

		// create array for getParams method of widget framework
		$id = 'WidgetTag' . $this->count;

		$widget = array(
			'type'  => $widgetType,
			'id'    => $id,
			'param' => $args,
		);

		// configure widget
		$widgetParams = $this->getParams($widget);

		// set additional params
		$widgetParams['skinname'] = $this->skinname;
		
		// inform widget he's rendered by WidgetTag
		$widgetParams['_widgetTag'] = true;

		// try to display it using widget function
		$output = $widgetType($id, $widgetParams);

		// wrap widget content
		$output = $this->wrap($widget, $output);

		// so count returned widgets
		$this->count++;

		// wrap widget HTML
		$output = '<nowiki><div class="widgetTag reset">' . $output . '</div></nowiki>';

		// finally!
		return $output;
	}
}

