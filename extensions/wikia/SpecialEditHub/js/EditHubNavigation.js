var ModuleNavigation = function() {
};

ModuleNavigation.prototype = {
	boxes: undefined,
	wrapper: undefined,
	switchSelector: 'input:not(:button), textarea, .filename-placeholder, .image-placeholder img, .video-title, .video-url-input, .timeago, .timer, div.image-placeholder.video > a',

	init: function () {
		this.wrapper = $('#edit-hub-form');
		this.boxes = this.wrapper.find('.module-box');
		this.initButtons();
	},

	initButtons: function() {
		this.wrapper.on('click', '.module-box .nav-down:not(:disabled)', $.proxy(this.moveDown, this));
		this.wrapper.on('click', '.module-box .nav-up:not(:disabled)', $.proxy(this.moveUp, this));
	},

	moveUp: function(event) {
		event.preventDefault();
		var sourceBox = $(event.target).parents('.module-box');
		var destBox = sourceBox.prev();
		this.switchValues(sourceBox, destBox);
	},

	moveDown: function(event) {
		event.preventDefault();
		var sourceBox = $(event.target).parents('.module-box');
		var destBox = sourceBox.next();
		this.switchValues(sourceBox, destBox);
	},

	switchValues: function(source, dest) {
		var sourceContainers = source.find(this.switchSelector);
		var destContainers = dest.find(this.switchSelector);

		var sourceContainersLength = sourceContainers.length;
		var destContainersLength = destContainers.length;

		if (sourceContainersLength != destContainersLength) {
			throw "Switchable length not equals";
		}
		
		for (var i = 0; i < sourceContainersLength; i++) {
			this.switchElementValue(sourceContainers[i], destContainers[i]);
		}
		
		dest.get(0).scrollIntoView();
	},

	switchElementValue: function(source, dest) {
		var sourceTagName = source.nodeName.toLowerCase();
		var tmp;
		if (sourceTagName != dest.nodeName.toLowerCase()) {
			throw "Switchable type not equals";
		}
		var imgAttribsToSwitch = ['src', 'width', 'height', 'data-video'];
		var linkAttribsToSwitch = ['href'];

		source = $(source);
		dest = $(dest);

		var form = EditHub.form.validate();

		switch(sourceTagName) {
			case 'h4':
			case 'time':
			case 'span':
			case 'div':
				tmp = source.text();
				source.text(dest.text());
				dest.text(tmp);
				break;
			case 'img':
			case 'a':
				var attribs = (sourceTagName == 'a') ? linkAttribsToSwitch : imgAttribsToSwitch;
				for (var i = 0; i < attribs.length; i++) {
					tmp = source.attr(attribs[i]);
					source.attr(attribs[i], dest.attr(attribs[i]));
					dest.attr(attribs[i], tmp);
				}
				break;
			case 'textarea':
			default:
				var sourceInvalid = this.checkFieldsValidationErrors(form, source);
				var destInvalid = this.checkFieldsValidationErrors(form, dest);

				tmp = source.val();
				source.val(dest.val());
				dest.val(tmp);


				if (sourceInvalid) {
					this.switchValidationError(form, source, dest);
				}

				if (destInvalid) {
					this.switchValidationError(form, dest, source);
				}

		}
	},
	switchValidationError: function(form, source, dest) {
		var cleanedElement = form.clean(source);
		delete form.invalid[cleanedElement.name];
		form.prepareElement(cleanedElement);
		form.hideErrors();
		form.settings.unhighlight(cleanedElement, form.settings.errorClass, form.settings.validClass);
		form.element(dest);
	},
	checkFieldsValidationErrors: function(form, field) {
		return form.errors().filter('[for="' + form.idOrName(form.clean(field)) + '"]:visible').exists();
	}
};

var moduleNavigation = new ModuleNavigation();
$(function () {
	moduleNavigation.init();
});
