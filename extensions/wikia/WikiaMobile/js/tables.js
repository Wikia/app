define('tables', ['events', 'track', 'wikia.window', 'jquery'], function(ev, track, w, $){
	'use strict';

	var d = w.document,
		pageContent = d.getElementById('mw-content-text') || d.getElementById('wkMainCnt'),
		realWidth = pageContent.offsetWidth,
		inited = false,
		handledTables = $();

	function process(tables){
		//if the table width is bigger than any screen dimension (device can rotate)
		//or taller than the allowed vertical size, then wrap it and/or add it to
		//the list of handled tables for speeding up successive calls
		handledTables = tables.add(handledTables);

		tables.filter(function(index, element){
			var tr = $(element).find('tr'),
				trLength = tr.length,
				correctRows = 0,
				l,
				i = 0;

			if(trLength > 2) {
				//sample only the first X rows
				tr = tr.slice(0,9);
				l = tr.length;

				for(; i < l; i++) {
					if(tr[i].cells.length == 2){
						correctRows++;
					}
				}
			}

			return correctRows > Math.floor(trLength/2);
		}).addClass('infobox')


		tables.filter(function(index, element){
			return $(element).width() > realWidth;
		}).wrap('<div class="bigTable" />');

		if(!inited && handledTables.length > 0){
			inited = true;
			w.addEventListener('viewportsize', function(){
				var table,
					isWrapped,
					isBig;

				realWidth = pageContent.offsetWidth;

				for(var x = 0, y = handledTables.length; x < y; x++){
					table = handledTables.eq(x);
					isBig = table.width() > realWidth;
					isWrapped = table.parent().is('.bigTable');

					if(isBig && !isWrapped){
						table.wrap('<div class="bigTable" />');
					}else if(!isBig && isWrapped){
						table = table.unwrap()[0];
						table.wkScroll.destroy();
						table.wkScroll = null;
					}
				}
			});

			if(!Features.overflow){
				$(d.body).on(ev.touch, '.bigTable', function(){
					var table = this.getElementsByTagName('table')[0];

					if(!table.wkScroll) {
						table.wkScroll = new w.iScroll(this, function(){
							track.event('tables', track.SWIPE);
						});
						this.className += ' active';
					}
				});
			}
		}
	}

	return {
		process: process
	};
});