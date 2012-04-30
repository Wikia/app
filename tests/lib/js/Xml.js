var APOS = "'", QUOTE = '"';
var ESCAPED_QUOTE = { 
	QUOTE: '&quot;',
	APOS: '&apos;'
};

var Xml = {
};

Xml.intro = function() {
	return '<?'+'xml version="1.0" encoding="UTF-8" ?>\n';
};

Xml.element = function(name,content,attributes){
    var att_str = '';
    if (attributes) { // tests false if this arg is missing!
        att_str = Xml.attributes(attributes);
    }
    var xml;
    if (!content){
        xml='<' + name + att_str + ' />';
    }
    else {
        xml='<' + name + att_str + '>' + content + '</'+name+'>';
    }
    return xml;
};

Xml.attributes = function(attributes) {
    var att_value;
    var apos_pos, quot_pos;
    var use_quote, escape, quote_to_escape;
    var att_str;
    var re;
    var result = '';
   
    for (var att in attributes) {
        att_value = new String(attributes[att]);
        
        // Find first quote marks if any
        apos_pos = att_value.indexOf(APOS);
        quot_pos = att_value.indexOf(QUOTE);
       
        // Determine which quote type to use around 
        // the attribute value
        if (apos_pos == -1 && quot_pos == -1) {
            att_str = ' ' + att + "='" + att_value +  "'";
            result += att_str;
            continue;
        }
        
        // Prefer the single quote unless forced to use double
        if (quot_pos != -1 && quot_pos < apos_pos) {
            use_quote = APOS;
        }
        else {
            use_quote = QUOTE;
        }
   
        // Figure out which kind of quote to escape
        // Use nice dictionary instead of yucky if-else nests
        escape = ESCAPED_QUOTE[use_quote];
        
        // Escape only the right kind of quote
        re = new RegExp(use_quote,'g');
        att_str = ' ' + att + '=' + use_quote + 
            att_value.replace(re, escape) + use_quote;
        result += att_str;
    }
    return result
};

Xml.cdata = function( s ) {
	s = new String(s);
	return '<![CDATA[' + s.replace(']]>',']]]]><![CDATA[>') + ']]>';
};
