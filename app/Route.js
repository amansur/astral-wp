var router = Router({
	'/project': {
		'/:slug': {
			on: function (slug) {
				RouteProject(slug)
			}
		},
	},
	'/home': function () {
		RouteHome();
	}
	,
	'/home/:anchor': function (anchor) {
			RouteHome(anchor);
	}
});