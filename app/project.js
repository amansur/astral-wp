function ProjectListViewModel() {
	var self = this;
	self.projects = ko.observable();
	self.tags = ko.observable();
	var tagList = {};
	
	self.getTags = function() {
		jQuery.get('/wp-json/wp/v2/project_tag', null, function(data) {
			var obj = [];
			for(var i = 0; i < data.length; i++) {
				var rec = data[i];
				var tag = new Tag(rec.id, rec.name);
				obj.push(tag);
				tagList[rec.id] = tag;
			}
			self.tags(obj);
		});
	};

	self.getProjects = function(tags) {
		jQuery.get('/wp-json/wp/v2/project', null, function(data) {
			var obj = [];
			for(var i = 0; i < data.length; i++) {
				var rec = data[i];
				var projectTags = [];
				for(var j = 0; j < rec.project_tag.length; j++) {
					projectTags.push(tagList[rec.project_tag[j]])
				}
				var project = new Project(rec.id, rec.acf.display_name, projectTags, rec.acf.feature_image.url);
				obj.push(project);
			}
			self.projects(obj);
		});
	}

	self.getTags();
	self.getProjects(self.tags());
};


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

