<?php

/**
 * Class to Handle HTML generation for Special:MapEditor
 *
 * @since 2.1
 *
 * @licence GNU GPL v2+
 * @author Nischayn22
 */
class MapEditorHtml extends ContextSource{

    /**
     * Array holding the additional attributes for the canvas div.
     * @var array()
     * @since 2.1
     */
    protected $attribs;

    /**
     * @param array $attribs
     * @param ContextSource|null $
     * @since 2.1
     */
    public function __construct( $attribs = array(), ContextSource $contextSource = null ){
        $this->attribs = $attribs;
    }

    /**
     * Returns the HTML for the MapEditor.
     * @return string
     * @since 2.1
     */
    public function getEditorHTML() {

	$output = <<<EOT
	{$this->getCanvasDiv()}<div style="display: none;">
	<div id="code-output-container" title="%1\$s">
		<textarea id="code-output" rows="15" readonly></textarea>
	</div>
	<div id="code-input-container" title="%2\$s" >
		<p>%3\$s</p>
		<textarea id="code-input" rows="15"></textarea>
	</div>
	<div id="marker-form" class="mapeditor-dialog" title="%4\$s">
		<div class="link-title-switcher">
			<input type="radio" name="switch" value="text" /> %5\$s
			<input type="radio" name="switch" value="link" /> %6\$s
		</div>
		<form class="mapeditor-dialog-form">
			<fieldset>
				<label for="m-title">%7\$s</label>
				<input type="text" name="title" id="m-title" class="text ui-widget-content ui-corner-all"/>
				<label for="m-text">%8\$s</label>
				<input type="text" name="text" id="m-text" class="text ui-widget-content ui-corner-all"/>
				<label for="m-link">%9\$s</label>
				<input type="text" name="link" id="m-link" class="text ui-widget-content ui-corner-all"/>
				<label for="m-icon">%10\$s</label>
				<input type="text" name="icon" id="m-icon" class="text ui-widget-content ui-corner-all"/>
				<label for="m-group">%11\$s</label>
				<input type="text" name="group" id="m-group" class="text ui-widget-content ui-corner-all"/>
				<label for="m-inlinelabel">%12\$s</label>
				<input type="text" name="inlinelabel" id="m-inlinelabel" class="text ui-widget-content ui-corner-all"/>
				<label for="m-visitedicon">%23\$s</label>
				<input type="text" name="visitedicon" id="m-visitedicon" class="text ui-widget-content ui-corner-all"/>
			</fieldset>
		</form>
	</div>

	<div id="strokable-form" class="mapeditor-dialog" title="%4\$s">
		<div class="link-title-switcher">
			<input type="radio" name="switch" value="text" /> %5\$s
			<input type="radio" name="switch" value="link" /> %6\$s
		</div>
		<form class="mapeditor-dialog-form">
			<fieldset>
				<label for="s-title">%7\$s</label>
				<input type="text" name="title" id="s-title" class="text ui-widget-content ui-corner-all"/>
				<label for="s-text">%8\$s</label>
				<input type="text" name="text" id="s-text" value="" class="text ui-widget-content ui-corner-all"/>
				<label for="s-link">%9\$s</label>
				<input type="text" name="link" id="s-link" class="text ui-widget-content ui-corner-all"/>
				<label for="s-strokecolor">%13\$s</label>
				<input type="text" name="strokeColor" id="s-strokecolor" class="text ui-widget-content ui-corner-all"/>
				<label for="s-strokeopacity">%14\$s</label>
				<input type="hidden" name="strokeOpacity" id="s-strokeopacity" class="text ui-widget-content ui-corner-all"/>
				<label for="s-strokeweight">%15\$s</label>
				<input type="text" name="strokeWeight" id="s-strokeweight" class="text ui-widget-content ui-corner-all"/>
			</fieldset>
		</form>
	</div>

	<div id="fillable-form" class="mapeditor-dialog" title="%4\$s">
		<div class="link-title-switcher">
			<input type="radio" name="switch" value="text" /> %5\$s
			<input type="radio" name="switch" value="link" /> %6\$s
		</div>
		<form class="mapeditor-dialog-form">
			<fieldset>
				<label for="f-title">%7\$s</label>
				<input type="text" name="title" id="f-title" class="text ui-widget-content ui-corner-all"/>
				<label for="f-text">%8\$s</label>
				<input type="text" name="text" id="f-text" value="" class="text ui-widget-content ui-corner-all"/>
				<label for="f-link">%9\$s</label>
				<input type="text" name="link" id="f-link" class="text ui-widget-content ui-corner-all"/>
				<label for="f-strokecolor">%13\$s</label>
				<input type="text" name="strokeColor" id="f-strokecolor" class="text ui-widget-content ui-corner-all"/>
				<label for="f-strokeopacity">%14\$s</label>
				<input type="hidden" name="strokeOpacity" id="f-strokeopacity" class="text ui-widget-content ui-corner-all"/>
				<label for="f-strokeweight">%15\$s</label>
				<input type="text" name="strokeWeight" id="f-strokeweight" class="text ui-widget-content ui-corner-all"/>
				<label for="f-fillcolor">%16\$s</label>
				<input type="text" name="fillColor" id="f-fillcolor" class="text ui-widget-content ui-corner-all"/>
				<label for="f-fillopacity">%17\$s</label>
				<input type="hidden" name="fillOpacity" id="f-fillopacity" class="text ui-widget-content ui-corner-all"/>
			</fieldset>
		</form>
	</div>

	<div id="polygon-form" class="mapeditor-dialog" title="%4\$s">
		<div class="link-title-switcher">
			<input type="radio" name="switch" value="text" /> %5\$s
			<input type="radio" name="switch" value="link" /> %6\$s
		</div>
		<form class="mapeditor-dialog-form">
			<fieldset>
				<label for="p-title">%7\$s</label>
				<input type="text" name="title" id="p-title" class="text ui-widget-content ui-corner-all"/>
				<label for="p-text">%8\$s</label>
				<input type="text" name="text" id="p-text" value="" class="text ui-widget-content ui-corner-all"/>
				<label for="p-link">%9\$s</label>
				<input type="text" name="link" id="p-link" class="text ui-widget-content ui-corner-all"/>
				<label for="p-strokecolor">%13\$s</label>
				<input type="text" name="strokeColor" id="p-strokecolor" class="text ui-widget-content ui-corner-all"/>
				<label for="p-strokeopacity">%14\$s</label>
				<input type="hidden" name="strokeOpacity" id="p-strokeopacity" class="text ui-widget-content ui-corner-all"/>
				<label for="p-strokeweight">%15\$s</label>
				<input type="text" name="strokeWeight" id="p-strokeweight" class="text ui-widget-content ui-corner-all"/>
				<label for="p-fillcolor">%16\$s</label>
				<input type="text" name="fillColor" id="p-fillcolor" class="text ui-widget-content ui-corner-all"/>
				<label for="p-fillopacity">%17\$s</label>
				<input type="hidden" name="fillOpacity" id="p-fillopacity" class="text ui-widget-content ui-corner-all"/>
				<label for="p-showonhover">%18\$s</label>
				<input type="checkbox" name="showOnHover" id="p-showonhover" class="text ui-widget-content ui-corner-all"/>
			</fieldset>
		</form>
	</div>
	<div id="map-parameter-form" class="mapeditor-dialog" title="%19\$s">
		<form class="mapeditor-dialog-form">
			<div>
				<select name="key">
					<option value="">%20\$s</option>
				</select>
			</div>
		</form>
	</div>
	<div id="imageoverlay-form" title="%22\$s">
		<div class="link-title-switcher">
			<input type="radio" name="switch" value="text" /> %5\$s
			<input type="radio" name="switch" value="link" /> %6\$s
		</div>
		<form class="mapeditor-dialog-form">
			<fieldset>
				<label for="i-title">%7\$s</label>
				<input type="text" name="title" id="i-title" class="text ui-widget-content ui-corner-all"/>
				<label for="i-text">%8\$s</label>
				<input type="text" name="text" id="i-text" class="text ui-widget-content ui-corner-all"/>
				<label for="i-link">%9\$s</label>
				<input type="text" name="link" id="i-link" class="text ui-widget-content ui-corner-all"/>
				<label for="i-image">%21\$s</label>
				<input type="text" name="image" id="i-image" class="text ui-widget-content ui-corner-all"/>
			</fieldset>
		</form>
	</div>
</div>
EOT;

		$html = sprintf(
			$output,
			$this->msg( 'mapeditor-code-title' ),
			$this->msg( 'mapeditor-import-title' ),
			$this->msg( 'mapeditor-import-note' ),
			$this->msg( 'mapeditor-form-title' ),
			$this->msg( 'mapeditor-link-title-switcher-popup-text' ),
			$this->msg( 'mapeditor-link-title-switcher-link-text' ),
			$this->msg( 'mapeditor-form-field-title' ),
			$this->msg( 'mapeditor-form-field-text' ),
			$this->msg( 'mapeditor-form-field-link' ),
			$this->msg( 'mapeditor-form-field-icon' ),
			$this->msg( 'mapeditor-form-field-group' ),
			$this->msg( 'mapeditor-form-field-inlinelabel' ),
			$this->msg( 'mapeditor-form-field-strokecolor' ),
			$this->msg( 'mapeditor-form-field-strokeopacity' ),
			$this->msg( 'mapeditor-form-field-strokeweight' ),
			$this->msg( 'mapeditor-form-field-fillcolor' ),
			$this->msg( 'mapeditor-form-field-fillopcaity' ),
			$this->msg( 'mapeditor-form-field-showonhover' ),
			$this->msg( 'mapeditor-mapparam-title' ),
			$this->msg( 'mapeditor-mapparam-defoption' ),
			$this->msg( 'mapeditor-form-field-image' ),
			$this->msg( 'mapeditor-imageoverlay-title' ),
			$this->msg( 'mapeditor-form-field-visitedicon' )
		);

		return $html;
	}

    /**
     * @return string
     * @since 2.1
     */
    public function getCanvasDiv(){
        return Html::element(
            'div',
            $this->attribs
        );
    }
	
}