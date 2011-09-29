var exports = exports || {};

define.call(exports, function(){
	return{
		Game: function(options){
			option = option || {};
			
			var gameId = options.id;
			
			//TODO: add game handling
			
			this.getId = function(){
				return gameId;
			};
			
			this.play = function(){
				alert('Starting game: ' + gameId);
			};
		},
		
		Tutorial: function(){
			var gameId = 'tutorial',
			currentRound = 0,
			data = [
				{
					image: 'tutorial_1.jpeg',
					answers:[
						'Edward Cullen',
						'Jacob Black',
						'Bella Swan',
						'Emmett Cullen'
					],
					correct: 'Edward Cullen'
				}
			];
			
			this.getId = function(){
				return gameId;
			};
			
			this.play = function(){
				alert('Starting game: ' + gameId);
			};
			
			this.next = function(){
				if(currentRound < data.length){
					var info = data[currentRound++];
				}else{
					alert('Game completed!');
				}
			};
		}
	}
});