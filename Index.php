<?php
echo "<meta charset='utf-8'>";
require_once ('Core/RouteConfig.php');
use \Core\RouteConfig as RouteConfig;

//自動載入
spl_autoload_register(array('Core\RouteConfig', 'AutoLoader'));

try
{
    RouteConfig::RegisterRoutes();
}catch(RecException $e){
    $e->Error(($e->getMessage()));
}