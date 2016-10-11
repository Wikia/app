/**
 * SemanticForms.js
 *
 * Javascript utility functions for the Semantic Forms extension.
 *
 * @author Yaron Koren
 * @author Sanyam Goyal
 * @author Stephan Gambke
 * @author Jeffrey Stuckman
 * @author Harold Solbrig
 * @author Eugene Mednikov
 */
/*global sfgShowOnSelect, sfgFieldProperties, sfgCargoFields, sfgDependentFields, validateAll, alert, sf*/

// Activate autocomplete functionality for the specified field
( function ( $, mw ) {

/* extending jQuery functions for custom highlighting */
$.ui.autocomplete.prototype._renderItem = function( ul, item) {

	var delim = this.element.context.delimiter;
	var term;
	if ( delim === null ) {
		term = this.term;
	} else {
		term = this.term.split( delim ).pop();
	}
	var re = new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + term.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi, "\\$1") + ")(?![^<>]*>)(?![^&;]+;)", "gi");
	var loc = item.label.search(re);
	var t;
	if (loc >= 0) {
		t = item.label.substr(0, loc) + '<strong>' + item.label.substr(loc, term.length) + '</strong>' + item.label.substr(loc + term.length);
	} else {
		t = item.label;
	}
	return $( "<li></li>" )
		.data( "item.autocomplete", item )
		.append( " <a>" + t + "</a>" )
		.appendTo( ul );
};

$.fn.attachAutocomplete = function() {
	return this.each(function() {
		// Get all the necessary values from the input's "autocompletesettings"
		// attribute. This should probably be done as three separate attributes,
		// instead.
		var field_string = $(this).attr("autocompletesettings");

		if ( typeof field_string === 'undefined' ) {
			return;

		}

		var field_values = field_string.split(',');
		var delimiter = null;
		var data_source = field_values[0];
		if (field_values[1] === 'list') {
			delimiter = ",";
			if (field_values[2] !== null && field_values[2] !== '' && field_values[2] !== undefined) {
				delimiter = field_values[2];
			}
		}

		// Modify the delimiter. If it's "\n", change it to an actual
		// newline - otherwise, add a space to the end.
		// This doesn't cover the case of a delimiter that's a newline
		// plus something else, like ".\n" or "\n\n", but as far as we
		// know no one has yet needed that.
		if ( delimiter !== null && delimiter !== '' && delimiter !== undefined ) {
			if ( delimiter === "\\n" ) {
				delimiter = "\n";
			} else {
				delimiter += " ";
			}
		}
		// Store this value within the object, so that it can be used
		// during highlighting of the search term as well.
		this.delimiter = delimiter;

		/* extending jQuery functions */
		$.extend( $.ui.autocomplete, {
			filter: function(array, term) {
				var sfgAutocompleteOnAllChars = mw.config.get( 'sfgAutocompleteOnAllChars' );
				var matcher;
				if ( sfgAutocompleteOnAllChars ) {
					matcher = new RegExp($.ui.autocomplete.escapeRegex(term), "i" );
				} else {
					matcher = new RegExp("\\b" + $.ui.autocomplete.escapeRegex(term), "i" );
				}
				return $.grep( array, function(value) {
					return matcher.test( value.label || value.value || value );
				});
			}
		} );

		var values = $(this).data('autocompletevalues');
		if ( !values ) {
			var sfgAutocompleteValues = mw.config.get( 'sfgAutocompleteValues' );
			values = sfgAutocompleteValues[field_string];
		}
		var split = function (val) {
			return val.split(delimiter);
		};
		var extractLast = function (term) {
			return split(term).pop();
		};
		if (values !== null && values !== undefined) {
			// Local autocompletion

			if (delimiter !== null && delimiter !== undefined) {
				// Autocomplete for multiple values

				var thisInput = $(this);

				$(this).autocomplete({
					minLength: 0,
					source: function(request, response) {
						// We need to re-get the set of values, since
						// the "values" variable gets overwritten.
						values = thisInput.data( 'autocompletevalues' );
						if ( !values ) {
							values = sfgAutocompleteValues[field_string];
						}
						response($.ui.autocomplete.filter(values, extractLast(request.term)));
					},
					focus: function() {
						// prevent value inserted on focus
						return false;
					},
					select: function(event, ui) {
						var terms = split( this.value );
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push( ui.item.value );
						// add placeholder to get the comma-and-space at the end
						terms.push("");
						this.value = terms.join(delimiter);
						return false;
					}
				});

			} else {
				// Autocomplete for a single value
				$(this).autocomplete({
					source:values
				});
			}
		} else {
			// Remote autocompletion.
			var myServer = mw.util.wikiScript( 'api' );
			var data_type = $(this).attr("autocompletedatatype");
			myServer += "?action=sfautocomplete&format=json&" + data_type + "=" + data_source;

			if (delimiter !== null && delimiter !== undefined) {
				$(this).autocomplete({
					source: function(request, response) {
						$.getJSON(myServer, {
							substr: extractLast(request.term)
						}, function( data ) {
							response($.map(data.sfautocomplete, function(item) {
								return {
									value: item.title
								};
							}));
						});
					},
					search: function() {
						// custom minLength
						var term = extractLast(this.value);
						if (term.length < 1) {
							return false;
						}
					},
					focus: function() {
						// prevent value inserted on focus
						return false;
					},
					select: function(event, ui) {
						var terms = split( this.value );
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push( ui.item.value );
						// add placeholder to get the comma-and-space at the end
						terms.push("");
						this.value = terms.join(delimiter);
						return false;
					}
				} );
			} else {
				$(this).autocomplete({
					minLength: 1,
					source: function(request, response) {
						$.ajax({
							url: myServer,
							dataType: "json",
							data: {
								substr:request.term
							},
							success: function( data ) {
								response($.map(data.sfautocomplete, function(item) {
									return {
										value: item.title
									};
								}));
							}
						});
					},
					open: function() {
						$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
					},
					close: function() {
						$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
					}
				} );
			}
		}
	});
};



/*
 * Functions to register/unregister methods for the initialization and
 * validation of inputs.
 */

