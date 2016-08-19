define('VisualEditorTourExperimentConfig', [], function () {
	'use strict';

	return {
		'en': [
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
		],
		'ja': [
			{
				selector: '#WikiaArticle',
				placement: 'top',
				title: 'コンテンツを作成',
				description: 'あなたの知識をコミュニティと共有しよう！新しい書き込みや修正、リンクの追加など、どんどん編集して記事を盛り' +
				'上げましょう！'
			},
			{
				selector: '.oo-ui-icon-link',
				placement: 'bottom',
				title: 'リンクを追加',
				description: 'リンクを追加したいテキストをハイライトしてください。リンク先にしたいWikiページの名前を直接入力できるように' +
				'なりました。テキストをハイライトした後でも、[リンクを削除]ボタンをクリックすればいつでも変更することができます！'
			},
			{
				selector: '.oo-ui-icon-video',
				placement: 'right',
				title: '動画を追加',
				description: '記事内の特定箇所に動画をアップロードしましょう。現在のWikiページにすでに存在する動画を検索、もしくは' +
				'YouTube、Vimeo、DailymotionなどからURLを指定してください。'
			},
			{
				selector: '.oo-ui-icon-image',
				placement: 'right',
				title: '画像を追加',
				description: '記事内の特定箇所に画像をアップロードしましょう。画像サイズは後から変更できます。'
			},
			{
				selector: '.oo-ui-icon-gallery',
				placement: 'right',
				title: 'ギャラリーを追加',
				description: '現在のWikiページにアップロードされた画像から選択してギャラリーを作成しましょう。'
			},
			{
				selector: '.oo-ui-icon-bullet-list',
				placement: 'right',
				title: '箇条書きリストおよび番号付きリスト',
				description: '追加したテキストをリストに整理しましょう。文章をいくつかハイライトしてお好きなリストを挿入、もしくはリスト' +
				'をそのまま挿入して入力を開始してください。リストを通常のテキストに変換したい場合は、選択済みリストをアンクリックしましょう。'
			},
			{
				selector: '.oo-ui-labelElement.oo-ui-listToolGroup',
				placement: 'bottom',
				title: 'さらにコンテンツを追加',
				description: '[挿入]をクリックしてインフォボックス、テンプレート、レファレンス、レファレンスリスト、テーブルなど、追加の' +
				'要素を選択しましょう。'
			},
			{
				selector: '.ve-ui-toolbar-saveButton',
				placement: 'bottom',
				title: '編集内容を公開',
				description: '編集が完了しましたら、[ページを保存]をクリックして記事の変更内容を保存してください。保存した後に他の' +
				'ユーザーが参照できるよう、変更内容の説明を追加することもできますが、必須ではありません。[保存]をクリックしてそのまま他の' +
				'Wikiページをさらに充実させましょう！'
			}
		]
	};
});
