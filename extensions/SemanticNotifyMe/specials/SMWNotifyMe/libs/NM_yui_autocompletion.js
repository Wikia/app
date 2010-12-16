/*
 * nm_autocomplete()
 *
 * Creates an autocompletion widget, using the Yahoo! UI (YUI) library,
 * for the specified form input, using the specified values and delimiter
 * (in the case that it's a multiple-values autocompletion)
 */

function nm_autocomplete(input_name, container_name, values, delimiter) {
	if (values != null) {
		this.oACDS = new YAHOO.widget.DS_JSFunction(nmAutocompleteFunctionGenerator(values));
		this.oACDS.maxCacheEntries = 0;
		this.oAutoComp = new YAHOO.widget.AutoComplete(input_name, container_name, this.oACDS);
	}

	// Instantiate AutoComplete
	this.oAutoComp.alwaysShowContainer = false;
	//this.oAutoComp.minQueryLength = 1;
	this.oAutoComp.maxResultsDisplayed = nmMaxResultsDisplayed;
	this.oAutoComp.animHoriz = false;
	this.oAutoComp.animVert = false;
	if (delimiter != '') {
		this.oAutoComp.delimChar = delimiter;
	}
	this.oAutoComp.minQueryLength = 0;
	this.oAutoComp.textboxFocusEvent.subscribe(
		function (sType, aArgs) {
			var oAutoComp = aArgs[0];
			oAutoComp.sendQuery("");
		});

	// don't set IFrame, which is meant to improve formatting on Internet
	// Explorer - currently, it only messes up the formatting
	//this.oAutoComp.useIFrame = true;
	// This function returns markup that bolds the original query
	this.oAutoComp.formatResult = function(aResultItem, sQuery) {
		var sKey = aResultItem[0]; // the entire result key
		var sKeyIndex = sKey.toLowerCase().indexOf(sQuery.toLowerCase());
		// if it's not the very beginning, make sure the query string
		// comes after a space
		if (sKeyIndex > 0) {
			sKeyIndex = sKey.toLowerCase().indexOf(' ' + sQuery.toLowerCase()) + 1;
		}
		var sKeyBefore = sKey;
		var sKeyQuery = "";
		var sKeyAfter = "";
		if (sKeyIndex >= 0) {
			sKeyBefore = sKey.substr(0, sKeyIndex);
			sKeyQuery = sKey.substr(sKeyIndex, sQuery.length); // the query itself
			sKeyAfter = sKey.substr(sKeyIndex + sQuery.length); // the rest of the result
		}

		var aMarkup = sKeyBefore +
			"<span style='font-weight:bold'>" +
			sKeyQuery +
			"</span>" +
			sKeyAfter;
		return aMarkup;
	};

	// Show custom message if no results found
	this.myOnDataReturn = function(sType, aArgs) {
		var oAutoComp = aArgs[0];
		var sQuery = aArgs[1];
		var aResults = aArgs[2];

		if(aResults.length == 0) {
			oAutoComp.setBody("<div>No matching results</div>");
		}
	};

	var itemSelectHandler = function (oAutoComp, listItem, dataArray) {
	}

	// neither of these events are necessary to subscribe to yet
	//this.oAutoComp.itemSelectEvent.subscribe(itemSelectHandler);
	//this.oAutoComp.dataReturnEvent.subscribe(this.myOnDataReturn);

	// Preload content in the container
	//this.oAutoComp.sendQuery("");
};

/*
 * Helper function - returns a function that returns, for a given query
 * string, an array of values that match it
 */
function nmAutocompleteFunctionGenerator(values_list) {
	return function (sQuery) {
		var primaryResults = [];
		var secondaryResults = [];
		if (sQuery && sQuery.length > 0) {
			// in some cases, decodeURI() doesn't handle colons correctly -
			// replace them manually
			query_str = decodeURI(sQuery).replace(/(%3A)/g, ":").toLowerCase();
			for (var i = 0; i < values_list.length; i++) {
				subarray = values_list[i];
				// workaround for strange IE bug
				var name;
				if (subarray.length > 1) {
					name = subarray;
				} else {
					name = subarray[0];
				}
				name_str = name.toLowerCase();
				var sKeyIndex = name_str.indexOf(query_str);
				if (sKeyIndex == 0) {
					primaryResults.push(subarray);
				} else {
					var index2 = name_str.indexOf(" " + query_str);
					if (index2 >= 0) {
						secondaryResults.push(subarray);
					}
				}
			}
			var aResults = primaryResults.concat(secondaryResults);
			// return no values if there's only one value, and the query
			// exactly matches it
			if (aResults.length == 1 && query_str.length == aResults[0][0].length) {
				return [];
			} else {
				return aResults;
			}
		}
		// Empty queries return all values
		else {
			return values_list;
		}
	}
}

function nmAttachAutocompleteToAllFields()
{
	var inputs = document.getElementsByName("nmdelegate");
	var y;
	for (y = 0; y < inputs.length; y++) {
		nmAttachAutocompleteToField(inputs[y].id);
	}
	nmAttachAutocompleteToField("nmd_new");
}

var nmautocompletestrings = new Array();
var nmMaxResultsDisplayed = 10;

//Activate autocomplete functionality for the specified field
function nmAttachAutocompleteToField(input_id)
{
	var div_id = input_id.replace(/nmd_/g, 'nmdiv_');
	var delimiter = ",";
	nm_autocomplete(input_id, div_id, nmautocompletestrings, delimiter);
}

YAHOO.util.Event.addListener(window, 'load', nmAttachAutocompleteToAllFields);
