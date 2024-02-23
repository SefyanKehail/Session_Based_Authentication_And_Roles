<?php

namespace App;

class View
{
    public function __construct(
    )
    {
    }

    public function render(string $path, array $params): string
    {
        $viewPath = VIEWS_PATH . '/' . $path;

        if (! file_exists($viewPath)) {
            throw new \Exception("View $viewPath not found");
        }

        foreach($params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include $viewPath;

        return (string) ob_get_contents();
    }
}