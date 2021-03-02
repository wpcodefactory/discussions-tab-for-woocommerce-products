var path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

// change these variables to fit your project
const outputPath = './assets';
const entryPoints = {
	admin: ['./src/js/admin.js', './src/scss/admin.scss'],
	frontend: ['./src/js/frontend.js','./src/scss/frontend.scss']
};

// Rules
const rules = [
	{
		test: /\.scss$/i,
		use: [
			MiniCssExtractPlugin.loader,
			'css-loader',
			'postcss-loader',
			'sass-loader',
		]
	},
	{
		test: /\.(jpg|jpeg|png|gif|woff|woff2|eot|ttf|svg)$/i,
		use: 'url-loader?limit=1024'
	},
	{
		exclude: /node_modules/,
		test: /\.jsx?$/,
		loader: 'babel-loader',
		options: {
			presets: ["@babel/preset-env"]
		}
	}
];

// Development
const devConfig = {
	entry: entryPoints,
	output: {
		path: path.resolve(__dirname, outputPath),
		filename: 'js/[name].js',
		chunkFilename: 'js/modules/dev/[name].js',
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: 'css/[name].css',
		}),

		// Uncomment this if you want to use CSS Live reload
		/*new BrowserSyncPlugin({
			port:81,
			proxy: 'http://localhost',
			files: [outputPath + '/*.css'],
			injectCss: true,
		}, {reload: false,}),*/

	],
	module: {
		rules: rules
	},
	devtool: 'source-map',

};

// Production
const prodConfig = {
	entry: entryPoints,
	output: {
		path: path.resolve(__dirname, outputPath),
		filename: 'js/[name].min.js',
		chunkFilename: 'js/modules/[name].js',
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: 'css/[name].min.css',
		}),
	],
	module: {
		rules: rules
	},

};

// Exports
module.exports = (env, argv) => {
	switch (argv.mode) {
		case 'production':
			return prodConfig;
		default:
			return devConfig;
	}
}