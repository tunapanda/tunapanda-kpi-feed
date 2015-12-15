module.exports = function(grunt) {
	grunt.loadNpmTasks('grunt-ftpuploadtask');

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		ftpUploadTask: {
			limikael_altervista_org: {
				options: {
					user: "limikael",
					password: process.env.ALTERVISTA_PASSWORD,
					host: "ftp.limikael.altervista.org",
					checksumfile: "_checksums/tunapanda-kpi-feed.json"
				},

				files: [{
					expand: true,
					dest: "tunapanda-kpi-feed",
					src: ["**","!node_modules/**"]
				}]
			},
		}
	});
}