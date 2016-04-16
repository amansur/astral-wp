var router = Router({
	'/project': {
		'/:slug': { on: showProject },
	},
	'/home': {
		'/:anchor': { on: showHome }
	},
	'/home': showHome
});

router.configure();
router.init();