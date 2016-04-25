define('VisualEditorTourExperimentConfig', [], function () {
	'use strict';

	return [
		{
			selector: '#WikiaArticle',
			placement: 'top',
			title: 'Write content',
			description: 'Share your knowledge with the Community! This space is yours: write, fix typos, ' +
			'add links. Make this article better with each edit!'
		},
		{
			selector: '.oo-ui-icon-link',
			placement: 'bottom',
			title: 'Add links',
			description: 'Highlight a text you want to add link to. You can now write the name of the wiki page ' +
			'you want the link to point at. Remember that you can always remove a link, by clicking on ‘remove the ' +
			'link’ button after highlighting the text.'
		},
		{
			selector: '.oo-ui-icon-video',
			placement: 'right',
			title: 'Add Video',
			description: 'Upload videos to a specified place in the article. Search for a video already present on ' +
			'this Wiki or provide an URL from such sources as YouTube, Vimeo or Dailymotion.'
		},
		{
			selector: '.oo-ui-icon-image',
			placement: 'right',
			title: 'Add Image',
			description: 'Upload pictures to a specified place in the article. You will be able to change the size ' +
			'of the element later.'
		},
		{
			selector: '.oo-ui-icon-gallery',
			placement: 'right',
			title: 'Add Gallery',
			description: 'Choose from the photos uploaded to this Wiki and create a gallery.'
		},
		{
			selector: '.oo-ui-icon-bullet-list',
			placement: 'right',
			title: 'Bullet list and Numbered list',
			description: 'Organize your text into neat lists. You can highlight a few paragraphs and insert a list ' +
			'of your choice or simply insert a list and start typing. If you want to turn a list into a regular text' +
			', just unclick the selected list.'
		},
		{
			selector: '.oo-ui-labelElement.oo-ui-listToolGroup',
			placement: 'bottom',
			title: 'Add extra content',
			description: 'Click ‘Insert’ to choose from a number of extra elements: Infobox, Template, Reference, ' +
			'Reference List and Table.'
		},
		{
			selector: '.ve-ui-toolbar-saveButton',
			placement: 'bottom',
			title: 'Publish your edit',
			description: 'After you’ve made your edit, save the changed article by clicking on ‘Save page’. Now you ' +
			'can add a description of your changes for other users to read, but you don’t have to do that. Click ' +
			'‘save’ and go ahead, make another page on this Wiki better!'
		}
	];
});