// Initialize data object to hold initialization and validation data
function setupSF() {

	$("#sfForm").data("SemanticForms",{
		initFunctions : [],
		validationFunctions : []
	});

}

// Register a validation method
//
// More than one method may be registered for one input by subsequent calls to
// SemanticForms_registerInputValidation.
//
// Validation functions and their data are stored in a numbered array
//
// @param valfunction The validation functions. Must take a string (the input's id) and an object as parameters
// @param param The parameter object given to the validation function
$.fn.SemanticForms_registerInputValidation = function(valfunction, param) {

	if ( ! this.attr("id") ) {
		return this;
	}

	if ( ! $("#sfForm").data("SemanticForms") ) {
		setupSF();
	}

	$("#sfForm").data("SemanticForms").validationFunctions.push({
		input : this.attr("id"),
		valfunction : valfunction,
		parameters : param
	});

	return this;
};

// Register an initialization method
//
// More than one method may be registered for one input by subsequent calls to
// SemanticForms_registerInputInit. This method also executes the initFunction
// if the element referenced by /this/ is not part of a multipleTemplateStarter.
//
// Initialization functions and their data are stored in a associative array
//
// @param initFunction The initialization function. Must take a string (the input's id) and an object as parameters
// @param param The parameter object given to the initialization function
// @param noexecute If set, the initialization method will not be executed here
$.fn.SemanticForms_registerInputInit = function( initFunction, param, noexecute ) {

	// return if element has no id
	if ( ! this.attr("id") ) {
		return this;
	}

	// setup data structure if necessary
	if ( ! $("#sfForm").data("SemanticForms") ) {
		setupSF();
	}

	// if no initialization function for this input was registered yet,
	// create entry
	if ( ! $("#sfForm").data("SemanticForms").initFunctions[this.attr("id")] ) {
		$("#sfForm").data("SemanticForms").initFunctions[this.attr("id")] = [];
	}

	// record initialization function
	$("#sfForm").data("SemanticForms").initFunctions[this.attr("id")].push({
		initFunction : initFunction,
		parameters : param
	});

	// execute initialization if input is not part of multipleTemplateStarter
	// and if not forbidden
	if ( this.closest(".multipleTemplateStarter").length === 0 && !noexecute) {
		var input = this;
		// ensure initFunction is only exectued after doc structure is complete
		$(function() {initFunction ( input.attr("id"), param );});
	}

	return this;
};

// Unregister all validation methods for the element referenced by /this/
$.fn.SemanticForms_unregisterInputValidation = function() {

	var sfdata = $("#sfForm").data("SemanticForms");

	if ( this.attr("id") && sfdata ) {
		// delete every validation method for this input
		for ( var i = 0; i < sfdata.validationFunctions.length; i++ ) {
			if ( typeof sfdata.validationFunctions[i] !== 'undefined' &&
				sfdata.validationFunctions[i].input === this.attr("id") ) {
				delete sfdata.validationFunctions[i];
			}
		}
	}

	return this;
};

// Unregister all initialization methods for the element referenced by /this/
$.fn.SemanticForms_unregisterInputInit = function() {

	if ( this.attr("id") && $("#sfForm").data("SemanticForms") ) {
		delete $("#sfForm").data("SemanticForms").initFunctions[this.attr("id")];
	}

	return this;
};

/*
 * Functions for handling 'show on select'
 */

// Display a div that would otherwise be hidden by "show on select".
function showDiv(div_id, instanceWrapperDiv, speed) {
	var elem;
	if ( instanceWrapperDiv !== null ) {
		elem = $('[data-origID="' + div_id + '"]', instanceWrapperDiv);
	} else {
		elem = $('#' + div_id);
	}

	elem
	.find(".hiddenBySF")
	.removeClass('hiddenBySF')

	.find(".disabledBySF")
	.removeAttr('disabled')
	.removeClass('disabledBySF');

	elem.each( function() {
		if ( $(this).css('display') === 'none' ) {

			$(this).slideDown(speed, function() {
				$(this).fadeTo(speed,1);
			});

		}
	});

	// Now re-show any form elements that are meant to be shown due
	// to the current value of form inputs in this div that are now
	// being uncovered.
	var sfgShowOnSelect = mw.config.get( 'sfgShowOnSelect' );
	elem.find(".sfShowIfSelected, .sfShowIfChecked").each( function() {
		var uncoveredInput = $(this);
		var uncoveredInputID = null;
		if ( instanceWrapperDiv === null ) {
			uncoveredInputID = uncoveredInput.attr("id");
		} else {
			uncoveredInputID = uncoveredInput.attr("data-origID");
		}
		var showOnSelectVals = sfgShowOnSelect[uncoveredInputID];

		if ( showOnSelectVals !== undefined ) {
			var inputVal = uncoveredInput.val();
			for ( var i = 0; i < showOnSelectVals.length; i++ ) {
				var options = showOnSelectVals[i][0];
				var div_id2 = showOnSelectVals[i][1];
				if ( uncoveredInput.hasClass( 'sfShowIfSelected' ) ) {
					showDivIfSelected( options, div_id2, inputVal, instanceWrapperDiv, false );
				} else {
					uncoveredInput.showDivIfChecked( options, div_id2, instanceWrapperDiv, false );
				}
			}
		}
	});
}

