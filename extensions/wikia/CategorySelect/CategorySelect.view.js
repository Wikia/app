/* CategorySelect */
// Ideally only run on view or purge, but if wgAction is not set, run it to be on the safe side.
if((typeof wgAction == "undefined") || (wgAction=="view") || (wgAction == "purge")){
	wgAfterContentAndJS.push(function() {
		$(".catlinks-allhidden").css("display", "block");
		$('#csAddCategorySwitch').children('a').click(function(ev) {
			ev.preventDefault();

			$.getResources([
				$.loadYUI,
				wgExtensionsPath + '/wikia/CategorySelect/CategorySelect.js'
			]).then(function() {
				showCSpanel();
			});

			$('#catlinks').addClass('csLoading');
		});
	});
}