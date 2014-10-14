$.loadJQueryAIM = function(){
	return {
		done: function(func) {
			func();
		}
	};
};

$.fn.log = function(){return true};