// Hide a div due to "show on select". The CSS class is there so that SF can
// ignore the div's contents when the form is submitted.
function hideDiv(div_id, instanceWrapperDiv, speed) {
	var elem;
	// IDs can't contain spaces, and jQuery won't work with such IDs - if
	// this one has a space, display an alert.
	if ( div_id.indexOf( ' ' ) > -1 ) {
		// TODO - this should probably be a language value, instead of
		// hardcoded in English.
		alert( "Warning: this form has \"show on select\" pointing to an invalid element ID (\"" + div_id + "\") - IDs in HTML cannot contain spaces." );
	}

	if ( instanceWrapperDiv !== null ) {
		elem = instanceWrapperDiv.find('[data-origID=' + div_id + ']');
	} else {
		elem = $('#' + div_id);
	}
	elem.find("span, div").addClass('hiddenBySF');

	elem.each( function() {
		if ( $(this).css('display') !== 'none' ) {

			// if 'display' is not 'hidden', but the element is hidden otherwise
			// (e.g. by having height = 0), just hide it, else animate the hiding
			if ( $(this).is(':hidden') ) {
				$(this).hide();
			} else {
			$(this).fadeTo(speed, 0, function() {
				$(this).slideUp(speed);
			});
			}
		}
	});

	// Also, recursively hide further elements that are only shown because
	// inputs within this now-hidden div were checked/selected.
	var sfgShowOnSelect = mw.config.get( 'sfgShowOnSelect' );
	elem.find(".sfShowIfSelected, .sfShowIfChecked").each( function() {
		var showOnSelectVals;
		if ( instanceWrapperDiv === null ) {
			showOnSelectVals = sfgShowOnSelect[$(this).attr("id")];
		} else {
			showOnSelectVals = sfgShowOnSelect[$(this).attr("data-origID")];
		}

		if ( showOnSelectVals !== undefined ) {
			for ( var i = 0; i < showOnSelectVals.length; i++ ) {
				//var options = showOnSelectVals[i][0];
				var div_id2 = showOnSelectVals[i][1];
				hideDiv(div_id2, instanceWrapperDiv, 'fast' );
			}
		}
	});
}

// Show this div if the current value is any of the relevant options -
// otherwise, hide it.
function showDivIfSelected(options, div_id, inputVal, instanceWrapperDiv, initPage) {
	for ( var i = 0; i < options.length; i++ ) {
		// If it's a listbox and the user has selected more than one
		// value, it'll be an array - handle either case.
		if (($.isArray(inputVal) && $.inArray(options[i], inputVal) >= 0) ||
			(!$.isArray(inputVal) && (inputVal === options[i]))) {
			showDiv( div_id, instanceWrapperDiv, initPage ? 0 : 'fast' );
			return;
		}
	}
	hideDiv(div_id, instanceWrapperDiv, initPage ? 0 : 'fast' );
}

// Used for handling 'show on select' for the 'dropdown' and 'listbox' inputs.
$.fn.showIfSelected = function(initPage) {
	var inputVal = this.val(),
		sfgShowOnSelect = mw.config.get( 'sfgShowOnSelect' ),
		showOnSelectVals,
		instanceWrapperDiv = this.closest('.multipleTemplateInstance');

	if ( instanceWrapperDiv.length === 0 ) {
		instanceWrapperDiv = null;
		showOnSelectVals = sfgShowOnSelect[this.attr("id")];
	} else {
		showOnSelectVals = sfgShowOnSelect[this.attr("data-origID")];
	}

	if ( showOnSelectVals !== undefined ) {
		for ( var i = 0; i < showOnSelectVals.length; i++ ) {
			var options = showOnSelectVals[i][0];
			var div_id = showOnSelectVals[i][1];
			showDivIfSelected( options, div_id, inputVal, instanceWrapperDiv, initPage );
		}
	}

	return this;
};

// Show this div if any of the relevant selections are checked -
// otherwise, hide it.
$.fn.showDivIfChecked = function(options, div_id, instanceWrapperDiv, initPage ) {
	for ( var i = 0; i < options.length; i++ ) {
		if ($(this).find('[value="' + options[i] + '"]').is(":checked")) {
			showDiv(div_id, instanceWrapperDiv, initPage ? 0 : 'fast' );
			return this;
		}
	}
	hideDiv(div_id, instanceWrapperDiv, initPage ? 0 : 'fast' );

	return this;
};

// Used for handling 'show on select' for the 'checkboxes' and 'radiobutton'
// inputs.
$.fn.showIfChecked = function(initPage) {
	var sfgShowOnSelect = mw.config.get( 'sfgShowOnSelect' ),
		showOnSelectVals,
		i;

	var instanceWrapperDiv = this.closest('.multipleTemplateInstance');
	if ( instanceWrapperDiv.length === 0 ) {
		instanceWrapperDiv = null;
		showOnSelectVals = sfgShowOnSelect[this.attr("id")];
	} else {
		showOnSelectVals = sfgShowOnSelect[this.attr("data-origID")];
	}

	if ( showOnSelectVals !== undefined ) {
		for ( i = 0; i < showOnSelectVals.length; i++ ) {
			var options = showOnSelectVals[i][0];
			var div_id = showOnSelectVals[i][1];
			this.showDivIfChecked(options, div_id, instanceWrapperDiv, initPage );
		}
	}

	return this;
};

// Used for handling 'show on select' for the 'checkbox' input.
$.fn.showIfCheckedCheckbox = function( partOfMultiple, initPage ) {
	var sfgShowOnSelect = mw.config.get( 'sfgShowOnSelect' ),
		divIDs,
		instanceWrapperDiv,
		i;

	if (partOfMultiple) {
		divIDs = sfgShowOnSelect[this.attr("data-origID")];
		instanceWrapperDiv = this.closest(".multipleTemplateInstance");
	} else {
		divIDs = sfgShowOnSelect[this.attr("id")];
		instanceWrapperDiv = null;
	}

	for ( i = 0; i < divIDs.length; i++ ) {
		var divID = divIDs[i];
		if ($(this).is(":checked")) {
			showDiv(divID, instanceWrapperDiv, initPage ? 0 : 'fast' );
		} else {
			hideDiv(divID, instanceWrapperDiv, initPage ? 0 : 'fast' );
		}
	}

	return this;
};

/*
 * Validation functions
 */

// Set the error message for an input.
$.fn.setErrorMessage = function(msg, val) {
	var container = this.find('.sfErrorMessages');
	container.html($('<div>').addClass( 'errorMessage' ).text( mw.msg( msg, val ) ));
};

// Append an error message to the end of an input.
$.fn.addErrorMessage = function(msg, val) {
	this.find('input').addClass('inputError');
	this.find('select2-container').addClass('inputError');
	this.append($('<div>').addClass( 'errorMessage' ).text( mw.msg( msg, val ) ));
};

