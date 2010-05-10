/*
 * Author: Inez Korczynski (korczynski at gmail dot com)
 */

YAHOO.example.AutoCompleteTextArea = function(a,b,c,d) {
	this.constructor.superclass.constructor.call(this,a,b,c,d);
	YAHOO.util.Event.removeListener(a, "keydown");
	YAHOO.util.Event.removeListener(a, "keypress");
};

YAHOO.lang.extend(YAHOO.example.AutoCompleteTextArea, YAHOO.widget.AutoComplete, {

	_suggestionSuccessful: false,

	_onTextboxKeyDown2: function(v,oSelf) {
		if ((v.keyCode == 221)) { //double brackets
			var text = oSelf._elTextbox.value.replace(/\r/g, "");
			var caret = oSelf.getCaret(oSelf._elTextbox);
                        if(text.charAt(i) == "]") {
				oSelf._toggleContainer(false);
                        }
		}

		if(v.keyCode== 27) {
			YAHOO.util.Event.preventDefault(v);
		}
	},

	// #2761
	_onTextboxKeyPress2: function(v,oSelf) {
		YAHOO.log('KeyPress code: #' + v.keyCode);

		switch(v.keyCode) {
			// up/dowm
			case 38:
			case 40:
				YAHOO.util.Event.preventDefault(v);
				YAHOO.log('UP/DOWN: stopEvent()');
				break;

			// enter
			case 13:
				 if(oSelf._oCurItem) {
                    			if(oSelf._nKeyCode != v.keyCode) {
                        			if(oSelf._bContainerOpen) {
                            				YAHOO.util.Event.stopEvent(v);
                        				YAHOO.log('ENTER: stopEvent()');
						}
                    			}
                    			oSelf._selectItem(oSelf._oCurItem);
                		}
                		else {
                    			oSelf._toggleContainer(false);
                		}
			break;

			// right
			case 39:
				oSelf._jumpSelection();
				YAHOO.util.Event.preventDefault(v);
				YAHOO.log('RIGHT: stopEvent()');
			break;
		}

	},

	_moveSelection: function(nKeyCode) {
		if(this._bContainerOpen) {
			// Determine current item's id number
			var oCurItem = this._oCurItem;
			var nCurItemIndex = -1;

			if(oCurItem) {
				nCurItemIndex = oCurItem._nItemIndex;
			}
			var nNewItemIndex = (nKeyCode == 40) ?
					(nCurItemIndex + 1) : (nCurItemIndex - 1);

			// Out of bounds
			if(nNewItemIndex < -2 || nNewItemIndex >= this._nDisplayedItems) {
				return;
			}

			if(oCurItem) {
				// Unhighlight current item
				this._toggleHighlight(oCurItem, "from");
				this.itemArrowFromEvent.fire(this, oCurItem);
			}
			if(nNewItemIndex == -1) {
				// Go back to query (remove type-ahead string)
				if(this.delimChar && this._sSavedQuery) {
					if(!this._textMatchesOption()) {
						this._elTextbox.value = this._sSavedQuery;
					}
					else {
						this._elTextbox.value = this._sSavedQuery + this._sCurQuery;
					}
				}
				else {
					//this._elTextbox.value = this._sCurQuery;
					this._toggleContainer(false);
				}
				this._oCurItem = null;
				return;
			}
			if(nNewItemIndex == -2) {
				// Close container
				this._toggleContainer(false);
				return;
			}

			var oNewItem = this._aListItems[nNewItemIndex];

			// Scroll the container if necessary
			var elContent = this._elContent;
			var scrollOn = ((YAHOO.util.Dom.getStyle(elContent,"overflow") == "auto") ||
				(YAHOO.util.Dom.getStyle(elContent,"overflowY") == "auto"));
			if(scrollOn && (nNewItemIndex > -1) &&
			(nNewItemIndex < this._nDisplayedItems)) {
				// User is keying down
				if(nKeyCode == 40) {
					// Bottom of selected item is below scroll area...
					if((oNewItem.offsetTop+oNewItem.offsetHeight) > (elContent.scrollTop + elContent.offsetHeight)) {
					// Set bottom of scroll area to bottom of selected item
						elContent.scrollTop = (oNewItem.offsetTop+oNewItem.offsetHeight) - elContent.offsetHeight;
					}
					// Bottom of selected item is above scroll area...
					else if((oNewItem.offsetTop+oNewItem.offsetHeight) < elContent.scrollTop) {
					// Set top of selected item to top of scroll area
						elContent.scrollTop = oNewItem.offsetTop;
					}
				}
				// User is keying up
				else {
					// Top of selected item is above scroll area
					if(oNewItem.offsetTop < elContent.scrollTop) {
						// Set top of scroll area to top of selected item
						this._elContent.scrollTop = oNewItem.offsetTop;
					}
					// Top of selected item is below scroll area
					else if(oNewItem.offsetTop > (elContent.scrollTop + elContent.offsetHeight)) {
						// Set bottom of selected item to bottom of scroll area
						this._elContent.scrollTop = (oNewItem.offsetTop+oNewItem.offsetHeight) - elContent.offsetHeight;
					}
				}
			}

			this._toggleHighlight(oNewItem, "to");
			this.itemArrowToEvent.fire(this, oNewItem);
			if(this.typeAhead) {
				this._updateValue(oNewItem);
			}
		}
	},

	_updateValue: function(oItem) {

		this.track('success');
		this._suggestionSuccessful = true;

		this._elTextbox.focus();

		var scrollTop = this._elTextbox.scrollTop;
		var text = this._elTextbox.value.replace(/\r/g, "");
		var caret = this.getCaret(this._elTextbox);

		for(var i = caret; i >= 0; i--) { // break for templates and normal links
			if( ( ( text.charAt(i - 1) == "[" ) && !this._bIsTemplate ) || ( ( text.charAt(i - 1) == "{" ) && this._bIsTemplate ) ) {
				break;
			}
		}

		var textBefore = text.substr(0, i);

		var newVal = textBefore + ((this._bIsTemplate && this._bIsSubstTemplate) ? 'subst:' : '' ) + (this._bIsColon ? ':' : '') + oItem._oResultData[0] + (this._bIsTemplate ? "}}" : "]]") + text.substr(i + this._originalQuery.length);
		this._elTextbox.value = newVal;

		if(YAHOO.env.ua.ie > 0) {
			caret = caret - this.row + 1;
		}

		this.setCaret(this._elTextbox, i +(this._bIsColon ? 1 : 0) + ((this._bIsTemplate && this._bIsSubstTemplate) ? 6 : 0 ) + oItem._oResultData[0].length + 2);
		this._oCurItem = oItem;
		this._elTextbox.scrollTop = scrollTop;
	},

	_sendQuery: function(sQuery) {
		var text = this._elTextbox.value.replace(/\r/g, "");
		var caret = this.getCaret(this._elTextbox);
		var sQueryStartAt;

		// also look forward, to see if we closed this one
		for(var i = caret; i < text.length; i++) {
			var c = text.charAt (i) ;
			if((c == "[") && (text.charAt(i - 1) == "[")) {
				break ;
			}
			if((c == "]") && (text.charAt(i - 1) == "]")) {
				return ;
			}
			if((c == "{") && (text.charAt(i - 1) == "{")) {
				break ;
			}
			if((c == "}") && (text.charAt(i - 1) == "}")) {
				return ;
			}
		}

		for(var i = caret; i >= 0; i--) {
			var c = text.charAt(i);
			if(c == "]" || c == "|") {
				if ( (c == "|") || ( (c == "]") && (text.charAt(i-1) == "]") ) ) {
					this._toggleContainer(false) ;
				}
				return;
			}

			if((c == "[") && (text.charAt(i - 1) == "[")) {
                                this._originalQuery = text.substr(i + 1, (caret - i - 1));
                                sQueryReal = this._originalQuery
                                        if (this._originalQuery.indexOf(':')==0){
                                                this._bIsColon = true;
                                                sQueryReal = sQueryReal.replace(':','');
                                        } else {
                                                this._bIsColon = false;
                                        }
                                this._bIsTemplate = false;
                                sQueryStartAt = i;
                                break;
			}

                        if((c == "{") && (text.charAt(i - 1) == "{")) {
                                this._originalQuery = text.substr(i + 1, (caret - i - 1));
                                this._bIsColon = false;
                                if (this._originalQuery.length >= 6 && this._originalQuery.toLowerCase().indexOf('subst:') == 0){
                                        sQueryReal = "Template:"+this._originalQuery.replace(/subst:/i,'');
                                        this._bIsSubstTemplate = true;
                                } else if (this._originalQuery.indexOf(':')==0){
                                        sQueryReal = this._originalQuery.replace(':','');
                                        this._bIsColon = true;
                                } else {
                                        sQueryReal = "Template:"+this._originalQuery;
                                        this._bIsSubstTemplate = false;
                                }
                                this._bIsTemplate = true;
                                sQueryStartAt = i;
                                break;
                        }
		}

		if(sQueryStartAt >= 0 && sQueryReal.length > 2) {
			YAHOO.example.AutoCompleteTextArea.superclass._sendQuery.call(this, encodeURI( sQueryReal ) );
		}
	},

	doBeforeExpandContainer: function(elTextbox, elContainer, sQuery, aResults) {
					// change the display
					for (var i=0, aList=elContainer.getElementsByTagName('li'); i<aList.length; i++){
						if (aList[i]._sResultKey){
							if (this._bIsTemplate){
								aList[i].innerHTML = aList[i].innerHTML.replace(ls_template_ns+':','');
								aList[i]._sResultKey = aList[i]._sResultKey.replace(ls_template_ns+':','');
								for (var j=0; j<aList[i]._oResultData.length; j++){
									aList[i]._oResultData[j] = aList[i]._oResultData[j].replace(ls_template_ns+':','');
								}
							}
						}
					}

		var position = this.getCaretPosition(elTextbox);
		elContainer.style.left = position[0] + 'px'
		elContainer.style.top = position[1] + 'px'

		/* #3378  */
		var maxLen = 20;

		for (var n=0; n<aResults.length; n++) {
			var len = aResults[n][0].length;
			if (maxLen < len) maxLen = len;
		}

		elContainer.style.width = Math.round((maxLen*7.5) < 400 ? maxLen*7.5 : 400) +'px';

		if (!this.isContainerOpen()) {
			this.track('open');
			this._suggestionSuccessful = false;
		}

		return true;
	},

	setCaret: function(control, pos) {
		if(control.setSelectionRange) {
			control.focus();
			control.setSelectionRange(pos, pos);
		} else if (control.createTextRange) {
			var range = control.createTextRange();
			range.collapse(true);
			range.moveEnd('character', pos);
			range.moveStart('character', pos);
			range.select();
		}
	},

	getCaret: function(control) {
		var caretPos = 0;
		// IE Support
		if(YAHOO.env.ua.ie != 0) {
			control.focus();
			var sel = document.selection.createRange();
			var sel2 = sel.duplicate();
			sel2.moveToElementText(control);
			var caretPos = -1;
			while(sel2.inRange(sel)) {
				sel2.moveStart('character');
				caretPos++;
			}
		// Firefox support
		} else if (control.selectionStart || control.selectionStart == '0') {
			caretPos = control.selectionStart;
		}
		return (caretPos);
	},

	getLineLength: function(control) {
		var width = control.scrollWidth;
		return Math.floor(width/8);
	},

	getCaretPosition: function(control) {
		var text = control.value.replace(/\r/g, "");
		var caret = this.getCaret(control);
		var lineLength = this.getLineLength(control);

		var row = 0;
		var charInLine = 0;
		var lastSpaceInLine = 0;

		for(i = 0; i < caret; i++) {
			charInLine++;
			if(text.charAt(i) == " ") {
				lastSpaceInLine = charInLine;
			} else if(text.charAt(i) == "\n") {
				lastSpaceInLine = 0;
				charInLine = 0;
				row++;
			}
			if(charInLine > lineLength) {
				if(lastSpaceInLine > 0) {
					charInLine = charInLine - lastSpaceInLine;

					lastSpaceInLine = 0;
					row++;
				}
			}
		}

		var nextSpace = 0;
		for(j = caret; j < caret + lineLength; j++) {
			if(text.charAt(j) == " " || text.charAt(j) == "\n" || caret == text.length) {
				nextSpace = j;
				break;
			}
		}

		if(nextSpace > lineLength && caret <= lineLength) {
			charInLine = caret - lastSpaceInLine;
			row++;
		}

		this.row = row;

		var top = 19+(2+(YAHOO.Tools.getBrowserAgent().mac ? 13 : 16)*row)-control.scrollTop;
		top += YAHOO.util.Dom.getY(this._elTextbox) - YAHOO.util.Dom.getY('article');
		top = Math.min(top, YAHOO.util.Dom.getY(this._elTextbox) - YAHOO.util.Dom.getY('article') + this._elTextbox.scrollHeight);
		top = Math.max(top, 0);

		var left = 3+(8*(charInLine-this._sCurQuery.length))-control.scrollLeft;
		left += YAHOO.util.Dom.getX(this._elTextbox) - YAHOO.util.Dom.getX('article');
		left = Math.min(left, this._elTextbox.scrollWidth - 161);
		left = Math.max(left, 0);

		return [left, top];
	},

	// RT #20343
	_onTextboxScroll: function(e, oSelf) {
		var position = oSelf.getCaretPosition(oSelf._elTextbox);
		oSelf._elContainer.style.left = position[0] + 'px'
		oSelf._elContainer.style.top = position[1] + 'px'
	},

	track: function(str) {
		//YAHOO.Wikia.Tracker.trackByStr(null, 'linkSuggest/' + str + (wgCanonicalSpecialPageName == 'Createpage' ? '/createPage' : '/editpage'));
	}

});

