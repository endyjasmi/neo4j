module.exports = function(grunt)
{
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		phpcs: {
			standard: {
				dir: ['src/**/*.php', 'tests/**/*.php'],
				options: {
					bin: 'vendor/bin/phpcs',
					standard: 'psr2'
				}
			},
			documentation: {
				dir: ['src/**/*.php', 'tests/**/*.php'],
				options: {
					bin: 'vendor/bin/phpcs',
					standard: 'pear'
				}
			}
		},

		phpunit: {
			test: {
				options: {
					bin: 'vendor/bin/phpunit'
				}
			}
		},

		watch: {
			options: {
				reload: true
			},
			
			config: {
				files: 'Gruntfile.js'
			},

			classes: {
				files: ['src/**/*.php', 'tests/**/*.php'],
				tasks: ['test']
			},
		}
	})

	grunt.loadNpmTasks('grunt-contrib-watch')
	grunt.loadNpmTasks('grunt-phpcs')
	grunt.loadNpmTasks('grunt-phpunit')

	grunt.registerTask('default', ['watch'])
	grunt.registerTask('test', ['phpunit:test', 'phpcs:standard'])
}