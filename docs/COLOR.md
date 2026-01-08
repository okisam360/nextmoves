# Colores de Marca — NextMove

Este archivo centraliza los colores de la marca, sus variables CSS y ejemplos de uso.

## Variables CSS
- `--neutral-95`: #171A1C
- `--brand-color`: #EF5A35
- `--neutral-00`: #FFFFFF
- `--neutral-20`: #D5D9DD
- `--neutral-70`: #6E7B86
- `--cta-default`: #EF5A35
- `--neutral-90`: #394046
- `--okisam-gris`: #3F3F3F
- `--okisam-rojo`: #E74A48

## Clases utilitarias disponibles
- Textos:
  - `.text-neutral-95`, `.text-brand`, `.text-neutral-00`, `.text-neutral-70`, `.text-neutral-20`, `.text-neutral-90`, `.text-okisam-gris`, `.text-okisam-rojo`
- Fondos:
  - `.bg-neutral-95`, `.bg-brand`, `.bg-neutral-00`, `.bg-neutral-70`, `.bg-neutral-20`, `.bg-neutral-90`, `.bg-okisam-gris`, `.bg-okisam-rojo`
- Bordes:
  - `.border-neutral-95`, `.border-brand`, `.border-neutral-00`, `.border-neutral-70`, `.border-neutral-20`, `.border-neutral-90`, `.border-okisam-gris`, `.border-okisam-rojo`
- CTA:
  - `.btn-cta` — clase semántica para botones de llamada a la acción (usa `--cta-default`).

## Ejemplos de uso

- Botón CTA:

```html
<a class="btn-cta" href="/suscribete">Suscríbete</a>
```

- Texto sobre fondo de marca:

```html
<div class="bg-brand text-neutral-00">Contenido</div>
```

## Notas
- Mantener este archivo actualizado cuando cambien variables en `okisam/app/styles/style.css`.
- Preferir las clases utilitarias para consistencia; para estilos complejos usar clases semánticas y componentes.
