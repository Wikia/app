window.HTMLParser= ghostwriter.htmlstreamparser
function test(Y){

	var 
		 tokenTest= new Y.Test.Case({
		 	name: "Tokenizer Test" 
			,"tokenized string should equal original": testTokenizer 
		})
		,tagHandler= new Y.Test.Case({ 
			 name: "HTML Tag Handling Test"
			,"parser should have correct tag count": testTagHandling 	
			,"parser should remove non-standard tags": testProcessingInstruction  
			,"parser should allow non-standard attributes": testAttributeHandling
		})
		,attributeTest= new Y.Test.Case({ 
			name: "HTML Tag Attribute Test"
			,"parser should ignore duplicate attributes" : testDuplicateAttributes
		})
		,speedTest= new Y.Test.Case({ 
			 name: "Parsing Speed Test"
			,"parser should buffer quickly":   testProcessingSpeed
		})
		,commentTest= new Y.Test.Case({ 
			 name: "Comment Tag Handling"		
			,"parser should handle basic comment tag properly": testCommentParsing 
			,"poorly closed comment tags should parse correctly": testPoorClosing 
			,"should remove html comments": testCommentHandling
			,"comments that enclose html tags should close properly": testEnclosedTags
		})
		,closingTokens= new Y.Test.Case({ 
			name: "Closing Token Testing" 
			,"parser should allow for missing ending token for closing tag": testEndToken 
		})
	; 
	Y.Test.Runner
		.add(tokenTest)
		.add(tagHandler)
		.add(attributeTest)
		.add(speedTest)
		.add(commentTest)
		.add(closingTokens)
	;
	Y.Test.Runner.run(); 
}
; 
function testTokenizer(){ 
	for (var
		i=0,
		l=strList.length,
		s= strList[i] 
	     ;i < l; 
	     s= strList[++i]
	){ 
		var a= tokenizer(s[0]); 
		Y.Assert.areEqual(a.join(""), s[0]); 
	}
	return true; 
}
function testDuplicateAttributes(){ 
	var string= "<div class=foo class=bar></div>"
	var p= new HTMLParser({ 
		start: function(t,a){
			debugger
			Y.Assert.areEqual('foo', a['class'])
		}
	})
	p.parse( string )

}
function testProcessingInstruction(){ 
	var count= 0; 
	var p= new ghostwriter.htmlstreamparser({start: function(){ count++; } }); 	
	p.parse("<?xml version=\"1.0\" encoding=\"utf-8\"?><div></div>"); 
	Y.Assert.areEqual(1, count); 
}
function testAttributeHandling(){ 
	var count= 0, at= { }; 
	var p= new HTMLParser({start: function(t,a){ 
		for (var i=0; i < a.length; i++){ 
			var o= a[i]; 
			at[o.name]= o.value; 
		}
		count++; 
	} }); 	
	p.parse("<div class=\"textblock\" xmlns:dc=\"http://www.purl.org/dc/elements/1.1\"  ></div>"); 
	Y.Assert.areEqual(1, count); 
	Y.Assert.areEqual("http://www.purl.org/dc/elements/1.1", at['xmlns:dc']); 
	Y.Assert.areEqual("textblock", at['class']); 
}
function testCommentParsing(){ 
	var 
		comment= "<!-- -------------- Advertising.com ------ Rubicon - USAToday - Rubicon USAToday 300x250 RP - 786746 - (300x250) ------------ -->\n<img border=1 height=50 width=20 src=about:blank />",
		failed= true,
		p= new HTMLParser({
			start: function(t,a){ 
				flog("got tag " + t); 
				failed=false; 
			}	
		})
	; 
	p.parse(comment); 
	Y.Assert.areEqual(false, failed); 
}
function testTagHandling(){
	for(var 
		i=0, 
		l= strList.length, 
		s= strList[i]
	    ; i < l 
	    ; s= strList[++i]
	) 
		t1(tokenizer(s[0]), s[1]); 	
	return true; 
	function t1(ary, tags){ 
		var 
			counts= (function(tags){
				var _= {}; 
				for(var t in tags)
					_[t]= { start: tags[t], end: tags[t] }; 
				return _; 
			})(tags), 
			p= new HTMLParser({ 
				start: function(tag,att,unary){ 
					counts[tag].start--;	
					if(unary) counts[tag].end--; 
				}
				, end: function(tag){ counts[tag].end--;  }
			})
		; 	
		flog('parsing '  + ary.join("   |  "))
		for(var i=0,l= ary.length; i<l; i++)
			p.parse(ary[i]); 

		for(var t in counts){
			flog(
				"Did not get equal count for " + t + 
				" ( " + counts[t].start + " / " +  counts[t].end + ")"
			)
			if(counts[t].end != counts[t].start) 
				debugger
			Y.Assert.areEqual(0, counts[t].end, counts[t].start)
			flog(" GOT " + t)
		}
		tags= null; 
	}
}
function testPoorClosing(){ 
	var 
		 fn= arguments.callee
		,content= "Text here"
		,txt= "<!-- Comment unclosed!--<tag>" + content 
		,tester= this
		,writeTo= document.createElement('div') 
	; 
	document.body.appendChild(writeTo)
	ghostwriter(writeTo, { 
		script: { text: "document.write('" + txt + "');"}, 
		done: function(){ 
			tester.resume(function(){  	
				var 
					lastChild= writeTo.lastChild
					,text= lastChild.textContent ? 
						lastChild.textContent : writeTo.innerText
				;
				Y.Assert.areEqual(content, text); 
			}); 
		}
	});
	this.wait(); 
}
function testProcessingSpeed(){ 
	var tokens= [ 
'<SCRIPT type="text/javascript"> \n'
,'var TFSMFlash_PRETAG="";\n'
,'var TFSMFlash_POSTTAG=""; \n'
,'var TFSMFlash_VERSION="9"; \n'
,'var TFSMFlash_WMODE="opaque"; \n'
,'var TFSMFlash_OASCLICK="http://omnikool.discovery.com/RealMedia/ads/click_lx.ads/dsc.discovery.com/index.html/L28/1980056644/TopLeft/DCI/4674__Pushdown_Banner_810330963/070910SCJ_TLC_GladePushRB.html/3245514b726b77754250554143767137?http://tlc.howstuffworks.com/home/clean-your-home-game.htm";\n'
,'var TFSMFlash_SWFCLICKVARIABLE="?clickTAG="+TFSMFlash_OASCLICK ; \n'
,'var TFSMFlash_SWFFILE="http://imagec12.247realmedia.com/RealMedia/ads/Creatives/DCI/4674__Pushdown_Banner_810330963/Glade-TLC-Roadblock.swf/1278711355"+TFSMFlash_SWFCLICKVARIABLE; \n'
,'var TFSMFlash_FSCOMMAND=""; \n'
,'var TFSMFlash_IMAGEALTERNATE=""; \n'
,'var TFSMFlash_OASALTTEXT=""; \n'
,'var TFSMFlash_OASTARGET="_blank"; \n'
,'var TFSMFlash_OASPROTOCOL="http://"; \n'
,'var TFSMFlash_OASDIM="WIDTH='
,"'"
,'990'
,"'"
,' HEIGHT='
,"'"
,'419'
,"'"
,'"; \n'
,'var TFSMFlash_OASADID="OAS_RMF_TopLeft_FLASH"; \n'
,'document.write,'
,"'"
,'<scr'
,"'"
,'+'
,"'"
,'ipt src="http://imagec12.247realmedia.com/RealMedia/ads/Creatives/DCI/4674__Pushdown_Banner_810330963/TFSMFlashWrapper204.js/1278711355"></scr'
,"'"
,'+'
,"'"
,'ipt>'
,"'"
,'); \n'
,'</SCRIPT>\n'
]
		,parser= new HTMLParser()
		,MAX= 50 /* ms */
		,t1= (new Date).valueOf()
		,t2
; 

	for(var i=0,l= tokens.length;i < l; i++){ 
		parser.parse(tokens[i]); 
	}
	t2= (new Date).valueOf(); 
	Y.Assert.isFalse( t2 - t1 >  MAX ); 
}
function testCommentHandling(){ 
	window.failed= window.failedhtml= window.failedcdata= true; 
	var 
		 fn= arguments.callee
		,tt= "<!--A-->"
		,tester= this
		,div= document.createElement('div')
	; 
	__txt= "";
	__txt += "<!-- Comment unclosed!-->\n<script><!--\nwindow.failedhtml= \n\"" + tt + "\"\n--><\/script>"; 
	__txt += "<!-- Comment unclosed!-->\n<script><!--//<![CDATA[\nwindow.failedcdata= \n\"" + tt + "\"\n//]]>--><\/script>"; 
	window.failed= false; 
	document.body.appendChild(div) 
	ghostwriter(div, { 
		script:{ text: "document.write(__txt)"}, 
		done: function(){ 
			tester.resume(function(){  	
				Y.Assert.areEqual(tt,window.failedcdata)
				Y.Assert.areEqual(tt,window.failedhtml)
			}); 
		}
	});
	this.wait(); 
}
function testEnclosedTags(){ 
	var 
	 content= "content man" 
	,text= '<div id=comment-tester><!-- <div font-family: Arial; font-size: 12px; margin-left: 5px;\">Anzeige</div> -->' + content + '<\/div>'
		,span= document.createElement('span') 
	document.body.appendChild(span) 
	ghostwriter(span, { 
		script: { 
			text: 
				"document.write(decodeURIComponent(\"" + 
				encodeURIComponent(text) + "\"));"
		}
		,done: function(){ 
			Y.Assert.areEqual( 
				content.length, 
				 document.getElementById('comment-tester').innerHTML.length 
			)
		}
	})	
}

