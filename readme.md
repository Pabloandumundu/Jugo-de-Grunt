# Jugo de Grunt #

## Descripción ##
Conjunto de utilidades basadas en el motor de automatización Grunt. Siendo accesibles a través de un menú (en formato página web) o directamente a través de varios archivos .bat. El proyecto incluye una carpeta de desarrollo y otra de producción y ambas se pueden lanzar con servidores php, el sistema puede minificar automáticamente contenido html, css, o javascrit. También permite subir por ftp de manera que solo suba aquello que se ha modificado, Incluye un creador de sitemap.xml y un chequeador de enlaces rotos. 

Además permite trabajar con proyectos Git, pues incluye el espectro de acciones necesarias como clonar, commits, pull (incluido merge) y push. Además se podrá subir a Dropbox y si se quiere de manera comprimida y con clave.

Por ultimo, se podrá hacer backups espejo de todo el proyecto de manera que solo copia lo modificado (o borra lo que ya no este en origen).

## Código ##

El núcleo son las acciones llevadas a cabo por los diferentes plugins de Grunt que ya están instalados en este conjunto. Para lanzar estas acciones se han creado varios archivos bat cada uno para una acción en concreto que, por otro lado, tienen la capacidad de recoger inputs del usuario (como dirección de repositorio, usuarios, contraseñas, etc) para  los diferentes servicios y guardarlos en archivos txt y json que son después leídos por Grunt para tener los parámetros con los que ejecutar las acciones. 

Estos archivos txt y json cumplen la función además de memoria (así ya queda todo configurado para cada proyecto) y son leídos también por los .bat para facilitar la interactividad dando opciones por defecto. Se podrán resetar todos estos ficheros con datos mediante una opción disponible.

A nivel de interface quedan pues los propios archivos bat o también un menú en formato pagina web que se puede lanzar ejecutando uno de los .bat (`000-Start!.bat`). Se trata una página en php en la que pulsando en los correspondientes botones se lanzan los .bat utilizando Wscript.Shell:

    $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("1sitemap.bat", 5, true);

En el menú web se podrán ir viendo ya algunos de los parámetros si ya se han configurado y tiene el siguiente formato:


![menú Jugo de Grunt](screencapture-127-0-0-1-8000-1474569279721.png?raw=true "Menú")


## Motivación ##

Este Proyecto es un trabajo del último modulo de un curso de confección y publicación de paginas web que estoy realizando, y esa ha sido la motivación ejecutiva, por así decirlo, pero la razón de porque “esto” ha sido una razón practica para mi, y es que me venia muy bien un sistema como este tanto para una web que ya llevo un tiempo desarrollando y que se esta haciendo bastante voluminosa como para futuros proyectos.

## Instalación ##

*Preparación del entorno si es la primera vez que vas a usar Jugo de Grunt (JdG) en el equipo.*

A modo general, sea el que sea el uso que le vayas a dar al entorno JdG el equipo en el que se vaya a usar tiene que tener instalado npm, npm se suele instalar cuando se instala nodejs. Lo puedes descargar para instalar en:

[https://nodejs.org/en/](https://nodejs.org/en/)

Además, teniendo ya npm, hay que instalar el Grunt command line interface en la maquina globalmente, para ello abres la consola de comandos y desde cualquier directorio ejecutas.

    npm install -g grunt-cli

Ahora ya se podría empezar a utilizar algunas de las características de JdG, para ello simplemente se descomprime el zip con el entorno en una carpeta donde vayas a desarrollar un proyecto. Acciones como hacer backups o minificar automáticamente ficheros (ver manual más adelante) se podrían ya realizar siempre que se lancen ejecutando los diferentes ficheros .bat construidos a tal efecto.

Sin embargo si se quiere hacer uso del menú frontal de lanzamiento de los diferentes servicios, desarrollado en formato página web, se requiere tener instalado algún tipo de servidor php, igualmente si se quiere lanzar servidores para desarrollo o producción a través del entorno requiere tener instalado un programa servidor php.

Dos de los programas servidores más utilizados y que se pueden usar para ello indistintamente son

Xampp → [https://www.apachefriends.org/es/index.html](https://www.apachefriends.org/es/index.html)

Wamp → [http://www.wampserver.com/en/](http://www.wampserver.com/en/)

Según el equipo en el que se haya instalado es posible además que sea necesario añadirle el path o ruta al php en las variables del sistema; Ir a 

Equipo->propiedades->Configuración avanzada del sistema->Variables de entorno..

Y en PATH hay que añadirle (después de ; ) la dirección donde esté instalado el servidor php (donde este php.exe), en Xampp por defecto está en C:\xampp\php

Si el servidor php instalado es el de Wamp la dirección es algo más larga, del tipo:

C:\wamp64\bin\php\php7.0.4

Y por supuesto varía un poco según la versión instalada.

Ahora ya estarían casi todas las funcionalidades del entorno JdG disponibles. Solo queda por añadir Git para las acciones que usan este sistema, que si no ha sido ya previamente instalado se puede descargar para instalar en

[https://git-scm.com/download/win](https://git-scm.com/download/win)

Y eso es todo ya están todas las características de JdG disponibles.

## Mejoras Realizadas ##

28/09/2016

- Se pueden usar barras de msdos normales a la hora de definir la ruta del backup (antes por exigencias del formato json no podían utilizarse) y avisa si los caracteres introducidos no sirven (acentos y eñes).
2. Varias correcciones en el manual pdf y el sistema de ayuda.


22/09/2016

- Se han mejorado la subida de ftp simplemente eligiendo otro plugín (ftp-diff-deployer) que funciona muchísimo mejor que el utilizado inicialmente (grunt-ftpush) es mucho más fino y no es exigente con los nombres de los archivos.
2. Se ha simplificado la visualización del proceso de backup, antes daba una serie de mensajes recurrentes con unos archivos que siempre cambiaban, ahora solo se verán cambios reales realizados en el proyecto (si bien internamente se siguen copiando esos archivos)
3. Se han añadido las funcionalidades de crear sitemap y chequear enlaces pues parecían dos opciones que podían venir muy bien.
4. Solo hay un botón para subir FTP (y un solo archivo bat por lo tanto); la selección de si se sube Producción o Desarrollo se realiza ahora mediante la opción de configurar FTP, lo que ahorra un poco de espacio y mejora la seguridad evitando que nos confundamos. También se ha ahorrado otro espacio al poner el botón de reset aparte en un botón abajo.

16/09/2016

- Primera versión completa.

