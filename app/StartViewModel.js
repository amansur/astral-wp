function StartViewModel() {
	var tagList = {};
	var self = this;
	self.columnHeight = ko.observable();
	self.projects = ko.observableArray();
	self.tags = ko.observableArray();
	self.selectedTags = ko.observableArray();
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
		jQuery.get('http://astr.nsur.org/wp-json/wp/v2/project', null, function(data) {
			var obj = [];
			for(var i = 0; i < data.length; i++) {
				var rec = data[i];
				var projectTags = [];
				for(var j = 0; j < rec.project_tag.length; j++) {
					projectTags.push(tagList[rec.project_tag[j]])
				}
				var displayHeight = 39 + 24 * (Math.ceil(projectTags.length / 6));
				var project = new Project(rec.id, rec.acf.display_name, projectTags, rec.acf.feature_image, null, displayHeight);
				obj.push(project);
			}
			self.projects(obj);
		});
	};

	self.showFeaturedImage = function(project, event) {
		if (project.featureMedia != null && project.featureMedia != 0) {
			self.getImage(project.featureMedia);
			project.featureMediaUrl(self.visibleImageUrl());
			setTimeout(function() { project.showImage(true)}, 100);
		}
		jQuery('.projectImage').css('position', 'absolute').css('top', event.pageY + 40).css('left', event.pageX);
	};
	self.hideFeaturedImage = function(project) {
		project.showImage(false);
		self.visibleImageUrl(null);
	};


	self.getTags();
	setTimeout(self.getProjects, 500);

	self.introText = ko.observable();

	// self.getIntro = function() {
	// 	jQuery.get('http://astr.nsur.org/wp-json/wp/v2/pages/164', null, function(data) {
	// 		self.introText(data.content.rendered);
	// 	});
	// };
	
	// self.getIntro();

	self.footer = ko.observableArray();

	// self.getAbout = function() {
	// 	jQuery.get('http://astr.nsur.org/wp-json/wp/v2/pages/167', null, function(data) {
	// 		self.aboutText(data.content.rendered);
	// 		self.aboutTitle(data.title.rendered);
	// 	});
	// };
	
	// self.getAbout();

	self.getConfig = function() {
		jQuery.get('http://astr.nsur.org/wp-json/wp/v2/config/174', null, function(data) { //174 astr 173 local
			self.introText(data.acf.heading);
			data.acf.footer.forEach(function(column) {
				var _column = [];
				column.column.forEach(function(item) {
					var _item = {heading: item.heading, content: item.content};
					_column.push(_item);
				});
				self.footer.push(_column);
			});
		});
	};

	self.visibleImageUrl = ko.observable();
	self.getImage = function(id) {
		jQuery.get('/wp-json/wp/v2/media/'+id, null, function(data) {
			self.visibleImageUrl(data.media_details.sizes.thumbnail.source_url);
		});
	};

	self.getConfig();
};
var foo;