//preTest(); 
//if(typeof HTMLScriptElement != 'undefined') 
	//HTMLScriptElement.prototype.async= true; 
var foo= function(arg1){ 
	alert(arg1); 
};
(function(){ 
	return "foo"; 
})(); 
function test(){ 
var 
  testCase = new Y.Test.Case({ 
	name: "Script Execution Learning Tests", 
	"local script should always execute synchronously" : localScriptSync,
	"remote scripts should never execute synchronously": remoteScriptSync,
	"404 error should dispatch through onerror event": errorRemoteScript
/*
"dynamic local script should execute before onload event of local attacher" : doubleAttachLocalScript, 
"local script should execute before onload event of remote attacher" : tripleAttachRemoteScript,
"onload event for remote script should fire after execution of dynamic local script" : doubleAttachingRemoteScript 
*/
   })
;
 Y.Test.Runner.add(testCase); 
 var script= document.createElement('script'); 
 script.src= 'http://e.ec2-1.digital-fulcrum.com/?delay=3&cache-control=no-cache;private'; 
 document.body.appendChild(script); 
 Y.Test.Runner.run(); 
}
function errorRemoteScript(){ 
	var 
		 remote = makeRemoteScript("http://digital-fulcrum.com/404-error.js")
		,theTest= this
		,errorReceived= false
	; 
	remote.onerror= function($event){ 
		errorReceived= true; 
		theTest.resume(); 
		return false; 
	}
	document.body.appendChild(remote); 
	this.wait(function(){ Y.Assert.fail("didn't get the onerror or onload event"); }, 10000); 
	
}
function localScriptSync(){ 
try { 
	oneScript.call(this); 
	/* twoScripts.call(this); */
}
catch(e){ 
	throw e; 
}
function oneScript(){ 
	var 
	   sync= window['execSync']= [0]
	  ,theTest= this
	  ,readyTestScript= makeInlineScriptSynchronous("execSync.push(2)")
	;
	sync.push(1); 
	document.body.appendChild(readyTestScript); 
	sync.push(3); 
	return Y.ArrayAssert.itemsAreEqual([0,1,2,3], sync); 
}
function twoScripts(){ 
	var 
		sync= window['doubleSync'] = [0]
		myScript= makeInlineScript('(' + (function(){ 
			var script = document.createElement('script'); 
			script.text= "doubleSync.push(3);"; 
			doubleSync.push(2); 
			document.body.appendChild( script ); 
			doubleSync.push(4); 
	   	})+ ")()"), 
	   	theTest= this
	; 
	myScript.onload= myScript.onreadystatechange= function(){ 
		this.onload= this.onreadystatechange= null; 
		theTest.resume(function(){ 
			Y.Assert.areEqual('object', typeof window.t0_1); 
		}); 
	}; 
	sync.push(1); 
	document.body.appendChild( myScript ); 
	sync.push(5); 
	return Y.ArrayAssert.itemsAreEqual([0,1,2,3,4,5], sync); 
}

}
function remoteScriptSync(){ 
	var 
		remote= makeRemoteScript("http://e.ec2-1.digital-fulcrum.com/?delay=3&cache-control=max-age=86400;private")
		,theTest= this
	; 
	window['remotesync']= sync= [0]; 
	window['scriptSleepOnload']= function(){
		window['scriptSleepOnload']= void 0;  
		sync.push(3); 
		theTest.resume(function(){ 
			Y.ArrayAssert.itemsAreEqual([0,1,2,3], sync);
		}); 

	}
	sync.push(1); 
	document.body.appendChild(remote); 
	sync.push(2); 
	this.wait(function(){ 
		Y.Assert.fail("synctest.js did not load in 10 seconds...");
	}, 10000);
}

function doubleAttachingRemoteScript(){ 
	var
		 remoteUrl= 'http://b.ec2-1.digital-fulcrum.com/?delay=1&cache-control=no-cache;private'
		,firstScript= makeRemoteScript(remoteUrl)
		,mySleepOnload= window.scriptSleepOnload= function(){ 
			var secondScript= document.createElement('script'); 
			secondScript.text= ['(', (function(){  window.t0_3 = { }; }), ')()'].join(""); 
			document.body.appendChild(secondScript); 
		 }
		,theTest= this
	;
	firstScript.onload= firstScript.onreadystatechange= function(){
		if(!testReadyState.apply(this))
			return;
		this.onload= this.onreadystatechange= null; 
		theTest.resume(function(){ 
			Y.Assert.areEqual('object', typeof window.t0_3); 
		}); 
	}
	document.body.appendChild(firstScript);
	this.wait(function(){ 
		Y.Assert.fail("Remote script element never fired onload event!"); 
	}, 10000); 
}

function tripleAttachRemoteScript(){ 
	var
		 remoteUrl= 'http://a.ec2-1.digital-fulcrum.com/?delay=1'
		,firstScript= makeRemoteScript(remoteUrl)
		/* Our remote script will execute the scriptSleepOnload function */
		,mySleepOnload= window.scriptSleepOnload= function(){ 

			var secondScript= makeInlineScript('(' + (function(){ 

				var thirdScript= document.createElement('script'); 
				thirdScript.text= ['(', (function(){  window.t0_2= { }; }), ')()'].join(""); 
				document.body.appendChild(thirdScript); 

			}) + ')()');

			secondScript.onload= secondScript.onreadystatechange= function(){ 
				if(!testReadyState.apply(this))
					return;
				this.onload= this.onreadystatechange= null; 
				Y.log('after second script onload, t0_2 = ' + typeof t0_2); 

				theTest.resume( function(){ 
					Y.Assert.areEqual('object', typeof t0_2); 
				}); 
			}

			document.body.appendChild( secondScript ); 

	   	 }
		,theTest= this
	;
	firstScript.onload= firstScript.onreadystatechange= function(){
		if(!testReadyState.apply(this))
			return;
		this.onload= this.onreadystatechange= null; 
		Y.log('after first script, t0_2 = ' + typeof t0_2); 
	}
	document.body.appendChild(firstScript);
	this.wait(function(){ 
		Y.Assert.fail("Remote script element never fired onload event!"); 
	}, 5000); 
}
//
//This test creates a script (S1) that attaches
//another script (S2).  It checks if 
//S2 executes before S1's onload event fires
function testReadyState(){ 
	return ( 
		this.readyState && 
		this.readyState != 'complete' && 
		this.readyState != 'loaded' 
	) ? false : true; 
}
function makeInlineScriptSynchronous(scriptText){ 
	var 
		script= document.createElement('script')
	;
	script.text= scriptText; 
	return script; 
}

function makeInlineScript(scriptText){ 
	var 
		script= document.createElement('script')
	;
	script.async= true; 
	script.text= scriptText; 
	if(!(script.readyState && window.ActiveXObject)) 
		script.src= 'data:text/javascript,' + encodeURIComponent(scriptText)
	return script; 
}
function makeRemoteScript(url){ 
	var script= document.createElement('script');
	script.async= true; 
	script.src= url; 
	return script; 
}
function makeMap(arrayOfKeys,singleValue){ 
	var obj= {}; 
	for(var i=0, length= arrayOfKeys.length; i < length; i ++)
		obj[arrayOfKeys[i]]= singleValue; 
	return obj;
}

