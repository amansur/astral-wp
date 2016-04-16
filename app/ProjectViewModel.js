function ProjectViewModel() {
	var self 	= this;
	self.slug 	= ko.observable();
	self.project = ko.observable();
	self.getProject = ko.computed(function() {
		if (self.slug() === undefined || self.slug() === null || self.slug() === "")	{		
			self.project(new Project());
			return false;
		}

		jQuery.get('/wp-json/wp/v2/project/?slug=' + self.slug(), null, function(data) {
			data = data[0]; // retrieving by slug returns array
			var _projectTags = jQuery.map(data.project_tag, function(tag) { 
				return tagList[tag]; 
			});
			var _media = jQuery.map(data.acf.media, function(media) {  
				if (media.acf_fc_layout == "picture") {
					var _image;
					jQuery.ajax({
						url:'/wp-json/wp/v2/media/'+media.image, 
						success: function(data) {
							_image = data.media_details.sizes.full.source_url;
						},
						async: false});

					return new Media(_image, media.image_description, media.acf_fc_layout);
				}
				if (media.acf_fc_layout == "video") {
					return new Media(media.video_url, media.video_description, media.acf_fc_layout);
				}
			});
			var _project = new Project(data.id, data.slug, data.acf.display_name, data.acf.description, _projectTags, null, _media);
			self.project(_project);
		});
	});
};