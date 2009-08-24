/* the upload javascript 
presently does hackery to work with Special:Upload page...
will be replaced with upload API once that is ready
*/

loadGM( { 
	"upload-enable-converter" : "Enable video converter (to upload source video not yet converted to theora format) <a href=\"http://commons.wikimedia.org/wiki/Commons:Firefogg\">more info</a>",
	"upload-fogg_not_installed": "If you want to upload video consider installing <a href=\"http://firefogg.org\">firefogg.org</a>, <a href=\"http://commons.wikimedia.org/wiki/Commons:Firefogg\">more info</a>",
	"upload-in-progress":"Doing Transcode & Upload (do not close this window)",
	"upload-transcoded-status": "Transcoded",
	"uploaded-status": "Uploaded",
	"upload-select-file": "Select File...",	
	"wgfogg_wrong_version": "You have firefogg installed but its outdated, <a href=\"http://firefogg.org\">please upgrade</a> ",
	"wgfogg_waring_ogg_upload": "You have selected an ogg file for conversion to ogg (this is probably unnessesary). Maybe disable the video converter?",
	"wgfogg_waring_bad_extension" : "You have selected a file with an unsuported extension. <a href=\"http://commons.wikimedia.org/wiki/Commons:Firefogg#Supported_File_Types\">More help</a>" 
});

var default_upload_options = {
	'target_div':'',
	'upload_done_action':'redirect',
	'api_url':false
}

