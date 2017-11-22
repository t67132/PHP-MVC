<?php
namespace Core;

class Controller
{
    /**
     * 載入版型頁面
     * @param string $page
     * @param array $data
     */
    public function show(string $Page, array $Data = null)
    {
        $Url = "Views/".$Page.".php";

        if(file_exists($Url)){
            require_once $Url;
        }
    }
}