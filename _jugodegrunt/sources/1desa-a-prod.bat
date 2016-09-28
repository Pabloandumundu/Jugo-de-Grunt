@echo off
setlocal
echo Se copiar n de Desarrollo ('de') los archivos que no existan o en Producci¢n (pr/) o hayan sido modificados en Desarrollo y se eliminar n de Producci¢n los que no esten en Desarrollo. Se volveran a minificar todos los archivos HTML, CSS y JS de Desarrollo en Producci¢n.
echo.

set /p estaseguro=¨Quieres Continuar (S/[N])?
if /i "%estaseguro%" NEQ "S" goto END

call grunt desa-a-prod

pause

:END
endlocal