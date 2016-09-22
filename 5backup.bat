@echo off
setlocal

set /p dbackup=<_jugodegrunt\dbackup.txt

echo Esta operaci¢n realizar  un backup espejo (directorio Desarrollo + "Jugo de Grunt") en el directorio especificado, solo se modificar  aquello que ha variado desde la £ltima vez que se ha realizado un backup a tal directorio.
echo.

set /p temp_dbackup=¨Cual es el directorio de destino (utilizar contrabarra, por ejemplo c:/mibackup) [%dbackup%]? 

if "%temp_dbackup%"=="" (

	echo %dbackup%>_jugodegrunt\dbackup.txt
	echo {"dbackup":"%dbackup%"}>_jugodegrunt\dbackup.json

) else (

	echo %temp_dbackup%>_jugodegrunt\dbackup.txt
	echo {"dbackup":"%temp_dbackup%"}>_jugodegrunt\dbackup.json
)

echo.

set /p dbackup=<_jugodegrunt\dbackup.txt

rem Los siguentes ficheros se borran a mano y luego se copian a mano para evitar tanto errores como mensajes recurrentes

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