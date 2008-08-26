function toggle_user(user_id){
        if ($D.hasClass("user-" + user_id ,'blast-friend-selected')){
		$D.replaceClass("user-" + user_id,'blast-friend-selected','blast-friend-unselected');	
        }else if ($D.hasClass("user-" + user_id ,'blast-friend-unselected')){
		$D.replaceClass("user-" + user_id,'blast-friend-unselected','blast-friend-selected');
	}
	
        if ($D.hasClass("user-" + user_id ,'blast-foe-selected')){
		$D.replaceClass("user-" + user_id,'blast-foe-selected','blast-foe-unselected');
        }else if ($D.hasClass("user-" + user_id ,'blast-foe-unselected')){
		$D.replaceClass("user-" + user_id,'blast-foe-selected','blast-foe-unselected');
	}	
 
}

function toggle_type(method,on,off){

	list = $$( ((method==1)?off:on) ,'div','blast-friends-list')

	for(x=0;x<=list.length-1;x++){
		el = list[x];
		if($D.hasClass(el,on) || $D.hasClass(el,off)){
			if(method==1){
				$D.replaceClass(el,off,on); 
			}else{
				$D.replaceClass(el,on,off);
			}
		}
		
	}
}

function toggle_friends(method){
	toggle_type(method,'blast-friend-selected','blast-friend-unselected')
}

function toggle_foes(method){
	toggle_type(method,'blast-foe-selected','blast-foe-unselected')
}

function select_all(){
	toggle_friends(1)
	toggle_foes(1)
}
function unselect_all(){
	toggle_friends(0)
	toggle_foes(0)
}

submitted = 0;
function send_messages( ){
	
	if(submitted == 1)return 0;
	
	submitted = 1
	selected = 0;
	user_ids_to = "";
	
	list = $$('blast-friend-selected','div','blast-friends-list')
	for(x=0;x<=list.length-1;x++){
		el = list[x];
		selected++;
		user_id = el.id.replace("user-","");
		user_ids_to += ((user_ids_to)?",":"") + user_id	 
	} 
	list = $$('blast-foe-selected','div','blast-friends-list')
	for(x=0;x<=list.length-1;x++){
		el = list[x];
		selected++;
		user_id = el.id.replace("user-","");
		user_ids_to += ((user_ids_to)?",":"") + user_id	 
	} 
	
	if(selected==0){
		alert("Please select at least one person");
		submitted = 0;
		return 0;
	}

	
	if( !$("message").value ){
		alert("Please enter a message");
		submitted = 0;
		return 0;
	}
 
	$("ids").value =  user_ids_to;

	document.blast.message.style.color = "#ccc";
	document.blast.message.readOnly = true;
	$("blast-friends-list").innerHTML = 'Sending messages...';
	document.blast.submit();
}
