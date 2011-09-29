(function(){
	var isApp = (typeof Titanium != 'undefined'),
	prefix = (isApp) ? '' : '../';
	
	require([
			prefix + "shared/modules/configServer",
			prefix + "shared/modules/templates",
			prefix + "shared/modules/imageServer",
			prefix + "shared/modules/soundServer",
			prefix + "shared/modules/game"
		],
		
		function(config, templates, imageServer, soundServer, games) {
			var startTutorial = true,
			wrapper,
			view = {
				image: function() {
					return function(text, render) {
						  return imageServer.getAsset(render(text));
					}
				},
				games: config.games,
				url: function() {
					return function(text, render) {
						  return config.urls[text];
					}
				}
			},
			gameScreenRender = function(event, round){
				var imgPath = (round.gameId == 'tutorial') ? imageServer.getAsset(round.data.image) : imageServer.getPicture(round.data.image);
				view.path = imgPath;
				wrapper.innerHTML = Mustache.to_html(templates.gameScreen, view);
			};
		
			imageServer.init(config.images);
			soundServer.init(config.sounds);	
			
			//load main page
			var elm = (isApp) ? document.body : document.getElementById('PhotoPopWrapper');
			
			elm.innerHTML = Mustache.to_html(templates.mainPage, view);
			
			wrapper = document.getElementById('wrapper'),
			muteButton = document.getElementById('button_volume');
			
			wrapper.innerHTML += Mustache.to_html(templates.selectorScreen, view);
			

			
			muteButton.onclick = function(){
				soundServer.play('pop');
				
				var imgs = this.getElementsByTagName('img');
				
				if(!soundServer.getMute()) {
					soundServer.setMute(true);
					imgs[0].style.display = "none";
					imgs[1].style.display = "block";
				} else {
					soundServer.setMute(false);
					imgs[1].style.display = "none";
					imgs[0].style.display = "block";
				}
			}
			
			if(startTutorial){
				var g = new games.Game({
					id: 'tutorial',
					data: config.tutorial
				});
				g.addEventListener('roundStart', gameScreenRender);
				g.play();
				
								
				var tilesWrapper = document.getElementById('tilesWrapper'),
				table = "",
				tableWidth = wrapper.clientWidth,
				tableHeight = wrapper.clientHeight,
				rows = 4,
				cols = 5;
				
				for(var row = 0; row < rows; row++) {
					table += "<tr>"
					for(var col = 0; col < cols; col++) {
						table += "<td id='tile"+row+"_"+col+"'></td>"
					}
					table += "</tr>";
					tilesWrapper.innerHTML = table;
				}
				
				var tr = tilesWrapper.getElementsByTagName('tr'),
				trLength = tr.length,
				offsetY = -1,
				offsetX = 0;
				
				for(var i = 0; i < trLength; i++) {
					var td = tr[i].getElementsByTagName('td'),
					tdLength = td.length;
					tr[i].style.top = offsetY;
					offsetY += tableHeight / rows;
					for(var j = 0; j < tdLength; j++) {
						td[j].style.width = tableWidth / cols;
						td[j].style.height = tableHeight / rows;
						td[j].style.left = offsetX;
						td[j].onclick = clickTile;
						offsetX += tableWidth / cols;
					}
					offsetX = 0;
				}
				
				function clickTile() {
					soundServer.play('pop');
					this.style.opacity = 0;
					this.style['-webkit-transform'] =  'rotateY(90deg) scale(5)';
					this.style.backgroundColor = 'green';
				}
			}


		}
	);
})();