$.fn.isAtMaxInstances = function() {
	var numInstances = this.find("div.multipleTemplateInstance").length;
	var maximumInstances = this.attr("maximumInstances");
	if ( numInstances >= maximumInstances ) {
		this.parent().setErrorMessage( 'sf_too_many_instances_error', maximumInstances );
		return true;
	}
	return false;
};

$.fn.validateNumInstances = function() {
	var minimumInstances = this.attr("minimumInstances");
	var maximumInstances = this.attr("maximumInstances");
	var numInstances = this.find("div.multipleTemplateInstance").length;
	if ( numInstances < minimumInstances ) {
		this.parent().addErrorMessage( 'sf_too_few_instances_error', minimumInstances );
		return false;
	} else if ( numInstances > maximumInstances ) {
		this.parent().addErrorMessage( 'sf_too_many_instances_error', maximumInstances );
		return false;
	} else {
		return true;
	}
};

$.fn.validateMandatoryField = function() {
	var fieldVal = this.find(".mandatoryField").val();
	var isEmpty;

	if (fieldVal === null) {
		isEmpty = true;
	} else if ($.isArray(fieldVal)) {
		isEmpty = (fieldVal.length === 0);
	} else {
		isEmpty = (fieldVal.replace(/\s+/, '') === '');
	}
	if (isEmpty) {
		this.addErrorMessage( 'sf_blank_error' );
		return false;
	} else {
		return true;
	}
};

$.fn.validateUniqueField = function() {

	var UNDEFINED = "undefined";
	var field = this.find(".uniqueField");
	var fieldVal = field.val();

	if (typeof fieldVal === UNDEFINED || fieldVal.replace(/\s+/, '') === '') {
		return true;
	}

	var fieldOrigVal = field.prop("defaultValue");
	if (fieldVal === fieldOrigVal) {
		return true;
	}

	var categoryFieldName = field.prop("id") + "_unique_for_category";
	var categoryField = $("[name=" + categoryFieldName + "]");
	var category = categoryField.val();

	var namespaceFieldName = field.prop("id") + "_unique_for_namespace";
	var namespaceField = $("[name=" + namespaceFieldName + "]");
	var namespace = namespaceField.val();

	var url = mw.config.get( 'wgScriptPath' ) + "/api.php?format=json&action=";

	var query,
		isNotUnique;

	// SMW
	var propertyFieldName = field.prop("id") + "_unique_property",
		propertyField = $("[name=" + propertyFieldName + "]"),
		property = propertyField.val();
	if (typeof property !== UNDEFINED && property.replace(/\s+/, '') !== '') {

		query = "[[" + property + "::" + fieldVal + "]]";

		if (typeof category !== UNDEFINED &&
			category.replace(/\s+/, '') !== '') {
			query += "[[Category:" + category + "]]";
		}

		if (typeof namespace !== UNDEFINED) {
			if (namespace.replace(/\s+/, '') !== '') {
				query += "[[:" + namespace + ":+]]";
			} else {
				query += "[[:+]]";
			}
		}

		var conceptFieldName = field.prop("id") + "_unique_for_concept";
		var conceptField = $("[name=" + conceptFieldName + "]");
		var concept = conceptField.val();
		if (typeof concept !== UNDEFINED &&
			concept.replace(/\s+/, '') !== '') {
			query += "[[Concept:" + concept + "]]";
		}

		query += "|limit=1";
		query = encodeURIComponent(query);

		url += "ask&query=" + query;
		isNotUnique = true;
		$.ajax({
			url: url,
			dataType: 'json',
			async: false,
			success: function(data) {
				if (data.query.meta.count === 0) {
					isNotUnique = false;
				}
			}
		});
		if (isNotUnique) {
			this.addErrorMessage( 'sf_not_unique_error' );
			return false;
		} else {
			return true;
		}
	}

	// Cargo
	var cargoTableFieldName = field.prop("id") + "_unique_cargo_table";
	var cargoTableField = $("[name=" + cargoTableFieldName + "]");
	var cargoTable = cargoTableField.val();
	var cargoFieldFieldName = field.prop("id") + "_unique_cargo_field";
	var cargoFieldField = $("[name=" + cargoFieldFieldName + "]");
	var cargoField = cargoFieldField.val();
	if (typeof cargoTable !== UNDEFINED && cargoTable.replace(/\s+/, '') !== ''
		&& typeof cargoField !== UNDEFINED
		&& cargoField.replace(/\s+/, '') !== '') {

		query = "&where=" + cargoField + "+=+'" + fieldVal + "'";

		if (typeof category !== UNDEFINED &&
			category.replace(/\s+/, '') !== '') {
			category = category.replace(/\s/, '_');
			query += "+AND+cl_to=" + category + "+AND+cl_from=_pageID";
			cargoTable += ",categorylinks";
		}

		if (typeof namespace !== UNDEFINED) {
			query += "+AND+_pageNamespace=";
			if (namespace.replace(/\s+/, '') !== '') {
				var ns = mw.config.get('wgNamespaceIds')[namespace.toLowerCase()];
				if (typeof ns !== UNDEFINED) {
					query +=  ns;
				}
			} else {
				query +=  "0";
			}
		}

		query += "&limit=1";

		url += "cargoquery&tables=" + cargoTable + "&fields=" + cargoField +
			query;
		isNotUnique = true;
		$.ajax({
			url: url,
			dataType: 'json',
			async: false,
			success: function(data) {
				if (data.cargoquery.length === 0) {
					isNotUnique = false;
				}
			}
		});
		if (isNotUnique) {
			this.addErrorMessage( 'sf_not_unique_error' );
			return false;
		} else {
			return true;
		}
	}

	return true;

};

$.fn.validateMandatoryComboBox = function() {
	var combobox = this.find( "input.sfComboBox" );
	if (combobox.val() === '') {
		this.addErrorMessage( 'sf_blank_error' );
		return false;
	} else {
		return true;
	}
};

$.fn.validateMandatoryDateField = function() {
	if (this.find(".dayInput").val() === '' ||
		this.find(".monthInput").val() === '' ||
		this.find(".yearInput").val() === '') {
		this.addErrorMessage( 'sf_blank_error' );
		return false;
	} else {
		return true;
	}
};

