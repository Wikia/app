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

	WET.byStr( '1_emails/founder/' + codes[code] );
};

$(function() {
	if( $.getUrlVar("ctc") != undefined ) {
		FounderEmails.track( $.getUrlVar("ctc") )
	};
});
