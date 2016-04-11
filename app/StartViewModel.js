function StartViewModel() {
	var self = this;
	self.projects = ko.observableArray();
	self.tags = ko.observableArray();
	self.selectedTags = ko.observableArray();
	self.columnHeight = ko.observable();
	
	var tagList = {};
	
	self.selectedProjects = ko.computed(function() {
        if(!self.selectedTags() || self.selectedTags().length == 0) {
        	self.columnHeight(0);
        	self.projects().forEach(function(val) { self.columnHeight(self.columnHeight() + val.displayHeight);});
            return self.projects(); 
        } else {
        	self.columnHeight(0);
            return ko.utils.arrayFilter(self.projects(), function(project) {
            	var show;
            	project.tags.forEach(function(val) {
            		if (self.selectedTags().indexOf(val) !== -1)
            			show = true;
            	})
            	if (show) self.columnHeight(self.columnHeight() + project.displayHeight);
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
			var obj = [];
			for(var i = 0; i < data.length; i++) {
				var rec = data[i];
				var projectTags = [];
				for(var j = 0; j < rec.project_tag.length; j++) {
					projectTags.push(tagList[rec.project_tag[j]])
				}
				var displayHeight = 39 + 24 * (Math.ceil(projectTags.length / 4));
				var project = new Project(rec.id, rec.acf.display_name, projectTags, rec.acf.feature_image.url, null, displayHeight);
				obj.push(project);
			}
			self.projects(obj);
		});
	};

	self.showFeaturedImage = function(project) {
		if(project.featureMedia != null) {
			project.showImage(true);
		}
	};
	self.hideFeaturedImage = function(project) {
		project.showImage(false);
	};


	self.getTags();
	self.getProjects();
};

function IntroViewModel() {
	var self = this;
	self.introText = ko.observable();

	self.getPage = function() {
		jQuery.get('http://astr.nsur.org/wp-json/wp/v2/pages/164', null, function(data) {
			self.introText(data.content.rendered);
		});
	};
	
	self.getPage();

};

function AboutViewModel() {
	var self = this;
	self.aboutText = ko.observable();
	self.aboutTitle = ko.observable();

	self.getPage = function() {
		jQuery.get('http://astr.nsur.org/wp-json/wp/v2/pages/167', null, function(data) {
			self.aboutText(data.content.rendered);
			self.aboutTitle(data.title.rendered);
		});
	};
	
	self.getPage();

};