function LS_PrepareTextarea (textarea, oDS) {
	var oAutoComp = new YAHOO.example.AutoCompleteTextArea(textarea, 'wpTextbox1_container', oDS);
	oAutoComp.highlightClassName = oAutoComp.prehighlightClassName = 'navigation-hover';
	oAutoComp.typeAhead = oAutoComp.animHoriz = oAutoComp.animVert = oAutoComp.autoHighlight = oAutoComp.forceSelection = oAutoComp.useShadow = false;
	oAutoComp.minQueryLength = 1;
	oAutoComp.maxResultsDisplayed = 10;
	oAutoComp.queryDelay = 0.4;

	oAutoComp.containerExpandEvent.subscribe(function(o) {
			YAHOO.util.Event.removeListener(this._elTextbox, "keydown");
			YAHOO.util.Event.addListener(this._elTextbox, "keydown", this._onTextboxKeyDown, this);
			YAHOO.util.Event.addListener(this._elTextbox, "keydown", this._onTextboxKeyDown2, this);

			YAHOO.util.Event.removeListener(this._elTextbox, "keypress");
			YAHOO.util.Event.addListener(this._elTextbox, "keypress", this._onTextboxKeyPress, this);

			// RT #20343
			YAHOO.util.Event.removeListener(this._elTextbox, "scroll");
			YAHOO.util.Event.addListener(this._elTextbox, "scroll", this._onTextboxScroll, this);

			if ( YAHOO.Tools.getBrowserAgent().mac ) {
				YAHOO.util.Event.addListener(this._elTextbox, "keypress", this._onTextboxKeyPress2, this); // #2761
			}
			});

	oAutoComp.containerCollapseEvent.subscribe(function(o) {
			LS_itemUnHighlight();
			if ( this._suggestionSuccessful == false ) {
				this.track('close');
			}
			YAHOO.util.Event.removeListener(this._elTextbox, "keydown");
			YAHOO.util.Event.removeListener(this._elTextbox, "keypress");
			});

	oAutoComp.itemArrowToEvent.subscribe(LS_itemHighlight);
	oAutoComp.itemArrowFromEvent.subscribe(LS_itemUnHighlight);
}

