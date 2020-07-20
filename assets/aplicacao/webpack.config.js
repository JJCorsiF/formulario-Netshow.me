const path = require('path');

module.exports = {
	entry: {
		main: './src/js/index.js',
	},
	output: {
		filename: 'main.js',
		path: path.resolve(__dirname, 'dist'),
	},
	mode: 'development',
	module: {
		rules: [
			{
				test: /\.css$/i,
				use: [
					{
						loader: 'style-loader',
						options: {
							esModule: true,
						},
					},
					{
						loader: 'css-loader',
						options: {
							modules: true,
						},
					},
					{ loader: 'sass-loader' },
				],
			},
			{
				test: /\.(js|jsx)$/i,
				use: 'babel-loader',
			},
			{ test: /\.ts$/i, use: 'ts-loader' },
			{ test: /\.txt$/i, use: 'raw-loader' },
		],
	},
	resolve: {
		alias: {
			'./vue.js': path.resolve(__dirname, './node_modules/vue/dist/vue.esm.browser.min.js'),
		},
		modules: ['node_modules'],
	},
};
