@echo off
setlocal EnableDelayedExpansion 
rem el EnableDelayedExpansion se utiliza para el efecto de texto verde
set /p gitRepo=<_jugodegrunt\gitRepo.txt
set /p gitRepoRama=<_jugodegrunt\gitRepoRama.txt
set /p gitUUser=<_jugodegrunt\gitUUser.txt
set /p gitUPass=<_jugodegrunt\gitUPass.txt

echo Se configurar  el sistema git del programa seleccionando el repositorio y la rama desde la que se realizar  la clonaci¢n, despu‚s se preguntar  si se quiere cambiar de usuario y en tal caso la contrase¤a.
echo.

:PREGUNTAREPOSITORIO
set /p temp_gitRepo=¨Direcci¢n del repositorio [%gitRepo%]? 

if "%temp_gitRepo%"=="" (

	if "%gitRepo%"=="https://github.com/mirepositorio/miproyecto.git" (

		echo.
		echo El repositorio indicado lo es a modo de ejemplo..
		goto PREGUNTAREPOSITORIO

	) else (

		echo %gitRepo%>_jugodegrunt\gitRepo.txt
		echo {"gitRepo":"%gitRepo%"}>_jugodegrunt\gitRepo.json

	)

) else (

	echo %temp_gitRepo%>_jugodegrunt\gitRepo.txt
	echo {"gitRepo":"%temp_gitRepo%"}>_jugodegrunt\gitRepo.json
)

set /p hayrama=¨vas a definir alguna rama (si se va a clonar desde la rama master o principal no es necesario definir ninguna) (S/[N])? 
if /i "%hayrama%" NEQ "S" goto SINRAMA

set /p temp_gitRepoRama=¨Rama que se utilizara [%gitRepoRama%]? 

if "%temp_gitRepoRama%"=="" (

	echo %gitRepoRama%>_jugodegrunt\gitRepoRama.txt
	echo {"gitRepoRama":"%gitRepoRama%"}>_jugodegrunt\gitRepoRama.json

) else (

	echo %temp_gitRepoRama%>_jugodegrunt\gitRepoRama.txt
	echo {"gitRepoRama":"%temp_gitRepoRama%"}>_jugodegrunt\gitRepoRama.json

)

GOTO USERPASS

:SINRAMA

echo (ninguna)>_jugodegrunt\gitRepoRama.txt
echo {"gitRepoRama":"(ninguna)"}>_jugodegrunt\gitRepoRama.json

:USERPASS

set /p gitRepo=<_jugodegrunt\gitRepo.txt
set gitRepo=%gitRepo:~8%

set /p nuevouser=Si necesitaras subir al repositorio tendras que entrar como un usuario con permiso de escritura en el, ¨accederas como %gitUUser%? si quieres cambiar escribe el nombre sino deja en blanco: 

if "%nuevouser%"=="" (

	if "%gitUUser%"=="el usuario con credencial local" (goto END) else (

	cd de
	echo.
	git remote set-url origin https://%gitUUser%:%gitUPass%@%gitRepo%
	cd..
	echo.

	rem texto de color verde:
	for /F "tokens=1,2 delims=#" %%a in ('"prompt #$H#$E# & echo on & for %%b in (1) do rem"') do (set "DEL=%%a")
	call :ColorText 0A "Si previamente no hab¡a ning£n git en el directorio de Desarrollo habr  dado el error de que el git no existe, no pasa nada, se puede realizar la clonaci¢n y ya se generar  autom ticamente el git en local"
	echo.
	goto END

	) 

) else (

goto NUEVOUSERPASS

)

:NUEVOUSERPASS
set /p nuevopass=Contrase¤a: 

echo %nuevopass%>_jugodegrunt\gitUPass.txt
echo %nuevouser%>_jugodegrunt\gitUUser.txt
echo {"gitUUser":"%nuevouser%"}>_jugodegrunt\gitUUser.json

cd de
echo.
git remote set-url origin https://%nuevouser%:%nuevopass%@%gitRepo%
cd..
echo.

rem texto de color verde:
for /F "tokens=1,2 delims=#" %%a in ('"prompt #$H#$E# & echo on & for %%b in (1) do rem"') do (
  set "DEL=%%a"
)
call :ColorText 0A "Si previamente no hab¡a ning£n git en el directorio de Desarrollo habra dado el error de que el git no existe, no pasa nada, se puede realizar la clonaci¢n y ya se generar  autom ticamente el git en local"
echo.
goto END

rem Para el efecto de texto verde
:ColorText
echo off
<nul set /p ".=%DEL%" > "%~2"
findstr /v /a:%1 /R "^$" "%~2" nul
del "%~2" > nul 2>&1
goto :eof

:END

echo.
pause
endlocal