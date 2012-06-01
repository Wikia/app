jQuery(function($) {
	var RecentChanges = {
		init: function() {
			this.$table = $('.mw-recentchanges-table');
			this.$dropdown = this.$table.find('.WikiaDropdown');
			this.$submit = this.$table.find('input[type="submit"]');
			this.$submit.on('click.RecentChangesDropdown', $.proxy(this.saveFilters, this));
			this.$selectAll = this.$dropdown.find('.select-all');
			this.$selectAll.on('change', $.proxy(this.selectAll, this));

			this.dropdown = new Wikia.MultiSelectDropdown(this.$dropdown);
			this.dropdown.on('change', $.proxy(this.onChange, this));
		},
		onChange: function(event) {
			var $checkbox = $(event.target);

			if (this.$selectAll.is(':checked')) {
				this.$selectAll.toggleClass('modified', this.dropdown.getItems().length != this.dropdown.getSelectedItems().length);
			}	
		},
		saveFilters: function(event) {
			var self = this;

			event.preventDefault();

			$.nirvana.sendRequest({
				controller: 'RecentChangesController',
				method: 'saveFilters',
				data: {
					filters: self.dropdown.getSelectedValues()
				},
				type: 'POST',
				format: 'json',
				callback: function(data) {
					window.location.reload();
				}
			});
		},
		selectAll: function(event) {
			var checked = this.$selectAll.removeClass('modified').is(':checked');

			this.dropdown
				.getItems()
				.toggleClass('selected', checked)
				.find(':checkbox').prop('checked', checked);
		},
	};

	RecentChanges.init();
});
