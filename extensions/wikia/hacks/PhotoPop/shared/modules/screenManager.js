var exports = exports || {};

define.call(exports, function(){
	var screens = {},
	Screen = my.Class({
		_screenId: '',
		_domElement: null,
		_origDisplay: '',
		_manager: null,
		
		constructor: function(id, manager){
			this._domElement = document.getElementById(id + 'Screen');
			
			if(!this._domElement) throw "Couldn't find screen '" + id + "'";
			
			this._manager = manager;
			this._screenId = id;
			this._origDisplay = (this._domElement.style.display && this._domElement.style.display != 'none') ? this._domElement.style.display : 'block';
			Observe(this);
		},
		
		hide: function(){
			this._domElement.style.display = 'none';
			this._manager.fire('hide', {id: this._screenId});
			return this;
		},
		
		show: function(){
			this._domElement.style.display = this._origDisplay;
			this._manager.fire('show', {id: this._screenId});
			return this;
		},
		
		getElement: function(){
			return this._domElement;
		}
	}),
	ScreenManager = my.Class({
		constructor: function(){
			Observe(this);
		},
		
		get: function(id){
			return screens[id] = screens[id] || new Screen(id, this);
		}
	});
	
	return new ScreenManager();
});