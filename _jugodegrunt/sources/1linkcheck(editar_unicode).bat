@echo off
setlocal
echo Se revisará el proyecto del directorio de Desarrollo para ver si tiene enlaces rotos.
echo Atención, será necesario tener el servidor de Desarrollo en marcha.
echo.

set /p estaseguro=¿Quieres Continuar (S/[N])?
IF /I "%estaseguro%" NEQ "S" goto END

call grunt link --force

pause

:END
endlocal