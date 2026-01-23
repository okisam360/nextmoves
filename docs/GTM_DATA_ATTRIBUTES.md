# Tracking: Implementación de Data Attributes (Tarea 29)

Este documento resume la implementación de atributos `data-*` realizada para optimizar el rastreo de eventos mediante Google Tag Manager (GTM) en el proyecto NextMove.

## 1. Atributos de Contexto (Fases y Estado)
Para evitar la dependencia de selectores CSS variables, se han inyectado atributos de contexto en los contenedores de contenido y módulos:

- `data-phase="q1|q2"`: Identifica la quincena a la que pertenece el contenido.
- `data-unlocked="true|false"`: Indica si el contenido es accesible (unlocked) o si el usuario está viendo la pantalla de bloqueo (locked).

Estos atributos se encuentran en los contenedores principales de `q1.php`, `q2.php` y en cada módulo individual.

## 2. Mapeo de Módulos (`data-module-type`)
Cada módulo dentro de la parrilla de contenidos tiene un tipo asignado en inglés para reporte unificado:

| Módulo PHP | `data-module-type` | Notas |
| :--- | :--- | :--- |
| `articulo.php` | `article` | Contiene tracking de modal e ID. |
| `quote.php` | `quote` | Módulo de cita/frase. |
| `dato_cualitativo.php` | `data` | Módulo de métrica/dato. |
| `grafico.php` | `graphic` | Módulo de imagen/gráfico. |
| `video_entrevista.php` | `video-interview` | Incluye `data-video="true"`. |
| `video_sumario.php` | `video-summary` | Incluye `data-video="true"`. |
| `header-panel.php` | `video-header` | Trigger de vídeo en la cabecera del panel. |

## 3. Seguimiento de CTAs (Suscripción)
Se han marcado los botones de acción principal para distinguir clics de navegación de intentos de conversión:

- `data-cta="subscription"`: 
    - Botón "Suscríbete ya" en el Header principal.
    - Botón "Suscríbete ya" del formulario de desbloqueo (ActiveCampaign).

## 4. Artículos y Modales
El módulo de artículos incluye tracking específico para medir el interés por temas:

- `data-article-id="[card_id]"`: Añadido al botón "Leer más" (`.open-article-modal`). Coincide con el parámetro `?post=` de la URL para consistencia.
- `data-modal="article"`: Añadido al contenedor raíz de la estructura del modal.

## 5. Triggers de Vídeo
Todos los elementos que abren el reproductor de vídeo (YouTube/Vimeo) incluyen un identificador común:

- `data-video="true"`: Atributo booleano presente en todos los enlaces o botones `.js-video-modal-trigger`.

---

**Fecha de implementación:** 23 de Enero, 2026
**Responsable:** GitHub Copilot (Gemini 3 Flash)
