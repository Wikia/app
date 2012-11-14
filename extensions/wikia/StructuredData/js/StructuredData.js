var StructureData = {
	// Mustache templates
	selectTemplate: '<select class="objects-to-add">{{#list}}<option data-value="{{id}}" data-url="{{url}}" data-type="{{type}}" {{#imageUrl}}data-image-url="{{imageUrl}}"{{/imageUrl}} >{{name}}</option>{{/list}}{{^list}}<option>No objects found!</option>{{/list}}</select> ',
	objectTemplate: '<li><input type="hidden" name="{{type}}[]" value="{{id}}"><a href="{{url}}">{{name}}</a> <button class="secondary remove">Remove</button></li>',
	imageObjectTemplate: '<li><input type="hidden" name="{{type}}[]" value="{{id}}"><a href="{{url}}" title="{{name}}"><img src="{{imageUrl}}" alt="{{name}}"</a> <button class="secondary remove">Remove</button></li>',
	inputTemplate: '<li><div class="input-group"><input type="text" name="{{type}}[]" value="" /> <button class="secondary remove">Remove</button></div></li>',

	init: function() {
		// Cache selectors
		var SDObjectWrapper = $('#SDObject'),
			that = this;
		// Attach handlers - load dropdown with objects to add
		SDObjectWrapper.on('click', 'td button.load-dropdown', function(event) {
			event.preventDefault();
			var $target = $(event.target);
			$('<div class="throbber-wrapper"></div>').insertAfter($target).startThrobbing();
			that.getObjectsToAdd($target, $target.data('range'));
			$target.attr('disabled', 'disabled');
		});
		// Attach handlers - add empty input to the list
		SDObjectWrapper.on('click', 'td button.add-input', function(event) {
			event.preventDefault();
			var $target = $(event.target);
			that.addEmptyInput($target);
		});
		// Attach handlers - add object from dropdown to list
		SDObjectWrapper.on('change', 'select.objects-to-add', function() {
			that.addObject($(this));
		});
		// Attach handlers - remove object from list
		SDObjectWrapper.on('click', 'td button.remove', function(event) {
			event.preventDefault();
			$(event.target).parents('li').remove();
		});
	},

	// METHOD for fetching collection of SDS objects form a given class and rendering <select> element with them inside
	getObjectsToAdd: function($eventTarget, classes) {
		var that = this,
			// Create a proper formatted string with classes for the request
			classesStr = classes.split(' '),
			classesStr = classesStr.join(',');
		$.nirvana.sendRequest( {
			controller: 'StructuredDataController',
			method: 'getCollection',
			type: 'GET',
			data: {
				objectType: classesStr
			},
			callback: function(data) {
				var html = Mustache.render(that.selectTemplate, data);
				$eventTarget.next().stopThrobbing();
				$eventTarget.after(html);
			}
		});
	},

	// METHOD for adding empty input fields for property values type 'rdfs:Literal'
	addEmptyInput: function($eventTarget) {
		var placeToAdd = ($eventTarget.siblings('ol').length > 0) ? $eventTarget.siblings('ol') : $eventTarget.siblings('ul'),
			inputData = {
			type: placeToAdd.data('field-name')
			},
			html = Mustache.render(this.inputTemplate, inputData);
		$(html).appendTo(placeToAdd).find('input').focus();
	},

	// METHOD for adding reference object to the list
	addObject: function(objectsList) {
		var selectedObject = objectsList.children(':selected'),
			placeToAdd = (objectsList.siblings('ol').length > 0) ? objectsList.siblings('ol') : objectsList.siblings('ul'),
			alreadyInList = false;
		// Check if the object is already in the list
		placeToAdd.find('input[type="hidden"]').each(function(){
			if ($(this).val() === selectedObject.data('value')) {
				alert('Object already in the list!');
				alreadyInList = true;
			}
		});
		if (!alreadyInList) {
			var	objectData = {
					name: selectedObject.text(),
					url: selectedObject.data('url'),
					id: selectedObject.data('value'),
					type: placeToAdd.data('field-name')
				},
				html;
			// Special case for photo property
			if (objectData.type === 'schema:photos') {
				objectData.imageUrl = selectedObject.data('image-url');
				html = Mustache.render(this.imageObjectTemplate, objectData);
			} else {
				html = Mustache.render(this.objectTemplate, objectData);
			}
			placeToAdd.append(html);
		}
	}
}
$(function() {
	StructureData.init();
});
