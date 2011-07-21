function test(){ 
	var testsuite= new Y.Test.Case({ 
		name: "SCRIPT children of NOSCRIPT container", 
		"All elements within a NOSCRIPT tag should be ignored": function(){ 
			var 
			 	text= "<noscript><script>window.failed= true;<\/script><\/noscript>" ,
				fn= arguments.callee,
				tester= this
			; 
			window.failed= false; 
			ghostwriter(document.body, { 
				script: { text: "document.write(\"" + text + "\");"},
				done: function(){ 
					tester.resume(function(){  	
						Y.Assert.areEqual(false,window.failed); 
					}); 
				}
			});
			this.wait(); 
		},
		"NOSCRIPT tag should auto-close on script completion": function(){ 
			window.failed= true; 
			var tester= this; 
			ghostwriter(document.body, { 
				script: { src: "t0-0.js" }, 
				done: function(){ 
					tester.resume(function(){ 
						Y.Assert.areEqual(false, window.failed); 
					}); 
				}
			}); 
			this.wait(); 
		}
	});
	Y.Test.Runner.add(testsuite); 
	Y.Test.Runner.run(); 
}

