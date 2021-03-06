@echo off
setlocal
set /p gitRepo=<_jugodegrunt/gitRepo.txt
set /p gitRepoRama=<_jugodegrunt/gitRepoRama.txt
set /p tienerama=<_jugodegrunt/gitRepoRama.json

if "%tienerama%"=="{"gitRepoRama":"(ninguna)"}" (
	goto SINRAMA
	)

if %gitRepo%==https://github.com/usuario/repositorio.git goto AVISOCONFIG

:CONRAMA
echo Esta operación clonará (bajará) el repositorio %gitRepo% (branch: %gitRepoRama%) en la carpeta de desarrollo ‘de’. La carpeta deberá estar vacía.
echo.

set /P estaseguro=¿Quieres Continuar (S/[N])?
if /i "%estaseguro%" NEQ "S" goto END

call grunt git1-clonar

pause

goto END

:SINRAMA
echo Esta operación clonará (bajará) el repositorio %gitRepo% (sin rama definida) en la carpeta de desarrollo ‘de’. La carpeta deberá estar vacía.
echo.

set /p estaseguro=¿Quieres Continuar (S/[N])?
if /i "%estaseguro%" NEQ "S" goto END

call grunt git1-clonarsinrama

pause

goto END

:AVISOCONFIG
echo Todavía no se ha seleccionado ningun repositorio desde el que clonar.

set /p DESEACONFIGURAR=¿Quieres configurar el repositorio (S/[N])?
if /i "%DESEACONFIGURAR%" NEQ "S" goto END

cls
call 2git-configurar.bat

:END
endlocal