<?php
/**
 * 
 */
class Bootstrap {

    public function __construct() {
        $flag = false;

        // 1. router
        if(!empty($_GET['path'])) {
            $tokens = explode('/', rtrim($_GET['path'], '/'));

            // 2. dispatcher
            $controllerName = ucfirst(array_shift($tokens));

            if (file_exists('Controllers/' . $controllerName . '.php')) {
                $controller = new $controllerName();
                // run an action
                if (!empty($tokens)) {
                    $actionName = array_shift($tokens);
                    if (method_exists($controller, $actionName)) {
                        // passing parameters if exists or null if not
                        $controller->{$actionName}(@$tokens);
                    } else {
                        // if action not found error page
                        $flag = true;
                    }

                } else {
                    //default action index
                    $controller->index();
                }
            } else {
                // if controller not found render an error page
                $flag = true;
            }
        } else {

            /**
             * Since the messages controller is the only available, set as default.
             */
            $controllerName = 'Messages';
            $controller = new $controllerName();
            $controller->index();
        }

        // Error page
        if ($flag) {
            $controllerName = 'Status404';
            $controller = new $controllerName();
            $controller->index();
        }
    }
}