<?php

     /**
     * Controller class for creating view object and model object 
     * @param  [string]   page name
     * @return [object]   view object
     */
class Controller
{

    public function __construct()
    {

        $this->responseapi = new Responseapi();
    }

     /**
     * Creating requierd model object
     * @param  [string]   model name
     * @return [object]   required model object
     */

    public function loadModel($name)
    {
        $path = 'models/' . $name . '_model.php';
        if (file_exists($path)) {
            require $path;
            $modelName   = $name . '_Model';
            $this->model = new $modelName();
        } else {
            return false;
        }
    }
    
}
