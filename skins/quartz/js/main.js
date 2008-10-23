YAHOO.util.Event.onDOMReady(function() {
	initAutoComplete();
//	YAHOO.util.Event.addListener(window, 'resize', setCarouselNumVisible);
});

/* fix widget cockpit - begin */
function setCarouselNumVisible() {
	if(carousel) {
	var widgetEl = YAHOO.util.Dom.get('widget_cockpit_list').firstChild;
	var widgetElWidth = parseInt(YAHOO.util.Dom.getStyle(widgetEl,'width'))+(parseInt(YAHOO.util.Dom.getStyle(widgetEl,'margin-right'))* 2);
	var carouselWidth = parseInt(YAHOO.util.Dom.getX('next-arrow')-YAHOO.util.Dom.getX('prev-arrow')-32);
	var numVisible = Math.floor( carouselWidth / widgetElWidth );
	carousel.setProperty('numVisible', Math.min(c_size, numVisible) );
	}
}
/* fix widget cockpit - end */

/* AutoComplete/SearchSuggest - Inez - begin */
function initAutoComplete() {

	var submitAutoComplete_callback = {
		success: function(o) {
			if(o.responseText !== undefined) {
				window.location.href=o.responseText;
			}
		}
	}

	var submitAutoComplete = function(comp, resultListItem) {
		YAHOO.Wikia.Tracker.trackByStr(null, 'search/suggestItem/' + escape(YAHOO.util.Dom.get('searchfield').value.replace(/ /g, '_')));

		sUrl = wgServer + wgScriptPath + '?action=ajax&rs=getSuggestedArticleURL&rsargs=' + encodeURIComponent(document.getElementById ( 'searchfield' ).value);
		var request = YAHOO.util.Connect.asyncRequest ( 'GET', sUrl, submitAutoComplete_callback );
	}

	// Assign 'enter' key handler for search field
	YAHOO.util.Event.addListener( 'searchfield', 'keypress', function(e) { if(e.keyCode==13) { YAHOO.util.Dom.get('searchform').submit(); } } );

	// Init datasource
	var oDataSource = new YAHOO.widget.DS_XHR(wgServer + wgScriptPath, [ "\n" ]);
	oDataSource.responseType = YAHOO.widget.DS_XHR.TYPE_FLAT;
	oDataSource.scriptQueryParam = "rsargs";
	oDataSource.scriptQueryAppend = "action=ajax&rs=searchSuggest";

	// Init AutoComplete object and assign datasource object to it
	var oAutoComp = new YAHOO.widget.AutoComplete('searchfield','searchSuggestContainer', oDataSource);
	oAutoComp.autoHighlight = false;
	oAutoComp.typeAhead = true;
	oAutoComp.queryDelay = 1;
	oAutoComp.itemSelectEvent.subscribe(submitAutoComplete);
}
/* AutoComplete/SearchSuggest - Inez - end */

/* setTopContentSection - Inez - begin */
function setTopContentSection(o) {
	var full_id = o.parentNode.parentNode.id;
	var instanceId = full_id.split('_')[1];
	YAHOO.util.Dom.setStyle(YAHOO.util.Dom.get('WidgetTopContent_'+instanceId+'_content').getElementsByTagName('ul'), 'display', 'none' );
	YAHOO.util.Dom.setStyle(o.options[o.selectedIndex].value + '_' + instanceId, 'display', 'block' );
	refreshWidget("name=WidgetTopContent&instance=" + instanceId + "&at=" + o.options[o.selectedIndex].value + "&", "WidgetTopContent_" + instanceId, null);
}
/* setTopContentSection - Inez - end */


/* macbre: tooltips */
function wikiaTooltip()
{
	var tooltipDiv = false;
	var params    = new Array();
	var obj           = this;

	var timeoutId;

	// returns whether tooltip is shown
	this.isShown = function() {return this.tooltipDiv != false;}

	// initialize tooltip with msg, close it after timeout ms and allow to close tooltip when user clicks on it (?)
	this.init = function(msg, timeout, closeOnClick)
	{
		this.params = {"msg": msg, "timeout": timeout, "closeOnClick": closeOnClick};
		this.tooltipDiv = false;
	}

	// closes tooltip
	this.close = function()
	{
		if (!obj.tooltipDiv) return;

		animOut = new YAHOO.util.Anim(obj.tooltipDiv, {opacity: {from: 0.9, to:0}}, 1);
		animOut.animate();

		animOut.onComplete.subscribe( function() {if (obj.tooltipDiv && obj.tooltipDiv.parentNode) obj.tooltipDiv.parentNode.removeChild(obj.tooltipDiv);});
	}

	// shows tooltip at (x,y)
	this.show = function(x,y,cssClass)
	{
		// create tooltip
		this.tooltipDiv = document.createElement('div');

		this.tooltipDiv.id               = 'wikiaTooltip' + YAHOO.util.Dom.generateId();
		this.tooltipDiv.className = 'wikiaTooltip wikiaTooltip'+ cssClass;

		this.tooltipDiv.style.left  = x + 'px';
		this.tooltipDiv.style.top  = y + 'px';

		document.body.appendChild(this.tooltipDiv);

		this.tooltipDiv.innerHTML  = this.params.msg;

		// close on user click
		if (this.params.closeOnClick)	YAHOO.util.Event.addListener(this.tooltipDiv, 'click', function(e) {this.parentNode.removeChild(this);});

		// animate it!
		animIn = new YAHOO.util.Anim(this.tooltipDiv, {opacity: {from: 0.0, to:0.9}}, 1);
		animIn.animate();

		// close it after certain delay (set in init())
		if (this.params.timeout > 0)
			this.timeoutId = window.setTimeout(this.close, this.params.timeout + 1000);
	}
}

