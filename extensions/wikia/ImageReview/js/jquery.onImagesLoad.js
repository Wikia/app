/**
 * jQuery 'onImagesLoaded' plugin v1.2.0 (Updated December 1, 2011)
 * Fires callback functions when images have loaded within a particular selector.
 *
 * Copyright (c) Cirkuit Networks, Inc. (http://www.cirkuit.net), 2008-2011.
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * For documentation and usage, visit "http://www.cirkuit.net/projects/jquery/onImagesLoad/"
 */
(function($){
    $.fn.onImagesLoad = function(options){
		//version 1.2.0 - if 'options' parameter is a function, treat it as the "all" callback
		if(typeof(options)=="function"){
			options = {
				all : options
			};
		}
		
		//merge in default options
        var self = this;
        self.opts = $.extend({}, $.fn.onImagesLoad.defaults, options);
		
		//reverse compatibility function names
		//version 1.2.0 - renamed "selectorCallback" to "all"
		if(self.opts.selectorCallback && !self.opts.all){
			self.opts.all = self.opts.selectorCallback; 
		}
		//version 1.2.0 - renamed "itemCallback" to "each"
		if(self.opts.itemCallback && !self.opts.each){
			self.opts.each = self.opts.itemCallback; 
		}

        self.bindEvents = function($imgs, container, callback){
            if ($imgs.length === 0){ //no images were in selection. callback based on options
                if (self.opts.callbackIfNoImagesExist && callback){ callback(container); }
            }
            else {
                var loadedImages = [];
                if (!$imgs.jquery){ $imgs = $($imgs); }
                $imgs.each(function(i){
                    //webkit fix inspiration thanks to bmsterling: http://plugins.jquery.com/node/10312
                    var orgSrc = this.src;
                    if (!$.browser.msie) {
                        this.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="; //ie will do funky things if this is here (show the image as an X, only show half of the image, etc)
                    }
                    $(this).bind('load', function(){
                        if (jQuery.inArray(i, loadedImages) < 0){ //don't double count images
                            loadedImages.push(i); //keep a record of images we've seen
                            if (loadedImages.length == $imgs.length){
                                if (callback){ callback.call(container, container); }
                            }
                        }
                    });
                    if (!$.browser.msie) {
                        this.src = orgSrc; //needed for potential cached images
                    }
                    else if (this.complete || this.complete === undefined){ this.src = orgSrc; }
                });
            }
        };

        var imgAry = []; //only used if self.opts.all exists
        self.each(function(){
            if (self.opts.each){
                var $imgs;
                if (this.tagName == "IMG"){ $imgs = this; } //is an image
                else { $imgs = $('img', this); } //contains image(s)
                self.bindEvents($imgs, this, self.opts.each);
            }
            if (self.opts.all){
                if (this.tagName == "IMG"){ imgAry.push(this); } //is an image
                else { //contains image(s)
                    $('img', this).each(function(){ imgAry.push(this); });
                }
            }
        });
        if (self.opts.all){ self.bindEvents(imgAry, this, self.opts.all); }

        return self.each(function(){}); //dont break the chain
    };

    //DEFAULT OPTOINS
    $.fn.onImagesLoad.defaults = {
        all: null,						//function - the function to invoke when all images that $(yourSelector) encapsultaes have loaded (invoked only once per selector. see documentation)
        each: null,						//function - the function to invoke when each item that $(yourSelector) encapsultaes has loaded (invoked one or more times depending on selector. see documentation)
        callbackIfNoImagesExist: false	//boolean - if true, the callbacks will be invoked even if no images exist within $(yourSelector).
										//			if false, the callbacks will not be invoked if no images exist within $(yourSelector).
    };
})(jQuery);