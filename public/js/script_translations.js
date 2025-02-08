/**
 * Carga las traducciones desde el backend de forma asíncrona.
 * Se almacena en una variable global para su uso en toda la app.
 */
let translations = {};

// Obtener la URL base del backend dinámicamente (ajustar para producción)
const API_BASE_URL = window.location.origin;    // Captura la URL del entorno actual
const API_TRANSLATIONS_URL = `${API_BASE_URL}/index.php?r=api_tranlations`;

/**
 * Carga las traducciones desde la API.
 */

async function loadTranslations() {
    try {
        const response = await fetch(API_TRANSLATIONS_URL, {
            method: 'GET',
            headers: {
                'Content-Type': 'no-cache'
            }
        });
        
        if (!response.ok) {
            throw new Error(`Error ${response.status}: ${response.statusText}\nNo se pudieron cargar las traducciones`);
        }

        // Parsear las traducciones y almacenarlas en la variable global
        translations = await response.json();
    } catch (error) {
        console.error('Error al cargar traducciones:', error);
    }
}
