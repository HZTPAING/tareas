<?php
    namespace Hztpaing\Tareas\src\helpers;

    use Hztpaing\Tareas\src\localization\Translator;

    class ApiHelper {
        private Translator $translator;

        public function __construct() {
            global $container;
            $this->translator = $container['translator'];
        }

        public function handleApiTranslations(): void {
            // Obtener el idioma actual desde la sesión (o usar el predeterminado)
            $locale = APP_LOCALE;

            // Definir la ruta del archivo de traducciones
            $translationFile = BASE_PATH . DIRECTORY_SEPARATOR . 'locales' . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . 'messages.php';

            // Cargar traducciones si el archivo existe
            if (file_exists($translationFile)) {
                $translations = include $translationFile;
            } else {
                $translations = ['error' => 'Archivo de traducción ' . $translationFile . ' no encontrado'];
            }

            // Enviar la respuesta JSON
            header('Content-Type: application/json');
            echo json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            exit();
        }
    }