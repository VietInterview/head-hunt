/*!
 * JobBoard's Gruntfile
 * https://minimalthemes.net/
 */
/* jshint node:true */
module.exports = function (grunt) {

	'use strict';

	// Project configuration.
	grunt.initConfig({

		pkg: grunt.file.readJSON( 'package.json' ),

		// Check textdomain errors.
		checktextdomain: {
			options:{
				text_domain: 'jobboard',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src:  [
					'**/*.php', // Include all files
					'!node_modules/**' // Exclude node_modules/
				],
				expand: true
			}
		},

		makepot: {
			theme: {
				options: {
					cwd: '',
					potFilename: 'jobboard.pot',
					domainPath: '/languages',
					type: 'wp-theme',
					exclude: [ 'node_modules/.*', 'dist/.*'],
					processPot: function( pot ) {
						pot.headers['project-id-version'];
						pot.headers['report-msgid-bugs-to'] = 'http://minimalthemes.net/contact';
						pot.headers['plural-forms'] = 'nplurals=2; plural=n != 1;';
						pot.headers['last-translator'] = 'LANGUAGE <EMAIL@ADDRESS>\n';
						pot.headers['language-team'] = 'LANGUAGE <EMAIL@ADDRESS>\n';
						pot.headers['x-poedit-basepath'] = '..\n';
						pot.headers['x-poedit-language'] = 'English\n';
						pot.headers['x-poedit-country'] = 'UNITED STATES\n';
						pot.headers['x-poedit-sourcecharset'] = 'utf-8\n';
						pot.headers['x-poedit-searchpath-0'] = '.\n';
						pot.headers['x-poedit-keywordslist'] = '__;_e;__ngettext:1,2;_n:1,2;__ngettext_noop:1,2;_n_noop:1,2;_c;_nc:4c,1,2;_x:1,2c;_ex:1,2c;_nx:4c,1,2;_nx_noop:4c,1,2;\n';
						pot.headers['x-textdomain-support'] = 'yes\n';
						return pot;
					}
				}
			}
		},

		postcss: {
			options: {
				processors: [
					require( 'autoprefixer-core' )({
						browsers: ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1', 'ie 9']
					})
				]
			},
			main: {
				src: 'style.css',
				dest: 'style.css'
			}
		},

		csscomb: {
	        style: {
				options: {
					config: 'csscomb.json'
				},
	            files: {
	                'style.css': ['style.css'],
	                'style-responsive.css': ['style-responsive.css']
	            }
	        }
		},

		// JavaScript linting with JSHint.
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'assets/js/theme-script.js'
			]
		},

		// Clean up dist directory
		clean: {
			main: ['dist/<%= pkg.name %>']
		},

		// Copy the theme into the dist directory
		copy: {
			main: {
				src:  [
					'**',
					'!csscomb.json',
					'!node_modules/**',
					'!.sass-cache/**',
					'!sass/**',
					'!dist/**',
					'!.git/**',
					'!Gruntfile.js',
					'!package.json',
					'!.gitignore',
					'!.gitmodules',
					'!**/Gruntfile.js',
					'!**/package.json',
					'!**/*~'
				],
				dest: 'dist/<%= pkg.name %>/'
			}
		},

		// Compress build directory into <name>.zip and <name>.<version>.zip
		compress: {
			main: {
				options: {
					mode: 'zip',
					archive: './dist/<%= pkg.name %>.v<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'dist/<%= pkg.name %>/',
				src: ['**/*'],
				dest: '<%= pkg.name %>/'
			}
		}

	});

	grunt.loadNpmTasks( 'grunt-postcss' );
	grunt.loadNpmTasks( 'grunt-checktextdomain' );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-csscomb' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );

	grunt.registerTask( 'css', ['postcss', 'csscomb']);
  grunt.registerTask( 'translate', ['checktextdomain', 'makepot'] );

};
