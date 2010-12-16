// Author : ThomasV - License : GPL


function pr_init_tabs(){
	var a = document.getElementById("p-namespaces");
	if(!a) a = document.getElementById("p-cactions");

	if (!a) return;
	var b = a.getElementsByTagName("ul");
	if (!b) return;

	if(self.proofreadPageViewURL) {
		b[0].innerHTML = b[0].innerHTML 
			+ '<li id="ca-image">'
			+ '<a href="' + escapeQuotesHTML(proofreadPageViewURL) + '"><span>'
			+ escapeQuotesHTML(proofreadPageMessageImage) + '</span></a></li>';
	}

	if(self.proofreadPageIndexURL){
		b[0].innerHTML = b[0].innerHTML 
			+ '<li id="ca-index">'
			+ '<a href="' + escapeQuotesHTML(proofreadPageIndexURL) 
			+ '" title="' + escapeQuotesHTML(proofreadPageMessageIndex) + '"><span>'
			+ '<img src="' + wgScriptPath + '/extensions/ProofreadPage/uparrow.png" alt="'
			+ escapeQuotesHTML(proofreadPageMessageIndex) 
			+ '" width="15" height="15" /></span></a></li>';
	}

	if(self.proofreadPageNextURL){
		b[0].innerHTML = 
			'<li id="ca-next">'
			+ '<a href="' + escapeQuotesHTML(self.proofreadPageNextURL)
			+ '" title="' + escapeQuotesHTML(proofreadPageMessageNextPage) + '"><span>'
			+ '<img src="' + wgScriptPath + '/extensions/ProofreadPage/rightarrow.png" alt="'
			+ escapeQuotesHTML(proofreadPageMessageNextPage) 
			+ '" width="15" height="15" /></span></a></li>'
			+ b[0].innerHTML ;
	}

	if(self.proofreadPagePrevURL){
		b[0].innerHTML = 
			'<li id="ca-prev">'
			+ '<a href="' + escapeQuotesHTML(self.proofreadPagePrevURL) 
			+ '" title="' + escapeQuotesHTML(proofreadPageMessagePrevPage) + '"><span>'
			+ '<img src="' + wgScriptPath + '/extensions/ProofreadPage/leftarrow.png" alt="'
			+ escapeQuotesHTML(proofreadPageMessagePrevPage) 
			+ '" width="15" height="15" /></span></a></li>'
			+ b[0].innerHTML ;
       }
}




function pr_image_url(requested_width){
	var thumb_url;

	if(self.proofreadPageExternalURL) {
		thumb_url = proofreadPageViewURL;
		self.DisplayWidth = requested_width;
		self.DisplayHeight = "";
	}
	else {
		//enforce quantization: width must be multiple of 100px
		var width = (100*requested_width)/100;
		//compare to the width of the image
		if(width < proofreadPageWidth)  {
			thumb_url = proofreadPageThumbURL.replace('##WIDTH##',""+width); 
			self.DisplayWidth = requested_width;
			self.DisplayHeight = requested_width*proofreadPageHeight/proofreadPageWidth;
		}
		else {
			thumb_url = proofreadPageViewURL; 
			self.DisplayWidth = proofreadPageWidth;
			self.DisplayHeight = proofreadPageHeight;
		}
	}
	return thumb_url;
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
			pageHeader = proofreadPageHeader;
			pageBody = text;
			pageFooter = proofreadPageFooter;
			document.editform.elements["wpSummary"].value="/* "+proofreadPageMessageQuality1+" */ ";
		}
	}

	//find the PageQuality template
	//we do this separately from header detection,
	//because the template might not be in the header 
	var reg = /<pagequality level=\"(0|1|2|3|4)\" user=\"(.*?)\" \/>/g;
	var m4 = reg.exec(pageHeader);
	var old_reg = /\{\{PageQuality\|(0|1|2|3|4)(\|(.*?|))\}\}/g;
	var old_m4 = old_reg.exec(pageHeader);
	if( m4 ) {
		switch( m4[1] ) {
			case "0": self.proofreadpage_quality = 0; break;
			case "1": self.proofreadpage_quality = 1; break;
			case "2": self.proofreadpage_quality = 2; break;
			case "3": self.proofreadpage_quality = 3; break;
			case "4": self.proofreadpage_quality = 4; break;
			default: self.proofreadpage_quality = 1;
		}
		self.proofreadpage_username = m4[2];
		pageHeader = pageHeader.replace(reg,'');
	}
	else if (old_m4 ) {
		switch( old_m4[1] ) {
			case "0": self.proofreadpage_quality = 0; break;
			case "1": self.proofreadpage_quality = 1; break;
			case "2": self.proofreadpage_quality = 2; break;
			case "3": self.proofreadpage_quality = 3; break;
			case "4": self.proofreadpage_quality = 4; break;
			default: self.proofreadpage_quality = 1;
		}
		self.proofreadpage_username = old_m4[3];
		pageHeader = pageHeader.replace(old_reg,'');
	}
	else {
		 self.proofreadpage_quality = 1;
		 self.proofreadpage_username = "";
	}

	//escape & character
	pageBody = pageBody.split("&").join("&amp;")
	pageHeader = pageHeader.split("&").join("&amp;")
	pageFooter = pageFooter.split("&").join("&amp;")

	container.innerHTML = ''
		+ '<div id="prp_header" style="display:none;">'
		+ '<span style="color:gray;font-size:80%;line-height:100%;">'
		+ escapeQuotesHTML(proofreadPageMessageHeader) + '</span>'
		+ '<textarea name="wpHeaderTextbox" rows="2" cols="80" tabindex=1>' + pageHeader + '</textarea><br/>'
		+ '<span style="color:gray;font-size:80%;line-height:100%;">'
		+ escapeQuotesHTML(proofreadPageMessagePageBody) + '</span></div>'
		+ '<textarea name="wpTextbox1" id="wpTextbox1" tabindex=1 style="height:' + ( self.DisplayHeight - 6 ) + 'px;">' + pageBody + '</textarea>'
		+ '<div id="prp_footer" style="display:none;">'
		+ '<span style="color:gray;font-size:80%;line-height:100%;">'
		+ escapeQuotesHTML(proofreadPageMessageFooter) + '</span><br/>'
		+ '<textarea name="wpFooterTextbox" rows="2" cols="80" tabindex=1>'+pageFooter+'</textarea></div>';


}


