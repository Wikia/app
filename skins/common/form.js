YAHOO.util.Event.onAvailable("moving", function() {
	YAHOO.util.Event.preventDefault('highlightform');
	var aBodyXY = YAHOO.util.Dom.getXY('highlightform');
	var aDivSel = YAHOO.util.Dom.getElementsByClassName('formblock', 'div');
	var height, width;
	var curDiv = null;
	if (aDivSel) {
		height = YAHOO.util.Dom.getStyle(aDivSel[0], 'height').replace("px", "");
		width = YAHOO.util.Dom.getStyle(aDivSel[0], 'width').replace("px", "");

		function findDiv(target) {
			var cDiv = null;			
			while (cDiv == null) { 
				if (target.nodeName.toUpperCase() == 'DIV') {
					cDiv = target;
				} else {
					target = target.parentNode; 
				}
			}
			return cDiv;
		}
		
		function onblurFormElem(event) {
			if (curDiv) {
				YAHOO.util.Dom.setStyle("moving", 'display', 'none');
				YAHOO.util.Dom.addClass(curDiv, 'selected'); 
			}
			curDiv = null;
		}
		
		function onfocusFormElem(event) {
			if (!curDiv) {
				var target = YAHOO.util.Event.getTarget(event, true);
				curDiv = findDiv(target);
			}
			
			var selectedDivs = YAHOO.util.Dom.getElementsByClassName('selected', 'div');
			if (selectedDivs.length == 0) {
				YAHOO.util.Dom.setStyle("moving", 'display', 'none');
				if (curDiv) {
					YAHOO.util.Dom.addClass(curDiv, 'selected'); 
				}
			} else {
				if (selectedDivs.length > 0) {
					var prevDiv = selectedDivs[0];
					if (prevDiv != curDiv) {
						height = curDiv.offsetHeight;
						var prevHeight = prevDiv.offsetHeight;
						width = YAHOO.util.Dom.getStyle(curDiv, 'width').replace("px", "");
						if (prevDiv) YAHOO.util.Dom.removeClass(prevDiv, 'selected'); 
						var move = new YAHOO.util.Anim("moving", {
							top: {
								from: (prevDiv) ? (YAHOO.util.Dom.getXY(prevDiv)[1] - aBodyXY[1]) : 0, 
								to: (prevDiv) ? (YAHOO.util.Dom.getXY(curDiv)[1] - aBodyXY[1]) : 0
							},
							height: { from: prevHeight, to: height },
							width: { from: width, to: width }
						}, 1);
						move.duration = 0.4;
						move.onComplete.subscribe(function() {
							YAHOO.util.Dom.addClass(curDiv, 'selected'); 
							YAHOO.util.Dom.setStyle("moving", 'display', 'none');
						}); 
						YAHOO.util.Dom.setStyle("moving", 'display', 'block');
						move.animate();
					}
				}
			}
		}
			
		var oF = document.forms['highlightform'];
		var oElm = oF.getElementsByTagName('INPUT');
		var els = oElm.length;
		for(i = 0; i < els; i++) {
			if (oElm[i].type != 'hidden' && oElm[i].type != 'submit' && oElm[i].type != 'reset') {
				YAHOO.util.Event.addListener(oElm[i], "focus", onfocusFormElem);
				YAHOO.util.Event.addListener(oElm[i], "blur", onblurFormElem);
			}
		}
		var oEls = oF.getElementsByTagName('SELECT');
		var elss = oEls.length;
		for(i = 0; i < elss; i++) {
			YAHOO.util.Event.addListener(oEls[i], "focus", onfocusFormElem);
			YAHOO.util.Event.addListener(oEls[i], "blur", onblurFormElem);
		}

		YAHOO.util.Dom.setStyle("moving", 'display', 'none');
		YAHOO.util.Dom.addClass(aDivSel[0], 'selected'); 
	}
});
