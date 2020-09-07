import { filter } from 'rxjs/operators';

export function ofType(...types) {
	return (source) => {
		return source.pipe(filter((action) => types.some((type) => action.type === type)));
	};
}
