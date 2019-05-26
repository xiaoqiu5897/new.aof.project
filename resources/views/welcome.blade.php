<div class="show_content_pc">TRUNG TÂM ĐÀO TẠO LẬP TRÌNH VIÊN QUỐC TẾ
    FPT-APTECH
HƯỚNG DẪN XÂY DỰNG ỨNG DỤNG WEB 
VỚI 
MACROMEDIA DREAMWEAVER MX
(Tài liệu bổ sung thực hiện project)
09/2003
Xây dựng trang web động với công cụ Dreamweaver MX
HƯỚNG DẪN XÂY DỰNG ỨNG DỤNG WEB VỚI 
MACROMEDIA DREAMWEAVER MX
I. Giới thiệu
1. Các bước cần thực hiện
a. Cấu hình hệ thống và Môi trường làm việc của Dreamweaver MX
b. Tạo Database
c. Thiết lập web site và tạo kết nối vào Database.
 Định 
nghĩa web site
 Chế độ 
làm việc đối với server
 Tạo 
<div style="text-align: center;margin-top: 10px"><script async="" src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-2979760623205174" data-ad-slot="9854054443"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script></div>
liên kết với database
 Publish 
web site vừa tạo lên PWS
 Xem 
trang web trong trình duyệt.
d. Tạo các dạng trang web thao tác có kết nối Database.
2. Web site minh họa
a. Nội dung: Trong phần này chúng ta minh họa việc tạo một web site giới thiệu mặt hàng 
điện thoại. Chế độ làm việc với Server thông qua các trang Active Server Page (asp). 
b. Chức năng thao tác:
- Trang login
- Trang logout
- Hiển thị dữ liệu theo danh sách theo dạng bảng
- Hiển thị dữ liệu theo danh sách dạng Master-Detail
- Nhập mới dữ liệu 
- Cập nhật dữ liệu dạng Master-Detail (Search Update)
- Cập nhật dữ liệu trên cùng một form (Search Update)
- Xoá dữ liệu (Search Delete)
c. Bố trí các trang:
Trang chủ  Trang Login  Trang chọn nội dung 
(Index_Login)
 Danh sách dạng bảng
 Danh sách dạng Master-Detail
 Nhập mới 
 Cập nhật dạng Master-Detail
 Cập nhật trên cùng một form
 Xoá dữ liệu
 Trang logout
