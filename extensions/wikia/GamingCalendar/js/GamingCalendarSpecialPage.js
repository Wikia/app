var EditGamingCalendarEntries = {

	init: function() {
		var node = $("#EditGamingCalendarEntries");
        node
            .on("mousedown", ".drag", function(event) {
                event.preventDefault();
            })
            .on("click", ".trash", EditGamingCalendarEntries.remove)
            .on('click', ".add-new a", EditGamingCalendarEntries.addNew)
            .on('click', ".create", EditGamingCalendarEntries.onSave)
            .find("ul").sortable({
                axis: "y",
                handle: ".drag",
                opacity: 0.8,
                stop: EditGamingCalendarEntries.renumber
            });

		if( node.closest(".modalWrapper") ) {
			// Presented in modal. Do specific modal stuff
            node.find(".cancel").click(function(event) {
				event.preventDefault();
				$(this).closest(".modalWrapper").closeModal();
			});
		}
	},

	addNew: function(event) {
		event.preventDefault();
		$("#EditGamingCalendarEntries .new-item").clone().removeClass("new-item").appendTo("#EditGamingCalendarEntries ul");
		EditGamingCalendarEntries.renumber();
	},

	remove: function() {
		$(this).closest("li").slideUp("fast", function() {
			$(this).remove();
			EditGamingCalendarEntries.renumber();
		});
	},

	renumber: function() {
		$("#EditGamingCalendarEntries li:not('.new-item') label.order").each(function(i) {
			$(this).text("#" + (i + 1));
		});
		$("#EditGamingCalendarEntries input.correct").each(function(i) {
			$(this).val(i);
		});
	},

	onSave: function(event) {
		event.preventDefault();

		if ($("#EditGamingCalendarEntries").data('calendarentriesdate')) {
			// editing existing Calendar Entries
			$.post('/wikia.php?controller=GamingCalendarSpecialPage&method=updateCalendarEntriesForDate&format=json', $("#EditGamingCalendarEntries").find("form").serialize(), function(data) {
				if (data.res.success) {
					document.location = data.res.url;
				} else if (data.error) {
					$("#EditGamingCalendarEntries").find(".errorbox").remove().end().prepend(data.error);
				}
			});
		}
	}
};

$(function() {
	if (wgAction != "edit" && wgAction != "submit"){
		// only init on special page
		EditGamingCalendarEntries.init();
	}
});