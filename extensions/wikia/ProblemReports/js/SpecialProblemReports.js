// ProblemReports - JS for special page
//

// handle clicks on "actions" icons
function reportProblemAction(elem, id, statusID, msgWait, askMsg)
{
	// confirm removal of report
	if (statusID == 10 && !confirm(askMsg)) {
		return;
	}

	if (YAHOO.util.Dom.hasClass(elem, 'problemReportsActionGreyedOut')) {
		return;
	}

	var parentElem = elem.parentNode;
	var oldHTML = parentElem.innerHTML;

	// callback
	function reportProblemActionCallback(data)
	{
		var problemStatusMsg = YAHOO.util.Dom.get('problemReportsList-problem-' + data.reportID + '-status');

		problemStatusMsg.innerHTML = '<em class="reportProblemStatus' + data.status + '">' + data.text + '</em>';
		parentElem.innerHTML = oldHTML;

		// remove report
		if (data.status == 10) {
			parentElem.parentNode.parentNode.removeChild(parentElem.parentNode);

			// don't forget to remove report summary
			var problemDescTr = YAHOO.util.Dom.get('problemReportsList-problem-' + data.reportID + '-summary');

			if (problemDescTr)
			    problemDescTr.parentNode.removeChild(problemDescTr);
		}
		else {
			// update action icons state (do grey out)
			action_icons = YAHOO.util.Dom.get('problemReportsActions-' + data.reportID).getElementsByTagName('a');

			YAHOO.util.Dom.removeClass(action_icons, 'problemReportsActionGreyedOut');
			YAHOO.util.Dom.addClass('problemReportsActions-' + data.reportID + '-' + data.status, 'problemReportsActionGreyedOut');
		}

	}

	// display progress message
	parentElem.innerHTML = msgWait;

	var callback = {
		success: function(o) { reportProblemActionCallback(YAHOO.Tools.JSONParse(o.responseText)); },
		failure: function(o) { reportProblemActionCallback(YAHOO.Tools.JSONParse(o.responseText)); }
	}

	YAHOO.util.Connect.asyncRequest("POST", wgScriptPath + wgScript, callback, "action=ajax&rs=wfProblemReportsAjaxAPI&id=" + id +"&status=" + statusID);
}

// toogle problem description row
function reportProblemToogleSummary(id)
{
	var elem = YAHOO.util.Dom.get("problemReportsList-problem-" + id + "-summary");
	
	if (!elem) {
		return;
	}

	switch(elem.style.display) {
		case "none": elem.style.display = ""; break;
		default:     elem.style.display = "none"; break;
	}
}

// sets up menu of templated responses in mailer form
function reportProblemMailerResponsesTemplatesSetup(list, textarea, footer)
{
	if (!list || !textarea || list.childNodes.length == 0) {
		return;
	}

	var args = {textarea: textarea, footer: footer};

	// add onlick handler for li > a elements
	for (i=0; i < list.childNodes.length; i++)
	{
		anchor = list.childNodes[i].getElementsByTagName('a')[0];

		anchor.href = '#mailer-message';

		// onclick handler
		YAHOO.util.Event.addListener(anchor, "click", function(type, args) {

			// make ajax request
			var callback = {
				success: function(o) {
					o.argument.textarea.style.cursor = 'text';
					o.argument.textarea.disabled = false;
					o.argument.textarea.value = o.responseText + "\n\n----\n" + o.argument.footer;
				},
				failure: function(o) {
					o.argument.textarea.style.cursor = 'text';
					o.argument.textarea.disabled = false;
					o.argument.textarea.value = '';
				},
				argument: args
			}

			// get template content via AJAX call
			req = YAHOO.util.Connect.asyncRequest("POST", wgScriptPath + wgScript, callback, "action=raw&title=" + encodeURI(this.title));

			textarea.style.cursor = 'wait';
			textarea.disabled = true;

		}, args);
    }
}

// send AJAX request to change problem type
function reportProblemChangeType(id, selectObj) {
	var typeId = selectObj.options[ selectObj.selectedIndex ].value;
	
	var callback = {
		success: function(o) { window.location.reload(); },
		failure: function(o) { selectObj.disabled = false; }
	}

	selectObj.disabled = true;

	YAHOO.util.Connect.asyncRequest("POST", wgScriptPath + wgScript, callback, "action=ajax&rs=wfProblemReportsAjaxAPI&id=" + id +"&type=" + typeId);
}

