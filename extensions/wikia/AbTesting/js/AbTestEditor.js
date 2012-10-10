(function(window, $, undefined) {
	var mw = window.mw,
		templates = {
			addTreatmentGroup: [
				'<div class="add-new">',
					'<div class="input-group">',
						'<label>Name</label>',
						'<input type="text" name="groups[]">',
					'</div>',
					'<div class="input-group">',
						'<label>Range</label>',
						'<input type="text" name="ranges[]">',
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
			].join('')
		},

		// Array of input names that may trigger a 'version change' warning.
		versionChangeWarningNames = [ 'control_group_id', 'end_time', 'ga_slot', 'groups[]', 'ranges[]', 'start_time' ];

	// TODO: does this need to be a class? Will it ever need to be
	// instantiated more than once?
	var Editor = $.createClass(Object,{
		constructor: function(el) {
			this.el = el;
			el.on('click','tr.exp', $.proxy(this.toggleExperimentRow,this));
			el.on('click','[data-command]', $.proxy(this.clickCommand,this));
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
		showDetails: function( id, html ) {
			var tr = typeof id == 'number' ? this.el.find('tr.exp[data-id='+id+']') : id;
			tr.next().find(':first-child');
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
				modal = $.showModal( title, response.html );

			modal.find('input[type=submit]').click($.proxy(this.submitEditForm, this));
			modal.find('button[name=addTreatmentGroup]').click($.proxy(this.addTreatmentGroup, this));

			// Cache current experiment values and track changes to those values
			if (modal.find('.edit').exists()) {
				modal.find(':input').bind( 'change keyup', $.proxy(this.checkVersionChange, this)).each(function(i, input) {
					var $input = $( input );
					$input.data( 'originalValue', $input.val() );
				});
			}

			// Rebuild control groups dropdown when groups are added/removed/changed
			modal.on('change', '[name="groups[]"]', $.proxy(this.rebuildControlGroups, this));
			modal.on('click', 'button[name=cancel]', $.proxy(this.cancelChange, this));
			modal.on('click', 'button[name=okay]', $.proxy(this.dismissWarning, this));

			modal.find('.datepicker :input').datetimepicker({
				dateFormat: 'yy-mm-dd',
				timeFormat: 'hh:mm:ss',
				showSecond: true
			});
		},
		cancelChange: function( e ) {
			var button = $( e.currentTarget ),
				inputGroup = button.closest( '.input-group' ),
				input = inputGroup.children( ':input' ),
				name = input.attr( 'name' );

			input.val( input.data( 'originalValue' ) );
			this.removeWarning( inputGroup );
		},
		dismissWarning: function( e ) {
			var button = $( e.currentTarget ),
				inputGroup = button.closest( '.input-group' ),
				input = inputGroup.children( ':input' ),
				name = input.attr( 'name' );

			input.addClass( 'dismissed' );
			this.removeWarning( inputGroup );
		},
		checkVersionChange: function( e ) {
			var input = $( e.currentTarget ),
				inputGroup = input.parent( '.input-group' ),
				name = input.attr( 'name' );

			this.removeWarning( inputGroup );

			// Issue warning for certain inputs if their value changes
			if ( $.inArray( name, versionChangeWarningNames ) >= 0
				&& !input.hasClass( 'dismissed' )
				&& input.val() != input.data( 'originalValue' ) ) {
				inputGroup.addClass( 'error' ).append( templates.warningMessage );
			}
		},
		rebuildControlGroups: function( e ) {
			var modal = $( e.currentTarget ).closest( '.modalWrapper' ),
				groups = modal.find('[name="groups[]"]'),
				select = modal.find('[name="control_group_id"]'),
				controlGroupId = select.find(':selected').val();

			select.empty();

			groups.each(function(i, group) {
				var $group = $(group),
					$option = $(templates.option),
					value = $group.data('id'),
					name = $group.val();

				if ( name ) {
					if ( value == controlGroupId ) {
						$option.attr( 'selected', true );
					}

					$option.attr( 'value', value );
					$option.text( name );

					select.append($option);
				}
			});
		},
		removeWarning: function( inputGroup ) {
			inputGroup.removeClass( 'error' ).find( '.error-msg' ).remove();
		},
		submitEditForm: function() {
			$.nirvana.sendRequest({
				controller: 'SpecialAbTesting',
				method: 'save',
				format: 'json',
				data: $('#AbTestingEditForm').serialize(),
				callback: $.proxy(this.editFormResponse,this),
				onErrorCallback: function() {
					// todo: php error - show the message to the user about internal error
					this.log(arguments);
				}
			});
		},
		editFormResponse: function(response) {
			var form = $('#AbTestingEditForm'),
				modal = form.closest('.modalWrapper');

			// Everything saved properly
			if ( response.status ) {
				modal.closeModal();

				var exp = this.el.find( '.exp[data-id=' + response.id + ']' );

				if ( exp.exists() ) {
					var template = $( response.html );
					exp.next( '.details' ).replaceWith( template.filter( '.details' ) )
					exp.replaceWith( template.filter( '.exp' ) );

				} else {
					this.el.find( '.exp-add' ).before( response.html );
				}

			// There was an error
			} else {
				var template = $( templates.errorMessage ),
					errorMessage = template.find( '.error-msg' );

				// TODO: why is errors an array of arrays? should be array of strings
				$.each( response.errors, function( i, error ) {
					errorMessage.html( errorMessage.html() + error.join( '<br />' ) + '<br />' );
				});

				form.find( '.general-errors' ).remove();
				form.append( template );
			}
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