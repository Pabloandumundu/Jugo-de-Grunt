@echo off
setlocal
set /p dropboxDirDest=<_jugodegrunt\dropboxDirDest.txt
set /p dropboxAsubir=<_jugodegrunt\dropboxAsubir.txt

if "%dropboxAsubir%"=="de" (

	echo Se subirá el contenido de la carpeta de desarrollo a Dropbox al directorio '%dropboxDirDest%', puede lanzar la configuración de Dropbox para cambiar estas opciones.

) else if "%dropboxAsubir%"=="pr" (

	echo Se subirá el contenido de la carpeta de producción a Dropbox al directorio '%dropboxDirDest%', puede lanzar la configuración de Dropbox para cambiar estas opciones.

)

echo.
set temp_dropboxAsubir=%dropboxAsubir%

set /p ficheroComprimido=¿Nombre del archivo comprimido a subir (se le añadirá la extensión .zip automáticamente) [si deja en blanco no se comprimirá y se copiará la carpeta tal cual]? 

if "%ficheroComprimido%"=="" (
	
	grunt backupdropbox
	pause
	goto END

) else (

	goto COMPR
)

:COMPR

set PATH=%PATH%;%~dp0\_jugodegrunt\7zportable

set /p protegerzip=¿Quieres proteger el contenido del zip? Si es asi escribe una contraseña [si dejas en blanco se no se protegerá]: 

if "%protegerzip%"=="" (

call 7z a %ficheroComprimido%.zip %dropboxAsubir%/

goto SUBIR

) else (

goto PROTEGER

)

:PROTEGER

set /P protegerestructura=¿Quieres ocultar la estructura de archivos (S/[N])? 
if /I "%protegerestructura%" NEQ "S" (goto PROTEGER1) else (goto PROTEGER2)

:PROTEGER1

call 7z a %ficheroComprimido%.zip %dropboxAsubir%\ -p%protegerzip%
goto SUBIR

:PROTEGER2

call 7z a %ficheroComprimido%.zip %dropboxAsubir%\
call 7z a %ficheroComprimido%-temp.zip %ficheroComprimido%.zip -p%protegerzip%
del %ficheroComprimido%.zip
ren %ficheroComprimido%-temp.zip %ficheroComprimido%.zip
goto SUBIR

:SUBIR

echo {"dropboxAsubir":"%ficheroComprimido%.zip"}>_jugodegrunt\dropboxAsubir.json

call grunt backupdropbox

echo {"dropboxAsubir":"%temp_dropboxAsubir%"}>_jugodegrunt\dropboxAsubir.json
del %ficheroComprimido%.zip /q

pause
:END
endlocal