(default.htm) (Login.asp) (Index_Login.htm
d. Nội dung từng trang
 Trang 
chủ: gồm 3 frame
Contents &lt;Banner&gt;
Page of 33
1
Xây dựng trang web động với công cụ Dreamweaver MX
Login &lt;Nội dung&gt;
Hình 1: trang Index.htm
 Trang 
Login.asp
LOGIN FORM
User name:
Password:
Submit
Hình 2: Trang Login.htm
Trang Login khi được gọi sẽ chiếm trọn màn hình hiện tại.
 Trang 
Index_Login.htm
Contents
Display
Dipslay Mas_Detail
Insert
Update Two Form
Update One Form
Delete
Logout
&lt;Banner&gt;
&lt;Nội dung&gt;
Hình 3: Trang Index_Login.htm
Trang Index_Login khi được gọi sẽ chiếm trọn màn hình hiện tại.
 Trang 
Logout.asp
• Đây là trang trống, chỉ chứa các đoạn mã JavaScript để đóng lại việc login.
• Chỉ đi kèm với việc đã login.
• Trang Logout.asp khi được gọi sẽ liên kết đến trang default.htm, khi đó trang 
default.htm sẽ chiếm trọn màn hình hiện tại.
 Các 
trang còn lại sẽ được đề cập khi xây dựng từng trang.
Page of 33
2
Xây dựng trang web động với công cụ Dreamweaver MX
Page of 33
3
Xây dựng trang web động với công cụ Dreamweaver MX
II. Cấu hình hệ thống và Môi trường làm việc 
2. Cấu hính hệ thống
- Hệ điều hành: Windows 2000, có cài đặt thêm các công cụ “Internet Information 
Server” và “Personal Web Server”.
- Hệ quản trị dữ liệu: Ms Access 2000.
- Trình duyệt web: Internet Explorer 5.0 và Netscape Nevigator 4.7
- Dreamweaver MX.
 Cài đặt IIS và PWS: (Khi Windows chưa được cài đặt)
a. Trong Windows 2000 vào Control Panels, chọn “Add / Remove Programs”  
Hiển thị hộp thoại  chọn tab “Add / Remove Windows Components”  xuất hiện 
hộp thoại kế tiếp như hình 4.
Hình 4.
b. Đánh dấu chọn vào Checkbox “Internet Information Sevices (IIS), sau đó bấm 
vào nút lệnh Next và thực hiện các công việc theo yêu cầu (PWS là một component 
trong IIS, bấm vào nút lệnh Detail… để xem chi tiết).
c. Sau khi khởi động lại máy tính, ta sẽ có một thư mục web site mặc định là 
D:\\Interpub\wwwroot như hình 5 (giả sử cài windows 2000 trên ổ đĩa D:)
Hình 5
Page of 33
4
Xây dựng trang web động với công cụ Dreamweaver MX
2. Môi trường làm việc của Dreamweaver MX
a. Chọn giao diện làm việc giống Dreamweaver 4.0
- Vào menu Edit / Preferences  hiển thị hộp thoại Preferences
- Trong mục Category chọn General  chọn nút lệnh “Change workspace..” hiển thị 
hộp thoại như hình 6, sau đó chọn “Dreamwevaer 4 Workspace” (thay đổi chỉ có hiệu 
quả cho sử dụng Dreamweaver MX lần sau)
Hình 6.
b. Hiển thị Object Panels
- Trong Dreamweaver MX, để hiển thị Object Panels ta vào menu Windows / Insert  
Object Panel sẽ xuất hiện bên trái màn hình. Xem hình 7.
Hình 7.
Page of 33
5
Xây dựng trang web động với công cụ Dreamweaver MX
I. Tạo Database
- Database được tạo trong Ms.Access2000 (Data_Project.mdb).
- Bảng dữ liệu
Login
Name Data Type Decription
UName Text User name 
PWord Text Password
Mobile
Name Data Type Decription
Mcode Text Mobile code
SCode Text Supplier code (Distributor)
MName Text Mobile Name
DNotice Date / Time Date of notice
Price Number Price of mobile
Image OLE Object Mobile’s photographic or movie
Supplier
Name Data Type Decription
SCode Text Supplier code (Distributor)
SName Text Supplier’s Name
- Sơ đồ quan hệ như sau:
Hình 8.
Page of 33
6
Xây dựng trang web động với công cụ Dreamweaver MX
II. Thiết lập web site và kết nối Database
3. Định nghĩa site:
Việc định nghĩa site tương tự trong Dreamweaver 4.0, giả sử ta tiến hành khai báo các 
thông số như hình 9. Trong đó:
- Site name: tên của web site (Project)
- Local Root Folder: địa chỉ lưu trữ web site trên máy local (D:\Internetpub\wwwroot\project 
(có thể lưu ở bất cứ thư mục nào tuỳ ý).
- Default Images Folder: thư mục chứa ảnh của trang (nếu có)
- HTTP Address: Địa chỉ của web site trên máy local, sẽ khai báo ở phần “Testing Server”.
Hình 9
4. Chế độ làm việc đối với server
Ta phải chọn chế độ làm việc đối với server, ở đây ta chọn là ASP JavaScript
a. Mở panel “Application”: Trong web site “Project”, từ Laucher bar (hoặc từ menu 
Windows) chọn “Database”, xuất hiện panel “Application” như hình 10a.
Page of 33
7
Xây dựng trang web động với công cụ Dreamweaver MX
Hình 10a Hình 10b
b. Click chuột vào “testing server” để mở hộp thoại “Site Definition for Project” xuất hiện 
như hình 11.
Hình 11
Page of 33
8
Xây dựng trang web động với công cụ Dreamweaver MX
c. Điền các thông số như hình 11. Trong đó:
- Server Model: chọn công nghệ server (ASP JavaScript)
- Access: giao thức giao tiếp với server (Local / Network).
- Testing Server Folder: thư mục chứa web site.
- URL Prefix: Địa chỉ của web site trên máy local, giả sử chúng ta đặt cho web site một alias 
là “myproject” (hoặc là tên của thư mục hiện hành: project), thì địa chỉ sẽ là: 
http://localhost/myproject (xem phần tạo alias cho web site ở mục publish web site lên 
PWS)
- Chọn OK để kết thúc ta được hình 10b.
5. Tạo liên kết với database
Trong project này ta dùng cơ chế kết nối ODBC connection string.
Có 2 hình thức kết nối:
Cách 1. Kết nối dùng DSN
- Tạo kết nối DSN vào Database
- Trong Dreamweaver MX, tạo kết nối giữa ứng dụng với kết nối DSN. 

 Khi sao chép Site đến một máy khác thì phải định nghĩa lại DSN tương ứng thì 
 chương trình mới thi hành.
Cách 2. Kết nối do người dùng viết code.
- Trong Dreamweaver MX, tạo kết nối giữa ứng dụng với Database do người dùng viết 
code. Có 2 dạng  Đường dẫn tuyệt đối và đường dẫn tương đối

 Nên dùng đường dẫn tương đối 
 
 để sao chép và thi hành Web Site trên các máy 
 khác nhau được dễ dàng.
Kết nối DSN vào Database
a. Kích Start  Settings  Addministrative Tools  Data Sources, hộp thoại 
ODBC Data Source Administrator xuất hiện như hình 12.
Hình 12.
Page of 33
9
Xây dựng trang web động với công cụ Dreamweaver MX
b. Click vào nút lệnh “Add”, xuất hiện hộp thoại như hình 13.
Hình 13
c. Chọn driver là “Microsoft Access Driver” như như hình 13, sau đó bấm 
“Finish”, một hộp thoại sẽ xuất hiện như hình 14. Tiến hành điền Data Source Name, 
sau đó click vào nút “Select” để chọn Database (Giả sử ta đang lưu ở thư mục 
D:\\Interpub\wwwroot\Project), sau cùng click vào nút lệnh “OK” quay lại hộp thoại 
như hình 12 nhưng có thêm data source “MyDatabase” vừa tạo. Click vào nút “OK” để 
hoàn tất.
Hình 14
Page of 33
10
Xây dựng trang web động với công cụ Dreamweaver MX
d. Trong site Project, vào panel Application.
Hình 15
e. Chọn tab Database, nhấn chuột vào dấu + và chọn “Data Source Name (DSN)”, 
một hộp thoại “Data Source Name” xuất hiện. Điền các thông số vào như hình 16.
Hình 16
f. Bấm “Test” để kiểm tra sự kết nối, nếu thành công sẽ xuất hiện thông báo “Connection 
was made successfully”.
g. Sau khi kết nối thành công, cửa sổ Application sẽ thay đổi như sau: 
Hình 17
Page of 33
11
</div>