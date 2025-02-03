<?php
class Autoloader{
    public static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    public static function autoload($class){
        $class = str_replace('\\', '', $class);
        $file= __DIR__ . '/' . $class . '.php';
        if(file_exists($file)){
            require $file;
        } else{
            throw new Exception("Le fichier $file n'est pas trouver");
        }
    }
}
?>