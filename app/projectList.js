var app = angular.module('listProject', ['ui.router']);

app.controller('ListCtrl', [
	'$scope',
	'projects',
	function($scope, projects) {
		$scope.projects = projects.projects;
	}]);

app.factory('projects', ['$http', function($http) {
	var o = {
		projects: []
	};

	o.getAll = function() {
		return $http.get('/wp-json/wp/v2/project').success(function(data) {
			angular.copy(data, o.projects);
		});
	};

	o.get = function(id) {
		return $http.get('/wp-json/wp/v2/project/' + id).then(function(res) {
			return res.data;
		});
	};

	return o;
}]);

app.config([
'$stateProvider',
'$urlRouterProvider',
function($stateProvider, $urlRouterProvider) {
	$stateProvider
		.state('home', {
			url: '/home',
			templateUrl: '/home.html',
			controller: 'ListCtrl',
			resolve: {
				postPromise: ['projects', function(projects) {
					return projects.getAll();
				}]
			}
		});
	// $stateProvider
	// 	.state('projects', {
	// 		url: '/projects/{id}',
	// 		templateUrl: '/projects.html',
	// 		controller: 'PostsCtrl',
	// 		resolve: {
	// 			post: ['$stateParams', 'projects', function($stateParams, projects) {
	// 				return projects.get($stateParams.id);
	// 			}]
	// 		}
	// 	});

	$urlRouterProvider.otherwise('home');
	}]);


