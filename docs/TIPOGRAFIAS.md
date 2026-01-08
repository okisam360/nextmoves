# Tipografías — NextMove

Este documento resume las reglas tipográficas del proyecto, los valores por defecto (desktop) y las variantes para Mobile.

Archivo principal de estilos: `okisam/app/styles/style.css`
Fuentes: `okisam/app/fonts/graphik/` (Regular, Medium, Semibold)

## Reglas generales
- Familia principal: Graphik
- Formato: OpenType (OTF)
- Uso recomendado: aplicar clases de utilidad (p. ej. `.h1-semibold`, `.h3-regular`) definidas en `okisam/app/styles/style.css`.

## Tipografías (Desktop)
- H1-Semibold
  - font-family: Graphik
  - font-weight: 600
  - font-style: normal
  - font-size: 40px
  - line-height: 110%
  - letter-spacing: 0px
  - text-align: center
  - CSS class: `.h1-semibold`

- H2-Regular
  - font-family: Graphik
  - font-weight: 400
  - font-size: 30px
  - line-height: 140%

- H3-Regular
  - font-family: Graphik
  - font-weight: 400
  - font-size: 24px
  - line-height: 130%
  - letter-spacing: 0px
  - text-align: center
  - CSS class: `.h3-regular`

- Otros estilos: ver `okisam/app/styles/style.css` para `h4`, `display-xxl`, `body-l`, `body-s`, etc.

## Overrides (Mobile — `@media (max-width: 768px)`)
- H1 (móvil)
  - font-family: Graphik
  - font-weight: 400
  - font-style: normal
  - font-size: 24px
  - line-height: 130%
  - letter-spacing: 0px
  - text-align: center
  - vertical-align: middle
  - Nota: añadido como override en la media query para la clase `.h1-semibold`.

- H3 (móvil)
  - font-family: Graphik
  - font-weight: 400
  - font-style: normal
  - font-size: 18px
  - line-height: 150%
  - letter-spacing: 0.6px
  - text-align: center
  - vertical-align: middle
  - Nota: añadido como override en la media query para la clase `.h3-regular`.

## Consideraciones de implementación
- Preferir clases semánticas (`.h1-semibold`, `.h3-regular`) en lugar de selectores elementales para evitar conflictos.
- Al exportar/importar ACF o crear componentes, mapear los títulos y textos a estas clases para mantener consistencia visual.
- Si se añaden variantes (ej.: `Semibold` vs `Regular`) asegúrate de incluir las `@font-face` necesarias en `okisam/app/styles/style.css`.

## Ejemplo rápido (CSS)
```css
.h1-semibold { font-family: 'Graphik', sans-serif; font-weight: 600; font-size: 40px; line-height: 110%; text-align:center; }
@media (max-width:768px){ .h1-semibold { font-weight:400; font-size:24px; line-height:130%; } }
.h3-regular { font-family: 'Graphik', sans-serif; font-weight:400; font-size:24px; line-height:130%; text-align:center }
@media (max-width:768px){ .h3-regular { font-size:18px; line-height:150%; letter-spacing:0.6px } }
```

---

Si quieres, puedo generar un JSON de ejemplo de ACF que incluya campos de título y subtítulo con sus clases, o crear plantillas base en `components/modules/` que usen estas clases. ¿Cuál prefieres?