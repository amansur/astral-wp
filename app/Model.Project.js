function Project(id, name, tags, featureMedia, media) {
	var self = this;
	self.id = id;
	self.name = name;
	self.tags = tags;
	self.featureMedia = featureMedia;
	show.media = media;
	self.showImage = ko.observable(false);
};