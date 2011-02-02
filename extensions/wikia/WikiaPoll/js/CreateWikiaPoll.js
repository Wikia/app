$(function() {
	if (wgAction != "edit" && wgAction != "submit"){
		// only init on special page
		CreateWikiaPoll.init();
	}
});

var CreateWikiaPoll = {

	init: function() {
		$("#CreateWikiaPoll")
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
			.find(".add-new a").click(CreateWikiaPoll.addNew).end()
			.find(".create").click(CreateWikiaPoll.onSave);
		if ($("#CreateWikiaPoll").closest(".modalWrapper")) {
			// Presented in modal. Do specific modal stuff
			$("#CreateWikiaPoll").find(".cancel").click(function(event) {
				event.preventDefault();
				$(this).closest(".modalWrapper").closeModal();
			});
		}		
	},
	
	addNew: function(event) {
		event.preventDefault();
		$("#CreateWikiaPoll .new-item").clone().removeClass("new-item").appendTo("#CreateWikiaPoll ul");
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
		$("#CreateWikiaPoll li:not('.new-item') label").each(function(i) {
			$(this).text("#" + (i + 1));
		});
	},
	
	showEditor: function() {
		var self = CreateWikiaPoll;
	
		// load CSS for editor popup and jQuery UI library (if not loaded yet) via loader function
		$.getResources([
			$.loadJQueryUI,
			wfGetSassUrl('/extensions/wikia/WikiaPoll/css/CreateWikiaPoll.scss'),
			wgExtensionsPath + '/wikia/WikiaPoll/js/CreateWikiaPoll.js?' + wgStyleVersion
		], function() {
			$.get(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=WikiaPoll&actionName=SpecialPage&outputType=html', function(data) {
				$(data).makeModal({width: 600});
				$().log("modal loaded");
				CreateWikiaPoll.init();
			});
		});
	},
	
	onSave: function(event) {
		event.preventDefault();
		$.get(wgScript + '?action=ajax&rs=WikiaPollAjax&method=create', $("#CreateWikiaPoll").find("form").serialize(), function(data) {
			console.log(data);
			if ($("#CreateWikiaPoll").closest(".modalWrapper").exists()) { // in modal
				if (data.success) {
					RTE.mediaEditor._add("{{" + data.question + "}}");
					$("#CreateWikiaPoll").closest(".modalWrapper").closeModal();
				} else if (data.error) {
					$("#CreateWikiaPoll").find(".errorbox").remove().end().prepend(data.error);
				}
			} else { // Special:Poll
				if (data.success) {
					document.location = data.url;				
				} else if (data.error) {
					$("#CreateWikiaPoll").find(".errorbox").remove().end().prepend(data.error);
				}
			}
		});		
	}

};