function tokenizer(s,count){
	count= count || 10; 
	if(typeof s != 'string'){ 
		if(s.length) 
			s= s.join(""); 
		else 
			throw Error("tokenizer(string);"); 
	}
	if(count > s.length) 
		count= s.length;
	var 
		_=[],
		max= parseInt(s.length / count) * 2, 
		sz= 0,pos= 0
	;
	for( var i=0;i < count -1 ; i++){  
		sz= Math.floor(Math.random() * max); 	
		sz= sz || 1; 
		if(pos + sz > s.length - 1) 
			sz= s.length - pos - 1;
		_[_.length]= s.slice(pos,pos + sz);
		pos += sz; 
	}
	_[_.length]= s.slice(pos, s.length); 
	return _; 
}

function testEndToken(){ 
	var s= document.getElementById("endTokenTest")
		,p= s.parentNode
		,t= this
	p.removeChild(s)

	ghostwriter(p, { script: { text: s.text } , done: testDone })

	this.wait(500, function(){Y.Assert.fail("Timeout waiting for done")})

	function testDone(){
		t.resume(function(){ 
			Y.Assert.isNotNull(document.getElementById("endTokenTest-span"))
		})
	}
}

window['strList']= [  
	[ 
"<h3>FOO</h3><h3>Perl is great</h3><ul><li><h4>Why?</h4></li><li><h4>References</h4></li></ul>", 
{ h3: 1 + 1, h4: 1 + 1, ul: 1, li: 2 }
	], 
	[ 
"<script type=text/javascript> var myf= 1; if(myf>=0)foo(); <\/script>", 
{ script: 1 }
	], 
	[
"<div id=foo><iframe height=100 width=200><script>var _FFF_= -1;<\/script></iframe></div>" , 
{ script: 0, div: 1, iframe: 1,script: 0 }
	],
	[
"<script TYPE=\'text/javascript\'>var ACE_AR = {Site: \'754519\', Size: \'300250\'};<\/script><script TYPE=\'text/javascript\' SRC=\'http://uac.advertising.com/wrapper/aceUAC.js\'><\/script><script type=\"text/javascript\" src=\"http://tap-cdn.rubiconproject.com/partner/scripts/rubicon/alice.js\"><\/script><img src=\"http://pixel.quantserve.com/pixel/p-e4m3Yko6bFYVc.gif?labels=NewsAndReference,CultureAndSociety\" style=\"display: none;\" border=\"0\" height=\"1\" width=\"1\" alt=\"Quantcast\"/>", 
	{ script: 3, img: 1 }

	]
]

