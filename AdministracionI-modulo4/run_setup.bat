@echo off
cd /d "d:\Modulo-4\AdministracionI-modulo4"
echo Ejecutando setup_initial_data.php...
php setup_initial_data.php
echo.
echo Verificando datos creados...
php check_data.php
pause
