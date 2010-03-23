/**
 * Javascript that allows the "page preview" to be displayed on the form page
 *
 * @author Stephan Gambke
 * based on http://en.wikipedia.org/wiki/User:Js/ajaxPreview, created by
 * Alex Smotrov
 */
var wkPreview;
var interval;

function ajaxFormPreviewInit(){
 
    if ((wgNamespaceNumber % 2 == 0) && /\.(js|css)$/.test(wgTitle)) return;
 
    if(!document.getElementById('wikiPreview')) return;
 
    var btnOld = document.getElementById('wpPreview');
    if (!btnOld || !document.getElementById('wikiPreview')) return;  // need preview-button and preview-placeholder
 
    var btn = document.createElement('input');
    btn.type = 'button';
    btn.onclick = ajaxFormPreviewClick;
    btn.id = btnOld.id;
    btn.name = btnOld.name;
    btn.value = btnOld.value;
    btn.title = btnOld.title;
 
    btn.value2 = btn.value;
 
    btn.accessKey = btnOld.accessKey;
 
    btnOld.parentNode.replaceChild(btn, btnOld);
}
 
function ajaxFormPreviewClick(){ajaxFormPreviewRun(this)}
 
function ajaxFormPreviewRun(btn){
 
    wkPreview = document.getElementById('wikiPreview');
    var form = document.createbox;
    var aj = sajax_init_object();
    var aj2 = sajax_init_object();
 
    // remove old error messages
    var el = document.getElementById("form_error_header");
    if (el) el.parentNode.removeChild(el);
 
    var elts = document.body.getElementsByTagName("span");
 
    for (var i = 0; i < elts.length; ++i)
	if (elts[i].className == 'errorMessage') elts[i].innerHTML = '';
 
    if (!wkPreview || !form || !aj || !aj2 || !validate_all() ) return;
 
    var frag=document.createElement("div");
 
    var htm;
 
    // gray out old preview
    wkPreview.style.opacity = '0.3';
    wkPreview.style.color = 'gray';
 
    document.body.style.cursor = 'wait';
  
    //prepare
    var action = document.URL;
    if (wgAction=='formedit') action += '&live';
 
    var boundary = '--------123xyz';
    var data = '';
 
    //FCKeditor visible? update free text first
    // if (!oFCKeditor.ready) return false;    //sajax_do_call in action - what do we do?
    if ( typeof FCKeditorAPI != "undefined" )
	if ( showFCKEditor & RTE_VISIBLE ) {
	    
	    var SRCtextarea = document.getElementById( 'free_text' );
	    
	    if ( SRCtextarea ) {
		
		var oEditorIns = FCKeditorAPI.GetInstance( 'free_text' );
		SRCtextarea.value = oEditorIns.GetData( oEditorIns.Config.FormatSource );
		
	    }
	    
	}
 
    elts = form.elements;
 
    for (i=0; i < elts.length; ++i) {
	if (elts[i].name && elts[i].name != '' && !elts[i].disabled &&
	    ((elts[i].type!='submit' && elts[i].type!='radio' && elts[i].type!='checkbox') || elts[i].checked)) {
	    addData (elts[i].name, elts[i].value);
	}
    }

    btn.style.width = Math.max(btn.scrollWidth, btn.offsetWidth) + 'px';
    btn.value = '...';
    btn.disabled='1';
 
    //send
 
    aj.open('POST', action, true);
    aj.setRequestHeader('Content-Type', 'multipart/form-data; boundary='+boundary);
    aj.send(data + '--' + boundary);
    aj.onreadystatechange = function(){
 
	if (aj.readyState != 4) return;
 
	// Got Wikitext. Now fetch HTML...
	
	frag.innerHTML = aj.responseText;
 
        if (!frag.getElementsByTagName("form")["editform"]) {
	    wkPreview.innerHTML = aj.responseText;
        }

	//alert(aj.responseText);
	action = frag.getElementsByTagName("form")["editform"].action;

	data = '';

	elts = frag.getElementsByTagName("form")["editform"].elements;

	for (i=0; i < elts.length; ++i)
	    if (elts[i].name && elts[i].name != '') addData (elts[i].name, elts[i].value);

	aj2.open('POST', action, true);
	aj2.setRequestHeader('Content-Type', 'multipart/form-data; boundary='+boundary);
	aj2.send(data + '--' + boundary);
	aj2.onreadystatechange = function(){

	    if (aj2.readyState != 4) return;

	    htm = aj2.responseText.replace(/&gt;/g,'>').replace(/&lt;/g,'<').replace(/&quot;/g,'"').replace(/&amp;/g,'&').replace(/&apos;/g,"'");

	    ifr = document.createElement('iframe');
	    ifr.onload="alert('load')";
	    wkPreview.innerHTML = '';

	    ifr.id="ifrPreview";
	    ifr.style.width="100%";
	    ifr.style.height="0";

	    ifr.style.margin="0px";
	    ifr.style.padding="0px";
	    ifr.style.border="0px";
	    ifr.border="0";
	    ifr.frameBorder="0";

	    wkPreview.appendChild(ifr);

	    var doc = null;

	    if (ifr.contentDocument)
		doc = ifr.contentDocument;

	    else if (ifr.contentWindow)
		doc = ifr.contentWindow.document;

	    else doc = ifr.Document;

	    doc.open();
	    doc.write(htm);
	    doc.close();        
 
	    interval=setInterval(function(){

		    var visible = null;

		    visible = doc.getElementById("wikiPreview");

                    if (!visible) return;

                    clearInterval(interval);

		    var currentfr=document.getElementById('ifrPreview');

		    if (currentfr && !window.opera){

			if (currentfr.contentDocument) { //ns6 syntax
			    doc = currentfr.contentDocument; 
			} else if (currentfr.Document && currentfr.Document.body.scrollHeight) { //ie5+ syntax
			    doc = currentfr.Document;
			}

			ifr.style.display="block";
			vish = visible.clientHeight;

			while (visible.tagName.toLowerCase() != "body") {

			    visible.style.width="100%";
			    visible.style.height= " " + vish + "px";
			    visible.style.margin="0px";
			    visible.style.padding="0px";
			    visible.style.border="0px";

			    pv = visible;
			    
			    while(pv.previousSibling) {
				pv = pv.previousSibling;
				if (pv.style) pv.style.display="none";
			    }

			    pv = visible;
				
			    while(pv.nextSibling) {
				pv = pv.nextSibling;
				if (pv.style) pv.style.display="none";
			    }

			    visible = visible.parentNode;
			}
			
			currentfr.style.height = " " + doc.body.scrollHeight + "px";

			window.scrollTo(currentfr.offsetLeft, currentfr.offsetTop);
			document.body.style.cursor = '';

			btn = document.getElementById('wpPreview');
			btn.value = btn.value2;
			btn.disabled='';
			btn.blur();

		    }
		},100);
	    
	    wkPreview.style.opacity = '';
	    wkPreview.style.color = '';
	    wkPreview.style.display='block';

	} // aj2.onreadystatechange = function(){

    } // aj.onreadystatechange = function(){

    function addData(name, value){
	if (!value) value = form[name] ? form[name].value : ''
			data += '--' + boundary + '\nContent-Disposition: form-data; name="'+name+'"\n\n' + value + '\n';
    }
}

if (wgAction=='formedit' || wgCanonicalSpecialPageName == 'FormEdit')
    addOnloadHook(ajaxFormPreviewInit);
