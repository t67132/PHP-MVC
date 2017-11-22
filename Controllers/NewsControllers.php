<?php
namespace Controllers;

require_once('Core/Controller.php');

use \Core\Controller as Controller;

class NewsControllers extends Controller
{
    public function Index(array $Data = null)
    {
        $this->show('News/Index', $Data);
    }
}