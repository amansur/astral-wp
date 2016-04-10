var foo;
function ProjectListViewModel() {
	var self = this;
	self.projects = ko.observableArray();
	self.tags = ko.observableArray();
	self.selectedTags = ko.observableArray();
	var tagList = {};
	
	self.selectedProjects = ko.computed(function() {
        if(!self.selectedTags() || self.selectedTags().length == 0) {
            return self.projects(); 
        } else {
            return ko.utils.arrayFilter(self.projects(), function(project) {
            	var show;
            	project.tags.forEach(function(val) {
            		if (self.selectedTags().indexOf(val) !== -1)
            			show = true;
            	})
                return show;
            });
        }
    });

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

	self.getProjects = function() {
		jQuery.get('/wp-json/wp/v2/project', null, function(data) {
			foo = data;
			var obj = [];
			for(var i = 0; i < data.length; i++) {
				var rec = data[i];
				var projectTags = [];
				for(var j = 0; j < rec.project_tag.length; j++) {
					projectTags.push(tagList[rec.project_tag[j]])
				}
				var project = new Project(rec.id, rec.acf.display_name, projectTags, rec.acf.feature_image.url, null);
				obj.push(project);
			}
			self.projects(obj);
		});
	};

	self.showFeaturedImage = function(project) {
		project.showImage(true);
	};
	self.hideFeaturedImage = function(project) {
		project.showImage(false);
	};


	self.getTags();
	self.getProjects();
};