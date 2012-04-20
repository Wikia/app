ImageDrop = {
    init: function(e){
        var dropbox = $('#WikiaMainContent');
        ImageDrop.headlines = $($("#WikiaArticle .mw-headline").parent());
        dropbox.filedrop({
            // The name of the $_FILES entry:
            paramname:'wpUploadFile',

            maxfiles: 5,
            maxfilesize: 2, // in mb
            url: wgServer + '/wikia.php?controller=ImageDrop&method=upload',

            uploadFinished:function(i,file,response){
                $.data(file).addClass('done');
                // response is the JSON object that post_file.php returns
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
            	console.log("drop override");
            	console.log(evt);
            	var node = $(evt.target);
            	var parents = node.parentsUntil('#WikiaArticle');
            	if(parents.length) {
            		node = $(parents.pop());
            	} 
            	var headline = $(node).prevAll("h2, h3")[0];
            	var index = 0;
            	if(headline) {
            		index = ImageDrop.headlines.index(headline) + 1;
            	}
            	this.data = {
            		section: index
            	};
            	console.log(index);
            }
        });

        var template = '...';

        function createImage(file){
            // ... see above ...
        }

        function showMessage(msg){
            message.html(msg);
        }
    }
};

$(function() {
    ImageDrop.init();
});