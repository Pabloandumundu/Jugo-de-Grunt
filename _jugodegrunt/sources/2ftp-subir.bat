@echo off
setlocal
set /p ftpServidor=<_jugodegrunt\ftpServidor.txt
set /p ftpPuerto=<_jugodegrunt\ftpPuerto.txt
set /p ftpDirectorioDestino=<_jugodegrunt\ftpDirectorioDestino.txt
set /p ftpAsubir=<_jugodegrunt\ftpAsubir.txt

if "%ftpAsubir%" == "pr" (

	echo Se subir n los £ltimos archivos modificados del directorio de Producci¢n al servidor '%ftpServidor%', puerto %ftpPuerto%, directorio '%ftpDirectorioDestino%'.
	goto SURE

) else if "%ftpAsubir%" == "de" (

	echo Atenci¢n: Se subir n los £ltimos archivos modificados de directorio de Desarrollo ...SIN MINIFICAR... al servidor '%ftpServidor%', puerto %ftpPuerto%, directorio '%ftpDirectorioDestino%'.
	goto SURE

)

:SURE
echo.
set /P estaseguro=¨Quieres Continuar (S/[N])?
if /I "%estaseguro%" NEQ "S" goto END

call grunt subir

pause

:END
endlocal