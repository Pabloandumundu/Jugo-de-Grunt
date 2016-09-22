@echo off
setlocal
echo Esta operaci¢n subir  los cambios definidos por los commit que no se hayan subido previamente al repositorio.
echo.

set /p estaseguro=¨Quieres Continuar (S/[N])?
if /i "%estaseguro%" NEQ "S" goto END

call grunt git4-push

pause

:END
endlocal