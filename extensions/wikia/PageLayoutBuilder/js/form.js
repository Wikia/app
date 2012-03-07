(function(window,$){
	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	WE.plugins.plbpagecontrols = $.createClass(	WE.plugins.pagecontrols,{
		init: function() {
			var self = this;
			this.titleNode = $();
			$('#wpPreview').click(function(){
				self.updateEditedTitle();
				var values = $('#WikiaArticle form').serializeArray();
				var fromValues = {};
				for(var i = 0;i < values.length; i++) {
				    if(values[i].name.indexOf('plb_') === 0) {
				        fromValues[values[i].name] = values[i].value ? values[i].value:"";
				    }
				}
				
				fromValues['plbId'] = $.getUrlVar('plbId');
				self.renderPreview(fromValues);
				return false;
			});
	
		}
	});
	
})(this,jQuery);


$(function() {
	$('#csMainContainer').removeClass('csEditMode');
	$('#csCategoryInput').attr('placeholder','').hide();
	initCatSelectForEdit();
}); 