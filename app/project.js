function ProjectListViewModel() {
	var self = this;
	var tags = [new Tag("print"), new Tag("identity")];
	self.projects = ko.observableArray();

	// [new Project("Project 1", tags),
	// new Project("Project 2", tags),
	// new Project("Project 3", tags)]

	self.getProjects = function() {
		$.get('/wp-json/wp/v2/project', null, self.projects);
	}

	self.getProjects();
}

function Project(name, tags) {
	var self = this;
	self.name = name;
	self.tags = tags;
}

function Tag(name) {
	var self = this;
	self.name = name;
}

ko.applyBindings(ProjectListViewModel());