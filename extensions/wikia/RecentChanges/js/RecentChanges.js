jQuery(function($) {
	//Used by AjaxRC
	window.Wikia = window.Wikia || {};
	
	var RecentChanges = {
		init: function() {
			this.$table = $('.mw-recentchanges-table');
			this.$dropdown = this.$table.find('.WikiaDropdown');
			this.$submit = this.$table.find('input[type="submit"]');
			this.$submit.on('click.RecentChangesDropdown', $.proxy(this.saveFilters, this));
			this.$submit.prop( 'disabled', false );

			this.dropdown = new Wikia.MultiSelectDropdown(this.$dropdown);
			this.dropdown.on('change', $.proxy(this.onChange, this));
		},

		saveFilters: function(event) {
			var self = this;

			event.preventDefault();

			self.dropdown.disable();
			self.$submit.prop( 'disabled', true );

			if(self.dropdown.getSelectedValues().length == 0) {
				self.dropdown.doSelectAll(true);
			}

			$.nirvana.sendRequest({
				controller: 'RecentChangesController',
				method: 'saveFilters',
				data: {
					filters: self.dropdown.getSelectedValues(),
					all: self.dropdown.everythingSelected() ? 1 : 0
				},
				type: 'POST',
				format: 'json',
				callback: function(data) {
					window.location.reload();
				}
			});
		}
	};

	RecentChanges.init();
	window.Wikia.RecentChanges = RecentChanges; //needed for AjaxRC
});