var mvUploader = function(initObj){
	return this.init( initObj );
}
mvUploader.prototype = {
	init:function( iObj ){
		var _this = this;	
		js_log('init uploader');
		if(!iObj)
			iObj = {};
		for(var i in default_upload_options){
			if(iObj[i]){
				this[i] = iObj[i];
			}else{
				this[i] = default_upload_options[i];
			}
		}
		//check if we are on the uplaod page: 
		this.on_upload_page = ( wgPageName== "Special:Upload")?true:false;					
		js_log('f:mvUploader: onuppage:' + this.on_upload_page);
		//grab firefogg.js: 
		mvJsLoader.doLoad({
				'mvFirefogg' : 'libAddMedia/mvFirefogg.js'
			},function(){
				//if we are not on the upload page grab the upload html via ajax:
				//@@todo refactor with 		
				if( !_this.on_upload_page){					
					$j.get(wgArticlePath.replace(/\$1/, 'Special:Upload'), {}, function(data){
						//add upload.js: 
						$j.getScript( stylepath + '/common/upload.js', function(){ 	
							//really _really_ need an "upload api"!
							wgAjaxUploadDestCheck = true;
							wgAjaxLicensePreview = false;
							wgUploadAutoFill = true;									
							//strip out inline scripts:
							sp = data.indexOf('<div id="content">');
							se = data.indexOf('<!-- end content -->');	
							if(sp!=-1 && se !=-1){		
								result_data = data.substr(sp, (se-sp) ).replace('/\<script\s.*?\<\/script\>/gi',' ');
								js_log("trying to set: " + result_data );																			
								//$j('#'+_this.target_div).html( result_data );
							}						
							_this.setupFirefogg();
						});	
					});				
				}else{
					_this.setupFirefogg();
				}							
			}
		);
	},
	setupFirefogg:function(){
		var _this = this;
		//add firefogg html if not already there: ( same as $wgEnableFirebug added in SpecialUpload.php )  
		if( $j('#fogg-video-file').length==0 ){
			js_log('add addFirefoggHtml');
			_this.addFirefoggHtml();
		}else{
			js_log('firefogg already init:');					
		}	
		//set up the upload_done action 
		//redirect if we are on the upload page  
		//do a callback if in called from gui) 
		var intFirefoggObj = ( this.on_upload_page )? 
				{'upload_done_action':'redirect'}:
				{'upload_done_action':function( rTitle ){
						js_log('add_done_action callback for uploader');
						//call the parent insert resource preview	
						_this.upload_done_action( rTitle );		
					}
				};
		if( _this.api_url )
			intFirefoggObj['api_url'] =  _this.api_url;
		js_log('new mvFirefogg');
		//if firefog is not taking over the submit we can here: 
		_this.fogg = new mvFirefogg( intFirefoggObj );			
			
	},
	grabWikiFormError:function( result_page ){
		var res = {};
		sp = result_page.indexOf('<span class="error">');
		if(sp!=-1){
			se = result_page.indexOf('</span>', sp);
			res.error_txt = result_page.substr(sp, (sp-se)) + '</span>';
		}else{
			//look for warning: 
			sp = result_page.indexOf('<ul class="warning">')
			if(sp!=-1){
				se = result_page.indexOf('</ul>', sp);
				error_txt = result_page.substr(sp, (se-sp)) + '</ul>';
				//try and add the ignore form item: 
				sfp = result_page.indexOf('<form method="post"');
				if(sfp!=-1){
					sfe = result_page.indexOf('</form>', sfp);
					res.form_txt = result_page.substr(sfp, ( sfe - sfp )) + '</form>';
				}
			}else{
				//one more error type check: 
				sp = result_page.indexOf('class="mw-warning-with-logexcerpt">')
				if(sp!=-1){
					se = result_page.indexOf('</div>', sp);
					res.error_txt = result_page.substr(sp, ( se - sp )) + '</div>';
				}
			}
		}	
		return res;		
	},
	//same add code as specialUpload if($wgEnableFirefogg){
	addFirefoggHtml:function(){		
		var itd_html = $j('#mw-upload-table .mw-input:first').html();			
		$j('#mw-upload-table .mw-input').eq(0).html('<div id="wg-base-upload">' + itd_html + '</div>');
		//add in firefogg control			
		$j('#wg-base-upload').after('<p id="fogg-enable-item" >' + 
						'<input style="display:none" id="fogg-video-file" name="fogg-video-file" type="button" value="' + gM('upload-select-file') + '">' +
						"<span id='wgfogg_not_installed'>" + 
							gM('upload-fogg_not_installed') +
						"</span>" +
						"<span class='error' id='wgfogg_wrong_version'  style='display:none;'><br>" +
							gM('wgfogg_wrong_version') +
						"<br>" +
						"</span>" +
						"<span class='error' id='wgfogg_waring_ogg_upload' style='display:none;'><br>"+
							gM('wgfogg_waring_ogg_upload') +
						"<br>" +
						"</span>" + 
						"<span class='error' id='wgfogg_waring_bad_extension' style='display:none;'><br>"+
							gM('wgfogg_waring_bad_extension') + 						
						"<br>" +
						"</span>" +  
						"<span id='wgfogg_installed' style='display:none' >"+
							'<input id="wgEnableFirefogg" type="checkbox" name="wgEnableFirefogg" >' + 							
								gM('upload-enable-converter') +
						'</span><br></p>');		
		//add in loader dl box: 	
		//hard code style (since not always easy to import style sheets)
		$j('body').append('<div id="dlbox-centered" class="dlbox-centered" style="display:none;'+
				'position:fixed;background:#DDD;border:3px solid #AAA;font-size:115%;width:40%;'+
				'height:300px;padding: 10px;z-index:100;top:100px;bottom:40%;left:20%;" >'+		
					'<h5>' + gM('upload-in-progress') + '</h5>' +
					'<div id="fogg-pbar-container" style="border:solid thin gray;width:90%;height:15px;" >' +
						'<div id="fogg-progressbar" style="background:#AAC;width:0%;height:15px;"></div>' +			
					'</div>' +
					'<span id="fogg-pstatus">0%</span>' +
					'<span id="fogg-status-transcode">' + gM('upload-transcoded-status') + '</span>'+  
					'<span style="display:none" id="fogg-status-upload">' + gM('uploaded-status') + '</span>' +
			'</div>' +					
			'<div id="dlbox-overlay" class="dlbox-overlay" style="display:none;background:#000;cursor:wait;height:100%;'+
						'left:0;top:0;position:fixed;width:100%;z-index:99;filter:alpha(opacity=60);'+
						'-moz-opacity: 0.6;	opacity: 0.6;" ></div>');				
	}
}