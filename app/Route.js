var router = Router({
	'/project': {
		'/:slug': {
			on: function (slug) {
				RouteProject(slug)
			}
		},
	},
	'/home': {
		'/:anchor': {
			on: function (anchor) {
				RouteHomeToAnchor(anchor);
			}
		}
	},
	'/home': function () {
			RouteHome();
		}
	});

router.configure();
router.init();