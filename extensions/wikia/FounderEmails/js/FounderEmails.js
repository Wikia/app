var FounderEmails = {};

FounderEmails.track = function( code ) {
	codes = {};
	codes.FE01 = 'userregistered/userpage';
	codes.FE02 = 'edit/userpage';
	codes.FE03 = '0days/unsubscribe';
	codes.FE04 = 'userregistered/unsubscribe';
	codes.FE05 = 'edit/unsubscribe';
	codes.FE06 = 'editfirst/userpage';
	codes.FE07 = 'editfirst/unsubscribe';
	codes.FE08 = '3days/unsubscribe';
	codes.FE09 = '10days/unsubscribe';

	codes.FE10 = '10days/logoupload';
	codes.FE11 = '10days/logoinstructions';
	codes.FE12 = '10days/changeskins';
	codes.FE13 = '10days/gettingstarted';
	codes.FE14 = '10days/forums';
	codes.FE15 = '3days/myhome';
	codes.FE16 = '3days/gettingstarted';
	codes.FE17 = '3days/forums';
	codes.FE18 = '0days/gettingstarted';
	codes.FE19 = '0days/forums';
	codes.FE20 = 'editanon/myhome';

	codes.AFE01 = 'answers/userregistered/userpage';
	codes.AFE02 = 'answers/edit/userpage';
	codes.AFE03 = 'answers/0days/unsubscribe';
	codes.AFE04 = 'answers/userregistered/unsubscribe';
	codes.AFE05 = 'answers/edit/unsubscribe';
	codes.AFE06 = 'answers/editfirst/userpage';
	codes.AFE07 = 'answers/editfirst/unsubscribe';
	codes.AFE08 = 'answers/3days/unsubscribe';
	codes.AFE09 = 'answers/10days/unsubscribe';
	codes.AFE10 = 'answers/10days/logoupload';
	codes.AFE11 = 'answers/10days/logoinstructions';
	codes.AFE12 = 'answers/10days/changeskins';
	codes.AFE13 = 'answers/10days/gettingstarted';
	codes.AFE14 = 'answers/10days/forums';
	codes.AFE15 = 'answers/3days/myhome';
	codes.AFE16 = 'answers/3days/gettingstarted';
	codes.AFE17 = 'answers/3days/forums';
	codes.AFE18 = 'answers/0days/gettingstarted';
	codes.AFE19 = 'answers/0days/forums';
	codes.AFE20 = 'answers/editanon/myhome';

	WET.byStr( '1_emails/founder/' + codes[code] );
};

$(function() {
	if( $.getUrlVar("ctc") != undefined ) {
		FounderEmails.track( $.getUrlVar("ctc") )
	};
});
