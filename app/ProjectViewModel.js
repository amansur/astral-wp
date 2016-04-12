function ProjectViewModel(id) {
	var self = this;
	self.name = ko.observable();
	self.tags = ko.observable();
	self.description = ko.observable();
	self.media = ko.observable();
	self.getProjects = function() {
		jQuery.get('/wp-json/wp/v2/project/' + id, null, function(data) {
			self.name = data.name;
			self.tags = data.project_tag;
			self.description = data.description;
			self.media = data.media;
		});
	};
};