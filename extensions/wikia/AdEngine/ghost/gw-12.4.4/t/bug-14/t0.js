function test(){ 
var theTest = new Y.Test.Case({ 
	name: "Target Not In Document",
	"scripts removed from the dom should not cause deadlock" : targetRemoved ,
	"demolish() should work when sub-script is pending" : subScriptRemoval,
	"demolish() should work with enqeueud ghostwriter handles" : enqueueDemolish 
});
Y.Test.Runner.add(theTest)
Y.Test.Runner.run(); 

}

function targetRemoved(){ 
flog('starting targetNotInDocument() test') 
	window['scriptSleepOnload']= scriptSleepOnload
	var 
		 to= document.body.appendChild( document.createElement("div") ) 
		,theTest= this
		,urlBase= 'http://ec2-1.digital-fulcrum.com/?delay=1&x-test=targetNotInDocument'
		,failed= false
		,complete= false
	; 
	var handle = ghostwriter(to, { 
		 insertType: "append"
		,script: { src: urlBase + '&x-test-sequence=1&cb=' + Math.floor(Math.random() * 1e6) }  
		,done: function(){ 
			flog('targetRemoved completed!') 
			complete = true
		} 
	});
	setTimeout(removeElement, 100);  
	this.wait(function(){ 
		if(complete && !failed) 
			return 

		if(failed)  
			Y.Assert.fail("ghostwriter() script ran in spite of being removed!") 
		if(!complete)
			Y.Assert.fail("ghostwriter() did not complete!") 

	},5000); 

	function removeElement(){
		handle.demolish()
		to.parentNode.removeChild( to ) 
	}
	function scriptSleepOnload(){ 
		flog('test will fail, script should not have executed')
		failed= true
	}
}

function subScriptRemoval(){
	flog('starting subScriptRemoval () test') 

	window['scriptSleepOnload']= scriptSleepOnload
	var 
		 to= document.body.appendChild( document.createElement("div") ) 
		,theTest= this
		,urlBase= 'http://ec2-1.digital-fulcrum.com/?delay=1&x-test=targetNotInDocument&cb=' + Math.floor(Math.random() * 1e6)
		,failed= false
		,complete= false
	; 
	var handle = ghostwriter(to, { 
		 insertType: "append"
		,script: { src: urlBase + '&x-test-sequence=1' }  
		,done: function(){ 
			flog('targetRemoved completed!') 
			complete = true
		} 
	});
	setTimeout(removeElement, 1500);  
	this.wait(function(){ 
		if(complete && !failed) 
			return 

		if(failed)  
			Y.Assert.fail(failed) 
		if(!complete)
			Y.Assert.fail("ghostwriter() did not complete!") 

	},3000); 

	function removeElement(){
		flog('removing target element') 
		handle.demolish()
		to.parentNode.removeChild( to ) 
	}
	function scriptSleepOnload(){ 
		document.write("<script src='" + urlBase + "&x-test-sequence=2'><\/script>")
		window['scriptSleepOnload']= function(){ 
			failed = 'Test will fail, script with x-test-sequence=2 should not have executed'
		}
	}
}

function enqueueDemolish(){
	flog("starting enqueue demolish test")
	window.scriptSleepOnload= null
	var 
		urlBase= function(){ 
			return 'http://ec2-1.digital-fulcrum.com/?delay=1&x-test=enqueueDemolish&cb=' + Math.floor(Math.random() * 1e6)
		},
		firstLoaded= false,
		handle,
		failed= false

	ghostwriter(document.body, { 
		script: { src: urlBase() }, 
		done: function(){ 
			firstLoaded = true
			window.scriptSleepOnload= function(){ 
				failed= "tsk, tsk ... demolished enqueue'd script still ran!"
			}
		}
	})
	handle= ghostwriter( document.body, { 
		script: { src: urlBase()  }
	}); 
	setTimeout(function(){ 
		handle.demolish()
	}, 500);
	this.wait(function(){
		if(failed) 
			Y.Assert.fail(failed) 
		else if (!firstLoaded) 
			Y.Assert.fail("First Script never fired don() handler")
	}, 3000)
}
