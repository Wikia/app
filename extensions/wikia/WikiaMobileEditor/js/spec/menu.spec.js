describe("Menu handler test cases", function() {

    var menu = modules.menu();

    // initializer should be a defined function
    it("should be defined", function(){
        expect(menu.init).toBeDefined();
    });

    it("should be a function", function(){
        expect(typeof menu.init).toBe(function);
    });
});