// Special handling for radiobuttons, because what's being checked
// is the first radiobutton, which has an empty value.
$.fn.validateMandatoryRadioButton = function() {
	if (this.find("[value='']").is(':checked')) {
		this.addErrorMessage( 'sf_blank_error' );
		return false;
	} else {
		return true;
	}
};

$.fn.validateMandatoryCheckboxes = function() {
	// Get the number of checked checkboxes within this span - must
	// be at least one.
	var numChecked = this.find("input:checked").size();
	if (numChecked === 0) {
		this.addErrorMessage( 'sf_blank_error' );
		return false;
	} else {
		return true;
	}
};

/*
 * Type-based validation
 */

$.fn.validateURLField = function() {
	var fieldVal = this.find("input").val();
	// code borrowed from http://snippets.dzone.com/posts/show/452
	var url_regexp = /(ftp|http|https|rtsp|news):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	if (fieldVal === "" || url_regexp.test(fieldVal)) {
		return true;
	} else {
		this.addErrorMessage( 'sf_bad_url_error' );
		return false;
	}
};

$.fn.validateEmailField = function() {
	var fieldVal = this.find("input").val();
	// code borrowed from http://javascript.internet.com/forms/email-validation---basic.html
	var email_regexp = /^\s*\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+\s*$/;
	if (fieldVal === '' || email_regexp.test(fieldVal)) {
		return true;
	} else {
		this.addErrorMessage( 'sf_bad_email_error' );
		return false;
	}
};

$.fn.validateNumberField = function() {
	var fieldVal = this.find("input").val();
	// Handle "E notation"/scientific notation ("1.2e-3") in addition
	// to regular numbers
	if (fieldVal === '' ||
	fieldVal.match(/^\s*[\-+]?((\d+[\.,]?\d*)|(\d*[\.,]?\d+))([eE]?[\-\+]?\d+)?\s*$/)) {
		return true;
	} else {
		this.addErrorMessage( 'sf_bad_number_error' );
		return false;
	}
};

$.fn.validateDateField = function() {
	// validate only if day and year fields are both filled in
	var dayVal = this.find(".dayInput").val();
	var yearVal = this.find(".yearInput").val();
	if (dayVal === '' || yearVal === '') {
		return true;
	} else if (dayVal.match(/^\d+$/) && dayVal <= 31) {
		// no year validation, since it can also include
		// 'BC' and possibly other non-number strings
		return true;
	} else {
		this.addErrorMessage( 'sf_bad_date_error' );
		return false;
	}
};

// Standalone pipes are not allowed, because they mess up the template
// parsing; unless they're part of a call to a template or a parser function.
$.fn.checkForPipes = function() {
	var fieldVal = this.find("input, textarea").val();
	// We need to check for a few different things because this is
	// called for a variety of different input types.
	if ( fieldVal === undefined || fieldVal === '' ) {
		fieldVal = this.text();
	}
	if ( fieldVal === undefined || fieldVal === '' ) {
		return true;
	}
	if ( fieldVal.indexOf( '|' ) < 0 ) {
		return true;
	}

	var nextPipe,
		nextDoubleBracketsStart,
		nextDoubleBracketsEnd;

	// There's at least one pipe - here's where the real work begins.
	// We do a mini-parsing of the string to try to make sure that every
	// pipe is within either double square brackets (links) or double
	// curly brackets (parser functions, template calls).
	// For simplicity's sake, turn all curly brackets into square brackets,
	// so we only have to check for one thing.
	// This will incorrectly allow bad text like "[[a|b}}", but hopefully
	// that's not a major problem.
	fieldVal = fieldVal.replace( /{{/g, '[[' );
	fieldVal = fieldVal.replace( /}}/g, ']]' );
	var curIndex = 0;
	var numUnclosedBrackets = 0;
	while ( true ) {
		nextDoubleBracketsStart = fieldVal.indexOf( '[[', curIndex );

		if ( numUnclosedBrackets === 0 ) {
			nextPipe = fieldVal.indexOf( '|', curIndex );
			if ( nextPipe < 0 ) {
				return true;
			}
			if ( nextDoubleBracketsStart < 0 || nextPipe < nextDoubleBracketsStart ) {
				// There's a pipe where it shouldn't be.
				this.addErrorMessage( 'sf_pipe_error' );
				return false;
			}
		} else {
			if ( nextDoubleBracketsEnd < 0 ) {
				// Something is malformed - might as well throw
				// an error.
				this.addErrorMessage( 'sf_pipe_error' );
				return false;
			}
		}

		nextDoubleBracketsEnd = fieldVal.indexOf( ']]', curIndex );

		if ( nextDoubleBracketsStart >= 0 && nextDoubleBracketsStart < nextDoubleBracketsEnd ) {
			numUnclosedBrackets++;
			curIndex = nextDoubleBracketsStart + 2;
		} else {
			numUnclosedBrackets--;
			curIndex = nextDoubleBracketsEnd + 2;
		}
	}

	// We'll never get here, but let's have this line anyway.
	return true;
};

