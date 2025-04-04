<?php
    // Obtener el servicio de traducción desde el contenedor global
    global $container;
    $translator = $container['translator'];
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars(APP_LOCALE);   // Usar APP_LOCALE para el idioma ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($translator->trans('APP_TITULO'));   // Título dinámico ?></title>
    
    <!-- CARGA DE CSS EXTERNOS -->
    <!-- DataTables CSS -->
    <link 
        href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" 
        rel="stylesheet" 
        type="text/css"
    />
    
    <!-- Font Awesome CSS -->
    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer"
    />
    
    <!-- jQuery UI CSS -->
    <link 
        rel="stylesheet" 
        href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css"
    />
    
    <!-- Bootstrap CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
        crossorigin="anonymous"
    />

    <!-- CARGA DE CSS PERSONALIZADO -->
    <link rel="stylesheet" href="<?= BASE_URL . DIRECTORY_SEPARATOR .  'public' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'tareas_style.css'; ?>">
    <link rel="stylesheet" href="<?= BASE_URL . DIRECTORY_SEPARATOR .  'public' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'tareas_container.css'; ?>">    
    <link rel="stylesheet" href="<?= BASE_URL . DIRECTORY_SEPARATOR .  'public' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'script_alert.css'; ?>">
    <link rel="stylesheet" href="<?= BASE_URL . DIRECTORY_SEPARATOR .  'public' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'styles.css';?>">
    
    <!-- CARGA DE JS EXTERNOS -->
    <!-- jQuery -->
    <script 
        src="https://code.jquery.com/jquery-3.7.1.js">
    </script>
    
    <!-- jQuery UI -->
    <script 
        src="https://code.jquery.com/ui/1.13.3/jquery-ui.js">
    </script>
    
    <!-- DataTables JS -->
    <script 
        src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js">
    </script>

    <!-- === Scripts de la aplicación === -->
    <!-- Scripts específicos para la página de tareas -->
    <script src="<?= BASE_URL . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'script_translations.js'; ?>"></script>
</head>

<body>