//setup verification fields on the form

function validateInput( fieldtype,fieldid ) {
	var inputVal = document.getElementById(fieldid).value;
	var valresult = document.getElementById(fieldid+'val');
	$.ajax({
		type: "POST",
		url: mw.util.wikiScript('api'),
		data: {'action':'validatesignup', 'format':'json', 'field':fieldtype, 'inputVal':inputVal },
		dataType: 'json',
		success: function( jsondata ){
			var image = "<img src='"+ imagePath + jsondata.signup.icon +"'>";
			var message = jsondata.signup.result;
			valresult.innerHTML = image+message;
		}
	});
}

function passwordStrength() {
	var strength = document.getElementById('wpPassword2val');
	var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
	var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
	var enoughRegex = new RegExp("(?=.{6,}).*", "g");
	var pwd = document.getElementById("wpPassword2");

	if (pwd.value.length==0) {
		strength.innerHTML = mw.message( 'signupapi-enterpassword' );
	} else if (pwd.value.length<minlength) {
		strength.innerHTML = mw.message( 'signupapi-passwordtooshort', minlength );
		$("#progress").progressbar({value: 10});
		$("div.ui-progressbar-value").css("background","red");
	} else if (strongRegex.test(pwd.value)) {
		strength.innerHTML = '<span style="color:green">'+mw.message( 'signupapi-strong' )+'</span>';
			$("#progress").progressbar({value: 100});
		$("div.ui-progressbar-value").css("background","green");
	} else if (mediumRegex.test(pwd.value)) {
		strength.innerHTML = '<span style="color:orange">'+mw.message( 'signupapi-medium' )+'</span>';
		$("#progress").progressbar({value: 60});
		$("div.ui-progressbar-value").css("background","orange");
	} else {
		strength.innerHTML = '<span style="color:red">'+mw.message( 'signupapi-weak' )+'</span>';
		$("#progress").progressbar({value: 30});
		$("div.ui-progressbar-value").css("background","red");
	}
}

function checkRetype( pass,retype ) {
	var valresult = document.getElementById('wpRetypeval');
	var image = "";
	var message = "";
	if ( pass==retype ) {
		image = "<img src='"+ imagePath +"MW-Icon-CheckMark.png'>";
		message = mw.message( 'signupapi-passwordsmatch' );
	}else {
		image = "<img src='"+ imagePath +"MW-Icon-NoMark.png'>";
		message = mw.message( 'signupapi-badretype' );
	}
	valresult.innerHTML = image+message;
}

$('#wpName2').change(function() {validateInput("username","wpName2");});
$('#wpPassword2').keyup(function() {passwordStrength();});
$('#wpRetype').change(function() {checkRetype(document.getElementById("wpPassword2").value,document.getElementById("wpRetype").value);});
$('#wpEmail').change(function() {validateInput( "email","wpEmail" );});

$('#wpName2').after('<span id="wpName2val" class="wpName2val"></span>');
$('#wpPassword2').after('<span id="wpPassword2val"></span><div id="progress" class="progress" style="width:30%; float: right;"></div>');
$('#wpRetype').after('<span id="wpRetypeval" class="wpRetypeval"></span>');
$('#wpEmail').after('<span id="wpEmailval" class="wpEmailval"></span>');

$("#progress").progressbar();
console.log();
$('div.ui-progressbar').css('background','#F2F5F7');

var imagePath = window.wgServer+window.wgExtensionAssetsPath + "/SignupAPI/includes/images/";
var minlength = window.wgMinimalPasswordLength;


