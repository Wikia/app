import Annotation from './Annotations';
import Comment from './Comments';
import Spoiler from './Spoilers';
import AnnotationStream from './AnnotationStream';

const spoilerList = [
	{
		content: 'Next scene contain spoilers about 4th season of Game of Thrones',
		displayAt: 25,
		moveTo: 50
	}
];

const annotationList = [
	{
		content: 'To read more about Darth Vader click here',
		displayAt: 10,
		linksTo: 'http://starwars.wikia.com/wiki/Anakin_Skywalker'
	}
];

export default function wikiaJWPlayerAnnotation(playerInstance, { annotations, comments, spoilers }) {
	console.group("DATA PASSED TO PLUGIN");
	console.log('#######', 'annotations', annotations);
	console.log('#######', 'comments', comments);
	console.log('#######', 'spoilers', spoilers);
	console.groupEnd();

	new AnnotationStream(playerInstance, { amount: 3 })
		.add(annotationList.map((el) => new Annotation({ item: el, playerInstance })))
		.add(comments.map((el) => new Comment({ item: el, playerInstance })))
		.add(spoilerList.map((el) => new Spoiler({ item: el, playerInstance })));
}
