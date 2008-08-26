
function submit(FILE, METHOD){

	var num = document.forms[0].elements.length;
	var url = "";

	//radio button 
	var j = 0;
	var a = 0;
	var radio_buttons = new Array();
	var nome_buttons = new Array();
	var the_form = window.document.forms[0];
	for(var i=0; i<the_form.length; i++){
		var temp = the_form.elements[i].type;
		if ( (temp == "radio") && ( the_form.elements[i].checked) ) { 
			nome_buttons[a] = the_form.elements[i].name;
			radio_buttons[j] = the_form.elements[i].value; 
			j++; 
			a++;
		}
	}
	for(var k = 0; k < radio_buttons.length; k++) {
		url += nome_buttons[k] + "=" + radio_buttons[k] + "&";
	}
	//checkbox
	var j = 0;
	var a = 0;
	var check_buttons = new Array();
	var nome_buttons = new Array();
	var the_form = window.document.forms[0];
	for(var i=0; i<the_form.length; i++){
		var temp = the_form.elements[i].type;
		if ( (temp == "checkbox") && ( the_form.elements[i].checked) ) { 
			nome_buttons[a] = the_form.elements[i].name;
			check_buttons[j] = the_form.elements[i].value; 
			j++; 
			a++;
		}
	}
	for(var k = 0; k < check_buttons.length; k++) {
		url += nome_buttons[k] + "=" + check_buttons[k] + "&";
	}
	for (var i = 0; i < num; i++){
		
		var chiave = document.forms[0].elements[i].name;
		var valore = document.forms[0].elements[i].value;
		var tipo = document.forms[0].elements[i].type;

		if ( (tipo == "submit") || (tipo == "radio") || (tipo == "checkbox") ){}
		else {
			url += chiave + "=" + valore + "&";
		}
	}
	var parameters = url;
	url = FILE + "?" + url;
	if (METHOD == undefined) { METHOD = "GET"; 	}
	if (METHOD == "GET") { ahah(url, 'target', '', METHOD); }
	else { ahah(FILE, 'target', '', METHOD, parameters); }
}

function ahah(url, target, delay, method, parameters) {

  if (method == undefined) { 
	  document.getElementById(target).innerHTML = "<p>Please wait while we load your contacts....</p><img src=images/loading.gif>";
	  document.emailform.reset();
	  if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	  } else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  if (req) {
		req.onreadystatechange = function() {
			ahahDone(url, target, delay, method, parameters);
		};
		req.open("GET", url, true);
		req.send("");
	  }  
  }
  if ( (method == "GET") || (method == "get") )
  {
	  document.getElementById(target).innerHTML = "<p>Please wait while we load your contacts....</p><img src=images/loading.gif>";
	  document.emailform.reset();
	  if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	  } else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  if (req) {
		req.onreadystatechange = function() {
			ahahDone(url, target, delay, method, parameters);
		};
		req.open(method, url, true);
		req.send("");
	  }
  }

  if ( (method == "POST") || (method == "post") )
  {
      document.getElementById(target).innerHTML = "<p>Please wait while we load your contacts....</p><img src=images/loading.gif>";
	  document.emailform.reset();
	  if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	  } else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  if (req) {
		req.onreadystatechange = function() {
			ahahDone(url, target, delay, method, parameters);
		};
		req.open(method, url, true);
		req.setRequestHeader("enctype=multipart/form-data");
		req.send(parameters);
	  }
  }
}  

function ahahDone(url, target, delay, method, parameters) {
  if (req.readyState == 4) { 
    if (req.status == 200) { 
      document.getElementById(target).innerHTML = req.responseText;
    } else {
      document.getElementById(target).innerHTML="ahah error:\n"+req.statusText;
    }
  }
}	