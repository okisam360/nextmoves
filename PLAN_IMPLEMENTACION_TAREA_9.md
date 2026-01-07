# Plan de Implementación: TAREA 9 — ACF: Estructura para Q2

Este documento detalla los pasos técnicos para la creación del grupo de campos ACF destinado a la gestión de módulos de la segunda quincena (Q2) en el CPT "Panel", manteniendo la consistencia con la estructura de Q1.

## 1. Configuración del Grupo de Campos
- **Nombre del Grupo:** Panel – Q2 (Segunda quincena)
- **Reglas de Ubicación:** Post Type es igual a `panel`
- **Ajustes de Interfaz:**
    - Posición: Normal (debajo del editor, preferiblemente después de Q1)
    - Estilo: Seamless
    - Etiqueta: Superior

## 2. Estructura del Repeater
Se creará un campo de tipo **Repeater** con el slug `q2_modules`.

### Campos Base (Dentro del Repeater)
| Etiqueta | Nombre (Slug) | Tipo | Instrucciones |
| :--- | :--- | :--- | :--- |
| Tipo de módulo | `module_type` | Select | Selecciona el tipo de contenido para Q2. |
| Fecha/hora de desbloqueo | `unlock_date` | Date Time Picker | Cuándo será visible este módulo de la segunda quincena. |
| Orden | `order` | Number | Prioridad de visualización dentro de Q2. |

**Opciones del Select (`module_type`):**
- `video_sumario` : Vídeo sumario
- `video_entrevista` : Vídeo entrevista
- `quote` : Quote
- `grafico` : Gráfico
- `dato` : Dato cualitativo
- `articulo` : Artículo

## 3. Campos Condicionales (Lógica de Visibilidad)
*Nota: Se recomienda usar los mismos slugs internos que en Q1 para facilitar el desarrollo del frontend, ya que están contenidos dentro del repeater `q2_modules`.*

### A. Vídeo Sumario / Vídeo Entrevista
- **Título:** `video_title` (Text)
- **URL YouTube:** `video_url` (Url)

### B. Quote
- **Texto:** `quote_text` (Textarea)
- **Autor:** `quote_author` (Text)

### C. Gráfico
- **Imagen:** `graphic_image` (Image)
- **Texto:** `graphic_text` (Text)

### D. Dato Cualitativo
- **Valor:** `data_value` (Text)
- **Descripción:** `data_label` (Text)

### E. Artículo
- **Título:** `article_title` (Text)
- **Extracto:** `article_excerpt` (Textarea)
- **Cuerpo HTML:** `article_content` (WYSIWYG Editor)

## 4. Consistencia y Usabilidad
- **Jerarquía:** Colocar el grupo Q2 inmediatamente después de Q1 para que Marketing vea la progresión temporal del mes.
- **Layout:** Usar **Block** en el Repeater.
- **Button Label:** "Añadir Módulo Q2".
- **Instrucciones:** Clarificar que Q2 corresponde a la segunda quincena para evitar errores de carga de datos.

## 5. Criterios de Aceptación y Pruebas
1. [ ] El grupo Q2 es independiente de Q1 (los cambios en uno no afectan al otro).
2. [ ] La lógica condicional funciona idénticamente a Q1.
3. [ ] El orden de los módulos en Q2 se puede gestionar mediante drag-and-drop o el campo "Orden".
4. [ ] Los datos se persisten correctamente en la base de datos.
5. [ ] La interfaz es intuitiva para el equipo de Marketing.
