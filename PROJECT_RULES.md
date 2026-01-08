# PROJECT RULES — NextMove

Resumen ejecutivo
- Objetivo: Unificar reglas y convenciones para la implementación ACF del CPT `panel`, basadas en los planes en `Plans/`.
- Ámbito: Estructura de campos para Q1 y Q2, tipos de módulo, `unlock_date`, convenciones de slugs y prácticas de UI para Marketing y Frontend.

Convenciones generales (ACF)
- Grupos principales:
  - `Panel – Q1 (Primera quincena)` → Repeater slug: `q1_modules`.
  - `Panel – Q2 (Segunda quincena)` → Repeater slug: `q2_modules` (duplicar Q1 y cambiar slug).
- Repetidores: usar **Layout: Block** y `Button Label` apropiado ("Añadir Módulo Q1" / "Añadir Módulo Q2").
- Mantener slugs de sub-campos idénticos entre Q1 y Q2 (ej.: `quote_text`, `video_sumario_url`) para que el frontend sea agnóstico a la quincena.

Tipos de módulo y campos clave
- Tipos soportados: `video_sumario`, `video_entrevista`, `quote`, `grafico`, `dato`, `articulo`.
- Campos generales por fila (dentro del repeater):
  - `module_type` (Select)
  - `unlock_date` (Date / Day selector según implementación)
  - `order` (Number)
- Subcampos importantes (resumen):
  - Vídeos: `video_*_title`, `video_*_url`, `video_*_thumb`, `video_*_size`.
  - Quote: `quote_text`, `quote_author`, `quote_source`, `quote_color`, `quote_size`.
  - Gráfico: `graphic_image`, `graphic_desc`, `graphic_source`, `graphic_color`.
  - Dato: `data_value`, `data_label`, `data_note`, `data_color`, `data_size`.
  - Artículo: `article_title`, `article_excerpt` (≤250), `article_content` (WYSIWYG), `article_image`, `article_color`.

Reglas para `unlock_date`
- En la implementación propuesta se puede usar un selector de día en vez de fecha completa.
  - Q1: días 1–14 (por defecto 1).
  - Q2: días 15–31 (por defecto 15).
- La fecha completa se construye con: `panel_year`, `panel_month` y el `unlock_date` del módulo.
- Frontend: comparar timestamp de desbloqueo con `current_time('timestamp')` para decidir renderizado.

UI & UX (Marketing)
- Ocultar editor principal si no es necesario; ordenar grupos: Q1 arriba, Q2 abajo.
- Wrapper widths sugeridos: títulos ~60–70%, URLs/fechas ~30–40%.
- Añadir instrucciones en campos críticos (ej.: "Pegar URL completa de YouTube").
- Soporte de drag-and-drop para `order` y/o permitir reordenamiento visual.

Criterios de aceptación (QA)
- Independencia: datos de Q1 y Q2 no se mezclan.
- Lógica condicional: cambiar `module_type` oculta/muestra subcampos inmediatamente.
- Persistencia: imágenes, WYSIWYG y todos los campos se guardan correctamente.
- Restricciones: `article_excerpt` ≤ 250 caracteres.

Próximos pasos técnicos (recomendado)
- Crear posts de prueba con al menos un módulo de cada tipo en Q1 y Q2 (QA interno).
- Implementar componentes frontend por tipo de módulo (`components/modules/*.php`).
- Añadir lazy-load para embeds de vídeo y optimización de imágenes.
- Sincronizar JSON/XML de ACF al entorno de producción si aplica.

Referencias
- Resumen de replicación: [Plans/ANEXO_PLAN_RESUMIDO.md](Plans/ANEXO_PLAN_RESUMIDO.md)
- Siguientes pasos: [Plans/ANEXO_SIGUIENTES_PASOS.md](Plans/ANEXO_SIGUIENTES_PASOS.md)
- Plan unificado ACF: [Plans/REPLAN_UNIFICADO_ACF.md](Plans/REPLAN_UNIFICADO_ACF.md)
- Implementación por tareas:
  - [Plans/PLAN_IMPLEMENTACION_TAREA_7.md](Plans/PLAN_IMPLEMENTACION_TAREA_7.md)
  - [Plans/PLAN_IMPLEMENTACION_TAREA_8.md](Plans/PLAN_IMPLEMENTACION_TAREA_8.md)
  - [Plans/PLAN_IMPLEMENTACION_TAREA_9.md](Plans/PLAN_IMPLEMENTACION_TAREA_9.md)
  - [Plans/PLAN_IMPLEMENTACION_TAREA_10.md](Plans/PLAN_IMPLEMENTACION_TAREA_10.md)
  - [Plans/PLAN_IMPLEMENTACION_TAREA_11.md](Plans/PLAN_IMPLEMENTACION_TAREA_11.md)

Contacto y notas
- Mantener este archivo actualizado si se cambian slugs o convenciones de ACF.
- Para cambios de producción, versionar los JSON/exports de ACF y anotar el despliegue en el changelog del repo.
