/**
 * Test explaining how to create mocked ajax response
 */

/*
@test-exclude This test is just an example
// Set framework to QUnit
@test-framework QUnit
// Specify dependency list
@test-require-module mockjax
*/

// Define new QUnit test module
module("Ajax Test");

// Add the following test to current test module
test("example test", function() {
	
	// prepare the mocked response
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
	// 1500ms is the timeout (which needs to be greater than "responseTime"
	//   setting for mocked response)
	stop(1500);
	
	// do the actual request
	$.getJSON('/restful/fortune', function(response) {
		// test response
		equal( response.status, 'success', 'status' );
		equal( response.fortune, 'Are you a turtle?', 'fortune' );
		// clear ajax mocking configuration
		$.mockjaxClear();
		// continue tests processing by QUnit
		start();
	});
	
});
