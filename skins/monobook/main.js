// macbre: moved here from onejstorule.js
var $ = YAHOO.util.Dom.get;

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

  Dialog.render(document.getElementById('container'));
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

  Dialog.render(document.getElementById('container'));
  Dialog.show();
}

function CreateDialogProgress(header, body)
{
  var Dialog = new YAHOO.widget.SimpleDialog("wikiaProgressDialog",
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

  Dialog.render(document.getElementById('container'));
  //Dialog.show(); // show it yourself

  return Dialog;
}

// ShowDialogInfo('Test Dialog',' foo bar', 'OK', function(){alert('OK is ok'); this.hide();}); // info dialog (OK)
// ShowDialogAsk('Test Dialog',' foo bar?', 'Yes', function(){alert('OK is ok'); this.hide();}, 'No', function(){alert('OK is not ok'); this.hide();}); // ask dialog (OK/NO)
// progress = CreateDialogProgress('Test Dialog', 'Doing something in background, please wait...'); progress.hide();
