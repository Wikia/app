function test(){ 
	var 
		element= ghostwriter.domelement
		,domtree= ghostwriter.domtree
	;
	var tagCreator= new Y.Test.Case({ 
		name: "HTML Tag Creator", 
		"element should set name property properly ": function(){ 
			var 
				f= element("IFRAME", { name: "myiframe" })	
				,_f= f.ready()
			; 
			document.body.appendChild(_f); 
			var live= frames.myiframe; 
			Y.Assert.areEqual(_f.contentWindow, live); 
		}
		,"element should add event handler properly ": function(){ 
			var 
				 f= element("button", { onclick: "alert(event.srcElement + this)" })
				 ,_f= f.ready()
			; 
			_f.innerHTML= "Event Handler Test"; 
			document.body.appendChild(_f); 
			
		}
		,"elements should be ready when opened": function(){ 
			var 
				_e= element("DIV", { foo: "bar" } )
				,e= _e.ready()
				,v= ""
			; 
			if(e){ 
				v= e.getAttribute("foo"); 
			}
			Y.Assert.areEqual("DIV", e.tagName); 
			Y.Assert.areEqual("bar",v); 

		},
		"elements should not be ready until closed (IE ONLY)": function(){ 
			if(navigator.userAgent.indexOf("MSIE") <= -1) 
				return; 
			var 
				_e= element("OBJECT", { foo: "bar" } )
				,e= _e.ready()
				,p1= element("param", { name: "foo", value: "bar" }, true)
				,p2= element("param", { name: "bar", value: "foo" }, true) 
				,script= element("SCRIPT", { type: "text/javascript" })
				,_script= script.ready()
			; 
			Y.Assert.areEqual(false, e, _script); 
			_e.appendChild(p1.ready()); 
			_e.appendChild(p2.ready()); 
			_e.close(); 
			e= _e.ready(); 
			script.close(); 
			_script= script.ready(); 
			Y.Assert.areEqual("OBJECT", e.tagName); 
			Y.Assert.areEqual("SCRIPT", _script.tagName); 
		}
		,"embedded child should be in html": function(){ 
			
			var 
				e= element("OBJECT", { foo: "bar" } )
				,_e= e.ready()
				,p1= element("param", { name: "foo", value: "bar" }, true)
				,p2= element("param", { name: "bar", value: "foo" }, true) 
				,em= element("embed", { })
			; 
			e.appendChild(p1.ready()); 
			e.appendChild(p2.ready()); 
			e.appendChild(em.ready());
			e.close(); 
			_e= e.ready(); 
			Y.Assert.areEqual("OBJECT", _e.tagName); 
		}
		,"script and style elements should get text set properly": function(){
			var 
				head= document.getElementsByTagName("HEAD")[0]
				,body= document.body
				,script= element("SCRIPT", { type: "text/javascript" })
				,_sdata= "var \nfoo=\"hello, \" + \"world\"; " 
				,_stext= ""
				,_stnode= document.createTextNode(_sdata)
				,css= element("STYLE",{ type: "text/css" } )
				,_cdata= "#writeto-1{height:300px;width:250px;border:1px solid black;}"
				,_ctext= ""
				,_ctnode= document.createTextNode(_cdata)
			; 
			foo= void(null); 
			script.appendChild(_stnode); 
			script= script.element; 
			_stext= 'text' in script ? script.text: script.innerHTML; 
			Y.Assert.areEqual(_sdata, _stext);

			css.appendChild(_ctnode); 
			css.close(); 
			css= css.element; 
			_ctext= 'text' in css ? css.text: css.innerHTML; 
			_ctext= _ctext.toLowerCase(); 
			_ctext.replace(/\s/gm, ""); 
			_cdata.replace(/\s/gm, ""); 
			body.appendChild(script); 
		
			Y.Assert.areEqual("hello, world", foo); 
			body.appendChild(css); 
			Y.Assert.areEqual("300px", 
				getStyle(
					document.getElementById("writeto-1"), 
					"height"
				) 
			); 
		}
		,"domtree should ignore tags": function(){
			var 
				dtree= new domtree()
				,id= "domtree-ignore-test"
			; 
			dtree
				.add("div", {id:id})
				.add("head")
				.add("ins")
				.close("ins")
				.close("head")
				.add("ins")
				.add("span")
				.close("span")
				.close("ins")
				.close("div")
			; 
			var 
				el= document.getElementById(id), 
				heads= el.getElementsByTagName("HEAD"), 
				ins= el.getElementsByTagName("ins"), 
				span= el.getElementsByTagName("span")
			; 
			Y.Assert.areEqual(0, heads.length); 
			Y.Assert.areEqual(1, span.length);
			Y.Assert.areEqual(2, ins.length); 


			
		}
		,"domtree should allow consecutive unclosed tags": function(){ 
			var dtree= new domtree(); 
			dtree
				.add("script", { id: "object-test1", src: "foo.js"})
				.close("script", false)
				.add("script", { id: "object-test1", src: "foo.js"})
				.close("script", false)
				.add("script", { id: "object-test", src: "foo.js" })
				.close("script", false)
				.add("A", { width: "250", height: 300 , href: "#" })
				.add("IMG", { src: "about:blank" })
				.close()
				.close()
			; 
			

		}
		,"domtree should maintain heirarchy": function(){
			var dtree= new domtree(); 
			dtree.add("", "Text above the div"); 
			dtree.close(); 

			dtree.add("DIV", { style: "height: 300px; width: 250px; border: 1px solid black;" });
			dtree.add("", "This is some text at the top of the div"); 
			dtree.close(); 
			dtree.add("SPAN", { style: "border: 2px dotted red" }); 
			dtree.add("", "Text within the span"); 
			dtree.close(); 
			dtree.add("IMG", { src: "http://www.digital-fulcrum.com/images/digital_fulcrum_color_small.jpg" }); 
			dtree.close(); 
			dtree.close(); 
			dtree.close(); 
		}
	}); 
	var streamParser= new Y.Test.Case({ 
		name: "HTML Stream Parser to DOM Tree Tests", 
		"simple html should parse to proper DOM": function(){ 
			var 
				text= 
					"document.write('<div id=written-1> hello, world </div>');" + 
					"var writtenDiv= document.getElementById('written-1');"
				,theTest= this
			;
				
			ghostwriter("writeto-1", {
				script: { text: text}, 
				done: function(){ 
					var d= document.getElementById("written-1"); 
					d.appendChild(document.createTextNode("FINISHED")); 
					theTest.resume(function(){
						Y.Assert.areEqual("DIV", d.tagName); 
						Y.Assert.areEqual(d, writtenDiv)
					})
				}
				
			}); 
			this.wait(function(){ 
				Y.Assert.fail("TIMEOUT waiting for test")
			},500)
		}
		,"written elements should be accessible like document.write": function(){ 
			var 
				theTest= this
				,openClosed
				,openNotClosed
				,imageIdTest
				,imageCollectionTest

			ghostwriter("writeto-1", { 
				script: t
				,done: function(){ theTest.resume(check) }
			}) 
			this.wait(function(){
				Y.Assert.fail("Test timed out waiting on done")
			}, 100)

			function t(){ 
				openandclose(); 
				opennotclosed(); 
				viaglobal(); 
			}
			function check(){
				Y.Assert.areEqual("DIV", openClosed.tagName); 
				Y.Assert.areEqual("DIV", openNotClosed.tagName); 
				Y.Assert.areEqual("IMG", imageIdTest.tagName)
				Y.Assert.areEqual(imageIdTest, imageCollectionTest)
			}
			function openandclose(){ 
				document.write("<div id='open-closed'><\/div>"); 
				openClosed= document.getElementById("open-closed"); 
			}
			function opennotclosed(){ 
				document.write("<div id='opennotclosed'>"); 
				openNotClosed= document.getElementById("opennotclosed"); 
				document.write("</div>"); 
			}
			function viaglobal(){ 
				document.write(
					"<img src='about:blank' " + 
					"height=1 width=1 name=TESTING id=TESTING>"
				)
				imageIdTest= document.getElementById("TESTING")
				imageCollectionTest= document.images['TESTING']
			}
		}
		,"written scripts should execute": function(){ 
			var theTest= this; 
			while(ghostwriter.running) 
				ghostwriter.currload(true)
			ghostwriter("writeto-1", {
				script: { 
					id: "test-immediate-execution",

					text: "(" +
						function(){ 
							window['TG']= void(null); 
							document.write(
							"<div id=script-text><scr" + 
							"ipt type=\"text/javascript\"> " + 
							"TG= 203;" + "<\/script>"
							); 
						} + ")(); "

				}
			}); 
			this.wait(function(){ 
				Y.Assert.areEqual(203, TG)
			}, 100)
		}
		,"written inline scripts should write into parent": function(){ 
			ghostwriter.currload(true)
			var 
			text="document.write('<img id=inlineimg name=inlineimg />');"
			,html= window['html']= [
				"<div id=contains-inline-output>", 
				"<script type=text/javascript>", 
				text,
				"<\/script>", 
				"</div>"
			].join(""); 
			ghostwriter("writeto-1", { script: { 
				text: "document.write(html);"
				,done: test
			}});
			function test(){
			var 
				i= document.images['inlineimg'],
				d= document.getElementById("contains-inline-output")
			; 
			Y.Assert.areEqual("IMG", i.tagName); 
			Y.Assert.areEqual(d, i.parentNode); 
			}
		}
		,"written flash objects should render": function(){ 
			
			var 
				 d= document.createElement("DIV")
				,theTest= this
				,str= 
				  'plain text above the object <hr/> <obj' + 'ect id="youtube-video" width="640" height="385"><param name="movie" value="http://www.youtube.com/v/z6JQzmsdBmM&hl=en_US&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed id="youtube-video" src="http://www.youtube.com/v/z6JQzmsdBmM&hl=en_US&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385"><\/embed><\/obj' + 'ect>'
			;
			document.body.appendChild(d); 
			ghostwriter(d, { 
				script: { 
					text: "document.write('" + str + "');" 
				}
				,done: function(){ 
					theTest.resume(function(){ 
						var d= document.getElementById("youtube-video"); 
						Y.Assert.isNotNull(d)
					})
				}
			}); 
			this.wait(function(){
				Y.Assert.fail("TIMEOUT waiting on finish")
			},500)
		}
		,"import statements should not freeze IE":function(){
			var 
			     u= "http://1.cuzillion.com/bin/resource.cgi?type=css&sleep=1&n=1&t=1234" 
			    ,t= "<div class=fake>Heloo from fake, am I red?</div> <div class=sleepcgi>Hello, world..I am purple,right?<\/div>" + 
				"<style id=import>" + 
				"@import url('" + u + "');" + 
				".fake { color: red; } " + 
				"</style>"
			; 
			ghostwriter(document.body.firstChild, { 
				 script: { text: "document.write(\""+ t + "\");" }
				,insertType: "before"
			});
		}
	});
	var styleparser= new Y.Test.Case({ 
		name: "STYLE element", 
		 "style elements should not choke on import statements": function(){ 
			var 
				style= element("STYLE",{})
				,div= element("DIV", { 'class': "sleepcgi" })
				,body= document.body
				,text= "@import url('http://1.cuzillion.com/bin/resource.cgi?type=css&sleep=1&n=1&t=1234');"
				;
			div.appendChild(element("", "This is text foolio").element);

			style.appendChild(element("",text).element);
			style.close(); 

			body.appendChild(style.element); 
			body.appendChild(div.element); 

			div.close(); 
			var color= getStyle(div.element, "color");
			flog("color is " + color); 
		}
	}); 

	Y.Test.Runner.add(tagCreator); 
	Y.Test.Runner.add(streamParser); 
	Y.Test.Runner.add(styleparser); 
	var b= document.createElement("BUTTON"); 
	b.innerHTML= "Start testing!"; 
	b.onclick= function(){
		Y.Test.Runner.run(); 
	}; 
	document.body.insertBefore(b, document.body.firstChild); 
}
function getStyle(oElm, strCssRule){
	var strValue = "";
	if(document.defaultView && document.defaultView.getComputedStyle){
		strValue = document.defaultView.getComputedStyle(oElm, "").getPropertyValue(strCssRule);
	}
	else if(oElm.currentStyle){
		strCssRule = strCssRule.replace(/\-(\w)/g, function (strMatch, p1){
			return p1.toUpperCase();
		});
		strValue = oElm.currentStyle[strCssRule];
	}
	return strValue;
}


