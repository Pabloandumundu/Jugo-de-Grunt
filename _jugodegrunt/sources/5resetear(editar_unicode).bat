@echo off
setlocal
echo Atención, se resetearán todos los datos sensibles (direcciones, usuarios y contraseñas) almacenados y utilizados en "Jugo de Grunt".
echo.

set /p estaseguro=¿Quieres Continuar (S/[N])?
if /I "%estaseguro%" NEQ "S" goto END

xcopy "_jugodegrunt\reset" "_jugodegrunt" /E /H /I /Y > nul

echo.
echo Hecho.
pause

:END
endlocal