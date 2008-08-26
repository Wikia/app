// Author : ThomasV - License : GPL


function proofreadpage_init_tabs(){

	var a = document.getElementById("p-cactions");
	if (!a) return;
	var b = a.getElementsByTagName("ul");
	if (!b) return;

	if(self.proofreadPageViewURL) {
		b[0].innerHTML = b[0].innerHTML 
			+ '<li id="ca-image">'
			+ '<a href="'+proofreadPageViewURL+'">'
			+ proofreadPageMessageImage+'</a></li>';
	}

	if(self.proofreadPageIndexURL){
		b[0].innerHTML = b[0].innerHTML 
			+ '<li id="ca-index">'
			+ '<a href="'+proofreadPageIndexURL+'" title="'+proofreadPageMessageIndex+'">'
			+ '<img src="'+wgScriptPath+'/extensions/ProofreadPage/uparrow.png" alt="'+proofreadPageMessageIndex+'" width="15" height="15" /></a></li>';
	}

	if(self.proofreadPageNextURL){
		b[0].innerHTML = 
			'<li id="ca-next">'
			+ '<a href="'+self.proofreadPageNextURL+'" title="'+proofreadPageMessageNextPage+'">'
			+ '<img src="'+wgScriptPath+'/extensions/ProofreadPage/rightarrow.png" alt="'+proofreadPageMessageNextPage+'" width="15" height="15" /></a></li>'
			+ b[0].innerHTML ;
	}

	if(self.proofreadPagePrevURL){
		b[0].innerHTML = 
			'<li id="ca-prev">'
			+ '<a href="'+self.proofreadPagePrevURL+'" title="'+proofreadPageMessagePrevPage+'">'
			+ '<img src="'+wgScriptPath+'/extensions/ProofreadPage/leftarrow.png" alt="'+proofreadPageMessagePrevPage+'" width="15" height="15" /></a></li>'
			+ b[0].innerHTML ;
       }
}





function proofreadpage_image_url(requested_width){
        var image_url;

        if(self.proofreadPageExternalURL) {
		image_url = proofreadPageExternalURL; 
	}
	else {

		//enforce quantization: width must be multiple of 100px
		var width = (100*requested_width)/100;

		if(width < proofreadPageWidth)  {
			 self.DisplayWidth = width;
			 self.DisplayHeight = width*proofreadPageHeight/proofreadPageWidth;
			 image_url = proofreadPageThumbURL.replace('##WIDTH##',""+width); 
		}
		else {
		     self.DisplayWidth = proofreadPageWidth;
		     self.DisplayHeight = proofreadPageHeight;
		     image_url = proofreadPageViewURL; 
		}
	}

	return image_url;
}



function proofreadpage_make_edit_area(container,text){

	re = /^<noinclude>([\s\S]*?)\n*<\/noinclude>([\s\S]*)<noinclude>([\s\S]*?)<\/noinclude>\n$/;
	m = text.match(re);
	if(m) {
		pageHeader = m[1];
		pageBody   = m[2];
		pageFooter = m[3];
	}
	else {
		re2 = /^<noinclude>([\s\S]*?)\n*<\/noinclude>([\s\S]*?)\n$/;
		m2 = text.match(re2);
		if(m2) {
			pageHeader = m2[1];
			//apparently lookahead is not supported by all browsers
			//so let us do another regexp
			re3 = /^([\s\S]*?)<noinclude>([\s\S]*?)<\/noinclude>/;
			m3 = m2[2].match(re3);
			if(m3){
				pageBody   = m3[1];
				pageFooter = m3[2];
			}
			else{
				pageBody   = m2[2];
				pageFooter = '';
			}
		}
		else {
			pageHeader = '{{PageQuality|1|}}<div class="pagetext">';
			pageBody = text;
			pageFooter = '<references/></div>';
			document.editform.elements["wpSummary"].value="/* "+proofreadPageMessageQuality1+" */ ";
		}
	}

        //escape & character
	pageBody = pageBody.split("&").join("&amp;")
	pageHeader = pageHeader.split("&").join("&amp;")
	pageFooter = pageFooter.split("&").join("&amp;")

	container.innerHTML = ''
		+'<div id="prp_header" style="display:none">'+proofreadPageMessageHeader+'<br/>'
		+'<textarea name="headerTextbox" rows="4" cols="80">'+pageHeader+'</textarea>'
		+'<br/>'+proofreadPageMessagePageBody+'<br/></div>'
		+'<textarea name="wpTextbox1" id="wpTextbox1" rows="40" cols="80">'+pageBody+'</textarea>'
		+'<div id="prp_footer" style="display:none"><br/>'+proofreadPageMessageFooter+'<br/>'
		+'<textarea name="footerTextbox" rows="4" cols="80">'+pageFooter+'</textarea></div>';


	var saveButton = document.getElementById("wpSave"); 
	var previewButton = document.getElementById("wpPreview"); 
	var diffButton = document.getElementById("wpDiff")
	if(saveButton){
		saveButton.onclick = proofreadPageFillForm;
		previewButton.onclick = proofreadPageFillForm;
		diffButton.onclick = proofreadPageFillForm;
	} 
	else {
		container.firstChild.nextSibling.setAttribute("readonly","readonly");
	}

}


