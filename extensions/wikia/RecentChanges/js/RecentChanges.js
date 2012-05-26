jQuery(function($) {
	var RecentChanges = {
		init: function() {
			this.$table = $('.mw-recentchanges-table');
			this.$dropdown = this.$table.find('.WikiaDropdown');
			this.$submit = this.$table.find('input[type="submit"]');
			this.$submit.on('click.RecentChangesDropdown', $.proxy(this.saveFilters, this));
			this.dropdown = new Wikia.MultiSelectDropdown(this.$dropdown);
			this.dropdown.on('change', $.proxy(this.onChange, this));
		},
		onChange: function(event) {
			var $checkbox = $(event.target);

			// Clear the list if 'all' is selected
			if ($checkbox.val() === 'all') {
				this.dropdown.getSelectedItems().filter(function(i, element) {
					var $element = $(element),
						$checkbox = $element.find(':checkbox');

					if ($checkbox.val() !== 'all') {
						$checkbox.removeAttr('checked');
						$element.removeClass('selected');
					}
				});

			// Otherwise, clear 'all'
			} else {
				this.$dropdown
					.find(':checkbox[value="all"]')
					.removeAttr('checked')
					.closest('li')
					.removeClass('selected');
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
		}
	};

	RecentChanges.init();
});
