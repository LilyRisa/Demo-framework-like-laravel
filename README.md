# Project test
## Hướng dẫn cài đặt:
- ```cp .env.example .env``` để tạo file chứa thông tin kết nối database
- Sửa thông tin kết nối database trong file .env và import file congminh.sql
- Run ``` composer install ```
- ``` composer dump-autoload ``` classmap autoload psr-4

## Sử dụng
- Trỏ gốc thư mục vào ./src/
- Truy cập theo link http://localhost/?route=home
