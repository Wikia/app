// TODO copy interface from ApiUploadHandler -- it changed

// Currently this doesn't at all follow the interface that Mdale made in UploadHandler
// will have to figure this out.

// this should be loaded with test suites when appropriate. separate file.
mw.MockUploadHandler = function(upload) {
	this.upload = upload;
	this.nextState = null;
	this.progress = 0.0;

};

mw.MockUploadHandler.prototype = {
	
	start: function () {
		var _this = this;
		_this.beginTime = (new Date()).getTime();
		_this.nextState = _this.cont;
		_this.nextState();
	},  
 
	cont: function () {
		var _this = this;
		var delta = 0.0001; // static?
		_this.progress += ( Math.random() * 0.1 );
		_this.upload.setTransportProgress(_this.progress);
		if (1.0 - _this.progress < delta) {
			_this.upload.setTransported();
		} else {
			setTimeout( function() { _this.nextState(); }, 200 );
		}
	}
 
};


