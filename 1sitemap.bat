@echo off
setlocal
set /p sitemapWeb=<_jugodegrunt\sitemapWeb.txt

echo Se crear  un fichero sitemap.xml con el contenido del directorio de Desarrollo, el fichero se guardar  dentro del mismo directorio.
echo.

:PREGUNTASITIO
set /p temp_sitemapWeb=¨A que direcci¢n web ra¡z estaran asociados los archivos [%sitemapWeb%]? 

if "%temp_sitemapWeb%"=="" (

	if "%sitemapWeb%"=="misitioweb.es" (

		echo.
		echo misitioweb.es es un ejemplo, deber¡a de introducir una direcci¢n v lida
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