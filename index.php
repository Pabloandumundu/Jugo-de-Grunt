<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="Jugo de Grunt"
    <meta name="author" content="Pablo Andueza Munduate">
    <meta name="description" content="Frontal con varias utilidades basadas en el motor de grunt y sus plugins, se hacen llamadas a procesos por lotes que configuran y ejecutan servicios como backups, minificar html, css y js, subidas ftp, git y dropbox">

    <title>Jugo de Grunt</title>

    <link rel="shortcut icon" href="_jugodegrunt/_menuhtml/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="_jugodegrunt/_menuhtml/img/favicon.ico" type="image/x-icon">

    <!-- Bootstrap nucleo -->
    <link href="_jugodegrunt/_menuhtml/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template de Bootsrap -->
    <link href="_jugodegrunt/_menuhtml/css/modern-business.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Unos pequeños retoques específicos de la página -->
    <link href="_jugodegrunt/_menuhtml/css/estilos.css" rel="stylesheet" type="text/css">

</head>

<body>

    <?php
    
    function recogeValoresFtp() {

        $str = file_get_contents('_jugodegrunt/ftpServidor.json');
        $json = json_decode($str, true);
        global $ftpServidor;
        $tmp = $json[ftpServidor];
        if ($tmp == "mipaginaweb.es") {$ftpServidor = "#";} // cuando no se han introducido datos
        else {$ftpServidor = $tmp;}

        $str = file_get_contents('_jugodegrunt/ftpDirectorioDestino.json');
        $json = json_decode($str, true);
        global $ftpDirectorioDestino;
        $ftpDirectorioDestino = $json[ftpDirectorioDestino];

        $str = file_get_contents('_jugodegrunt/ftpPuerto.json');
        $json = json_decode($str, true);
        global $ftpPuerto;
        $ftpPuerto = $json[ftpPuerto];

        $str = file_get_contents('_jugodegrunt/ftpAsubir.json');
        $json = json_decode($str, true);
        global $ftpAsubir;
        $tmp = $json[ftpAsubir];
        if ($tmp == "de") {$ftpAsubir = "Desarrollo";}
        else if ($tmp == "pr") {$ftpAsubir = "Producción";}


    }

    function recogeValoresGit() {

        $str = file_get_contents('_jugodegrunt/gitRepo.json');
        $json = json_decode($str, true);
        global $gitRepo;
        $tmp = $json[gitRepo];
        if ($tmp == "https://github.com/mirepositorio/miproyecto.git") {$gitRepo = "#";} // cuando no se han introducido datos
        else {$gitRepo = $tmp;}

        $str = file_get_contents('_jugodegrunt/gitRepoRama.json');
        $json = json_decode($str, true);
        global $gitRepoRama;
        $gitRepoRama = $json[gitRepoRama];

        $str = file_get_contents('_jugodegrunt/gitUUser.json');
        $json = json_decode($str, true);
        global $gitUUser;
        $tmp = $json[gitUUser];
        if ($tmp == "el usuario con credencial local") {$gitUUser = "(Usuario Local)";}
        else {$gitUUser = $tmp;}

    }

    function recogeValoresDropbox() {

        $str = file_get_contents('_jugodegrunt/dropboxDirDest.json');
        $json = json_decode($str, true);
        global $dropboxDirDest;
        $dropboxDirDest = $json[dropboxDirDest];

        $str = file_get_contents('_jugodegrunt/dropboxAsubir.json');
        $json = json_decode($str, true);
        global $dropboxAsubir;
        $deopr = $json[dropboxAsubir];
        if ($deopr == "pr/**/*.*") {$dropboxAsubir = "Producción";}
        else {$dropboxAsubir = "Desarrollo";}

        $str = file_get_contents('_jugodegrunt/dropboxToken.json');
        $json = json_decode($str, true);
        global $dropboxToken;
        $tmp = $json[dropboxToken];
        if ($tmp == "") {$dropboxToken = "#";} // cuando no se han introducido datos
        else $dropboxToken = substr($tmp, 0, 16); // se presentan hasta un máximo de 16 caracteres

    }

    function recogeValorSitemap() {

        $str = file_get_contents('_jugodegrunt/sitemapWeb.json');
        $json = json_decode($str, true);
        global $sitemapWeb;
        $tmp = $json[sitemapWeb];
        if ($tmp == "misitioweb.es") {$sitemapWeb = "#";} // cuando no se han introducido datos
        else {$sitemapWeb = $tmp;}

    }

    function recogeValores() {

        recogeValoresFtp();
        recogeValoresGit();
        recogeValoresDropbox();
        recogeValorSitemap();
    }

    recogeValores();


    if (!empty($_POST)) { 

        $servicio = reset($_POST); // apunta a, y devuelve, el primer valor de $_POST
        switch ($servicio) {
            case "Vigilar y Minificar":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("1escuchar.bat", 5, false);
                break;
            case "Lanza Serv. Prod.":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("1servidor-produccion.bat", 5, false);
                break;
            case "Lanza Serv. Desa.":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("1servidor-desarrollo.bat", 5, false);
                break;
            case "Desa. a Prod.":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("1desa-a-prod.bat", 5, true);
                break;            
            case "Cambiar FTP":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("2ftp-configurar.bat", 5, true);
                recogeValoresFtp(); // para que aparezcan los nuevos datos en la página
                break;
            case "Subir por FTP":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("2ftp-subir.bat", 5, false);
                break;
            case "Crear Sitemap":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("1sitemap.bat", 5, true);
                recogeValorSitemap(); // para que aparezca si hubiera cambio en la web asociada
                break;
            case "Chequear Links":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("1linkcheck.bat", 5, false);
                break;
            case "Cambiar Git":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("3git-configurar.bat", 5, true);
                recogeValoresGit(); // para que aparezcan los nuevos datos en la página
                break;
            case "Clonar Git":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("3git-clone.bat", 5, true);
                break;
            case "Hacer Commit":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("3git-commit.bat", 5, true);
                break;
            case "Hacer Pull":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("3git-pull.bat", 5, true);
                break;
            case "Hacer Push":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("3git-push.bat", 5, true);
                break;
            case "Cambia Dropbox":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("4dropbox-configurar.bat", 5, true);
                recogeValoresDropbox(); // para que aparezcan los nuevos datos en la página
                break;
            case "Sube a Dropbox":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("4dropbox-subir.bat", 5, true);
                break;
            case "Hacer Backup":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("5backup.bat", 5, false); 
                break;            
            case "Reinicia Valores":
                $WshShell = new COM("WScript.Shell"); $oExec = $WshShell->Run("5resetear.bat", 5, true);
                recogeValores();
                break;
        }
    }

    ?>

    <!-- Contenido Página -->
    <div class="container">

        <div id="logomarco" class="text-center">
            <h1><img id="logotipo" src="_jugodegrunt/_menuhtml/img/logo.svg" alt="Jugo de Grunt" class="center-block"></h1>
        </div>


        <!-- Paneles Servicios -->
        <div class="row equalizer">
            <div class="col-lg-12">
                <h2 class="page-header">Servicios</h2>
            </div>
            <form action="" method="post">
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-binoculars fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Vigilar / Minificar</h4>
                            <p>Lo que cambia en Desarrollo quedará minificado en Producción</p>
                            <input type="submit" name="vigilar" class="btn btn-primary" value="Vigilar y Minificar">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-server fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Servidor Producción</h4>
                            <p>Lanza servidor PHP con el contenido de Producción</p>
                            <input type="submit" name="servprod" class="btn btn-primary" value="Lanza Serv. Prod.">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-server fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Servidor Desarrollo</h4>
                            <p>Lanza servidor PHP con el contenido de Desarrollo</p>
                            <input type="submit" name="servdes" class="btn btn-primary" value="Lanza Serv. Desa.">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-files-o fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Desarrollo &#8594; Producción</h4>
                            <p>Se realiza un volcado de Desarrollo a Producción, incluida minificación</p>
                            <input type="submit" name="configgit" class="btn btn-primary" value="Desa. a Prod.">
                        </div>
                    </div>
                </div>


                
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-gear fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Configurar FTP</h4>
                            <p class="wordbreak"><u><em>Servidor</em></u>: <a href="http://<?php echo $ftpServidor ?>" target="_blank"><?php echo $ftpServidor ?></a><br>
                            <u><em>Directorio</em></u>: <?php echo $ftpDirectorioDestino ?><br>
                            <u><em>Puerto</em></u>: <?php echo $ftpPuerto ?><br>
                            <u><em>A Subir</em></u>: <?php echo $ftpAsubir ?></p>
                            <input type="submit" name="ftpconfig" class="btn btn-primary" value="Cambiar FTP">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-upload fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Subir FTP</h4>
                            <p>Subirá por FTP el contenido designado (reconoce y sube solo contenido modificado)</p>
                            <input type="submit" name="ftpprod" class="btn btn-primary" value="Subir por FTP">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-sitemap fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Generar Sitemap</h4>
                            <p><u><em>Para Web</em></u>: <span class="wordbreak"><a href="http://<?php echo $sitemapWeb ?>" target="_blank"><?php echo $sitemapWeb ?></a></span><br>
                            Se creará el fichero sitemap.xml del directorio de Desarrollo</p>
                            <input type="submit" name="ftpdesa" class="btn btn-primary" value="Crear Sitemap">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-link fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Comprobar Links</h4>
                            <p>Chequeará si el proyecto en Desarrollo tiene links internos rotos, requiere Servidor Desarrollo</p>
                            <input type="submit" name="ftpdesa" class="btn btn-primary" value="Chequear Links">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-gears fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Configurar Git</h4>
                            <p class="wordbreak"><u><em>Repositorio</em></u>: <a href="<?php echo $gitRepo ?>" target="_blank"><?php echo $gitRepo ?></a><br>
                            <u><em>Rama</em></u>: <?php echo $gitRepoRama ?></p>
                            <input type="submit" name="gitconfig" class="btn btn-primary" value="Cambiar Git">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-git fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Git Clone</h4>
                            <p>Realiza la clonación del repositorio en Desarrollo, el directorio 'de' deberá estar vació</p>
                            <input type="submit" name="gitclone" class="btn btn-primary" value="Clonar Git">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-git-square fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Git Commit</h4>
                            <p>Realiza un commit con los cambios realizados, se podrá añadir un comentario</p>
                            <input type="submit" name="gitcommit" class="btn btn-primary" value="Hacer Commit">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-git-square fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Git Pull</h4>
                            <p>Comprobará si hay cambios en el repositorio, los bajará y fundirá con cambios en Desarrollo</p>
                            <input type="submit" name="gitpull" class="btn btn-primary" value="Hacer Pull">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-git-square fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Git Push</h4>
                            <p><u><em>Usuario</em></u>: <?php echo $gitUUser ?><br> Subirá los commit que no se hayan subido al repositorio</p>
                            <input type="submit" name="gitpush" class="btn btn-primary" value="Hacer Push">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-dropbox fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Configurar Dropbox</h4>
                            <p><u><em>Token</em></u>: <?php echo $dropboxToken ?> ...<br>
                            <u><em>Destino</em></u>: <span class="wordbreak"><?php echo $dropboxDirDest ?></span><br><u><em>Origen</em></u>: <?php echo $dropboxAsubir ?></span></p>
                            <input type="submit" name="dropboxconfig" class="btn btn-primary" value="Cambia Dropbox">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-dropbox fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Subir Dropbox</h4>
                            <p>Se subirá el origen seleccionado.<br>Se le puede indicar que lo suba comprimido en un .zip protegido</p>
                            <input type="submit" name="dropboxsubir" class="btn btn-primary" value="Sube a Dropbox">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 watch">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                  <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                  <i class="fa fa-clone fa-stack-1x fa-inverse"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <h4>Backup</h4>
                            <p>Mediante comparación copia solo los archivos modificados</p>
                            <input type="submit" name="backup" class="btn btn-primary" value="Hacer Backup">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12 col-sm-12 text-right">
					<a href="#" data-toggle="tooltip" data-placement="left" title="Se borraran las direcciones, usuarios y contraseñas utilizadas"><input type="submit" class="btn btn-default btn-lg" name="resetear" value="Reinicia Valores" ></a>
				</div>
            </form>
        </div>
        <!-- /. Paneles Servicios -->

        <!-- Ayuda -->
        <div id="ayuda" class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Ayuda</h2>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Seleccione Servicio
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#vigilarminificar" class="toggle">Vigilar / Minificar</a></li>
                        <li><a href="#servidorproduccion" class="toggle">Servidor Producción</a></li>
                        <li><a href="#servidordesarrollo" class="toggle">Servidor Desarrollo</a></li>
                        <li><a href="#desaaprod" class="toggle">Desarrollo &#8594; Producción</a></li>
                        <li><a href="#configurarftp" class="toggle">Configurar FTP</a></li>
                        <li><a href="#subirftp" class="toggle">Subir FTP</a></li>
                        <li><a href="#generarsitemap" class="toggle">Generar Sitemap</a></li>
                        <li><a href="#comprobarlinks" class="toggle">Comprobar Links</a></li>
                        <li><a href="#configurargit" class="toggle">Configurar Git</a></li>
                        <li><a href="#gitclone" class="toggle">Git Clone</a></li>
                        <li><a href="#gitcommit" class="toggle">Git Commit</a></li>
                        <li><a href="#gitpull" class="toggle">Git Pull</a></li>
                        <li><a href="#gitpush" class="toggle">Git Push</a></li>
                        <li><a href="#configurardropbox" class="toggle">Configurar Dropbox</a></li>
                        <li><a href="#subirdropbox" class="toggle">Subir Dropbox</a></li>
                        <li><a href="#backup" class="toggle">Backup</a></li>
                        <li class="divider"></li>
                        <li><a href="#resetear" class="toggle">Reinicia Valores</a></li>
                        <li class="divider"></li>
                    </ul>

                    <a href="_jugodegrunt/manual/JdG-manual.pdf" target="_blank"><button type="button" class="btn btn-warning btn-md"></span> Manual en PDF <span class="fa fa-file-pdf-o"></button></a>
                </div>
                <br>
                <div id="marcoayuda">

                    <div id="vigilarminificar" class="well hidden txtayuda">
                         <h3>Vigilar / Minificar</h3>
                         <p>Al ejecutarse queda en segundo plano y, mientras se esta trabajando en un proyecto en el directorio de Desarrollo ('de'), este proceso se encarga de copiar y en los casos de archivos .html, .css y .js además minificar (eliminando espacios y comentarios) el contenido en el directorio de Producción ('pr').</p>
                         <p>Este proceso es útil porque se reducen los tamaños de los archivos y por lo tanto los tiempos de carga.</p>
                         <p>Es bastante habitual que se inicie un proyecto no empezando de cero sino teniendo ya cierto contenido en Desarrollo. Si se inicia la vigilancia antes de copiar ese contenido a Desarrollo el programa se enterará de los cambios. Si, por el contrario, se tiene ya cierto contenido y después se empieza a vigilar el programa no se enterará hasta que se haga algún cambio (el que sea).</p>
                         <p>En este sentido hay una acción relacionada con esto que es “Desarrollo a Producción” y cuya única función es hacer lo mismo que hace “Vigilar / Minificar” solo que en ese caso no espera a que haya un cambio, sino que realiza <u>una</u> ejecución sin más.</p>
                    </div>
                    <div id="servidorproduccion" class="well hidden txtayuda">
                        <h3>Servidor Producción</h3>
                        <p>Este servicio arrancará un servidor php con el contenido que haya en la carpeta de Producción. Deberá haber algún fichero index (ya sea .html o .php) para que sea lanzado cuando arranque.</p>
                        <p>Cuando se ejecute esta acción se abrirá una ventana de comandos que ira mostrando los mensajes del servidor y que no se deberá cerrar hasta que queramos paralizar el servicio.</p>
                    </div>
                    <div id="servidordesarrollo" class="well hidden txtayuda">
                        <h3>Servidor Desarrollo</h3>
                        <p>Este servicio arrancará un servidor php con el contenido que haya en la carpeta de Desarrollo. Deberá haber algún fichero index (ya sea .html o .php) para que sea lanzado cuando arranque.</p>
                        <p>Cuando se ejecute esta acción se abrirá una ventana de comandos que ira mostrando los mensajes del servidor y que no se deberá cerrar hasta que queramos paralizar el servicio.</p>
                    </div>
                    <div id="desaaprod" class="well hidden txtayuda">
                        <h3>Desarrollo &#8594; Producción</h3>
                        <p>Esta acción hace casi lo mismo que Vigilar / Minimificar solo que no se queda vigilando en segundo plano a la espera de un cambio sino que lanza <u>una</u> ejecución sin más.</p>
                        <p>Puede ser útil si, por ejemplo, no queremos tener en segundo plano “Vigilar/Minificar”, podemos ejecutar esta acción cuando se quiera y ya esta.</p>
                        <p>Sin embargo hay una pequeña diferencia (que no afecta sin embargo a los resultados) y es que si bien el resto de los ficheros solo copia o cambia lo que este modificado en los archivos html, css y js los vuelve a minimizar y copiar todos. De todas formas la ejecución de la minificación es en extremo rápida y, muy gigantesca tiene que ser la web para que afecte a la productividad. (Se intentará solucionarlo en futuras versiones).</p>
                    </div>
                    <div id="configurarftp" class="well hidden txtayuda">
                        <h3>Configurar FTP</h3>
                        <p>Esta acción sirve para configurar el acceso a un servidor FTP al que vayamos luego a subir nuestros contenidos.</p>
                        <p>Durante el proceso de configuración se nos hará una serie de preguntas donde podemos o bien introducir los nuevos datos o bien pulsar enter con lo que se mantendrá la última configuración conocida para cada caso.</p>
                        <p>Se nos preguntará en el siguiente orden; dirección del servidor, puerto (muy habitualmente 21), usuario de acceso, password de dicho usuario, directorio de destino (que puede ser ‘public_html’, simplemente ‘/’ o algún otro dependiendo del servidor; hay que conocer donde nos sitúa el FTP por defecto y donde está en relación con la dirección http del hosting web). por último, además, se nos preguntará si lo que queremos subir es el contenido de Desarrollo o de Producción.</p>
                        <p>En el menú gráfico se puede ver encima del botón cual es el sitio, puerto y el directorio al que se subirá y que es lo que se subirá.</p>
                    </div>
                    <div id="subirftp" class="well hidden txtayuda">
                        <h3>Subir FTP</h3>
                        <p>Esta acción subirá por FTP aquello que se haya modificado o añadido en el directorio designado (Desarrollo o Producción) desde la última subida a ese mismo servidor. Si es la primera vez que se sube subirá todo.</p>
                        <p>También, si hay archivos en el servidor que ya no están en el directorio origen serán eliminados.</p>
                        <p>El acceso servidor FTP destino se configura mediante la acción independiente "Configurar FTP".</p>
                    </div>
                    <div id="generarsitemap" class="well hidden txtayuda">
                        <h3>Generar Sitemap</h3>
                        <p>Se creará un archivo sitemap.xml que contendrá referencias a todos los archivos que haya en el directorio de Desarrollo (ficheros html, imágenes, pdfs, y todo, absolutamente todo, lo demás) que se guardará en la raíz de ese mismo directorio.</p>
                        <p>Se preguntará cual será la dirección web raíz a la que estarán asociados los archivos (“homepage”) de tal forma que aunque el rastreo se haga en la máquina local las direcciones que se incluirán en el archivo sitemap tendrán como inicio la dirección indicada.</p>
                        <p>El archivo sitemap.xml es utilizado por los buscadores (una vez subido al directorio raíz de nuestra web) para agilizar y facilitar que se rastreen todos los archivos contenidos en nuestra web y de esa forma puedan salir en las búsquedas.</p>
                        <p>Una peculiaridad de este modo de crear el sitemap es que no lo hace siguiendo todos los posibles enlaces empezando por la pagina de inicio, sino que sin más añade todos los archivos que encuentra en el directorio. Esto implica que este método <u>no sirve para páginas dinámicas</u> donde el contenido se extrae de bases de datos, por otro lado tiene la propiedad de que añade paginas o contenido que no necesariamente esta enlazado desde nuestro sitio principal, lo cual puede resultar útil (o no) en algunas ocasiones.</p>
                        <p>A cada enlace añadido se le adjuntará automáticamente la fecha de modificación.</p>
                        <p>En principio cada enlace añadido contabá además con otro par de parámetros que se añadían automáticamente el “chagefreq” y el “priority” y que en este caso tenían el mismo valor para todos los archivos, los cuales se ha decidido eliminar del sitemap.xml ya que, por un lado, en el caso de changefreq (cuyo valor puede ser “always”, “hourly”, “daily”, ”weekly”, ”monthly”, ”yearly” o “never”) al aplicarle el mismo valor a todos los archivos estaríamos simplemente mintiéndole a los robots de los buscadores, porque evidentemente no todos los archivos iban a cambiarse con tal o cual asiduidad, y ante esta situación es mejor no poner nada y ya esta, el buscador seguirá intentando actualizar la indexación de nuestra web rastreando los archivos de forma equitativa, lo mismo se aplicá al parámetro priority que suele tener un valor de 0 a 1 y en este caso se añadía automáticamente el valor 0.5 a todos los archivos (de tal forma que ninguno tenia prioridad y todos serian equitativamente revisados cada cierto tiempo), que se ha decidido eliminar porque su utilidad era nula y lo único que hacia era añadirle más peso al archivo sitemap.xml</p>
                        <p>Al eliminar ambos parámetros el archivo sitemap.xml pesa menos y los buscadores podrán dedicar más de su cupo diario de datos con respecto a nuestra web para rastrear las páginas.</p>
                    </div>
                    <div id="comprobarlinks" class="well hidden txtayuda">
                        <h3>Comprobar Links</h3>
                        <p>Comprobará si el proyecto de la carpeta Desarrollo tiene enlaces internos (enlaces que apuntan a páginas de la misma web) rotos.</p>
                        <p>Para ejecutarlo es necesario que previamente este lanzado el servicio "Servidor Desarrollo" pues hace las comprobaciones a partir de este.</p>
                        <p>Siempre que haya enlaces rotos nos mostrará, al final, tras haber pasado por todos los links las siguientes 2 lineas:</p>
                        <p><code>Warning: Task "linkChecker:dev" failed. Used --force, continuing</code></p>
                        <p><code>Done, but with warnings.</code></p>
                        <p>Si no encuentra enlaces rotos nos devolverá <code>Done</code>.</p>
                    </div>
                    <div id="configurargit" class="well hidden txtayuda">
                        <h3>Configurar Git</h3>
                        <p>Esta acción servirá para introducir todos los datos necesarios para poder acceder a y, si fuera el caso también escribir en, un repositorio git.</p>
                        <p>Primero de todo se nos preguntará por la dirección del repositorio git, después se nos preguntará si vamos a definir una rama en concreto o si lo dejamos en blanco y no definimos ninguna. Si no definimos ninguna rama el sistema cuando se vaya a hacer la clonación automáticamente intentará hacerla desde la rama master o principal.</p>
                        <p>Luego se nos preguntará por el usuario (el usurario solo sería necesario si fuéramos a subir algo al repositorio), este, si queremos que nos sirva, deberá tener permiso de escritura en el repositorio. Si la pregunta se deja en blanco el usuario será el último usuario git conocido, en principio que haya usado "Jugo de Grunt" (JdG), si no hay nadie el usuario git ya configurado en el sistema Windows (y si no hay nadie saldrá una ventana cuando se trate de subir algo pidiéndonos usuario y contraseña). En la pregunta aparece el último usuario conocido por JdG.</p>
                        <p>Si introducimos un nuevo nombre de usuario de seguido nos preguntará por la contraseña. Y eso es todo.</p>
                    </div>
                    <div id="gitclone" class="well hidden txtayuda">
                        <h3>Git Clone</h3>
                        <p>Mediante este método haremos una clonación inicial de lo que haya en el repositorio previamente definido con "Configurar Git" en la carpeta de Desarrollo 'de'.</p>
                        <p>Esta carpeta deberá estar vacía, y por motivos de seguridad se ha evitado automatizar esta tarea; el usuario deberá ser consciente del contenido que hubiera en esa carpeta antes de borrarlo todo.</p>
                    </div>
                    <div id="gitcommit" class="well hidden txtayuda">
                        <h3>Git Commit</h3>
                        <p>Cuando se hayan hecho uno o varios cambios aparte de guardar de la manera habitual hay que ir haciendo commits que son como instantáneas que quedan guardadas en el registro de git en local y que luego se pueden subir al repositorio (una o varias a la vez).</p>
                        <p>Al ejecutar esta acción nos preguntará si queremos añadirle algún comentario personalizado al commit o si le añade el comentario automático, el comentario automático tendría el formato:</p>
						<p>&nbsp;&nbsp;Repository Updated on fecha/hora.</p>
                    </div>
                    <div id="gitpull" class="well hidden txtayuda">
                        <h3>Git Pull</h3>
                        <p>Con esta acción se descargará lo que haya sido modificado en el repositorio desde la última vez que se descargó (ya sea con otro pull o con clone). Pero más allá de descargar ficheros o de borrar ficheros en local si no están en el repositorio, lo que hace es integrar el código que ha cambiado en el repositorio con el código que nosotros tenemos y que a su vez hayamos podido cambiar, linea a linea.</p>
                        <p>La acción incluye el fetch y el merge.</p>
                        <p>Un caso típico del la necesidad de usar "Git Pull" es que hayos intentado subir y git nos haya dado un error avisándonos de que había modificaciones en el repositorio, en ese caso debemos ejecutar esta acción.</p>
                        <p>Si después de ejecutarla no da mensaje de que tenemos que solucionar un conflicto a mano, (ver siguientes párrafos) <u>volveremos a hacer un commit</u> y <u>después un push.</u></p>
                        <p>Hay conflictos en los que no tenemos que actuar; cuando los archivos modificados en el repositorio son distintos de los modificados en local, o cuando aún siendo el mismo fichero las líneas modificadas son distintas, el sistema se encargará de entramar (o mezclar) las lineas. Sin embargo el caso en el que SI debemos actuar de manera manual es cuando las mismas líneas están modificadas de distinta manera en el repositorio y en local.</p>
                        <p>En ese caso hay que <u>volver a ejecutar un commit</u> y después <u>tras hacer el pull</u>, el o los ficheros en cuestión incluirán todas las líneas en conflicto, junto con unas marcas llamativas para que las veamos de un simple vistazo y podamos elegir las que queremos que se mantengan. Tras solucionar y elegir las líneas que queremos <u>volvemos a ejecutar un commit</u> y después ya podremos subir mediante el <u>push</u>.</p>
                    </div>
                    <div id="gitpush" class="well hidden txtayuda">
                        <h3>Git Push</h3>
                        <p>Esta acción sirve para subir el/los commit que hayamos hecho en local pero que todavía no se hayan subido al repositorio.</p>
                        <p>El usuario de acceso, que se puede especificar usando el "Configurar Git" deberá tener permisos de acceso a dicho repositorio..</p>
                        <p>Si en el repositorio no ha habido cambios con respecto a la copia que teníamos nos subirá sin problemas, si hubiera habido cambios (quizás realizados por otros usuarios) tendremos que hacer primero un "Git Pull", actuar si fuera menester (ver instrucciones de la acción), volver a hacer un commit y después volver a hacer el push.</p>
                    </div>
                    <div id="configurardropbox" class="well hidden txtayuda">
                        <h3>Configurar Dropbox</h3>
                        <p>Con esta acción se configuraran los parámetros de acceso a un repositorio Dropbox al que podremos luego subir tanto el directorio de Producción como el de Desarrollo.</p>
                        <p>Al ejecutarlo lo primero que se nos pedirá sera el Token de acceso de la aplicación, tienes las instrucciones de como conseguir uno abajo. Con el toquen ya le estamos dando la dirección donde tiene que subir junto con el permiso.</p>
                        <p>Después nos dirá que le señalemos si queremos subir el directorio de Producción ('pr') o de Desarrollo ('de').</p>
                        <p>Se nos pregunta por último cual queremos que sea el directorio del destino (dentro del espacio al que se accede con el token mediante la aplicación o con la cuenta asociada como usuario).</p>
                        <br>
                        <p><em>Como conseguir un token de acceso</em>:</p>
                        <p>Si no tienes cuenta Dropbox crea una cuenta (no hace falta que ejecutar el programa que se empieza a bajar automáticamente, simplemente mira el correo con el que te registraste y te habrán enviado un correo para que chequees y confirmes, y ya tendrás la cuenta activada).</p>
                        <p>Después accede a <a href="https://www.dropbox.com/developers/apps" target="_blank">https://www.dropbox.com/developers/apps</a></p>
                        <p>Crea una aplicación, te saldrá una ventana, entre las opciones a elegir escoge "Dropbox Api", el tipo de aplicación: "App folder– Access to a single folder created specifically for your app.", y le pones el nombre que quieras.</p>
                        <p>En el menú de la izquierda pulsa "API Explorer" y después "token/revoke" y ya te aparece un botón que pone "Get token" lo pulsas y el string que aparece es el token que se puede usar para la configuración.</p>
                    </div>
                    <div id="subirdropbox" class="well hidden txtayuda">
                        <h3>Subir Dropbox</h3>
                        <p>Con esta acción subiremos un contenido a un espacio en Dropbox, definidos ambos en "Configurar Dropbox".</p>
                        <p>En esta acción se nos preguntará si queremos comprimir el directorio que subamos o lo subiremos tal cual (si dejamos en blanco no comprimirá, si ponemos un nombre lo comprimirá en un zip con ese nombre).</p>
                        <p>Si hemos señalado que si queríamos que lo comprimiera nos preguntará si lo queremos proteger con contraseña, en este caso es importante señalar que si bien la codificación puede ser bastante segura sobre todo si ponemos una contraseña un poco larga, no permitiéndonos descomprimir a no ser que la sepamos (independientemente del programa con el que tratemos de descomprimir), si se nos permite en principio navegar por la estructura de directorios de los archivos contenidos en este, permitiendo ver los nombres de archivos. Por ello aquí se nos preguntará si queremos además ocultar la estructura de archivos, que lo que hará sería una doble compresión (un fichero zip normal con los archivos dentro, a su vez dentro de un archivo zip protegido).</p>
                    </div>
                    <div id="backup" class="well hidden txtayuda">
                        <h3>Backup</h3>
                        <p>Con esta acción se realizará una copia integral del proyecto (directorio de Desarrollo) más el entorno (Grunt+JdG) en un directorio que se podrá especificar justo después de iniciar la acción.</p>
                        <p>Las copias serán de tipo espejo, en las que solo se copiarán los archivos que se hayan modificado o añadido desde la última vez que se hizo la copia en un directorio dado. Si además hay archivos en el destino que ya no se encuentran en origen estos serán eliminados.</p>
                        <p>Atención: la dirección deberá llevar contrabarra “/” y no barra “\” para que el programa lo lea correctamente y no falle, en caso de equivocarse volver a ejecutar esta misma acción de “Backup” y corregir.</p>
                    </div>
                    <div id="resetear" class="well hidden txtayuda">
                        <h3>Reinicia Valores</h3>
                        <p>Mediante esta acción se borraran todos las direcciones, usuarios y contraseñas que se han guardado en esta instancia de "Jugo de Grunt"</p>
                    </div>

                </div>
                <!-- /.marcoayuda -->

            </div>
        </div>
        <!-- /.ayuda -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12" style="text-align: right; font-size:11.5px">
                    <p>

                      
                    <a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Licencia de Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/80x15.png" /></a><br> Esta obra está bajo una <a rel="license" href="http://creativecommons.org/licenses/by/4.0/">licencia de Creative Commons Reconocimiento 4.0 Internacional</a>. <br>
                     Jugo de Grunt&reg; es una marca registrada de Jugi-Grunt Company Ltd.

                    </p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="_jugodegrunt/_menuhtml/js/jquery.js"></script>

    <!-- Bootstrap -->
    <script src="_jugodegrunt/_menuhtml/js/bootstrap.min.js"></script>

    <!-- Código específico para la página  -->
    <script src="_jugodegrunt/_menuhtml/js/codigo.js"></script>


</body>

</html>
