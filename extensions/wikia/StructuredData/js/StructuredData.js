var StructuredData = {
	// Mustache templates
	selectTemplate: '<select class="objects-to-add"><option value="false">{{defaultOption}}</option>{{#list}}<option data-value="{{id}}" data-url="{{url}}" data-type="{{type}}" data-name="{{name}}" {{#schema:contentURL}}data-image-url="{{schema:contentURL}}"{{/schema:contentURL}} >{{type}} - {{name}}</option>{{/list}}</select> ',
	objectTemplate: '<li><input type="hidden" name="{{type}}[]" value="{{id}}"><a href="{{url}}">{{name}}</a> <button class="secondary remove">{{removeText}}</button></li>',
	imageObjectTemplate: '<li><input type="hidden" name="{{type}}[]" value="{{id}}"><strong><a href="{{url}}" title="{{name}}">{{name}}</a></strong></br><img src="{{imageUrl}}" alt="{{name}}" /> <button class="secondary remove">{{removeText}}</button></li>',
	inputTemplate: '<li><div class="input-group"><input type="text" name="{{type}}[]" value="" /> <button class="secondary remove">{{removeText}}</button></div></li>',
	// jQuery cached selectors
	cachedSeletors: {},
	init: function() {
		var that = this;
		// Cache selectors
		this.cachedSeletors.SDObjectWrapper = $('#SDObject');
		// Attach handlers
		this.attachSpecialPageEditModeHandlers(this);
		this.attachSpecialPageBrowsingModeHandlers(this);
		// Add WMU support for editing image objects
		this.cachedSeletors.SDObjectWrapper.find('table[data-object-type="schema:ImageObject"] input[name="schema:url"]').after(' <button id="useWMU">Use WMU</button>');
		var wmuDeffered;
		$('#useWMU').click(function(event){
			event.preventDefault();
			var $input = $(this).prev();
			if (!wmuDeffered) {
				// *** WMU is not ready for resource loader
				// ***
				// wmuDeffered = mw.loader.use(
				//	'ext.wikia.WMU'
				// ***
				// *** so for the moment all assets need to be loaded separately
				wmuDeffered = $.when(
					$.loadYUI(),
					$.loadJQueryAIM(),
					$.getResource([$.getSassCommonURL( 'extensions/wikia/WikiaMiniUpload/css/WMU.scss'), wgExtensionsPath + '/wikia/WikiaMiniUpload/js/WMU.js'])
				).then(function() {
					WMU_skipDetails = true;
					WMU_show();
					WMU_openedInEditor = false;
				});
			} else if (wmuDeffered.state() === 'resolved') {
				WMU_show();
				WMU_openedInEditor = false;
			} else {
				 return false;
			}
			$(window).bind('WMU_addFromSpecialPage', function(event, wmuData) {
				var filePageUrl = window.location.protocol + '//' + window.location.host + '/' + wmuData.imageTitle;
				$input.val(filePageUrl);
			});
		});
		// Add date/time pickers only for SD object page
		$('input[name="schema:startDate"]').datetimepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:+0',
			dateFormat: 'yy-mm-dd',
			showSecond: 'true',
			separator: 'T',
			controlType: 'select',
			timeFormat: "HH:mm:ss"
		});
		$('input[name="schema:birthDate"]').datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '-150:+0',
			dateFormat: 'yy-m-d'
		});
	},
	attachSpecialPageEditModeHandlers: function(context) {
		// Attach handlers - load dropdown with objects to add
		this.cachedSeletors.SDObjectWrapper.on('click', 'td button.load-dropdown', function(event) {
			event.preventDefault();
			var $target = $(event.target);
			$('<div class="throbber-wrapper"></div>').insertAfter($target).startThrobbing();
			context.getObjectsToAdd($target, $target.data('range'));
			$target.attr('disabled', 'disabled');
		});
		// Attach handlers - add empty input to the list
		this.cachedSeletors.SDObjectWrapper.on('click', 'td button.add-input', function(event) {
			event.preventDefault();
			var $target = $(event.target);
			context.addEmptyInput($target);
		});
		// Attach handlers - add object from dropdown to list
		this.cachedSeletors.SDObjectWrapper.on('change', 'select.objects-to-add', function() {
			// Check if the option containing proper object was selected
			if ($(this).children(':selected').val() !== 'false') {
				context.addObject($(this));
			}
			// Reset dropdown
			$(this).children().first().attr('selected', 'selected');
		});
		// Attach handlers - remove object from list
		this.cachedSeletors.SDObjectWrapper.on('click', 'td button.remove', function(event) {
			event.preventDefault();
			$(event.target).parents('li').remove();
		});
		// Attach handlers - Use 'ENTER' to go to the next input in list or add new if pressed on last one HACK SOLUTION
		this.cachedSeletors.SDObjectWrapper.on('keydown', 'td li input[type="text"]', function(event) {
			if (event.which == 13) {
				event.preventDefault();
			}
		}).on('keyup', 'td li input[type="text"]', function(event) {
			if (event.which == 13) {
				event.preventDefault();
				var $target = $(event.target),
					$nextField = $target.parents('li').next().find('input');
				if ($nextField.length > 0) {
					$nextField.focus();
				} else {
					$target.parents('li').parent().siblings('button.add-input').click();
				}
			}
		});
	},
	attachSpecialPageBrowsingModeHandlers: function(context) {
		// Attach handlers - add confirmation before deleting object
		this.cachedSeletors.SDObjectWrapper.on('click', '.SDObject-delete', function(event) {
			event.preventDefault();
			var href = $(this).attr('href');
			context.confirmObjectDelete(href)
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
				data.defaultOption = $.msg('structureddata-dropdown-template-default-value');
				var html;
				if (data.list.length > 0) {
					html = Mustache.render(that.selectTemplate, data);
				} else {
					html = '<span> ' + $.msg('structureddata-dropdown-template-no-results') + '</span>';
				}
				$eventTarget.next().stopThrobbing();
				$eventTarget.after(html);
			}
		});
	},

	// METHOD for adding empty input fields for property values type 'rdfs:Literal'
	addEmptyInput: function($eventTarget) {
		var placeToAdd = ($eventTarget.siblings('ol').length > 0) ? $eventTarget.siblings('ol') : $eventTarget.siblings('ul'),
			inputData = {
			type: placeToAdd.data('field-name'),
			removeText:	$.msg('structureddata-object-edit-remove-reference')
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
				alert($.msg('structureddata-object-already-in-list'));
				alreadyInList = true;
			}
		});
		if (!alreadyInList) {
			var	objectData = {
					name: selectedObject.data('name'),
					url: selectedObject.data('url'),
					id: selectedObject.data('value'),
					type: placeToAdd.data('field-name'),
					removeText:	$.msg('structureddata-object-edit-remove-reference')
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
	},
	// METHOD - showing modal with confirmation question before deleting object
	confirmObjectDelete: function(href) {
		$.showCustomModal(
			$.msg('structureddata-object-delete-confirm-header'),
			'<p>' + $.msg('structureddata-object-delete-confirm-message') + '</p>',
			{
				id: "SDObjectDelConfirm",
				width: 600,
				buttons: [
					{
						id:'ok',
						defaultButton:true,
						message: $.msg('structureddata-object-delete-confirm-ok-button'),
						handler:function() {
							window.location = href;
						}
					},
					{
						id:'cancel',
						message: $.msg('structureddata-object-delete-confirm-cancel-button'),
						handler:function() {
							$('#SDObjectDelConfirm').closeModal();
						}
					}
				]
			}
		);
	}
}
$(function() {
	StructuredData.init();
});