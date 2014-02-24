describe('Wikia Home Page', function(){

	it('remixing - default', function() {
		var collectionIndex,
			WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 0;
		WikiaRemixInstance.collections = [
			{shown: false},
			{shown: false},
			{shown: false}
		];

		collectionIndex = WikiaRemixInstance.getNextCollectionIndex();
		expect(collectionIndex).toBe(0);
		WikiaRemixInstance.markCollectionAsShown(collectionIndex);

		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);

		collectionIndex = WikiaRemixInstance.getNextCollectionIndex();
		expect(collectionIndex).toBe(1);
		WikiaRemixInstance.markCollectionAsShown(collectionIndex);

		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);

		collectionIndex = WikiaRemixInstance.getNextCollectionIndex();
		expect(collectionIndex).toBe(2);
		WikiaRemixInstance.markCollectionAsShown(collectionIndex);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
	});

	it('remixing - one collection', function() {
		var collectionIndex,
			WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 0;
		WikiaRemixInstance.collections = [
			{shown: false}
		];

		collectionIndex = WikiaRemixInstance.getNextCollectionIndex();
		expect(collectionIndex).toBe(0);
		WikiaRemixInstance.markCollectionAsShown(collectionIndex);

		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
	});

	it('remixing - one shown', function() {
		var collectionIndex,
			WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 0;
		WikiaRemixInstance.collections = [
			{shown: true},
			{shown: false},
			{shown: false}
		];

		collectionIndex = WikiaRemixInstance.getNextCollectionIndex();
		expect(collectionIndex).toBe(1);
		WikiaRemixInstance.markCollectionAsShown(collectionIndex);

		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);

		collectionIndex = WikiaRemixInstance.getNextCollectionIndex();
		expect(collectionIndex).toBe(2);
		WikiaRemixInstance.markCollectionAsShown(collectionIndex);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
	});

	it('remixing - other shown', function() {
		var collectionIndex,
			WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 0;
		WikiaRemixInstance.collections = [
			{shown: false},
			{shown: true},
			{shown: false}
		];

		collectionIndex = WikiaRemixInstance.getNextCollectionIndex();
		expect(collectionIndex).toBe(0);
		WikiaRemixInstance.markCollectionAsShown(collectionIndex);

		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);

		collectionIndex = WikiaRemixInstance.getNextCollectionIndex();
		expect(collectionIndex).toBe(2);
		WikiaRemixInstance.markCollectionAsShown(collectionIndex);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
	});

	it('remixing - all shown', function() {
		var WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 0;
		WikiaRemixInstance.collections = [
			{shown: true},
			{shown: true},
			{shown: true}
		];

		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
	});

	it('remixing - no collections', function() {
		var WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 0;
		WikiaRemixInstance.shownCollectionsIndexes = [];

		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
	});

	it('remixing - counter increased', function() {
		var collectionIndex,
			WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 2;
		WikiaRemixInstance.collections = [
			{shown: false},
			{shown: false},
			{shown: false}
		];

		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		collectionIndex = WikiaRemixInstance.getNextCollectionIndex();
		expect(collectionIndex).toBe(0);
		WikiaRemixInstance.markCollectionAsShown(collectionIndex);

		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);

		collectionIndex = WikiaRemixInstance.getNextCollectionIndex();
		expect(collectionIndex).toBe(1);
		WikiaRemixInstance.markCollectionAsShown(collectionIndex);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
	});

	it('remixing - counter increased one shown', function() {
		var collectionIndex,
			WikiaRemixInstance = new WikiaHomePageRemix();

		WikiaRemixInstance.remixCount = 2;
		WikiaRemixInstance.collections = [
			{shown: true},
			{shown: false},
			{shown: false}
		];

		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		collectionIndex = WikiaRemixInstance.getNextCollectionIndex();
		expect(collectionIndex).toBe(1);
		WikiaRemixInstance.markCollectionAsShown(collectionIndex);

		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);

		collectionIndex = WikiaRemixInstance.getNextCollectionIndex();
		expect(collectionIndex).toBe(2);
		WikiaRemixInstance.markCollectionAsShown(collectionIndex);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
		expect(WikiaRemixInstance.getNextCollectionIndex()).toBe(undefined);
	});
});

