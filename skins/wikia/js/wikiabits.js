// MediaWiki JavaScript support functions (Wikia addons)


// simple wrappers for YUI dialogs - used in ProblemReports extension
//
// usage:
// ShowDialogInfo('Test Dialog',' foo bar', 'OK', function(){alert('OK is ok'); this.hide();}); // info dialog (OK)
// ShowDialogAsk('Test Dialog',' foo bar?', 'Yes', function(){alert('OK is ok'); this.hide();}, 'No', function(){alert('OK is not ok'); this.hide();}); // ask dialog (OK/NO)
// progress = CreateDialogProgress('Test Dialog', 'Doing something in background, please wait...'); progress.hide();
//
function ShowDialogInfo(header, body, txtOK, handleOK)
{
  Dialog = new YAHOO.widget.SimpleDialog("wikiaDialog",
    {
	width: "250px",
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
}

function ShowDialogAsk(header, body, txtOK, handleOK, txtNO, handleNO)
{
  Dialog = new YAHOO.widget.SimpleDialog("wikiaDialog",
    {
    width: "250px",
    effect: {effect: YAHOO.widget.ContainerEffect.FADE, duration: 0.25},
    fixedcenter: true,
    modal: true,
    draggable: true,
    close: false
    });

  var buttons = [ { text: txtOK, handler: handleOK},  { text: txtNO, handler: handleNO} ];


  Dialog.setHeader(header);
  Dialog.setBody(body);
  Dialog.cfg.setProperty('icon', YAHOO.widget.SimpleDialog.ICON_WARN);
  Dialog.cfg.queueProperty("buttons", buttons);

  Dialog.render(document.body);
  Dialog.show();
}

function CreateDialogProgress(header, body)
{
  Dialog = new YAHOO.widget.SimpleDialog("wikiaProgressDialog",
    {
    width: "325px",
    fixedcenter: true,
    modal: true,
    draggable: false,
    close: false,
    visible: false
    });

  Dialog.setHeader(header);
  Dialog.setBody(body);

  Dialog.render(document.body);
  //Dialog.show(); // show it yourself

  return Dialog;
}



// macbre: ProblemReports common JavaScript functions
//
var reportProblemPanel;

YAHOO.util.Event.onDOMReady( function ()
{
    if (document.getElementById("articleWrapper") && document.getElementById("reportProblemForm"))
    {
	document.body.appendChild(document.getElementById("reportProblemForm"));
    }

    YAHOO.util.Event.addListener("ca-report-problem", "click", reportProblemShow);
});

// keep "elem" value length below 512 (+ 1)
function reportProblemCheckTextarea(elem)
{
	var len = elem.textLength;

	if (len > 512)
		elem.value = elem.value.substr(0,511);
}

function reportProblemShow() {

	// quick fix for monobook visibility issue
	if (document.getElementById("globalWrapper"))
	    document.getElementById("globalWrapper").appendChild(document.getElementById("reportProblemForm"));

	// create & render & show YUI panel
	reportProblemPanel = new YAHOO.widget.Panel("reportProblemForm",{fixedcenter: false, modal: true, draggable: false, width: '565px'});

	reportProblemPanel.render(document.body);

	// center form
	var left = parseInt(YAHOO.util.Dom.getViewportWidth() / 2 - 580/2);
	YAHOO.util.Dom.setStyle('reportProblemForm', 'left', left + 'px');

	reportProblemPanel.show();

	return false;
}

function reportProblemSubmit() {

	// send AJAX request
	var callback = {
		success: function(o) { reportProblemCallback(eval("(" + o.responseText + ")")); },
		failure: function(o) { reportProblemCallback(eval("(" + o.responseText + ")")); }
	}

	// format AJAX request params
	var form   = YAHOO.util.Dom.get("reportProblem");
	var fields = form.elements;
	var postData = "";

	for (f=0; f < 6; f++)
	{
		postData += fields[f].name + "=" + encodeURIComponent(fields[f].value) + "&";
	}

	// block form submition
	YAHOO.util.Dom.get("pr_submit").disabled = true;

	YAHOO.util.Dom.setStyle('reportProblemForm', 'cursor', 'progress');

	// send AJAX request
	reqReportProblem = YAHOO.util.Connect.asyncRequest("POST", form.action, callback, postData + "ajax=1");

	return false;
}

function reportProblemCallback(data)
{
	// spam detected: return to dialog...
	if (data.spam == 1)
	{
		YAHOO.util.Dom.setStyle('pr_summary', 'border', 'solid 1px #DC143C');
		YAHOO.util.Dom.setStyle('pr_summary', 'background-color', '#FFE4E1');

		ShowDialogInfo(data.caption, data.msg, "OK", function() {this.hide()});

		YAHOO.util.Dom.get("pr_submit").disabled = false;
		YAHOO.util.Dom.setStyle('reportProblemForm', 'cursor', 'default');

		return;
	}

	// hide report dialog and show summary dialog
	reportProblemPanel.hide();

	// reset reports dialog
	YAHOO.util.Dom.setStyle('pr_summary', 'border', '');
	YAHOO.util.Dom.setStyle('pr_summary', 'background-color', '');

	YAHOO.util.Dom.get("pr_submit").disabled = false;
	YAHOO.util.Dom.setStyle('reportProblemForm', 'cursor', 'default');

	ShowDialogInfo(data.caption, data.text, "OK", function() {this.hide()});
}
