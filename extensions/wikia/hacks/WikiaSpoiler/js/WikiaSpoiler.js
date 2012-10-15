$(function() {
	WikiaSpoiler.init();
});

var WikiaSpoiler = {
	hiddenClassName: 'wikiaspoilerhidden',
	levelClassPrefix: 'wikiaspoiler-',
	init: function() {
	    $('.wikiaspoilerselect').change(function() {
		    var selectedIndex = $('.wikiaspoilerselect').val();
		    var spoilers = $('.wikiaspoiler');
		    for (var i=0; i<spoilers.length; i++) {
			    var classList = $(spoilers[i]).attr('class').split(/\s+/);
			    $.each( classList, function(index, spoilerClassName){
				    if (spoilerClassName.match(/wikiaspoiler-\d+/)) {
					    var classIndex = spoilerClassName.substr(WikiaSpoiler.levelClassPrefix.length);
					    if (classIndex <= selectedIndex) {
						    // show
						    $(spoilers[i]).removeClass(WikiaSpoiler.hiddenClassName);
					    }
					    else {
						    // hide
						    $(spoilers[i]).addClass(WikiaSpoiler.hiddenClassName);
					    }
				    }
			    });
		    }
	    });
    }
}