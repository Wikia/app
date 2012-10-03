
function test(){ 
var theTest = new Y.Test.Case({ 
	name: "Empty Scripts",
	"empty scripts should be mutable post-attach" : mutateEmptyScript,
	'empty scripts should not clog queue': addNewScript
});
Y.Test.Runner.add(theTest)
Y.Test.Runner.run(); 
}

function addNewScript(){
	var test= this
	clogged = true
	ghostwriter(document.body , { 
		script: { text: "clogged= false; document.write('<h1>hello, world </h1>')" } ,
		insertType: 'append'
	})

	this.wait(function(){ 
		Y.Assert.isFalse(clogged); 	
	},1500); 
}

function mutateEmptyScript (){ 

flog('starting mutateEmptyScript() test') 

	window.ws = writeScript
	window.good = false
	ghostwriter(document.body, { 
		 insertType: "append"
		,script: { text: "ws()" } 
	});
	this.wait(function(){ 
		Y.Assert.isTrue(good); 	
	},1500); 

	function writeScript(){
		document.write("<script id=a ><\/script>");
		document.write("<script>setTimeout('" + 
			'document.getElementById("a").src="good.js"' + 
			"', 1)<\/script>");
	}
	function scriptSleepOnload(){ 
		flog('test will fail, script should not have executed')
		failed= true
	}
}


