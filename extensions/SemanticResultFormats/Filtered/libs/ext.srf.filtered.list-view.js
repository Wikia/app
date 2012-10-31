/**
 * File holding the list-view plugin
 * 
 * For this plugin to work, the filtered plugin needs to be available first.
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

(function ($) {

	var methods = {
		
		init: function( args ){
			return this;
		},
		
		alert: function(){
			alert('List View!');
			return this;
		},
		
		updateItem: function(params){

			var view = this.children('.filtered-views').children('.filtered-list');
			
			if ( params.visible ) {
				view.children('.' + params.item ).slideDown( 200 );
			} else {
				view.children('.' + params.item ).slideUp( 200 );
			}
			return this;
		},
		
		updateAllItems: function(){

			var filtered = this;
			var items = this.children('.filtered-views').children('.filtered-list').children();
			
			items.each(function(){
				
				var $this = $(this)
				var id = $this.attr('id');
				
				if (filtered.filtered('isVisible', id)) {
					$this.slideDown(0);
				} else {
					$this.slideUp(0);
				}
				
			});
			
		}
		
	};

	listView = function( method ) {
  
		// Method calling logic
		if ( methods[method] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.filtered.listView' );
		}    


	};

	// attach ListView to all Filtered query printers
	// let them sort out, if ListView is actually applicable to them
	jQuery('.filtered').filtered('attachView', 'list', listView );

})(jQuery);

