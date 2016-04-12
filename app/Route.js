var router = new Grapnel({ pushState : true });

router.get('projects/:id?', function(req){
    var id = req.params.id;
    ko.applyBindings(ProjectViewModel(id), document.getElementById('project'));
});

router.get('start', function(req){
	ko.applyBindings(StartViewModel(), document.getElementById('main'));
});