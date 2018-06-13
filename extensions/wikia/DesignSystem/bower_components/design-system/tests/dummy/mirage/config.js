export default function() {

  // These comments are here to help you get started. Feel free to delete them.

	/*
	  Config (with defaults).

	  Note: these only affect routes defined *after* them!
	*/

	// this.urlPrefix = '';    // make this `http://localhost:8080`, for example, if your API is on a different server
	// this.namespace = '';    // make this `/api`, for example, if your API is namespaced
	// this.timing = 400;      // delay for each request, automatically set to 0 during testing

	/*
	  Shorthand cheatsheet:

	  this.get('/posts');
	  this.post('/posts');
	  this.get('/posts/:id');
	  this.put('/posts/:id'); // or this.patch
	  this.del('/posts/:id');

	  http://www.ember-cli-mirage.com/docs/v0.3.x/shorthands/
	*/
	this.passthrough('https://localhost/**');

	this.passthrough('/svg/**');

	this.get('https://services.wikia.com/on-site-notifications/notifications/unread-count', () => {
		return {
			"unreadCount": 1,
			"_links": { "notificationsUrl": "/notifications?startingTimestamp=2018-06-01T10:44:13.309Z" }
		};
	});

	this.get('https://services.wikia.com/on-site-notifications/notifications', () => {
		return {
			"notifications": [
				{
					"type": "replies-notification",
					"community": { "id": "1487443", "name": "Latata's Wiki" },
					"refersTo": {
						"uri": "http://pl.latata.wikia.com/d/p/2874001183423355951",
						"createdBy": "30225649",
						"type": "discussion-thread",
						"title": "test",
						"snippet": "post w mojej kategorii"
					},
					"events": {
						"total": 3,
						"totalUniqueActors": 3,
						"latestActors": [{
							"id": "26629533",
							"name": "Nikodamn",
							"avatarUrl": "https://static.wikia.nocookie.net/4053c0f6-fb5a-4295-9027-5cf1f06a2c85"
						}, {
							"id": "25126702",
							"name": "Igor Rogatty",
							"avatarUrl": "https://static.wikia.nocookie.net/d01a239e-b173-447e-8ed5-b84ed7a6563e"
						}, {
							"id": "33027931",
							"name": "Xkxd",
							"avatarUrl": "https://vignette.wikia.nocookie.net/messaging/images/1/19/Avatar.jpg"
						}],
						"latestEvent": {
							"when": "2018-06-11T10:38:55.000Z",
							"causedBy": {
								"id": "26629533",
								"name": "Nikodamn",
								"avatarUrl": "https://static.wikia.nocookie.net/4053c0f6-fb5a-4295-9027-5cf1f06a2c85"
							},
							"uri": "http://pl.latata.wikia.com/d/p/2874001183423355951/r/3088249501253655890",
							"type": "discussion-post",
							"snippet": "skont klikash"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": true
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
				{
					"type": "replies-notification",
					"community": { "id": "1", "name": "Westworld Wiki" },
					"refersTo": {
						"uri": "http://westworld.wikia.com/d/p/3120688743317564066",
						"createdBy": "3321936",
						"type": "discussion-thread",
						"title": "Title",
						"snippet": "Snippet"
					},
					"events": {
						"total": 2,
						"totalUniqueActors": 2,
						"latestActors": [{
							"id": "24851773",
							"name": "Username1",
							"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
						}, {
							"id": "129646",
							"name": "Username2",
							"avatarUrl": "https://static.wikia.nocookie.net/e597e1f9-2246-4759-9d11-6970ad64605f"
						}],
						"latestEvent": {
							"when": "2018-05-22T18:00:11.000Z",
							"causedBy": {
								"id": "24851773",
								"name": "Username1",
								"avatarUrl": "https://vignette.wikia.nocookie.net/eb7f3136-d079-4826-ab1c-160738494f3a"
							},
							"uri": "http://westworld.wikia.com/d/p/3120688743317564066/r/3132938694690485168",
							"type": "discussion-post",
							"snippet": "Snippet"
						}
					},
					"read": false
				},
			],
			"_links": {
				"next": "notifications",
			},
		}
	})
}
