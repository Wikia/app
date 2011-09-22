
document.write("<div data-stuff=' foo &amp; bar &quot;&quot;&#162;'><\/div>");
var 
	W= "s= true, foo=s&&'bar',bar=foo&&\\\"foo\\\";<entity>",
	Wa= W, 
	da = /&/g,
	ea = /</g,
	fa = />/g,
	ha = /\"/g,
	t = [ '<iframe id=inline-fixamp name=inline-fixamp src="about:blank" data-test="', null, '"><\/iframe>' ]

;

/[&<>\"]/.test(W) && (W.indexOf("&") != - 1 && (W = W.replace(da, "&amp;")), W.indexOf("<") != - 1 && (W = W.replace(ea, "&lt;")), W.indexOf(">") != - 1 && (W = W.replace(fa, "&gt;")), W.indexOf('"') != - 1 && (W = W.replace(ha, "&quot;")));

t[1]= W
document.write(t.join(""))


function test(){ 
	var 
		element= ghostwriter.domelement
		,domtree= ghostwriter.domtree
	;
	var theTest = new Y.Test.Case({ 
		name: "HTML Attribute Encoding", 
		"attributes containing ampersand should be fixed":fixAmpersandTest
	});
	var b= document.createElement("BUTTON"); 
	b.innerHTML= "Start testing!"; 
	b.onclick= function(){
		Y.Test.Runner.add(theTest); 
		Y.Test.Runner.run(); 
	}; 
	document.body.insertBefore(b, document.body.firstChild); 
}


function fixAmpersandTest (){
	var 
		da = /&/g,
		ea = /</g,
		fa = />/g,
		ha = /\"/g,
		theTest= this,
	    	W= "s= true, foo=s&&'bar',bar=foo&& \"foo\" <entity>",
		Wa= W, 
	    	t= [ '<iframe onload="resume()" id=iframe-fixamp name=iframe-fixamp src="about:blank" data-test="', null, '"><\/iframe>' ]
	;
	/[&<>\"]/.test(W) && (W.indexOf("&") != - 1 && (W = W.replace(da, "&amp;")), W.indexOf("<") != - 1 && (W = W.replace(ea, "&lt;")), W.indexOf(">") != - 1 && (W = W.replace(fa, "&gt;")), W.indexOf('"') != - 1 && (W = W.replace(ha, "&quot;")));
	t[1] = W
	window.resume= resume; 
	ghostwriter(document.body.firstChild, { 
		 script: { text: "document.write(decodeURIComponent(\""+ 
		 		encodeURIComponent(t.join("")) + 
			"\"));" }
		,insertType: "before"
	});
	this.wait()
	function resume(){ 
		theTest.resume(function(){ 
			var 
			   i= document.getElementById("iframe-fixamp")
			  ,t= i.getAttribute("data-test")
			; 
			Y.Assert.areEqual(Wa,t)
		})
	}
}

