function test(){ 
	if(document.documentElement.doScroll) 
		Y.Test.Runner.add(new Y.Test.Case({ 
			 name: "Handle doScroll Override"
			,setUp: ghostwriter.fh.set 
			,"doScroll should throw error while emulating preload": testDoScrollOverride
			,"doScroll should restore on simulated domeready event": testDoScrollRestore
		}))

	var theTest = new Y.Test.Case({ 
		 name: "Refire DOM Load Events"
		,setUp: ghostwriter.fh.set 
		,"should re-fire onload events subscribed to post-load": testOnloadEvents
		,"should not proxy non-onload events": testNonloadEvents 
		,"should refire global onload event": testGlobalOnload
		,"exceptions in event handlers should not be trapped": testException
	});
	Y.Test.Runner.add(theTest); 

	var b= document.createElement("BUTTON"); 
	b.innerHTML= "Start testing!"; 
	b.onclick= function(){
		Y.Test.Runner.run(); 
	}; 
	document.body.insertBefore(b, document.body.firstChild); 
}

function testDoScrollRestore(){ 
	var threw= false 
	ghostwriter.fh()
	try{ document.documentElement.doScroll() } 
	catch(e){ 
		Y.Assert.fail("doScroll handler not restored properly: " + e)
	}
}
function testGlobalOnload(){ 
	ghostwriter.fh()
	Y.Assert.areEqual(true, globalOnloadFired, "Never fired global onload event") 
}
function testException(){ 
	if(window.addEventListener)
		window.addEventListener("load", throwError, false) 	
	else if (window.attachEvent) 
		window.attachEvent("onload", throwError) 
	flog("registered event that should throw an error")
	ghostwriter.fh()
}
function throwError(){ 
	flog("about to throw an error ... ") 
	return NOT_DEFINED_VARIABLE++
}

function testDoScrollOverride(){ 
	var 
		 docElem= document.documentElement
		,threw= false
	;
	try { 
		document.documentElement.doScroll()
	}
	catch(e){ threw= true } 
	Y.Assert.areEqual(true, threw, "doScroll did not throw an exception")
}

function testNonloadEvents(){ 
	var 
		clicked= false
	;
	if(document.addEventListener)
		document.addEventListener("click", handleClick, false) 
	else if (document.attachEvent) 
		document.attachEvent('onclick', handleClick) 
	
	simulateClick()
	Y.Assert.areEqual(true, clicked, "Click event never handled!") 

	function handleClick(event){
		clicked= true
	}
	function simulateClick(){ 
		if(document.createEvent){ 
			var event= document.createEvent("MouseEvents")
			event.initMouseEvent(
				"click", true, true, window, 
				0,0,0,0,0, false, false, false ,false, 0, null
			) 
			document.dispatchEvent(event) 
		}else if(document.fireEvent) 
			return document.fireEvent("onclick")
	}

}

function testOnloadEvents(){

	var 
		fired= 0 
	;
	if( document.addEventListener ) { 
		fired++
		document.addEventListener(
			"DOMContentLoaded", 
			function(){ flog("firing domcontentloaded"); fired -- }, 
			false
		)
		fired++
		window.addEventListener(
			"load", 
			function(event){ 
				flog("firing window.onload "); 
				if(event.type != 'load') 
					Y.Assert.fail("Fired wrong event type") 
				else 
					fired -- 
			}, 
			false
		)
	}
	if ( document.attachEvent ){  
		fired++
		window.attachEvent(
			"onreadystatechange", 
			function(){ fired -- }
		)
		fired++
		window.attachEvent(
			"onload",
			function(event){ 
				if(event.type != 'load') 
					Y.Assert.fail("Fired wrong event type") 
				fired -- 
			} 
		)
	}
	ghostwriter.fh()
	Y.Assert.areEqual(0, fired, "Failed to fire all events to which we subscribed") 
	ghostwriter.fh()
	Y.Assert.areEqual(0, fired, "Re-fired events multiple times!") 
}
