/**
 * Licence: MIT and GPL version 2.0 licenses. This means that you can 
 * choose the license that best suits your project and use it accordingly. 
 *
 * Based on other plugins for jqPlot by Chris Leonello (chris dot leonello at gmail) 
 * and Cubic Hermite spline - http://en.wikipedia.org/wiki/Cubic_Hermite_spline
 * krypin at gmail dot com
 *
 * If you are feeling kind and generous, consider supporting the jqPlot project by
 * making a donation at: http://www.jqplot.com/donate.php .
 *
 */
(function($) {
    // Class: $.jqplot.hermiteSplineRenderer
    // A plugin renderer for jqPlot to draw a Hermite spline.
    // Draws series as a cubic Hertmite spline.
    $.jqplot.hermiteSplineRenderer = function(){
        $.jqplot.LineRenderer.call(this);
    };
    
    $.jqplot.hermiteSplineRenderer.prototype = new $.jqplot.LineRenderer();
    $.jqplot.hermiteSplineRenderer.prototype.constructor = $.jqplot.hermiteSplineRenderer;
    
    // called with scope of series.
    $.jqplot.hermiteSplineRenderer.prototype.init = function(options) {
        // Number of steps
        this.steps = 50;
        
        //Cardinal spline 'tension' constant which affects the tightness of the curve
        //must be in the interval (0,1)
        this.tension = 0.5; 

        $.extend(true, this, options);

        // set the shape renderer options
        var opts = {lineJoin:'miter', lineCap:'round', fill:false, isarc:false, strokeStyle:this.color, lineWidth: this.lineWidth};
        this.renderer.shapeRenderer.init(opts);
    };

    $.jqplot.hermiteSplineRenderer.prototype.draw = function(ctx, gd, options) {
        var i;
        var opts = (options != undefined) ? options : {};
        var showLine = (opts.showLine != undefined) ? opts.showLine : this.showLine;

        if (gd.length) {
            if (showLine) {
                if (gd.length >  1) { 
                    var newGD = [];
                    for (var i=0; i<gd.length-1; i++) {
                        var steps = this.steps;
                        var a = this.tension;
                        for (var t=0; t < steps; t++) {
                            var s = t / steps;
                            var h1 = (1 + 2*s)*Math.pow((1-s),2);
                            var h2 = s*Math.pow((1-s),2);
                            var h3 = Math.pow(s,2)*(3-2*s);
                            var h4 = Math.pow(s,2)*(s-1);     
                            
                            if (gd[i-1]) {  
                                var TiX = a * (gd[i+1][0] - gd[i-1][0]); 
                                var TiY = a * (gd[i+1][1] - gd[i-1][1]);
                            } else {
                                var TiX = a * (gd[i+1][0] - gd[i][0]); 
                                var TiY = a * (gd[i+1][1] - gd[i][1]);                                  
                            }
                            if (gd[i+2]) {  
                                var Ti1X = a * (gd[i+2][0] - gd[i][0]); 
                                var Ti1Y = a * (gd[i+2][1] - gd[i][1]);
                            } else {
                                var Ti1X = a * (gd[i+1][0] - gd[i][0]); 
                                var Ti1Y = a * (gd[i+1][1] - gd[i][1]);                                 
                            }
                            
                            var pX = h1*gd[i][0] + h3*gd[i+1][0] + h2*TiX + h4*Ti1X;
                            var pY = h1*gd[i][1] + h3*gd[i+1][1] + h2*TiY + h4*Ti1Y;
                            var p = [pX, pY];
                            newGD.push(p);
                        }
                    }
                    gd = newGD;  
                }
                this.renderer.shapeRenderer.draw(ctx, gd, opts);
            }
        }
    }; 
})(jQuery);    