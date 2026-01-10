# Panel Modules

This directory contains template files for rendering different types of content modules in Q1 and Q2 sections.

## Available Modules

### 1. Video Sumario (`video_sumario.php`)
Summary video with thumbnail and description.

**Fields:**
- `video_sumario_title` - Video title
- `video_sumario_url` - YouTube URL
- `video_sumario_thumb` - Thumbnail image
- `video_sumario_desc` - Video description
- `video_sumario_size` - Card size (small/medium/large)

### 2. Video Entrevista (`video_entrevista.php`)
Interview video with interviewer information.

**Fields:**
- `video_entrevista_title` - Video title
- `video_entrevista_url` - YouTube URL
- `video_entrevista_thumb` - Thumbnail image
- `video_entrevista_person_role` - Interviewer name and role
- `video_entrevista_size` - Card size (small/medium/large)

### 3. Quote (`quote.php`)
Citation or quote block.

**Fields:**
- `quote_text` - Quote text
- `quote_author` - Author name
- `quote_source` - Source/role
- `quote_color` - Color scheme
- `quote_size` - Card size (small/medium/large)

### 4. Gráfico (`grafico.php`)
Graphic or chart display.

**Fields:**
- `graphic_image` - Chart/graphic image
- `graphic_desc` - Description
- `graphic_source` - Data source
- `graphic_color` - Color scheme

### 5. Dato Cualitativo (`dato_cualitativo.php`)
Qualitative data display.

**Fields:**
- `data_value` - Data value (number/text)
- `data_label` - Data label
- `data_note` - Additional note
- `data_color` - Color scheme
- `data_size` - Card size (small/medium/large)

### 6. Artículo (`articulo.php`)
Article content block.

**Fields:**
- `article_title` - Article title
- `article_excerpt` - Short excerpt (max 250 chars)
- `article_content` - Full content (WYSIWYG)
- `article_image` - Featured image
- `article_color` - Color scheme

## How Modules Work

1. **ACF Flexible Content**: Each Q1/Q2 field is an ACF Flexible Content field that allows multiple modules
2. **Module Array**: Each module in the array has an `acf_fc_layout` key that identifies the module type
3. **Template Loading**: The Q1/Q2 templates loop through modules and include the appropriate template file
4. **Module Variable**: The `$module` variable contains all field data for that specific module instance

## Creating a New Module

To add a new module type:

1. **Create the PHP template:**
   ```php
   <?php
   /**
    * Module: Your Module Name
    * Description of what this module does
    */

   // Extract field values from $module array
   $field1 = isset($module['your_field_name']) ? $module['your_field_name'] : '';
   $field2 = isset($module['another_field']) ? $module['another_field'] : '';
   
   // Handle image fields (they return arrays)
   $image_url = is_array($field1) ? $field1['url'] : $field1;
   ?>

   <div class="module module-your-type">
       <div class="module-content">
           <?php if ($field1): ?>
               <h3><?php echo esc_html($field1); ?></h3>
           <?php endif; ?>
           
           <?php if ($field2): ?>
               <p><?php echo esc_html($field2); ?></p>
           <?php endif; ?>
       </div>
   </div>
   ```

2. **Add ACF Flexible Content Layout:**
   - Go to the Panel field group in ACF
   - Add a new layout to `panel_q1` and `panel_q2`
   - Layout name must match your template filename (without .php)
   - Add sub-fields for your module

3. **Add CSS styles:**
   - Add styles in `app/styles/style.css`
   - Use `.module-your-type` as the base selector

## CSS Classes

All modules use these standard classes:

- `.module` - Base module class
- `.module-{type}` - Specific module type
- `.module-size-{size}` - Size variant (small/medium/large)
- `.module-color-{color}` - Color variant
- `.module-content` - Content wrapper
- `.module-thumbnail` - Thumbnail/image container

## Size Variants

Modules can have different sizes:
- `small` - 1 column width
- `medium` - 1 column width (default)
- `large` - 2 columns width

The grid automatically adjusts on mobile to single column.

## Color Variants

Available color variants:
- `default` - Default theme color
- `primary` - Primary brand color
- `secondary` - Secondary color
- `success` - Success/positive color
- `info` - Information color
- `warning` - Warning color
- `danger` - Danger/error color

## Security Best Practices

Always escape output:
- `esc_html($text)` - For plain text
- `esc_url($url)` - For URLs
- `esc_attr($attr)` - For HTML attributes
- `wp_kses_post($html)` - For rich content (WYSIWYG)

## Example Usage in ACF

When creating content in WordPress:

1. Edit a Panel post
2. Scroll to Q1 or Q2 section
3. Click "Add Module"
4. Select module type (e.g., "Video Sumario")
5. Fill in the fields
6. Click "Add Module" again for additional modules
7. Drag to reorder modules
8. Publish/Update

## Debugging

If a module doesn't render:

1. Check template filename matches ACF layout name exactly
2. Verify template is in `templates/modules/` directory
3. Check field names match between template and ACF
4. Look for PHP errors in debug log
5. Verify module array has data: `var_dump($module);`

## Module Template Checklist

- [ ] Template filename matches ACF layout name
- [ ] All field values extracted with isset() checks
- [ ] Image fields handled correctly (array vs string)
- [ ] All output properly escaped
- [ ] Module wrapper has appropriate classes
- [ ] CSS styles added for the new module
- [ ] Documentation updated if needed
