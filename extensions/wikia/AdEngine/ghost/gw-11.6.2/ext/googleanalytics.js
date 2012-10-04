/* 
 * 
 * @preserve Copyright(c) 2010-2011 Digital Fulrcum, LLC 
 * (http://digital-fulcrum.com). All rights reserved.
 * License: See license.txt or http://digital-fulcrum.com/ghostwriter-license/ 
 * GhostWriter: http://digital-fulcrum.com/ghostwriter-complete-control
 * Release: 11.6.2 
 */
ghostReporter= (function(W){
var
	 D= document
	,Debug= W.ghostwriter.debug

	,$StartTime= W.START || new Date()
	,$Handlers= ghostwriter['handlers']= {
		 'begin':startGhostLoad
		,'end':endGhostLoad
		,'onelement': onElement

	}
	,$Ie= W.navigator.userAgent.indexOf("MSIE")> 0  && !W.opera
	,$GoogleAnalyticsAccount= "UA-XXXXXXX-X"

	,$SampleRate= 5
	,$Threshold= 5000
	,$Floor= 50
	,$SamplesSent= 0

	,$ReportDelay= 1
	,$CurrentReporter= null
	,$GoogleTracker= W._gaq= (function(){
		var
			 $= []
			,ga= D.createElement('script')
			,firstScript= D.getElementsByTagName("SCRIPT")[0]

		;
		$.push(['_setAccount', $GoogleAnalyticsAccount])
		$.push(['_trackPageview'])

		ga.async= true
		ga.src=
			(D.location.protocol ==
			'https:' ? 'https://ssl' : 'http://www')
			+ ".google-analytics.com/ga.js"

		firstScript.parentNode.insertBefore(
			ga, firstScript
		)
		return $
	 })()
	 ,$WantThese= { 
	 	OBJECT: $Ie ? "addFlashLoadHandler" : false, 
	 	EMBED: $Ie ? false : "addFlashLoadHandler"
	  }
	 ,adCalls= W.timing= { }
;
function startGhostLoad(scriptElement){
	var
		 id= scriptElement.id
		,tracker
	;
	if(!id)
		return
	tracker= $CurrentReporter= adCalls[id]= adCalls[id] || new ghostLoadReporter(id)
	tracker.start()
}
function endGhostLoad(scriptElement){
	var
		 id= scriptElement.id
		,tracker= adCalls[id]
	;
	if(!id || !tracker)
		return
	tracker.end()
	$CurrentReporter= null
}
function onElement(element){
	if(!wantElement(element))
		return
	$CurrentReporter.addComponent(element)
}
function wantElement(element){
	return $CurrentReporter &&
		$WantThese[element.tagName] ||
		(element.src && !(element.tagName in $WantThese))
}
function ghostLoadReporter( id ){
	this.id= id
	this.setBuckets( [ 100, 500, 1000, 2000, 5000, 10000, 30000] )
	this.components= { }
	this.waiting= { }
	this.tracker= _gat
		._createTracker($GoogleAnalyticsAccount)
	;
}

ghostLoadReporter.prototype= {
	start: function(){
		this.startTime= new Date
		this.startOffset= Number ( this.startTime - $StartTime )

		if(shouldSample())
			this.report(
				this.getBucketValue(this.startOffset)
				,"startOffset"
				,this.startOffset
			)
	}
	,end: function(){
		this.endTime= new Date
		this.duration= this.endTime - this.startTime

		if(shouldSample())
			this.report(
		 		this.getBucketValue(self.duration)
				,"loadTime"
				,this.duration
			)

		return this
	}
	,addComponent: function(element){
		if(!shouldSample()) 
			return 

		var
			 id= element.tagName + '://' +  getComponentId(element)
			,self= this
			,method= element.tagName in $WantThese ? 
				$WantThese[element.tagName] : "addLoadHandler"
		;

		this.waiting[id]= new Date

		this[method](element, handler)

		function handler(){ 
			self.reportComponent(id)
		}
	}
	,report: function( action, label, value ){
		var
			 eventTracker= this.tracker._createEventTracker(this.id)
		;

		/*resetTrackingLimit(eventTracker)*/

		eventTracker._trackEvent(action,label,value)

		if(Debug())
			flog( [
				this.id, "logging", action , "as", label, "with value", value
		      	      ].join( " " )
			)
		return true
	}
	,reportComponent: function(id){
		var
			 waiting= this.waiting
			,started= waiting[id]
			,duration= Number(new Date - started)
		;

		if( duration > $Threshold)
			this.report(id,'componentTimeout',duration)
		else if(duration > $Floor && shouldSample())
			this.report(id,'componentLoad',duration)

		delete waiting[id]

	}

	,addLoadHandler: function(element,handler){
		if(element.addEventListener) {
			type= "load"
			element.addEventListener(type, onload, false)
		}else if(element.attachEvent){
			type="onreadystatechange"
			element.attachEvent(type, onload)
		}

		function onload(event){
			if(
				element.readyState &&
				element.readyState != 'complete' &&
				element.readyState != 'loaded'
			)
				return true

			handler.apply(this,arguments)
			removeEvent.call(this, type, arguments.callee)
		}
	}
	,addFlashLoadHandler: function (element,handler){
		var
			 self= this
			,tries= 50
			,loaded= isFlashLoaded(element)
			,interval= Math.floor($Threshold / tries)
			,intervalTimer
		;
		if(loaded === null)
			delete this.waiting[id]
		else if(loaded)
			handler.apply(element)
		else
			intervalTimer= setInterval(testFlash, interval)

		return

		function testFlash(){
			var loaded= isFlashLoaded(element)
			flog("testing flash component '"  + element.name + "' " + tries)

			if(loaded)
				handler.apply(element)

			if(--tries <= 0 || loaded)
				clearInterval(intervalTimer)
		}
	}
	,setBuckets: function(bucketList){
		this.buckets= bucketList.sort(bucketSort)
	}
	,getBucketValue: function(value){
		var
			 bList= this.buckets
			 ,str= ""
		;
		for(var i=0, l = bList.length; i < l; i++){
			if(value >= bList[i])
				continue
			if(i==0)
				return "0-" + bList[i]
			else
				return bList[i-1] + "-" + (bList[i] - 1)
		}
		return bList[bList.length-1] + "+"
	}
}
function bucketSort(a,b){return (a-b)}
function shouldSample(){
	var rnd= Math.round( Math.random() * 100 )
	if(rnd <= $SampleRate){
		return true
	}
}
function getComponentId(element){
	var
		  re=  /:\/\/([^?;=]+)/
		 ,url= element.src || element.movie || element.data || element.href || ""
		 ,m= re.exec(url)
	;
	if(m && m.length > 1)
		return m[1]
	else
		return false
}
function removeEvent(type,listener){
	if(this.removeEventListener)
		this.removeEventListener(type, listener, false)
	else if(this.detachEvent)
		this.detachEvent(type, listener)
	return
}
/*function resetTrackingLimit(b){
	var a=
		('xe' in b && 'l' in b.xe && 'J' in b.xe.l && b.xe.l.J) ||
		('qe' in b && 'k' in b.qe && 'I' in b.qe.k && b.qe.k.I)
	if(!a)
		return true
	for(var i=0, l = a.length; i < l ; i++){
		if(a[i][0] == '__utmb=') {
			var
				 c= a[i]
				,j= c[1]().split(".")
			;
			j[1] > 0 && j[1]--
			j[2] ++
			c[2](j.join("."))
			c[3]()
			return true
		}
	}
	return true
}*/
function isFlashLoaded (element){

	if(!element.parentNode)
		return false
	try {
		return element.PercentLoaded() == 100
	}
	catch(e) { return false }

}

return ghostLoadReporter
})(this);

