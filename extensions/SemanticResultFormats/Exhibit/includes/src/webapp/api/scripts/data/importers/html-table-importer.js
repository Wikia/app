/*==================================================
 *  Exhibit.HtmlTableImporter
 *==================================================
 */

Exhibit.HtmlTableImporter = {
};
Exhibit.importers["text/html"] = Exhibit.HtmlTableImporter;

Exhibit.HtmlTableImporter.load = function(link, database, cont) {
    var url = typeof link == "string" ? link : link.href;
    if (url.substr(0,1) == "#") {
        try {
            var id = /#(.*)/.exec(f)[1];
            var table = document.getElementById(id);
            table.style.display = "none"; // as we are replacing it with the exhibit UI

            Exhibit.HtmlTableImporter.loadTable(table, database);
        } catch (e) {
            SimileAjax.Debug.exception(e);
        } finally {
            if (cont) {
                cont();
            }
        }
    } else if (typeof link != "string") {
        var xpath = link.getAttribute('ex:xpath'); 
        var columns = (link.getAttribute('ex:columns')).split(',');
        var babelURL = "http://simile.mit.edu/babel/html-extractor?" + [
            "xpath=" + xpath,
            "url=" + encodeURIComponent(url)
        ].join("&");
        var fConvert = function(string) {
            var div = document.createElement("div");
            div.innerHTML = string;
            var table = div.firstChild;
            
            var th, ths = table.getElementsByTagName("th");
            for( col = 0; th = ths[col]; col++ ) {
                var label = columns[col];
                th.setAttribute('ex:name', label);
            }
            
            Exhibit.HtmlTableImporter.loadTable(table, database);
            return {};
        }
        return Exhibit.JSONPImporter.load(babelURL, database, cont, fConvert);
    } else {
        if (cont) {
            cont();
        }
    }
}

Exhibit.HtmlTableImporter.loadTable = function(table, database) {

    var textOf = function( n ) { return n.textContent || n.innerText || ""; };
    var readAttributes = function( node, attributes ) {
        var result = {}, found = false, attr, value, i;
        for( i = 0; attr = attributes[i]; i++ ) {
            value = Exhibit.getAttribute( node, attr );
            if( value ) {
                        result[attr] = value;
                        found = true;
            }
        }
        return found && result;
    }

    // FIXME: it's probably a better idea to ask database.js for these lists:
    var typelist = [ "uri", "label", "pluralLabel" ];
    var proplist = [ "uri", "valueType", // [text|number|date|boolean|item|url|textwithlink]
                     "label", "reverseLabel",
                     "pluralLabel", "reversePluralLabel",
                     "groupingLabel", "reverseGroupingLabel" ];
    var columnProps = [ "valueParser", "arity" ];

    var parsed = {}; // accumulator of all data we scrape up (for loadData)
    var type = Exhibit.getAttribute( table, 'type' );
    var types = type && readAttributes( table, typelist );
    if( types ) {
        parsed.types = {};
        parsed.types[type] = types;
    }

    var fields = [], props = {}, columnData = [], row, col;
    var tr, trs = table.getElementsByTagName("tr");
    var th, ths = trs[0].getElementsByTagName("th");
    for( col = 0; th = ths[col]; col++ ) {
        var field = textOf( th ).trim();
        var hastextwithlink = false;
        var attr = readAttributes( th, proplist );
        var name = Exhibit.getAttribute( th, 'name' );
        if( name ) {
            attr = attr || {};
            attr.label = attr.label || field;
            field = name;
        }
        if( attr ) {
            props[field] = attr;
            if (props[field].valueType == "textwithlink") {
                props[field].valueType = "text";
                props[(field + "-link")] = {valueType : "url"};
                hastextwithlink = true;
            }
            parsed.properties = props;
        }
        fields.push( field );
        attr = readAttributes( th, columnProps ) || {};
        if( attr.valueParser && attr.valueParser in window ) {
            attr.valueParser = window[attr.valueParser];
        } else { // provide a default valueParser:
            if( attr.arity == "single" ) {
                attr.valueParser = function( text, node, rowNo, colNo ) {
                    return text.trim();
                };
            } else {
                attr.valueParser = function( text, node, rowNo, colNo ) {
                    if( text.indexOf(';') == -1 )
                        return text.trim();

                    var data = text.split(';');
                    for( var i = 0; i<data.length; i++ )
                        data[i] = data[i].trim();

                    return data;
                };
                if (hastextwithlink) { 
                    var fallback = attr.valueParser; 
                    attr.valueParser = function( text, node, rowNo, colNo ) { 
                        var links = node.getElementsByTagName("a"); 
                        if( !links.length ) { return fallback( text, node, rowNo, colNo ); }
                        var data={};
                        data[fields[colNo]] = text.trim();
                        data[(fields[colNo] + "-link") ] = links[0].href;
                        return data;
                    } 
                }
            }
        }
        columnData[col] = attr;
    }

    var img, imgs = table.getElementsByTagName("img");
    while( img = imgs[0] ) // replace any images with their respective URLs
        img.parentNode.replaceChild( document.createTextNode( img.src ), img );

    var items = [], td, raw;
    for( row = 1; tr = trs[row]; row++ ) {
        var item = {};
        var tds = tr.getElementsByTagName("td");
        for( col = 0; td = tds[col]; col++ ) {
            var raw = textOf( td );
            data = columnData[col].valueParser( raw, td, row, col );
            if( data == null || raw === "" ) {
                continue;
            }
            if( typeof data == 'object' && !(data instanceof Array) ) {
                for( var property in data ) {
                    item[property] = data[property];
                }
            } else {
                item[fields[col]] = data;
            }
        }

        if( type )
            item.type = type;

        items.push( item );
        parsed.items = items;
    }

    database.loadData( parsed, Exhibit.Persistence.resolveURL(location.href) );
};
