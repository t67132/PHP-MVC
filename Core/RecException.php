<?php
namespace Core;

use Exception;

class RecException extends Exception
{
    /**
     * 錯誤頁面載入
     * @param $Msg
     */
    public function Error(string $Msg = null)
    {
        $Error = 'Views/Error/Index.php';

        if(file_exists($Error)){
            require $Error;
        }
    }
}

?>