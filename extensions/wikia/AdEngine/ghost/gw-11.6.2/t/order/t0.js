function test(){ 
	var test= new Y.Test.Case({ 
		name: "Script Load Ordering ", 
		"scripts should load in HTML order": function(){ 
			flog(a); 
			issequence(a); 
		},
		"SCRIPT Node Map should reflect loading scripts": function(){ 
			flog(c); 
			issequence(c); 
		}
	});
	Y.Test.Runner.add(test); 
	Y.Test.Runner.run(); 
}
function issequence(a){ 
	for(var i=0,l=a.length; i < l; i++)
		if(i > 0) 
			Y.Assert.areEqual(
				a[i-1] + 1,
				a[i]
			); 
	return true; 
}
