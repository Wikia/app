/* eslint no-console:0 */
'use strict';

const fs = require('fs-extra');
const glob = require('glob');
const path = require('path');

module.exports = {
	name: 'post-build-copy',

	postBuild: function (results) {
		const config = this.app.options.postBuildCopy;

		config.forEach(({enabled, src, dest}) => {			
			if (enabled === false) {
				return;
			}

			src = glob.sync(results.directory + src);

			if (src.length === 0) {
				console.warn('post-build-copy: No files found for glob ' + results.directory + src);
			}

			src.forEach(function (file) {
				/**
				 * Support destination in two forms:
				 * - `/dir/` for multiple files
				 * - `/dir/filename` for single files
 				 */
				const destIsDir = dest.slice(-1) === '/';
				const dir = destIsDir ? dest : path.parse(dest).dir;
				const fileName = destIsDir ? path.parse(file).base : path.parse(dest).base;
				const fullSrc = path.resolve(file);
				const fullDest = path.resolve(dir + '/' + fileName);

				try {
					fs.copySync(fullSrc, fullDest, {dereference: true});
				} catch (e) {
					console.error('post-build-copy: Could not copy from ' + fullSrc + ' to ' + fullDest);
				}
			});
			
		});
	},

	isDevelopingAddon: function () {
		return true;
	}
};
