//* IMAGE *//

window.PageLayoutBuilder = window.PageLayoutBuilder || {};

PageLayoutBuilder.inputEmpty = function (e) {
	$(e.target).unbind('focus', PageLayoutBuilder.inputEmpty).val("").removeClass("plb-empty-input");
}

$(function() {
	$('.plb-empty-input').focus(PageLayoutBuilder.inputEmpty);

	$("#plbForm").submit(function() {
		$("input.plb-empty-input, textarea.plb-empty-input ").val("");
	});
});

PageLayoutBuilder.uploadImage = function (size, name) {
	$.loadYUI( function() {
		importStylesheetURI( wgExtensionsPath+ '/wikia/WikiaMiniUpload/css/WMU.css?'+wgStyleVersion );
		$.getScript(wgExtensionsPath+ '/wikia/WikiaMiniUpload/js/WMU.js?'+wgStyleVersion, function() {
			WMU_show();
			
			WMU_Event_OnLoadDetails = function() {
				$('#ImageColumnRow,#ImageSizeRow,#ImageWidthRow,#ImageLayoutRow').hide();
			};			

			WMU_insertImage = function() {
				$.ajax({
				  url: wgScript + '?action=ajax&rs=layoutWidgetImage::getUrlImageAjax&name=' + $("#ImageUploadMWname").val() + "&size=" + size,
				  dataType: "json",
				  method: "get",
				  success: function(data) {
					if(data.status == "ok") {
						$("#imageboxdiv_" + name).css("width", (parseInt( data.size.width ) + 4) + "px");
						$("#imagediv_" + name).css("width", data.size.width + "px")
						.css("line-height", data.size.height + "px")
						.css('background-image', 'url("' +  data.url +'")');
						$("#" + name).val( $("#ImageUploadMWname").val()  + " | " + $("#ImageUploadCaption").val() );
						$("#thumbcaption").val($("#ImageUploadCaption").val());
					}
					WMU_close();
				  }
				});
			}
		});
	});
	return false;
}
//* END IMAGE *//