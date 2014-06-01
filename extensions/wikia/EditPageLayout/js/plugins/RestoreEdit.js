(function(window,$){

require(['uniqueId'], function(uniqueId) {

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	/**
	 * Automatically saves and restores non-saved edits across edit sections
	 */
	WE.plugins.restoreedit = $.createClass(WE.plugin,{

		requires: ['noticearea'],
		afterShow: function(editor) {
			var self = this,
				executed = 0;

			this.editor = editor;

			editor.bind('afterLoadingStatus', function(){
				if(executed || (typeof wgRevisionId == 'undefined') ){
					return;
				}

				executed = 1;

				var originalText = editor.getContent(),
				eds = new EditDataStore(wgTitle + '#' + wgEditPageSection, 5000, function(){
					return {'rev' : wgRevisionId, 'con': editor.getContent(), 'mode': editor.mode };
				}),
				old = eds.getOldData(),
				restoreHandler = function(ev){
					$().log('restoring original content', 'RestoreEdit');
					editor.setContent(originalText,originalMode);
					eds.deleteAll();
					self.closeModal();
				},
				diffHandler = function(ev){
					$().log('showing diff', 'RestoreEdit');
					editor.plugins.pagecontrols.renderChanges({});
				};

				var originalMode = editor.mode;

				eds = new EditDataStore(wgTitle + '#' + wgEditPageSection, 5000, function(){
					return {'rev' : wgRevisionId, 'con': editor.getContent(), 'mode': editor.mode };
				});
				old = eds.getOldData();

				$('#editform').submit(function(){
					eds.stop();
					eds.deleteAll();
					eds.clear();
				});

				if(old && old.data != null ){
					editor.setContent(old.data.con, old.data.mode);

					if(old.data.rev == wgRevisionId){
						editor.fire('notice', $.msg('restore-edits-notice'));
					}else{
						editor.fire('notice', $.msg('restore-edits-diff-notice'));
					}
					//attaching handlers for the short notices
					var editorEl = $('#EditPageEditor');
						editorEl.find('.restoreeditlink').bind('click', restoreHandler);
						editorEl.find('.difflink').bind('click', diffHandler);

					//attaching handlers for the long notices in the modal dialog (bind/delegate don't work in this case)
					$('.modalWrapper')
						.on('click', '.restoreeditlink', restoreHandler)
						.on('click', '.difflink', diffHandler);
				}

				eds.start();
			});
		},

		closeModal: function(){
			if($().isModalShown()){
				$().getModalWrapper().closeModal();
				this.editor.plugins.noticearea.dismissClicked(null, true);
			}
		}
	});

	/**
	 * Store class for articles
	 */

	var EditDataStore = $.createClass(Object,{
	    sessionTimeout: 60*60*6, //in sec
	    oldData: null,
	    openTime: 0,
	    dataKey: null,
	    sessionId: null,
	    callBack: null,
	    mainKey: 'EDS',
	    defaultData: {
	        sessions: {},
	        newest: null,
	        timestamp: 0
	    },
		timerId: null,

	    constructor: function(articleName, timesample, callbackGetData){
	        if(typeof callbackGetData != "function"){
	            throw "callbackGetdata is not callback";
	        }

	        this.dataKey = $.md5(articleName);
	        this.openTime = this.getTime();
	        this.sessionId = this.createSessionId();
	        this.oldData = this.getData();
	        var data = callbackGetData();
    	    var startData = {};
    	    var startMode = data.mode;
    	    startData[data.mode] = data.con;
	        this.start = function(){
	            /*We don't cera about transaction problem in the worst case we lose information from one timesample */
	            this.timerId = setInterval(
					$.proxy(
						function(){
							var data = callbackGetData();

							if( !startData[data.mode] ) {
								startData[data.mode] = data.con;
							}

							if( startData[data.mode] != data.con) {
								this.store(data);
							} else {
								if( startMode == data.mode) {
									this.store(null);
								}
							}
						},
						this
					),
					timesample
				); //code,millisec
	        };
	    },

	    deleteAll:function(){
	    	this.storeData(null);
			$().log('Data reset', 'RestoreEdit');
	    },

	    /* global clean */
	    clear: function(){
	        var alldata = $.storage.get(this.mainKey),
			count = 0;

			for(var i in alldata){
	            if(
					!alldata[i] ||
					(
						!alldata[i].timestamp ||
						((this.getTime() - alldata[i].timestamp) > this.sessionTimeout)
					)
				){
	            	delete alldata[i];
					count++;
	    	    }
	        }

			$().log('Cleanup: ' + count + 'element(s)', 'RestoreEdit');
	    },

		stop: function(){
			if(this.timerId != null){
				clearInterval(this.timerId);
			}
		},

	    store: function(datatostore){
	    	var data = this.getData();

	    	//local clean remove old sessions
	    	for(var i in data.sessions){
	    		if((this.getTime() - data.sessions[i].timestamp) > this.sessionTimeout){
	    			delete data.sessions[i];
	    		}
	    	}

	    	data.timestamp = this.getTime();
	        data.newest = this.sessionId;
	    	data.sessions[this.sessionId] = {
	                'timestamp': this.getTime(),
	                'opened': this.openTime,
	                'data': datatostore
	        };

	    	this.storeData(data);
	    },

	    getData: function(){
	    	var alldata = $.storage.get(this.mainKey);
			if(!alldata || !alldata[this.dataKey]){
	    		return this.defaultData;
	    	}

	    	return alldata[this.dataKey];
	    },

	    storeData: function(data) {
	    	var alldata = $.storage.get(this.mainKey) || {};

	    	alldata[this.dataKey] = data;
			try {
				$.storage.set(this.mainKey, alldata);
				//$().log('Data stored', 'RestoreEdit');
			} catch (e) {
				$.storage.flush();
				$().log('Local Storage Exception:' + e.message);
			}
	    },

	    getOldData: function() {
	        /* for now just take newest code is prepare for user base choice*/
	    	if(this.oldData.newest){
	    		return this.oldData.sessions[this.oldData.newest];
	    	}

	    	return false;
	    },

	    createSessionId: function() {
	        return uniqueId('_', true);
	    },

	    getTime: function() {
	        return Math.round((new Date()).getTime() / 1000);
	    }
	});

});
})(this,jQuery);
