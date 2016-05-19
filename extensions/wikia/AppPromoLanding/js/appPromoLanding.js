// Branch.io form integration. Sends the link to the phone number entered into the form.
(function(b,r,a,n,c,h,_,s,d,k){if(!b[n]||!b[n]._q){for(;s<_.length;)c(h,_[s++]);d=r.createElement(a);d.async=1;d.src="https://cdn.branch.io/branch-latest.min.js";k=r.getElementsByTagName(a)[0];k.parentNode.insertBefore(d,k);b[n]=h}})(window,document,"script","branch",function(b,r){b[r]=function(){b._q.push([r,arguments])}},{_q:[],_v:1},"addListener applyCode banner closeBanner creditHistory credits data deepview deepviewCta first getCode init link logout redeem referrals removeListener sendSMS setIdentity track validateCode".split(" "), 0);
branch.init( window.branchKey ); // need to do this before the sendToBranch stuff is called.

// Determine if the user is on iOS or Android, and if-so, immediately direct them to the correct store page.
var userAgent = navigator.userAgent.toLowerCase();
if(userAgent.indexOf("android") > -1) {
	// We will send them through Branch.io instead, for now.
	//if(window.androidUrl){
	//	window.location = window.androidUrl;
	//}
	redirectToBranchLink();
} else if( userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i ) ) {
	// We will send them through Branch.io instead, for now.
	//if(window.iosUrl){
	//	window.location = window.iosUrl;
	//}
	redirectToBranchLink();
}

// Make the "GET" button hidden until the form field has some value.
$(function() {
	$('form#branchIoForm input').keyup(function() {
		if($('form#branchIoForm input').val() != ''){
			$('form#branchIoForm button').css('visibility', 'visible');
		} else {
			$('form#branchIoForm button').css('visibility', 'hidden');
		}
	});
});

function sendSMS() {
	branch.sendSMS(
		$('form#branchIoForm input').val(),
		{
			channel: 'Wikia',
			feature: 'Text-Me-The-App',
			campaign: 'apppromolanding'
		}, { make_new_link: false }, // Default: false. If set to true, sendSMS will generate a new link even if one already exists.
		function(err) { console.log(err); }
	);
	return false;
}

// When this is called, the user will be redirect to the branch.io link for the app
// which will send the user directly to the store corresponding to their platform.
function redirectToBranchLink(){
	branch.link({
		channel: 'Wikia',
		feature: 'auto-redirect',
		campaign: 'apppromolanding',
	}, function(err, link) {
		if(err){
			consloe.log(err);
		}
		window.location = link;
	});	
}
