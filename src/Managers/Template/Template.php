<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\Template;

use Marussia\HttpKernel\App as App;
use Marussia\DependencyInjection\Container as Container;
use Marussia\Template\Template as TemplateHandler;

class Template
{
    private $template;
    
    public function __construct()
    {
        $container = new Container;
        
        $this->template = $container->instance(TemplateHandler::class, [ROOT . '/public/template/']);
    }

    public function data(array $data)
    {
        foreach ($data as $name => $content) {
            $this->template->$name = $content;
        }
    }
    
    public function render()
    {
        $view = $this->template->render();

        App::event('App.Template', 'RenderReady', $view);
    }
}
