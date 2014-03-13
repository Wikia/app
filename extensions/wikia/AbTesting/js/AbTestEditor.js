(function(window, $, undefined) {
	var mw = window.mw,
		templates = {
			addTreatmentGroup: [
				'<div class="add-new">',
					'<div class="input-group group-name">',
						'<label>Name</label>',
						'<input type="text" name="groups[]">',
					'</div>',
					'<div class="input-group ranges">',
						'<label>Range (0--99)</label>',
						'<input type="text" name="ranges[]">',
					'</div>',
					'<div class="input-group value-dialog group-styles">',
						'<input name="styles[]" type="hidden" value="" />',
						'<span>Styles: <span class="value-empty-text">(none)</span><span class="value-present-text">(present)</span> <a class="wikia-button value-edit">Edit</a></span>',
					'</div>',
					'<div class="input-group value-dialog group-scripts">',
						'<input name="scripts[]" type="hidden" value="" />',
						'<span>Scripts: <span class="value-empty-text">(none)</span><span class="value-present-text">(present)</span> <a class="wikia-button value-edit">Edit</a></span>',
					'</div>',
				'</div>'
			].join(''),
			errorMessage: [
				'<div class="input-group error general-errors">',
					'<div class="error-msg"></div>',
				'</div>'
			].join(''),
			option: '<option></option>',
			warningMessage: [
				'<div class="error-msg">',
					'<p>Changing this value will create a new version of the experiment!</p>',
					'<button type="button" name="okay">Okay</button>',
					'<button type="button" name="cancel">Cancel</button>',
				'</div>'
			].join(''),
			textareaEditor: [
				'<form class="textarea-editor">',
					'<textarea></textarea>',
					'<div class="buttons">',
						'<button type="button" name="save">Save</button>',
						'<button class="secondary" type="button" name="cancel">Cancel</button>',
					'</div>',
				'</form>'
			].join('')
		},

		// Array of input names that may trigger a 'version change' warning.
		REGEX_versionChangeWarningNames = /^(start_time|end_time|ga_slot|groups\[\]|ranges\[\]|flag_.*)$/;

	// TODO: does this need to be a class? Will it ever need to be
	// instantiated more than once?
	var Editor = $.createClass(Object,{
		constructor: function(el) {
			this.el = el;
			el.on('click','tr.exp', $.proxy(this.toggleExperimentRow,this));
			el.on('click','[data-command]', $.proxy(this.clickCommand,this));
			this.setupShowPastCheckbox();
		},
		log: $.proxy($.fn.log,$()),
		msg: $.proxy(mw.msg,mw),
		toggleExperimentRow: function(ev) {
			if($(ev.target).is('button')) return;
			var target = $(ev.currentTarget);
			target.toggleClass('collapsed');
			if ( !target.hasClass('collapsed') ) {
				var details = target.next().find(':first-child');
				if ( $.trim(details.text()) == '' ) {
					this.loadExperimentDetails(target.data('id'),details);
				}
			}
		},
		loadExperimentDetails: function( id, detailsEl ) {
			$.nirvana.sendRequest({
				controller: 'SpecialAbTesting',
				method: 'experimentDetails',
				format: 'html',
				data: {
					id: id
				},
				callback: $.proxy(this.loadExperimentDetailsData,this,detailsEl),
				onErrorCallback: $.proxy(this.loadExperimentDetailsError,this,detailsEl)
			});
			detailsEl.find('.exp-throbber').startThrobbing();
		},
		loadExperimentDetailsData: function( detailsEl, html ) {
			detailsEl.find('.exp-throbber').stopThrobbing();
			detailsEl.html(html);
		},
		loadExperimentDetailsError: function( detailsEl, html ) {
			detailsEl.find('.exp-throbber').stopThrobbing();
			detailsEl.html(html);
		},
		clickCommand: function (ev) {
			var target = $(ev.currentTarget);
			var cmd = target.data('command');
			var id = target.closest('[data-id]').data('id');
			ev.preventDefault();
			switch (cmd) {
				case 'add-experiment':
					this.addExperiment();
					break;
				case 'edit-experiment':
					this.editExperiment(id);
					break;
			}
		},
		addExperiment: function() {
			$.nirvana.sendRequest({
				controller: 'SpecialAbTesting',
				method: 'modal',
				format: 'json',
				callback: $.proxy(this.showEditModal, this)
			});
		},
		addTreatmentGroup: function(e) {
			var button = $(e.currentTarget);
			button.parent('.input-group').before(templates.addTreatmentGroup);
		},
		editExperiment: function(id) {
			$.nirvana.sendRequest({
				controller: 'SpecialAbTesting',
				method: 'modal',
				format: 'json',
				data: {
					id: id,
					type: 'edit'
				},
				callback:$.proxy(this.showEditModal, this)
			});
		},
		showEditModal: function( response ) {
			var title = this.msg('abtesting-' + response.type + '-experiment-title'),
				modal = $.showModal( title, response.html, {
					closeOnBlackoutClick: false
				} );

			modal.find('input[type=submit]').click($.proxy(this.submitEditForm, this));
			modal.find('button[name=addTreatmentGroup]').click($.proxy(this.addTreatmentGroup, this));

			// Cache current experiment values and track changes to those values
			if (modal.find('.edit').exists()) {
				modal.find(':input').bind( 'change keyup', $.proxy(this.checkVersionChange, this)).each(function(i, input) {
					var $input = $( input );
					var val = !$input.is('[type=checkbox]') ? $input.val() : $input.attr('checked');
					$input.data( 'originalValue', val );
				});
			}

			modal.on('click', 'button[name=cancel]', $.proxy(this.cancelChange, this));
			modal.on('click', 'button[name=okay]', $.proxy(this.dismissWarning, this));

			modal.find('.datepicker :input').datetimepicker({
				dateFormat: 'yy-mm-dd',
				timeFormat: 'HH:mm:ss',
				showSecond: true
			});

			modal.on('click', '.value-dialog .value-edit', $.proxy(this.editHiddenTextarea,this));
		},
		cancelChange: function( e ) {
			var button = $( e.currentTarget ),
				inputGroup = button.closest( '.input-group' ),
				input = inputGroup.find( ':input' ),
				name = input.attr( 'name' );

			if ( !input.is('[type=checkbox]') ) {
				input.val( input.data( 'originalValue' ) );
			} else {
				input.data( 'originalValue' ) ? input.attr('checked','checked') : input.attr('checked',false);
			}
			this.removeWarning( inputGroup );
		},
		dismissWarning: function( e ) {
			var modal = $('#AbTestingEditForm').closest('.modalWrapper'),
				warnings = modal.find('.input-group > .error-msg'),
				inputGroup, input,
				self = this;

			modal.addClass('warning-dismissed');
			warnings.each(function(i,warning){
				inputGroup = $(warning).closest( '.input-group' );
				input = inputGroup.children( ':input' );
				input.addClass('dismissed');
				self.removeWarning( inputGroup );
			});
		},
		checkVersionChange: function( e ) {
			var input = $( e.currentTarget ),
				inputGroup = input.closest( '.input-group' ),
				name = input.attr( 'name' ),
				modal = $('#AbTestingEditForm').closest('.modalWrapper'),
				val = !input.is('[type=checkbox]') ? input.val() : input.attr('checked');

			// Issue warning for certain inputs if their value changes
			if ( REGEX_versionChangeWarningNames.test(name)
				&& !input.hasClass( 'dismissed' )
				&& !modal.hasClass( 'warning-dismissed' )
				&& val != input.data( 'originalValue' ) ) {
				if ( !inputGroup.hasClass('error') ) {
					inputGroup.addClass( 'error' ).append( templates.warningMessage );
				}
			} else {
				this.removeWarning( inputGroup );
			}
		},
		removeWarning: function( inputGroup ) {
			inputGroup.removeClass( 'error' ).find( '.error-msg' ).remove();
		},
		submitEditForm: function() {
			var self = this;
			$.nirvana.sendRequest({
				controller: 'SpecialAbTesting',
				method: 'save',
				format: 'json',
				data: $('#AbTestingEditForm').serialize(),
				callback: $.proxy(this.editFormResponse,this),
				onErrorCallback: function() {
					// todo: php error - show the message to the user about internal error
					self.log(arguments);
				}
			});
		},
		editFormResponse: function(response) {
			var form = $('#AbTestingEditForm'),
				modal = form.closest('.modalWrapper'),
				template, errorMessage;

			// Everything saved properly
			if ( response.status ) {
				modal.closeModal();

				var exp = this.el.find( '.exp[data-id=' + response.id + ']' );

				if ( exp.exists() ) {
					template = $( response.html );
					exp.next( '.details' ).replaceWith( template.filter( '.details' ) );
					exp.replaceWith( template.filter( '.exp' ) );

				} else {
					this.el.find( '.exp-add' ).before( response.html );
				}

			// There was an error
			} else {
				template = $( templates.errorMessage );
				errorMessage = template.find( '.error-msg' );

				// TODO: why is errors an array of arrays? should be array of strings
				$.each( response.errors, function( i, error ) {
					// Not sure if the above TODO was addressed, but this now seems
					// to be a string sometimes and not an array.
					var str = typeof error == 'string' ? error : error.join( '<br />' );
					errorMessage.html( errorMessage.html() + str + '<br />' );
				});

				form.find( '.general-errors' ).remove();
				form.append( template );
			}
		},
		editHiddenTextarea: function( ev ) {
			var self = this,
				inputGroup = $(ev.currentTarget).closest('.value-dialog'),
				input = inputGroup.find('input'),
				value = input.val(),
				title = inputGroup.hasClass('group-styles') ? 'Edit styles' : 'Edit script',
				modal = $.showModal( title, templates.textareaEditor, {
					closeOnBlackoutClick: false
				}),
				textarea = modal.find('textarea');

			textarea.val(input.val());
			modal
				.on('click','button[name=save]',function(){
					var value = textarea.val();
					modal.closeModal();
					input.val(value);
					inputGroup[value?'addClass':'removeClass']('value-active');
				})
				.on('click','button[name=cancel]',function(){
					modal.closeModal();
				});
		},
		setupShowPastCheckbox: function() {
			var self = this,
				el = $('#show-past-experiments'),
				off = $.storage.get('abtesting:showpast') || false;

			// load from localstorage
			if ( off ) {
				el.prop('checked', false);
				self.hidePast();
			}

			// bind
			el.on('change', function (e) {
				var state = el.is(':checked');

				if ( state ) {
					self.showPast();
				} else {
					self.hidePast();
				}

				$.storage.set('abtesting:showpast', state);
			});

		},
		hidePast: function() {
			$('tr.exp td.not-running').each( function() {
				$( this ).parent().addClass('collapsed').hide();
			});
		},
		showPast: function() {
			$('tr.exp td.not-running').each( function() {
				$( this ).parent().show();
			});
		}
	});

	// TODO: do we need to expose these globally?
	window.Wikia.AbTestEditor = Editor;
	$(function(){
		if ( !window.Wikia.AbTestEditorInstance ) {
			window.Wikia.AbTestEditorInstance = new Editor($('#AbTestEditor'));
		}
	});
})(window, jQuery);