/* macbre: send to a friend JS functions (moved here from inline JS) */

// YUI dialogs used in SendToAFriend - must be global / shared between functions
var notifyPanel;
var notifyReport;
var reqNotify;

YAHOO.util.Event.onDOMReady( function ()
{
    // macbre: quick fix for wikia skin footer extra bottom margin issue
    if (document.getElementById('articleWrapper') && document.getElementById('notifyForm'))
    {
	document.body.appendChild(document.getElementById('notifyForm'));
	YAHOO.util.Dom.setStyle('notifyForm', 'top', '0px');
    }
});

function notifyShow() {

	// macbre: quick fix for monobook #notifyForm visibility issue
	if (document.getElementById('globalWrapper') && document.getElementById('notifyForm'))
	    document.getElementById('globalWrapper').appendChild(document.getElementById('notifyForm'));

	// create & show YUI dialog
	notifyPanel = new YAHOO.widget.Panel('notifyForm',{fixedcenter: true, modal: true, draggable: false, width: '362px'});

	notifyPanel.render(document.body);

	YAHOO.util.Dom.setStyle('stoaf_submit', 'display', 'inline');
	YAHOO.util.Dom.setStyle('stoaf_cancel', 'display', 'none');

	YAHOO.util.Dom.setStyle('stoaf_progress', 'visibility', 'hidden');

	notifyPanel.show();

	return false;
}

// handle notifyForm submittion
function notifySubmit()
{
   // macbre: show progress indicator and cancel button
   YAHOO.util.Dom.setStyle('stoaf_submit', 'display', 'none');
   YAHOO.util.Dom.setStyle('stoaf_cancel', 'display', 'inline');

   YAHOO.util.Dom.setStyle('stoaf_progress', 'visibility', 'inherit');

    return notifySend(YAHOO.util.Dom.get('notification'));
}

// send notify request
function notifySend(form) {

	var callback = {
		success: function(o) { notifySendCallback(o.responseText); },
		failure: function(o) { notifySendCallback(false); }
	}

	url = form.action;

	if(url.indexOf('?') > 1) {
		url += '&';
	} else {
		url += '?';
	}

	// make request URL
	url += 'en=1&id=' + form.id.value + '&ns=' + form.ns.value + '&re=' + form.re.value + '&nm=' + form.name.value + '&fr=' + form.fr.value + '&to=' + form.to.value;

	// send request
	reqNotify = YAHOO.util.Connect.asyncRequest("GET", url, callback, null);

	return false;
}

// goes back to stf main dialog
function notifyBack()
{
	YAHOO.util.Dom.setStyle('stoaf_submit', 'display', 'inline');
	YAHOO.util.Dom.setStyle('stoaf_cancel', 'display', 'none');

	YAHOO.util.Dom.setStyle('stoaf_progress', 'visibility', 'hidden');

	notifyReport.hide();
	notifyPanel.show();
}

// aborts request
function notifyAbort()
{
	notifyPanel.hide();

	YAHOO.util.Connect.abort(reqNotify);
}

// handle request processing
function notifySendCallback(response)
{
	if (response == false)
	{
		YAHOO.util.Dom.get("articlesinject").innerHTML = "<hr /><br /><div><b>Sorry, our site is under heavy load. Please try again later...</b><br /><br /></div>";
	}
	else
	{
		YAHOO.util.Dom.get("articlesinject").innerHTML = response;
	}

	notifyReport = new YAHOO.widget.SimpleDialog('notifyReport', {
		width:  '377px',
		fixedcenter: true,
		draggable: false,
		close: true,
		modal: true
	});

	notifyReport.render(document.body);

	YAHOO.util.Dom.setStyle('stoaf_submit', 'display', 'inline');
	YAHOO.util.Dom.setStyle('stoaf_cancel', 'display', 'none');

	YAHOO.util.Dom.setStyle('stoaf_progress', 'visibility', 'hidden');

	notifyPanel.hide();
	notifyReport.show();

}
