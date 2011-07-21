function test(){ 
	var theTest = new Y.Test.Case({ 
		name: "Queue Tests", 
		"ghostwriter should queue when multiple calls are made" : testQueue 
	});
	Y.Test.Runner.add(theTest)
	Y.Test.Runner.run(); 
}
function scriptSleepOnload(url){ 
	document.write("<h3>Loaded: <span>" + url + "<\/span><\/h3>")
}
function writeSleeper(url){ 
	document.write("<script>scriptSleepOnload('" + url + "')<\/script>")
}
function testQueue(){ 
	var 
		 theTest= this
		,firstUrl= "?delay=2&x-order=1&cb=" + Math.floor(Math.random() * 100000) 
		,secondUrl= "?delay=1&x-order=2&cb=" + Math.floor(Math.random() * 100000) 
		,server= "http://a.ec2-1.digital-fulcrum.com"
		,urls= [firstUrl, "inline local script 1", secondUrl]
		,loaded= []
	; 
	ghostwriter("test-1", { 
		 insertType: "append"
		,script: { src: server+'/'+ urls[0]} 
		,done: function(){ 
			loaded.push(firstUrl)
		} 
	});
	ghostwriter("test-1", { 
		 insertType: "append"
		,script: { text: "writeSleeper('" + urls[1] + "')" } 
		,done: function(){ 
			loaded.push(urls[1])
		} 
	});

	ghostwriter("test-1", { 
		insertType: "append"
		,script: { src: server+'/'+urls[2]} 
		,done: function(){ 
			loaded.push(secondUrl)
			theTest.resume(function(){ 
				Y.ArrayAssert.itemsAreEqual( urls, loaded )
			}); 

		}
	}); 

	this.wait(function(){ 
		Y.Assert.fail("never got return from first script!"); 
	},60000); 

}

