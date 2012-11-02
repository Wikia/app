function createExhibit() {//overload Exhibit's autoCreate-functionality

  /*
   * This javascript bases on the Wibbit startup procedure and was modified for the use in Semantic MediaWiki
   * Data: We're using the HTML table importer to get the data for the exhibit.
  */

	window.database = Exhibit.Database.create();
	window.exhibit = Exhibit.create(window.database);

	if(!remote){

	for (var id in ex_sources) {
		var source = ex_sources[id];
		var dataTable = document.getElementById(source.id);
		//if (source.hideTable == 1) { dataTable.setAttribute("style", "display:none"); };
		dataTable.setAttribute("ex:type", source.type);
		dataTable.setAttribute("ex:label", source.label);
		dataTable.setAttribute("ex:pluralLabel", source.pluralLabel);
		var th, ths = dataTable.getElementsByTagName("th");
		var columns = source.columns;
		if (columns[0] !== "") {
			for(var c = 0; c < ths.length; c++) {
				var split = columns[c].indexOf(':');
				if (split > 0) {
					var name = columns[c].substring(0, split);
					var valueType = columns[c].substring((split + 1), columns[c].length);
					ths[c].setAttribute('ex:valueType', valueType);
				} else { var name = columns[c]; }
				ths[c].setAttribute('ex:name', name);
			}
		} else {
			ths[0].setAttribute('ex:name', 'label');
			for (var c = 1; c < ths.length; c++) {
				//Safari uses innerText instead of textContent, so:
				var thetext = ths[c].textContent || ths[c].innerText;
				var label = thetext.toLowerCase();
				label = label.replace(/\s/g,'');
				ths[c].setAttribute('ex:name', label);
			}
		}
		Exhibit.HtmlTableImporter.loadTable(dataTable, window.database);
	}}

    window.database.loadDataLinks(); //load JSON files in addition

    var exhibitDiv = document.getElementById('exhibitLocation');
    exhibitDiv.innerHTML = "<div id='top-facets'></div><table width='100%' style='clear: both'><tr id='exhibit-content' valign='top'><td id='left-facets' width='0%'></td><td id='view-content'><div id='view'></div></td><td id='right-facets' width='0%'></td></tr></table><div id='bottom-facets'></div>";//<div ex:role='exhibit-collection' ex:itemTypes='Item'/>";

    /*
     * Configuration: We're creating HTML strings that specify the configurations,
     * formatted in the same form as specifications in the HTML of a regular exhibit.
     */
    if (ex_facets) {//facets
      for (var index in ex_facets) {
		  var facet = ex_facets[index];
		  var position = facet.position;
		  var innerHTML = "<div " + facet.innerHTML + " style='padding: 2px; float: left; width: 15em' ></div>";
		  if (position == "top") {
			  var facetDiv = document.getElementById('top-facets')
			  facetDiv.innerHTML = facetDiv.innerHTML + innerHTML;
		  }
		  if (position == "bottom") {
			  var facetDiv = document.getElementById('bottom-facets');
			  facetDiv.innerHTML = facetDiv.innerHTML + innerHTML;
		  }
		  if (position == "left") {
			  var facetTd = document.getElementById('left-facets');
			  facetTd.innerHTML = facetTd.innerHTML + innerHTML;
			  facetTd.setAttribute('width', '24%');
		  }
		  if (position == "right") {
			  var facetTd = document.getElementById('right-facets');
			  facetTd.innerHTML = facetTd.innerHTML + innerHTML;
			  facetTd.setAttribute('width', '24%');
		  }
		}
    }

    if (ex_views && (ex_views[0] !== "")) {//views
		var viewHTML = '<div '+formats+' id="exhibit-view-panel" ex:role="viewPanel"><div ex:role="lens">'+ex_lens+'</div>';
		for (var i = 0; i < ex_views.length; i++) {
			viewHTML = viewHTML + '<div ' + ex_views[i] + ' ></div>';
		}
		viewHTML = viewHTML + '</div>';
		document.getElementById("view").innerHTML = viewHTML;
    } else {
		document.getElementById("view").innerHTML = '<div ex:role="view"></div>';
    }

    for(var i = 0; i < ex_lenscounter; i++){ //lenses
		var test = document.getElementById("lenscontent"+i);
		if(test.innerHTML.indexOf('|')>=0){
			var commands = test.innerHTML.split('|');
			test.setAttribute('ex:formats','date { template:\'' + commands[1] +'\' }');
			test.innerHTML = commands[0];
		}
		test.setAttribute('ex:content','.' + test.innerHTML.replace(' ','_').toLowerCase());
		test.setAttribute('class',"inlines");
		test.innerHTML = '';
    }
    for(var i = 0; i < ex_linkcounter; i++){ //lenses
		var test = document.getElementById("linkcontent"+i);
		var newlink = document.createElement('a');
		newlink.setAttribute('ex:href-subcontent',wgServer + wgScript + '?title={{urlenc(.' + test.innerHTML + ')}}');
		newlink.setAttribute('ex:content','.' + test.innerHTML);
		test.innerHTML = '';
		test.appendChild(newlink);
    }
    for(var i = 0; i < ex_imagecounter; i++){ //lenses
                var test = document.getElementById("imagecontent"+i);
                var newimage = document.createElement('img');
		newimage.setAttribute('ex:src-content','.' + test.innerHTML);
                newimage.setAttribute('height','100');
		test.innerHTML = '';
                test.appendChild(newimage);
    }

    window.exhibit.configureFromDOM();
}

addOnloadHook(createExhibit);


