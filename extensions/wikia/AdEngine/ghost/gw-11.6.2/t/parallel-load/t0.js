function test(){ 
	var theTest = new Y.Test.Case({ 
		 name: "Parallel Loading Test"
		,"ghostwriter should execute scripts in insertion order" : testParallelLoad 
	});
	Y.Test.Runner.add(theTest)
	Y.Test.Runner.run(); 
}
function testParallelLoad(){ 
var 
	scriptQueue= null
	,execOrder= []
	,correctOrder= 'x-sub-order=' + [1,2,3].join("|x-sub-order=")
	,theTest= this
;
window['scriptSleepOnload']= scriptSleepOnload

ghostwriter("p3-c",{ 
	script: { src: "http://paraload.ec2-1.digital-fulcrum.com/?delay=0&x-order=1&cache-control=no-cache" } 
	,done: function(){ 
		theTest.resume(function(){ 
			Y.Assert.areEqual(
				correctOrder, execOrder.join("|"), 
				"Script ran out-of-order"
			)
		})
	}
})
this.wait(function(){ 
	Y.Assert.fail("Script load timeout!") 
}, 10000)
function scriptSleepOnload(url){ 
	if(!scriptQueue) 
		scriptQueue = makeQueue()
	else
		execOrder.push ( getOrder(url) )	
}
function makeQueue(){
	var 
		 cacheControl= "expires=-86400&cache-control=no-cache;max-age=0"
		,server= 'http://sub.ec2-1.digital-fulcrum.com/'
		,urls= [
		    '?delay=3&x-sub-order=1'
		   ,'?delay=2&x-sub-order=2'
		   ,'?delay=1&x-sub-order=3'
		]
		,q= []
	;	
	for(var i = 0 , l = urls.length; i < l ; i++){ 
		var url= server + urls[i] + '&' + cacheControl 
		document.write("<script src='"+url+"'><\/script>")
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
