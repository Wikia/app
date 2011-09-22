/* 
 * 
 * @preserve Copyright(c) 2010-2011 Digital Fulrcum, LLC 
 * (http://digital-fulcrum.com). All rights reserved.
 * License: See license.txt or http://digital-fulcrum.com/ghostwriter-license/ 
 * GhostWriter: http://digital-fulcrum.com/ghostwriter-complete-control
 * Release: 11.6.7 
 */
(function(){ 
ghostwriter['addbubbles']= addbubbles; 
var 
	 W= window 
	,A=false
	,D= document
	,START 
	,HEAD= D.getElementsByTagName("HEAD")[0]
	,CSS= "css/bubbles.css"
	,BODY= D.body
	,total= 0
	,obj= W.gwtimers= {}
	,c= null
	,SS= (function(){ 
		var $= D.createElement("STYLE"),rule= 
			"#gwm-bubbles .gwm-bubble{ display: block; }",
			rules
		;
		$.setAttribute("type","text/css"); 
		if($.styleSheet)
			$.styleSheet.cssText= rule; 
		else 
			$.appendChild(D.createTextNode(rule)); 
		HEAD.appendChild($); 
		rules= $.sheet ? $.sheet.cssRules : ($.styleSheet ? $.styleSheet.rules : [{style:{}}]); 
		return rules[0]; 
	})()
	,PCTFN= function(e,f){
		a(); 
		function a(){ 
			var p= e.PercentLoaded ? e.PercentLoaded() : 0;
			if(p!= 100){ 
				setTimeout(a, 50);
			}else 
				f(); 
		}
	}
	,COLLECT= {"IMG":true,"EMBED":PCTFN,"IFRAME":true}
;
/*@cc_on COLLECT["LINK"]= COLLECT["OBJECT"]= true; delete COLLECT["EMBED"]@*/
ghostwriter.handlers= { 
startscript: onstart, 
finishscript: onfinish,
begin: function(o){ 
	START= START || W.START || Number(new Date); 
	if(!o.id) return; 
	total= Number(new Date);
	obj[o.id]= c= []; 
	c.__start__= total; 
}, 
end: function(o){ 
	if(!c) return; 
	c.__total__= (Number(new Date) - total)
	c= null; 
},
onelement: function(el){ 
	if(!c || !COLLECT[el.tagName]) return; 
	var o= c[c.length-1],src,h,d,f;
	if(!o) return; 
	src= el.src || el.movie || el.data || el.href;
	if(!src) return; 
	h= o.children= o.children || [];
	d= h[h.length]= {src: src, time: -1, tag: el.tagName, start: Number(new Date)};
	f= (function(obj,cb){ 
		return function(event){
			if(
				this.readyState && 
				this.readyState != 'complete' && 
				this.readyState != 'loaded'
			)
				return 

			obj.time= Number(new Date) - obj.start; 

			this.onload= this.onreadystatechange= null 
			if(typeof cb == 'function') 
				cb.call(this,event)

		}
	})(d, el.onload||el.onreadystatechange); 

	if(typeof COLLECT[el.tagName] == 'function') 
		return COLLECT[el.tagName](el,f);	
	else
		el.onload= el.onreadystatechange= f
	
}
}

function onstart(script){ 
	if(!c || !script.src) return; 
	c[c.length]= { 
		 src: script.src
		,start: Number(new Date)
		,time: -1
	}; 
	if(!A) addload(); 
}
function onfinish(script){ 
	var o= c && c[c.length-1]
	if(!o || !script.src)return; 
	flog("registering end time for " + script.src )
	o.time= Number(new Date) - o.start; 
	return 
}
function addload(){ 
	A=true; 
	if(W.attachEvent) W.attachEvent("onload", addbubbles);
	else W.addEventListener("load",addbubbles, false); 
}

function addbubbles(){
	var 
		_main= D.createElement("DIV")
		,ss= D.createElement("LINK")
		,topcount= 0
	; 
	ss.href= CSS
	ss.rel= "stylesheet"
	ss.type="text/css"
	BODY.appendChild(ss)
	_main.id= "gwm-bubbles"
	
	for (var id in obj){
		if(obj[id].length <= 0) continue; 
		var 
			b= D.createElement("DIV"),
			bc= D.createElement("SPAN"),
			ba= D.createElement("SPAN"),

			start= Math.round( (obj[id].__start__ - START) / 10 ) / 100,
			end= Math.round( (obj[id].__start__ + obj[id].__total__ - START) / 10 ) / 100,

			text= [ 
				start, " - ", end, "s"
			].join(""),
			el= D.getElementById(id),
			pos= el.parentNode === HEAD ? [0,0] : getposition(el),
			top= pos[0], left= pos[1]
		; 
		b.className= "gwm-bubble"; 
		bc.className= "gwm-bubble"; 
		ba.className= "gwm-arrow"; 
		bc.innerHTML= text; 
		b.appendChild(bc); 
		b.appendChild(ba); 

		obj[id].__id__= id; 
		if(top == 0) 
			ba.className+= " gwm-arrow-up"; 

		top -= 22; 	
		left += 15; 
		top= top > 12 ? top : ( 12 + (topcount++ * 50)) ; 
		b.style.top= top + "px"; 


		left= left > 0 ? left : 1; 
		b.style.left= left + "px";  

		_main.appendChild(b); 
		bc.onclick= showdetails(b,obj[id]);
	}
	BODY.appendChild(_main); 
}
window.gp= getposition;
function getposition($,r){ 
	var top=0,left=0,o= $,e;
	r= r==null ? false : r; 
	while($) { 
		if(
			$.nodeType == 1 && 
			$.offsetTop && 
			$.style && 
			$.style.position != "absolute" && 
			$.offsetHeight > 0  && $.offsetParent

		){ 
			e= $.firstChild; 
			do { 
				top+= $.offsetTop; 
				left += $.offsetLeft; 
			}while($= $.offsetParent); 
			break;
		}
		$=$.nextSibling;
	}
	while(!r && e){
		var _= getposition(e,true); 
		if(_[0] > 0 && _[0] < top){ 
			top= _[0]; left= _[1]; 
			break; 
		}
		e= e.nextSibling; 
	}
	if(top === 0 && !r)  
		flog("got back position 0 for " + o.parentNode.childNodes.length); 
	return [ top, left ]; 
}
	
	
function showdetails(bubble,breakdown){ 
return (function(el,list){ 	
	var table= null; 
	return show; 
	function show(){ 
		if(!SS) makecss(); 
		el.className += " gwm-hover"; 
		table= table || build(list);  
		el.appendChild(table); 
		SS.style.display= "none"; 
		this.onclick= hide;  
	}
	function hide(){ 
		el.className= el.className.split(/\s+/)[0]; 
		el.removeChild(table); 
		SS.style.display= "block"; 
		this.onclick= show; 
	}
})(bubble, breakdown); 
}
function build(obj){ 
	var table= builddetails(obj); 
	return table; 
}
function buildsummary(obj){ 
}
function builddetails(obj){ 
	var 
		t= D.createElement("TABLE"),
		tb= D.createElement("TBODY"),
		th= D.createElement("Tr"),
		th2= D.createElement("Td"),
		th3= D.createElement("Td"),
		th4= D.createElement("Td"),
		sumtr= D.createElement("TR"),
		sumtd1= D.createElement("TD"),
		sumtd2= D.createElement("TD")
	; 
	t.className="gwm-details";
	sumtr.className="summary"; 
	t.cellSpacing= t.cellPadding= 0; 

	t.appendChild(tb); 
	th.className="header";
	th2.colSpan= '2'; 
	th2.innerHTML= "Object List for SCRIPT#" + obj.__id__; 
	th3.innerHTML= "start<br/>offset<br/>(s)"; 
	th4.innerHTML= "load<br/>time<br/>(ms)"; 
	th.appendChild(th2); 
	th.appendChild(th3); 
	th.appendChild(th4); 
	tb.appendChild(th); 


	for(var i=0, l= obj.length; i < l; i ++){ 
		var 
			row= obj[i]
			,tr= buildrow(row)
			,c= (i+1) % 2 == 0 ? "even" : "odd"
			,h= row.children
		;
		tr.className= c;  
		tb.appendChild(tr); 
		if(!h) continue; 
		for(var j=0,m=h.length;j<m;j++){ 
			tr= buildrow(h[j]); 
			tr.className= c; 
			tb.appendChild(tr); 
		}

	}
	sumtd1.colSpan= 2;
	sumtd1.innerHTML= "LOAD TIME:";
	sumtd2.innerHTML= obj.__total__; 
	sumtr.appendChild(sumtd1); 
	sumtr.appendChild(sumtd2); 
	tb.appendChild(sumtr); 
	return t; 
}
function buildrow(row){ 
	var 
			tr= D.createElement("TR"), 
			tn= row.tag || "SCRIPT",
			urlcell= D.createElement("TD"),
			timecell= D.createElement("TD"),
			link= D.createElement("A"),
			tagcell= D.createElement("TD"),
			offsetcell= D.createElement("TD"),
			shorturl, 
			url= row.src, 
			offset= Math.round( (row.start - START) / 10 ) / 100, 
			time= row.time //>= 0 ? row.time : "..." 
		; 

		link.href=link.title= url; 
		link.target= "_new";
		if(url.length > 60) { 
			shorturl= [
				url.substr(0,30), 
				url.substring(
					url.length - 30, url.length -1
				)
			].join ("..."); 
		}else
			shorturl= url; 

		link.innerHTML= shorturl;
		offsetcell.innerHTML= "+" + offset 
		urlcell.appendChild(link); 
		timecell.innerHTML= time; 
		tagcell.innerHTML= tn; 

		tr.appendChild(tagcell); 
		tr.appendChild(urlcell); 
		tr.appendChild(offsetcell); 
		tr.appendChild(timecell); 
	return tr; 
}
})(); 

