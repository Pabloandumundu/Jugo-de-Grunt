@echo off
setlocal

set /p dropboxToken=<_jugodegrunt\dropBoxToken.txt
set /p dropboxAsubir=<_jugodegrunt\dropboxAsubir.txt
set /p dropboxDirDest=<_jugodegrunt\dropboxDirDest.txt

echo Se configurar  el backup a Dropbox.
echo.

:PREGUNTATOKEN
set /p temp_dropboxToken=¨Token de acceso de la aplicaci¢n a Dropbox [%dropboxToken%]? 
if "%temp_dropboxToken%"=="" (

	if "%dropBoxToken%"=="" (

		echo.
		echo No ha introducido ningun valor..
		goto PREGUNTATOKEN

	) else (

		echo %dropboxToken%>_jugodegrunt\dropboxToken.txt
		echo {"dropboxToken":"%dropboxToken%"}>_jugodegrunt\dropboxToken.json
	)

) else (

	echo %temp_dropboxToken%>_jugodegrunt\dropboxToken.txt
	echo {"dropboxToken":"%temp_dropboxToken%"}>_jugodegrunt\dropboxToken.json
)

:PREGUNTADIREC
echo Seleccione de que directorio quiere hacer backup:
echo 1 - Desarrollo (de)
echo 2 - Producci¢n (pr)

set /p directorio=

if %directorio%==1 (

    echo de>_jugodegrunt\dropboxAsubir.txt
	echo {"dropboxAsubir":"de/**/*.*"}>_jugodegrunt\dropboxAsubir.json

) else if %directorio%==2 (

    echo pr>_jugodegrunt\dropboxAsubir.txt
	echo {"dropboxAsubir":"pr/**/*.*"}>_jugodegrunt\dropboxAsubir.json

) else (

    echo Selecci¢n inv lida..
    goto PREGUNTADIREC

)

set /p temp_dropboxDirDest=¨Directorio de destino en Dropbox [%dropboxDirDest%]? 

if "%temp_dropboxDirDest%"=="" (

	echo %dropboxDirDest%>_jugodegrunt\dropboxDirDest.txt
	echo {"dropboxDirDest":"%dropboxDirDest%"}>_jugodegrunt\dropboxDirDest.json

) else (

	echo %temp_dropboxDirDest%>_jugodegrunt\dropboxDirDest.txt
	echo {"dropboxDirDest":"%temp_dropboxDirDest%"}>_jugodegrunt\dropboxDirDest.json
)

echo.
pause

:END
endlocal