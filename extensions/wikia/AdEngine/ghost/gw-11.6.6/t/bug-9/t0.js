function test(){ 
	var theTest = new Y.Test.Case({ 
		 name: "Parallel Loading Test"
		,"ghostwriter should not trigger premature execution" : testPrematureExecution 
	});
	Y.Test.Runner.add(theTest)
	Y.Test.Runner.run(); 
}
function testPrematureExecution(){ 
var 
	 correctOrder= ['x-order=0','x-order=1','x-order=2'] 
	,theTest= this
	,execOrder= []
	,loaded= false
;
window['scriptSleepOnload']= scriptSleepOnload
window['addToExecOrder']= addToExecOrder

ghostwriter(document.body,{ 
	script: { src: "http://paraload.ec2-1.digital-fulcrum.com/?delay=0" } 
	,done: function(){ 
		theTest.resume(function(){ 
			Y.ArrayAssert.itemsAreEqual(
				 correctOrder
				,execOrder
				,"A script ran prematurely / out-of-order"
			)
		})
	}
})
this.wait(function(){ 
	Y.Assert.fail("Script load timeout / premature execution!") 
}, 10000)
function scriptSleepOnload(url){ 
	if(!loaded) { 
		loaded= true
		loadScripts()
	}else
		addToExecOrder(getOrder(url))	
}

function addToExecOrder(value){ 
	execOrder.push(value)
}
function loadScripts(){
	var 
		server= 'http://sub.ec2-1.digital-fulcrum.com/'
		,urls= [
		    '?delay=3&x-order=1'
		   ,'?delay=2&x-order=2'
		]
		,q= []
	;	
	document.write("<script>addToExecOrder('x-order=0')<\/script>")
	for(var i = 0 , l = urls.length; i < l ; i++){ 
		var url= server + urls[i] 
		document.write([
			"<script src='",url,"'>", 
			"this is bogus test", 
			"<\/script>"
		].join(""))
	}	
	return q 
}

function getOrder(qsv){
	var 
		 re= /x-[\w\-]*order=\d+/
		,m= qsv.match(re) 
	;
	return m[0] 
}

}
