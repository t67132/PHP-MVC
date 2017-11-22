<?php
/**
 * Apache conf/httpd open LoadModule rewrite_module modules/mod_rewrite.so
 */
namespace Core;

use Exception;

use \Controllers;

//use \Controllers\HomeControllers;

//控制器名稱 預設Home
define('G_ROUTE_CONTROLLERS', 'Home');
//方法名稱 預設Index
define('G_ROUTE_METHOD', 'Index');

class RecException extends Exception
{
    /**
     * 錯誤頁面載入
     * @param $msg
     */
    public static function Error(string $msg = null)
    {
        $err_dir = 'Views/Error/Index.php';

        if(file_exists($err_dir)){
            require $err_dir;
        }
    }
}

/**
 * 路由器配置
 */
class RouteConfig extends RecException
{
    //控制器名稱
    protected static $ControllersName = G_ROUTE_CONTROLLERS.'Controllers';
    //方法名稱
    protected static $MethodName = G_ROUTE_METHOD;
    //其他參數
    protected static $Paramet = array();

    /**
     * 註冊路由器
     * @throws Exception
     */
    public static function RegisterRoutes()
    {
        self::RoutesUrl();

        $Url = 'Controllers/'.self::$ControllersName.'.php';
        if(file_exists($Url)){
            //New Class Error
            $Controllers = new self::$ControllersName;
        }else{
            RecException::Error('控制器不存在');
        }
        self::$MethodName = (!empty(self::$MethodName)) ? self::$MethodName : G_ROUTE_METHOD;

        //檢查方法
        if(method_exists($Controllers, self::$MethodName)){
            $Method = self::$MethodName;
            $NewParamet = array();
            $ParametNum = (!empty(self::$Paramet[0])) ? count(self::$Paramet) : 0;
            if($ParametNum > 0){
                if($ParametNum % 2 == 0){
                    for($i = 0; $i < $ParametNum; $i += 2){
                        $NewParamet[self::$Paramet[$i]] = self::$Paramet[$i+1];
                    }
                }else{
                    RecException::Error('非法參數!');
                }
            }
            $Controllers->$Method($NewParamet);
        }else{
            RecException::Error('路徑不存在!');
        }
    }

    /**
     * 路由器網址檢查
     */
    private static function RoutesUrl()
    {
        if(isset($_GET['Url'])){
            $Url = explode('/', $_GET['Url']);

            if(isset($Url[0])){
                self::$ControllersName = $Url[0];
                unset($Url[0]);
            }

            if(isset($Url[1])){
                self::$MethodName = $Url[1];
                unset($Url[1]);
            }

            if(isset($Url)){
                self::$Paramet = array_values($Url);
            }
        }
    }

    /**
     * 自動載入
     * @param $ClassName
     * @throws Exception
     */
    public static function AutoLoader(string $ClassName = null)
    {
        //控制器目錄
        $Controllers = 'Controllers/'.$ClassName.'.php';

        //模型目錄
        $Models = 'Models/'.$ClassName.'.php';

        //核心目錄
        $Core = 'Core/'.$ClassName.'.php';

        if(file_exists($Controllers)){
            require_once $Controllers;
        }else if(file_exists($Models)){
            require_once $Models;
        }else if(file_exists($Core)){
            require_once $Core;
        }else{
            RecException::Error('類別文件不存在');
        }
    }
}