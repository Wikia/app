/* 
 * @author Federico "Lox" Lucignano
 * 
 * Features
 *	- Can be safely called multiple times on the same element to change/update tooltip content
 *	- supports a callback (accepts a reference to the target element and must return a value),
 *	a jQuery object reference or a scalar value as the tooltip content
 */

if(typeof jQuery.fn.wikiaTooltip === 'undefined'){
	jQuery.fn.wikiaTooltip = function(tooltip, options) {
		if(typeof tooltip !== 'undefined'){
			var defaultOptions = jQuery.extend(
				{
					includeMargin: false,
					suppressNative: true,
					suppressNativeRecursive: false,
					className: 'wikia-tooltip',
					position: 'auto',
					side: 'top',
					align: 'center'
				},
				options
			);
			
			var requestor = $(this);
			
			if(typeof requestor.data('tooltip-options') !== 'undefined'){
				requestor.removeData('tooltip-options');
				requestor.removeData('tooltip-value');
				requestor.removeData('tooltip-cached-position');
				requestor.removeData('tooltip-native');
				
				if(typeof requestor.data('tooltip-cached') !== 'undefined'){
					requestor.data('tooltip-cached').remove();
					requestor.removeData('tooltip-cached');
				}
			}
			
			requestor.data('tooltip-options', defaultOptions);
			requestor.data('tooltip-value', tooltip);
			
			if(defaultOptions.suppressNative) requestor.removeAttr('title');
			if(defaultOptions.suppressNativeRecursive) requestor.find('[title]').removeAttr('title');
			
			requestor.unbind('mouseenter mouseleave').hover(
				function(event){
					var elm = $(this);
					var options = elm.data('tooltip-options');
					var tooltip = elm.data('tooltip-cached');

					if(typeof tooltip === 'undefined'){
						tooltip = elm.data('tooltip-value');

						switch(typeof tooltip){
							case 'object':
								break;
							case 'function':
								$().log('Running tooltip creation callback', 'tooltip-value');
								tooltip = tooltip(elm);

								if(typeof tooltip === 'object') break;
							default:
								$().log('Creating tooltip element', 'tooltip-value');
								tooltip = $('<div>' + tooltip.toString() + '</div>');
								$('body').prepend(tooltip);
								break;
						}

						$().log('Setting up tooltip element', 'tooltip-value');
						if(!tooltip.hasClass(options.className)) tooltip.addClass(options.className);

						//TODO: move to SASS file
						tooltip.css({
							'display': 'none',
							'position': 'absolute',
							'z-index': '200000',
							'background-color': 'red',
							'color': 'white'
						});

						elm.data('tooltip-cached', tooltip);
						elm.removeData('tooltip-cached-position');
					} else {
						$().log('Using cached tooltip element', 'tooltip-value');
					}
					
					var globalPosition = elm.offset();
					var cachedPosition = elm.data('tooltip-cached-position');
					
					if(typeof cachedPosition === 'undefined' ||
						((typeof cachedPosition !== 'undefined') &&
							(globalPosition.top != cachedPosition.top || globalPosition.left != cachedPosition.left )
						)
					){
						$().log('Calculating tooltip element position', 'tooltip-value');
						var position = {};

						switch(options.side){
							default:
							case 'top':
								position.top = globalPosition.top - tooltip.outerHeight(options.includeMargin);
								position.left = globalPosition.left;
								break;
							case 'bottom':
								position.top = globalPosition.top + elm.outerHeight(options.includeMargin);
								position.left = globalPosition.left;
								break;
							case 'left':
								position.left = globalPosition.left - tooltip.outerWidth(options.includeMargin);
								position.top = globalPosition.top;
								break;
							case 'right':
								position.left = globalPosition.left + elm.outerWidth(options.includeMargin);
								position.top = globalPosition.top;
								break;
						}
						
						elm.data('tooltip-cached-position', globalPosition);
						tooltip.offset(position);
					} else {
						$().log('Using previously calculated tooltip element position', 'tooltip-value');
					}
					

					$().log('Show', 'tooltip-value');
					tooltip.show();
				},
				function(){
					$().log('Hide', 'tooltip-value');
					$(this).data('tooltip-cached').hide();
				}
			);
		}
	}
}