function pr_reset_size() {

	var box = document.getElementById("wpTextbox1");
	var h = document.getElementById("prp_header"); 
	var f = document.getElementById("prp_footer"); 
	if( h.style.cssText == 'display:none;') {
		box.style.cssText = "height:" + ( self.DisplayHeight - 6 ) + "px";
	} else {
		if( self.pr_horiz ) {
			box.style.cssText = "height:" + ( self.DisplayHeight - 6 ) + "px";
		} else {
			box.style.cssText = "height:" + ( self.DisplayHeight - 6 - h.offsetHeight - f.offsetHeight) + "px";
		}
	}
}

function pr_toggle_visibility() {

	var box = document.getElementById("wpTextbox1");
	var h = document.getElementById("prp_header"); 
	var f = document.getElementById("prp_footer"); 
	if( h.style.cssText == ''){
		h.style.cssText = 'display:none';
		f.style.cssText = 'display:none';
	} else {
		h.style.cssText = '';
		f.style.cssText = '';
	}
	pr_reset_size();
}

function pr_toggle_layout() {

	self.pr_horiz = ! self.pr_horiz;
	pr_fill_table();
	pr_reset_size();
	pr_zoom(0);
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
var zoomamount=2; 
var zoom_status=''; 

var ieox=0; var ieoy=0; 
var ffox=0; var ffoy=0;



/*relative coordinates of the mouse pointer*/
function get_xy(evt){

	if(typeof(evt) == 'object') {
		evt = evt?evt:window.event?window.event:null; if(!evt){ return false;}
		if(evt.pageX) {
			xx=evt.pageX - ffox;
			yy=evt.pageY - ffoy;
		}
		else {
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
    
}

//mouse move
function zoom_move(evt) {

	if(zoom_status != 1) { return false;}
	evt = evt?evt:window.event?window.event:null; if(!evt){ return false;}
	get_xy(evt);
	zp_clip.style.margin =  ((yy > objh )?(objh*(1-zoomamount_h)):(yy*(1-zoomamount_h))) + 'px 0px 0px '
		+ ((xx > objw )?(objw*(1-zoomamount_w)):(xx*(1-zoomamount_w))) + 'px';
	return false;
}






function zoom_off() {
	zp_container.style.width='0px';
	zp_container.style.height='0px';
	zoom_status = 0;
}




function countoffset() {
	zme=document.getElementById("pr_container");
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

	evt = evt?evt:window.event?window.event:null; if(!evt){ return false;}

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

	zp_container.style.width = objw+'px';
	zp_container.style.height = objh+'px';
	zp_clip.style.margin =  ((lastyy > objh )?(objh*(1-zoomamount_h)):(lastyy*(1-zoomamount_h))) + 'px 0px 0px '
		+ ((lastxx > objw )?(objw*(1-zoomamount_w)):(lastxx*(1-zoomamount_w))) + 'px';

	return false;
}


//zoom using two images (magnification glass)
function pr_initzoom(){
	if(proofreadPageIsEdit) return;
	if(!self.proofreadPageViewURL) return;
	if(self.DisplayWidth>800) return;

	zp = document.getElementById("pr_container");
	if(zp){
		var hires_url = pr_image_url(800);
		self.objw = zp.firstChild.width;
		self.objh = zp.firstChild.height;

		zp.onmouseup = zoom_mouseup;
		zp.onmousemove =  zoom_move;
		zp_container = document.createElement("div");
		zp_container.style.cssText ="position:absolute; width:0; height:0; overflow:hidden;";
		zp_clip = document.createElement("img");
		zp_clip.setAttribute("src", hires_url);
		zp_clip.style.cssText = "padding:0;margin:0;border:0;";
		zp_container.appendChild(zp_clip);
		zp.insertBefore(zp_container,zp.firstChild); 

	}
}



/********************************
 * new zoom : mouse wheel
 * 
 ********************************/

var init_x = 0;
var init_y = 0;
var is_drag = false;
var is_zoom = false;
var pr_container = false;
var pr_rect = false;

/* size of the window */
var pr_width = 0, pr_height = 0;

function set_container_css(show_scrollbars,default_cursor){
	if(show_scrollbars) {
		self.container_css = self.container_css.replace("overflow:hidden","overflow:auto");
	} else {
		self.container_css = self.container_css.replace("overflow:auto","overflow:hidden");
	}
	if(default_cursor) {
		self.container_css = self.container_css.replace("cursor:crosshair","cursor:default");
	} else {
		self.container_css = self.container_css.replace("cursor:default","cursor:crosshair");
	}
	sl = pr_container.scrollLeft;//save scrollbar value for Opera, Chrome
	st = pr_container.scrollTop;
	pr_container.style.cssText = self.container_css;
	pr_container.scrollLeft = sl;
	pr_container.scrollTop = st;
}

function pr_drop(evt){
	evt = evt?evt:window.event?window.event:null; if(!evt){ return false;}
	get_xy(evt); if(xx>pr_container.offsetWidth-20 || yy>pr_container.offsetHeight-20) return false;

	document.onmouseup = null;
	document.onmousemove = null;
	document.onmousedown = null;
	pr_container.onmousemove = pr_move;
	if( is_drag==false ) {
		is_zoom = !is_zoom;
	} else {
		if(is_zoom) {
			is_zoom=false;
			if(boxWidth*boxWidth+boxHeight*boxHeight >= 2500){
				var zp_img = document.getElementById("ProofReadImage");
				ratio_x = Math.abs( pr_container.offsetWidth/self.boxWidth );
				zp_img.width = zp_img.width*ratio_x;
				pr_container.scrollLeft = (pr_container.scrollLeft + xMin)*ratio_x;
				pr_container.scrollTop =  (pr_container.scrollTop  + yMin)*ratio_x;
			}
		}
	}
	is_drag = false;
	pr_rect.style.cssText = "display:none";
	set_container_css(!is_zoom,!is_zoom);
	return false;
}

function pr_grab(evt){

	evt = evt?evt:window.event?window.event:null; if(!evt){ return false;}
	get_xy(evt); if(xx>pr_container.offsetWidth-20 || yy>pr_container.offsetHeight-20) return false;

	//only left button; see http://unixpapa.com/js/mouse.html for why it is this complicated
	if(evt.which == null) {
		if(evt.button != 1) return false;
	} else {
		if(evt.which > 1) return false;
	}

	document.onmousedown = function(){return false;}; 
	document.onmousemove = pr_drag;
	document.onmouseup = pr_drop;
	pr_container.onmousemove = pr_drag;

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
	
	init_x = pr_container.scrollLeft + lastxx;
	init_y = pr_container.scrollTop + lastyy;
	is_drag = false;
	set_container_css(!is_zoom,!is_zoom);
	return false;

}


function pr_move(evt) {
	evt = evt?evt:window.event?window.event:null; if(!evt){ return false;}
	countoffset();
	get_xy(evt);
}

function pr_drag(evt) {
	evt = evt?evt:window.event?window.event:null; if(!evt){ return false;}
	get_xy(evt); if(xx>pr_container.offsetWidth-20 || yy>pr_container.offsetHeight-20) return false;

	if(!is_zoom) {
		pr_container.scrollLeft = (init_x-xx);
		pr_container.scrollTop  = (init_y-yy);
	} else {
		self.xMin = Math.min( init_x - pr_container.scrollLeft, xx );
		self.yMin = Math.min( init_y - pr_container.scrollTop , yy );
		self.xMax = Math.max( init_x - pr_container.scrollLeft, xx );
		self.yMax = Math.max( init_y - pr_container.scrollTop , yy );
		self.boxWidth  = Math.max( xMax-xMin, 1 );
		self.boxHeight = Math.max( yMax-yMin, 1 );
		if(boxWidth*boxWidth+boxHeight*boxHeight < 2500){
			pr_rect.style.cssText = "display:none;";
		} else {
			ratio = pr_container.offsetWidth/pr_container.offsetHeight;
			if(boxWidth/boxHeight < ratio ) {
				boxWidth = boxHeight*ratio;
				if(xx==xMin) xMin = init_x - pr_container.scrollLeft - boxWidth;
			} else {
				boxHeight = boxWidth/ratio;
				if(yy==yMin) yMin = init_y - pr_container.scrollTop - boxHeight;
			}
			pr_rect.style.cssText = "cursor:crosshair;opacity:0.5;position:absolute;left:"+ xMin +"px;top:"+ yMin +"px;width:"+boxWidth+"px;height:"+boxHeight+"px;background:#000000;";
		}
	}
	if (evt.preventDefault) evt.preventDefault();
	evt.returnValue = false;
	is_drag = true;
	return false;
}


function pr_zoom(delta){

	var zp_img = document.getElementById("ProofReadImage");
	if(!zp_img) return;
	
	if (delta == 0) {
		//reduce width by 20 pixels in order to prevent horizontal scrollbar from showing up
		zp_img.width = pr_container.offsetWidth-20;
		pr_container.style.cssText = self.container_css; //needed by IE6
	}
	else{
		var old_width = zp_img.width;
		var new_width = Math.round(zp_img.width*Math.pow(1.1,delta));
		var delta_w = new_width - old_width;
		if(delta_w==0) return;
		var s = (delta_w>0)?1:-1;

		var ptx = xx + pr_container.scrollLeft;
		var pty = yy + pr_container.scrollTop;
		
		for(var dw=s; dw != delta_w; dw=dw+s){
			zp_img.width = old_width + dw;//this adds 1 pixel
			pr_container.style.cssText = self.container_css; //needed by IE6
			if(xx){
				//magnification factor
				var lambda = (old_width+dw)/old_width;
				pr_container.scrollLeft = Math.round(lambda*ptx - xx);
				pr_container.scrollTop = Math.round(lambda*pty - yy);
			}
		}
	}
}

function pr_zoom_wheel(evt){
	evt = evt?evt:window.event?window.event:null; if(!evt){ return false;}
	var delta = 0;
	if (evt.wheelDelta) { 
		/* IE/Opera. */
		delta = evt.wheelDelta/120;
	}
	else if (evt.detail) {
		/** Mozilla case. */
		/** In Mozilla, sign of delta is different than in IE.
        	 * Also, delta is multiple of 3.
        	 */
		delta = -evt.detail/3;
	}
	if(is_zoom && delta) {
		//disable wheel zoom for IE6.
		if( (!self.proofreadpage_disable_wheelzoom) 
		    && ( navigator.appName.indexOf("Microsoft")==-1 || navigator.appVersion.indexOf("MSIE 6.")==-1) ) 
			pr_zoom(delta);
		if(evt.preventDefault) evt.preventDefault();
		evt.returnValue = false;
	}
}




/* fill table with textbox and image */
function  pr_fill_table(){

	//remove existing table
	while(self.table.firstChild){
		self.table.removeChild(self.table.firstChild);
	}

	//setup the layout
	if(!pr_horiz) {
		//use a table only here
		var t_table = document.createElement("table");
		var t_body = document.createElement("tbody");
		var cell_left  = document.createElement("td");
		var cell_right = document.createElement("td");
		t_table.appendChild(t_body);  

		var t_row = document.createElement("tr");
		t_row.setAttribute("valign","top");
		cell_left.style.cssText = "width:50%; padding-right:0.5em;vertical-align:top;";
		cell_right.setAttribute("rowspan","3");
		cell_right.style.cssText = "vertical-align:top;";
		t_row.appendChild(cell_left);
		t_row.appendChild(cell_right);
		t_body.appendChild(t_row);
		cell_right.appendChild(pr_container_parent);
		cell_left.appendChild(self.text_container);
		self.table.appendChild(t_table);
	} else {
		self.table.appendChild(self.text_container);
		form = document.getElementById("editform");
		tb = document.getElementById("toolbar");
		if(tb) tb.parentNode.insertBefore(pr_container_parent,tb);
		else form.parentNode.insertBefore(pr_container_parent,form);
	}
	
	if(proofreadPageIsEdit) { 
		if(!pr_horiz){
			self.DisplayHeight = Math.ceil(pr_height*0.85);
			self.DisplayWidth = parseInt(pr_width/2-70);
			css_wh = "width:"+self.DisplayWidth+"px; height:"+self.DisplayHeight+"px;";
			pr_container_parent.style.cssText="position:relative;width:"+self.DisplayWidth+"px;";
		} else {
			self.DisplayHeight = Math.ceil(pr_height*0.4);
			css_wh = "width:100%; height:"+self.DisplayHeight+"px;";
			pr_container_parent.style.cssText="position:relative;height:"+self.DisplayHeight+"px;";
		}
		self.container_css = "position:absolute;top:0px;cursor:default; background:#000000; overflow:auto; " + css_wh;
		pr_container.style.cssText = self.container_css;
	}
	pr_zoom(0);
}







function pr_setup() {

	self.pr_horiz = (self.proofreadpage_default_layout=='horizontal');
	if(!proofreadPageIsEdit) pr_horiz = false;

	self.table = document.createElement("div");
	self.text_container = document.createElement("div");

	pr_container = document.createElement("div");
	pr_container.setAttribute("id", "pr_container");

	self.pr_container_parent = document.createElement("div");
	pr_container_parent.appendChild(pr_container);

	//get the size of the window
	if( typeof( window.innerWidth ) == 'number' ) {
		//Non-IE
		pr_width = window.innerWidth;
		pr_height = window.innerHeight;
	} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		//IE 6+ in 'standards compliant mode'
		pr_width = document.documentElement.clientWidth;
		pr_height = document.documentElement.clientHeight;
	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		//IE 4 compatible
		pr_width = document.body.clientWidth;
		pr_height = document.body.clientHeight;
	}

	//fill the image container	
	if(!proofreadPageIsEdit) { 
		//this sets DisplayWidth and DisplayHeight
		var thumb_url = pr_image_url(parseInt(pr_width/2-70)); 
		var image = document.createElement("img");
		image.setAttribute("id", "ProofReadImage");
		image.setAttribute("src", thumb_url);
		image.setAttribute("width", self.DisplayWidth);
		image.style.cssText = "padding:0;margin:0;border:0;";
		pr_container.appendChild(image);
		pr_container.style.cssText = "overflow:hidden;width:"+self.DisplayWidth+"px;";
	} else {
		//prevent the container from being resized once the image is downloaded. 
		img_w = pr_horiz?0:parseInt(pr_width/2-70)-20;
		pr_container.innerHTML = "<img id=\"ProofReadImage\" src=\""
		    + escapeQuotesHTML(proofreadPageViewURL) 
		    + "\" width=\"" + img_w + "\" />";
		pr_container.onmousedown = pr_grab;
		pr_container.onmousemove = pr_move;
		if (pr_container.addEventListener)
			pr_container.addEventListener('DOMMouseScroll', pr_zoom_wheel, false);
		pr_container.onmousewheel = pr_zoom_wheel;//IE,Opera. 
	}

	table.setAttribute("id", "textBoxTable");
	table.style.cssText = "width:100%;";

	pr_fill_table();
	
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
		if (self.proofreadpage_show_headers){
			pr_toggle_visibility();
		}
	}
	else {
		self.text_container.appendChild(new_text);
		f.appendChild(self.table);
	}
  
	//add buttons  
	if(proofreadPageIsEdit) {

		var toolbar = document.getElementById("toolbar");

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
			
		var image3 = document.createElement("img");
		image3.width = 23;
		image3.height = 22;
		image3.border = 0;
		image3.className = "mw-toolbar-proofread";
		image3.style.cursor = "pointer";
		image3.alt = "-";
		image3.title = "zoom out";
		image3.src = wgScriptPath+"/extensions/ProofreadPage/Button_zoom_out.png";
		image3.onclick = new Function("xx=0;yy=0;pr_zoom(-2);");
			
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
			
		var image2 = document.createElement("img");
		image2.width = 23;
		image2.height = 22;
		image2.border = 0;
		image2.className = "mw-toolbar-proofread";
		image2.style.cursor = "pointer";
		image2.alt = "+";
		image2.title = "zoom in";
		image2.src = wgScriptPath+"/extensions/ProofreadPage/Button_zoom_in.png";
		image2.onclick = new Function("xx=0;yy=0;pr_zoom(2);");
			
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

		pr_rect = document.createElement("div");
		pr_container_parent.appendChild(pr_rect);

		if( (!toolbar) || (self.wgWikiEditorPreferences && self.wgWikiEditorPreferences["toolbar"] ) ) {
			toolbar = document.createElement("div");
			toolbar.style.cssText="position:absolute;";
			pr_container_parent.appendChild(toolbar);
		}
		toolbar.appendChild(image);
		toolbar.appendChild(image3);
		toolbar.appendChild(image4);
		toolbar.appendChild(image2);
		toolbar.appendChild(image1);
	}
}





function pr_init() {

	if( document.getElementById("pr_container")) return;

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
				self.proofreadPageViewURL = "http://"+m[1];  
				self.proofreadPageExternalURL = true;
			}
		} 
		else {
			var proofreadPageIsEdit = false;
			text = document.getElementById("bodyContent"); 
			try { 
				var a = document.getElementById("pageURL");
				var b = a.firstChild;
				self.proofreadPageViewURL = b.getAttribute("href");
				self.proofreadPageExternalURL = true;
			} catch(err){};
		}
		//set to dummy values, not used
		self.proofreadPageWidth = 400;
		self.proofreadPageHeight = 400;
	}

	if(!self.proofreadPageViewURL) return;

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


