# REPLAN UNIFICADO: Implementación ACF (Tareas 8, 9 y 10)

Este plan unifica los requisitos de las tareas 8, 9 y 10 en un único flujo de trabajo, resolviendo las inconsistencias de slugs y campos detectadas.

## Fase 1: Configuración de Q1 (Estructura Base + Campos Detallados)

Se creará el grupo de campos **"Panel – Q1 (Primera quincena)"** asignado al CPT `panel`.

### 1.1. Campos de Control (Repeater: `q1_modules`)
| Etiqueta | Slug | Tipo | Instrucciones para Marketing |
| :--- | :--- | :--- | :--- |
| Tipo de módulo | `module_type` | Select | Selecciona el tipo de contenido que se mostrará en este bloque. |
| Fecha desbloqueo | `unlock_date` | Date Time | Define el día y la hora exacta en que este módulo será visible. |
| Orden | `order` | Number | Prioridad de visualización (ej: 1 para el primero). |

### 1.2. Sub-campos Detallados (Lógica Condicional)
Dentro del repeater `q1_modules`, configurar los campos según el tipo seleccionado:

| Tipo Módulo | Campo | Slug | Tipo | Instrucciones para Marketing |
| :--- | :--- | :--- | :--- | :--- |
| **Vídeo Sumario** | Título | `video_sumario_title` | Text | Título descriptivo del vídeo. |
| | URL YouTube | `video_sumario_url` | Url | Pega la URL completa de YouTube (ej: https://youtube.com/watch?v=...). |
| | Descripción | `video_sumario_desc` | Textarea | Breve resumen opcional del contenido del vídeo. |
| **Vídeo Entrevista**| Título | `video_entrevista_title`| Text | Título de la entrevista. |
| | URL YouTube | `video_entrevista_url` | Url | Pega la URL completa de YouTube. |
| | Entrevistado | `video_entrevista_person`| Text | Nombre y cargo de la persona entrevistada. |
| **Quote** | Frase | `quote_text` | Textarea | Introduce la frase destacada (sin comillas). |
| | Autor | `quote_author` | Text | Nombre de la persona que cita. |
| | Fuente/Cargo | `quote_source` | Text | Cargo o empresa del autor de la frase. |
| **Gráfico** | Imagen | `graphic_image` | Image | Sube el gráfico en formato PNG o JPG (alta calidad). |
| | Descripción | `graphic_desc` | Text | Explicación breve de lo que muestra el gráfico. |
| | Fuente | `graphic_source` | Text | Origen de los datos del gráfico. |
| **Dato** | Valor | `data_value` | Text | El dato resaltado (ej: "78%", "12.4M€"). |
| | Etiqueta | `data_label` | Text | Descripción corta del dato (ej: "Crecimiento anual"). |
| | Nota | `data_note` | Text | Aclaración adicional sobre el dato (opcional). |
| **Artículo** | Título | `article_title` | Text | Título principal del artículo. |
| | Extracto | `article_excerpt` | Textarea | Resumen gancho (Máx. 250 caracteres). |
| | Contenido | `article_content` | WYSIWYG | Cuerpo completo con formato (negritas, listas, etc.). |
| | Imagen | `article_image` | Image | Imagen de cabecera para el artículo. |

---

## Fase 2: Replicación para Q2 (Segunda Quincena)

Para asegurar la consistencia y rapidez:
1. **Duplicar** el grupo "Panel – Q1".
2. **Renombrar** a "Panel – Q2 (Segunda quincena)".
3. **Cambiar Slug del Repeater:** De `q1_modules` a `q2_modules`.
4. **Mantener Sub-campos:** Los slugs internos (ej. `quote_text`) se mantienen iguales para que el frontend sea agnóstico a la quincena.

---

## Fase 3: Optimización de UI para Marketing

- **Layout del Repeater:** Configurar como **"Block"** para una edición más clara.
- **Button Label:** "Añadir Módulo Q1" / "Añadir Módulo Q2".
- **Wrapper Attributes:** 
    - Títulos al 60% de ancho.
    - URLs/Fechas al 40% de ancho.
- **Instrucciones:** Añadir textos de ayuda en campos críticos (ej: "Pegar URL completa de YouTube").

---

## Fase 4: Criterios de Aceptación (QA)

1. [ ] **Independencia:** Los datos guardados en Q1 no aparecen en Q2 y viceversa.
2. [ ] **Lógica:** Al cambiar el selector de tipo, los campos se ocultan/muestran instantáneamente.
3. [ ] **Validación:** El extracto del artículo no permite más de 250 caracteres.
4. [ ] **Persistencia:** Todos los campos (incluyendo imágenes y WYSIWYG) guardan datos correctamente.
5. [ ] **Frontend Ready:** Los slugs coinciden con la especificación técnica para el desarrollo del tema.
