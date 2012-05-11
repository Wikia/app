define('tables', ['cache', 'events'], function(cache, ev){
	var w = window,
		handledTables,
		tableWrapperHTML = '<div class="bigTable left">',
		realWidth = w.innerWidth || w.clientWidth,
		realHeight = w.innerHeight || w.clientHeight,
		touch = ev.touch;

	function processTables(){
		if(typeof handledTables == 'undefined'){
			handledTables = [];

			$('table').not('table table, .infobox, .toc').each(function(){
				var table = $(this),
					rows = table.find('tr'),
					rowsLength = rows.length;

				//find infobox like tables
				if(rowsLength > 2){
					var correctRows = 0,
						cellLength;

					$.each(rows, function(index, row) {
						cellLength = row.cells.length;

						//sample only the first X rows
						if(cellLength > 2 || index == 9)
							return false;

						if(cellLength == 2)
							correctRows++;
					});

					if(correctRows > Math.floor(rowsLength/2)) {
						table.addClass('infobox');
						return true;
					}
				}

				//if the table width is bigger than any screen dimension (device can rotate)
				//or taller than the allowed vertical size, then wrap it and/or add it to
				//the list of handled tables for speeding up successive calls
				//NOTE: tables with 100% width have the same width of the screen, check the size of the first row instead
				var firstRowWidth = rows.first().width();

				table.computedWidth = firstRowWidth;
				if(firstRowWidth > realWidth){
					//remove scripts to avoid re-parsing
					table.find('script').remove();
					table.wrap(tableWrapperHTML);
					table.wasWrapped = true;
					table.isWrapped = true;
					handledTables.push(table);
				} else if(firstRowWidth > realHeight){
					table.wasWrapped = false;
					table.isWrapped = false;
					handledTables.push(table);
				}
			});

			if(handledTables.length > 0)
				w.addEventListener('resize', processTables);
		}else if(handledTables.length > 0){
			var table, row, isWrapped, isBig, wasWrapped,
				maxWidth = w.innerWidth || w.clientWidth;

			for(var x = 0, y = handledTables.length; x < y; x++){
				table = handledTables[x];
				row = table.find('tr').first();
				isWrapped = table.isWrapped;
				wasWrapped = table.wasWrapped;
				isBig = (table.computedWidth > maxWidth);

				if(!isWrapped && isBig){
					if(!wasWrapped){
						table.wasWrapped = true;
						//remove scripts to avoid re-parsing
						table.find('script').remove();
					}

					table.wrap(tableWrapperHTML);
					table.isWrapped = true;
				}else if(isWrapped && !isBig){
					table.unwrap();
					table.isWrapped = false;
				}
			}
		}
	}

	function onstop(el, x, max){
		var dir = 'bigTable active';

		el.style.border = 'none';

		if(x < max - 5) {
			el.style.borderRight = '5px solid rgb(215,232,242)';
		}

		if(x > 5) {
			el.style.borderLeft = '5px solid rgb(215,232,242)';
		}
	}

	//init
	function init(){

		var body = $(document.body);

		processTables();

		if(handledTables.length){
			if(!Modernizr.overflow){
				var key = 'wideTable' + wgStyleVersion,
					script = cache.get(key),
					ttl = 604800,//7days
					process = function(s){
						Wikia.processScript(s);
						body.delegate('.bigTable', touch, function(){
							if(!this.wkScroll) {
								this.wkScroll = new iScroll(this, onstop);
								this.className += ' active';
							}
						});
					};

				if(script){
					process(script);
				}else{
					Wikia.getMultiTypePackage({
						scripts: 'wikiamobile_scroll_js',
						ttl: ttl,
						callback: function(res){
							script = res.scripts[0];
							cache.set(key, script, ttl);
							process(script);
						}
					});
				}
			}else{
				body.delegate('.bigTable', touch, function(){
					var wrapper = this;
					if(!wrapper.bigTable){
						var outerWidth = wrapper.clientWidth,
							width = wrapper.children[0].offsetWidth;

						wrapper.addEventListener('resize', function(){
							outerWidth = this.clientWidth;
							width = this.children[0].offsetWidth;
						});

						wrapper.addEventListener('scroll', function(ev){
							onstop(wrapper, ev.target.scrollLeft, (width - outerWidth));
						});

						wrapper.bigTable = true;
					}
				});
			}
		}
	}

	return {
		init: init
	}
});