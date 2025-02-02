<?php
    // Obtener las instancias necesarias desde el contenedor
    global $container;
    $translator = $container['translator']; // Servicio de traducción
    $htmlHelper = $container['htmlHelper']; // Servicio para generar HTML dinámico
?>

<!-- Sección principal del formulario de acceso -->
<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <!-- Título del formulario -->
            <h5 class="mb-4 text-center">
                <?= htmlspecialchars($translator->trans('APP_LOGIN_FORM'), ENT_QUOTES, 'UTF-8'); // Título dinámico traducido ?>
            </h5>

            <!-- Formulario de acceso -->
            <form 
                class="form-control shadow p-4" 
                method="post" 
                action="<?= htmlspecialchars(BASE_URL . DIRECTORY_SEPARATOR . 'index.php', ENT_QUOTES, 'UTF-8'); ?>"
            >
                <!-- Campo oculto para mantener la ruta 'r=login' -->
                <input type="hidden" name="r" value="login" />

                <!-- Campo de correo electrónico -->
                <div class="mb-3">
                    <label for="user" class="form-label">
                        <?= htmlspecialchars($translator->trans('APP_EMAIL'), ENT_QUOTES, 'UTF-8'); // Etiqueta para el campo email ?>
                    </label>
                    <input 
                        type="email" 
                        id="user" 
                        name="user" 
                        class="form-control"
                        placeholder="<?= htmlspecialchars($translator->trans('APP_PLACEHOLDER_EMAIL'), ENT_QUOTES, 'UTF-8'); ?>" 
                        minlength="5" 
                        maxlength="150" 
                        required 
                    />
                </div>

                <!-- Campo de contraseña -->
                <div class="mb-3">
                    <label for="pass" class="form-label">
                        <?= htmlspecialchars($translator->trans('APP_PASSWORD'), ENT_QUOTES, 'UTF-8'); // Etiqueta para el campo contraseña ?>
                    </label>
                    <input 
                        type="password" 
                        id="pass" 
                        name="pass" 
                        class="form-control"
                        placeholder="<?= htmlspecialchars($translator->trans('APP_PLACEHOLDER_PASSWORD'), ENT_QUOTES, 'UTF-8'); ?>" 
                        minlength="5" 
                        maxlength="30" 
                        required 
                    />
                </div>
                
                <!-- Campo oculto para identificar la acción -->
                <input type="hidden" name="action" value="FORM_LOGIN" />
                
                <!-- Botones del formulario -->
                <div class="d-flex justify-content-between">
                    <!-- Botón para enviar los datos del formulario -->
                    <button class="btn btn-primary" type="submit">
                        <?= htmlspecialchars($translator->trans('APP_LOGIN_BUTTON'), ENT_QUOTES, 'UTF-8'); // Botón de iniciar sesión ?>
                    </button>
                    <button class="btn btn-danger" type="reset">
                        <?= htmlspecialchars($translator->trans('APP_RESET_BUTTON'), ENT_QUOTES, 'UTF-8'); // Botón de reinicio ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- <script src="../assects/js/login.js"></script> -->
