$(function(){
	var RecentChanges = {
		init: function(){
			//TODO: other selector
			$('.mw-recentchanges-table input[type=submit]').click(RecentChanges.saveFilters);

		},
		saveFilters: function(e) {
			e.preventDefault();
			$.nirvana.sendRequest({
				controller: 'RecentChangesController',
				method: 'saveFilters',
				data: { 'filters': RecentChanges.getFilter()},
				type: "POST",
				format: 'json',
				callback: function(data) {
					window.location.reload();
				}
			});
		},

		getFilter: function() {
			//TODO:  other selector ?
			var filters = [];
			var inputs = $('.mw-recentchanges-table input[type=checkbox]:checked');
			for( var i = 0; i < inputs.length; i++ ){
				filters.push($(inputs[i]).val());
			}
			return filters;
		}
	};
	RecentChanges.init();
});
