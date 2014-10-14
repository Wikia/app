/*
 * @build  : 24 Aug, 2013
 * @author : Ram swaroop
 * @company: Compzets.com
 */
(function($){
    $.fn.contentshare = function(options) {        
        // fetch options
        var opts = $.extend({},$.fn.contentshare.defaults,options);
        
        $.extend($.fn.contentshare,{
            
            init : function(shareable) {
                $.fn.contentshare.defaults.shareable = shareable;
            },
            getContent : function() {
                var content="";
                for(var i=0;i<opts.shareLinks.length;i++){
                    content+='<a href="'+opts.shareLinks[i]+this.getSelection()+'" '+((opts.newTab)?"target=\"_blank\"":"")+'><img src="'+opts.shareIcons[i]+'" '+((i!=0)?"style=\"margin-left:5px\"":"")+'/></a>';
                }
                return content;
            },
            getSelection : function(option) {
                if(window.getSelection){
                    return (option=='string')?encodeURIComponent($.trim(window.getSelection().getRangeAt(0).toString())):window.getSelection().getRangeAt(0);
                }
                else if(document.selection){
                    return (option=='string')?encodeURIComponent($.trim(document.selection.createRange().text)):document.selection.createRange();
                }
            },                
            showTooltip : function() {
                this.clear();
                if(this.getSelection('string').length < opts.minLength)
                    return;
                this.preloadShareIcons(opts.shareIcons);
                var range = this.getSelection();
                var newNode = document.createElement("mark");
                range.surroundContents(newNode);
                $('mark').addClass(opts.className);
                $('.'+opts.className).tooltipster({trigger:'custom',interactive:true,content:this.getContent(),animation:opts.animation});
                $('.'+opts.className).tooltipster('show');
            },
            preloadShareIcons : function(array) {
                for (var i = 0; i < array.length; i++) {
                    var img = new Image();
                    img.src = array[i];
                }
            },
            clear : function() {
                $('.'+opts.className).tooltipster('hide');
                $('mark').contents().unwrap();
                $('mark').remove();
            }
        });        
        
        // initialize the awesome plugin
        $.fn.contentshare.init(this);
    };
    
    // default options
    $.fn.contentshare.defaults = {
        shareable  : {},
        shareIcons : ["img/fb.png","img/tw.png"],
        shareLinks : ["http://www.facebook.com/sharer.php?s=100&p[url]="+document.URL+"&p[title]="+document.title+"&p[summary]=" , "http://twitter.com/intent/tweet?text="],
        minLength  : 5,
        newTab     : true,
        className  : "contentshare",
        animation  : "grow"
    };

}(jQuery));

// calling the plugin on DOM ready
$(document).ready(function(){
    $("p").contentshare();
    $.fn.contentshare.defaults.shareable.on('mouseup',function(){
        $.fn.contentshare.showTooltip();
    });            
});