/*the sequence remote search driver
 	extends the base remote search driver with sequence specific stuff. 	
 	could seperate this out into seperate lib.
*/
var seqRemoteSearchDriver = function(initObj){
	return this.init( initObj )
}
seqRemoteSearchDriver.prototype = {
	init:function( initObj ){
		//inherit the remoteSearchDriver properties: 
		var tmpRSD = new remoteSearchDriver( initObj );
		for(var i in tmpRSD){
			if(this[i]){
				this['parent_'+i] = tmpRSD[i];
			}else{
				this[i] = tmpRSD[i];
			}
		}
	},	
	addResultBindings:function(){
		//set up seq:		
		var _this = this;
		//setup parent bindings:
		this.parent_addResultBindings();
		
		//add an additional drag binding
		var source_pos = null;
		var insert_key='na';
		var clip_key ='';
		
		//@@todo support multiple tracks
		$j('.mv_clip_box_result').draggable({
			start:function(){
				source_pos = $j(this).offset();
				js_log("update pos of: #clone_" + this.id + ' to l:' +source_pos.left  + ' t:' + source_pos.top ); 
				$j('#clone_' + this.id).css(source_pos);
			},
			helper:function(){			
				//js_log(' should put at: ' + source_pos.left + ' ' + source_pos.right);
				//get source pos:
				//$j(this).clone().attr('id', 'clone_' + this.id).css({'z-index':'101'}).appendTo('body');
				$j(this).clone().attr('id', 'clone_' + this.id).css({
					'z-index':'101',
					'position':'absolute'
				}).appendTo('#container_track_0'); 
				js_log('appended: ' +  'clone_' + this.id );
				return $j('#clone_'+this.id).get(0);
			},
			drag:function(e, ui){
				insert_key = _this.p_seq.clipDragUpdate(ui, this);		
			},
			//do contain: 
			containment:'#container_track_0',
			stop:function(){
				js_log('done drag insert after: ' + insert_key);
			}			
		}); 
	
	},
	resourceEdit:function(rObj, rsdElement){
		//pass along for now: 
		this.parent_resourceEdit(rObj, rsdElement);
	}
}