var badgesUpdate = new Array();
badgesUpdate["ub-header-btn-txt-color"] = new Array("ub-layer-title", "color", "ub-header-txt-color");
badgesUpdate["ub-header-btn-bg-color"] = new Array("user-badges-title", "backgroundColor", "ub-header-bg-color");
badgesUpdate["ub-body-btn-bg-color"] = new Array("user-badges-body", "backgroundColor", "ub-body-bg-color");
badgesUpdate["ub-body-btn-label-color"] = new Array("ub-layer-username-title", "color", "ub-body-label-color");
badgesUpdate["ub-body-btn-label-color-edits"] = new Array("ub-layer-edits-title", "color", "ub-body-label-color");
badgesUpdate["ub-body-btn-data-color"] = new Array("ub-layer-edits-value", "color", "ub-body-data-color");
badgesUpdate["ub-body-btn-data-color-username"] = new Array("ub-layer-username-url", "color", "ub-body-data-color");
badgesUpdate["ub-header-txt-align"] = new Array("ub-layer-title", "textAlign");
badgesUpdate["ub-body-logo-align"] = new Array("ub-layer-logo", "margin");
badgesUpdate["ub-body-small-logo-align"] = new Array("ub-layer-wikia-title", "margin");

function int2Hex(i) {
	var hex = parseInt(i).toString(16);
	return (hex.length < 2) ? "0" + hex : hex;
}

function int2rgb(s) {
	return [s.substr(0, 2), s.substr(2, 2), s.substr(4, 2)];
}

function hex2rgb(h,e,x) {
	return [parseInt(h,16), parseInt(e, 16), parseInt(x, 16)];
}

function color2rgb(color) {
	if(color.indexOf('rgb')<=-1) {
		return hex2rgb(color.substring(1,3),color.substring(3,5),color.substring(5,7));
	}
	return color.substring(4,color.length-1).split(',');
}

function color2hex(color, wout) {
	var c = new Array();
	if(color.indexOf('rgb')<=-1) {
		c = hex2rgb(color.substring(1,3),color.substring(3,5),color.substring(5,7));
	} else {
		c = color.substring(4,color.length-1).split(',');
	}
	return ((!wout) ? '#' : "") + int2Hex(c[0]) + int2Hex(c[1]) + int2Hex(c[2]);
}

function color2RGBArray(color) {
	var c = new Array();
	if(color.indexOf('rgb')<=-1) {
		c = hex2rgb(color.substring(1,3),color.substring(3,5),color.substring(5,7));
	} else {
		c = color.substring(4,color.length-1).split(',');
	}
	return c;
}


