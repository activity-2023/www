<?php
declare(strict_types=1);

namespace Core\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

abstract  class AbstractController {
    private const TEMPLATES_DIR = __DIR__.'/../../templates/';
    private const LAYOUT_PATH = self::TEMPLATES_DIR.'layout/layout.php';

    public function render(string $template  ):string{
        $templatePath = self::TEMPLATES_DIR.$template.'.php';
        ob_start();
        include ($templatePath);
        $content = ob_get_clean();
        ob_start();
        include (self::LAYOUT_PATH);
        return ob_get_clean();
    }

    public abstract function index(Request $request, Response $response): Response;


}
