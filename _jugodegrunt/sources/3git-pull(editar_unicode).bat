@echo off
setlocal
echo Esta operación comprobará si hay cambios en el repositorio y, si es el caso, los bajará.
echo.

set /p estaseguro=¿Quieres Continuar (S/[N])?
if /i "%estaseguro%" NEQ "S" goto END

call grunt git2-pull

pause

:END
endlocal