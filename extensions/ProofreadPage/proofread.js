// Author : ThomasV - License : GPL

//todo : 
//add a state for empty pages : detect if textbox is empty
//use the API


function pr_init_tabs(){

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





function pr_image_url(requested_width){
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



function pr_make_edit_area(container,text){

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
		saveButton.onclick = pr_fill_form;
		previewButton.onclick = pr_fill_form;
		diffButton.onclick = pr_fill_form;
	} 
	else {
		//make the text area readonly
		container.firstChild.nextSibling.setAttribute("readonly","readonly");
	}
}


function pr_toggle_visibility() {

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

function pr_toggle_layout() {

	if (!self.pr_horiz)
		pr_fill_table(true);
	else
		pr_fill_table(false);
  
}



//vertical mode
self.vertHeight = 0;
var ImgWidth  = 0;

function pr_content(image_url){
  
	if (self.vertHeight == 0) {
		if(document.selection  && !is_gecko)
			self.vertHeight=Math.ceil(document.body.clientHeight*0.4);
		else
			self.vertHeight=Math.ceil(window.innerHeight*0.4);
	}
	var s = "<div style=\"overflow: auto; height: " + self.vertHeight + "px; width: 100%;\">";
	s = s + "<img id=\"ProofReadImage\" src=\""+ image_url +"\" alt=\""+ image_url +"\"";
	s = s + " width=\"" + ImgWidth +"\"></div>";		
	return s;
}


function pr_zoom(value) {

	if(!document.getElementById("ImageContainer")) return;
	
	var PrImage = document.getElementById("ProofReadImage");
 
	if (value == 0) 
		PrImage.width = document.getElementById("ImageContainer").offsetWidth-20;
	else 
		PrImage.width = PrImage.width + value;
 
	ImgWidth = PrImage.width;
 
	if(document.selection  && !is_gecko) {
		//IE: 
		document.getElementById("ImageContainer").innerHTML = pr_content(PrImage.src);
	}
} 





function  pr_fill_table(horizontal_layout){

	//remove existing body  
	if(self.table.firstChild){
		self.table.removeChild(self.table.firstChild);
	}

	//create table body
	var t_body = document.createElement("tbody");
	self.table.appendChild(t_body);
	var cell_left  = document.createElement("td");
	var cell_right = document.createElement("td");
  
	if(!proofreadPageIsEdit) horizontal_layout=false;

	//first setup the layout
	if(!horizontal_layout) {
		var t_row = document.createElement("tr");
		t_row.setAttribute("valign","top");
		cell_left.style.cssText = "width:50%; padding-right:0.5em;";
		cell_right.setAttribute("rowspan","3");
		t_row.appendChild(cell_left);
		t_row.appendChild(cell_right);
		t_body.appendChild(t_row);
	}
	else {
		var t_row1 = document.createElement("tr");
		var t_row2 = document.createElement("tr");
		t_body.appendChild(t_row2);	  
		t_body.appendChild(t_row1);	  
		t_row1.appendChild(cell_left);
		t_row2.appendChild(cell_right);
	}
	

	//create image and text containers
	var image_container = document.createElement("div");
	image_container.setAttribute("id", "ImageContainer");
	cell_right.appendChild(image_container);
	cell_left.appendChild(self.text_container);


	//fill the image container
	if(!horizontal_layout){

		self.pr_horiz = false;
		var displayWidth = 400;
		if (parseInt(navigator.appVersion)>3) {
			if (navigator.appName.indexOf("Microsoft")!=-1) {
				displayWidth = parseInt(document.body.offsetWidth/2-70);
			}
			else {
				displayWidth = parseInt(window.innerWidth/2-70);
			}
		}
		//this function sets self.DisplayHeight
		var image_url = pr_image_url(displayWidth); 
		
		if(self.DisplayHeight) 
			self.TextBoxHeight = DisplayHeight;
		else 
			self.TextBoxHeight = 700;

		//fill image container	
		if(!proofreadPageIsEdit) {
			var image = document.createElement("img");
			image.setAttribute("src", image_url); 
			image.style.cssText = "padding:0;margin:0;border:0;";
			image_container.appendChild(image);
		}
		else{
			var image_url = proofreadPageViewURL;
			var s = "<div style=\"overflow: auto; width: 100%; height:"+self.DisplayHeight+"px;\">";
			s = s + "<img id=\"ProofReadImage\" src=\""+ image_url +"\" alt=\""+ image_url +"\"";
			s = s + " width=\"" + displayWidth +"\"></div>";
			image_container.innerHTML = s;
			document.getElementById("wpTextbox1").style.cssText = "height:"+(self.TextBoxHeight-7)+"px";
			pr_zoom(0);
		}
		//document.getElementById("contentSub").appendChild(ImageContainer);
		
	}
	else{
		self.pr_horiz = true;
		image_container.innerHTML = pr_content(proofreadPageViewURL);
		
		if(proofreadPageIsEdit){
			document.getElementById("wpTextbox1").style.cssText = "height:"+self.vertHeight+"px";
			pr_zoom(0);
		}
	}
}







function pr_setup() {

	self.table = document.createElement("table");
	self.text_container = document.createElement("div");
	self.image_container = document.createElement("div");
	table.setAttribute("id", "textBoxTable");
	table.style.cssText = "width:100%;";

	//fill table
    if(self.proofreadpage_default_layout=='horizontal') 
		pr_fill_table(true);
	else
		pr_fill_table(false);

	//insert the image    
	if(proofreadPageIsEdit) {
		var text = document.getElementById("wpTextbox1"); 
	}
	else { 
		var text = document.getElementById("bodyContent"); 
	}
	if(!text) return;
	var f = text.parentNode; 
	var new_text = f.removeChild(text);

	if(proofreadPageIsEdit) {
		pr_make_edit_area(self.text_container,new_text.value);
		var copywarn = document.getElementById("editpage-copywarn");
		f.insertBefore(table,copywarn);
		
	}
	else {
		self.text_container.appendChild(new_text);
		f.appendChild(self.table);
	}
  
	//add buttons  
	if(proofreadPageIsEdit) {

		var toolbar = document.getElementById("toolbar");
		/*var f = tb.parentNode; 
		 var toolbar = f.removeChild(tb);
		 self.text_container.insertBefore(toolbar,self.text_container.firstChild);*/

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
			image.onclick = pr_toggle_visibility;
			toolbar.appendChild(image);
			
			var image3 = document.createElement("img");
			image3.width = 23;
			image3.height = 22;
			image3.border = 0;
			image3.className = "mw-toolbar-proofread";
			image3.style.cursor = "pointer";
			image3.alt = "-";
			image3.title = "zoom out";
			image3.src = wgScriptPath+"/extensions/ProofreadPage/Button_zoom_out.png";
			image3.onclick = new Function("pr_zoom(-50);");
			toolbar.appendChild(image3);
			
			var image4 = document.createElement("img");
			image4.width = 23;
			image4.height = 22;
			image4.border = 0;
			image4.className = "mw-toolbar-proofread";
			image4.style.cursor = "pointer";
			image4.alt = "-";
			image4.title = "reset zoom";
			image4.src = wgScriptPath+"/extensions/ProofreadPage/Button_examine.png";
			image4.onclick = new Function("pr_zoom(0);");
			toolbar.appendChild(image4);
			
			var image2 = document.createElement("img");
			image2.width = 23;
			image2.height = 22;
			image2.border = 0;
			image2.className = "mw-toolbar-proofread";
			image2.style.cursor = "pointer";
			image2.alt = "+";
			image2.title = "zoom in";
			image2.src = wgScriptPath+"/extensions/ProofreadPage/Button_zoom_in.png";
			image2.onclick = new Function("pr_zoom(50);");
			toolbar.appendChild(image2);
			
			var image1 = document.createElement("img");
			image1.width = 23;
			image1.height = 22;
			image1.className = "mw-toolbar-editbutton";
			image1.src = wgScriptPath+'/extensions/ProofreadPage/Button_multicol.png';
			image1.border = 0;
			image1.alt = " ";
			image1.title = "vertical/horizontal layout";
			image1.style.cursor = "pointer";
			image1.onclick = pr_toggle_layout;
			toolbar.appendChild(image1);

		}
	}
}




function pr_fill_form() {
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




function pr_init() {

	if( document.getElementById("proofreadImage")) return;

	if(document.URL.indexOf("action=protect") > 0 || document.URL.indexOf("action=unprotect") > 0) return;
	if(document.URL.indexOf("action=delete") > 0 || document.URL.indexOf("action=undelete") > 0) return;
	if(document.URL.indexOf("action=watch") > 0 || document.URL.indexOf("action=unwatch") > 0) return;
	if(document.URL.indexOf("action=history") > 0 ) return;

	/*check if external url is provided*/				       
	if(!self.proofreadPageViewURL) {
		var text = document.getElementById("wpTextbox1"); 
		if (text) {
			var proofreadPageIsEdit = true;
			re = /<span class="hiddenStructure" id="pageURL">\[http:\/\/(.*?)\]<\/span>/;
			m = re.exec(text.value);
			if( m ) { 
				self.proofreadPageExternalURL = "http://"+m[1];  
			}
		} 
		else {
			var proofreadPageIsEdit = false;
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

	if( self.proofreadpage_setup ) {
	  
	    proofreadpage_setup(
		proofreadPageWidth,
		proofreadPageHeight, 
		proofreadPageIsEdit);

	}
	else pr_setup();
}



addOnloadHook(pr_init);
addOnloadHook(pr_init_tabs);


function pr_initzoom(){
	if(document.getElementById("wpTextbox1")){
		if(self.pr_horiz)
			document.getElementById("wpTextbox1").style.cssText = "height:"+self.vertHeight+"px";
		else
			document.getElementById("wpTextbox1").style.cssText = "height:"+(self.TextBoxHeight-7)+"px";
		pr_zoom(0);
	}
}
hookEvent("load", pr_initzoom );


/*Quality buttons*/

function pr_add_quality(form,value){
 
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


function pr_add_quality_buttons(){

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
' <span class="quality2"> <input type="radio" name="quality" onclick="pr_add_quality(this.form,2)"> </span>'
+'<span class="quality1"> <input type="radio" name="quality" onclick="pr_add_quality(this.form,1)"> </span>'
+'<span class="quality3"> <input type="radio" name="quality" onclick="pr_add_quality(this.form,3)"> </span>';
	if(show4) f.innerHTML = f.innerHTML 
+ '<span class="quality4"> <input type="radio" name="quality" onclick="pr_add_quality(this.form,4)"> </span>';
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

 

addOnloadHook(pr_add_quality_buttons);