var LS_previewTimer;
var LS_previewImages = {};
var LS_imageToPreview;

function LS_itemHighlight(oSelf , elItem) {
	clearTimeout(LS_previewTimer);
	if(elItem[1].innerHTML.indexOf(ls_file_ns+':') == 0) { // check if namespace of highlighted item is NS_FILE
		LS_imageToPreview = elItem[1].innerHTML.substring(ls_file_ns.length + 1); // get filename from highlighted item

		if(LS_previewImages[LS_imageToPreview]) {
			LS_preview(LS_imageToPreview);
		} else {
			LS_previewTimer = setTimeout(LS_preview, 750);
		}
	}
}

function LS_itemUnHighlight() {
	YAHOO.util.Dom.get('LS_imagePreview').style.visibility = 'hidden';
	clearTimeout(LS_previewTimer);
}

function LS_preview(image) {
	if(image) LS_imageToPreview = image;
	if(LS_previewImages[LS_imageToPreview]) {
		LS_realPreview(LS_previewImages[LS_imageToPreview]);
	} else {
	    var callback = {
			success: function(o) {
				LS_previewImages[LS_imageToPreview] = o.responseText;
				LS_realPreview(LS_previewImages[LS_imageToPreview]);
			},
			argument: LS_imageToPreview
	    }
		YAHOO.util.Connect.asyncRequest('GET', wgServer+wgScriptPath+'?action=ajax&rs=getLinkSuggestImage&imageName='+encodeURIComponent(LS_imageToPreview), callback);

	}
}

