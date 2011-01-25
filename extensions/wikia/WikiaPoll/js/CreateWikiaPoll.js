$(function() {
	CreateWikiaPoll.init();
});

var CreateWikiaPoll = {

	init: function() {
		$(".CreateWikiaPoll")
			.find("ul").sortable({
				axis: "y",
				handle: ".drag",
				opacity: .8,
				stop: CreateWikiaPoll.renumber
			}).end()
			.find(".drag").live("mousedown", function(event) {
				event.preventDefault();
			}).end()
			.find(".trash").live("click", CreateWikiaPoll.remove).end()
			.find(".add-new a").click(CreateWikiaPoll.addNew);
		
	},
	
	addNew: function(event) {
		event.preventDefault();
		$(".CreateWikiaPoll .new-item").clone().removeClass("new-item").appendTo(".CreateWikiaPoll ul");
		CreateWikiaPoll.renumber();
	},
	
	remove: function() {
		$(this).closest("li").slideUp("fast", function() {
			$(this).remove();
			CreateWikiaPoll.renumber();
		})
	},
	
	renumber: function() {
		console.log("renumbering");
		$(".CreateWikiaPoll li:not('.new-item') label").each(function(i) {
			$(this).text("#" + (i + 1));
		});
	},
	
	showEditor: function() {
		var self = CreateWikiaPoll;
	
		// load CSS for editor popup and jQuery UI library (if not loaded yet) via loader function
		$.getResources([
			$.loadJQueryUI,
			wgExtensionsPath + '/wikia/WikiaPoll/css/CreateWikiaPoll.css?' + wgStyleVersion
		], function() {
			$.post(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=WikiaPoll&actionName=SpecialPage&outputType=html', function(data) {
				$.showModal('', data, {
					callback: function() {
						$().log("modal loaded");
					}
				});
			});
		});
	}

};