function startTest(){ 
	var hookTest= new Y.Test.Case({ 
		 name: "Multi-call loadscripts"
		,"loadscripts should support multiple calls": testMultiLoad 

	});
	Y.Test.Runner.add(hookTest); 
	Y.Test.Runner.run(); 
}

function testMultiLoad(){ 
	ghostwriter.fh.set()
	var 
		 theTest= this
		,body= document.body
	;
	body.appendChild(
		makeDeferScript("t1.js")
	)
		
	function reload(){
		addLoadEvent(function(){
			theTest.resume(testCompletion)
		})
		body.appendChild(makeDeferScript("t2.js"))
		ghostwriter.loadscripts()
	}
	function testCompletion(){
		Y.Assert.areEqual(true, loaded.t1, "failed to load first script, t1.js")
		Y.Assert.areEqual(true, loaded.t2, "failed to load second script, t2.js")
	}

	ghostwriter.debug(true)
	addLoadEvent( reload )
	ghostwriter.loadscripts()

	this.wait(function(){ 
		Y.Assert.fail("Failed to fire onload event handler!!!") 
	}, 5000)

}
function addLoadEvent(fn){
	flog("adding load event ...")
	if(window.addEventListener) 
		window.addEventListener("load", fn, true)
	else if (window.attachEvent) 
		window.attachEvent("onload", fn)

}
function makeDeferScript(url){
	var s= document.createElement("script")
	with(s){
		setAttribute("type", "text/deferscript")
		setAttribute("defersrc",url)
	}
	return s
}
