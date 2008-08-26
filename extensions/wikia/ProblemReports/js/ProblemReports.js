// ProblemReports - JS for "report a problem" dialog
//

YAHOO.namespace('wikia');
YAHOO.wikia.ProblemReportsDialog = function () {}

YAHOO.wikia.ProblemReportsDialog.prototype = {

	panel: false,
	form: false,

	// add onlick event for 'report a problem' action tabs
	init: function(links) {
		YAHOO.util.Event.addListener(links, "click", this.onClick, {ns: wgNamespaceNumber, title: wgTitle, obj: this});
	},

	// onClick event handler for lazy loading approach
	fire: function() {
		this.onClick(false, {ns: wgNamespaceNumber, title: wgTitle, obj: this});
	},

	// keep "elem" value length below 512 (+ 1)
	checkTextareaLength: function(elem) {
		len = elem.textLength;

		if (len > 512) {
			elem.value = elem.value.substr(0,511);
		}
	},

	// callback for click on "report a problem" tab / link 
	onClick: function(type,args) {

		window.scrollTo(0,0);

		if (!args.obj.form) {
			// we don't have problem reports form content - get its content via AJAX

			document.body.style.cursor = 'wait'; // show we're doing something in background

			args.obj.form = document.createElement('div');
			args.obj.form.id = "reportProblemForm";
			args.obj.form.className = "roundedDiv";
			args.obj.form.style.cssText = "left: 150px; top: 100px; margin-top: 0; margin-left: 0";

			document.body.appendChild(args.obj.form);

			// get form content via AJAX
			var callback = {
				success: function(o) {
					document.body.style.cursor = 'default';
					o.argument.form.innerHTML = o.responseText;
					o.argument.showPanel(true);
				},
				failure: function(o) { document.body.style.cursor = 'default'; alert('error'); },
				argument: args.obj
			}

			// format AJAX request params
			YAHOO.util.Connect.asyncRequest("POST", wgScriptPath + wgScript, callback, "action=ajax&rs=wfProblemReportsAjaxGetDialog&rsargs[]=" + args.ns + "&rsargs[]=" +   encodeURIComponent(args.title) );
		}
		else {
			// yeah, we have problem reports form content - show it...
			args.obj.showPanel(false);
		}
	},

	// show dialog after content arrival (via AJAX)
	showPanel: function(firstTime) {

		// create, render & show YUI panel
		this.panel = new YAHOO.widget.Panel(this.form, {fixedcenter: false, modal: true, draggable: false, width: '565px', zIndex: 1500});

		this.panel.render(document.body);

		// center form
		var left = parseInt(YAHOO.util.Dom.getViewportWidth() / 2 - 580/2);
		YAHOO.util.Dom.setStyle(this.form, 'left', left + 'px');

		// register event handlers
		if (firstTime) {
			// register handler for close button
			YAHOO.util.Event.addListener("pr_cancel", "click", function(ev,o) {
				o.panel.hide();
			}, this);
		}	

		// register handler for beforeHideEvent
		this.panel.beforeHideEvent.subscribe(function(name, args, o) {
			o.track('cancel'); // track cancelled problem reports
		}, this);

		this.panel.show();

		// fill pr_browser with browser name, flash version and stuff
		YAHOO.util.Dom.get('pr_browser').innerHTML = this.getUserInfo();

		// tracking
		this.track('open');

		return false;
	},

	// submit dialog
	panelSubmit: function() {

		// send AJAX request
		var callback = {
			success: function(o) { o.argument.panelSubmitCheck(YAHOO.Tools.JSONParse(o.responseText)); },
			failure: function(o) { console.log(o); },
			argument: this
		}

		// format AJAX request params
		var fields = YAHOO.util.Dom.get('reportProblem').elements;
		var postData = "action=ajax&rs=wfProblemReportsAjaxReport";

		for (f=0; f < 6; f++) {
			postData += "&" + fields[f].name + "=" + encodeURIComponent(fields[f].value);
		}

		// add user browser info
		postData += '&pr_browser=' + encodeURIComponent(YAHOO.util.Dom.get('pr_browser').innerHTML);

		// block form submition
		YAHOO.util.Dom.get("pr_submit").disabled = true;
		YAHOO.util.Dom.get("pr_cancel").disabled = true;

		YAHOO.util.Dom.setStyle(this.form, 'cursor', 'progress');

		// send AJAX request
		YAHOO.util.Connect.asyncRequest('POST', wgScriptPath + wgScript, callback, postData);

		return false;
	},

	// check data returned by PHP logic after dialog submition
	panelSubmitCheck: function(data) {
		
		// reset reports dialog CSS
		YAHOO.util.Dom.get("pr_submit").disabled = false;
		YAHOO.util.Dom.get("pr_cancel").disabled = false;
		YAHOO.util.Dom.setStyle(this.form, 'cursor', 'default');

		YAHOO.util.Dom.removeClass('pr_email',   'errorField');
		YAHOO.util.Dom.removeClass('pr_summary', 'errorField');
		YAHOO.util.Dom.removeClass('pr_cat',     'errorField');

		// report is not valid
		if (data.valid == 0)
		{
			// highlight invalid form fields
			if (data.email_empty) {
				YAHOO.util.Dom.addClass('pr_email', 'errorField');
			}

			if (data.summary_empty || data.spam) {
				YAHOO.util.Dom.addClass('pr_summary', 'errorField');
			}

			if (data.cat_empty) {
				YAHOO.util.Dom.addClass('pr_cat', 'errorField');
			}

			YAHOO.util.Dom.get("pr_submit").disabled = false;
			YAHOO.util.Dom.get("pr_cancel").disabled = false;
			YAHOO.util.Dom.setStyle(this.form, 'cursor', 'default');

			this.track('invalid'); // track "invalid" problem reports

			// show message from JSON
			this.infobox(data.caption, data.msg, "OK", function() {this.hide()});

			return;
		}

		// don't track when we hide the panel
		this.panel.beforeHideEvent.unsubscribe();

		// report was saved -> hide report dialog and show summary dialog
		this.panel.hide();

		this.track('reported'); // track succesful problem reports

		this.infobox(data.caption, data.msg, "OK", function() {this.hide()});
	},

	// get user data (browser, skin, theme, etc)
	getUserInfo: function() {
		// user agent
		info  = 'Browser: ' + YAHOO.Tools.getBrowserEngine().ua;

		// flash
		flashVer = parseInt(YAHOO.Tools.checkFlash()) ? YAHOO.Tools.checkFlash() : 'none';
		info += ' Flash: ' + flashVer;

		// skin and theme
		info += ' Skin: ' + skin;
		if (typeof themename != 'undefined') {
			info += '-' + themename;
		}
		
		return info;
	},

	// YUI popup dialog wrapper
	infobox: function(header, body, txtOK, handleOK) {

		Dialog = new YAHOO.widget.SimpleDialog("wikiaDialogInfo",
		{
			width: "250px",
			zIndex: 999,
			effect: {effect: YAHOO.widget.ContainerEffect.FADE, duration: 0.25},
			fixedcenter: true,
			modal: true,
			draggable: true,
			close: false
		});

		var buttons = [ { text: txtOK, handler: handleOK, isDefault: true} ];

		Dialog.setHeader(header);
		Dialog.setBody(body);
		Dialog.cfg.setProperty('icon', YAHOO.widget.SimpleDialog.ICON_INFO);
		Dialog.cfg.queueProperty("buttons", buttons);

		Dialog.render(document.body);
		Dialog.show();
	},

	// do tracking stuff
	track: function(url) {
		if (YAHOO.Wikia && YAHOO.Wikia.Tracker) {
			YAHOO.Wikia.Tracker.trackByStr(null, 'report-problem/' + url);
		}
	}

}

if (typeof wikiaProblemReportsDialog == 'undefined') {

	var wikiaProblemReportsDialog = false;

	// initialize report a problem dialog handling JS
	YAHOO.util.Event.onDOMReady( function () {
		wikiaProblemReportsDialog = new YAHOO.wikia.ProblemReportsDialog();
		wikiaProblemReportsDialog.init(["fe_report_link", "ca-report-problem"]);
	});
}
