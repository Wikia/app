/**
 * jQuery Rating Bar
 * --------------------------------------------------------------------------
 *
 * allRating is a fully customisable rating scale with inputs from radio, and select inputs.
 * allRating also comes with themes allowing you to select themes such as star, and bars.
 *
 * @version     0.1
 * @since       20/03/2011
 * @author      Dan Dunford (http://plugins.dunfy.me.uk/allrating)
 * @license	http://www.gnu.org/licenses/gpl.html GPL
 * @license     http://en.wikipedia.org/wiki/MIT_License MIT
 *
 * allRating Plugin by http://vantage-technologies.co.uk/ is licensed under the MIT License and the GPL License.
 * Copyright © 2011 http://vantage-technologies.co.uk/
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * @package     jQuery Plugins
 * 
 */

(function( $ ){
    $.rating = {
        defaults: {
            /** Class & ID Defines **/
            segmentContainerClass      : 'ratingSegmentContainer',
            segmentActiveClass         : 'ratingSegmentActive',
            segmentClassNonActiveClass : 'ratingSegmentNonActive',
            segmentClass               : 'ratingSegment',
            segmentDisabledClass       : 'ratingEditDisabled',
            segmentCancelClass         : 'ratingSegmentCancel',
            segmentEditClass           : 'ratingSegmentEdit',
            outerContainerClass        : 'rating',
            hoverClass                 : 'ratingHoverContainer',
            ratingContainerId          : 'ratingContainer',
            clearClass                 : 'ratingClear',

            /** Choose Theme **/
            theme                      : 'star', //star, bar, medal, tinystar
            
            /** Options **/
            input                      : 'select', //the input type, select or radio
            existingRatingOnEdit       : false,
            showHover                  : true,     //should display the current rating via hover
            disabled                   : false,    //can the rating be changed? You can also disable rating edit by setting the select box to disabled.

            /** Events **/
            onClickEvent                : function(value, input) { }

            /** Not yet implemented **/
            /** outputScaleCount    : 10,       //scale the rating back, or up to given number **/
        }
    }

    /**Main Code**/
    $.fn.allRating = function(options) {
		// Handle API methods
		if(typeof arguments[0]=='string'){
			// Perform API methods on individual elements
			if(this.length>1){
				var args = arguments;
				return this.each(function(){
					$.fn.rating.apply($(this), args);
				});
			};
			// Invoke API method handler
			$.fn.allRating[arguments[0]].apply(this, $.makeArray(arguments).slice(1) || []);
			// Quick exit...
			return this;
		};    	
    	
        var config = $.extend({}, $.rating.defaults, options);

        this.each( function() {

            var index = $.fn.allRating._ui();

            $.fn.allRating.init(this, config, index);

            var input = $.fn.allRating.fetchInput( this, config, index );
            var html = $.fn.allRating.generateHtml(input, config);

            $(this).after(html);

            $.fn.allRating.addActiveStars(input, config, true);

            $.fn.allRating.initEvents(input, config);
        });

        return this;
    };

    /**Private Functions**/
    $.fn.allRating.init = function(item, config, index ) {
        //hide select box and replace with new rating
        $(item).hide();

        //if the input element has no id, create one
        if(!$(item).attr('id')) {
            $(item).attr('id', config.ratingContainerId+'-'+index+'-input');
        }
    };

    $.fn.allRating.fetchInput = function(item, config, index ) {

        var input = {};
        this.config = config;

        //fetch input details
        input.item          = $(item);
        input.Id            = $(item).attr('id');
        if(typeof(item) == 'string')
            input.ratingId = item.replace('#','').replace('-input','');
        else
            input.ratingId = config.ratingContainerId+'-'+index;
                

        switch(config.input) {
            case 'select':
                input.options       = $(item).find('option');
                input.optionCount   = $(input.options).length - 1;
                input.selectedValue = $(item).find('option:selected').val();
                var selectedText    = $(item).find('option:selected').text();
                input.selectedText  = (null == selectedText) ? 'Not Rated' : selectedText;
                input.disabled      = $(item).is(':disabled');
                break;
            case 'radio' :
                input.options       = $(item).find('input');
                input.optionCount   = $(input.options).length - 1;
                input.selectedValue = $(item).find('input[type=radio]:checked').val();
                var selectedText    = $('label[for=' + $(item).find('input[type=radio]:checked').attr('id') + ']').html()
                input.selectedText  = (null == selectedText) ? 'Not Rated' : selectedText;
                input.disabled      = $(item).hasClass(config.segmentDisabledClass);
                break;
            default:
                return input;
        }

        return input;
    };

    $.fn.allRating.generateHtml = function(input, config) {
        
        var segmentCollection = $.fn.allRating.generateSegments(input, config);
        var hoverContainer  =
        '<div class="'+config.hoverClass+' '+config.theme+'">'+
        '<label class="existingRating">' + input.selectedText + '</label>'+
        '<label class="newRating"></label>'+
        '<div class="' + config.clearClass + '"></div>'+
        '</div>';

        return '<div class="' + config.outerContainerClass + ' ' + config.theme + '" id="' + input.ratingId + '">'+
        hoverContainer + '<div class="' + config.segmentContainerClass + '">' + segmentCollection + '</div>'+
        '</div><div class="' + config.clearClass + '">'+
        '</div>';

    };

    $.fn.allRating.generateSegments = function(input, config) {
        return $.fn.allRating.generateSegmentHtml(config, input);
    };

    $.fn.allRating.generateSegmentHtml = function(config, input) {
        var segmentCollection = '';
        var disabled = '';
        if(input.disabled)
            disabled = config.segmentDisabledClass;

        $(input.options).each(function() {
            segmentCollection = 
            segmentCollection + '<a class="' + config.segmentClass + ' ' + disabled + ' ' +
            config.segmentClassNonActiveClass + ' '+
            config.theme + '" rel="' + $(this).val() + '" href="#' + input.ratingId + '"></a>';
        });

        if(false && !input.disabled) { // TODO
            segmentCollection =
                segmentCollection + '<a class="' + config.segmentCancelClass + ' '+
                config.theme + '" rel="cancel" href="#' + input.ratingId + '"></a>';
        }

        return segmentCollection;
    }

    $.fn.allRating.addActiveStars = function(input, config, original) {
    	
        if(original) {
           $('#' + input.ratingId + ' .'+config.segmentContainerClass).find('a[rel="' + input.selectedValue + '"]').addClass('original');
        }
        $('#' + input.ratingId + ' .'+config.segmentContainerClass+' a:not(.'+config.segmentCancelClass+')').removeClass(config.segmentActiveClass).addClass(config.segmentClassNonActiveClass);
        $('#' + input.ratingId + ' .'+config.segmentContainerClass).find('a[rel="' + input.selectedValue + '"]').removeClass(config.segmentClassNonActiveClass).addClass(config.segmentActiveClass);
        $('#' + input.ratingId + ' .'+config.segmentContainerClass).find('a[rel="' + input.selectedValue + '"]').prevAll('a').each(function() {
            $(this).removeClass(config.segmentClassNonActiveClass).addClass(config.segmentActiveClass);
        });
    };
    
    $.extend($.fn.allRating, {
    	setValue: function( value ) {
            var inputId = $(this).attr('id');
            var config = $.extend({}, $.rating.defaults, this.options);
            //var input = $.fn.allRating.updateInput('#'+inputId, value, config);
        }
    });
    
    $.fn.allRating.initEvents = function(input, config) {
        $.fn.allRating.initClickEvents(input, config);
        $.fn.allRating.initHoverEvents(input, config);
    };

    $.fn.allRating.initClickEvents = function(input, config) {

        $('#'+input.ratingId+' .'+config.segmentClass).click(function() {
            //this is here to also stop disabled segments 
            if(!$(this).hasClass(config.segmentDisabledClass)) {
                $(this).siblings('.'+config.segmentCancelClass).fadeIn();
                
                var inputId = $(this).attr('href')+'-input';
                var newValue = $(this).attr('rel');
                var input = $.fn.allRating.updateInput(inputId, newValue, config);
                config.onClickEvent(input);
            }
            
            return false;
        })

        $('#'+input.ratingId+' .'+config.segmentCancelClass).click(function() {
            if($($(this).attr('href') + ' .'+config.segmentContainerClass+' .original').length > 0)
                $($(this).attr('href') + ' .'+config.segmentContainerClass+' .original').click();
            else
                $.fn.allRating.updateInput($(this).attr('href')+'-input', null, config);

            var input = $.fn.allRating.fetchInput( $(this).attr('href')+'-input', config );
            $.fn.allRating.addActiveStars(input, config);
            $(this).fadeOut();
            return false;
        });
    };

    $.fn.allRating.updateInput = function(inputId, newValue, config){
        switch(config.input) {
            case 'select' :
            	alert(inputId);
                $(inputId).val(newValue);
                return $(inputId); //return the original input 
                break;
            case 'radio' :
                if(newValue != null)
                    $(inputId+' input[type=radio]').filter('[value='+newValue+']').attr('checked', 'checked');
                else
                    $(inputId+' input[type=radio]').attr('checked',false);
                
                return $(inputId+' input[type=radio]').filter('[value='+newValue+']'); //return the original selected input

                break;
        }
    };

    $.fn.allRating.findTextFromValue = function(input, value, config) {
        switch(config.input) {
            case 'select':
                return $('#'+input.ratingId+'-input option[value="'+value+'"]').text();
                break;
            case 'radio':
                return $('label[for=' + $('#'+input.ratingId+'-input input[value="'+value+'"]').attr('id') + ']').html()
                break;
        }

        return null;
    }

    $.fn.allRating.initHoverEvents = function(input, config) {

        // Check if rating text should be displayed
        if (config.showHover) {

            $('#'+input.ratingId+' .'+config.segmentContainerClass).hover(function(e) {
                $(this).siblings('.'+config.hoverClass).css({
                    'position':'absolute',
                    'top': ($(this).position().top+$(this).siblings('.'+config.hoverClass).height()),
                    'left': $(this).position().left
                }).fadeIn();
            }, function() { //hover out
                $(this).stop().siblings('.'+config.hoverClass).fadeOut("fast");
            });

            //if the rating isn't disabled let the user know which rating they're hovering over
            if(!input.disabled) {
                if(config.existingRatingOnEdit)
                    $('#'+input.ratingId+' .'+config.hoverClass+' .existingRating').prepend('Existing: ');
                else
                    $('#'+input.ratingId+' .'+config.hoverClass+' .existingRating').hide();

                $('#'+input.ratingId).find('a.'+config.segmentClass).hover(function() {
                    $('#'+input.ratingId+' .'+config.hoverClass+' .newRating').html('New: '+$.fn.allRating.findTextFromValue(input, $(this).attr('rel'), config));
                });
            }
        }

        $('#'+input.ratingId+' .'+config.segmentClass+':not(.'+config.segmentDisabledClass+')').hover(function() {
            $(this).siblings(':not(.'+config.segmentCancelClass+')').removeClass(config.segmentActiveClass).addClass(config.segmentClassNonActiveClass);
            
            $(this).prevAll('a').each(function() {
                $(this).removeClass(config.segmentClassNonActiveClass).addClass(config.segmentActiveClass);
            });

            $(this).removeClass(config.segmentClassNonActiveClass).addClass(config.segmentActiveClass);
        }, function() { //hover out
            var input = $.fn.allRating.fetchInput( $(this).attr('href')+'-input', config );
            $.fn.allRating.addActiveStars(input, config);
        });
    };

    $.fn.allRating._ui = function () {
        return(((1+Math.random())*0x10000)|0).toString(16).substring(1);
    };

})( jQuery );
