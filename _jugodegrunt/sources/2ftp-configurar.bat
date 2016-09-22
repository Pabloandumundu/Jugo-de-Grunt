@echo off
setlocal
set /p ftpServidor=<_jugodegrunt\ftpServidor.txt
set /p ftpPuerto=<_jugodegrunt\ftpPuerto.txt
set /p ftpUsuario=<_jugodegrunt\ftpUsuario.txt
set /p ftpPassword=<_jugodegrunt\ftpPassword.txt
set /p ftpDirectorioDestino=<_jugodegrunt\ftpDirectorioDestino.txt
set /p ftpAsubir=<_jugodegrunt\ftpAsubir.txt

echo Se configurar  la conexi¢n al servidor FTP a donde realizar subidas, se pedir  direcci¢n del servidor, puerto a utilizar (habitualmente 21), usuario y contrase¤a, directorio donde se subir  (por ejemplo '/public_html'), y aquello que se subir  (Desarrollo o Producci¢n).
echo.

set /p temp_ftpServidor=¨Direcci¢n del Servidor [%ftpServidor%]? 

if "%temp_ftpServidor%"=="" (

	if "%ftpServidor%"=="mipaginaweb.es" (
		echo La direcci¢n del servidor queda sin configurar mipaginaweb.es es un ejemplo.
		echo Puedes introducir el resto de los datos si lo deseas...
		
		) 

) 

:PREGUNTAS
set /p temp_ftpPuerto=¨Puerto [%ftpPuerto%]? 
set /p temp_ftpUsuario=¨Usuario de acceso [%ftpUsuario%]? 
set /p temp_ftpPassword=¨Password de acceso [%ftpPassword%]? 
set /p temp_ftpDirectorioDestino=¨Directorio de destino [%ftpDirectorioDestino%]? 

:PREGUNTAFTPASUBIR
if "%ftpAsubir%"=="pr" (

	goto PREGUNTAPR

) else if "%ftpAsubir%"=="de" (

	goto PREGUNTADE

) 

:PREGUNTAPR 

set /p temp_ftpAsubir=¨Que directorio se subir , Desarrollo o Producci¢n (de/[pr])? 

if "%temp_ftpAsubir%"=="" (

	echo %ftpAsubir%>_jugodegrunt\ftpAsubir.txt
	echo {"ftpAsubir":"%ftpAsubir%"}>_jugodegrunt\ftpAsubir.json

) else (

	echo %temp_ftpAsubir%>_jugodegrunt/ftpAsubir.txt
	echo {"ftpAsubir":"%temp_ftpAsubir%"}>_jugodegrunt/ftpAsubir.json
)

goto CONTINUA

:PREGUNTADE

set /p temp_ftpAsubir=¨Que directorio se subir , Producci¢n o Desarrolo (pr/[de])? 

if "%temp_ftpAsubir%"=="" (

	echo %ftpAsubir%>_jugodegrunt/ftpAsubir.txt
	echo {"ftpAsubir":"%ftpAsubir%"}>_jugodegrunt/ftpAsubir.json

) else (

	echo %temp_ftpAsubir%>_jugodegrunt/ftpAsubir.txt
	echo {"ftpAsubir":"%temp_ftpAsubir%"}>_jugodegrunt/ftpAsubir.json
)

goto CONTINUA

:CONTINUA

if "%temp_ftpServidor%"=="" (

	echo %ftpServidor%>_jugodegrunt/ftpServidor.txt
	echo {"ftpServidor":"%ftpServidor%"}>_jugodegrunt/ftpServidor.json

) else (

	echo %temp_ftpServidor%>_jugodegrunt/ftpServidor.txt
	echo {"ftpServidor":"%temp_ftpServidor%"}>_jugodegrunt/ftpServidor.json
)

if "%temp_ftpPuerto%"=="" (

	echo %ftpPuerto%>_jugodegrunt/ftpPuerto.txt
	echo {"ftpPuerto":"%ftpPuerto%"}>_jugodegrunt/ftpPuerto.json

) else (

	echo %temp_ftpPuerto%>_jugodegrunt/ftpPuerto.txt
	echo {"ftpPuerto":"%temp_ftpPuerto%"}>_jugodegrunt/ftpPuerto.json

)

if "%temp_ftpUsuario%"=="" (
	goto USUARIOANTERIOR
) else (
	goto SETPASS
)
:USUARIOANTERIOR
set temp_ftpUsuario=%ftpUsuario%
goto SETPASS

:SETPASS
if "%temp_ftpPassword%"=="" (
	goto PASSWORDANTERIOR
) else (
	goto ESCRIBIRUSERPASS
)
:PASSWORDANTERIOR
set temp_ftpPassword=%ftpPassword%
goto ESCRIBIRUSERPASS

:ESCRIBIRUSERPASS
echo %temp_ftpUsuario%>_jugodegrunt/ftpUsuario.txt
echo {"ftpUsuario":"%temp_ftpUsuario%"}>_jugodegrunt/ftpUsuario.json
echo %temp_ftpPassword%>_jugodegrunt/ftpPassword.txt
echo {"ftpPassword":"%temp_ftpPassword%"}>_jugodegrunt/ftpPassword.json


if "%temp_ftpDirectorioDestino%"=="" (

	echo %ftpDirectorioDestino%>_jugodegrunt/ftpDirectorioDestino.txt
	echo {"ftpDirectorioDestino":"%ftpDirectorioDestino%"}>_jugodegrunt/ftpDirectorioDestino.json

) else (

	echo %temp_ftpDirectorioDestino%>_jugodegrunt/ftpDirectorioDestino.txt
	echo {"ftpDirectorioDestino":"%temp_ftpDirectorioDestino%"}>_jugodegrunt/ftpDirectorioDestino.json

)

echo.
pause

:END
endlocal