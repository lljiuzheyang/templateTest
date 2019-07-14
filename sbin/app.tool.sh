#!/usr/bin/env bash
# Author        :    AlicFeng
# Email         :    a@samego.com
# Description   :    应用shell脚本 用于应用缓存刷新、守护进程重加载、赋予项目正确文件所属权限

function refresh(){
    php artisan config:cache || {
        echo -e "configure reload failed";
        exit 1;
    }
    php artisan route:cache || {
        echo -e "route reload failed";
        exit 1;
    }
    php artisan optimize || {
        echo -e "optimize failed";
        exit 1;
    }
    php artisan queue:restart || {
        echo -e "queue:restart failed"
        exit 1;
    }
}

function supervisor_reload(){
    supervisorctl reload
}
function file_auth() {
    SHELL_FOLDER=$(cd "$(dirname "$0")";pwd)
    chown www:www -R ${SHELL_FOLDER}/../*
    echo "Grant folder authority of www finished"
}


function usage() {
    echo "usage:"
    echo  "app.tool.sh
    -h    help message | 帮助文档
    -s    refresh cache && supervisorctl reload | 刷新应用缓存 以及 重加载守护进程supervisor
    -c    refresh cache | 刷新应用缓存
    -a    grant folder authority of www | 赋予文件所属权限
    -u    refresh cache && supervisorctl reload && grant folder authority of www | 上线后必须执行"
    exit 0
}

while getopts chsau option
do
case ${option} in
    u)
        refresh
        supervisor_reload
        file_auth
        ;;
    a)
        file_auth
        ;;
    s)
        refresh
        supervisor_reload
        ;;
    h)
        usage
        ;;
    c)
        refresh
        ;;
    *)
        usage
        ;;
esac
done