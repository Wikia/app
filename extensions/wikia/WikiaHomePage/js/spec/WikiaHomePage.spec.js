describe("Wikia Home Page", function(){

	it("remixing - default", function() {
		var collectionId;
		var WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 0;
		WikiaRemixInstance.shownCollections = {
			3: false,
			10: false,
			9: false
		};

		collectionId = WikiaRemixInstance.getNextCollectionId();
		expect(collectionId).toBe('3');
		WikiaRemixInstance.markCollectionAsShown(collectionId);

		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);

		collectionId = WikiaRemixInstance.getNextCollectionId();
		expect(collectionId).toBe('10');
		WikiaRemixInstance.markCollectionAsShown(collectionId);

		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);

		collectionId = WikiaRemixInstance.getNextCollectionId();
		expect(collectionId).toBe('9');
		WikiaRemixInstance.markCollectionAsShown(collectionId);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
	});

	it("remixing - one collection", function() {
		var collectionId;
		var WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 0;
		WikiaRemixInstance.shownCollections = {
			7: false
		};

		collectionId = WikiaRemixInstance.getNextCollectionId();
		expect(collectionId).toBe('7');
		WikiaRemixInstance.markCollectionAsShown(collectionId);

		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
	});

	it("remixing - one shown", function() {
		var collectionId;
		var WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 0;
		WikiaRemixInstance.shownCollections = {
			3: true,
			10: false,
			9: false
		};

		collectionId = WikiaRemixInstance.getNextCollectionId();
		expect(collectionId).toBe('10');
		WikiaRemixInstance.markCollectionAsShown(collectionId);

		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);

		collectionId = WikiaRemixInstance.getNextCollectionId();
		expect(collectionId).toBe('9');
		WikiaRemixInstance.markCollectionAsShown(collectionId);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
	});

	it("remixing - other shown", function() {
		var collectionId;
		var WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 0;
		WikiaRemixInstance.shownCollections = {
			3: false,
			10: true,
			9: false
		};

		collectionId = WikiaRemixInstance.getNextCollectionId();
		expect(collectionId).toBe('3');
		WikiaRemixInstance.markCollectionAsShown(collectionId);

		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);

		collectionId = WikiaRemixInstance.getNextCollectionId();
		expect(collectionId).toBe('9');
		WikiaRemixInstance.markCollectionAsShown(collectionId);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
	});

	it("remixing - all shown", function() {
		var collectionId;
		var WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 0;
		WikiaRemixInstance.shownCollections = {
			3: true,
			10: true,
			9: true
		};

		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
	});

	it("remixing - no collections", function() {
		var collectionId;
		var WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 0;
		WikiaRemixInstance.shownCollections = {
		};

		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
	});

	it("remixing - counter increased", function() {
		var collectionId;
		var WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 2;
		WikiaRemixInstance.shownCollections = {
			3: false,
			10: false,
			9: false
		};

		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		collectionId = WikiaRemixInstance.getNextCollectionId();
		expect(collectionId).toBe('3');
		WikiaRemixInstance.markCollectionAsShown(collectionId);

		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);

		collectionId = WikiaRemixInstance.getNextCollectionId();
		expect(collectionId).toBe('10');
		WikiaRemixInstance.markCollectionAsShown(collectionId);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
	});

	it("remixing - counter increased one shown", function() {
		var collectionId;
		var WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 2;
		WikiaRemixInstance.shownCollections = {
			3: true,
			10: false,
			9: false
		};

		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		collectionId = WikiaRemixInstance.getNextCollectionId();
		expect(collectionId).toBe('10');
		WikiaRemixInstance.markCollectionAsShown(collectionId);

		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);

		collectionId = WikiaRemixInstance.getNextCollectionId();
		expect(collectionId).toBe('9');
		WikiaRemixInstance.markCollectionAsShown(collectionId);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionId()).toBe(undefined);
	});
});

