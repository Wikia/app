ghostwriter['handlers']= { 
	check: function(tagName, attrObj){  
		var src; 
		return !(

			(src = attrObj.src)
			&& src.indexOf("bad") > 0 
		);
	}
}
function startTest(){ 
	var hookTest= new Y.Test.Case({ 
		 name: "Hook Tester"
  		,"check hook should discard elements with a src url containing 'bad'":testDismissal
		,"begin and end hook should fire when ghostload starts and finishes": testBeginAndEnd
		,"start and finish script handlers should be called when sub scripts load": testStartAndFinish
		,"onelement handler should be called with DOM element argument": testOnElement 

	});
	Y.Test.Runner.add(hookTest); 

}
function testOnElement(){ 
	var 
		 theTest= this
		,calls= 0 
		,sleeper= window['scriptSleepOnload']= function(url){ 
			document.write("<h1>Loaded URL \"" + url + "\"<\/h2>")
		}
		,tags= ['script','img','script','h1'] 
		,found= []
	;
	ghostwriter(document.body, { 
		 script: { text: "writeDomStuff()" } 
		,handlers: { 
			onelement: function(domelement){ 
				calls++
				found.push(domelement.tagName.toLowerCase())
			}
		}
		,done: function(){ 
			theTest.resume(function(){ 
				Y.Assert.areEqual(4,calls)
				Y.ArrayAssert.itemsAreEqual(tags,found)
			})
		}
	})
	this.wait(function(){ 
		Y.Assert.fail("Script timed out...")
	},5000);
}

function writeDomStuff(){ 
	var 
		html = [
			'<script src="http://c.ec2-1.digital-fulcrum.com/?delay=3&x-order=1&cb=js"><\/script>'
			,'<img src="http://c.ec2-1.digital-fulcrum.com/?delay=1&x-order=1&cb=img">'
		].join("")
	;
	document.write(html)
}

function testStartAndFinish(){ 
	var 
		 runner= Y.Test.Runner 
		,theTest= this
		,urls= [
			 '?delay=2&x-order=1&rnd=' + Math.random()
			,'?delay=1&x-order=2&rnd=' + Math.random() 
			,'?delay=1&x-order=3&rnd=' + Math.random()
		 ]
		,server= "http://startandfinish.ec2-1.digital-fulcrum.com"
		,totalCalls= urls.length
		,startCalls= urls.length 
		,finishCalls= urls.length 
		,currentUrl= server + '/' + urls.shift()
		,previousUrl
		,onStart= function(script){ 
			startCalls--
		 }
		,onFinish= function(script){ 
			finishCalls--
		 }
		,sleeper= window['scriptSleepOnload']= function(url){ 
			previousUrl= currentUrl
			totalCalls--
			
			if(urls.length > 0){
				currentUrl= server + '/' + urls.shift()
				document.write('<script src="' + currentUrl + '"><\/script>')
			}
		 }
	;
	ghostwriter(document.body, { 
		 script: { src: currentUrl }
		,done: function(){ 
			window['scriptSleepOnload'] = null
			theTest.resume(function(){ 
				Y.Assert.areEqual(0,startCalls, "got wrong number of starting callbacks")
				Y.Assert.areEqual(0,finishCalls, "got wrong number of finishing callbacks")
				Y.Assert.areEqual(0,totalCalls, "Did not actually execute all scripts")
			});
		} 
		,handlers: { 
			'startscript': onStart, 
			'finishscript': onFinish
		}
	})

	theTest.wait(function(){ 
		Y.Assert.fail("Missed first start handler")
	}, 60000)
}
function testBeginAndEnd(){ 
	var 
		theTest= this
		,url= 'http://beginandend.ec2-1.digital-fulcrum.com/?delay=2&x-order=1'
		,executedScript= false
		,executedBegin= false
		,sleeper= window['scriptSleepOnload']= function(){
			executedScript= true	
		}
		,failed= null
		,beginHandler= function(){ 
			executedBegin= true	
			if(executedScript)
				failed= "Got begin handler after script ran??"
		}
		,endHandler= function(){ 
			if(!executedBegin)
				failed= "got end handler before beginHandler called";
		}
	;
	ghostwriter("writeto-1", { 
		script: { src: url } 
		,handlers: { 
			begin: beginHandler, 
			end: endHandler
		}
		,done: function(){ 
			theTest.resume(function() {
				if(failed) 
					Y.Assert.fail(failed) 
			})
		}
	})
	this.wait(function(){ 
		Y.Assert.fail("Error: Never received beginHandler call")
	}, 5000)
}

function testDismissal(urllist){
	var 
	 ID= 0, URL= 1, ASSERT=2,
	 imageIdsAndUrls= [
	 	 ['good-img', "http://good.ec2-1.digital-fulcrum.com/?delay=2", Y.Assert.areNotEqual ]
		,['bad-img', "http://bad.ec2-1.digital-fulcrum.com/?delay=1", Y.Assert.areEqual ]
		,['good-img2', "http://good.ec2-1.digital-fulcrum.com/?delay=3", Y.Assert.areNotEqual ]
	]; 
	ghostwriter(document.body, { 

		insertType: "append", 

		script: function(){ 
			document.write("<div id=pixel-container>"); 
			$Iterator(imageIdsAndUrls, function($){ 

				document.write(
					makeImageTag($[ID],$[URL])
				); 
				var img= document.getElementById($[ID]); 
				$[ASSERT](img,null); 
			}); 
			document.write("</div id=pixel-container>"); 
		} 
	});  
}

makeImageTag= (function(){ 
	var 
  	  ID= 2, NAME= 4, SRC= 6,
	  IMG= ["<img width=0 height=0", 
		" id=","", 
		" name=","", 
		" src=\"", "", 
		"\">"
	  ]
	;
	return function(name,url){ 
		var img= IMG.slice(); 
		img[NAME]= img[ID]= name; 
		img[SRC]= url; 
		return img.join(""); 
	}
})(); 
function $Iterator(collection,fn){ 
	var _= []; 
	for(var i=0,l= collection.length; i < l; i++)
		_[_.length]= fn(collection[i]); 
	return _; 
}
function test(){ 
	startTest(); 	
	createStartButton(); 
}

function createStartButton(){ 
	var b= document.createElement("BUTTON"); 
	b.innerHTML= "Start testing!"; 
	b.onclick= function(){
		Y.Test.Runner.run(); 
	}; 
	document.body.insertBefore(b, document.body.firstChild); 
}

