define('tables', ['events'], function(ev){
	var w = window,
		realWidth = w.innerWidth || w.clientWidth,
		inited = false,
		handledTables = [];

	function wrap(elm){
		var wrapper = document.createElement('div');
		wrapper.className = 'bigTable';
		wrapper.appendChild(elm.cloneNode(true));
		elm.parentNode.replaceChild(wrapper, elm);
	}

	function unwrap(elm){
		var parent = elm.parentNode;
		parent.parentNode.replaceChild(elm, parent);
	}

	function removeScripts(elm){
		var scripts = elm.getElementsByTagName('caption'),
			script,
			i = 0;

		while(script = scripts[i++]){
			script.parentElement.removeChild(script);
		}
	}

	function process(tables){
		var l = tables.length,
			i = 0;

		for(; i < l; i++){
			var table = tables[i],
				rows = table.getElementsByTagName('tr'),
				rowsLength = rows.length;

			//find infobox like tables
			if(rowsLength > 2){
				var correctRows = 0,
					cellLength,
					row;

				for(var j = 0; j < rowsLength; j++) {
					row = rows[j];
					cellLength = row.cells.length;

					//sample only the first X rows
					if(cellLength > 2 || j == 9){
						break;
					}

					if(cellLength == 2){
						correctRows++;
					}
				}

				if(correctRows > Math.floor(rowsLength/2)) {
					table.className += ' infobox';
					break;
				}
			}

			//if the table width is bigger than any screen dimension (device can rotate)
			//or taller than the allowed vertical size, then wrap it and/or add it to
			//the list of handled tables for speeding up successive calls
			//NOTE: tables with 100% width have the same width of the screen, check the size of the first row instead
			var firstRowWidth = rows[0].offsetWidth;

			table.computedWidth = firstRowWidth;
			if(firstRowWidth > realWidth){
				//remove scripts to avoid re-parsing
				removeScripts(table);
				wrap(table);
				table.wasWrapped = true;
				table.isWrapped = true;
				handledTables.push(table);
			}
		}

		if(handledTables.length > 0 && !inited){
			w.addEventListener('orientationchange', function(){
				setTimeout(function(){
					var table, isWrapped, isBig, wasWrapped,
						maxWidth = w.innerWidth || w.clientWidth;

					for(var x = 0, y = handledTables.length; x < y; x++){
						table = handledTables[x];
						isWrapped = table.isWrapped;
						wasWrapped = table.wasWrapped;
						isBig = (table.computedWidth > maxWidth);

						if(!isWrapped && isBig){
							if(!wasWrapped){
								table.wasWrapped = true;
								//remove scripts to avoid re-parsing
								removeScripts(table);
							}

							wrap(table);
							table.isWrapped = true;
						}else if(isWrapped && !isBig){
							unwrap(table);
							table.isWrapped = false;
						}
					}
				},200);
			});

			if(!Modernizr.overflow){
				document.body.addEventListener(ev.touch, function(ev){
					var t = ev.target;

					if(t.className.indexOf('bigTable') > -1){
						if(!t.wkScroll) {
							new iScroll(t);
							t.wkScroll = true;
							t.className += ' active';
						}
					}

				}, true);
			}

			inited = true;
		}
	}

	return {
		process: process
	}
});
