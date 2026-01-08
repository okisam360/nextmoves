# Plan de Implementación: TAREA 10 — ACF: Campos por tipo de módulo

Este documento detalla la configuración específica de los campos internos para cada tipo de módulo dentro de los repeaters `q1_modules` y `q2_modules`, incluyendo la lógica condicional y ajustes de UI.

## 1. Definición de Campos por Tipo de Módulo

A continuación se detallan los campos que deben crearse dentro de cada fila del repeater. Todos estos campos deben tener configurada la **Lógica Condicional** para mostrarse solo cuando el campo `module_type` coincida con el valor respectivo.

### 🔹 1. Vídeo Sumario
*Condición: `module_type` == `video_sumario`*
- **Título del vídeo:** `video_sumario_title` (Texto)
- **URL YouTube:** `video_sumario_url` (Url)
- **Imagen miniatura:** `video_sumario_thumb` (Imagen)
- **Descripción breve:** `video_sumario_desc` (Textarea) - *Opcional*
- **Tamaño de tarjeta:** `video_sumario_size` (Select: 1x3, 3x1)

### 🔹 2. Vídeo Entrevista
*Condición: `module_type` == `video_entrevista`*
- **Título del vídeo:** `video_entrevista_title` (Texto)
- **URL YouTube:** `video_entrevista_url` (Url)
- **Imagen miniatura:** `video_entrevista_thumb` (Imagen)
- **Entrevistado / Cargo:** `video_entrevista_person` (Texto) - *Opcional*
- **Tamaño de tarjeta:** `video_entrevista_size` (Select: 1x3, 3x1)

### 🔹 3. Quote
*Condición: `module_type` == `quote`*
- **Texto de la frase:** `quote_text` (Textarea)
- **Autor:** `quote_author` (Texto) - *Opcional*
- **Cargo o Fuente:** `quote_source` (Texto) - *Opcional*
- **Color:** `quote_color` (Select: Blanco, Negro)
- **Tamaño de tarjeta:** `quote_size` (Select: 1x1, 1x2)

### 🔹 4. Gráfico
*Condición: `module_type` == `grafico`*
- **Imagen:** `graphic_image` (Imagen) - *Retorno: ID de la imagen.*
- **Descripción / Explicación:** `graphic_desc` (Texto)
- **Fuente:** `graphic_source` (Texto) - *Opcional*
- **Color:** `graphic_color` (Select: Blanco, Negro)

### 🔹 5. Dato Cualitativo
*Condición: `module_type` == `dato`*
- **Valor numérico:** `data_value` (Texto) - *Ej: "78%", "12,4M€"*
- **Descripción corta:** `data_label` (Texto)
- **Nota o Aclaración:** `data_note` (Texto) - *Opcional*
- **Color:** `data_color` (Select: Blanco, Negro)
- **Tamaño de tarjeta:** `data_size` (Select: 1x1, 1x2)

### 🔹 6. Artículo
*Condición: `module_type` == `articulo`*
- **Título:** `article_title` (Texto)
- **Extracto:** `article_excerpt` (Textarea) - *Límite: 250 caracteres.*
- **Cuerpo completo:** `article_content` (Editor WYSIWYG) - *Configuración: Media Upload habilitado, Toolbar básico/completo.*
- **Imagen principal:** `article_image` (Imagen) - *Opcional*
- **Color:** `article_color` (Select: Blanco, Negro)

## 2. Configuración de Lógica Condicional (ACF)

Para cada campo listado arriba, se debe acceder a la pestaña **"Conditional Logic"** en la edición del campo ACF:
1. Activar "Conditional Logic".
2. Regla: `Show this field if` -> `Tipo de módulo` -> `is equal to` -> `[Valor correspondiente]`.

## 3. Optimización de la Interfaz (UI)

Para mejorar la experiencia de Marketing:
- **Instrucciones:** Añadir textos de ayuda en campos como la URL de YouTube o el límite de caracteres del extracto.
- **Ancho de campos (Wrapper Attributes):** Ajustar el ancho (ej: Título al 70% y URL al 30%) para que la fila no sea excesivamente larga verticalmente.
- **Agrupación Visual:** Se pueden usar campos de tipo **"Tab"** o **"Accordion"** dentro del repeater si se desea una limpieza visual extrema, aunque con la lógica condicional actual debería ser suficiente.

## 4. Criterios de Aceptación
1. [ ] Al seleccionar un tipo de módulo, solo aparecen sus campos específicos.
2. [ ] Los campos opcionales no impiden el guardado si se dejan vacíos.
3. [ ] El editor WYSIWYG del artículo permite formatear texto correctamente.
4. [ ] Las imágenes se cargan y previsualizan correctamente en el panel.
5. [ ] Los datos son accesibles desde el frontend mediante `get_sub_field()`.
