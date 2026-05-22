# Kế hoạch triển khai (Technical Blueprint)

Dựa trên phân tích mã nguồn `index.html` của trang chủ và các yêu cầu của bạn, tôi đã phác thảo Bản thiết kế kỹ thuật cho bước đầu tiên này. 

## Proposed Changes

### Component Extraction
Trích xuất các khối giao diện lặp lại trong `index.html` thành các linh kiện (components) độc lập để tái sử dụng trên toàn hệ thống.
Chúng ta sẽ tạo các file trong thư mục `template-parts/component/`:

#### [NEW] [card-doctor.php](file:///d:/datamain/Local_Sites_D/bv-carmel/app/public/wp-content/themes/canhcamtheme/template-parts/component/card-doctor.php)
Component cho Bác sĩ. Sẽ nhận các tham số như tên, chuyên khoa, tóm tắt, hình ảnh thông qua biến `$args` (mảng arguments) truyền vào hàm `get_template_part('template-parts/component/card', 'doctor', $args)`.

#### [NEW] [card-outstanding.php](file:///d:/datamain/Local_Sites_D/bv-carmel/app/public/wp-content/themes/canhcamtheme/template-parts/component/card-outstanding.php)
Component cho Chuyên khoa nổi bật.

#### [NEW] [card-new.php](file:///d:/datamain/Local_Sites_D/bv-carmel/app/public/wp-content/themes/canhcamtheme/template-parts/component/card-new.php)
Component cho Tin tức / Hoạt động.

---

### Custom Post Types
Tạo các Custom Post Type theo yêu cầu trong file `inc/function-post-types.php`.

#### [MODIFY] [function-post-types.php](file:///d:/datamain/Local_Sites_D/bv-carmel/app/public/wp-content/themes/canhcamtheme/inc/function-post-types.php)
Đăng ký 3 Post Type:
- **Chuyên khoa** (`specialty`)
- **Bác sĩ** (`doctor`)
- **Dịch vụ** (`service`)

*Lưu ý: Chúng ta sẽ thiết lập tham số cho các CPT này (hỗ trợ title, editor, thumbnail, excerpt).*

---

### ACF JSON - Mối quan hệ Chuyên khoa & Bác sĩ
Tạo file ACF JSON định nghĩa field để chọn các Bác sĩ thuộc một Chuyên khoa.

#### [NEW] [group_specialty_doctors.json](file:///d:/datamain/Local_Sites_D/bv-carmel/app/public/wp-content/themes/canhcamtheme/acf-json/group_specialty_doctors.json)
File JSON này sẽ chứa một field Relationship mang tên `specialty_doctors`, cho phép Admin chọn nhiều Bác sĩ (từ CPT `doctor`). Field Group này sẽ được gắn với Location là Post Type `specialty`.

---

## User Review Required

> [!IMPORTANT]
> **Về Form Liên hệ**: Theo yêu cầu, hệ thống sẽ sử dụng Contact Form 7. Ở bước xây dựng template cho trang chứa form, chúng ta sẽ cung cấp 1 field ACF dạng shortcode để admin dán ID của Contact Form 7 vào.
> 
> **Xác nhận tiến hành**: Bạn có đồng ý với cấu trúc các thành phần và Post Type như trên không? Nếu có, hãy phê duyệt để tôi bắt đầu viết mã và tạo các file này.
