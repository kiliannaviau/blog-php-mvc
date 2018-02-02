<?php

namespace TestProject\Engine;

class Router
{
    public static function run (array $aParams)
    {
        $sNamespace = 'BlogPhp\Controller\\';
        $sDefCtrl = $sNamespace . 'Blog';
        $sCtrlPath = ROOT_PATH . 'Controller/';
        $sCtrl = ucfirst($aParams['ctrl']);

        if (is_file($sCtrlPath . $sCtrl . '.php'))
        {
            $sCtrl = $sNamespace . $sCtrl;
            $oCtrl = new $sCtrl;

            // La classe ReflectionClass rapporte des informations sur une classe.
            // La classe ReflectionMethod rapporte des informations sur une méthode.
            // call_user_func : Appelle une fonction de rappel callback fournie par le paramètre callback où les autres arguments seront passés en paramètre. 
            if ((new \ReflectionClass($oCtrl))->hasMethod($aParams['act']) && (new \ReflectionMethod($oCtrl, $aParams['act']))->isPublic())
                call_user_func(array($oCtrl, $aParams['act']));
            else
                call_user_func(array($oCtrl, 'notFound'));
        }
        else
        {
            call_user_func(array(new $sDefCtrl, 'notFound'));
        }
    }
}
