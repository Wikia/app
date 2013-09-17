describe("Menu handler test cases", function() {

    var menu = modules['menu'];

    it("returns 0 for numbers bigger than 2 * Pi = 360 degrees (for circle)", function() {
        expect(getRange(700)).not.toBe(true);
    });

    it("should be defined", function(){
        expect(typeof init).toBe(true);
    });
});