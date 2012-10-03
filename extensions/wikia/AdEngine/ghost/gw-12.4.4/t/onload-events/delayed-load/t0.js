function test(){ 
	var theTest = new Y.Test.Case({ 
		 name: "Refire DOM Load Events"
		,setUp: ghostwriter.fh.set 
		,"should fire onload events after actual event": testDelayedLoadEvent 
	});
	Y.Test.Runner.add(theTest); 
	Y.Test.Runner.run(); 
}


function testDelayedLoadEvent(){
	var 
		fired= 0 
	;
	if( document.addEventListener ) { 
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
			"onload",
			function(event){
				if(event.type != 'load') 
					Y.Assert.fail("Fired wrong event type") 
				fired --
			}
		)
	}
	var totalFired= fired
	ghostwriter.fh()
	Y.Assert.areEqual(totalFired, fired, "Oops, fired the onload event before it happened") 
	this.wait(function(){ 
		Y.Assert.areEqual(0, fired, "Did not re-fire onload event after it actually occurred")
	}, 3000)
}
