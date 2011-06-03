/*
@test-framework QUnit
@test-require-module mockjax
*/

/**
 * This is an example test of mocking ajax requests
 */
module("Ajax Test");
test("example test", function() {
	
	// prepare the mocked response and behavior
	$.mockjax({
		// define which ajax requests should be intercepted by this rule
		url: '/restful/fortune',
		// time to wait before call the request callback
		responseTime: 750,
		// actual response which should be returned to the callback
		responseText: {
			status: 'success',
			fortune: 'Are you a turtle?'
		}
	});

	// we need to notify QUnit about asynchronous operation
	// 1500 is the timeout (which is set to be greater than "responseTime"
	//   setting from mocked request
	stop(1500);
	
	// do the actual request
	$.getJSON('/restful/fortune', function(response) {
		// test response
		equal( response.status, 'success', 'status' );
		equal( response.fortune, 'Are you a turtle?', 'fortune' );
		// clear ajax mocking configuration
		$.mockjaxClear();
		// continue processing next tests
		start();
	});
	
});
