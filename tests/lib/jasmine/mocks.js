$.loadJQueryAIM = function(){
	return {
		done: function(func) {
			func();
		}
	};
}

window.Wikia.log = function(){
	return true;
}

window.Wikia.log.levels = {};