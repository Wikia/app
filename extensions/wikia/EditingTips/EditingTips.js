/*
 *  * Author: Inez Korczynski (korczynski at gmail dot com)
 *
 */

YAHOO.util.Event.addListener(["toggleEditingTips", "editingTips_close"], "click", function(e) {
        YAHOO.util.Event.preventDefault(e);
        if(YAHOO.util.Dom.hasClass(document.body, "editingTips") && YAHOO.util.Dom.hasClass(document.body, "editingWide")) {
				SaveEditingTipsState(true);

                YAHOO.util.Dom.removeClass(document.body, "editingWide");
                if($("toggleWideScreen")) {
                        $("toggleWideScreen").innerHTML = editingTipsEnterMsg ;
                }
                if($("toggleEditingTips")) {
                        $("toggleEditingTips").innerHTML = "Hide Editing Tips";
                }

		YAHOO.Wikia.Tracker.trackByStr(e, 'editingTips/toggle/editingTips/on');

        } else if(YAHOO.util.Dom.hasClass(document.body, "editingTips")) {
				SaveEditingTipsState(false);

		YAHOO.Wikia.Tracker.trackByStr(e, 'editingTips/toggle/editingTips/off');

                YAHOO.util.Dom.removeClass(document.body, "editingTips");
                if($("toggleEditingTips")) {
                        $("toggleEditingTips").innerHTML = editingTipsShowMsg ;
                }
        } else {
				SaveEditingTipsState(true);

		YAHOO.Wikia.Tracker.trackByStr(e, 'editingTips/toggle/editingTips/on');

                YAHOO.util.Dom.addClass(document.body, "editingTips");
                if(!showDone) {
                        AccordionMenu.openDtById("firstTip");
                        showDone = true;
                }
                if($("toggleEditingTips")) {
                        $("toggleEditingTips").innerHTML = editingTipsHideMsg ;
                }
        }
});

function SaveEditingTipsState(open) {
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=SaveEditingTipsState&open='+open);
}

YAHOO.util.Event.addListener("toggleWideScreen", "click", function(e) {
        YAHOO.util.Event.preventDefault(e);
        if(YAHOO.util.Dom.hasClass(document.body, "editingWide")) {
                YAHOO.util.Dom.removeClass(document.body, "editingWide");
                YAHOO.util.Dom.removeClass(document.body, "editingTips");
                if($("toggleWideScreen")) {
                        $("toggleWideScreen").innerHTML = editingTipsEnterMsg ;
                }

		YAHOO.Wikia.Tracker.trackByStr(e, 'editingTips/toggle/widescreen/off');

        } else {
                YAHOO.util.Dom.addClass(document.body, "editingWide");
                YAHOO.util.Dom.addClass(document.body, "editingTips");
                if($("toggleWideScreen")) {
                        $("toggleWideScreen").innerHTML = editingTipsExitMsg ;
                }
                if($("toggleEditingTips")) {
                        $("toggleEditingTips").innerHTML = editingTipsShowMsg ;
                }

		YAHOO.Wikia.Tracker.trackByStr(e, 'editingTips/toggle/widescreen/on');
        }
});

// tracking
YAHOO.util.Event.onDOMReady(function() {
	var editingTipsHeaders = $('editingTips').getElementsByTagName("dt");

	YAHOO.util.Event.addListener(editingTipsHeaders, 'click', function(e) {
		var el = YAHOO.util.Event.getTarget(e);

		if (el.nodeName == 'SPAN') {
			el = el.parentNode;
		}

		if ( YAHOO.util.Dom.hasClass(el, 'a-m-t-expand') || YAHOO.util.Dom.hasClass(el, 'color1') ) {
			return;
		}

		tipId = (el.id == 'firstTip') ? 1 : (el.id.split('-')[1]);

		if (parseInt(tipId)) {
			YAHOO.Wikia.Tracker.trackByStr(e, 'editingTips/expand/' + tipId);
		}
	});

	YAHOO.util.Event.addListener('editingTips_close', 'click', function(e) {YAHOO.Wikia.Tracker.trackByStr(e, 'editingTips/close')});
});
