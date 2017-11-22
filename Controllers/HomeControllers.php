<?php
namespace Controllers;

require_once('Core/Controller.php');

use \Core\Controller as Controller;

class HomeControllers extends Controller
{
    public function Index(array $Data = null)
    {
        $this->show('Home/Index', $Data);
    }
}