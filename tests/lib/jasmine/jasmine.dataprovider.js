/**
 * Jasmine dataprovider functionality
 * https://github.com/jphpsf/jasmine-data-provider
 * Licence: WTFPL
 *
 * Instead:
 * describe("username validation", function() {
 *  it("should return true for valid usernames", function() {
 *     expect(validateUserName("abc")).toBeTruthy();
 *     expect(validateUserName("longusername")).toBeTruthy();
 *     expect(validateUserName("john_doe")).toBeTruthy();
 *   });
 *
 *   it("should return false for invalid usernames", function() {
 *     expect(validateUserName("ab")).toBeFalsy();
 *     expect(validateUserName("name_too_long")).toBeFalsy();
 *     expect(validateUserName("no spaces")).toBeFalsy();
 *     expect(validateUserName("inv*alid")).toBeFalsy();
 *   });
 * })
 *
 * Use:
 * describe("username validation", function() {
 *   using("valid values", ["abc", "longusername", "john_doe"], function(value){
 *     it("should return true for valid usernames", function() {
 *       expect(validateUserName(value)).toBeTruthy();
 *     })
 *   })
 *
 *   using("invalid values", ["ab", "name_too_long", "no spaces", "inv*alid"], function(value){
 *     it("should return false for invalid usernames", function() {
 *       expect(validateUserName(value)).toBeFalsy();
 *     })
 *   })
 * })
 */
function using(name, values, func){
	for (var i = 0, count = values.length; i < count; i++) {
		if (Object.prototype.toString.call(values[i]) !== '[object Array]') {
			values[i] = [values[i]];
		}
		func.apply(this, values[i]);
		jasmine.currentEnv_.currentSpec.description += ' (with "' + name + '" using ' + JSON.stringify(values[i]) + ')';
	}
}
