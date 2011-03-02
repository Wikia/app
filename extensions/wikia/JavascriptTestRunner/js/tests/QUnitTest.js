/*
@test-framework QUnit
*/
module("Module A");
test("first test within module", function() {
  ok( true, "all pass" );
});
test("second test within module", function() {
  ok( true, "all pass" );
});
module("Module B");
test("some other test", function() {
  expect(2);
  equals( true, false, "failing test" );
  equals( true, true, "passing test" );
});