function proofreadpage_toggle_visibility() {

	var box = document.getElementById("wpTextbox1");
	var h = document.getElementById("prp_header"); 
	var f = document.getElementById("prp_footer"); 
	if( h.style.cssText == ''){
		h.style.cssText = 'display:none';
		f.style.cssText = 'display:none';
		if(self.TextBoxHeight)	box.style.cssText = "height:"+(TextBoxHeight-7)+"px";
	} else {
		h.style.cssText = '';
		f.style.cssText = '';
		if(self.TextBoxHeight)  box.style.cssText = "height:"+(TextBoxHeight-270)+"px";
	}
}




function proofreadpage_default_setup() {

	self.displayWidth = 400; //default value

	if (parseInt(navigator.appVersion)>3) {
		if (navigator.appName.indexOf("Microsoft")!=-1) {
			displayWidth = parseInt(document.body.offsetWidth/2-70);
		} else {
			displayWidth = parseInt(window.innerWidth/2-70);
		}
	}

        var image_url = proofreadpage_image_url(displayWidth);

	if(self.DisplayHeight) self.TextBoxHeight = DisplayHeight;
	else self.TextBoxHeight = 700;

	if(proofreadPageIsEdit) {
		var text = document.getElementById("wpTextbox1"); 
		if (!text) return;
	}
	else { 
		var text = document.getElementById("bodyContent"); 
		if(!text) return;
	}


	//image 
	var image = document.createElement("img");
	image.setAttribute("src", image_url); 
	image.style.cssText = "padding:0;margin:0;border:0;";

	//container
	//useful for hooking elements to the image, eg href or zoom.
	var container = document.createElement("div");
	container.setAttribute("id", "proofreadImage");
	container.appendChild(image);

	var table = document.createElement("table");
	table.setAttribute("id", "textBoxTable");
	table.style.cssText = "width:100%;";
	var t_body = document.createElement("tbody");
	var t_row = document.createElement("tr");
	t_row.setAttribute("valign","top");
	var cell_left = document.createElement("td");
	cell_left.style.cssText = "width:50%; padding-right:0.5em;";
	var cell_right = document.createElement("td");
	cell_right.appendChild(container);
	cell_right.setAttribute("rowspan","3");
	t_row.appendChild(cell_left);
	t_row.appendChild(cell_right);
	t_body.appendChild(t_row);
	table.appendChild(t_body);

    
	var f = text.parentNode; 
	var new_text = f.removeChild(text);

	if(proofreadPageIsEdit) {
		proofreadpage_make_edit_area(cell_left,new_text.value);
		var toolbar = document.getElementById("toolbar");
		if(toolbar){
			var image = document.createElement("img");
			image.width = 23;
			image.height = 22;
			image.className = "mw-toolbar-editbutton";
			image.src = wgScriptPath+'/extensions/ProofreadPage/button_category_plus.png';
			image.border = 0;
			image.alt = proofreadPageMessageToggleHeaders;
			image.title = proofreadPageMessageToggleHeaders;
			image.style.cursor = "pointer";
			image.onclick = proofreadpage_toggle_visibility;
			toolbar.appendChild(image);
		}
		copywarn = document.getElementById("editpage-copywarn");
		f.insertBefore(table,copywarn);
		document.getElementById("wpTextbox1").style.cssText = "height:"+(TextBoxHeight-7)+"px";

	} else {
		cell_left.appendChild(new_text);
		f.appendChild(table);
	}

}




function proofreadPageFillForm() {
	var form = document.getElementById("editform");
	var header = form.elements["headerTextbox"];
	var footer = form.elements["footerTextbox"];
	if(header){
		var h = header.value.replace(/(\s*(\r?\n|\r))+$/, ''); 
		if(h) h = "<noinclude>"+h+"\n\n\n</noinclude>";
		var f = footer.value;
		if(f) f = "<noinclude>\n"+f+"</noinclude>";
		var ph = header.parentNode; 
		ph.removeChild(header);
		var pf = footer.parentNode; 
		pf.removeChild(footer);
		form.elements["wpTextbox1"].value = h+form.elements["wpTextbox1"].value+f;
		form.elements["wpTextbox1"].setAttribute('readonly',"readonly");
	}

}






