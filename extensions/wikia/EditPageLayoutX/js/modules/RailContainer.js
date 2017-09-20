(function(window){

	var WE = window.WikiaEditor;

	WE.modules.RailContainer = $.createClass(WE.modules.Container,{
		
		afterRenderChild: function( no, module, el ) {
			el = WE.modules.RailContainer.superclass.afterRenderChild.call(this,no,module,el);
			
			var html = '';
			var headerText = module.getHeaderText();
			var headerClass = module.getHeaderClass();
			
			var collapse = '<img src="' + wgBlankImgUrl + '" class="chevron collapse" />';
			html += '<div class="module module_' + headerClass + '" data-id="' + headerClass + '">';
			html += headerText ? '<h3><span>' + ($.htmlentities(headerText) || '') + '</span>' + collapse + '</h3>' : '';
			html += '<div class="module_content"></div>';
			html += '</div>';
			var wrapper = $(html);
			wrapper.find('.module_content').append(el);
			var headerDom = wrapper.find('h3').first().children('span').first();
			module.on({
				headerchange: function( module, text ) {
					headerDom.text(text);
				},
				hide: function() {
					wrapper.hide();
				},
				show: function() {
					wrapper.show();
				}
			});
			
			this.editor.collapsiblemodules && this.editor.collapsiblemodules.add(this,wrapper);
			
			return wrapper;
		}
		
	});
	
	WE.modules.railcontainer = WE.modules.RailContainer;

})(this);