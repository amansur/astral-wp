<html>
<head>
	<link rel="stylesheet" href="/wp-content/themes/astral-wp/bower_components/bootstrap/dist/css/bootstrap.min.css">

	<!-- <script type="text/javascript" src="/wp-content/themes/astral-wp/bower_components/angular/angular.min.js"></script>
	<script type="text/javascript" src="/wp-content/themes/astral-wp/bower_components/angular-ui-router/release/angular-ui-router.min.js"></script> -->
	</head>
<body>

<ul data-bind="foreach: projects">
<li>
	<span data-bind="text: name"></span>
	<span data-bind="foreach: tags">
		<span data-bind="text: name"></span>
	</span>
</li>
</ul>
<script type="text/javascript" src="/wp-content/themes/astral-wp/bower_components/knockout/dist/knockout.js"></script>
<script type="text/javascript" src="/wp-content/themes/astral-wp/app/project.js"></script>

</body>
</html>