
function getMailAccount (lhost, email, lang) {
	email = email.toUpperCase();
	page="";
	if(email.indexOf("@GMAIL.COM")>-1)page = "mygmail";
	if(email.indexOf("@YAHOO.COM")>-1)page = "myyahoo";
	if(email.indexOf("@HOTMAIL.COM")>-1)page = "myhotmail";
	if(email.indexOf("@AOL.COM")>-1)page = "myaol";
	
	if(email)setMailAction(lhost, page, lang)
}

function setMailAction(lhost, page, lang){
	document.emailform.action="javascript:submit('" + lhost + "/extensions/wikia/getmycontacts/" + page + ".php?language=" +lang +"', 'POST')";
}

function toggleChecked(){
	var the_form = window.document.myform;
	for(var i=0; i<the_form.length; i++){
		if(the_form.elements[i].name == "list[]"){
			the_form.elements[i].checked = ((all_checked == 1)?false:true);
		}
	}

	all_checked = ((all_checked == 1)?0:1);
	
}

all_checked = 1;

