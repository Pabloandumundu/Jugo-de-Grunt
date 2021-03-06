@echo off
setlocal
set /p sitemapWeb=<_jugodegrunt\sitemapWeb.txt

echo Se creará un fichero sitemap.xml con el contenido del directorio de Desarrollo, el fichero se guardará dentro del mismo directorio.
echo.

:PREGUNTASITIO
set /p temp_sitemapWeb=¿A que dirección web raíz estaran asociados los archivos [%sitemapWeb%]? 

if "%temp_sitemapWeb%"=="" (

	if "%sitemapWeb%"=="misitioweb.es" (

		echo.
		echo misitioweb.es es un ejemplo, debería de introducir una dirección válida
		goto PREGUNTASITIO

	) else (

		echo %sitemapWeb%>_jugodegrunt\sitemapWeb.txt
		echo {"sitemapWeb":"%sitemapWeb%"}>_jugodegrunt\sitemapWeb.json
	)

) else (

	echo %temp_sitemapWeb%>_jugodegrunt\sitemapWeb.txt
	echo {"sitemapWeb":"%temp_sitemapWeb%"}>_jugodegrunt\sitemapWeb.json
)

call grunt sitemap

rem se eliminan las lineas con los parametros <changefreq> y <priority>
cd de
type sitemap.xml | findstr /v changefreq | findstr /v priority > sitemap-temp.xml
del sitemap.xml
ren sitemap-temp.xml sitemap.xml
cd ..

pause

:END
endlocal