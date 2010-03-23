/*
 * sf_autocomplete()
 *
 * Creates an autocompletion widget, using the Yahoo! UI (YUI) library,
 * for the specified form input, using the specified values and delimiter
 * (in the case that it's a multiple-values autocompletion)
 */
function sf_autocomplete(input_name, container_name, values, api_url, data_type, delimiter, data_source) {
    // Instantiate JS Function DataSource - the type depends on whether
    // it gets autocompletion values locallly or remotely (through Ajax);
    // which in turn is set depending on whether the 'values' or the
    // 'data_type' and 'api_url' parameters are set
    if (values != null) {
        this.oACDS = new YAHOO.widget.DS_JSFunction(autocompleteFunctionGenerator(values));
        this.oACDS.maxCacheEntries = 0;
        this.oAutoComp = new YAHOO.widget.AutoComplete(input_name, container_name, this.oACDS);
    } else {
        var myServer = api_url;
        var mySchema = ["sfautocomplete", "title"];
        this.oACDS = new YAHOO.widget.DS_XHR(myServer, mySchema);
        this.oACDS.scriptQueryParam = "substr";
        if (data_type == 'property')
            this.oACDS.scriptQueryAppend = "action=sfautocomplete&format=json&property=" + data_source;
        else if (data_type == 'relation')
            this.oACDS.scriptQueryAppend = "action=sfautocomplete&format=json&relation=" + data_source;
        else if (data_type == 'attribute')
            this.oACDS.scriptQueryAppend = "action=sfautocomplete&format=json&attribute=" + data_source;
        else if (data_type == 'category')
            this.oACDS.scriptQueryAppend = "action=sfautocomplete&format=json&category=" + data_source;
        else if (data_type == 'namespace')
            this.oACDS.scriptQueryAppend = "action=sfautocomplete&format=json&namespace=" + data_source;
        else if (data_type == 'external_url')
            this.oACDS.scriptQueryAppend = "action=sfautocomplete&format=json&external_url=" + data_source;
        this.oACDS.responseType = YAHOO.widget.DS_XHR.TYPE_JSON;
        this.oAutoComp = new YAHOO.widget.AutoComplete(input_name, container_name, this.oACDS);
    }

    // Instantiate AutoComplete
    this.oAutoComp.alwaysShowContainer = false;
    this.oAutoComp.minQueryLength = 1;
    this.oAutoComp.maxResultsDisplayed = 20;
    this.oAutoComp.animHoriz = false;
    this.oAutoComp.animVert = false;
    this.oAutoComp.useIFrame = true;
    if (delimiter != '') {
        this.oAutoComp.delimChar = delimiter;
    }
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
        var sKeyBefore = sKey.substr(0, sKeyIndex);
        var sKeyQuery = sKey.substr(sKeyIndex, sQuery.length); // the query itself
        var sKeyAfter = sKey.substr(sKeyIndex + sQuery.length); // the rest of the result

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
function autocompleteFunctionGenerator(values_list) {
    return function (sQuery) {
        var primaryResults = [];
        var secondaryResults = [];
        if (sQuery && sQuery.length > 0) {
            // in some cases, decodeURI() doesn't handle certain characters
            // correctly - replace them manually
            query_str = decodeURI(sQuery).replace(/(%3A)/g, ":").toLowerCase();
            query_str = query_str.replace(/(%24)/g, "$");
            query_str = query_str.replace(/(%2f)/g, "/");
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

/*
 * The following two functions are not related to YUI or autocompletion -
 * there just wasn't a better place to put them, and it seemed like overkill
 * to create a separate file just for them
 */

// show the relevant div if any one of the relevant options are passed in
// to the relevant dropdown - otherwise, hide it
function showIfSelected(input_id, options_array, div_id) {
	the_input = document.getElementById(input_id);
	the_div = document.getElementById(div_id);
        for (var i in options_array) {
		if (the_input.value == options_array[i]) {
			the_div.style.display = 'block';
			return;
		}
	}
	the_div.style.display = 'none';
}

// show the relevant div if any one of the relevant checkboxes are
// checked - otherwise, hide it
function showIfChecked(checkbox_inputs, div_id) {
	the_div = document.getElementById(div_id);
        for (var i in checkbox_inputs) {
		checkbox = document.getElementById(checkbox_inputs[i]);
		if (checkbox.checked) {
			the_div.style.display = 'block';
			return;
		}
	}
	the_div.style.display = 'none';
}
