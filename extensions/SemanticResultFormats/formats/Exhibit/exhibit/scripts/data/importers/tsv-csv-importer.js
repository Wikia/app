Exhibit.TsvCsvImporter = {
};

//the importer will be called with any of the following MIME types
Exhibit.importers["text/comma-separated-values"] = Exhibit.TsvCsvImporter;
Exhibit.importers["text/csv"] = Exhibit.TsvCsvImporter;
Exhibit.importers["text/tab-separated-values"] = Exhibit.TsvCsvImporter;
Exhibit.importers["text/tsv"] = Exhibit.TsvCsvImporter;


Exhibit.TsvCsvImporter.load = function(link, database, cont) {
	var url = typeof link == "string" ? link : link.href;
    url = Exhibit.Persistence.resolveURL(url);
    var type = link.type.substring(link.type.indexOf("/")+1); //type of data (either tsv or csv)
    var hasColumnTitles = Exhibit.getAttribute(link, "hasColumnTitles")!=null? Exhibit.getAttribute(link, "hasColumnTitles") : true; // false if ex:hasColumnTitles is set to false, otherwise the default value is true
    var expressionString = Exhibit.getAttribute(link, "properties"); //null if no ex:properties attribute is given in the html documents
    
	var fError = function(statusText, status, xmlhttp) {
        Exhibit.UI.hideBusyIndicator();
        Exhibit.UI.showHelp(Exhibit.l10n.failedToLoadDataFileMessage(url));
        if (cont) cont();
	};
	    
    var fDone = function(xmlhttp) {
        Exhibit.UI.hideBusyIndicator();
        try {
            var o = null;
            try {
            	var text = xmlhttp.responseText; //the text retrieved from the link
                o = eval(Exhibit.TsvCsvImporter.parseTsvCsv(text, type, expressionString, hasColumnTitles)); //text is converted to Exhibit JSON
            } catch (e) {
                Exhibit.UI.showJsonFileValidation(Exhibit.l10n.badJsonMessage(url, e), url);
			}
            
            if (o != null) { 
                database.loadData(o, Exhibit.Persistence.getBaseURL(url)); 
            }
        } catch (e) {
            SimileAjax.Debug.exception(e, "Error loading tsv/csv data from " + url);
        } finally {
            if (cont) cont();
        }
    };

    Exhibit.UI.showBusyIndicator();
    SimileAjax.XmlHttp.get(url, fError, fDone); 
	
}        

Exhibit.TsvCsvImporter.parseTsvCsv = function(text, format, expressionString, hasColumnTitles) {
		var separator = Exhibit.TsvCsvImporter.formatType(format); // type of separator ("," or "/t")

		var lines = text.split("\n");
        var rest; //array containing the data excluding the column titles
				
		var hasPropertyListAttribute = expressionString!=null; //boolean that is false unless the ex:properties attribute is specified
        var exString;
        var propertyRow;
        
        if (hasPropertyListAttribute){ //if the data is in tsv format, the comma-separated list of the ex:properties attribute must become a tab-separated string 
			exString = Exhibit.TsvCsvImporter.replaceAll(expressionString, ",", separator)
		}
    
        if (hasPropertyListAttribute){ //if the ex:properties attribute is specified, the string becomes the column header row
            propertyRow = exString.split(separator);
            if(hasColumnTitles=="false"){ 
				rest = lines;
			}else{ //if there is a header row in the data file, the first row must be removed and the list of property names given in ex:properties will override it
                rest = lines.slice(1);
            }
        }else{
            if (hasColumnTitles=="false"){ //if there is no header row in the file and no ex:properties attribute is specified, the user is notified that the column names are required
				alert("No header row was given for the property names. Either specify them in the ex:properties attribute or add a header row to the file.");
                return;
			}
			else{
                propertyRow = lines[0].split(separator);
                rest = lines.slice(1);
            }
		}
       
		while (rest[rest.length-1]==""){ //removes empty rows at the end
			rest = rest.slice(0,rest.length-1);
		} 
		var properties = Exhibit.TsvCsvImporter.getProperties(propertyRow);
		var items = Exhibit.TsvCsvImporter.getItems(separator, rest, propertyRow);

		var json = {"properties":properties, "items":items}; //data converted to Exhibit JSON
		return json; 
	}
	
	
