@echo off
cd /d "%~dp0"
start cmd /k "php artisan serve"
timeout /t 2 >nul
start cmd /k "npm run dev"