function LS_realPreview(s) {
	if((YAHOO.util.Dom.getX('wpTextbox1_container') + 180 + parseInt(YAHOO.util.Dom.get('wpTextbox1_container').style.width)) < YAHOO.util.Dom.getViewportWidth()) {
		YAHOO.util.Dom.get('LS_imagePreview').style.textAlign = 'left';
		YAHOO.util.Dom.get('LS_imagePreview').style.left = (parseInt(YAHOO.util.Dom.get('wpTextbox1_container').style.left) + parseInt(YAHOO.util.Dom.get('wpTextbox1_container').style.width) + 1) + 'px';
	} else {
		YAHOO.util.Dom.get('LS_imagePreview').style.textAlign = 'right';
		YAHOO.util.Dom.get('LS_imagePreview').style.left = (parseInt(YAHOO.util.Dom.get('wpTextbox1_container').style.left) - 181) + 'px';
	}
	YAHOO.util.Dom.get('LS_imagePreview').style.top = YAHOO.util.Dom.get('wpTextbox1_container').style.top;
	YAHOO.util.Dom.get('LS_imagePreview').style.visibility = '';
	if(s != 'N/A') s = '<img src="'+s+'"/>';
	YAHOO.util.Dom.get('LS_imagePreview').innerHTML = s;
}

addOnloadHook(function() {
	// So far this extension works only in Firefox and Internet Explorer
	if(YAHOO.env.ua.ie > 0 || YAHOO.env.ua.gecko > 0 || YAHOO.env.ua.webkit > 0) {
		var oDS = new YAHOO.widget.DS_XHR(wgServer + wgScriptPath, ["\n"]);
		oDS.responseType = YAHOO.widget.DS_XHR.TYPE_FLAT;
		oDS.scriptQueryAppend = 'action=ajax&rs=getLinkSuggest';

		// todo remember about old createpage...
		if ('createpage' != wgCanonicalSpecialPageName) {
			LS_PrepareTextarea ('wpTextbox1', oDS) ;
		} else {
			var content_root = YAHOO.util.Dom.get ('wpTableMultiEdit') ;
			var edit_textareas = YD.getElementsBy (function (el) {
					if (el.id.match ("wpTextboxes") && (el.style.display != 'none') ) {
						return true ;
					} else {
						return false ;
					}
				}, 'textarea', content_root, function (el) {
					LS_PrepareTextarea (el.id, oDS) ;
				}) ;
		}
	}
});
