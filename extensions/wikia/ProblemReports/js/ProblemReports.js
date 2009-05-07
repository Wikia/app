// ProblemReports - JS for "report a problem" dialog
var ProblemReportsDialog = function () {};

ProblemReportsDialog.prototype = {

	panel: false,
	form: false,
	blocked: false,

	// add onlick event for 'report a problem' action tabs
	/*
	init: function(links) {
		YAHOO.util.Event.addListener(links, "click", this.onClick, {title: wgPageName, obj: this});
	},
	*/

	// onClick event handler for lazy loading approach
	fire: function() {
		this.onClick(false, {title: wgPageName, obj: this});
	},

	// keep "elem" value length below 512 (+ 1)
	checkTextareaLength: function(elem) {
		len = elem.textLength;

		if ( (len > 512) && (false == this.blocked) ) {			
			this.blocked = true;
			// disable the submit button & show the alert to tell the user what went wrong...
			YAHOO.util.Dom.addClass('pr_summary', 'errorField');
			YAHOO.util.Dom.get("pr_submit").disabled = true;
			this.infobox( pr_msg_exchead, pr_msg_exceeded, "OK", function() {this.hide()});
		} else if ((len <= 512) &&  (this.blocked)) {
				YAHOO.util.Dom.removeClass('pr_summary', 'errorField');
				YAHOO.util.Dom.get("pr_submit").disabled = false;
				this.blocked = false;
		}
	},

	// callback for click on "report a problem" tab / link 
	onClick: function(type,args) {
		// scroll to the top of the page
		window.scrollTo(0,0);

		var browserInfo = this.getBrowserInfo();

		// get problem reports form
		$.get(wgScript + '?action=ajax&rs=wfProblemReportsAjaxGetDialog&title=' + encodeURIComponent(args.title) + '&uselang='+ wgUserLanguage + '&cb=' + wgMWrevId + '-' + wgStyleVersion, function(html) {
			$("#positioned_elements").append(html);
			$('#reportProblemForm').makeModal({width: 580});
			$('#pr_browser').html(browserInfo);
		});
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

		for (f=0; f < fields.length; f++) {
			postData += (fields[f].name != '') ?  "&" + fields[f].name + "=" + encodeURIComponent(fields[f].value) : '';
		}

		// add user browser info
		postData += '&pr_browser=' + encodeURIComponent(YAHOO.util.Dom.get('pr_browser').innerHTML);

		// block form submition
		YAHOO.util.Dom.get("pr_submit").disabled = true;
		YAHOO.util.Dom.get("pr_cancel").disabled = true;

		YAHOO.util.Dom.setStyle(this.form, 'cursor', 'progress');

		// send AJAX request
		YAHOO.util.Connect.asyncRequest('POST', ((wgScript == null) ? (wgScriptPath + "/index.php") : wgScript), callback, postData);

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
	getBrowserInfo: function() {
		// user agent
		info  = 'Browser: ' + navigator.userAgent;

		// flash
		/*
		flashVer = parseInt(YAHOO.Tools.checkFlash()) ? YAHOO.Tools.checkFlash() : 'none';
		info += ' Flash: ' + flashVer;
		*/

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
