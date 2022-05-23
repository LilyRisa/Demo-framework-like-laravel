# Project test
Một framework được viết dựa theo laravel

## Yêu cầu:
 - composer
 - RewriteEngine On


## Hướng dẫn cài đặt:
- ```cp .env.example .env``` tạo file chưa biến môi trường
- Sửa thông tin kết nối database trong file .env và import file congminh.sql
- Migration đang được hoàn thiện và thêm tại bản update sau
- Run ``` composer install ```
- ``` composer dump-autoload ``` classmap autoload psr-4

## Sử dụng
- Trỏ gốc thư mục vào ./src/
- Truy cập theo link http://localhost/home (ex: 'home' đã khai báo trong route tại ./src/Routes/Web.php)

## Hướng dẫn:
 (Về cơ bản dự án này chỉ phục vụ mục đích nghiên cứu)
 ### Route:
 Mắc định 'GET', 'POST' và 'PUT' đều sử dụng csrf để xác thực
  - ``` .src/Route ``` tương tự laravel, example

 ### middleware:
  - ``` ./src/Middleware ``` Tạo class middleware theo mẫu. Thêm class vào config tại ``` ./conf.php ```. Thêm tên middleware vào đối số thứ 3 trong route ex: ``` Route::get({url_route},{Controller@method}, {Middleware})->name({name_route}) ```

 ### Controller:
  - ``` ./src/Controllers ```

 ### Views:
  - ~~``` ./src/Views ``` Sử dụng twig template 2.x vui lòng đọc doc tại [a link](https://twig.symfony.com/doc/2.x/)~~
  - BladeOne được tạo ra tương tự như blade trong laravel [BladeOne](https://github.com/EFTEC/BladeOne)
    * <pre><code>@route({"name": "home", "id" : 3})</code></pre> Function route được thêm vào để lấy url theo name route. Tham số truyền vào là 1 json, bắt buộc phải có key "name", tham số tiếp theo tùy chọn theo route
    * <pre><code>@csrf_token()</code></pre> Function tạo ra chuỗi csrf token
    * <pre><code>@csrf_field()</code></pre> Function tạo thẻ html input chứa csrf token


 ### Models
  - ``` ./src/Models ``` Models sẽ được viết tại đây. Kế thừa từ class Models ``` ./src/Core/Abstracts/Models.php ```

 ### Cache
  - Khởi động ứng dụng sẽ tạo ra thư mục ```./src/cache``` và ```./src/config```nếu không tồn tại
  - ```./src/cache```Cache database và cache view
  - ```./src/config`` Cache config
  - Chạy command ```php Cm app:cache config``` để remove cache và setup lại

  -------------------------------

  ## Example
    Hầu hết các tính năng đều dựa trên framework laravel

  ### Khởi động
  ``` cp .env.example .env ``` (Tạo file .env)
  ``` php cm app:cache config --all ``` (Tạo các file và thư mục cache và config hệ thống)
  ``` php cm key:generate ``` (Tạo APP_KEY trong file .env. APP_KEY sử dụng mã hóa AES-128-CTR)
  ### Create
  - Eloquent
 ``` $user =  new Users(); $user->name = "Công Minh";<br /> $user->birthday = "10/12/1999";<br /> $user->address = "Hai Duong";<br /> $id = $user->save(); ```
  - Query
 ``` $id = DB::insert('INSERT INTO users (name, birthday, address) VALUES (:name, :birthday, :address); SELECT LAST_INSERT_ID();', ['name' => "Công Minh",<br />'birthday' =><br /> '10/12/1999','address' =><br /> 'Hai Duong']); ```

  ### Update
  - Eloquent
  ```
      $user =  Users::find(12);  // Mặc định khi truyền 1 tham số thì trường tìm kiếm sẽ là 'id' hoặc User::find('id', 12)
      $user->name = "Công Minh";
      $user->birthday = "10/12/1999";
      $user->address = "Hai Duong";
      $id = $user->save();
      ```
  - Query
  ``` $id = DB::update('UPDATE users SET name = :name, birthday = :birthday, address = :address WHERE id in (26,27,28,29);', [<br />'name' => "Công Minh",<br />'birthday' => '10/12/1999',<br />'address' => 'Hai Duong'<br />]); ```
         
  ### Select
  - Eloquent
  ```
      $user = User::all(); // Lấy tất cả bản ghi
      $user = User::where('name', 'Công minh)->get();
      $user = Users::whereLike('name', 'minh')->orWhere('address', 'Hai Duong')->get();
      $user = User::where('name', 'Công minh)->orWhereLike('address', 'address')->orderBy('id', 'DESC')->get();
      $user = Users::where([
          ['name', '=' ,'Công Minh'],
          ["address", 'like' ,"%Hai%"]
        ])->get();
      $user = Users::where('name', 'minh')->Where('address', 'address')->get();

      $user = Users::with('subject', 'School')->where('name', 'minh')->get(); // Relationship model tương tự như laravel, cấu hình trong model
      ```
     Xem thêm các phương thức tại ``` /src/Core/Abstracts/ModelsForward.php ```
  - Query
  ``` $id = DB::update('UPDATE users SET name = :name, birthday = :birthday, address = :address WHERE id in (26,27,28,29);', [
                'name' => "Công Minh",
                'birthday' => '10/12/1999',
                'address' => 'Hai Duong'
         ]); ```


### Đang cập nhật 

  


[Bronoz](https://www.facebook.com/congminher/)