hookEvent("load", pr_initzoom );


/*Quality buttons*/

function pr_add_quality(form,value){
 
	self.proofreadpage_quality = value;
	self.proofreadpage_username = wgUserName;
	var text="";
	switch( value ) {
		case 0: text = proofreadPageMessageQuality0; break;
		case 1: text = proofreadPageMessageQuality1; break;
		case 2: text = proofreadPageMessageQuality2; break;
		case 3: text = proofreadPageMessageQuality3; break;
		case 4: text = proofreadPageMessageQuality4; break;
	}
	form.elements["wpSummary"].value="/* " + text + " */ ";
	form.elements["wpProofreader"].value=self.proofreadpage_username;

}


function pr_add_quality_buttons(){

	var ig  = document.getElementById("wpWatchthis");
	if(!wgUserName) ig = document.getElementById("wpSummary");
	if( !ig ) return;
	var f = document.createElement("span");
	f.innerHTML = 
' <input type="hidden" name="wpProofreader" value="'+self.proofreadpage_username+'">'
+'<span class="quality0"> <input type="radio" name="quality" value=0 onclick="pr_add_quality(this.form,0)" tabindex=4> </span>'
+'<span class="quality2"> <input type="radio" name="quality" value=2 onclick="pr_add_quality(this.form,2)" tabindex=4> </span>'
+'<span class="quality1"> <input type="radio" name="quality" value=1 onclick="pr_add_quality(this.form,1)" tabindex=4> </span>'
+'<span class="quality3"> <input type="radio" name="quality" value=3 onclick="pr_add_quality(this.form,3)" tabindex=4> </span>'
+'<span class="quality4"> <input type="radio" name="quality" value=4 onclick="pr_add_quality(this.form,4)" tabindex=4> </span>';
	f.innerHTML = f.innerHTML + '&nbsp;' + escapeQuotesHTML(proofreadPageMessageStatus);

	if(!wgUserName) f.style.cssText = 'display:none';
	ig.parentNode.insertBefore(f,ig.nextSibling.nextSibling.nextSibling);

	if( ! ( ( self.proofreadpage_quality == 4 ) || ( ( self.proofreadpage_quality == 3 ) && ( self.proofreadpage_username != wgUserName ) ) ) ) {
		document.editform.quality[4].parentNode.style.cssText = 'display:none';
		document.editform.quality[4].disabled = true;
	}
	switch( self.proofreadpage_quality ) {
		case 4: document.editform.quality[4].checked = true; break;
		case 3: document.editform.quality[3].checked = true; break;
		case 1: document.editform.quality[2].checked = true; break; 
		case 2: document.editform.quality[1].checked = true; break; 
		case 0: document.editform.quality[0].checked = true; break; 
	}
}

 

addOnloadHook(pr_add_quality_buttons);
