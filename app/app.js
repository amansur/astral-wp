// pager.extendWithPage(StartViewModel);
var vm = StartViewModel();
ko.applyBindings(vm, document.getElementById('main'));
// pager.start(); var foo = 4;


// use HTML5 history
// pager.useHTML5history = true;
// // use History instead of history
// pager.Href5.history = History;
// // extend your view-model with pager.js specific data
// pager.extendWithPage(StartViewModel);
// // apply the view-model using KnockoutJS as normal
// ko.applyBindings(StartViewModel());
// // start pager.js
// // pager.start();
// pager.startHistoryJs();

jQuery('.project').on('mouseleave', function() { jQuery('.projectImage').hide();});