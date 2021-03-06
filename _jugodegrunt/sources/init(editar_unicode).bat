@echo off
setlocal EnableDelayedExpansion
rem el EnableDelayedExpansion se utiliza para el efecto de texto verde

echo "        _                       _       _____                  _     "
echo "       | |                     | |     / ____|                | |    "
echo "       | |_   _  __ _  ___   __| | ___| |  __ _ __ _   _ _ __ | |_   "
echo "   _   | | | | |/ _` |/ _ \ / _` |/ _ \ | |_ | '__| | | | '_ \| __|  "
echo "  | |__| | |_| | (_| | (_) | (_| |  __/ |__| | |  | |_| | | | | |_   "
echo "   \____/ \__,_|\__, |\___/ \__,_|\___|\_____|_|   \__,_|_| |_|\__|  "
echo "                 __/ |                                               "
echo "                |___/                                                "
echo.

set /p destino=¿Dónde quiere realizar la instalación (por ejemplo C:\miproyecto)? 

set PATH=%PATH%;%~dp0/7zportable
7z x JdG.rar -o%destino%

echo.
rem texto de color verde:
for /F "tokens=1,2 delims=#" %%a in ('"prompt #$H#$E# & echo on & for %%b in (1) do rem"') do (
  set "DEL=%%a"
)
call :ColorText 0A "Recordar que para que Jugo de Grunt funcione correctamente deberán estar instalados npn y grunt de manera global en este Windows,"
echo.
call :ColorText 0A "Además para aprovechar algunas de sus características (empezando por el menú gráfico) requiere tener instalado algún programa servidor php,"
echo.
call :ColorText 0A "Para utilizar las funcionalidades Git debe de instalarse Git,"
echo.
call :ColorText 0A "Se recomienda el manual en este mismo directorio, donde se concretan de manera sencilla estos pasos"
echo.
echo.
pause
goto END

rem para el efecto de texto verde
:ColorText
echo off
<nul set /p ".=%DEL%" > "%~2"
findstr /v /a:%1 /R "^$" "%~2" nul
del "%~2" > nul 2>&1
goto :eof

:END
echo.

endlocal