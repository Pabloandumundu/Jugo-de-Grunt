@echo off
setlocal
echo Esta operación preparará un commit de los últimos cambios.
echo.

set /p estaseguro=¿Quieres Continuar (S/[N])?
if /i "%estaseguro%" NEQ "S" goto END

echo Se le añadirá un comentario al commit que por defecto será "Repository updated on fecha/hora".

set /p modificarcomentario=¿Quieres modificar el comentario (S/[N])?
if /i "%modificarcomentario%" NEQ "S" goto PORDEFECTO

set /p comentario=Introduzca su comentario: 
echo %comentario%>_jugodegrunt\gitRepoCommit.txt
goto COMMENT


:PORDEFECTO
call grunt git3-commit
goto END

:COMMENT
call grunt git3-commitwithcomment

:END
pause
endlocal