function test(){ 
var theTest = new Y.Test.Case({ 
	name: "Target Not In Document",
	"scripts destined for targets not in the dom should not be attached" : targetNotInDocument
});
Y.Test.Runner.add(theTest)
Y.Test.Runner.run(); 

}
function targetNotInDocument(){ 
flog('starting targetNotInDocument() test') 
	var 
		 to= document.body.appendChild( document.createElement("div") ) 
		,theTest= this
		,urlBase= 'http://ec2-1.digital-fulcrum.com/?delay=1&x-async=false&x-test=targetNotInDocument'
	; 
	window['scriptSleepOnload']= removeNextElementAndWriteName 
	ghostwriter(document.body.lastChild, { 
		insertType: "before", 
		script: { id: "inserted-into-live-dom", src: urlBase + '&x-test-sequence=1' }, 
		done: function(){ 
			window['scriptSleepOnload'] = failTest 
		} 
	})
	ghostwriter(to, { 
		 insertType: "append"
		,script: { id: "inserted-into-orphan", src: urlBase + '&x-test-sequence=2' }  
		,done: function(){ 
			flog('targetNotInDocument completed!') 
			theTest.resume(function(){ }); 
		} 
	});
	this.wait(function(){ 
		Y.Assert.fail("5s elapsed, script incorrectly added to DOM"); 
	},5000); 

	function failTest(){ 
		theTest.resume( function(){ 
			Y.Assert.fail("Pending script still ran") 
		}); 
		window['scriptSleepOnload']= void null 
	}
	function removeNextElementAndWriteName(){
		flog('removing next target element') 
		to.parentNode.removeChild( to ) 
		document.write("loaded script for test " + theTest.name); 
	}


}

