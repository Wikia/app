module.exports = {
	root: true,
	parserOptions: {
		ecmaVersion: 2017,
		sourceType: 'module'
	},
	plugins: [
		'ember'
	],
	extends: [
		'eslint:recommended',
		'plugin:ember/recommended'
	],
	env: {
		browser: true
	},
	rules: {
	},
	globals: {
		server: true,
		FastBoot: true,
		hljs: false
	},
	overrides: [
		// node files
		{
			files: [
				'index.js',
				'ember-cli-build.js',
				'testem.js',
				'config/**/*.js',
				'lib/*/index.js',
				'tests/dummy/config/**/*.js'
			],
			excludedFiles: [
				'app/**',
				'addon/**',
				'tests/dummy/app/**'
			],
			env: {
				browser: false,
				node: true
			},
			plugins: ['node'],
			rules: Object.assign({}, require('eslint-plugin-node').configs.recommended.rules, {
				// add your custom rules and overrides for node files here
			})
		}
	]
};
