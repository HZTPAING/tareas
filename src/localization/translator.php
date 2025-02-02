<?php

namespace Hztpaing\Tareas\localization;

class Translator
{
    private $locale;
    private $translations = [];

    public function __construct($locale = 'es')
    {
        $this->locale = $locale;
        $this->loadTranslations();
    }

    private function loadTranslations(): void
    {
        $filePath = BASE_PATH . DIRECTORY_SEPARATOR . 'locales' . DIRECTORY_SEPARATOR . $this->locale . DIRECTORY_SEPARATOR . 'messages.php';
        if (file_exists($filePath)) {
            $this->translations = include $filePath;
        } else {
            throw new \Exception("Archivo de traducción no encontrado: $filePath");
        }
    }

    public function trans($key)
    {
        return $this->translations[$key] ?? $key;
    }
}
