# Plan de Implementación: TAREA 8 — ACF: Estructura para Q1

Este documento detalla los pasos técnicos para la creación del grupo de campos ACF destinado a la gestión de módulos de la primera quincena (Q1) en el CPT "Panel".

## 1. Configuración del Grupo de Campos
- **Nombre del Grupo:** Panel – Q1 (Primera quincena)
- **Reglas de Ubicación:** Post Type es igual a `panel`
- **Ajustes de Interfaz:**
    - Posición: Normal (debajo del editor)
    - Estilo: Seamless (sin caja de WordPress)
    - Etiqueta: Superior

## 2. Estructura del Repeater
Se creará un campo de tipo **Repeater** con el slug `q1_modules`.

### Campos Base (Dentro del Repeater)
| Etiqueta | Nombre (Slug) | Tipo | Instrucciones |
| :--- | :--- | :--- | :--- |
| Tipo de módulo | `module_type` | Select | Selecciona el tipo de contenido. |
| Fecha/hora de desbloqueo | `unlock_date` | Date Time Picker | Cuándo será visible este módulo. |
| Orden | `order` | Number | Prioridad de visualización. |

**Opciones del Select (`module_type`):**
- `video_sumario` : Vídeo sumario
- `video_entrevista` : Vídeo entrevista
- `quote` : Quote
- `grafico` : Gráfico
- `dato` : Dato cualitativo
- `articulo` : Artículo

## 3. Campos Condicionales (Lógica de Visibilidad)
Cada conjunto de campos se mostrará solo si el `module_type` coincide.

### A. Vídeo Sumario / Vídeo Entrevista
*Se muestran si `module_type` es `video_sumario` o `video_entrevista`.*
- **Título:** `video_title` (Text)
- **URL YouTube:** `video_url` (Url)

### B. Quote
*Se muestra si `module_type` es `quote`.*
- **Texto:** `quote_text` (Textarea)
- **Autor:** `quote_author` (Text) - *Opcional*

### C. Gráfico
*Se muestra si `module_type` es `grafico`.*
- **Imagen:** `graphic_image` (Image) - *Retorno: ID o URL según preferencia de dev*
- **Texto:** `graphic_text` (Text) - *Opcional*

### D. Dato Cualitativo
*Se muestra si `module_type` es `dato`.*
- **Valor:** `data_value` (Text) - *Ej: 85% o "Excelente"*
- **Texto:** `data_label` (Text) - *Descripción del dato*

### E. Artículo
*Se muestra si `module_type` es `articulo`.*
- **Título:** `article_title` (Text)
- **Extracto:** `article_excerpt` (Textarea)
- **Cuerpo HTML:** `article_content` (WYSIWYG Editor)

## 4. Optimización de UI para Marketing
Para asegurar que la interfaz sea clara:
- Utilizar **Layout: Block** en el Repeater para que cada fila sea legible.
- Añadir **Instrucciones** claras en cada campo.
- Configurar el **Button Label** del Repeater como "Añadir Módulo Q1".
- Usar **Campos de Mensaje** o **Acordeones** si la lista de campos condicionales crece demasiado (opcional).

## 5. Criterios de Aceptación y Pruebas
1. [ ] El usuario puede añadir múltiples filas al repeater.
2. [ ] Al cambiar el "Tipo de módulo", los campos inferiores cambian instantáneamente.
3. [ ] El selector de fecha permite elegir día y hora con precisión.
4. [ ] Los datos se guardan correctamente al actualizar el post tipo "Panel".
5. [ ] La interfaz no presenta solapamientos ni confusión visual.
