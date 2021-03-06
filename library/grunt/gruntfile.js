module.exports = function(grunt) {

	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),

		// chech our JS
		jshint: {
			options: {
				"bitwise": true,
				"browser": true,
				"curly": true,
				"eqeqeq": true,
				"eqnull": true,
				"esnext": true,
				"immed": true,
				"jquery": true,
				"latedef": true,
				"newcap": true,
				"noarg": true,
				"node": true,
				"strict": false,
				"trailing": true,
				"undef": true,
				"globals": {
					"jQuery": true,
					"alert": true
				}
			},
			all: [
				'gruntfile.js',
				'../js/script.js'
			]
		},

		// concat and minify our JS
		uglify: {
			options: {
				beautify: true,
			},
			dist: {
				files: {
					'../js/scripts.min.js': [
						'../js/scripts.js'
					],
					'../../app/app.min.js': [
						'../../app/app.js',
						'../../app/functions.js',
						'../../app/Model.Project.js',
						'../../app/Model.Tag.js',
						'../../app/Model.Media.js',
						'../../app/TagListViewModel.js',
						'../../app/ProjectListViewModel.js',
						'../../app/ProjectViewModel.js',
						'../../app/AppViewModel.js',
						'../../app/Route.js'
					]
				}
			}
		},

		// compile your sass
		sass: {
			dev: {
				options: {
					style: 'expanded'
				},
				files: {
					'../css/style.css': '../scss/style.scss',
					'../css/ie.css': '../scss/ie.scss',
					'../css/login.css': '../scss/login.scss',
					'../css/admin.css': '../scss/admin.scss',
					'../css/app.css': '../scss/app.scss'
				}
			},
			prod: {
				options: {
					style: 'compressed'
				},
				files: {
					'../css/style.css': '../scss/style.scss',
					'../css/ie.css': '../scss/ie.scss',
					'../css/login.css': '../scss/login.scss',
					'../css/admin.css': '../scss/admin.scss',
					'../css/app.css': '../scss/app.scss'
				}
			}
		},

		// watch for changes
		watch: {
			grunt: {
				files: ['gruntfile.js'],
			},
			scss: {
				files: ['../scss/**/*.scss'],
				tasks: [
					'sass:dev',
					'notify:scss'
				],
				options: {
					livereload: true
				}
			},
			js: {
				files: [
					'<%= jshint.all %>',
					'../../app/AppViewModel.js',
					'../../app/ProjectViewModel.js',
					'../../app/ProjectListViewModel.js',
					'../../app/TagListViewModel.js',
					'../../app/Model.Media.js',
					'../../app/Model.Project.js',
					'../../app/Model.Tag.js',
					'../../app/app.js',
					'../../app/Route.js',
					'../../app/functions.js'
				],
				tasks: [
					'jshint',
					'uglify',
					'notify:js'
				],
				options: {
					livereload: true
				}
			}
		},

		// check your php
		phpcs: {
			application: {
				dir: '../*.php'
			},
			options: {
				bin: '/usr/bin/phpcs'
			}
		},

		// notify cross-OS
		notify: {
			scss: {
				options: {
					title: 'Grunt, grunt!',
					message: 'SCSS is all gravy'
				}
			},
			js: {
				options: {
					title: 'Grunt, grunt!',
					message: 'JS is all good'
				}
			},
			dist: {
				options: {
					title: 'Grunt, grunt!',
					message: 'Theme ready for production'
				}
			}
		},

		clean: {
			dist: {
				src: ['../dist'],
				options: {
					force: true
				}
			}
		},

		copyto: {
			dist: {
				files: [
					{cwd: '../', src: ['**/*'], dest: '../dist/'}
				],
				options: {
					ignore: [
						'../dist{,/**/*}',
						'../doc{,/**/*}',
						'../grunt{,/**/*}',
						'../scss{,/**/*}'
					]
				}
			}
		}
	});

	// Load NPM's via matchdep
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	// Development task
	grunt.registerTask('default', [
		'jshint',
		'uglify',
		'sass:dev'
	]);

	// Production task
	grunt.registerTask('dist', function() {
		grunt.task.run([
			'jshint',
			'uglify',
			'sass:prod',
			'clean:dist',
			'copyto:dist',
			'notify:dist'
		]);
	});
};
