function test(Y){
var inlineWriteHandlerTest = new Y.Test.Case({ 
	name: "Inline Document.write tests", 
	"should create identical dom structure": function(){ 
		var 
			regular= Y.one("#parse-0") 
			,modified= Y.one("#parse-1")
		; 
		Y.Assert.areEqual(regular.innerHTML, modified.innerHTML); 
	},
	"should have correct element count": function(){ 
		var 
			 tags = ghostwriter.getTags()
			,node= Y.one("#parse-1")
		; 
		for(var tag in tags) { 
			// script tags are all ready in the DOM and would not be found 
			if(tag == 'script') continue; 
			Y.Assert.areEqual( node.all(tag).size(), tags[tag], "Should have same count for " + tag  ); 
		}
			
	}
})
Y.Test.Runner.add(inlineWriteHandlerTest);
Y.Test.Runner.run();
}
; 

