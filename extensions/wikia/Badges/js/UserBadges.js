function int2Hex(i) {
	var hex = parseInt(i).toString(16); 
	return (hex.length < 2) ? "0" + hex : hex; 
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

var badgesUpdate = new Array();
badgesUpdate["ub-header-txt-color"] = new Array("ub-layer-title", "color");
badgesUpdate["ub-header-bg-color"] = new Array("user-badges-title", "backgroundColor");
badgesUpdate["ub-body-bg-color"] = new Array("user-badges-body", "backgroundColor");
badgesUpdate["ub-body-label-color"] = new Array("ub-layer-username-title", "color");
badgesUpdate["ub-body-data-color"] = new Array("ub-layer-edits-value", "color");
badgesUpdate["ub-header-txt-align"] = new Array("ub-layer-title", "textAlign");
badgesUpdate["ub-header-logo-align"] = new Array("ub-layer-logo", "margin");
badgesUpdate["ub-header-small-logo-align"] = new Array("ub-layer-wikia-title", "margin");

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
			YAHOO.util.Dom.get('body').appendChild(pickerPanel);

            this.dialog = new YAHOO.widget.Dialog("yui-picker-panel", { 
				width : "380px",
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
            Event.on(["ub-header-txt-color", "ub-header-bg-color", "ub-body-bg-color", "ub-body-label-color", "ub-body-data-color"], "click", function(e) {
				__id = this.id;
				var color = YAHOO.util.Dom.getStyle(this.id, 'backgroundColor');
				var rgbColor = YAHOO.util.Color.hex2rgb(color2hex(color, 1));
				YAHOO.util.Dom.setStyle('yui-picker-swatch', 'backgroundColor', color);
				YAHOO.util.Dom.get('yui-picker-hex').value = color2hex(color, 1);
				__colorDialog.show();            	
				picker.setValue(rgbColor, false);
            });
            Event.on(["ub-header-txt-align"], "change", function(e) {
            	YAHOO.util.Dom.setStyle("ub-layer-title", "textAlign", this.value);
			});
            Event.on(["ub-header-txt-align", "ub-header-logo-align", "ub-header-small-logo-align"], "change", function(e) {
            	YAHOO.util.Dom.setStyle(badgesUpdate[this.id][0], badgesUpdate[this.id][1], this.value);
			});
            //Event.on(["ub-header-txt-color", "ub-header-bg-color", "ub-body-bg-color", "ub-body-label-color", "ub-body-data-color"], "click", this.dialog.show, this.dialog, true);
		},
		
		handleSubmit: function() {
			if (__id) {
				var pickerColor = YAHOO.util.Dom.getStyle('yui-picker-swatch', 'backgroundColor');
				YAHOO.util.Dom.setStyle(__id, 'backgroundColor', pickerColor);
				YAHOO.util.Dom.setStyle(badgesUpdate[__id][0], badgesUpdate[__id][1], pickerColor);
				document.getElementById(__id).value = color2hex(pickerColor);
			}
			this.hide();
		},
 
		handleCancel: function() {
			this.cancel();
		},
	}
}();

YAHOO.util.Event.onDOMReady(function() {
	colorDialog.init();
	//colorDialog, true
	getHdTextColor();
	getHdBgColor();
	getBodyBgColor();
	//
	getBodyLabelColor();
	getBodyDataColor();	
});

function getHdTextColor() {
	var id = 'ub-header-txt-color';
	var color = YAHOO.util.Dom.getStyle(badgesUpdate[id][0], badgesUpdate[id][1]);
	YAHOO.util.Dom.setStyle('ub-header-txt-color', 'backgroundColor', color);
	document.getElementById('ub-header-txt-color').value = color2hex(color);
}

function getHdBgColor() {
	var id = 'ub-header-bg-color';
	var color = YAHOO.util.Dom.getStyle(badgesUpdate[id][0], badgesUpdate[id][1]);
	YAHOO.util.Dom.setStyle('ub-header-bg-color', 'backgroundColor', color);
	document.getElementById('ub-header-bg-color').value = color2hex(color);
}

function getBodyBgColor() {
	var id = 'ub-body-bg-color';
	var color = YAHOO.util.Dom.getStyle(badgesUpdate[id][0], badgesUpdate[id][1]);
	YAHOO.util.Dom.setStyle('ub-body-bg-color', 'backgroundColor', color);
	document.getElementById('ub-body-bg-color').value = color2hex(color);
}

function getBodyLabelColor() {
	var id = 'ub-body-label-color';
	var color = YAHOO.util.Dom.getStyle(badgesUpdate[id][0], badgesUpdate[id][1]);
	YAHOO.util.Dom.setStyle('ub-body-label-color', 'backgroundColor', color);
	document.getElementById('ub-body-label-color').value = color2hex(color);
}

function getBodyDataColor() {
	var id = 'ub-body-data-color';
	var color = YAHOO.util.Dom.getStyle(badgesUpdate[id][0], badgesUpdate[id][1]);
	YAHOO.util.Dom.setStyle('ub-body-data-color', 'backgroundColor', color);
	document.getElementById('ub-body-data-color').value = color2hex(color);
}

