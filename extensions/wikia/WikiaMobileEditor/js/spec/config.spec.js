describe("Config tests suite", function() {

    var config = modules.config();

    //initializer function
    it("should be defined", function() {
        expect(config.init).toBeDefined;
    });

    it("should be a function", function() {
        expect(typeof config.init).toBe('function');
    });

});
