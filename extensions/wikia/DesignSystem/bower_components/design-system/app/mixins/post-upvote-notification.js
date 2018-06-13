import Mixin from '@ember/object/mixin';

export default Mixin.create({
	/**
	 * Constructs a localized post upvote notification body
	 * @param {Ember.Object} model
	 * @returns {string}
	 */
	getPostUpvoteMessageBody(model) {
		const hasTitle = model.get('title'),
			totalUniqueActors = model.get('totalUniqueActors'),
			hasMultipleUsers = totalUniqueActors > 1;

		if (hasTitle) {
			if (hasMultipleUsers) {
				return this.getTranslatedMessage('notifications-post-upvote-multiple-users-with-title', {
					postTitle: this.get('postTitleMarkup'),
					number: totalUniqueActors
				});
			} else {
				return this.getTranslatedMessage('notifications-post-upvote-single-user-with-title', {
					postTitle: this.get('postTitleMarkup'),
				});
			}
		} else if (hasMultipleUsers) {
			return this.getTranslatedMessage('notifications-post-upvote-multiple-users-no-title', {
				number: totalUniqueActors
			});
		} else {
			return this.getTranslatedMessage('notifications-post-upvote-single-user-no-title');
		}
	}
});
