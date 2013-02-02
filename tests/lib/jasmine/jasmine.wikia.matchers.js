beforeEach(function(){
	this.addMatchers({
		toBeFunction: function(name){
			return typeof this.actual === 'function';
		}
	});
});