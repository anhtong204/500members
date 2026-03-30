# Hướng Dẫn Dự Án WordPress - Hola Team Theme

## Tổng Quan Dự Án

Đây là một trang web WordPress sử dụng theme tùy chỉnh "Hola Team" dựa trên framework UnderStrap. Dự án sử dụng Advanced Custom Fields (ACF) Pro để tạo các component/block động trên trang.

### Cấu Trúc Dự Án

```
/Users/natsu/Sites/500members/
├── wp-admin/          # WordPress admin files
├── wp-content/
│   ├── plugins/       # Plugins (bao gồm ACF Pro)
│   ├── themes/
│   │   └── hola-team/ # Theme chính
│   └── uploads/       # Media files
├── wp-includes/       # WordPress core files
└── wp-config.php      # WordPress configuration
```

## Cấu Trúc Theme Hola Team

Theme được tổ chức như sau:

```
wp-content/themes/hola-team/
├── assets/
│   ├── acf-json/      # ACF field groups (JSON export)
│   ├── css/           # Stylesheets
│   ├── js/            # JavaScript files
│   └── fonts/         # Custom fonts
├── components/        # Component templates
│   ├── components.php # Main component renderer
│   ├── content/       # Content component
│   ├── faq/           # FAQ component
│   ├── image_text/    # Image + Text component
│   ├── pricing_plans/ # Pricing Plans component
│   ├── slider/        # Slider component
│   ├── steps/         # Steps component
│   └── testimonials/  # Testimonials component
├── inc/               # Include files
│   ├── acf.php        # ACF configuration
│   ├── functions.php  # Custom functions
│   └── ...            # Other includes
├── src/               # Source files (SCSS, JS)
├── functions.php      # Main theme functions
├── style.css          # Theme stylesheet
└── ...                # Standard WordPress theme files
```

### ACF Configuration

- ACF field groups được lưu dưới dạng JSON trong `assets/acf-json/`
- Tự động sync khi import/export
- Options page: "Advanced Theme Settings"

## Components Hiện Có

### Danh Sách Components

1. **Content** - Hiển thị nội dung văn bản
   - Field Group: group_629f038f23d18
   - Template: components/content/default.php

2. **Slider** - Carousel/slider
   - Field Group: group_5fec3ed1b0037
   - Template: components/slider/default.php

3. **FAQ** - Câu hỏi thường gặp
   - Field Group: group_60b7f5a1f09c3
   - Template: components/faq/default.php

4. **Steps** - Các bước hướng dẫn
   - Field Group: group_6b7a8c9d0e1f2
   - Template: components/steps/default.php

5. **Testimonials** - Lời chứng thực
   - Field Group: group_7a8c9d0f1e2b3
   - Template: components/testimonials/default.php

6. **Image + Text** - Hình ảnh và văn bản
   - Field Group: group_8a7d9b0f3c19
   - Template: components/image_text/default.php

7. **Pricing Plans** - Bảng giá
   - Field Group: group_9a1b2c3d4e5f6
   - Template: components/pricing_plans/default.php

### ACF Field Groups Quan Trọng

- **group_58a7f7c5e16c1**: Component - Basic General (fields chung)
- **group_5c0fd4be25824**: Layout (flexible content chính)
- **group_5edda4b4b0098**: Component - Content Fields
- Các group khác cho từng component cụ thể

### Basic General Fields (group_58a7f7c5e16c1)

Bao gồm:
- Container (container, container-wide, etc.)
- Component ID
- Component Height (auto, full, custom)
- Text Color & Align
- Margin & Padding
- Background Color/Image
- Title & Subtitle
- Body Content
- Link
- Custom Class
- H1 Element

## Cách Tạo Component/Block Mới

### Bước 1: Tạo ACF Field Group cho Component

1. Tạo field group mới trong ACF admin với cấu trúc:
   - Tab "Content": Fields riêng cho component
   - Tab "Settings": Clone "Component - Basic General" (group_58a7f7c5e16c1)

2. Xuất field group thành JSON vào `assets/acf-json/`

### Bước 2: Thêm Layout vào Flexible Content

Chỉnh sửa field group "Layout" (group_5c0fd4be25824):
- Thêm layout mới trong field "Components" (flexible_content)
- Set name = tên component (ví dụ: "pricing_plans")
- Clone field group vừa tạo

### Bước 3: Tạo Template Component

1. Tạo thư mục mới trong `components/` với tên component
2. Tạo file `default.php` (hoặc layouts khác nếu cần)
3. Sử dụng variables từ ACF fields
4. Sử dụng helper functions:
   - `open_component($id, $classes, $styles, $component_name, $layout_position)`
   - `close_component()`
   - `get_component_title($h1, $title, $sub_title)`
   - `render_link($link, $class)`

### Bước 4: Include trong components.php

File `components/components.php` sẽ tự động include template dựa trên `$component_name`.

## Ví Dụ: Tạo Component Pricing Plans

### 1. ACF Field Group (group_9a1b2c3d4e5f6)

```json
{
    "key": "group_9a1b2c3d4e5f6",
    "title": "Component - Pricing Plans",
    "fields": [
        {
            "key": "field_9a1b2c3d4e5f7",
            "label": "Content",
            "name": "",
            "type": "tab"
        },
        {
            "key": "field_9a1b2c3d4e5f8",
            "label": "Plans",
            "name": "plans",
            "type": "repeater",
            "sub_fields": [
                // Plan name, price, interval, features, etc.
            ]
        }
    ]
}
```

### 2. Thêm vào Layout Group

Trong group_5c0fd4be25824, thêm layout:

```json
"layout_9a1b2c3d4e5f0": {
    "key": "layout_9a1b2c3d4e5f0",
    "name": "pricing_plans",
    "label": "Pricing Plans",
    "sub_fields": [
        {
            "clone": ["group_9a1b2c3d4e5f6"]
        }
    ]
}
```

### 3. Template: components/pricing_plans/default.php

```php
<div class="<?php echo $container_class; ?>">
    <?php get_component_title($component_h1, $component_title, $component_sub_title); ?>
    
    <?php if (have_rows('plans')): ?>
        <div class="pricing-plans">
            <?php while (have_rows('plans')): the_row(); 
                $plan_name = get_sub_field('plan_name');
                $plan_price = get_sub_field('plan_price');
                // Render plan
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
    
    <?php render_link($component_link, 'btn'); ?>
</div>
```

## Quy Trình Phát Triển

1. **Thiết kế fields** trong ACF admin
2. **Xuất JSON** để version control
3. **Tạo template** trong `components/`
4. **Test trên page** với flexible content
5. **Style với SCSS** trong `src/`
6. **Build assets** với npm/yarn

## Lưu Ý Quan Trọng

- Luôn export ACF fields thành JSON sau khi thay đổi
- Sử dụng helper functions để consistency
- Follow naming conventions: component-name, field_name
- Test responsive design cho tất cả components
- Document fields và usage trong comments

## Build Process

```bash
cd wp-content/themes/hola-team
npm install  # or yarn install
npm run build  # Compile SCSS/JS
```

Theme sử dụng build process để compile assets từ `src/` vào `assets/`.</content>
<parameter name="filePath">/Users/natsu/Sites/500members/wp-content/themes/hola-team/project-overview.md