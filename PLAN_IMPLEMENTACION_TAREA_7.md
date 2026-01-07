# Plan de Implementación: TAREA 7 — ACF: Estructura general del Panel

Este documento detalla la configuración del grupo de campos ACF para la información base y el comportamiento del CPT "Panel".

## 1. Configuración del Grupo de Campos
- **Nombre del Grupo:** Panel – Configuración general
- **Reglas de Ubicación:** Post Type es igual a `panel`
- **Ajustes de Interfaz:**
    - Posición: Normal (debajo del título)
    - Estilo: Standard (con caja de WordPress)
    - Etiqueta: Superior
    - **Ocultar en pantalla:** Editor de contenido (Classic Editor / Gutenberg), Imagen destacada (opcional, si no se usa).

## 2. Definición de Campos

| Etiqueta | Nombre (Slug) | Tipo | Instrucciones / Opciones |
| :--- | :--- | :--- | :--- |
| Año | `panel_year` | Select | Opciones: 2024, 2025, 2026... |
| Mes | `panel_month` | Select | Enero, Febrero, ..., Diciembre. |
| Título del panel | `panel_title` | Text | Título público del panel mensual. |
| Intro / Párrafo inicial | `panel_intro` | Textarea | Breve introducción que aparecerá en la cabecera. |
| Estado del panel | `panel_status` | Select | `active` : Activo<br>`hidden` : Oculto<br>`historical` : Histórico |

## 3. Detalles Técnicos de los Campos

### 3.1. Mes (`panel_month`)
Se recomienda usar valores numéricos para facilitar el ordenamiento en el frontend:
- `01` : Enero
- `02` : Febrero
- ...
- `12` : Diciembre

### 3.2. Estado del Panel (`panel_status`)
Este campo controlará la visibilidad global o el etiquetado en el listado de paneles:
- **Activo:** El panel actual en curso.
- **Oculto:** Borrador o panel en preparación no visible al público.
- **Histórico:** Paneles de meses anteriores ya finalizados.

## 4. Optimización de UI
- **Ancho de campos:**
    - Año y Mes: 25% cada uno (en la misma fila).
    - Estado: 50% (en la misma fila que año/mes).
    - Título: 100%.
    - Intro: 100%.

## 5. Criterios de Aceptación
1. [ ] El grupo de campos aparece inmediatamente debajo del título al editar un "Panel".
2. [ ] El editor de texto por defecto de WordPress está oculto para evitar confusiones.
3. [ ] Los selectores de Año, Mes y Estado muestran las opciones correctas.
4. [ ] Marketing puede actualizar la intro y el título sin necesidad de código.
5. [ ] Los datos se guardan y recuperan correctamente al actualizar la entrada.
