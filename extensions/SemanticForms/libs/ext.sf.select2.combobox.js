/*
 * ext.sf.select2.comboboxjs
 *
 * Javascript utility class to handle autocomplete
 * for combobox input type using Select2 JS library
 *
 * @file
 *
 * @licence GNU GPL v2+
 * @author Jatin Mehta
 */

( function( $, mw, sf ) {
	'use strict';

	/**
	 * Inheritance class for the sf.select2 constructor
	 *
	 *
	 * @class
	 */
	sf.select2 = sf.select2 || {};

	/**
	 * Class constructor
	 *
	 *
	 * @class
	 * @constructor
	 */
	sf.select2.combobox = function() {

	};

	var combobox_proto = new sf.select2.base();

	/*
	 * Returns options to be set by select2
	 *
	 * @return {object} opts
	 *
	 */
	combobox_proto.setOptions = function() {
		var input_id = this.id;
		var opts = {};
		input_id = "#" + input_id;
		var input_tagname = $(input_id).prop( "tagName" );
		var autocomplete_opts = this.getAutocompleteOpts();

		if ( autocomplete_opts.autocompletedatatype !== undefined ) {
			opts.ajax = this.getAjaxOpts();
			opts.minimumInputLength = 1;
			opts.formatInputTooShort = mw.msg( "sf-select2-input-too-short", opts.minimumInputLength );
			opts.formatSelection = this.formatSelection;
			opts.escapeMarkup = function (m) { return m; };
		} else if ( input_tagname == "INPUT" ) {
			opts.data = this.getData( autocomplete_opts.autocompletesettings );
		}
		var sfgAutocompleteOnAllChars = mw.config.get( 'sfgAutocompleteOnAllChars' );
		if ( !sfgAutocompleteOnAllChars ) {
			opts.matcher = function( term, text ) {
				var no_diac_text = sf.select2.base.prototype.removeDiacritics( text );
				var position = no_diac_text.toUpperCase().indexOf(term.toUpperCase());
				var position_with_space = no_diac_text.toUpperCase().indexOf(" " + term.toUpperCase());
				if ( (position != -1 && position === 0 ) ||  position_with_space != -1 ) {
					return true;
				} else {
					return false;
				}
			};
		}
		opts.formatResult = this.formatResult;
		opts.formatSearching = mw.msg( "sf-select2-searching" );
		opts.formatNoMatches = mw.msg( "sf-select2-no-matches" );
		opts.placeholder = $(input_id).attr( "placeholder" );
		if ( $(input_id).attr( "existingvaluesonly" ) !== "true" && input_tagname == "INPUT" ) {
			opts.createSearchChoice = function( term, data ) { if ( $(data).filter(function() { return this.text.localeCompare( term )===0; }).length===0 ) {return { id:term, text:term };} };
		}
		if ( $(input_id).val() !== "" && input_tagname == "INPUT" ) {
			opts.initSelection = function ( element, callback ) { var data = {id: element.val(), text: element.val()}; callback(data); };
		}
		opts.allowClear = true;
		var size = $(input_id).attr("size");
		if ( size === undefined ) {
			size = 35; //default value
		}
		opts.containerCss = { 'min-width': size * 6 };
		opts.containerCssClass = 'sf-select2-container';
		opts.dropdownCssClass = 'sf-select2-dropdown';

		return opts;
	};
	/*
	 * Returns data to be used by select2 for combobox autocompletion
	 *
	 * @param {string} autocompletesettings
	 * @return {associative array} values
	 *
	 */
	combobox_proto.getData = function( autocompletesettings ) {
		var input_id = "#" + this.id;
		var values = [{id: 0, text: ""}];
		var dep_on = this.dependentOn();
		var i, data;
		if ( dep_on === null ) {
			if ( autocompletesettings == 'external data' ) {
				var name = $(input_id).attr(this.nameAttr($(input_id)));
				var sfgEDSettings = mw.config.get( 'sfgEDSettings' );
				var edgValues = mw.config.get( 'edgValues' );
				data = {};
				if ( sfgEDSettings[name].title !== undefined && sfgEDSettings[name].title !== "" ) {
					data.title = edgValues[sfgEDSettings[name].title];
					i = 0;
					if ( data.title !== undefined && data.title !== null ) {
						data.title.forEach(function() {
							values.push({
							id: i + 1, text: data.title[i]
						    });
						    i++;
						});
					}
					if ( sfgEDSettings[name].image !== undefined && sfgEDSettings[name].image !== "" ) {
						data.image = edgValues[sfgEDSettings[name].image];
						i = 0;
						if ( data.image !== undefined && data.image !== null ) {
							data.image.forEach(function() {
								values[i+1].image = data.image[i];
								i++;
							});
						}
					}
					if ( sfgEDSettings[name].description !== undefined && sfgEDSettings[name].description !== "" ) {
						data.description = edgValues[sfgEDSettings[name].description];
						i = 0;
						if ( data.description !== undefined && data.description !== null ) {
							data.description.forEach(function() {
								values[i+1].description = data.description[i];
								i++;
							});
						}
					}
				}

			} else {
				var sfgAutocompleteValues = mw.config.get( 'sfgAutocompleteValues' );
				data = sfgAutocompleteValues[autocompletesettings];
				//Convert data into the format accepted by Select2
				if (data !== undefined && data !== null ) {
					var index = 1;
					for (var key in data) {
						values.push({
							id: index, text: data[key]
						});
						index++;
					}
				}
			}
		} else { //Dependent field autocompletion
			var dep_field_opts = this.getDependentFieldOpts( dep_on );
			var my_server = mw.config.get( 'wgScriptPath' ) + "/api.php";
			my_server += "?action=sfautocomplete&format=json";
			// URL depends on whether Cargo or Semantic MediaWiki
			// is being used.
			if ( dep_field_opts.prop.indexOf('|') == -1 ) {
				// SMW
				my_server += "&property=" + dep_field_opts.prop + "&baseprop=" + dep_field_opts.base_prop + "&basevalue=" + dep_field_opts.base_value;
			} else {
				// Cargo
				var cargoTableAndFieldStr = dep_field_opts.prop;
				var cargoTableAndField = cargoTableAndFieldStr.split('|');
				var cargoTable = cargoTableAndField[0];
				var cargoField = cargoTableAndField[1];
				var baseCargoTableAndFieldStr = dep_field_opts.base_prop;
				var baseCargoTableAndField = baseCargoTableAndFieldStr.split('|');
				var baseCargoTable = baseCargoTableAndField[0];
				var baseCargoField = baseCargoTableAndField[1];
				my_server += "&cargo_table=" + cargoTable + "&cargo_field=" + cargoField + "&base_cargo_table=" + baseCargoTable + "&base_cargo_field=" + baseCargoField + "&basevalue=" + dep_field_opts.base_value;
			}
			//alert(my_server);
			$.ajax({
				url: my_server,
				dataType: 'json',
				async: false,
				success: function(data) {
					var id = 1;
					//Convert data into the format accepted by Select2
					data.sfautocomplete.forEach( function(item) {
						values.push({
						 	id: id++, text: item.title
						});
					});
					return values;
				}
			});
		}

		return values;
	};
	/*
	 * Returns ajax options to be used by select2 for
	 * remote autocompletion of combobox
	 *
	 * @return {object} ajaxOpts
	 *
	 */
	combobox_proto.getAjaxOpts = function() {
		var autocomplete_opts = this.getAutocompleteOpts();
		var data_source = autocomplete_opts.autocompletesettings.split(',')[0];
		var my_server = mw.util.wikiScript( 'api' );
		var autocomplete_type = autocomplete_opts.autocompletedatatype;
		if ( autocomplete_type == 'cargo field' ) {
			var table_and_field = data_source.split('|');
			my_server += "?action=sfautocomplete&format=json&cargo_table=" + table_and_field[0] + "&cargo_field=" + table_and_field[1];
		} else {
			my_server += "?action=sfautocomplete&format=json&" + autocomplete_opts.autocompletedatatype + "=" + data_source;
		}

		var ajaxOpts = {
			url: my_server,
			dataType: 'json',
			data: function (term) {
				return {
					substr: term, // search term
				};
			},
			results: function (data, page, query) { // parse the results into the format expected by Select2.
				var id = 0;
				if (data.sfautocomplete !== undefined) {
					data.sfautocomplete.forEach( function(item) {
						item.id = id++;
						item.text = item.title;
					});
					return {results: data.sfautocomplete};
				} else {
					return {results: []};
				}
			}
		};

		return ajaxOpts;
	};
	/*
	 * Used to set the value of the HTMLInputElement
	 * when there is a change in the select2 value
	 *
	 */
	combobox_proto.onChange = function() {
		var self = this;
		var data = $(this).select2( "data" );
		if (data !== null) {
			$(this).val( data.text );
		} else {
			$(this).val( '' );
		}

		// Set the corresponding values for any other field
		// in the form which is dependent on this element
		var cmbox = new sf.select2.combobox();
		var dep_on_me = $.unique(cmbox.dependentOnMe( $(this) ));
		dep_on_me.forEach( function( dependent_field_name ) {
			var dependent_field;
			if ( cmbox.partOfMultiple( $(self) ) ) {
				dependent_field = $(self).closest( ".multipleTemplateInstance" )
					.find( '[origname ="' + dependent_field_name + '" ]' );
			} else {
				dependent_field = $('[name ="' + dependent_field_name + '" ]');
			}
			cmbox.dependentFieldAutocompleteHandler( dependent_field, self );
		});
	};
	/*
	 * Handles dependent field autocompletion
	 *
	 * @param {HTMLElement} dependent_field
	 * @param {HTMLElement} dependent_on
	 *
	 */
	combobox_proto.dependentFieldAutocompleteHandler = function( dependent_field, dependent_on ) {
		var class_name = $(dependent_field).attr( 'class' );
		var cmbox = new sf.select2.combobox();
		var tokens = new sf.select2.tokens();

		if ( class_name.indexOf( 'sfComboBox' ) != -1 ) {
			cmbox.refresh(dependent_field);
		} else  if ( class_name.indexOf( 'sfTokens' ) != -1 ) {
			tokens.refresh(dependent_field);
		} else if ( class_name.indexOf( 'createboxInput' ) != -1 ) {
			var name_attr = cmbox.nameAttr($(dependent_on));
			var field_name = $(dependent_field).attr(name_attr),
			base_field_name = $(dependent_on).attr(name_attr),
			base_value = $(dependent_on).val();
			$(dependent_field).setDependentAutocompletion(field_name, base_field_name, base_value);
		}

	};

	sf.select2.combobox.prototype = combobox_proto;

} )( jQuery, mediaWiki, semanticforms );
