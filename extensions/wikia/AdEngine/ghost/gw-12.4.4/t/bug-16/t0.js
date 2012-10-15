
function test(){ 
var theTest = new Y.Test.Case({ 
	name: "Multiple Non-Deferred Scripts",
	"should not remove scripts in the head or before our first one" : finishEarly
});
Y.Test.Runner.add(theTest)
Y.Test.Runner.run(); 
}
function finishEarly(){ 

flog('starting non-defer () test') 
	var self= this, 
	    scripts= document.getElementsByTagName("script"),
	    keepers= ['first-in-body','inhead'], 
	    leavers= ['second-in-body']
	;
	ghostwriter.loadscripts()

	this.wait(function(){ 
		for(var i=0, l= keepers.length; i < l; i++) 
			Y.Assert.isNotNull( document.getElementById( keepers[i] ), 
				"Should not have removed script " + keepers [i] 
			)
	},1500); 
}


