// Author : ThomasV - License : GPL

//the index template is a sytem message.
//another message in i18n lists the parameters

function findparam(str2, param_name) {
	var pattern = "\\n\\|"+param_name+"=([\\s\\S]*?)\\n\\|([^=\\n\\|]+)=";
	var re2 = new RegExp(pattern);
	var m2 = str2.match(re2);
	if(m2) return m2[1];  
	return '';
}

function proofreadpage_index_init() {

	var toolbar = document.getElementById("toolbar"); 
	toolbar.parentNode.removeChild(toolbar);

	var text = document.getElementById("wpTextbox1"); 
	if(!text) return;

	params = '';
	if(text.value) {
		var re = /\{\{:MediaWiki:Proofreadpage_index_template([\s\S]*)\n\}\}/m;
		var m = text.value.match(re);
		if(!m) return; 
		params = m[1]+'\n\|END='; 
	}

	var f = text.parentNode; 
	var new_text = f.removeChild(text);

	var container = document.createElement("div");

	var index_attributes = self.prp_index_attributes.split('\n');
	var str = '<div style="display:none;"><textarea id="wpTextbox1" name="wpTextbox1">'+new_text.value+'</textarea></div>';
	str = str + '<table>';
	for(i=0;i<index_attributes.length;i++){
		m = index_attributes[i].split('|');
		param_name = m[0];

		if(m[1]) param_label=m[1]; else param_label=param_name;
		str = str + '<tr><td>'+param_label+': </td>';

		value = findparam(params,param_name);
		value = value.replace(/\{\{!\}\}/g,'|');

		if(m[2]) size=m[2]; else size="1";
		if(size=="1") {
			str = str + '<td><input	name="'+param_name+'" size=60 value="'+value+'"/></td></tr>'; 
		}
		else{
			str = str +'<td><textarea name="'+param_name+'" cols=60 rows='+size+'>'+value+'</textarea></td></tr>';
		}

	}
	str = str +'</table>';
	container.innerHTML = str;

	var saveButton = document.getElementById("wpSave");
	var previewButton = document.getElementById("wpPreview");
	var diffButton = document.getElementById("wpDiff");
	if(saveButton){
		saveButton.onclick = proofreadpage_fill_index;
		previewButton.onclick = proofreadpage_fill_index;
		diffButton.onclick = proofreadpage_fill_index;
	} 
	else {
		container.firstChild.nextSibling.setAttribute("readonly","readonly");
	}

	copywarn = document.getElementById("editpage-copywarn");
	f.insertBefore(container,copywarn);

}

function proofreadpage_fill_index() {
	var form = document.getElementById("editform");
	var result = "{{:MediaWiki:Proofreadpage_index_template";
	var index_attributes = self.prp_index_attributes.split('\n');

	for(i=0;i<index_attributes.length;i++){
		m = index_attributes[i].split('|');
		param_name = m[0];

		value = form.elements[param_name].value;
		//remove trailing \n
		value = value.replace(/\n$/,'');

		//replace pipe symbol everywhere...
		value = value.replace(/\|/g,'{{!}}');

		//...except in links...
		do { 
		   prev = value;
		   value = value.replace(/\[\[(.*?)\{\{!\}\}(.*?)\]\]/g,'[[$1|$2]]');
		}
		while (value != prev);

		//..and in templates
		do { 
		   prev = value;
		   value = value.replace(/\{\{(.*?)\{\{!\}\}(.*?)\}\}/g,'{{$1|$2}}');
		}
		while (value != prev);

		result = result + "\n|"+param_name+"="+value;
	}
	result = result + "\n}}";
	form.elements["wpTextbox1"].value = result;
}




//use hookevent instead of addOnLoadHook, so that the code is evalued after wikibits.js
hookEvent("load", proofreadpage_index_init);
