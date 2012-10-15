/*!
 * jQuery uCompare
 * http://www.userdot.net/#!/jquery
 *
 * Copyright 2011, UserDot www.userdot.net
 * Licensed under the GPL Version 3 license.
 * Version 1.0.0
 *
 */
( function ( $ ) {
    $.fn.extend( {
    	// Hook into jquery.ucompage
        ucompare: function ( localConfig ) {
        	// Configuration variable
            var config = {
                defaultgap: 50,
                leftgap: 10,
                rightgap: 10,
                caption: false,
                reveal: .5
            };
            $.extend( config, localConfig );
            return this.each( function () {
                /** Initialization function */
            	
                var container = $(this);
                // Extract image attributes
                var imageLeftSource = container.children("img:eq(0)").attr("src");
                var imageRightSource = container.children("img:eq(1)").attr("src");
                var caption = container.children("img:eq(0)").attr("alt");
                var width = container.children("img:eq(0)").width();
                var height = container.children("img:eq(0)").height();
                // Hide both images
                container.children("img").hide();
                container.css({
                    overflow: "hidden",
                    position: "relative"
                });

                /**
				 * MediaWiki hack:
                 * Parent element height can still be 0px after hiding the images
                 * so we really want to update its dimensions.
                 */
                container.width(width); container.height(height);

                // The left part is the foreground image
                container.append('<div class="uc-mask"></div>');
                // The right part is the background image
                container.append('<div class="uc-bg"></div>');
                // Caption
                container.append( $( '<div class="uc-caption" />' ).text( caption ) );
                // Set the foreground and background image dimensions
                container.children(".uc-mask, .uc-bg").width(width);
                container.children(".uc-mask, .uc-bg").height(height);
                // Fancy initial animation
                container.children(".uc-mask").animate({
                    width: width - config.defaultgap
                }, 1e3);
                // Set the images
                container.children(".uc-mask").css("backgroundImage", "url(" + imageLeftSource + ")");
                container.children(".uc-bg").css("backgroundImage", "url(" + imageRightSource + ")");
                if ( config.caption ) {
                	container.children(".uc-caption").show()
            	}
            }).mousemove(function (event) {
            	/** Mouse movent event handler */
            	
            	// Create a jQuery object of the container
                var container = $(this);
                
                // Calculate mouse position relative to the left of the image
                var mousePosition = event.pageX - container.children(".uc-mask").offset().left;
                
                // Extract image width
                var imageWidth = container.width();
                
                // Extract caption
                var captionLeft = container.children("img:eq(0)").attr("alt");
                var captionRight = container.children("img:eq(1)").attr("alt");
                
                if ( mousePosition > config.leftgap && 
                		mousePosition < imageWidth - config.rightgap ) {
                	// Set the width of the left image
                    container.children(".uc-mask").width( mousePosition );
                }
                
                // Set caption
                if ( mousePosition < imageWidth * config.reveal ) {
                    container.children(".uc-caption").text( captionRight );
                } else {
                    container.children(".uc-caption").text( captionLeft );
                }
            } ); // End of return statement
        } // End of ucompare function
    } ); 
} )( jQuery );
