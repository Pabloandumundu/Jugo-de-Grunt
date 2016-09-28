@echo off
setlocal

set /p dbackup=<_jugodegrunt\dbackup.txt

echo Esta operaci¢n realizar  un backup espejo (directorio Desarrollo + "Jugo de Grunt") en el directorio especificado, solo se modificar  aquello que ha variado desde la £ltima vez que se ha realizado un backup a tal directorio.


:PREGUNTA
echo.
set temp_dbackup=
set /p temp_dbackup=¨Cu l es el directorio de destino (por ejemplo C:\mibackup) [%dbackup%]? 

if "%temp_dbackup%"=="" (

	echo %dbackup%>_jugodegrunt\dbackup.txt
	echo {"dbackup":"%dbackup:\=/%"}>_jugodegrunt\dbackup.json
	GOTO EJECUCION

) else (

	goto CARACTERES
	
)

:CARACTERES

echo.

If NOT "%temp_dbackup%"=="%temp_dbackup:)=%" (

	echo Lo sentimos, no se puede utilizar "cerrar par‚ntesis" en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else If NOT "%temp_dbackup%"=="%temp_dbackup: =%" ( 


	echo Lo sentimos, no se pueden utilizar tildes en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else If NOT "%temp_dbackup%"=="%temp_dbackup:µ=%" ( 

	echo Lo sentimos, no se pueden utilizar tildes en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else If NOT "%temp_dbackup%"=="%temp_dbackup:‚=%" ( 

	echo Lo sentimos, no se pueden utilizar tildes en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else If NOT "%temp_dbackup%"=="%temp_dbackup:=%" ( 

	echo Lo sentimos, no se pueden utilizar tildes en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else If NOT "%temp_dbackup%"=="%temp_dbackup:¡=%" ( 


	echo Lo sentimos, no se pueden utilizar tildes en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else If NOT "%temp_dbackup%"=="%temp_dbackup:Ö=%" ( 

	echo Lo sentimos, no se pueden utilizar tildes en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else If NOT "%temp_dbackup%"=="%temp_dbackup:¢=%" ( 

	echo Lo sentimos, no se pueden utilizar tildes en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else If NOT "%temp_dbackup%"=="%temp_dbackup:à=%" ( 

	echo Lo sentimos, no se pueden utilizar tildes en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else If NOT "%temp_dbackup%"=="%temp_dbackup:£=%" ( 

	echo Lo sentimos, no se pueden utilizar tildes en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else If NOT "%temp_dbackup%"=="%temp_dbackup:é=%" ( 

	echo Lo sentimos, no se pueden utilizar tildes en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else If NOT "%temp_dbackup%"=="%temp_dbackup:¤=%" ( 

	echo Lo sentimos, no se pueden utilizar "¤" en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else If NOT "%temp_dbackup%"=="%temp_dbackup:¥=%" ( 

	echo Lo sentimos, no se pueden utilizar "¥" en el directorio destino, utilice otro nombre.
	goto PREGUNTA

) else (

	echo %temp_dbackup%>_jugodegrunt\dbackup.txt
	echo {"dbackup":"%temp_dbackup:\=/%"}>_jugodegrunt\dbackup.json
	goto EJECUCION

)

:EJECUCION

set /p dbackup=<_jugodegrunt\dbackup.txt

rem Los siguentes ficheros se borran a mano y luego se copian a mano para evitar tanto errores como mensajes recurrentes


if exist "%dbackup%\node_modules\.bin" (
	del "%dbackup%\node_modules\.bin" /F /Q
	rd "%dbackup%\node_modules\.bin" /S /Q
)

if exist "%dbackup%\.grunt" (
	del "%dbackup%\.grunt" /F /Q
	rd "%dbackup%\.grunt" /S /Q
)
if exist "%dbackup%\de\.git" (
	del "%dbackup%\de\.git" /F /Q
	rd "%dbackup%\de\.git" /S /Q
)
if exist "%dbackup%\3git-configurar.bat" (
	del "%dbackup%\3git-configurar.bat"
)
if exist "%dbackup%\_jugodegrunt\sources\3git-configurar.bat" (
	del "%dbackup%\_jugodegrunt\sources\3git-configurar.bat"
)
if exist "%dbackup%\_jugodegrunt\sources\3git-configurar(editar_unicode).bat" (
	del "%dbackup%\_jugodegrunt\sources\3git-configurar(editar_unicode).bat"
)
if exist "%dbackup%\_jugodegrunt\dbackup.txt" (
	del "%dbackup%\_jugodegrunt\dbackup.txt"
)
if exist "%dbackup%\_jugodegrunt\dbackup.json" (
	del "%dbackup%\_jugodegrunt\dbackup.json"
)
if exist "%dbackup%\pr" (
	rd "%dbackup%\pr" /S /Q
)


call grunt backup

if exist "node_modules\.bin" (xcopy ".grunt" "%dbackup%\node_modules\.bin" /E /H /I /Y > nul)
if exist ".grunt" (xcopy ".grunt" "%dbackup%\.grunt" /E /H /I /Y > nul)
if exist "de\.git" (xcopy "de\.git" "%dbackup%\de\.git" /E /H /I /Y > nul)
xcopy "3git-configurar.bat" "%dbackup%\3git-configurar.bat*" /Y > nul
xcopy "_jugodegrunt\sources\3git-configurar.bat" "%dbackup%\_jugodegrunt\sources\3git-configurar.bat*" /Y > nul
xcopy "_jugodegrunt\sources\3git-configurar(editar_unicode).bat" "%dbackup%\_jugodegrunt\sources\3git-configurar(editar_unicode).bat*" /Y > nul
xcopy "_jugodegrunt\dbackup.txt" "%dbackup%\_jugodegrunt\dbackup.txt*" /Y > nul
xcopy "_jugodegrunt\dbackup.json" "%dbackup%\_jugodegrunt\dbackup.json*" /Y > nul
md "%dbackup%\pr"

pause

:END
endlocal