colorDialog = function() {
	var Event=YAHOO.util.Event,
		Dom=YAHOO.util.Dom,
		lang=YAHOO.lang,
		__colorDialog,
		picker,
		__id;

	var pickerPanel = document.createElement('div');
	pickerPanel.setAttribute("id", "yui-picker-panel");
	pickerPanel.setAttribute("class", "yui-picker-panel");
	pickerPanel.innerHTML = "<div class=\"hd\">Please choose a color:</div><div class=\"bd\"><div class=\"yui-picker\" id=\"yui-picker\"></div></div><div class=\"ft\"></div></div>";

	return {
        init: function() {
			document.body.appendChild(pickerPanel);

            this.dialog = new YAHOO.widget.Dialog("yui-picker-panel", {
				width : "380px",
				zIndex: 20,
				close: true,
				fixedcenter: true,
				visible: false,
				draggable: true,
				constraintoviewport: true,
				buttons: [ { text:"Submit", handler:this.handleSubmit, isDefault:true },
							{ text:"Cancel", handler:this.handleCancel } ]
             });

            this.dialog.renderEvent.subscribe(function() {
				if (!picker) {
					picker = new YAHOO.widget.ColorPicker("yui-picker", {
						container: this.dialog,
						images: {
							PICKER_THUMB: "/skins/common/yui_2.5.2/colorpicker/assets/picker_thumb.png",
							HUE_THUMB: "/skins/common/yui_2.5.2/colorpicker/assets/hue_thumb.png"
						},
						txt: {
							ILLEGAL_HEX: ColorTxt["ILLEGAL_HEX"],
							SHOW_CONTROLS: ColorTxt["SHOW_CONTROLS"],
							HIDE_CONTROLS: ColorTxt["HIDE_CONTROLS"],
							CURRENT_COLOR: ColorTxt["CURRENT_COLOR"],
							CLOSEST_WEBSAFE: ColorTxt["CLOSEST_WEBSAFE"],
      						R: "R",
							G: "G",
							B: "B",
							HEX: "#",
							PERCENT: "%"
						},
						showcontrols: true,  
						showhexcontrols: true,
						showhexsummary: true,
						showrgbcontrols: true,
						showhsvcontrols: false,
						showwebsafe: true
					});
					picker.on("rgbChange", function(o) {
					});
				}
			});

            this.dialog.validate = function() {
				return true;
            };
            this.dialog.render();

			__colorDialog = this.dialog;
			//document.getElementById('yui-picker-panel_h').innerHTML = ColorTxt["DIALOG_HEADER"];
            Event.on(["ub-header-btn-txt-color", "ub-header-btn-bg-color", "ub-body-btn-bg-color", "ub-body-btn-label-color", "ub-body-btn-data-color"], "click", function(e) {
				__id = this.id;
				var color = YAHOO.util.Dom.getStyle(this.id, 'backgroundColor');
				//var rgbColor = int2rgb(color2hex(color, 1));
				var rgbColor = color2RGBArray(color);
				__colorDialog.show();
				picker.setValue(rgbColor, false);
            });
            Event.on(["ub-header-txt-align"], "change", function(e) {
            	YAHOO.util.Dom.setStyle("ub-layer-title", "textAlign", this.value);
			});
            Event.on(["ub-header-txt-align", "ub-body-logo-align", "ub-body-small-logo-align"], "change", function(e) {
            	YAHOO.util.Dom.setStyle(badgesUpdate[this.id][0], badgesUpdate[this.id][1], this.value);
			});
			Event.on("ub_configurator-href", "click", function(e) {
				YAHOO.util.Dom.get("ub_configurator-panel").style.display = "";
				YAHOO.util.Dom.get("ub-overwrite-badge").checked = "checked";
			});
		},

		handleSubmit: function() {
			if (__id) {
				var pickerColor = YAHOO.util.Dom.getStyle('yui-picker-swatch', 'backgroundColor');
				YAHOO.util.Dom.setStyle(__id, 'backgroundColor', pickerColor);
				YAHOO.util.Dom.setStyle(badgesUpdate[__id][0], badgesUpdate[__id][1], pickerColor);
				if (__id == 'ub-body-btn-label-color') {
					var _tmp = 'ub-body-btn-label-color-edits';
					YAHOO.util.Dom.setStyle(badgesUpdate[_tmp][0], badgesUpdate[_tmp][1], pickerColor);
				}
				if (__id == 'ub-body-btn-data-color') {
					var _tmp = 'ub-body-btn-data-color-username';
					YAHOO.util.Dom.setStyle(badgesUpdate[_tmp][0], badgesUpdate[_tmp][1], pickerColor);
				}
				document.getElementById(badgesUpdate[__id][2]).value = color2hex(pickerColor);
			}
			this.hide();
		},

		handleCancel: function() {
			this.cancel();
		}
	}
}();

YAHOO.util.Event.onDOMReady(function() {
	colorDialog.init();
	//colorDialog, true
	
	if (badgesUpdate) {
		for (i in badgesUpdate) {
			if (badgesUpdate[i][2]) {
				getDefaultColor(i, badgesUpdate);
			}
		}
	}
	YAHOO.util.Dom.setStyle("ub-layer-title", "textAlign", YAHOO.util.Dom.get('ub-header-txt-align').value);
	YAHOO.util.Dom.setStyle("ub-layer-logo", "margin", YAHOO.util.Dom.get('ub-body-logo-align').value);
	YAHOO.util.Dom.setStyle("ub-layer-wikia-title", "margin", YAHOO.util.Dom.get('ub-body-small-logo-align').value);
});

function getDefaultColor(id, obj) {
	if (obj && obj[id]) {
		var color = YAHOO.util.Dom.getStyle(obj[id][0], obj[id][1]);
		YAHOO.util.Dom.setStyle(id, 'backgroundColor', color);
		document.getElementById(obj[id][2]).value = color2hex(color);
	}
}

function changeSmallLogo(id, path) {
	var smallLogo = document.getElementById('ub-small-logo-img');
	smallLogo.src = path;
}
