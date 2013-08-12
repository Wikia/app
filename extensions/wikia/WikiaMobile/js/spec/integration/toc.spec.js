describe("Toc module", function() {
	var sections = {
			open: function(){}
		},
		track = {
			event: function(){},
			CLICK: ''
		},
		body = getBody(),
		window = {
			document: {
				body: body,
				getElementById: function(id){
					return body.querySelector('#' + id);
				}
			}
		},
		toc = modules.toc(track, sections, window, jQuery);

	it('should be defined', function(){
			expect(toc).toBeDefined();
			expect(typeof toc.init).toEqual('function');
			expect(typeof toc.open).toEqual('function');
			expect(typeof toc.close).toEqual('function');
	});

	it('should init', function(done){
		body.innerHTML = '<div id="mw-content-text"><table id="toc" class="toc"><div id="toctitle"></div></table></div>';

			toc.init();

			expect(window.document.body.className).toMatch('hasToc');

			var chev = window.document.getElementById('toctitle').querySelectorAll('.chev');
			expect(chev.length).toEqual(1);
	});

	it('should open/close toc', function(){
		body.innerHTML = '<div id="mw-content-text"><table id="toc" class="toc"><div id="toctitle"></div></table></div>';

		var d = window.document;

		toc.init();
		toc.open();

		expect(d.getElementById('toc').className).toMatch('open');
		expect(d.body.className).toMatch('hidden');

		toc.close();

		expect(d.getElementById('toc').className).not.toMatch('open');
		expect(body.className).not.toMatch('hidden');
	})
});