/*
 *  Mouse Zoom.  Credits: http://valid.tjp.hu/zoom/
 */

// global vars
var lastxx, lastyy, xx, yy;

var zp_clip;  //zp_clip is the large image
var zp_container;

var zoomamount_h=2; 
var zoomamount_w=2; 
var zoom_status=''; 

var ieox=0; var ieoy=0; 
var ffox=0; var ffoy=0;


//mouse move
function zoom_move(evt) {

	if(zoom_status != 1) { return false;}

	if(typeof(evt) == 'object') {
		evt = evt?evt:window.event?window.event:null; if(!evt){ return false;}
		if(evt.pageX) {
			xx=evt.pageX - ffox;
			yy=evt.pageY - ffoy;
		}
		else {
			if(typeof(document.getElementById("proofreadImage")+1) == 'number') {return true;} 
			xx=evt.clientX - ieox;
			yy=evt.clientY - ieoy;
		}
	}
	else { 
		xx = lastxx; 
		yy = lastyy; 
	}
	lastxx = xx; 
        lastyy = yy;

	//new
        zp_clip.style.margin = 
                  ((yy > objh )?(objh*(1-zoomamount_h)):(yy*(1-zoomamount_h))) + 'px 0px 0px '
		+ ((xx > objw )?(objw*(1-zoomamount_w)):(xx*(1-zoomamount_w)))
		+ 'px';

	return false;
}






function zoom_off() {
	zp_container.style.width='0px';
	zp_container.style.height='0px';
	zoom_status = 0;
}




function countoffset() {
	zme=document.getElementById("proofreadImage");
	ieox=0; ieoy=0;
	for(zmi=0;zmi<50;zmi++) {
		if(zme+1 == 1) { 
			break;
		} 
		else {
			ieox+=zme.offsetLeft; 
			ieoy+=zme.offsetTop;
		}
		zme=zme.offsetParent; 
	}
	ffox=ieox;
	ffoy=ieoy;
	ieox-=document.body.scrollLeft;
	ieoy-=document.body.scrollTop;
}




function zoom_mouseup(evt) {

	 evt = evt?evt:window.event?window.event:null; 
	 if(!evt) return false;

	 //only left button; see http://unixpapa.com/js/mouse.html for why it is this complicated
	 if(evt.which == null) {
	 	if(evt.button != 1) return false;
	 } else {
		if(evt.which > 1) return false;
	 }

	if(zoom_status == 0) {
       		zoom_on(evt);
		return false;
		}
	 else if(zoom_status == 1) {
		zoom_status = 2;
		return false;
	 }
	 else if(zoom_status == 2) {
	 	zoom_off(); 
		return false;
	 }
	 return false;
}


function zoom_on(evt) {
	evt = evt?evt:window.event?window.event:null; if(!evt){ return false;}
	zoom_status=1;

	if(evt.pageX) {
		countoffset();
		lastxx=evt.pageX - ffox; 
		lastyy=evt.pageY - ffoy;
		} 
	else {
		countoffset();
		lastxx=evt.clientX - ieox;
		lastyy=evt.clientY - ieoy; 
	}

	zoomamount_h = zp_clip.height/objh;
	zoomamount_w = zp_clip.width/objw;

        zp_container.style.margin = '0px 0px 0px 0px';
	zp_container.style.width = objw+'px';
	zp_container.style.height = objh+'px';

	zoom_move('');
	return false;
}


function proofreadPageZoom(){

	if(navigator.appName == "Microsoft Internet Explorer") return;
	if(!self.proofreadPageViewURL) return;
	if(self.DisplayWidth>800) return;

	zp = document.getElementById("proofreadImage");
	if(zp){
		var hires_url = proofreadpage_image_url(800);
		self.objw = zp.firstChild.width;
		self.objh = zp.firstChild.height;

		zp.setAttribute("onmouseup","zoom_mouseup(event);" );
		zp.setAttribute("onmousemove","zoom_move(event);" );

		zp_container = document.createElement("div");
		zp_container.style.cssText ="position:absolute; width:0; height:0; overflow:hidden;";
		zp_clip = document.createElement("img");
		zp_clip.setAttribute("src", hires_url);
		zp_clip.style.cssText = "padding:0;margin:0;border:0;";
		zp_container.appendChild(zp_clip);
		zp.insertBefore(zp_container,zp.firstChild); 

	}
}