Exhibit.TsvCsvImporter.formatType = function(format) { //function that returns the right separator according to the MIME type specified in the html document
		var separator = "";
		if (format == "tab-separated-values" || format == "tsv"){
		    separator = separator.concat("\t");
		}
		else if (format == "comma-separated-values" || format == "csv"){
		    separator = separator.concat(",");
		}else{
            alert("invalid format, must be tsv or csv");
                }
		return separator;
	}
	
Exhibit.TsvCsvImporter.getProperties = function(propertyRow) { //function that parses the array of properties and returns the properties in Exhibit JSON format
		var properties = {};
        var valueTypes = { "text" : true, "number" : true, "item" : true, "url" : true, "boolean" : true, "date" : true };  //possible value types for the properties
		
		for (i = 0; i<propertyRow.length; i++){
			var prop = propertyRow[i];
			var type = "";

			if (prop.match(":")){
				var t = prop.substring(prop.lastIndexOf(":") + 1);
				prop = prop.substring(0, prop.lastIndexOf(":"));
				if (t in valueTypes){
					type = t;
				}else{
					type = "text"; //if the value type that is specified is not contained in valueTypes, it is set to text
				}
			}else{
				type = "text"; //the default value type is text
			}
			properties[prop] = {"valueType":type}; //each property and its corresponding valueType are added to properties object
		}
		return properties
	}
	
	
Exhibit.TsvCsvImporter.getItems = function(separator, rest, propertyRow){
		var items = [];
		var listSeparator = ";";
		
		for (i = 0; i<rest.length; i++){
			var row = rest[i].split(separator);
			
			if (separator==","){ //in csv data, commas within the data are escaped using double-quote characters, for example "Boston, MA" should not be split at the comma
				var quotes = false; //boolean that is set to true when the first double-quote is encountered
				for (var j = 0; j < row.length; j++){ //this for loop fixes each row if the elements were separated incorrectly due to presences of commas in the text
					if (row[j].indexOf('"')==0 && row[j][row[j].length-1]!='"'){
						quotes = true;
						var x = j
						while (quotes){
							joined = [row[x] + "," + row[x+1]];
							row = row.slice(0,x).concat(joined, row.slice(x+2));
							if (row[x][row[x].length-1]=='"'){
								quotes=false; //boolean is set to false when the ending double-quote character is found
							}
						}		
					}
				
				}
			}
			
			
			if (row.length < propertyRow.length){ 
				while (row.length!=propertyRow.length){
					row.push(""); //adds empty strings to the row if some of the ending property fields are missing
				}
			} 
			var item = {}; // variable that stores each item's property values
			
			for (var j = 0; j < propertyRow.length; j++){ 
				var values = row[j];
				
				values = Exhibit.TsvCsvImporter.replaceAll(values, '""', '"'); 
				if(values[0]=='"'){
					values = values.slice(1);
				}
				if(values[values.length-1]=='"'){
					values = values.slice(0,values.length-1);
				}
				
				var fieldValues = values.split(listSeparator); // array of field values for each property
				if (fieldValues.length > 1){
					for (var k = 0; k < fieldValues.length; k++){
						while (fieldValues[k][0]==" "){ //removes leading white spaces from each field value
							fieldValues[k] = fieldValues[k].slice(1);
						}
					}
				}
				var property = propertyRow[j]; //retrieves the corresponding property name
				var fieldname = property.match(":") ? property.substring(0, property.lastIndexOf(":")): property;
				item[fieldname]= fieldValues; //stores the field values associated with the corresponding property in the item object
			}
			items.push(item); //current item is added to the end of the items array
		}
		return items;
}


Exhibit.TsvCsvImporter.replaceAll = function(string, toBeReplaced, replaceWith)	{ //function that replaces all the occurrences of "toBeReplaced" in the string with "replacedWith"
	var regex = "/"+toBeReplaced+"/g";
	return string.replace(eval(regex),replaceWith);
}

	