# PROJECT RULES — NextMove

Resumen ejecutivo
- Objetivo: Unificar reglas y convenciones para la implementación ACF del CPT `panel`, basadas en los planes en `Plans/`.
- Ámbito: Estructura de campos para Q1 y Q2, tipos de módulo, `unlock_date`, convenciones de slugs y prácticas de UI para Marketing y Frontend.

## Tipo de contenido (CPT)

En este proyecto solo se registra un tipo de contenido personalizado: `panel`.

- **Etiqueta plural:** Paneles
- **Etiqueta singular:** Panel
- **Clave / slug:** `panel` (solo minúsculas, guiones bajos/guiones; máximo 20 caracteres)
- **Visible públicamente:** Sí
- **Jerárquico:** No
- **Configuración avanzada:** Activada (mostrar todas las opciones)

Mantener esta configuración como referencia al exportar/versionar los JSON de ACF y al replicar el entorno.

Convenciones generales (ACF)
- Grupos principales:
  - `Panel – Q1 (Primera quincena)` → Repeater slug: `q1_modules`.
  - `Panel – Q2 (Segunda quincena)` → Repeater slug: `q2_modules` (duplicar Q1 y cambiar slug).
- Repetidores: usar **Layout: Block** y `Button Label` apropiado ("Añadir Módulo Q1" / "Añadir Módulo Q2").
- Mantener slugs de sub-campos idénticos entre Q1 y Q2 (ej.: `quote_text`, `video_sumario_url`) para que el frontend sea agnóstico a la quincena.

### Campos principales del Panel

Organización de los campos principales usados por el CPT `panel` (Etiqueta / Nombre / Tipo):

| Etiqueta | Nombre | Tipo |
| :--- | :--- | :--- |
| Estado del panel | `panel_status` | Selección |
| Fecha del panel | `panel_date` | Selector de fecha |
| Título | `panel_title` | Texto |
| Subtítulo del Panel | `panel_subtitle` | Texto |
| Intro / Párrafo inicial | `panel_intro` | Área de texto |
| Imagen del Panel | `panel_image` | Imagen |
| Número de Entrega | `panel_report_delivery` | Texto |
| Video Introductorio | `panel_video_intro` | URL |
| Video Introductorio (alternativo) | `panel_video` | URL |
| Título de Video | `panel_title_video` | Texto |
| Imagen del Video | `panel_video_thumbnail` | Imagen |
| Día de desbloqueo Q1 | `panel_q1_unlock_date` | Selección |
| 1º Quincena | `panel_q1` | Contenido flexible |
| Día de desbloqueo Q2 | `panel_q2_unlock_date` | Selección |
| 2º Quincena | `panel_q2` | Contenido flexible |


## Esquemas (layouts) de las Quincenas

Cada campo tipo "Contenido flexible" (`panel_q1` y `panel_q2`) contiene una lista de esquemas (layouts) reutilizables. A continuación se definen los esquemas disponibles, su slug y la lista exacta de campos (etiqueta — nombre — tipo) según las capturas:

#### 1. Vídeo sumario (`video_sumario`)

| Etiqueta | Nombre | Tipo |
| :--- | :--- | :--- |
| Título del Video | `video_sumario_title` | Texto |
| URL YouTube | `video_sumario_url` | URL |
| Imagen miniatura | `video_sumario_thumb` | Imagen |
| Descripción | `video_sumario_desc` | Área de texto |
| Tamaño de Tarjeta | `video_sumario_size` | Selección |

#### 2. Vídeo entrevista (`video_entrevista`)

| Etiqueta | Nombre | Tipo |
| :--- | :--- | :--- |
| Título | `video_entrevista_title` | Texto |
| URL YouTube | `video_entrevista_url` | URL |
| Imagen miniatura | `video_entrevista_thumb` | Imagen |
| Entrevistado / Cargo | `video_entrevista_person_role` | Texto |
| Tamaño de Tarjeta | `video_entrevista_size` | Selección |

#### 3. Quote (`quote`)

| Etiqueta | Nombre | Tipo |
| :--- | :--- | :--- |
| Frase | `quote_text` | Área de texto |
| Autor | `quote_author` | Texto |
| Fuente / Cargo | `quote_source` | Texto |
| Color | `quote_color` | Selección |
| Tamaño de tarjeta | `quote_size` | Selección |

#### 4. Gráfico (`grafico`)

| Etiqueta | Nombre | Tipo |
| :--- | :--- | :--- |
| Imagen | `graphic_image` | Imagen |
| Descripción | `graphic_desc` | Texto |
| Fuente | `graphic_source` | Texto |
| Color | `graphic_color` | Selección |

#### 5. Dato cualitativo (`dato_cualitativo`)

| Etiqueta | Nombre | Tipo |
| :--- | :--- | :--- |
| Valor | `data_value` | Texto |
| Etiqueta | `data_label` | Texto |
| Nota | `data_note` | Texto |
| Color | `data_color` | Selección |
| Tamaño de tarjeta | `data_size` | Selección |

#### 6. Artículo (`articulo`)

| Etiqueta | Nombre | Tipo |
| :--- | :--- | :--- |
| Título | `article_title` | Texto |
| Extracto | `article_excerpt` | Área de texto (≤250 caracteres) |
| Contenido | `article_content` | Editor WYSIWYG |
| Imagen principal | `article_image` | Imagen |
| Color | `article_color` | Selección |

Notas:
- Mantener los slugs y prefijos de campo idénticos entre `panel_q1` y `panel_q2` para que el frontend pueda procesarlos de forma agnóstica a la quincena.
- Los nombres de campo sugeridos usan prefijos por esquema para evitar colisiones al exportar/importar JSON de ACF.
- A la hora de implementar componentes frontend, mapear cada esquema a un componente en `components/modules/` (ej.: `components/modules/video_sumario.php`).


## Reglas de Estilo y Colores

Los colores de la marca y sus variables CSS ahora se documentan en `docs/COLOR.md`. Ver: [docs/COLOR.md](docs/COLOR.md)

Se recomienda usar las variables CSS definidas en `okisam/app/styles/style.css` y las clases utilitarias listadas en `docs/COLOR.md` para mantener consistencia visual y facilitar el mantenimiento.


### Tipografías

Para especificaciones completas y overrides móviles, ver: [docs/TIPOGRAFIAS.md](docs/TIPOGRAFIAS.md)