function proofreadpage_init() {

	if( document.getElementById("proofreadImage")) return;

	if(document.URL.indexOf("action=protect") > 0 || document.URL.indexOf("action=unprotect") > 0) return;
	if(document.URL.indexOf("action=delete") > 0 || document.URL.indexOf("action=undelete") > 0) return;
	if(document.URL.indexOf("action=watch") > 0 || document.URL.indexOf("action=unwatch") > 0) return;
	if(document.URL.indexOf("action=history") > 0 ) return;

	/*check if external url is provided*/				       
	if(!self.proofreadPageViewURL) {
		var text = document.getElementById("wpTextbox1"); 
		if (text) {
			proofreadPageIsEdit = true;
			re = /<span class="hiddenStructure" id="pageURL">\[http:\/\/(.*?)\]<\/span>/;
			m = re.exec(text.value);
			if( m ) { 
				self.proofreadPageExternalURL = "http://"+m[1];  
			}
		} 
		else {
			proofreadPageIsEdit = false;
			text = document.getElementById("bodyContent"); 
			try { 
				var a = document.getElementById("pageURL");
				var b = a.firstChild;
				self.proofreadPageExternalURL = b.getAttribute("href");
			} catch(err){};
		}
		//set to dummy values, not used
		self.proofreadPageWidth = 400;
		self.proofreadPageHeight = 400;
	}

	if(!self.proofreadPageViewURL && !self.proofreadPageExternalURL) return;

	if( self.proofreadpage_setup ) 

	     proofreadpage_setup(
		proofreadPageWidth,
		proofreadPageHeight, 
		proofreadPageIsEdit);

	else proofreadpage_default_setup();
}



addOnloadHook(proofreadpage_init);
addOnloadHook(proofreadpage_init_tabs);
hookEvent("load", proofreadPageZoom);




/*Quality buttons*/

function proofreadpage_add_quality(form,value){
 
	var text="";
	switch(value){
		case 1: text = proofreadPageMessageQuality1; break;
		case 2: text = proofreadPageMessageQuality2; break;
		case 3: text = proofreadPageMessageQuality3; break;
		case 4: text = proofreadPageMessageQuality4; break;
	}

	form.elements["wpSummary"].value="/* "+text+" */ ";
	s = form.elements["headerTextbox"].value;
	s = s.replace(/\{\{PageQuality\|(.*?)\}\}/gi,"")
	form.elements["headerTextbox"].value="{{PageQuality|"+value+"|"+wgUserName+"}}"+s;
	//remove template from wpTextbox1 in case it was corrupted
	s = form.elements["wpTextbox1"].value;
	s = s.replace(/\{\{PageQuality\|(.*?)\}\}/gi,"")
	form.elements["wpTextbox1"].value=s;
}


function proofreadpage_add_quality_buttons(){

        if(self.proofreadpage_no_quality_buttons) return;

	var ig  = document.getElementById("wpWatchthis");
	if(!ig) return;

	var s = document.editform.headerTextbox.value;
	var reg = /\{\{PageQuality\|([0-9]*(%|))(\|.*?|)\}\}/g;
	var m = reg.exec(s);
	var show4 = false;
	if(m) {
		//this is for backward compatibility
		if(m[1]=="100%") m[1]="4";
		if(m[1]=="75%") m[1]="3";
		if(m[1]=="50%") m[1]="1";
		if(m[1]=="25%") m[1]="2";

		if( (m[3] != "|"+wgUserName) && (m[1]=="3")) show4 = true;
		if(m[1] =="4") show4 = true;
	}
	var f = document.createElement("span");
	f.innerHTML = 
' <span class="quality2"> <input type="radio" name="quality" onclick="proofreadpage_add_quality(this.form,2)"> </span>'
+'<span class="quality1"> <input type="radio" name="quality" onclick="proofreadpage_add_quality(this.form,1)"> </span>'
+'<span class="quality3"> <input type="radio" name="quality" onclick="proofreadpage_add_quality(this.form,3)"> </span>';
	if(show4) f.innerHTML = f.innerHTML 
+ '<span class="quality4"> <input type="radio" name="quality" onclick="proofreadpage_add_quality(this.form,4)"> </span>';
	f.innerHTML = f.innerHTML + '&nbsp;'+proofreadPageMessageStatus;
	ig.parentNode.insertBefore(f,ig.nextSibling.nextSibling.nextSibling);
	if(m) { 
		switch(m[1]){
			case "4": document.editform.quality[3].checked=true; break;
			case "3": document.editform.quality[2].checked=true; break;
			case "1": document.editform.quality[1].checked=true; break; 
			case "2": document.editform.quality[0].checked=true; break; 
		}
	}
}

 

addOnloadHook(proofreadpage_add_quality_buttons);
