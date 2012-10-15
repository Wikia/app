//the core javascript file of the wiki@home extension

//load msgs:
mw.addMessages({
	"wah-menu-jobs" : "Jobs",
	"wah-menu-stats": "Stats",
	"wah-menu-pref" : "Preferences",
	"wah-loading" : "loading Wiki@Home interface ...",

	"wah-lookingforjob" : "Looking For a job ...",

	"wah-start-on-visit": "Start up Wiki@Home anytime I visit this site.",
	"wah-jobs-while-away": "Only run jobs when I have been away from my browser for 20 minutes.",

	"wah-nojobfound" : "No job found. Will retry in $1.",

	"wah-notoken-login" : "Are you logged in? If not, please log in first.",
	"wah-apioff" : "The API appears to be off. Please contact the wiki administrator.",

	"wah-doing-job" : "Job: <i>$1</i> on: <i>$2</i>",
	"wah-downloading" : "Downloading file <i>$1%</i> complete",
	"wah-encoding" : "Encoding file <i>$1%</i> complete",

	"wah-encoding-fail" : "Encoding failed. Please reload this page or try back later.",

	"wah-uploading" : "Uploading file <i>$1</i> complete",
	"wah-uploadfail" : "Uploading failed",
	"wah-doneuploading" : "Upload complete. Thank you for your contribution.",

	"wah-needs-firefogg": "To participate in Wiki@Home you need to install Firefogg.",

	"wah-api-error" : "There has been an error with the API. Please try back later."

});


wahConfig = {
	'wah_container'		: '#wah_container',
	//how many seconds to wait before looking for a job again (in seconds)
	'jobsearch_delay'	: ( wgClientSearchInterval ) ? wgClientSearchInterval: 60
};

//mw.ready ensures that the dom and core libraries are ready:
mw.ready(function(){
	//set up the dependency load request:
	var depReq = [
		[
			'mvBaseUploadInterface',
			'mvFirefoggRender',
			'mvFirefogg',
			'$j.ui'
		],
		[
			'$j.ui.sortable',
			'$j.ui.progressbar',
			'$j.ui.tabs',
			'$j.cookie'
		]
	];
	mvJsLoader.doLoadDepMode( depReq, function(){
		WikiAtHome.init( wahConfig );
	});
});

