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
	script.src= url; 
	return script; 
}
function makeMap(arrayOfKeys,singleValue){ 
	var obj= {}; 
	for(var i=0, length= arrayOfKeys.length; i < length; i ++)
		obj[arrayOfKeys[i]]= singleValue; 
	return obj;
}

function queryStringToObject(qsv){ 
	var 
		 pairs= qsv.split("&")
		,ret= { } 
		,pair= []
	;
	for(var i=0, len= pairs.length; i < len; i ++){ 
		pair= pairs[i].split("="); 
		ret[pair.splice(0,1).join("").toLowerCase()]= pair.join("="); 
	}
	return ret; 
}

