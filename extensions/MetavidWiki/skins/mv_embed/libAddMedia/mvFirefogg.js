/* adds firefogg support. 
* autodetects: new upload api or old http POST.  
 */
 
var default_firefogg_options = {
	'upload_done_action':'redirect',
	'enabled':false,
	'api_url':false
}
var mvFirefogg = function(initObj){
	return this.init( initObj );
}
mvFirefogg.prototype = {

	min_firefogg_version : '0.9.5',
	enabled : false, 			//if firefogg is enabled or not. 
	upload_mode:'autodetect', 	//can be 'post', 'chunks' or autodetect. (autodetect issues an api call)   
	encoder_settings:{			//@@todo allow server to set this 
		'maxSize': 400, 
		'videoBitrate': 400
	},	
	formData:{}, //the form to be submitted
	
	init : function( iObj ){
		if(!iObj)
			iObj = {};
		//inherit iObj properties:
		for(var i in default_firefogg_options){
			if(iObj[i]){
				this[i] = iObj[i];
			}else{
				this[i] = default_firefogg_options[i];
			}
		}
		this.setupFirefogg();
	},
	setupFirefogg : function(){
		var _this = this;		
		if(typeof(Firefogg) == 'undefined'){ 
			$j('#wgfogg_not_installed').show();
			return false;
		}
		//make sure all the error msgs are hidden: 
		$j('#wgfogg_not_installed,#wgfogg_wrong_version').hide();
		
		//show firefogg enabler: 
		$j('#wgfogg_installed,#wgEnableFirefogg').show();
		
		if( $j('#wgEnableFirefogg').length > 0 ){
			_this.fogg = new Firefogg();	
			//do the version check:			
			if( this.fogg.version.replace(/[^0-9]/gi, '') < this.min_firefogg_version.replace(/[^0-9]/gi, '' ) ){
				//show wrong version error: 
				$j('#wgfogg_wrong_version').show();
				//hide the installed parent div: 
				$j('#wgfogg_installed').hide();
			}
			//make sure the checkbox accurately reflects the current state per config:  			
			$j('#wgEnableFirefogg').get(0).checked = this.enabled;
			
			//setup the click bindding: 
			$j('#wgEnableFirefogg').click( function(){
				if( _this.enabled ){						
					_this.disable_fogg();			
				}else{
					_this.enable_fogg();
				}
			});
		}else{
			js_log('could not find wgEnableFirefogg');
		}
	},
	enable_fogg:function(){	
		var _this = this;
			
		//enable the FOGG_TOGGLE
		this.enabled=true;
		
		//make sure file is "checked"
		if($j( '#wpSourceTypeFile' ).length != 0)
			$j( '#wpSourceTypeFile' ).get(0).checked = true;		
		
		//hide normal file upload stuff
		$j( '#wg-base-upload' ).hide();
		
		//setup the form pointer:
		_this.editForm = $j( '#mw-upload-form' ).get(0);
			
		//show fogg & add click binding: 
		$j( '#fogg-video-file' ).unbind().show().click( function(){
			_this.select_fogg();
		});							
	},
	disable_fogg:function(){
		var _this = this;
		//not enabled: 
		this.enabled=false;		

		$j( '#wg-base-upload' ).show();
		
		//hide any errors warnings and video select:
		$j( '#wgfogg_waring_ogg_upload,#wgfogg_waring_bad_extension,#fogg-video-file' ).hide();	
		
		//restore the orignal  		
		if( _this.org_onsubmit ){	
			_this.editForm.onsubmit = _this.org_onsubmit;
		}else{
			_this.editForm.onsubmit = function(){ return true; };
		}
	},
	fogg_update_progress:function(progress){		
		$j( '#fogg-progressbar' ).css( 'width', parseInt(progress*100) +'%');		
		$j( '#fogg-pstatus' ).html( parseInt(progress*100) + '% - ');
	},
	select_fogg:function(){			
		var _this = this;
		if( _this.fogg.selectVideo() ) {
			
			//update destination filename:
			if( _this.fogg.sourceFilename ){				
				var sf = _this.fogg.sourceFilename;						
				var ext = '';
				if(	sf.lastIndexOf('.') != -1){
					ext = sf.substring( sf.lastIndexOf('.')+1 ).toLowerCase();
				}
				//set upload warning				
				if( ext == 'ogg' || ext == 'ogv' ){		
					$j('#wgfogg_waring_ogg_upload').show();
					return false;
				}else if( ext == 'avi' || ext == 'mov' || ext == 'mp4' || ext=='mp2' ||
						  ext == 'mpeg' || ext == 'mpeg2' || ext == 'mpeg4' ||
						  ext == 'dv' || ext=='wmv' ){
					//hide ogg warning
					$j('#wgfogg_waring_ogg_upload').hide();									
					sf = sf.replace( ext, 'ogg' );
					$j('#wpDestFile').val( sf );
				}else{
					//not video extension error:	
					$j('#wgfogg_waring_bad_extension').show();					
					return false;			
				}
			}
			//run the onClick hanndle: 
			if( toggleFilenameFiller ) 		
				toggleFilenameFiller();						
			
			//set up the org_onsubmit if not set: 
			if( typeof( _this.org_onsubmit ) == 'undefined' )
				_this.org_onsubmit = _this.editForm.onsubmit;
					
			_this.editForm.onsubmit = function() {	
				
				//run the original onsubmit (if not run yet set flag to avoid excessive chaining ) 
				if( typeof( _this.org_onsubmit ) == 'function' ){										  
					if( ! _this.org_onsubmit() ){
						//error in org submit return false;
						return false;					
					}
				}												
				//get the input form data in flat json: 										
				var tmpAryData = $j( _this.editForm ).serializeArray();					
				for(var i=0; i < tmpAryData.length; i++){
					if( tmpAryData[i]['name'] )
						_this.formData[ tmpAryData[i]['name'] ] = tmpAryData[i]['value'];
				}							
				
				//display the loader:
				$j('#dlbox-centered,#dlbox-overlay').show();				
				
				//for some unknown reason we have to drop down the #p-search z-index:
				$j('#p-search').css('z-index', 1);								
				
				//select upload mode: 
				_this.doUploadSwitch();
				//don't submit the form (firefogg will handle that)	
		  		return false;			
			}
		}
	},
	doUploadSwitch:function(){
		var _this = this;
		//check the upload mode: 
		if( _this.upload_mode == 'autodetect' ){
			if( ! _this.api_url )
				return js_error( 'Error: can\'t autodetect mode without api url' );
			do_api_req( {
				'data':{ 'action':'paraminfo','modules':'upload' },
				'url':_this.api_url 
			}, function(data){
				if( typeof data.paraminfo == 'undefined' || typeof data.paraminfo.modules == 'undefined' )
					return js_error( 'Error: bad api results' );
				if( typeof data.paraminfo.modules[0].classname == 'undefined'){
					js_log( 'Autodetect Upload Mode: \'post\' ');
					_this.upload_mode = 'post';
				}else{					
					for( var i in data.paraminfo.modules[0].parameters ){						
						var pname = data.paraminfo.modules[0].parameters[i].name;
						if( pname == 'enablechunks' ){
							js_log( 'Autodetect Upload Mode: chunks ' );
							_this.upload_mode = 'chunks';
							break;
						}
					}											
					if( _this.upload_mode != 'chunks'){
						return js_error('Upload API without chunks param is not supported');
					}
				}				
				_this.doUploadSwitch();
			});
		}else if( _this.upload_mode == 'post') {
			_this.doEncUpload();
		}else if( _this.upload_mode == 'chunks'){
			_this.doChunkUpload();
		}else{			
			js_error( 'Error: unrecongized upload mode: ' + _this.upload_mode );
		}			
	},
	//doChunkUpload does both uploading and encoding at the same time and uploads one meg chunks as they are ready
	doChunkUpload : function(){
		var _this = this;						
		//add chunk response hook to build the resultURL when uploading chunks 						
		/*_this.fogg.setChunkCallback( function( result ){
			js_log( 'chunkResponseHook:' + result );
			try{
				var upRes = JSON.parse( result );				
				if( upRes.upload.sessionkey ){
				
				}
				if( upRes.upload.result ){
					
				}				
			}catch(e){
				js_error( 'error could not parse chunkResponse' );
			}			
		});*/
		
		
		//build the api url: 
		var aReq ={
			'action'	: 'upload',
			'format'	: 'json',
			'filename'	: _this.formData['wpDestFile'],
			'comment'	: _this.formData['wpUploadDescription'],
			'enablechunks': true
		};
		
		if( _this.formData['wpWatchthis'] )
			aReq['watch'] =  _this.formData['wpWatchthis'];
		
		if(  _this.formData['wpIgnoreWarning'] )
			aReq['ignorewarnings'] = _this.formData['wpIgnoreWarning'];
													
		_this.fogg.upload( JSON.stringify( _this.encoder_settings ),  aReq ,  JSON.stringify( _this.formData ) );		
			
		//update upload status:						
		_this.doUploadStatus();
	},
	//doEncUpload first encodes then uploads
	doEncUpload : function(){	
		var _this = this;				
		_this.fogg.encode( JSON.stringify( _this.encoder_settings ) );		  	
		
		//setup a local function for timed callback:
		var encodingStatus = function() {
			var status = _this.fogg.status();
			
			//update progress bar
			_this.fogg_update_progress( _this.fogg.progress() );			
			
			//loop to get new status if still encoding
			if( _this.fogg.state == 'encoding' ) {
				setTimeout(encodingStatus, 500);
			}else if ( _this.fogg.state == 'encoding done' ) { //encoding done, state can also be 'encoding failed'
				//now call the upload function 
								    		
			    //hide the fogg-status-transcode
			    $j('#fogg-status-transcode').hide();
			    			
			    //show the fogg-status-upload
			    $j('#fogg-status-upload').show();			    			    					    																											 						
				
				// ignore warnings & set source type 
				//_this.formData[ 'wpIgnoreWarning' ]='true';
				_this.formData[ 'wpSourceType' ]='file';		
				_this.formData[ 'action' ] = 'submit';
				
				//send to the post url: 				
				//js_log('sending form data to : ' + _this.editForm.action);
				//for(var fk in _this.formData){
				//	js_log(fk + ' : ' +  _this.formData[fk]);
				//}			
				_this.fogg.post( _this.editForm.action, 'wpUploadFile', JSON.stringify( _this.formData ) );
				
				//update upload status:						
				_this.doUploadStatus();
				
			}else if(_this.fogg.state == 'encoding fail'){
				//@@todo error handling: 
					alert('encoding failed');
			}
		}
		encodingStatus();		  			
	},	
	doUploadStatus:function() {	
		var _this = this;
		//setup a local function for timed callback: 				
		var uploadStatus = function(){	
			var status = _this.fogg.status();							        					      					        					
			//js_log(' up stats: ' + status + ' p:' + _this.fogg.progress() + ' state: '+ _this.fogg.state + ' result page:' + _this.fogg.responseText);
			
		    //update progress bar
		    _this.fogg_update_progress( _this.fogg.progress() );
		    		    
		    //loop to get new status if still uploading (could also be encoding if we are in chunk upload mode) 
		    if( _this.fogg.state == 'encoding' || _this.fogg.state == 'uploading') {
				setTimeout(uploadStatus, 100);
			}
		    //check upload state
		    else if( _this.fogg.state == 'upload done' ||  _this.fogg.state == 'done' ) {	
		       	js_log( 'firefogg:upload done: '); 			        		       			       			       	       		       			       	
		       	//if in "post" upload mode read the html response (should be depricated): 
		       	if( _this.upload_mode == 'post' ) {
		       		var response_text ='';
		       		try{
		       			var pstatus = JSON.parse( _this.fogg.uploadstatus() );
		       			response_text = pstatus["responseText"];
		       		}catch(e){
		       			js_log("could not parse uploadstatus / could not get responseText");
		       		}
		       		//js_log( 'done upload response is: ' + cat["responseText"] );
		       		_this.procPageResponse( response_text );
		       		
		       	}else if( _this.upload_mode == 'chunks'){
		       		//should have an json result:
		       		js_error('chunks upload not yet supported');
		       		//var foo = _this;
		       		//var cat = _JSON.parse( _this.fogg.uploadstatus() );
		       		//debugger;
		       			       		
		       	}													
			}else{  
				//upload error: 
				alert('firefogg upload error: ' + _this.fogg.state );		
	       }
	   }
	   uploadStatus();
	},	
	/*
	procPageResponse should be faded out soon.. its all very fragile to read the html output and guess at stuff*/
	procPageResponse:function( result_page ){
		js_log('f:procPageResponse');
		var sstring = 'var wgTitle = "' + this.formData['wpDestFile'].replace('_',' ');		
		var error_txt = 'Your upload <i>should be</i> accessible <a href="' + 
						wgArticlePath.replace(/\$1/, 'File:' + this.formData['wpDestFile'] ) + '">'+
						'here</a> \n';
		//set the error text in case we dont' get far along in processing the response 
		$j( '#dlbox-centered' ).html( '<h3>Upload Completed:</h3>' + error_txt );
												
		if( result_page && result_page.toLowerCase().indexOf( sstring.toLowerCase() ) != -1){	
			js_log( 'upload done got redirect found: ' + sstring + ' r:' + _this.upload_done_action );										
			if( _this.upload_done_action == 'redirect' ){
			$j( '#dlbox-centered' ).html( '<h3>Upload Completed:</h3>' + error_txt + '<br>' + form_txt);
				window.location = wgArticlePath.replace( /\$1/, 'File:' + formData['wpDestFile'] );
			}else{
				//check if the add_done_action is a callback:
				if( typeof _this.upload_done_action == 'function' )
					_this.upload_done_action();
			}									
		}else{								
			//js_log( 'upload page error: did not find: ' +sstring + ' in ' + "\n" + result_page );					
			var form_txt = '';		
			if( !result_page ){
				//@@todo fix this: 
				//the mediaWiki upload system does not have an API so we can\'t read errors							
			}else{
				var res = mvUploader.grabWikiFormError( result_page );
							
				if(res.error_txt)
					error_txt = opt.error_txt;
					
				if(res.form_txt)
					form_txt = res.form_txt;
			}		
			js_log( 'error text is: ' + error_txt );		
			$j( '#dlbox-centered' ).html( '<h3>Upload Completed:</h3>' + error_txt + '<br>' + form_txt);
		}
	}
}
