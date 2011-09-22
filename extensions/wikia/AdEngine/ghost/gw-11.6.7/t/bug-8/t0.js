function test(){ 
	var theTest = new Y.Test.Case({ 
		name: "Anchor Removal Test", 
		"removing anchor should not kill IE6" : testAnchorRemoval
	});
	Y.Test.Runner.add(theTest)
	Y.Test.Runner.run(); 

}
function testAnchorRemoval(){ 
	var 
		 to= document.getElementById("test-1") 
		,tn= window.anchor= document.createTextNode("FOO BAR")
		,theTest= this
	; 
	to.appendChild( tn )
	ghostwriter(tn, { 
		 insertType: "before"
		,script: { text: "writeAnchorRemoval();" } 
		,done: function(){ 
			theTest.resume(function(){ 
				Y.Assert.areEqual(null, tn.parentNode)
				var html= to.innerHTML
				Y.Assert.isTrue( html.indexOf("hello") >= 0 )
				Y.Assert.isTrue( html.indexOf("FOO") < 0 )
			})
		} 
	});
	this.wait(function(){ 
		Y.Assert.fail("Did not finish anchor test removal"); 
	},5000); 

}
function writeAnchorRemoval() { 
	document.write("<script>removeAnchor();<\/script>");
}
function removeAnchor(){ 
	window.anchor.parentNode.removeChild(window.anchor); 
	document.write("hello, world");
}


