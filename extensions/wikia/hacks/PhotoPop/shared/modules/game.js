var exports = exports || {};

define.call(exports, function(){
	var Game = my.Class(Observable, {
		constructor: function(options){
			options = options || {};
			
			this._id = options.id;
			this._data = options.data || [];
			this._currentRound = 0;
		},
		
		getId: function(){
			return this._id;
		},
		
		play: function(){
			console.log('Starting game: ' + this._id);
			this.next();
		},
		
		next: function(){
			if(this._currentRound < this._data.length){
				var info = this._data[this._currentRound++];
				
				this.fire('roundStart', {gameId: this._id, data: info});
			}else{
				console.log('Game completed!');
				this.fire('complete');
			}
		}
	});
	
	return {
		Game: Game
	};
});