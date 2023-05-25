<?php

namespace Order\Controller;

class ViewController
{
    public function getView()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $views = $this->searchDirectory("views") ?? $_ENV['VIEWS'] ?? $_SESSION['VIEWS'] ?? $_COOKIE['VIEWS'] ?? '/';
        $dir = "$views";

        if (!isset($_ENV['HOME_URI'])) $_ENV['HOME_URI'] = "/index";

        if ($uri == "" || $uri == "/") {
            $uri = "/{$_ENV['HOME_URI']}";
        }

        if (file_exists($dir . "$uri.php")) {
            require_once($dir . "$uri.php");
        } else {
            http_response_code(404);
        }
    }

    public function searchDirectory($targetName)
    {
        $directory = "../";
        $dirIterator = new \RecursiveDirectoryIterator($directory);
        $iterator = new \RecursiveIteratorIterator($dirIterator, \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $file) {
            if ($file->isDir() && $file->getFilename() === $targetName) {
                return $file->getPathname();
            }
        }

        return null;
    }
}