window.validateAll = function () {

	// Hook that fires on form submission, before the validation.
	mw.hook('sf.formValidationBefore').fire();

	var num_errors = 0;

	// Remove all old error messages.
	$(".errorMessage").remove();

	// Make sure all inputs are ignored in the "starter" instance
	// of any multiple-instance template.
	$(".multipleTemplateStarter").find("span, div").addClass("hiddenBySF");

	$(".multipleTemplateList").each( function() {
		if (! $(this).validateNumInstances() ) {
			num_errors += 1;
		}
	});

	$("span.inputSpan.mandatoryFieldSpan").not(".hiddenBySF").each( function() {
		if (! $(this).validateMandatoryField() ) {
			num_errors += 1;
		}
	});
	$("div.ui-widget.mandatory").not(".hiddenBySF").each( function() {
		if (! $(this).validateMandatoryComboBox() ) {
			num_errors += 1;
		}
	});
	$("span.dateInput.mandatoryFieldSpan").not(".hiddenBySF").each( function() {
		if (! $(this).validateMandatoryDateField() ) {
			num_errors += 1;
		}
	});
	$("span.radioButtonSpan.mandatoryFieldSpan").not(".hiddenBySF").each( function() {
		if (! $(this).validateMandatoryRadioButton() ) {
			num_errors += 1;
		}
	});
	$("span.checkboxesSpan.mandatoryFieldSpan").not(".hiddenBySF").each( function() {
		if (! $(this).validateMandatoryCheckboxes() ) {
			num_errors += 1;
		}
	});
	$("span.inputSpan.uniqueFieldSpan").not(".hiddenBySF").each( function() {
		if (! $(this).validateUniqueField() ) {
			num_errors += 1;
		}
	});
	$("span.inputSpan, div.sfComboBox").not(".hiddenBySF, .freeText, .pageSection").each( function() {
		if (! $(this).checkForPipes() ) {
			num_errors += 1;
		}
	});
	$("span.URLInput").not(".hiddenBySF").each( function() {
		if (! $(this).validateURLField() ) {
			num_errors += 1;
		}
	});
	$("span.emailInput").not(".hiddenBySF").each( function() {
		if (! $(this).validateEmailField() ) {
			num_errors += 1;
		}
	});
	$("span.numberInput").not(".hiddenBySF").each( function() {
		if (! $(this).validateNumberField() ) {
			num_errors += 1;
		}
	});
	$("span.dateInput").not(".hiddenBySF").each( function() {
		if (! $(this).validateDateField() ) {
			num_errors += 1;
		}
	});

	// call registered validation functions
	var sfdata = $("#sfForm").data('SemanticForms');

	if ( sfdata && sfdata.validationFunctions.length > 0 ) { // found data object?

		// for every registered input
		for ( var i = 0; i < sfdata.validationFunctions.length; i++ ) {

			// if input is not part of multipleTemplateStarter
			if ( typeof sfdata.validationFunctions[i] !== 'undefined' &&
				$("#" + sfdata.validationFunctions[i].input).closest(".multipleTemplateStarter").length === 0 &&
				$("#" + sfdata.validationFunctions[i].input).closest(".hiddenBySF").length === 0 ) {

				if (! sfdata.validationFunctions[i].valfunction(
						sfdata.validationFunctions[i].input,
						sfdata.validationFunctions[i].parameters)
					) {
					num_errors += 1;
				}
			}
		}
	}

	if (num_errors > 0) {
		// add error header, if it's not there already
		if ($("#form_error_header").size() === 0) {
			$("#contentSub").append('<div id="form_error_header" class="errorbox" style="font-size: medium"><img src="' + mw.config.get( 'sfgScriptPath' ) + '/skins/MW-Icon-AlertMark.png" />&nbsp;' + mw.message( 'sf_formerrors_header' ).escaped() + '</div><br clear="both" />');
		}
		scroll(0, 0);
	} else {
		// Disable inputs hidden due to either "show on select" or
		// because they're part of the "starter" div for
		// multiple-instance templates, so that they aren't
		// submitted by the form.
		$('.hiddenBySF').find("input, select, textarea").not(':disabled')
		.prop('disabled', true)
		.addClass('disabledBySF');
		//remove error box if it exists because there are no errors in the form now
		$("#contentSub").find(".errorbox").remove();
	}

	// Hook that fires on form submission, after the validation.
	mw.hook('sf.formValidationAfter').fire();

	return (num_errors === 0);
};

var num_elements = 0;

/**
 * Functions for multiple-instance templates.
 */
$.fn.addInstance = function( addAboveCurInstance ) {
	var sfgShowOnSelect = mw.config.get( 'sfgShowOnSelect' );
	var wrapper = this.closest(".multipleTemplateWrapper");
	var multipleTemplateList = wrapper.find('.multipleTemplateList');

	// If the nubmer of instances is already at the maximum allowed,
	// exit here.
	if ( multipleTemplateList.isAtMaxInstances() ) {
		return false;
	}

	// Global variable.
	num_elements++;

	// Create the new instance
	var new_div = wrapper
		.find(".multipleTemplateStarter")
		.clone()
		.removeClass('multipleTemplateStarter')
		.addClass('multipleTemplateInstance')
		.addClass('multipleTemplate') // backwards compatibility
		.removeAttr("id")
		.fadeTo(0,0)
		.slideDown('fast', function() {
			$(this).fadeTo('fast', 1);
		});

	// Add on a new attribute, "data-origID", representing the ID of all
	// HTML elements that had an ID; and delete the actual ID attribute
	// of any divs and spans (presumably, these exist only for the
	// sake of "show on select"). We do the deletions because no two
	// elements on the page are allowed to have the same ID.
	new_div.find('[id!=""]').attr('data-origID', function() { return this.id; });
	new_div.find('div[id!=""], span[id!=""]').removeAttr('id');

	new_div.find('.hiddenBySF')
	.removeClass('hiddenBySF')

	.find('.disabledBySF')
	.removeAttr('disabled')
	.removeClass('disabledBySF');

	// Make internal ID unique for the relevant form elements, and replace
	// the [num] index in the element names with an actual unique index
	new_div.find("input, select, textarea").each(
		function() {
			// Add in a 'b' at the end of the name to reduce the
			// chance of name collision with another field
			if (this.name) {
				var old_name = this.name.replace(/\[num\]/g, '');
				$(this).attr('origName', old_name);
				this.name = this.name.replace(/\[num\]/g, '[' + num_elements + 'b]');
			}

			if (this.id) {

				var old_id = this.id;

				this.id = this.id.replace(/input_/g, 'input_' + num_elements + '_');

				// TODO: Data in sfgShowOnSelect should probably be stored in
				//  $("#sfForm").data('SemanticForms')
				if ( sfgShowOnSelect[ old_id ] ) {
					sfgShowOnSelect[ this.id ] = sfgShowOnSelect[ old_id ];
				}

				// register initialization and validation methods for new inputs

				var sfdata = $("#sfForm").data('SemanticForms');
				if ( sfdata ) { // found data object?
					var i;
					if ( sfdata.initFunctions[old_id] ) {

						// For every initialization method for
						// input with id old_id, register the
						// method for the new input.
						for ( i = 0; i < sfdata.initFunctions[old_id].length; i++ ) {

							$(this).SemanticForms_registerInputInit(
								sfdata.initFunctions[old_id][i].initFunction,
								sfdata.initFunctions[old_id][i].parameters,
								true //do not yet execute
								);
						}
					}

					// For every validation method for the
					// input with ID old_id, register it
					// for the new input.
					for ( i = 0; i < sfdata.validationFunctions.length; i++ ) {

						if ( typeof sfdata.validationFunctions[i] !== 'undefined' &&
							sfdata.validationFunctions[i].input === old_id ) {

							$(this).SemanticForms_registerInputValidation(
								sfdata.validationFunctions[i].valfunction,
								sfdata.validationFunctions[i].parameters
								);
						}
					}
				}
			}
		}
	);

	new_div.find('a').attr('href', function() {
		return this.href.replace(/input_/g, 'input_' + num_elements + '_');
	});

	new_div.find('span').attr('id', function() {
		return this.id.replace(/span_/g, 'span_' + num_elements + '_');
	});

	new_div.find('label').attr('for', function() {
		return this.htmlFor.replace(/input_/g, 'input_' + num_elements + '_');
	});

	// Add the new instance.
	if ( addAboveCurInstance ) {
		new_div.insertBefore(this.closest(".multipleTemplateInstance"));
	} else {
		this.closest(".multipleTemplateWrapper")
			.find(".multipleTemplateList")
			.append(new_div);
	}

	new_div.initializeJSElements(true);

	// Initialize new inputs.
	new_div.find("input, select, textarea").each(
		function() {

			if (this.id) {

				var sfdata = $("#sfForm").data('SemanticForms');
				if ( sfdata ) {

					// have to store data array: the id attribute
					// of 'this' might be changed in the init function
					var thatData = sfdata.initFunctions[this.id] ;

					if ( thatData ) { // if anything registered at all
						// Call every initialization method
						// for this input
						for ( var i = 0; i < thatData.length; i++ ) {
							thatData[i].initFunction(
								this.id,
								thatData[i].parameters
								);
						}
					}
				}
			}
		}
	);

	// Hook that fires each time a new template instance is added.
	// The first parameter is a jQuery selection of the newly created instance div.
	mw.hook('sf.addTemplateInstance').fire(new_div);
};

