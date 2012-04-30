ImageDrop = {
    init: function(e){
        ImageDrop.dropbox = $('#WikiaArticle');
        ImageDrop.headlines = $($("#WikiaArticle .mw-headline").parent());
        ImageDrop.mask = $('<div id="ImageDropMask"><div>');
        ImageDrop.dropbox.append(ImageDrop.mask);
        ImageDrop.dropbox.filedrop({
            // The name of the $_FILES entry:
            paramname:'wpUploadFile',

            maxfiles: 5,
            maxfilesize: 2, // in mb
            url: wgServer + '/wikia.php?controller=ImageDrop&method=upload',

            uploadFinished:function(i,file,response){
            	ImageDrop.mask.stopThrobbing();
            	ImageDrop.mask.css("height", 0);
            	$().log(response);
                //$.data(file).addClass('done');
                // response is the JSON object that post_file.php returns
                var headline = $(ImageDrop.previousHeadline);
                if(headline.length > 0) {
                	headline.after($(response));
                } else {
                	ImageDrop.dropbox.prepend($(response));
                }
            },

            error: function(err, file) {
                switch(err) {
                    case 'BrowserNotSupported':
                        showMessage('Your browser does not support HTML5 file uploads!');
                        break;
                    case 'TooManyFiles':
                        alert('Too many files! Please select 5 at most!');
                        break;
                    case 'FileTooLarge':
                        alert(file.name+' is too large! Please upload files up to 2mb.');
                        break;
                    default:
                        break;
                }
            },

            // Called before each upload is started
            beforeEach: function(file){
                if(!file.type.match(/^image\//)){
                    alert('Only images are allowed!');

                    // Returning false will cause the
                    // file to be rejected
                    return false;
                }
            },

            uploadStarted:function(i, file, len){
                createImage(file);
            },

            progressUpdated: function(i, file, progress) {
                //$.data(file).find('.progress').width(progress);
            },
            
            drop: function(evt) {
            	$().log("drop");
            	$().log(evt);
            	var node = ImageDrop.findNearestNode(evt.target);
            	node.removeClass('imagedrop-highlight');
            	var headline = ImageDrop.findNearestHeadline(node);
            	this.data.section = ImageDrop.index;
                this.data.title = wgTitle;
            	$().log(ImageDrop.index);
            	//ImageDrop.mask.css("height", 0);
            	ImageDrop.mask.startThrobbing();
            },
            
            dragEnter: function(evt) {
            	$().log("Entered");
            	if(!$(evt.target).is("#ImageDropMask")) {
	            	var node = ImageDrop.findNearestNode(evt.target);
	            	var headline = ImageDrop.findNearestHeadline(node);
	            	if(!headline.is(ImageDrop.previousHeadline)) {
	            		ImageDrop.index = 0;
	            		var height = 0;
	            		var maskTop = 0;
		            	if(headline.length > 0) {
		            		ImageDrop.index = ImageDrop.headlines.index(headline) + 1;
		            		var nextHeadline = headline.nextAll("h2, h3, h4").first();
		            		height = nextHeadline.position().top - headline.position().top;
		            		maskTop = headline.position().top;
		            	} else {
		            		var nextHeadline = ImageDrop.dropbox.find("h2, h3, h4").first();
		            		height = nextHeadline.position().top;
		            	}
		            	
		            	ImageDrop.mask.css("height", height);
		            	ImageDrop.mask.css("top", maskTop);
		            	ImageDrop.previousHeadline = headline;
	            	}
            	}
            },
            dragLeave: function(evt) {
            	$().log("Left");
            	var node = ImageDrop.findNearestNode(evt.target);
            }
        });

        var template = '...';

        function createImage(file){
            // ... see above ...
        }

        function showMessage(msg){
            //message.html(msg);
        }
    },
    findNearestNode: function(node) {
    	node = $(node);
    	var parents = node.parentsUntil('#WikiaArticle');
    	if(parents.length > 0) {
    		node = $(parents.last());
    	} 
    	return node;
    },
    findNearestHeadline: function(headline) {
    	if(!headline.is("h2, h3, h4")) {
    		headline = $($(headline).prevAll("h2, h3, h4")[0]);
    	}
    	return headline;
    }
};

$(function() {
    ImageDrop.init();
});