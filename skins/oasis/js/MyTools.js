$(function() {
	MyTools.init();
});

var MyTools = {

	init: function() {
		$("#my-tools-menu").find(".my-tools-edit").click(MyTools.loadDialog);
	},

	loadDialog: function(event) {
		event.preventDefault();
		importStylesheetURI(wfGetSassUrl("skins/oasis/css/core/_MyTools.scss"));
		$().getModal("/index.php?action=ajax&rs=moduleProxy&moduleName=MyTools&actionName=Configuration&outputType=html", "#MyToolsConfiguration", {callback: MyTools.configureDialog});
	},

	configureDialog: function(event) {

		$("#MyToolsConfiguration").find('form').submit(function(event) {
			event.preventDefault();
			return false;
		});

		//save mytools
		$("#MyToolsConfiguration").find('input[type=submit]').click(function(event) {
			event.preventDefault();
			$('#MyToolsConfigurationWrapper').closeModal();

			var tools = [];

			$("#MyToolsConfiguration .list li").each(function() {
				tools.push(this.className);
			});

			$.post(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=MyTools&actionName=Index&outputType=html',
				{moduleParams: $.toJSON({tools: tools})},
				function(html) {
						$('#my-tools-menu').find('li').filter('.custom').remove();
						$(html).find('li').filter('.custom').prependTo('#my-tools-menu');
				}
			);

		});

		$.getScript(stylepath + '/common/jquery/jquery.autocomplete.js', function() {
			$("#MyToolsConfiguration").find('.search').autocomplete({
				serviceUrl: wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=MyTools&actionName=Suggestions&outputType=data',
				onSelect: function(value, data) {
					var drag = '<img src="' + stylepath + '/common/blank.gif" class="drag">';
					var trash = '<img src="' + stylepath + '/common/blank.gif" class="trash">';
					$("#MyToolsConfiguration").find('input[type=text]').val('');
					$('<li>').addClass(data).html(drag + value + trash).appendTo("#MyToolsConfiguration .list");
				},
				selectedClass: 'selected',
				appendTo: '#MyToolsConfiguration form',
				width: '270px'
			});

			$("#MyToolsConfiguration").find(".list").sortable({
				axis: "y",
				handle: ".drag",
				opacity: .8
			});
		});

		//delete tool
		$("#MyToolsConfiguration .trash").live("click", function() {
			$(this).closest("li").slideUp("fast", function() {
				$(this).remove();
			});
		});

	}
};
