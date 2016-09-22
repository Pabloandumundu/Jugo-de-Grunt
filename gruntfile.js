module.exports = function(grunt) {

	require('load-grunt-tasks')(grunt);

	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),

		// se leen varios parámetros a usar
		sitemapWeb: grunt.file.readJSON('_jugodegrunt/sitemapWeb.json'),
		ftpServidor: grunt.file.readJSON('_jugodegrunt/ftpServidor.json'),
		ftpPuerto: grunt.file.readJSON('_jugodegrunt/ftpPuerto.json'),
		ftpDirectorioDestino: grunt.file.readJSON('_jugodegrunt/ftpDirectorioDestino.json'),
		ftpUsuario: grunt.file.readJSON('_jugodegrunt/ftpUsuario.json'),
		ftpPassword: grunt.file.readJSON('_jugodegrunt/ftpPassword.json'),
		ftpAsubir: grunt.file.readJSON('_jugodegrunt/ftpAsubir.json'),
		dbackup: grunt.file.readJSON('_jugodegrunt/dbackup.json'),
		dropboxToken: grunt.file.readJSON('_jugodegrunt/dropboxToken.json'),
		dropboxAsubir: grunt.file.readJSON('_jugodegrunt/dropboxAsubir.json'),
		dropboxDirDest: grunt.file.readJSON('_jugodegrunt/dropboxDirDest.json'),
		ficheroComprimido: grunt.file.readJSON('_jugodegrunt/ficheroComprimido.json'),
		gitRepo: grunt.file.readJSON('_jugodegrunt/gitRepo.json'),
		gitRepoRama: grunt.file.readJSON('_jugodegrunt/gitRepoRama.json'),
		gitRepoCommit: grunt.file.read('_jugodegrunt/gitRepoCommit.txt'),


		// configuración de las diferectes acciones.
		// comprime y pasa archivos javascript a la carpeta producción:
		uglify: {
			my_target: {
				files: [{
					expand: true,
					cwd: 'de',
					src: ['**/*.js', '!**/*.min.js'], //se excluyen los posibles javascript que ya estén previamente minificados
					dest: 'pr'
				}]
			}
		},

		// comprime y pasa archivos css a la carpeta producción:
		cssmin: {
				target: {
					files: [{
						expand: true,
						cwd: 'de',
						src: ['**/*.css', '!**/*.min.css'], //se excluyen los posibles css que ya estén previamente minificados
						dest: 'pr'
					}]
				}
		},

		// comprime y pasa archivos html a la carpeta producción:
		htmlmin: {
				dist: {
						options: {
							removeComments: true,
							collapseWhitespace: true
						},
						files: [{
								expand: true,
								cwd: 'de',
								src: ['**/*.html', '!**/*.min.html'], //se excluyen los posibles html que ya estén previamente minificados
								dest: 'pr'
						}],
				}
			},

		// corazón del sistema de vigilancia que ejecutará las diferentes copias y minificaciones cuando hay archivos nuevos o se modifiquen los existentes:
		watch: {
			files: ['de/**'],
			tasks: ['newer:uglify', 'newer:cssmin', 'newer:htmlmin', 'sync:desprod']
		},

		// para subir por ftp, sube solo lo que se ha modificado o es nuevo:
		'ftp-diff-deployer': {	
    		options: {},
    			www: {
      			options: {
        			host: '<%= ftpServidor.ftpServidor %>',
        			auth: {
          				username: '<%= ftpUsuario.ftpUsuario %>',
          				password: '<%= ftpPassword.ftpPassword %>'
        			},
        		src: '<%= ftpAsubir.ftpAsubir %>',
        		dest: '<%= ftpDirectorioDestino.ftpDirectorioDestino %>',
        		exclude: ['.*']
      			}
    		}	    
 		},

 		// para crear el sitemap:
  		sitemap: {
    		dist: {
      			pattern: ['de/**/*.*'],
      			siteRoot: 'de/',
      			homepage: 'http://<%= sitemapWeb.sitemapWeb %>/',
      			changefreq: 'weekly'
    		}
  		},

  		// para comprobar links rotos:
  		linkChecker: {  			
  			options: {
    			maxConcurrency: 20, // utilizar una gran cantidad de concurrencia para acelerar la verificación
    			noFragment: true
  			},
  			dev: {
    			site: 'localhost',
    			options: {
	      			initialPort: 8002,
	      			callback: function (crawler) {
	        			crawler.addFetchCondition(function (url) {
	          			return url.port === '8002';
	    				});
	    			}
	    		}
  			}
  			// se le puede decir que siga probando links en la web:
  			//  postDeploy: {
    		// 		site: 'misitio.es'
  			// 	}
		},
		
		sync: {
			backup: { // para realizar los backups (entorno + Desarrollo), cambia solo lo modificado
				files: [{

					src: ['**', '!pr/**', '!3git-configurar.bat', '!3git-configurar(editar_unicode).bat', '!_jugodegrunt/sources/3git-configurar.bat', '!_jugodegrunt/sources/3git-configurar(editar_unicode).bat', '!_jugodegrunt/dbackup.*'], // se excluye Producción, tambien se excluye un fichero (3git...) que sino da error al tratar de copiar (porque trata de leer los archivos no solo copiar y este tiene unos caracteres especiales que hace que lo interprete, es un caso muy especial y único, la copia se hace aparte desde el batch con un xcopy), también se excluyen archivos dbackup que se modifican al ejecutar esta acción y se copian aparte para evitar mensajes recurrentes (siempre)
					dest: '<%= dbackup.dbackup %>' 
				}],
			updateAndDelete: true,
			pretend: false, 
			verbose: true
			},

			desprod: { // se utiliza tanto durante el proceso de vigilancia como en Desarrollo->Producción para copiar todo lo que no haya en Desarrollo en Producción o los archivos que se vayan modificando (siempre que previamente no hayan pasado los procesos de minificación porque ya el archivo de destino sera entonces más nuevo y no copiara, que es justo lo que tiene que hacer.)
				files: [{
      				cwd: 'de',
      				src: ['**/*.*'],
      				dest: 'pr'
				}],
				updateAndDelete: true,
				pretend: false, 
				verbose: true
			}
		},

		// TODO LO RELACIONADO CON GIT:
		gitclone: {
			clonar: {
				options: {
					repository: '<%= gitRepo.gitRepo %>',
					branch: '<%= gitRepoRama.gitRepoRama %>',
					directory: "de"
				}
			},
			clonarsinrama: {
				options: {
					repository: '<%= gitRepo.gitRepo %>',
					directory: "de"
				}
			}
		},
		gitfetch: {
    		your_target: {
      			options: {
        			all: true,
        			cwd: 'de/'
      			}
    		}
	  	},
	  	gitpull: {
	    	your_target: {
	      		options: {
	      			all: true,
	        		cwd: 'de/'
	      		}
	    	}
	  	},
	    gitadd: {
	      	task: {
	       		options: {
	          		force: true,
	          		all: true,
	       	 		cwd: 'de/'
	       		}
	      	}
	    },
	    gitcommit: {
	      	autocomment: {
	        	options: {
	           		message: 'Repository updated on ' + grunt.template.today(),
	           		allowEmpty: true,
	           		cwd: 'de/'
	         	}
	      	},
	      	withcomment: {
	      		options: {
	           		message: '<%= gitRepoCommit %>',
	           		allowEmpty: true,
	           		cwd: 'de/'
	         	}
	      	}
	    },
	    gitpush: {
	       task: {
	        	options: {
	          		remote: 'origin',
	           		branch: 'master',
	          		cwd: 'de/'
	         	}
	       	}
	    },

	    // servidor php para el menú, directorio producción y directorio desarrollo
	    php: {
        	menu: {
            	options: {
            		port: 8000,
                	keepalive: true,
                	open: true,
                	ini: '_jugodegrunt/_menuhtml/php.ini' // opciones necesarias para que funcione la ejecución de programas desde la página
            	}
        	},
        	produccion: {
            	options: {
            		port: 8001,
                	keepalive: true,
                	open: true,
                	base: 'pr',
            	}
        	},
        	desarrollo: {
            	options: {
            		port: 8002,
                	keepalive: true,
                	open: true,
                	base: 'de',
            	}
        	}
    	},

    	// backup Dropbox
  		dropbox: {
			options: {
  				access_token: '<%= dropboxToken.dropboxToken %>'
			},
			dev: {
  				files: {
    				'<%= dropboxDirDest.dropboxDirDest %>': ['<%= dropboxAsubir.dropboxAsubir %>'],
  				}
  			}
  		},  		

	}); // fin grunt.initconfig.


	// carga los plugins a ser usados por grunt:
	grunt.loadNpmTasks('grunt-contrib-uglify'); //compresor JS -> https://github.com/gruntjs/grunt-contrib-uglify
	grunt.loadNpmTasks('grunt-contrib-cssmin'); //compresor CSS -> https://github.com/gruntjs/grunt-contrib-cssmin
	grunt.loadNpmTasks('grunt-contrib-htmlmin'); // compresor HTML -> https://github.com/gruntjs/grunt-contrib-htmlmin

	grunt.loadNpmTasks('grunt-contrib-watch'); // el plugin que hace que el sistema se pueda quedar vigilando cambios -> https://github.com/gruntjs/grunt-contrib-watch

	grunt.loadNpmTasks('grunt-newer'); // añadiéndole este a otros procesos hará que estos actúen solo sobre fichero nuevos o modificados -> https://github.com/tschaub/grunt-newer

	grunt.loadNpmTasks('grunt-ftp-diff-deployer');  // sistema para subir por ftp que sube solo los archivos que hayan sido modificados -> https://www.npmjs.com/package/grunt-ftp-diff-deployer

	grunt.loadNpmTasks('grunt-git'); // plugin que sera usado por todo el sistema de git -> https://github.com/rubenv/grunt-git

	grunt.loadNpmTasks('grunt-sync'); // para realizar backups espejo donde solo se copia (o borra) lo añadido o modificado (o eliminado) desde la última vez que se hizo la copia en el destino. -> https://www.npmjs.com/package/grunt-sync

	grunt.loadNpmTasks('grunt-dropbox'); // para dropbox, nos permitirá subir y hacer backusps si tenemos un token de acceso -> https://www.npmjs.com/package/grunt-dropbox

	grunt.loadNpmTasks('grunt-sitemap'); // para hacer el sitemap -> https://docs.omniref.com/js/npm/grunt-sitemap/1.2.0

	grunt.loadNpmTasks('grunt-link-checker');  // para comprobar si hay enlaces rotos -> https://github.com/ChrisWren/grunt-link-checker

	// a pesar de que no esta especificado aquí por no pertenecer a npm sino al propio grunt si que se ha instalado también el servidor PHP mediante los comandos:
	// npm install grunt-php --save-dev	
	// npm install load-grunt-tasks --save-dev // si no se instala no funcionará. 

	// también, independientemente de Grunt, se ha añadido una versión portable de 7zip para la compresión de archivos antes de subir a Dropbox y que tiene la capacidad de añadirles contraseña a los archivos.
	


	// creación de los diferentes alias para los comandos para que estén facilmente disponibles desde el bash
	grunt.registerTask('default', ['watch']);
	grunt.registerTask('desa-a-prod', ['sync:desprod', 'uglify', 'cssmin', 'htmlmin']);
	grunt.registerTask('subir', ['ftp-diff-deployer']);
	grunt.registerTask('backup', ['sync:backup']);
	grunt.registerTask('backupdropbox', ['dropbox']);
	//grunt.registerTask('sitemap', 'sitemap'); // (ejemplo) al tener el mismo nombre se crearía un bucle infinito, se le llamará directamente
	grunt.registerTask('link', 'linkChecker');
	grunt.registerTask('git1-clonar', ['gitclone:clonar']);
	grunt.registerTask('git1-clonarsinrama', ['gitclone:clonarsinrama']);
	grunt.registerTask('git2-pull', ['gitfetch', 'gitpull']);
	grunt.registerTask('git3-commit', ['gitadd', 'gitcommit:autocomment']);
	grunt.registerTask('git3-commitwithcomment', ['gitadd', 'gitcommit:withcomment']);
	grunt.registerTask('git4-push', ['gitpush']);
	grunt.registerTask('servphp-menu', ['php:menu']);
	grunt.registerTask('servphp-prod', ['php:produccion']);
	grunt.registerTask('servphp-desa', ['php:desarrollo']);

};