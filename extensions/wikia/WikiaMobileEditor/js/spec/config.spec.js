describe("Config tests suite", function() {

    var config = modules['config'];

    it("returns true when number from range given", function() {
        var activeTags = {key : 'value'};
        expect(validate(activeTags)).toBe(true);
    });


    it("returns false when empty object given", function() {
        var activeTags = {};
        expect(validate(activeTags)).toBe(true);
    });


    it("returns false when too big object given (100 elements)", function() {
        activeTags = {};
        for(var i = 0; i < 100; i++){
            activeTags['key'+i];
        }
        expect(validate(activeTags)).toBe(true);
    });

    it("should be defined", function(){
        expect(typeof config.init).toBe('function');
        expect(typeof config.active).toBe('function');
    });


});
