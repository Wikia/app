import Annotation from './Annotations';
import Comment from './Comments';
import AnnotationStream from './AnnotationStream';

export default function wikiaJWPlayerAnnotation(playerInstance, { annotations, comments, spoilers }) {
	console.log('#######', '', annotations, comments); 
	new AnnotationStream(playerInstance, { amount: 3 })
		.add(annotations.map((el) => new Annotation({ item: el, playerInstance })))
		.add(comments.map((el) => new Comment({ item: el, playerInstance })));
}
