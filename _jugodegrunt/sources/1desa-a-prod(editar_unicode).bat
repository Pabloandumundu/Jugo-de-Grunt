@echo off
setlocal
echo Se copiarán de Desarrollo ('de') los archivos que no existan o en Producción (pr/) o hayan sido modificados en Desarrollo y se eliminarán de Producción los que no esten en Desarrollo. Se volveran a minificar todos los archivos HTML, CSS y JS de Desarrollo en Producción.
echo.

set /p estaseguro=¿Quieres Continuar (S/[N])?
if /i "%estaseguro%" NEQ "S" goto END

call grunt desa-a-prod

pause

:END
endlocal