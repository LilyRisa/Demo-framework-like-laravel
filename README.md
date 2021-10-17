# Project test
Một framework được viết trong vài ngày dựa theo laravel

## Yêu cầu:
 - composer
 - RewriteEngine On


## Hướng dẫn cài đặt:
- ```cp .env.example .env``` để tạo file chứa thông tin kết nối database
- Sửa thông tin kết nối database trong file .env và import file congminh.sql
- Run ``` composer install ```
- ``` composer dump-autoload ``` classmap autoload psr-4

## Sử dụng
- Trỏ gốc thư mục vào ./src/
- Truy cập theo link http://localhost/home (ex: 'home' đã khai báo trong route tại ./src/Routes/Web.php)

## Hướng dẫn:
 (Về cơ bản nó vẫn chưa hoàn thiện và sẽ có rất nhiều lỗi sảy ra)

 ### Route:
  - ``` .src/Route ``` tương tự laravel, example

 ### middleware:
  - ``` ./src/Middleware ``` Tạo class middleware theo mẫu. Thêm class vào config tại ``` ./conf.php ```. Thêm tên middleware vào đối số thứ 3 trong route ex: ``` Route::get({url_route},{Controller@method}, {Middleware})->name({name_route}) ```

 ### Controller:
  - ``` ./src/Controllers ``` Chỉ có chắc năng làm việc với database và trả về view

 ### Views:
  - ``` ./src/Views ``` Sử dụng twig template 2.x vui lòng đọc doc tại [a link](https://twig.symfony.com/doc/2.x/)

 ### Models
  - ``` ./src/Models ``` Models sẽ được viết tại đây. Kế thừa từ class Models ``` ./src/Core/Abstracts/Models.php ```

  -------------------------------

[Bronoz](https://www.facebook.com/dark.knight.os/)