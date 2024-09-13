<?php
namespace sts\cli;

class TemplateRenderer
{
    public function renderTemplate(string $templatePath, array $variables): string
    {
        if (!file_exists($templatePath)) {
            throw new \Exception("Șablonul nu a fost găsit la calea: $templatePath");
        }

        $content = file_get_contents($templatePath);

        foreach ($variables as $key => $value) {
            $content = str_replace("{{{$key}}}", $value, $content);
        }

        return $content;
    }
}
