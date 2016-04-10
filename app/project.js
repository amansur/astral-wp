function ProjectListViewModel() {
	var self = this;
	

	self.getTags = function() {
		var allTags = {};
		jQuery.get('/wp-json/wp/v2/project_tag', null, function(data) {
			for(var i = 0; i < data.length; i++) {
				var rec = data[i];
				var tag = new Tag(rec.id, rec.name);
				allTags[rec.id] = tag;
				//self.tags.push(tag);
			}
		});
		return allTags;
	};

	self.getProjects = function(tags) {
		var allProjects = [];
		jQuery.get('/wp-json/wp/v2/project', null, function(data) {
			projectData = data;
			for(var i = 0; i < data.length; i++) {
				var rec = data[i];
				var projectTags = [];
				for(var j = 0; j < rec.project_tag.length; j++) {
					projectTags.push(tags[rec.project_tag[j]])
				}
				var project = new Project(rec.id, rec.acf.display_name, projectTags, rec.acf.feature_image.url);
				allProjects.push(project);
			}
		});
		return allProjects;
	};

	var allTags = self.getTags();
	var allProjects = self.getProjects(allTags);
	
	self.projects = ko.observableArray(allProjects);
	self.tags = allTags;
	
	foo = self.projects;
	bar = self.tags;
}

var foo;
var bar;

function Project(id, name, tags, featureMedia) {
	var self = this;
	self.id = id;
	self.name = name;
	self.tags = tags;
	self.featureMedia = featureMedia;
}

function Tag(id, name) {
	var self = this;
	self.id = id;
	self.name = name;
}

ko.applyBindings(ProjectListViewModel());