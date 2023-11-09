@echo off
# 启动admin服务
start cmd /k "cd /d admin && php artisan serve --port=8088"
# 启动front服务
start cmd /k "cd /d front && npm run dev"
start cmd /k "cd /d admin"
