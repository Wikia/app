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
			$('#pr_summary'). addClass('errorField');
			$('#pr_submit').attr('disabled', true);
			this.infobox( pr_msg_exchead, pr_msg_exceeded, "OK", function() {this.hide()});
		}
		else if ((len <= 512) &&  (this.blocked)) {
			$('#pr_summary').removeClass('errorField');
			$('#pr_submit').attr('disabled', false);
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
		// format AJAX request URL
		var fields = $('#reportProblem').attr('elements');
		var url = wgScript + "?action=ajax&rs=wfProblemReportsAjaxReport";

		for (f=0; f < fields.length; f++) {
			url += (fields[f].name != '') ?  "&" + fields[f].name + "=" + encodeURIComponent(fields[f].value) : '';
		}

		// add user browser info
		url += '&pr_browser=' + encodeURIComponent(YAHOO.util.Dom.get('pr_browser').innerHTML);

		// block form submition
		$('#pr_submit, #pr_cancel').attr('disabled', true);

		// send AJAX request
		$.getJSON(url, this.panelSubmitCheck);

		return false;
	},

	// check data returned by PHP logic after dialog submition
	panelSubmitCheck: function(data) {
	
		$().log('ProblemReports: panelSubmitCheck()').log(data);
	
		// reset reports dialog CSS
		$('#pr_submit, #pr_cancel').attr('disabled', false);

		$('#pr_email, #pr_summary, #pr_cat').removeClass('errorField');

		// report is not valid
		if (data.valid == 0) {
			// highlight invalid form fields
			if (data.email_empty) {
				$('#pr_email').addClass('errorField');
			}

			if (data.summary_empty || data.spam) {
				$('#pr_summary').addClass('errorField');
			}

			if (data.cat_empty) {
				$('#pr_cat').addClass('errorField');
			}

			$('#pr_submit, #pr_cancel').attr('disabled', false);
		
			wikiaProblemReportsDialog.track('invalid'); // track "invalid" problem reports
		}
		else {
			// close the pop-up
			$(".modalWrapper").closeModal();

			wikiaProblemReportsDialog.track('reported'); // track succesful problem reports
		}

		// show message from JSON
		wikiaProblemReportsDialog.infobox(data.caption, data.msg, "OK", function() {this.hide()});
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

	// jQuery/Christian popup dialog wrapper
	infobox: function(header, body) {
		html = '<div id="problemReportsInfobox" title="' + header + '">' + body + '</div>';
		$("#positioned_elements").append(html);
		$("#problemReportsInfobox").makeModal({width: 200});
	},

	// do tracking stuff
	track: function(url) {
		$().log('ProblemReports: track "' + url + '"');
		// YAHOO.Wikia.Tracker.trackByStr(null, 'report-problem/' + url);
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
