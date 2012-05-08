/*
 * @author Federico "Lox" Lucignano
 *
 * Features
 *	- Can be safely called multiple times on the same element to
 *	change/update tooltip content

 *	- supports a callback (accepts a reference to the target element
 *	and must return a value), a jQuery object reference or a scalar value
 *	as the tooltip content
 *
 *	- supports different positioning options
 *
 *Examples
 *	//passing a string
 *	$('#test').wikiaTooltip('this is a tooltip');
 *
 *	//passing a jQuery object
 *	<div class="wikia-tooltip" id="test-tooltip">This is a tooltip</div>
 *	$('#test').wikiaTooltip($('#test-tooltip'));
 *
 *	//passing a callback returning a string
 *	$('#test').wikiaTooltip(function(elm){return elm.id + Math.random();});
 *
 *	//passing a callback returning a jQuery object
 *	$('#test').wikiaTooltip(function(elm){return $('#' + elm.id + '-tooltip');});
 *
 *	//customizing options
 *	$('#test').wikiaTooltip('this is a tooltip', {position: 'relative', top: -15, left: 20});
 *
 *	//change tooltip on the fly
 *	$('#test').wikiaTooltip('this is a tooltip aligned top-left');
 *	$('#test').wikiaTooltip('and this is a tooltip aligned bottom-right', {side: 'bottom', align: 'right'});
 *
 *	//loading asynchronously the script
 *	$.loadWikiaTooltip(function(){$('#test').wikiaTooltip('this is a tooltip');});
 *
 *	//loading the script and required stylesheet via PHP
 *	global $wgOut, $wgJsMimeType, $wgStylePath
 *	$wgOut->addScript("<script type=\"$wgJsMimeType\" src=\"$wgStylePath/common/jquery/jquery.wikia.tooltip.js\"></script>");
 *	$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/modules/WikiaTooltip.scss'));
 */

