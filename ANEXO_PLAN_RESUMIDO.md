# ANEXO: Guía Rápida de Replicación (Q1 → Q2)

Dado que la estructura de **Q1** ya está implementada y validada, la configuración de **Q2** se realizará mediante replicación para asegurar consistencia técnica y de usuario.

## 1. Clonación de Estructura
Para agilizar el proceso, se recomienda:
1. **Exportar/Duplicar** el grupo de campos "Panel – Q1".
2. **Renombrar** el nuevo grupo a "Panel – Q2 (Segunda quincena)".
3. **Actualizar Slugs:** Cambiar el slug del Repeater principal de `q1_modules` a `q2_modules`.
   * *Nota: Los slugs de los sub-campos (video_url, quote_text, etc.) pueden mantenerse idénticos ya que están encapsulados en un repeater diferente.*

## 2. Diferencias Clave
| Elemento | Q1 (Completado) | Q2 (Pendiente) |
| :--- | :--- | :--- |
| **Slug Repeater** | `q1_modules` | `q2_modules` |
| **Etiqueta Botón** | "Añadir Módulo Q1" | "Añadir Módulo Q2" |
| **Contexto Temporal** | Primera quincena | Segunda quincena |

## 3. Resumen de Implementación Frontend (Referencia)
Para el desarrollador que integre estos campos, la lógica será:

```php
// Ejemplo de lógica unificada
$quincenas = ['q1_modules', 'q2_modules'];

foreach ($quincenas as $q) {
    if (have_rows($q)) {
        while (have_rows($q)) {
            the_row();
            $tipo = get_sub_field('module_type');
            $desbloqueo = get_sub_field('unlock_date');
            // Lógica de renderizado según $tipo...
        }
    }
}
```

## 4. Checklist de Cierre
- [ ] Slugs de Q2 verificados (no colisionan con Q1).
- [ ] Orden de los grupos en la edición (Q1 arriba, Q2 abajo).
- [ ] Pruebas de guardado independientes.