var WikiAtHome = {
	menu_items: ['jobs', 'stats', 'pref'],
	init: function(){
		var _this = this;
		//proc config:
		for(var i in wahConfig){
			_this[i] = wahConfig[i];
		}
		//make sure api is "on"
		if( !wgEnableAPI ){
			$j( _this.wah_container ).html( gM('wah-apioff') );
			return false;
		}

		//fist see if we are even logged in:
		if( !wgUserName ){
			$j( _this.wah_container ).html( gM('wah-notoken-login'));
		}else{
			//first get an edit token (title and api_url not needed
			//@@todo we should request a token for uploading/wikiathome?
			get_mw_token(false, false, function(token){
				if(!token){
					$j( _this.wah_container ).html( gM('wah-notoken-login'));
				}else{
					_this.eToken = token;
					//if we load the interface oky then
					if( _this.loadInterface() ){
						//look for a job:
						_this.lookForJob();
						if(_this.assinedJob){
							_this.proccessJob();
						}else{
							//update interface that nothing is available (look again in 60 seconds)
						}
					}
				}
			});
		}
	},
	loadInterface: function(){
		var _this = this;
		var listHtml ='<div id="wah-tabs">'+
					'<ul>';
		var contHtml='';
		//output the menu itmes:
		for(var i in _this.menu_items){
			var item = _this.menu_items[i];
			listHtml+='<li><a href="#tab-' + item + '">' + gM('wah-menu-'+item)+'</a></li>';
			contHtml+='<div id="tab-' + item + '" class="tab-content">' +
				'</div>';
		}
		listHtml+='</ul>';
		contHtml+='</div>';
		$j( _this.wah_container ).html( listHtml +  contHtml );
		//apply bindings
		$j('#wah-tabs').tabs({
			select: function(event, ui) {
				//_this.selectTab( $j(ui.tab).attr('id').replace('rsd_tab_', '') );
			}
		}).find(".ui-tabs-nav").sortable({axis:'x'});

		//set pref initial layout
		$j('#tab-pref').html(
			'<h2>' + gM('wah-menu-pref') + '</h2>' +
			'<i>These preferences are not yet active</i>' +
			'<ul>' +
				'<li><input type="checkbox">' + gM('wah-start-on-visit') + '</li>' +
				'<li><input type="checkbox">' + gM('wah-jobs-while-away') + '</li>' +
			'</ul>'
		);

		//set the initial stats layout
		$j('#tab-stats').html(
			'<h2>Some Cool Visual Stats Go here!</h2>'
				);

		//set tabs to initial layout
		$j('#tab-jobs').html(
			'<h2 class="wah-gen-status"></h2>' +
			'<div class="progress-bar" style="width:400px;height:20px;"></div>' +
			'<div class="progress-status" ></div>'
		 );

		//make sure we have firefogg
			//check if we have firefogg installed (needed for transcoding jobs)
		this.myFogg = new mvFirefogg({
			'only_fogg':true
		});

		if(!this.myFogg.firefoggCheck() ){
			$j('#tab-jobs .progress-bar').hide().after(
				gM('wah-needs-firefogg')
			);

			//if we don't have 3.5 firefox update link:
			if(!($j.browser.mozilla && $j.browser.version >= '1.9.1')) {
				$j('#tab-jobs .progress-status').html(
					gM('fogg-use_latest_fox')
				);
			}else{
				//do firefogg install links:
				$j('#tab-jobs .progress-status').html(
					gM('fogg-please_install', _this.myFogg.getOSlink() )
				);
			}
			return false;
		}
		//set up local fogg pointer:
		this.fogg = this.myFogg.fogg;
		return true;
	},
	lookForJob: function( job_set_id ){
		var _this = this;
		//set the big status
		$j('#tab-jobs .wah-gen-status').html( gM('wah-lookingforjob') );
		var reqObj = {
			'action' 	: 'wikiathome',
			'getnewjob'	: true,
			'token'		: _this.eToken
		};
		//add a set_id to work on the file we have already downloaded
		if( job_set_id ){
			reqObj['jobset'] = job_set_id;
		}
		do_api_req({
			'data' : reqObj
		},function(data){
			//if we have a job update status to processing
			if( data.error){
				$j('#tab-jobs .wah-gen-status').html( gM('wah-api-error') );
			}else if( data.wikiathome.nojobs ){
				_this.delayLookForJob();
			}else{
				//we do have job proccess it
				_this.doProccessJob( data.wikiathome.job );
			}
		});
	},

	delayLookForJob:function(){
		var _this = this;
		var i=0;
		var delayJobUpdate = function(){
			i++;
			if(i == _this.jobsearch_delay){
				_this.lookForJob();
				return false;
			}else{
				//update the delay msg:
				$j('#tab-jobs .wah-gen-status').html( gM( 'wah-nojobfound', seconds2npt( _this.jobsearch_delay - i )) );
			}
			setTimeout(delayJobUpdate, 1000);
		};
		setTimeout(delayJobUpdate, 1000);
	},
	doProccessJob:function( job ){
		var _this = this;
		//update the status
		$j('#tab-jobs .wah-gen-status').html(
			gM('wah-doing-job', [job.job_json.jobType, job.job_title] )
		);
		//set up the progressbar
		$j('#tab-jobs .progress-bar').progressbar({
			value: 0
		});
		//set the jobKey:
		_this.jobKey = job.job_key;

		//start processing the work flow based on work type
		if( job.job_json.jobType == 'transcode' ){
			//download the source footage
			_this.doTranscodeJob( job );
		}
	},
	doTranscodeJob : function( job ){
		var _this = this;

		//get the url of the video we want to download
		do_api_req({
			'data':{
				'titles': job.job_fullTitle,
				'prop'	: 'imageinfo',
				'iiprop': 'url'
			}
		},function(data){
				for(var i in data.query.pages){
				_this.source_url = data.query.pages[i].imageinfo[0].url;
			}
			//have firefogg download the file:
			mw.log("do selectVideoUrl:: " + _this.source_url);
			_this.fogg.selectVideoUrl( _this.source_url );


			//check firefogg state and update status:
			var updateDownloadState = function(){
				if( _this.fogg.state == 'downloading'){
					//update progress
					_this.updateProgress(_this.fogg.progress(), 'wah-downloading');
					//loop update:
					setTimeout(updateDownloadState, 100);
				}else if( _this.fogg.state == 'downloaded'){
						mw.log('download is done, run encode:' + JSON.stringify( job.job_json.encodeSettings ) );
						//we can now issue the encode call
						_this.fogg.encode(
							JSON.stringify(
								job.job_json.encodeSettings
							)
						);
						updateEncodeState();
				}else if( _this.fogg.state == "download failed"){
					mw.log('download state failed');
				}
			};

			//do the initial call to downloading state updates
			if( _this.fogg.state == 'downloading'){
				setTimeout(updateDownloadState, 100);
			}

			//our encode state update
			var updateEncodeState = function(){
				_this.updateProgress( _this.fogg.progress(), 'wah-encoding' );
				if( _this.fogg.state == 'encoding done' ){
					mw.log('encoding done , do upload');
					_this.fogg.post( mwGetLocalApiUrl(),
						'file',
						JSON.stringify({
							'action' 	: 'wikiathome',
							'token'		: _this.eToken,
							'jobkey'	: _this.jobKey,
							'format'	: 'json'
						})
					);
					//do upload req
					updateUploadState();
					return true;
				}else if( _this.fogg.state == 'encoding failed'){
					mw.log('encoding failed');
					//maybe its time to refresh the window?
					$j('#tab-jobs .progress-status').html(
						gM( 'wah-encoding-fail' )
					);
					return false;
				}
				setTimeout(updateEncodeState, 100);
			};
			//our updateUploadState update
			var updateUploadState = function(){
				_this.updateProgress( _this.fogg.progress(), 'wah-uploading');
				if( _this.fogg.state == 'upload done'){
					//get the json result:
					var response_text =  _this.fogg.responseText;
					if(!response_text){
						   try{
							   var pstatus = JSON.parse( _this.fogg.uploadstatus() );
							   response_text = pstatus["responseText"];
						   }catch(e){
							   mw.log("could not parse uploadstatus / could not get responseText");
						   }
					}
					mw.log("got upload response:: " + response_text);
					//see if we can parse the result
					try{
						resultObj = JSON.parse( response_text );
					}catch(e){
						mw.log("could not parse result of upload :: " +response_text);
					}
					
					if( resultObj['wikiathome'] && resultObj['wikiathome']['chunkaccepted']){
						//congratulate the user and issue new job request
						$j('#tab-jobs .progress-status').html(
							gM( 'wah-doneuploading' )
						);
						//reset the progress bar:
						$j('#tab-jobs .progress-bar').progressbar( 'value', 0 );
	
						var getNextTranscodeJob = function(){
							_this.lookForJob( job.job_set_id );
						};
						//display the msg for 10 seconds
						setTimeout(getNextTranscodeJob, 10000);
					}else{
						//check for parseable error: 
						if( resultObj['error'] && resultObj['error']['info'] && resultObj['error']['code']);
						$j('#tab-jobs .progress-status').html(
							resultObj['error']['info'] + ' ' + resultObj['error']['code']
						);
					}
					

					return true;
				}else if( _this.fogg.state == 'upload failed'){
					$j('#tab-jobs .progress-status').html(
						gM( 'wah-uploadfail' )
					);
				}
				setTimeout(updateUploadState, 100);
			}
		});


		//for transcode jobs we have to download (unless we already have the file)

	},
	updateProgress: function( perc, msgKey ){
		//get percent done with 2 decimals
		var percDone = (perc == 0 ) ? '0': Math.round(perc * 10000) /100;
		//update progress bar
		$j('#tab-jobs .progress-bar').progressbar(
			'value',
			Math.round( percDone )
		);
		//update status
		$j('#tab-jobs .progress-status').html(
			gM(msgKey, percDone)
		);
	}
};
