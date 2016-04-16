function Project(id, slug, name, description, tags, featureMedia, media) {
	var self = this;
	self.id = id;
	self.slug = slug,
	self.name = name;
	self.description = description;
	self.tags = tags;
	self.featureMedia = featureMedia;
	self.featureMediaUrl = ko.observable();
	self.media = media;
};