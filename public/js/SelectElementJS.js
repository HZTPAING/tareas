// SelectElementJS.js
class SelectElementJS {
    constructor(id, name, className = '', required = false, multiple = false, showIcon = false) {
        this.id = id;                       // ID del <select>
        this.name = name;                   // Nombre del <select>
        this.className = className;         // Clases CSS del <select>
        this.required = required;           // Si el campo es obligatorio
        this.multiple = multiple;           // Si permite seleccionar multiples opciones
        this.options = [];                  // Lista de opciones
        this.defaultOption = null;          // Opción por defecto
        this.attributes = {};               // Atributos personalizados para el <select>
        this.showIcon = showIcon;           // Si mostrar icono al lado del texto de la opción
    }

    /**
     * Establecer la opción por defecto en el <select>
     * 
     * @param {string} text - Texto visible en la opción por defecto
     * @param {string} value - (Opcional) Valor de la opción por defecto
     */ 
    setDefaultOption(text, value = '') {
        this.defaultOption = { text, value };
    }

    /**
     * Agregar una opcion al <select>
     * 
     * @param {string} value - Valor de la opción
     * @param {string} text - Texto visible en la opcion
     * @param {boolean} selected - Indica si esta opción está  seleccionada por defecto
     * @param {string} iconClass - (Opcional) Class CSS de un icono FontAwesome
     */
    addOption(value, text, selected = false, iconClass = null) {
        this.options.push({ value, text, selected, iconClass });
    }

    /**
     * Agregar atributos personalizados al <select>
     * 
     * @param {string} key - Nombre del atributo
     * @param {string} value - Valor del atributo
     */
    addAttribute(key, value) {
        this.attributes[key] = value;
    }

    /**
     * Renderizar y devolver el HTML del <select>
     * @returns {string} HTML del <select>
     */
    render() {
        let html_select = `<div class="d-flex align-items-center">`;

        // Añadir icono al lado del texto de la opción
        if (this.showIcon) {
            const defaultIconClass = this.options.find(opt => opt.selected)?.iconClass || 'fa-solid fa-circle text-secondary';
            this.addAttribute('data-selected-icon', defaultIconClass);
            html_select += `<span class="input-group-text input-group-text-icono-select me-2" id="ico-estado"><i id="idIcoE" class="${defaultIconClass}"></i></span>`;
        }

        // Iniciar el <select>
        html_select += `<select id="${this.id}" name="${this.name}" class="${this.className}"`;

        if (this.required) html_select += ' required';
        if (this.multiple) html_select += ' multiple';
        
        // Añadir atributos personalizados al <select>
        for (let key in this.attributes) {
            if (this.attributes.hasOwnProperty(key)) {
                html_select += ` ${key}="${this.attributes[key]}"`;
            }
        }

        html_select += '>';

        // Añadir la opcion por defecto
        if (this.defaultOption) {
            html_select += `<option value="${this.defaultOption.value}">${this.defaultOption.text}</option>`;
        }

        // Añadir las opciones dinamicas al <select>
        this.options.forEach(option => {
            const selected = option.selected ? 'selected' : '';

            html_select += `
                <option 
                    value="${option.value}" ${selected} 
                    data-icon-class="${option.iconClass || ''}"
                >
                    ${option.text}
                </option>
            `;
        });

        html_select += '</select>';

        return html_select;
    }

    /**
     * Metodo para actualizar dinamicamente el icono externo cuando se selecciona una opción
     */
    attachChangeEvent() {
        document.addEventListener('change', (event) => {
            // Verificar si el evento se disparo en el <select> correspondiente
            if (event.target && event.target.id === this.id) {
                const selectElement = event.target;
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const iconClass = selectedOption.getAttribute("data-icon-class") || 'fa-solid-circle text-secondary';
                
                // Actualizar atributo en el select (para falicitar debugging)
                selectElement.setAttribute('data-selected-icon', iconClass);
                
                // Cambiar el icono dinamicamente
                const iconElement = document.getElementById('idIcoE');
                if (iconElement) {
                    iconElement.className = iconClass;
                }
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const selectElement = document.getElementById(this.id);
            if (selectElement) {
                // Disparar el evento de cambio para establecer el icono inicial
                selectElement.dispatchEvent(new Event('change'));
            }
        });
    }
}

// Exportar la clase para usarla en otros archivos JS
export default SelectElementJS;
