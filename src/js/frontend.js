/**
 * Discussions Tab for WooCommerce Products - Frontend JS
 *
 * @version 1.2.6
 * @since   1.2.6
 * @author  Thanks to IT
 */

// Dynamic modules
__webpack_public_path__ = alg_dtwp.plugin_url + "/assets/";
let modules = alg_dtwp.modulesToLoad;
if (modules && modules.length) {
	modules.forEach(function (module) {
		import(
			/* webpackMode: "lazy"*/
			`./modules/${module}`)
			.then(function (component) {
				component.init();
			});
	});
}

// Static modules
const staticModules = [
	'cancel-btn-fixer',
	'parent-comment-id-fixer',
	'labels-manager'
];
staticModules.forEach(function (module_name) {
	let module = require('./modules/' + module_name);
	module.init();
});