# Plan de Implementación: TAREA 11 — Campo “Unlock Date” por módulo

Este documento detalla la configuración del campo de tiempo para el desbloqueo automático de módulos.

## 1. Configuración del Campo
- **Label:** `Día de desbloqueo`
- **Nombre (slug):** `unlock_date`
- **Tipo:** Select (Selección)
- **Instrucciones:** "Día del mes para habilitar el módulo."

## 2. Comportamiento y Valores por Defecto
Para facilitar el trabajo de Marketing, se han implementado rangos y valores por defecto dinámicos:
- **Módulos Q1:** Opciones del **1 al 14**. Por defecto: **1**.
- **Módulos Q2:** Opciones del **15 al 31**. Por defecto: **15**.

## 3. Consideraciones de Usuario
- **Simplicidad:** En lugar de seleccionar una fecha completa, el usuario solo elige el día. El sistema asume el Mes y Año configurados globalmente en el Panel (Tarea 7).

## 4. Lógica de Frontend (Adelanto Tarea 14)
El código de visualización construirá la fecha completa usando el día seleccionado y los datos del panel:
```php
$panel_year = get_field('panel_year'); // ej: 2026
$panel_month = get_field('panel_month'); // ej: 01
$unlock_day = get_sub_field('unlock_date'); // ej: 15

$unlock_timestamp = strtotime("$panel_year-$panel_month-$unlock_day 09:00:00");
$now = current_time('timestamp');

if ($now >= $unlock_timestamp) {
    // Mostrar módulo
} else {
    // Mostrar estado bloqueado
}
```

## 5. Criterios de Aceptación
1. [x] Cada módulo en Q1 y Q2 tiene el campo de fecha.
2. [x] Los valores por defecto (1 y 15) se cargan correctamente en nuevos módulos.
3. [x] El formato de 24h es consistente.
4. [x] Los datos persisten correctamente tras guardar.
