# ANEXO: Siguientes Pasos tras la Configuración de ACF (Q1, Q2 y Campos)

Una vez finalizada la implementación de las estructuras de datos en ACF (Tareas 8, 9 y 10), el flujo de trabajo debe avanzar hacia la integración y visualización. Estos son los pasos recomendados:

## 1. Carga de Datos de Prueba (QA Interno)
- **Objetivo:** Verificar que la interfaz es robusta.
- **Acción:** Crear un post de tipo "Panel" y completar al menos un módulo de cada tipo tanto en Q1 como en Q2.
- **Validación:** Comprobar que la lógica condicional no falla y que todos los campos (especialmente los WYSIWYG e imágenes) guardan la información correctamente.

## 2. Desarrollo del Frontend (Maquetación de Módulos)
- **Objetivo:** Renderizar los datos en la web.
- **Acción:** Crear componentes Blade/PHP para cada tipo de módulo:
    - `components/modules/video.php`
    - `components/modules/quote.php`
    - `components/modules/graphic.php`
    - `components/modules/data.php`
    - `components/modules/article.php`
- **Estilos:** Aplicar CSS/SCSS específico para que cada módulo sea distinguible visualmente según el diseño.

## 3. Implementación de la Lógica de Desbloqueo
- **Objetivo:** Respetar el campo `unlock_date`.
- **Acción:** En el loop del frontend, añadir una validación de fecha:
    ```php
    $now = current_time('timestamp');
    $unlock_time = strtotime(get_sub_field('unlock_date'));

    if ($now >= $unlock_time) {
        // Renderizar módulo
    } else {
        // Mostrar estado "Próximamente" o simplemente ocultar
    }
    ```

## 4. Optimización de Rendimiento
- **Objetivo:** Evitar carga lenta por exceso de imágenes o vídeos.
- **Acción:** Implementar Lazy Load para los embeds de YouTube y optimizar el tamaño de las imágenes cargadas en el campo "Gráfico".

## 5. Formación a Marketing
- **Objetivo:** Autonomía total del cliente.
- **Acción:** Breve sesión o manual de usuario explicando:
    - Cómo añadir/quitar módulos.
    - Cómo funciona el orden de arrastrar y soltar.
    - Importancia de la fecha de desbloqueo para la automatización del panel.

## 6. Paso a Producción
- **Objetivo:** Despliegue seguro.
- **Acción:** Sincronizar los JSON de ACF (si se usa la prestación de local JSON) o importar el XML del grupo de campos en el entorno de producción.