if(typeof jQuery.fn.wikiaTooltip === 'undefined'){
	jQuery.fn.wikiaTooltip = function(tooltip, options) {
		if(typeof tooltip !== 'undefined'){
			var defaultOptions = jQuery.extend(
				{
					//position should be calculated relative to the element parent (for relative-positioned elements)
					relativeToParent: false,
					//include margins in size calculations
					includeMargin: true,
					//suppress native title tooltip
					suppressNative: true,
					//if suppressNative is true this will
					//make it recursive
					suppressNativeRecursive: false,
					//class name to assign to the tooltip
					//element
					className: 'wikia-tooltip',
					//positioning rule,
					//auto/relative/absolute(to document's body)
					position: 'auto',
					//On which side of the target element
					//the tooltip should appear, used only
					//if position is auto or relative
					side: 'top',
					//The alignment of the tooltip element
					//relative to the target element, used
					//only if position is auto or relative
					align: 'left',
					//top position for the tooltip element,
					//used only if position is absolute or
					//relative, left/center/right for top
					//and bottom sides, top/middle/bottom
					//for left and right sides
					top: 0,
					//left position for the tooltip element,
					//used only if position is absolute or
					//relative
					left: 0,
					//disntance of the tooltip element's nearest side from the target element side specified in the side option,
					//used only if position is auto
					distance: 0,
					// if set, don't let tooltip to be wider than this value
					maxWidth: false,
					// If set to true, tooltip will stay open while hovering over the message.
					hoverStay: false
				},
				options
			);

			var requestor = $(this);

			if(typeof requestor.data('tooltip-options') !== 'undefined'){
				requestor
					.removeData('tooltip-options')
					.removeData('tooltip-value')
					.removeData('tooltip-cached-position')
					.removeData('tooltip-native');

				if(typeof requestor.data('tooltip-cached') !== 'undefined'){
					requestor.data('tooltip-cached').remove();
					requestor.removeData('tooltip-cached');
				}
			}

			requestor.data('tooltip-options', defaultOptions);
			requestor.data('tooltip-value', tooltip);

			if(defaultOptions.suppressNative){
				requestor.removeAttr('title');
				if(defaultOptions.suppressNativeRecursive) {
					requestor.find('[title]').removeAttr('title');
				}
			}

			requestor
				.unbind('mouseenter.wikiaTooltip mouseleave.wikiaTooltip')
				.bind({
					'mouseenter.wikiaTooltip': jQuery.__wikiaTooltipOnMouseEnter,
					'mouseleave.wikiaTooltip': jQuery.__wikiaTooltipOnMouseLeave
				});

                        // Timer functions for keeping message open when hovering over it.
                        if(defaultOptions.hoverStay){
                            var timers = {
                                handle: false,
                                hideTip: function(){
                                    $('.wikia-tooltip').hide();
                                },
                                setTime: function(){
                                    this.handle = setTimeout(this.hideTip,300);
                                },
                                clearTime:function(){
                                    clearTimeout(this.handle);
                                }
                            }

                            requestor.data('timers',timers);
                        }
		}
	};

	/*
	 * shared callback for mouseenter event
	 */
	jQuery.__wikiaTooltipOnMouseEnter = function(){
		var elm = $(this);
		var options = elm.data('tooltip-options');
		var tooltip = elm.data('tooltip-cached');
        var timers = elm.data('timers');
		var position = {};

		if(typeof tooltip === 'undefined'){
			tooltip = elm.data('tooltip-value');

			switch(typeof tooltip){
				case 'object':
					break;
				case 'function':
					tooltip = tooltip(elm);

					if(typeof tooltip === 'object') {
						break;
					}
				default:
					//could use HTML5 details tag, but support for Monobook is preferred
					tooltip = $('<div>' + tooltip.toString() + '</div>');
					// If we're setting a width, we want to allow the text to wrap
					if(!options.maxWidth){
					    position['white-space'] = 'nowrap';
					}
					$('body').append(tooltip);
					break;
			}

			if(!tooltip.hasClass(options.className)) {
				tooltip.addClass(options.className);
			}

			elm
				.data('tooltip-cached', tooltip)
				.removeData('tooltip-cached-position');
		}

		var globalPosition = (options.relativeToParent) ? elm.position() : elm.offset();
		var cachedPosition = elm.data('tooltip-cached-position');

		if(typeof cachedPosition === 'undefined' ||
			((typeof cachedPosition !== 'undefined') &&
				(globalPosition.top != cachedPosition.top || globalPosition.left != cachedPosition.left ) &&
				options.position !== 'absolute'
			)
		){
			switch(options.position){
				case 'absolute':
					position.top = options.top;
					position.left = options.left;
					break;
				case 'auto':
				case 'relative':
				default:
					switch(options.side){
						case 'bottom':
							position.top = globalPosition.top + elm.outerHeight(options.includeMargin);
							position.left = jQuery.__wikiaTooltipGetAlignedPosition(options, globalPosition, elm, tooltip);
							break;
						case 'left':
							position.left = globalPosition.left - tooltip.outerWidth(options.includeMargin);
							position.top = jQuery.__wikiaTooltipGetAlignedPosition(options, globalPosition, elm, tooltip);
							break;
						case 'right':
							position.left = globalPosition.left + elm.outerWidth(options.includeMargin);
							position.top = jQuery.__wikiaTooltipGetAlignedPosition(options, globalPosition, elm, tooltip);
							break;
						case 'top':
						default:
							position.top = globalPosition.top - tooltip.outerHeight(options.includeMargin);
							position.left = jQuery.__wikiaTooltipGetAlignedPosition(options, globalPosition, elm, tooltip);
							break;
					}

					break;
			}

			if(options.position === 'relative'){
				position.top += options.top;
				position.left += options.left;
			}

			elm.data('tooltip-cached-position', globalPosition);
			tooltip.css(position);
		}

		if(options.maxWidth){
			tooltip.css('width',options.maxWidth);
		}

		tooltip.show();

		// If hoverStay is set, clear timout for hiding message
		// because we just hovered over the trigger element
		if(options.hoverStay) {
			timers.clearTime();
		}
	};

	/*
	 * shared callback for mouseleave event
	 */
	jQuery.__wikiaTooltipOnMouseLeave = function(){
        var elm = $(this),
            options = elm.data('tooltip-options'),
            tooltip = elm.data('tooltip-cached'),
            timers = elm.data('timers');

            // If hoverStay is set, start timeout for hiding message.
            if(options.hoverStay){
                timers.setTime();
                tooltip.mouseenter(function(){
                    timers.clearTime();
                }).mouseleave(function(){
                    timers.setTime();
                });
            } else {
                 tooltip.hide();
            }
	};

	/*
	 * Utility method to calculate tooltip element aligned position
	 */
	jQuery.__wikiaTooltipGetAlignedPosition = function(options, globalPosition, elm, tooltip){
		var pos;

		if(options.side === 'top' || options.side === 'bottom'){
			switch(options.align){
				case 'left':
				default:
					pos = globalPosition.left;
					break;
				case 'center':
					pos = globalPosition.left + ((elm.outerWidth(options.includeMargin) - tooltip.outerWidth(options.includeMargin)) / 2);
					break;
				case 'right':
					pos = globalPosition.left + elm.outerWidth(options.includeMargin) - tooltip.outerWidth(options.includeMargin);
					break;
			}
		}else if(options.side === 'left' || options.side === 'right'){
			switch(options.align){
				default:
				case 'top':
					pos = globalPosition.top;
					break;
				case 'middle':
					pos = globalPosition.top +  ((elm.outerHeight(options.includeMargin) - tooltip.outerHeight(options.includeMargin)) / 2);
					break;
				case 'bottom':
					pos = globalPosition.top + elm.outerHeight(options.includeMargin) - tooltip.outerHeight(options.includeMargin);
					break;
			}
		}

		return pos;
	};
}
