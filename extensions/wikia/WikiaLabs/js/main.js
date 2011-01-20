WikiLabs = {};

$(function() {
	WikiLabs.init();	
});

WikiLabs.init = function() {
	$('#addProject').click(function(){
		$.ajax({
			url: wgScript + '?action=ajax&rs=WikiaLabs::getProjectModal',
			dataType: "html",
			method: "post", //post to prevent cache
			success: function(data) {
				var modal =	$(data).makeModal({ width : 650});
				modal.find('#saveProject').click(function() {
					$.ajax({
						type: "POST",
						url: wgScript + '?action=ajax&rs=WikiaLabs::saveProject',
						data: modal.find('form').serialize(),
						success: function(msg){
							alert( "Data Saved: " + msg );
						}
					});
					return false;
				});
				modal.find('button.prjscreen').click(function() {
					WikiLabs.uploadImage(modal.find('.prjscreen'));
					return false;
				}); 
				
			}
		});
	});
} 

WikiLabs.uploadImage = function ( imgelement ) {
	$.loadYUI( function() {
		importStylesheetURI( wgExtensionsPath+ '/wikia/WikiaMiniUpload/css/WMU.css?'+wgStyleVersion );
		$.getScript(wgExtensionsPath+ '/wikia/WikiaMiniUpload/js/WMU.js?'+wgStyleVersion, function() {
			WMU_show();
			
			WMU_Event_OnLoadDetails = function() {
				$('#ImageColumnRow,#ImageSizeRow,#ImageWidthRow,#ImageLayoutRow').hide();
			};			

			WikiLabs.WMU_insertImage = function(event,body) {
				$.ajax({
				  url: wgScript + '?action=ajax&rs=WikiaLabs::getUrlImageAjax&name=' + $("#ImageUploadFileName").val(),
				  dataType: "json",
				  method: "get",
				  success: function(data) {
					if(data.status == "ok") {
						$().log(imgelement);
						imgelement.filter('img').attr('src', data.url );
						imgelement.filter('input').val($("#ImageUploadFileName").val());
					}
					WMU_close();
				  }
				});
				return false;
			}
			$("body").unbind('imageUploadSummary').bind( 'imageUploadSummary', WikiLabs.WMU_insertImage);
		});
	});
	return false;
}


