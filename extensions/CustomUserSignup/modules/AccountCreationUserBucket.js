//checks
if(!mw.activeCampaigns){ mw.activeCampaigns ={}; }

//define new active campaign
mw.activeCampaigns.AccountCreation =

{ 
  //Treatment name
  "name": "AccountCreation",
  
  //Treatment version. Increment this when altering rates
  "version": 1,
  
  "preferences": {"setBuckets" : false },
  
  // Rates are calculated out of the total sum, so
  // rates of x:10000, y:3, and z:1 mean users have a
  // chance of being in bucket x at 10000/10004,
  // y at 3/10004 and z at 1/10004
  // The algorithm is faster if these are ordered in descending order,
  // particularly if there are orders of magnitude differences in the
  // bucket sizes
  // "none" is reserved for control
  "rates": {"ACP1": 25, "ACP2": 25, "ACP3": 25, "none": 25},
  
  // individual changes, function names corresponding
  // to what is in "rates" object
  // (note: "none" function not needed or used)
  
  "ACP1": function(){
	  //change to NiceMsg1 campaign
	  $j("#pt-anonlogin a").each(function(){
		  $j(this).attr("href", $j(this).attr("href") + "&campaign=ACP1" ); 
	  });
	  $j("#pt-login a").each(function(){
		  $j(this).attr("href", $j(this).attr("href") + "&campaign=ACP1" ); 
	  });
	  
  },
  "ACP2": function(){
	  //change to NiceMsg2 campaign
	  $j("#pt-anonlogin a").each(function(){
		  $j(this).attr("href", $j(this).attr("href") + "&campaign=ACP2" ); 
	  });
	  $j("#pt-login a").each(function(){
		  $j(this).attr("href", $j(this).attr("href") + "&campaign=ACP2" ); 
	  });
  },

  "ACP3": function(){
	  //change to NiceMsg2 campaign
	  $j("#pt-anonlogin a").each(function(){
		  $j(this).attr("href", $j(this).attr("href") + "&campaign=ACP3" ); 
	  });
	  $j("#pt-login a").each(function(){
		  $j(this).attr("href", $j(this).attr("href") + "&campaign=ACP3" ); 
	  });
  },
  
  // "allActive" is reserved.
  // If this function exists, it will be apply to every user not in the "none" bucket
  "allActive": function(){
		   
		  //track account creation attempts
		  $j("#wpCreateaccount").click(function(){ $j.trackAction('submit-signup-data'); });
		  
		  //this is the "don't have an account? CREATE ONE" link
		  $j("#userloginlink").click(function(){ $j.trackAction('visit-signup'); });
		  
	if($j.cookie('acctcreation') ){
		  //add click tracking to preview
		  $j("#wpPreview").click(function(){ $j.trackAction('preview'); });
		  
		  //add click tracking to save
		  $j("#wpSave").click(function(){ $j.trackAction('save'); });
	  }
  },
	  
  "all": function(){
			//add up all rates
			var campaign = mw.activeCampaigns.AccountCreation;
		  	if( $j.cookie('userbuckets') && 
		  			$j.parseJSON( $j.cookie('userbuckets') )["AccountCreation"]){
		  		var buckets = $j.parseJSON( $j.cookie('userbuckets') );
		  		
		  		if(typeof(campaign[buckets[campaign.name][0]]) == "function"){
		  			campaign[buckets[campaign.name][0]](); //function to execute
					campaign.allActive();
					return;
		  		}
		  	} else {
				var bucketTotal = 0;
				for ( var rate in campaign.rates ){
					bucketTotal += campaign.rates[rate];
				}
				
				//give the user a random number in those rates
				var currentUser = Math.floor(Math.random() * (bucketTotal+1));
				
				// recurse through the rates until we get into the range the user falls in,
				// assign them to that range
				var prev_val = -1;
				var next_val = 0;
				for( rate in campaign.rates ){
					next_val += campaign.rates[rate];
					if(prev_val <= currentUser && currentUser < next_val){
						if(rate != "none"){
							campaign[rate]();
						}
						break;
					}
					prev_val = next_val;
				}
		  	}//else
		 }  
  
};