// The first argument is needed, even though it's an attribute of the element
// on which this function is called, because it's the 'name' attribute for
// regular inputs, and the 'origName' attribute for inputs in multiple-instance
// templates.
$.fn.setDependentAutocompletion = function( dependentField, baseField, baseValue ) {
	// Get data from either Cargo or Semantic MediaWiki.
	var myServer = mw.config.get( 'wgScriptPath' ) + "/api.php",
		sfgCargoFields = mw.config.get( 'sfgCargoFields' ),
		sfgFieldProperties = mw.config.get( 'sfgFieldProperties' );
	myServer += "?action=sfautocomplete&format=json";
	if ( sfgCargoFields.hasOwnProperty( dependentField ) ) {
		var cargoTableAndFieldStr = sfgCargoFields[dependentField];
		var cargoTableAndField = cargoTableAndFieldStr.split('|');
		var cargoTable = cargoTableAndField[0];
		var cargoField = cargoTableAndField[1];
		var baseCargoTableAndFieldStr = sfgCargoFields[baseField];
		var baseCargoTableAndField = baseCargoTableAndFieldStr.split('|');
		var baseCargoTable = baseCargoTableAndField[0];
		var baseCargoField = baseCargoTableAndField[1];
		myServer += "&cargo_table=" + cargoTable + "&cargo_field=" + cargoField + "&is_array=true" + "&base_cargo_table=" + baseCargoTable + "&base_cargo_field=" + baseCargoField + "&basevalue=" + baseValue;
	} else {
		var propName = sfgFieldProperties[dependentField];
		var baseProp = sfgFieldProperties[baseField];
		myServer += "&property=" + propName + "&baseprop=" + baseProp + "&basevalue=" + baseValue;
	}
	var dependentValues = [];
	var thisInput = $(this);
	// We use $.ajax() here instead of $.getJSON() so that the
	// 'async' parameter can be set. That, in turn, is set because
	// if the 2nd, "dependent" field is a combo box, it can have weird
	// behavior: clicking on the down arrow for the combo box leads to a
	// "blur" event for the base field, which causes the possible
	// values to get recalculated, but not in time for the dropdown to
	// change values - it still shows the old values. By setting
	// "async: false", we guarantee that old values won't be shown - if
	// the values haven't been recalculated yet, the dropdown won't
	// appear at all.
	// @TODO - handle this the right way, by having special behavior for
	// the dropdown - it should get delayed until the values are
	// calculated, then appear.
	$.ajax({
		url: myServer,
		dataType: 'json',
		async: false,
		success: function(data) {
			var realData = data.sfautocomplete;
			$.each(realData, function(key, val) {
				dependentValues.push(val.title);
			});
			thisInput.data('autocompletevalues', dependentValues);
			thisInput.attachAutocomplete();
		}
	});
};

/**
 * Called on a 'base' field (e.g., for a country) - sets the autocompletion
 * for its 'dependent' field (e.g., for a city).
 */
$.fn.setAutocompleteForDependentField = function( partOfMultiple ) {
	var curValue = $(this).val();
	if ( curValue === null ) { return this; }

	var nameAttr = partOfMultiple ? 'origName' : 'name';
	var name = $(this).attr(nameAttr);
	var sfgDependentFields = mw.config.get( 'sfgDependentFields' );
	var dependent_on_me = [];
	for ( var i = 0; i < sfgDependentFields.length; i++ ) {
		var dependentFieldPair = sfgDependentFields[i];
		if ( dependentFieldPair[0] === name ) {
			dependent_on_me.push(dependentFieldPair[1]);
		}
	}
	dependent_on_me = $.unique(dependent_on_me);

	var self = this;
	$.each( dependent_on_me, function() {
		var element, cmbox, tokens,
			dependentField = this;

		if ( partOfMultiple ) {
			element = $( self ).closest( '.multipleTemplateInstance' )
				.find('[origName="' + dependentField + '"]');
		} else {
			element = $('[name="' + dependentField + '"]');
		}

		if ( element.hasClass( 'sfComboBox' ) ) {
			cmbox = new sf.select2.combobox();
			cmbox.refresh(element);
		} else if ( element.hasClass( 'sfTokens' ) ) {
			tokens = new sf.select2.tokens();
			tokens.refresh(element);
		} else {
			element.setDependentAutocompletion(dependentField, name, curValue);
		}
	});


	return this;
};

