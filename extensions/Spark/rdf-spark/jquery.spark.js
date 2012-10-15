/*****************************************************************************
 * SPARK -- bringing the semantic web everywhere
 *
 * (c) 2011 Denny Vrandecic, Andreas Harth - KIT
 *
 * SPARK is an extensible JavaScript visualization library for data on the
 * Semantic Web, enabling web developers and authors to easily integrate data
 * in a number of useful visualization.
 *
 * Further information can be found at
 *   http://km.aifb.kit.edu/projects/spark
 * and
 *   http://code.google.com/p/rdf-spark/
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *****************************************************************************/

(function($){
	$.fn.spark = function( options ) {

		var defaults = {
			'endpoint'	: 'http://qcrumb.com/sparql',
			'format'	: 'simple',
			'query'		: '',
			'rdf'		: '',
			'ns'		: {
				'rdf'			: 'http://www.w3.org/1999/02/22-rdf-syntax-ns#',
				'rdfs'			: 'http://www.w3.org/2000/01/rdf-schema#',
				'owl'			: 'http://www.w3.org/2002/07/owl#',
				'rif'			: 'http://www.w3.org/2007/rif#',
				'foaf'			: 'http://xmlns.com/foaf/0.1/',
				'dbpedia'		: 'http://dbpedia.org/resource/',
				'dbpedia-owl'	: 'http://dbpedia.org/ontology/',
				'dbpprop'		: 'http://dbpedia.org/property/',
				'geo'			: 'http://www.w3.org/2003/01/geo/wgs84_pos#',
				'dc'			: 'http://purl.org/dc/terms/'
			}
		};

		// if the parameter is just a string, assume it is the query string
		if (typeof options == 'string') {
			var query = options;
			options = { 'query' : query };
		}
		var settings = defaults;
		if (options) $.extend( true, settings, options );

		var sparqljson = function(index, element) {
			var $this = $(element);

			var request = {}; // { accept : 'application/sparql-results+json' };

			request.query = '';
			$.each(settings.ns, function(prefix, uri) {
				request.query += 'PREFIX ' + prefix + ': <' + uri + '>\n';
			});
			request.query += settings.query;
			if (settings.rdf.length > 0) {
				var froms = '';
				$.each(settings.rdf.split(/\s+/), function(i, from) { froms += '\nFROM <' + from + '>'; });
				request.query = request.query.replace(/\sWHERE(\s)*\{/i, froms + '\nWHERE {');
			}

			// TODO what to do if XML is returned instead of JSON?
			// TODO how to handle failures?
			var responder = function(response) {
				format($this, response, reducer(response), settings);
			};

			//$.getJSON(settings.endpoint, request, responder);

			$.ajaxSetup({
				  'beforeSend': function(xhr) {
				        xhr.setRequestHeader("Accept", "application/sparql-results+json");
				   }
			});

			$.ajax({
				url : settings.endpoint,
				type : 'GET',
				data : request,
				dataType : 'json',
				success : responder,
				error : function() { } // TODO
			});


		};

		return this.each(sparqljson);
	};

	// Gets the format, loads it, and initalizes it, if required
	// TODO what if loading fails?
	// TODO there should be an extensible map of format names to source files
	var format = function(element, response, reduced, settings) {
		var callFormat = function(data, textStatus) {
			format = format in $.spark.format ? format : 'simple';
			//format = 'galleryview';
			//alert(format);
			$.spark.format[format](element, response, reduced, settings);
		};

		var format = settings.format;
		format = /[\.\/]((\w)+)\.js/i.exec(format);
		if (format !== null) {
			if (format.length > 0) {
				format = format[1];
			}
			if (typeof $.spark.format[format] !== 'function') {
				$.getScript(settings.format, callFormat);
			} else {
				callFormat();
			}
		} else {
			format = settings.format;
			callFormat();
		}
	};

	// spark function for manual calls of Spark in JavaScript
	$.spark = function(element, options) { $(element).spark(options); };

	var defaultparam = function(params, paramname, value) {
		if (params.param[paramname] == undefined) params.param[paramname] = value;
		return params;
	};

	// Standard formats
	$.spark.format = {};

	$.spark.format.simple = function(element, result, reduced, params) {
		params = defaultparam(params, 'conjunct', ', ');
		params = defaultparam(params, 'lastconjunct', ', ');
		params = defaultparam(params, 'wrapresult', function(i) { return i; });
		params = defaultparam(params, 'wraprow', function(i) { return i; });

		var lines = [];

		$.each(reduced, function(item, values) {
			var line = (values.label == undefined)? item : values.label;
			if (values.link != undefined) line = '<a href="' + values.link + '">' + line + '</a>';
			lines.push( params.param.wraprow(line) );
		});

		var html = lines.join( params.param.conjunct );

		if ( lines.length != 0 ) {
			html += params.param.lastconjunct;
		}

		element.html(params.param.wrapresult(html));
	};

	$.spark.format.ul = function(element, result, reduced, params) {
		params = defaultparam(params, 'conjunct', '');
		params = defaultparam(params, 'lastconjunct', '');
		params = defaultparam(params, 'wrapresult', function(i) { return '<ul>' + i + '</ul>'; });
		params = defaultparam(params, 'wraprow', function(i) { return '<li>' + i + '</li>'; });
		$.spark.format.simple(element, result, reduced, params);
	};

	$.spark.format.count = function(element, result, reduced, params) {
		var count = 0;
		$.each(reduced, function(item, values) { count++; });
		element.html(count);
	};

	// Turns a SPARQL Result Set in JSON into a visualization set
	// It basically reduces everything to the first variable, and eliminates
	// the combinatoric explosion of the relational result set.
	// TODO currently only one level is supported, add several levels by _ prefix or some other way
	var reducer = function( result ) {
		if (result.head.vars.length == 0) return undefined;
		var firstvar = result.head.vars[0];
		if (result.results.bindings.length == 0) return null;

		var reduced = {};
		$.each(result.results.bindings, function(index, val) {
			var v = val[firstvar].value;
			if (!(v in reduced)) reduced[v] = {};
			$.each(val, function(variable, binding) {
				if (variable == firstvar)
					return true;
				if (!(variable in reduced[v]))
					reduced[v][variable] = [];
				if ($.inArray(binding.value, reduced[v][variable]) == -1) {
					reduced[v][variable].push(binding.value);
				}
			});
		});
		// TODO for debugging only
		//var x = {}; x.result = result; x.reduced = reduced; $.dump(x);
		return reduced;
	};

	// To be executed automatically on an element with the spark class.
	// Gets all relevant options and then calls the actual spark function.
	// Param: list of elements to be called on.
	var spark_markup = function(elements) {
		elements.each(function() {
			var $this = $(this);
			// get options
			// TODO: get options from enclosing elements
			var options = {};
			options.param = {};

			$.each($this.mapAttributes('data-spark-'), function(key, value) {
				var path = key.split('-').slice(2, 4);
				if (path.length > 1) {
					if (options[path[0]] == undefined) options[path[0]] = {};
					options[path[0]][path[1]] = value;
				} else {
					options[path[0]] = value;
				}
			});

			$this.spark(options);
		});
	};

	// mapAttributes, code taken from Michael Riddle, 2010, MIT license
	$.fn.mapAttributes = function(prefix) {
		var maps = [];
		$(this).each(function() {
			var map = {};
			for(var key in this.attributes) {
				if(!isNaN(key)) {
					if(!prefix || this.attributes[key].name.substr(0,prefix.length) == prefix) {
						map[this.attributes[key].name] = this.attributes[key].value;
					}
				}
			}
			maps.push(map);
		});
		return (maps.length > 1 ? maps : maps[0]);
	};

	$(document).ready(function() { spark_markup($('.spark')); });
})(jQuery);
