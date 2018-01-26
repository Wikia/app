import Annotation from './Annotations';
import Comment from './Comments';
import AnnotationStream from './AnnotationStream';

const commentMock = [
	{
		text: 'My 1st comment',
		createdBy: { username: "Ciastek", avatarUrl: 'https://www.shareicon.net/data/2016/08/05/806962_user_512x512.png'},
		displayAt: 2
	},
	{
		text: 'My 2nd comment',
		createdBy: { username: "Krzyś", avatarUrl: 'https://www.shareicon.net/data/2016/08/05/806962_user_512x512.png'},
		displayAt: 4
	},
	{
		text: 'My 3rd comment',
		createdBy: { username: "Krzyś", avatarUrl: 'https://www.shareicon.net/data/2016/08/05/806962_user_512x512.png'},
		displayAt: 8
	}
];

const annotationMock = [
	{
		text: 'My 1st annotation',
		createdBy: { username: "Barti", avatarUrl: 'https://www.shareicon.net/data/2016/08/05/806962_user_512x512.png'},
		linksTo: 'https://www.shareicon.net/data/2016/08/05/806962_user_512x512.png',
		displayAt: 1
	},
	{
		text: 'My 2nd annotation',
		createdBy: { username: "Ciastek", avatarUrl: 'https://www.shareicon.net/data/2016/08/05/806962_user_512x512.png'},
		linksTo: 'https://www.shareicon.net/data/2016/08/05/806962_user_512x512.png',
		displayAt: 3
	},
	{
		text: 'My 3rd annotation',
		createdBy: { username: "Ciastek", avatarUrl: 'https://www.shareicon.net/data/2016/08/05/806962_user_512x512.png'},
		linksTo: 'https://www.shareicon.net/data/2016/08/05/806962_user_512x512.png',
		displayAt: 7.5
	}
];


export default function wikiaJWPlayerAnnotation(playerInstance, options = {}) {
	new AnnotationStream(playerInstance, { amount: 3 })
		.add(annotationMock.map((el) => new Annotation({ item: el, playerInstance })))
		.add(commentMock.map((el) => new Comment({ item: el, playerInstance })));
}