/**
 * Initialize all the JS-using elements contained within this block - can be
 * called for either the entire HTML body, or for a div representing an
 * instance of a multiple-instance template.
 */
$.fn.initializeJSElements = function( partOfMultiple ) {
	this.find(".sfShowIfSelected").each( function() {
		$(this)
		.showIfSelected(true)
		.change( function() {
			$(this).showIfSelected(false);
		});
	});

	this.find(".sfShowIfChecked").each( function() {
		$(this)
		.showIfChecked(true)
		.click( function() {
			$(this).showIfChecked(false);
		});
	});

	this.find(".sfShowIfCheckedCheckbox").each( function() {
		$(this)
		.showIfCheckedCheckbox(partOfMultiple, true)
		.click( function() {
			$(this).showIfCheckedCheckbox(partOfMultiple, false);
		});
	});

	// Enable the new remove button
	this.find(".removeButton").click( function() {

		// Unregister initialization and validation for deleted inputs
		$(this).parentsUntil( '.multipleTemplateInstance' ).last().parent().find("input, select, textarea").each(
			function() {
				$(this).SemanticForms_unregisterInputInit();
				$(this).SemanticForms_unregisterInputValidation();
			}
		);

		// Remove the encompassing div for this instance.
		$(this).closest(".multipleTemplateInstance")
		.fadeTo('fast', 0, function() {
			$(this).slideUp('fast', function() {
				$(this).remove();
			});
		});
		return false;
	});

	// ...and the new adder
	if ( partOfMultiple ) {
		this.find('.addAboveButton').click( function() {
			$(this).addInstance( true );
			return false; // needed to disable <a> behavior
		});
	}

	this.find('.autocompleteInput').attachAutocomplete();

	var combobox = new sf.select2.combobox();
	this.find('.sfComboBox').not('#semantic_property_starter, .multipleTemplateStarter .sfComboBox, .select2-container').each( function() {
		combobox.apply($(this));
	});

	var tokens = new sf.select2.tokens();
	this.find('.sfTokens').not('.multipleTemplateStarter .sfTokens, .select2-container').each( function() {
		tokens.apply($(this));
	});

	this.find('.autoGrow').autoGrow();
	this.find('.sfFancyBox').fancybox({
		'width'         : '75%',
		'height'        : '75%',
		'autoScale'     : false,
		'transitionIn'  : 'none',
		'transitionOut' : 'none',
		'type'          : 'iframe',
		'overlayColor'  : '#222',
		'overlayOpacity' : '0.8'
	});

	// @TODO - this should ideally be called only for inputs that have
	// a dependent field - which might involve changing the storage of
	// "dependent fields" information from a global variable to a
	// per-input HTML attribute.
	this.find('input, select').each( function() {
		$(this)
		.setAutocompleteForDependentField( partOfMultiple )
		.blur( function() {
			$(this).setAutocompleteForDependentField( partOfMultiple );
		});
	});
	// The 'blur' event doesn't get triggered for radio buttons for
	// Chrome and Safari (the WebKit-based browsers) so use the 'change'
	// event in addition.
	// @TODO - blur() shuldn't be called at all for radio buttons.
	this.find('input:radio')
		.change( function() {
			$(this).setAutocompleteForDependentField( partOfMultiple );
		});

	this.find(".sfTreeInput").not(".multipleTemplateStarter .sfTreeInput").each( function() {
		$(this).applyDynatree();
	});

};

// Once the document has finished loading, set up everything!
$(document).ready( function() {
	var i,
		inputID,
		validationFunctionData;

	function getFunctionFromName( functionName ) {
		var func = window;
		var namespaces = functionName.split( "." );
		for ( var i = 0; i < namespaces.length; i++ ) {
			func = func[ namespaces[ i ] ];
		}
		return func;
	}

	// Initialize inputs created by #forminput.
	if ( $('.sfFormInput').length > 0 ) {
		$('.autocompleteInput').attachAutocomplete();
	}

	// Exit now if a Semantic Forms form is not present.
	if ( $('#sfForm').length === 0 ) {
		return;
	}

	// register init functions
	var initFunctionData = mw.config.get( 'ext.sf.initFunctionData' );
	for ( inputID in initFunctionData ) {
		for ( i in initFunctionData[inputID] ) {
			/*jshint -W069 */
			$( '#' + inputID ).SemanticForms_registerInputInit( getFunctionFromName( initFunctionData[ inputID ][ i ][ 'name' ] ), initFunctionData[ inputID ][ i ][ 'param' ] );
			/*jshint +W069 */
		}
	}

	// register validation functions
	validationFunctionData = mw.config.get( 'ext.sf.validationFunctionData' );
	for ( inputID in validationFunctionData ) {
		for ( i in validationFunctionData[inputID] ) {
			/*jshint -W069 */
			$( '#' + inputID ).SemanticForms_registerInputValidation( getFunctionFromName( validationFunctionData[ inputID ][ i ][ 'name' ] ), validationFunctionData[ inputID ][ i ][ 'param' ] );
			/*jshint +W069 */
		}
	}

	$( 'body' ).initializeJSElements(false);

	$('.multipleTemplateInstance').initializeJSElements(true);
	$('.multipleTemplateAdder').click( function() {
		$(this).addInstance( false );
	});
	$('.multipleTemplateList').sortable({
		axis: 'y',
		handle: '.instanceRearranger'
	});

	// If the form is submitted, validate everything!
	$('#sfForm').submit( function() {
		return validateAll();
	} );
});
}( jQuery, mediaWiki ) );
