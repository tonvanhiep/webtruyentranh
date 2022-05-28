<?php
define('HOST', 'localhost');
define('USENAME', 'root');
define('PASSWORD', '');
define('N_DATABASE', 'PROJECT_WEB_TRUYEN');



$connect = mysqli_connect(HOST, USENAME, PASSWORD);

if (!$connect) {
    die("#101: KẾT NỐI HOST THẤT BẠI. " . "<br>" . mysqli_connect_error());
}
else {
    echo "(1/5) KẾT NỐI HOST THÀNH CÔNG." . "<br>";
}



// Kiểm tra database có tồn tại không
$sql_query = "SELECT SCHEMA_NAME
FROM INFORMATION_SCHEMA.SCHEMATA
WHERE SCHEMA_NAME = '". N_DATABASE ."' ";

$result = mysqli_query($connect, $sql_query);

$data = array();
$data = mysqli_fetch_array($result, 1);

echo "<br>" . "DATABASE '" . N_DATABASE;

if(empty($data['SCHEMA_NAME'])) {
    echo "' CHƯA TỒN TẠI" . "<br>";
}
else {
    die("' ĐÃ TỒN TẠI" . "<br>" . "<br>" . "========== KẾT THÚC ==========");
}



// Lệnh tạo database
$sql_query = "CREATE DATABASE IF NOT EXISTS ".N_DATABASE." CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

// Thực thi câu truy vấn
if (!mysqli_query($connect, $sql_query)) {
    die("<br>" . "#102: TẠO DATABASE THẤT BẠI. " . "<br>" . mysqli_error($connect));
}
else {
    echo "<br>" . "(2/5) TẠO DATABASE THÀNH CÔNG." . "<br>";
}



mysqli_select_db($connect, N_DATABASE);



echo "<br>" . "TẠO TABLE... " . "<br>";

$table = array();

$table[0] = "CREATE TABLE TAIKHOAN (
    TENDN VARCHAR(50) PRIMARY KEY,
    EMAIL CHAR(100) NOT NULL,
    GIOITINH VARCHAR(3) CHECK (GIOITINH IN ('NAM', 'NỮ')),
    FACEBOOK VARCHAR(200),
    ANHDD VARCHAR(200),
    NGAYSINH DATE,
    NGAYKT DATETIME,
    NGAYCN DATETIME
  );";

$table[1] = "CREATE TABLE DANGNHAP (
    TENDN VARCHAR(50) REFERENCES TAIKHOAN(TENDN),
    MATKHAU CHAR(20) NOT NULL,
    LOAIDN CHAR(20) CHECK (LOAIDN IN ('ADMIN', 'MEMBER')),
    NGAYKT DATETIME,
    NGAYCN DATETIME,
    CONSTRAINT TDN_UNI UNIQUE (TENDN)
  );";

$table[2] = "CREATE TABLE QUOCGIA (
  MSQG INT PRIMARY KEY AUTO_INCREMENT,
  TENQG VARCHAR(30));";

$table[3] = "CREATE TABLE TRUYEN (
    MSTRUYEN INT PRIMARY KEY AUTO_INCREMENT,
    TENTRUYEN VARCHAR(100) NOT NULL,
    TACGIA VARCHAR(50) NOT NULL,
    NGUOIDANG VARCHAR(50) REFERENCES TAIKHOAN(TENDN),
    TINHTRANG VARCHAR(50) CHECK (
      TINHTRANG IN (
        'CHỜ DUYỆT',
        'ĐANG TIẾN HÀNH',
        'TẠM NGƯNG',
        'ĐÃ HOÀN THÀNH'
      )
    ),
    QUOCGIA INT REFERENCES QUOCGIA(MSQG),
    SOCHUONG INT CHECK (SOCHUONG >= 0),
    MOTA LONGTEXT,
    NGAYKT DATETIME,
    NGAYCN DATETIME
  );";

$table[4] = "CREATE TABLE TENTRUYEN_KHAC (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    MSTRUYEN INT REFERENCES TRUYEN(MSTRUYEN),
    TENKHAC VARCHAR(200)
  );";

$table[5] = "CREATE TABLE THELOAI (
      MSTL INT PRIMARY KEY AUTO_INCREMENT,
      TENTL VARCHAR(50)
  );";

$table[6] = "CREATE TABLE THELOAI_TRUYEN (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    MSTRUYEN INT REFERENCES QUOCGIA(MSQG),
    MSTL INT REFERENCES THELOAI(MSTL),
    CONSTRAINT PK_TR_TL UNIQUE (MSTRUYEN, MSTL)
  );";

$table[7] = "CREATE TABLE CHUONGTRUYEN (
    MSCHUONG INT PRIMARY KEY AUTO_INCREMENT,
    MSTRUYEN INT REFERENCES TRUYEN(MSTRUYEN),
    TENCHUONG VARCHAR(100),
    SOTRANG INT,
    NGAYKT DATETIME,
    NGAYCN DATETIME
  );";

$table[8] = "CREATE TABLE TRANGTRUYEN (
    MSTRANG INT PRIMARY KEY AUTO_INCREMENT,
    MSCHUONG CHAR(10) REFERENCES CHUONGTRUYEN(MSTRUYEN),
    ANHTRUYEN VARCHAR(200)
  );";

$table[9] = "CREATE TABLE PHANHOI (
    MSPH INT PRIMARY KEY AUTO_INCREMENT,
    NGUOIGUI VARCHAR(50) REFERENCES TAIKHOAN(TENDN),
    NGUOINHAN VARCHAR(50) REFERENCES TAIKHOAN(TENDN),
    TIEUDE VARCHAR(200),
    NOIDUNG LONGTEXT,
    NGAYGUI DATETIME,
    TRANGTHAINN VARCHAR(30) CHECK (TRANGTHAINN IN ('ĐÃ ĐỌC','ĐÁNH DẤU SAO'))
  );";

$table[10] = "CREATE TABLE FILEDINHKEM_PHANHOI (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    MSPH INT REFERENCES PHANHOI(MSPH),
    LINK VARCHAR(200)
  );";

$table[11] = "CREATE TABLE BINHLUAN_TRUYEN (
    MSBL INT PRIMARY KEY AUTO_INCREMENT,
    MSTRUYEN INT REFERENCES TRUYEN(MSTRUYEN),
    NGUOIDANG VARCHAR(50) REFERENCES TAIKHOAN(TENDN),
    TIEUDE VARCHAR(200),
    NOIDUNG LONGTEXT,
    NGAYKT DATETIME,
    NGAYCN DATETIME
  );";

$table[12] = "CREATE TABLE DANHGIA_TRUYEN (
    MSDG INT PRIMARY KEY AUTO_INCREMENT,
    MSTRUYEN INT REFERENCES TRUYEN(MSTRUYEN),
    DIEM INT CHECK (DIEM >= 1 AND DIEM <= 5),
    NGUOIDG VARCHAR(50) REFERENCES TAIKHOAN(TENDN),
    NGAYKT DATETIME,
    NGAYCN DATETIME
  );";

$table[13] = "CREATE TABLE THONGBAO (
    MSTB INT PRIMARY KEY AUTO_INCREMENT,
    NGUOINTB VARCHAR(50) REFERENCES TAIKHOAN(TENDN),
    THOIGIAN DATETIME,
    TRANGTHAI VARCHAR(10) CHECK (TRANGTHAI IN ('Đã đọc', 'Chưa đọc')),
    NOIDUNG LONGTEXT
  );";

$table[14] = "CREATE TABLE LICHSUDOC (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  MSTRUYEN INT REFERENCES TRUYEN(MSTRUYEN),
  NGUOIDOC VARCHAR(50) REFERENCES TAIKHOAN(TENDN),
  THOIGIAN DATETIME);";

$table[15] = "CREATE TABLE THEODOI (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  MSTRUYEN INT REFERENCES TRUYEN(MSTRUYEN),
  NGUOIDOC VARCHAR(50) REFERENCES TAIKHOAN(TENDN),
  THOIGIAN DATETIME);";

$table[16] = "CREATE TABLE LUOTXEM_TRUYEN (
  MSTRUYEN INT UNIQUE REFERENCES TRUYEN(MSTRUYEN),
  LUOTXEM INT);";

$table[17] = "CREATE TABLE DIEMDG_TRUYEN (
  MSTRUYEN INT UNIQUE REFERENCES TRUYEN(MSTRUYEN),
  DIEM FLOAT);";

for ($i = 0; $i <= 17; $i++) {
  $sql_query = $table[$i];
  
  if (!mysqli_query($connect, $sql_query)) {
    echo "<br>" . "#103: TẠO TABLE THẤT BẠI. " . "<br>" . mysqli_error($connect);
    mysqli_close($connect);
    die("<br>" . "========== KẾT THÚC ==========");
  }
  else {
    echo ($i+1) . " / 18" . "<br>";
  }

}

echo "<br>" . "(3/5) TẠO TABLE THÀNH CÔNG." . "<br>";



echo "<br>" . "TẠO TRIGGER... " . "<br>";

$trigger = array();
$trigger[0] = "CREATE TRIGGER THEM_CHUONG_TRUYEN
  BEFORE INSERT 
  ON chuongtruyen
  FOR EACH ROW
  BEGIN
    SET NEW.NGAYKT = NOW();
    SET NEW.NGAYCN = NOW();
    SET NEW.SOTRANG = (SELECT COUNT(*) FROM trangtruyen TT WHERE TT.MSCHUONG = NEW.MSCHUONG);
  END";

$trigger[1] = "CREATE TRIGGER SUA_CHUONG_TRUYEN
  BEFORE UPDATE 
  ON chuongtruyen
  FOR EACH ROW
  BEGIN
    SET NEW.NGAYKT = OLD.NGAYKT;
    SET NEW.NGAYCN = NOW();
    SET NEW.SOTRANG = (SELECT COUNT(*) FROM trangtruyen TT WHERE TT.MSCHUONG = NEW.MSCHUONG);
  END";

$trigger[2] = "CREATE TRIGGER XOA_CHUONG_TRUYEN
  BEFORE DELETE 
  ON chuongtruyen
  FOR EACH ROW
  BEGIN
	  DELETE FROM trangtruyen WHERE MSCHUONG = OLD.MSCHUONG;
    UPDATE truyen
    SET SOCHUONG = (SELECT COUNT(*) FROM chuongtruyen CT WHERE CT.MSTRUYEN = OLD.MSTRUYEN) - 1
    WHERE MSTRUYEN = OLD.MSTRUYEN;
  END";

$trigger[3] = "CREATE TRIGGER XOA_TRUYEN
  BEFORE DELETE 
  ON truyen
  FOR EACH ROW
    BEGIN
	    DELETE FROM binhluan_truyen WHERE MSTRUYEN = OLD.MSTRUYEN;
      DELETE FROM chuongtruyen WHERE MSTRUYEN = OLD.MSTRUYEN;
      DELETE FROM danhgia_truyen WHERE MSTRUYEN = OLD.MSTRUYEN;
      DELETE FROM diemdg_truyen WHERE MSTRUYEN = OLD.MSTRUYEN;
      DELETE FROM lichsu WHERE MSTRUYEN = OLD.MSTRUYEN;
      DELETE FROM luotxem_truyen WHERE MSTRUYEN = OLD.MSTRUYEN;
      DELETE FROM tentruyen_khac WHERE MSTRUYEN = OLD.MSTRUYEN;
      DELETE FROM theloai_truyen WHERE MSTRUYEN = OLD.MSTRUYEN;
      DELETE FROM theodoi WHERE MSTRUYEN = OLD.MSTRUYEN;
    END";


$trigger[4] = "CREATE TRIGGER SUA_BL_TRUYEN
  BEFORE UPDATE 
  ON binhluan_truyen
  FOR EACH ROW
  BEGIN
    SET NEW.NGAYKT = OLD.NGAYKT;
    SET NEW.NGAYCN = NOW();
  END";

$trigger[5] = "CREATE TRIGGER THEM_BL_TRUYEN
  BEFORE INSERT 
  ON binhluan_truyen
  FOR EACH ROW
  BEGIN
    SET NEW.NGAYKT = NOW();
    SET NEW.NGAYCN = NOW();
  END";

$trigger[6] = "CREATE TRIGGER THEM_DANG_NHAP
  BEFORE INSERT 
  ON dangnhap
  FOR EACH ROW
  BEGIN
    SET NEW.NGAYKT = NOW();
    SET NEW.NGAYCN = NOW();
  END";

$trigger[7] = "CREATE TRIGGER SUA_DANG_NHAP
  BEFORE UPDATE
  ON dangnhap
  FOR EACH ROW
  BEGIN
    SET NEW.NGAYKT = OLD.NGAYKT;
    SET NEW.NGAYCN = NOW();
  END";

$trigger[8] = "CREATE TRIGGER THEM_DANH_GIA_TRUYEN_TRC
  BEFORE INSERT
  ON danhgia_truyen
  FOR EACH ROW
  BEGIN
	  SET NEW.NGAYKT = NOW();
    SET NEW.NGAYCN = NOW();
  END";

$trigger[9] = "CREATE TRIGGER THEM_DANH_GIA_TRUYEN_SAU
  AFTER INSERT
  ON danhgia_truyen
  FOR EACH ROW
  BEGIN
	  UPDATE diemdg_truyen
    SET DIEM = (SELECT AVG(DGT.DIEM) FROM danhgia_truyen DGT WHERE DGT.MSTRUYEN = NEW.MSTRUYEN)
    WHERE MSTRUYEN = NEW.MSTRUYEN;
  END";

$trigger[10] = "CREATE TRIGGER SUA_DANH_GIA_TRUYEN_TRC
  BEFORE UPDATE
  ON danhgia_truyen
  FOR EACH ROW
  BEGIN
	  SET NEW.NGAYKT = OLD.NGAYKT;
    SET NEW.NGAYCN = NOW();
  END";

$trigger[11] = "CREATE TRIGGER SUA_DANH_GIA_TRUYEN_SAU
  AFTER UPDATE
  ON danhgia_truyen
  FOR EACH ROW
  BEGIN
	  UPDATE diemdg_truyen
    SET DIEM = (SELECT AVG(DGT.DIEM) FROM danhgia_truyen DGT WHERE DGT.MSTRUYEN = NEW.MSTRUYEN)
    WHERE MSTRUYEN = NEW.MSTRUYEN;
  END";

$trigger[12] = "CREATE TRIGGER XOA_DANH_GIA_TRUYEN
  AFTER DELETE
  ON danhgia_truyen
  FOR EACH ROW
  BEGIN
	  UPDATE diemdg_truyen
    SET DIEM = (SELECT AVG(DGT.DIEM) FROM danhgia_truyen DGT WHERE DGT.MSTRUYEN = OLD.MSTRUYEN)
    WHERE MSTRUYEN = OLD.MSTRUYEN;
  END";

$trigger[13] = "CREATE TRIGGER XOA_DIEM_DG_TRUYEN
  BEFORE DELETE
  ON diemdg_truyen
  FOR EACH ROW
  BEGIN
	  DELETE FROM danhgia_truyen WHERE MSTRUYEN = OLD.MSTRUYEN;
  END";

$trigger[14] = "CREATE TRIGGER THEM_PHAN_HOI
  BEFORE INSERT ON phanhoi
  FOR EACH ROW
  BEGIN
	  SET NEW.NGAYGUI = NOW();
  END";

$trigger[15] = "CREATE TRIGGER XOA_PHAN_HOI
  BEFORE DELETE ON phanhoi
  FOR EACH ROW
  BEGIN
	  DELETE FROM filedinhkem_phanhoi WHERE MSPH = OLD.MSPH;
  END";

$trigger[16] = "CREATE TRIGGER XOA_QUOC_GIA
  BEFORE DELETE ON quocgia
  FOR EACH ROW
  BEGIN
	  DELETE FROM truyen WHERE QUOCGIA = OLD.MSQG;
  END";

$trigger[17] = "CREATE TRIGGER THEM_TAI_KHOAN_TRC
  BEFORE INSERT ON taikhoan
  FOR EACH ROW
  BEGIN
	  SET NEW.NGAYKT = NOW();
    SET NEW.NGAYCN = NOW();
  END";

$trigger[18] = "CREATE TRIGGER SUA_TAI_KHOAN_TRC
  BEFORE UPDATE ON taikhoan
  FOR EACH ROW
  BEGIN
	  SET NEW.NGAYKT = OLD.NGAYKT;
    SET NEW.NGAYCN = NOW();
  END";

$trigger[19] = "CREATE TRIGGER XOA_TAI_KHOAN
  BEFORE DELETE ON taikhoan
  FOR EACH ROW
  BEGIN
    DELETE FROM dangnhap WHERE TENDN = OLD.TENDN;
    DELETE FROM truyen WHERE NGDANG = OLD.TENDN;
    DELETE from binhluan_truyen WHERE NGUOIDANG = OLD.TENDN;
  END";

$trigger[20] = "CREATE TRIGGER XOA_THE_LOAI
  BEFORE DELETE ON theloai
  FOR EACH ROW
  BEGIN
    DELETE FROM theloai_truyen WHERE MSTL = OLD.MSTL;
  END";

$trigger[21] = "CREATE TRIGGER THEM_THEO_DOI
  BEFORE INSERT ON theodoi
  FOR EACH ROW
  BEGIN
    SET NEW.THOIGIAN = NOW();
  END";

$trigger[22] = "CREATE TRIGGER THEM_THONG_BAO
  BEFORE INSERT ON thongbao
  FOR EACH ROW
  BEGIN
    SET NEW.THOIGIAN = NOW();
  END";

$trigger[23] = "CREATE TRIGGER THEM_TRANG_TRUYEN
  AFTER INSERT ON trangtruyen
  FOR EACH ROW
  BEGIN
    UPDATE chuongtruyen
    SET SOTRANG = (SELECT COUNT(*) FROM trangtruyen TT WHERE TT.MSCHUONG = NEW.MSCHUONG)
    WHERE MSCHUONG = NEW.MSCHUONG;
  END";

$trigger[24] = "CREATE TRIGGER XOA_TRANG_TRUYEN
  AFTER DELETE ON trangtruyen
  FOR EACH ROW
  BEGIN
    UPDATE chuongtruyen
    SET SOTRANG = (SELECT COUNT(*) FROM trangtruyen TT WHERE TT.MSCHUONG = OLD.MSCHUONG)
    WHERE MSCHUONG = OLD.MSCHUONG;
  END";

$trigger[25] = "CREATE TRIGGER THEM_TRUYEN
  BEFORE INSERT ON truyen
  FOR EACH ROW
  BEGIN
    SET NEW.TINHTRANG = 'CHỜ DUYỆT';
    SET NEW.NGAYKT = NOW();
    SET NEW.NGAYCN = NOW();
  END";

$trigger[26] = "CREATE TRIGGER SUA_TRUYEN
  BEFORE UPDATE ON truyen
  FOR EACH ROW
  BEGIN
    SET NEW.NGAYKT = OLD.NGAYKT;
    SET NEW.NGAYCN = NOW();
  END";

$trigger[27] = "CREATE TRIGGER THEM_LICH_SU_DOC
  BEFORE INSERT ON lichsudoc
  FOR EACH ROW
  BEGIN
    SET NEW.THOIGIAN = NOW();
  END";

for ($i = 0; $i <= 27; $i++) {
  $sql_query = $trigger[$i];
  
  if (!mysqli_query($connect, $sql_query)) {
    echo "<br>" . "#104: TẠO TRIGGER THẤT BẠI. " . "<br>" . mysqli_error($connect);
    mysqli_close($connect);
    die("<br>" . "========== KẾT THÚC ==========");
  }
  else {
    echo ($i+1) . " / 28" . "<br>";
  }

}

echo "<br>" . "(4/5) TẠO TRIGGER THÀNH CÔNG." . "<br>";



// echo "<br>" . "TẠO FUNCTION... " . "<br>";
// $func = array();
// $func[0] = "CREATE PROCEDURE TANG_LUOT_XEM(IN MST INT)
//   BEGIN
//     UPDATE LUOTXEM_TRUYEN LXT
//     SET LXT.LUOTXEM = LXT.LUOTXEM + 1
//     WHERE LXT.MSTRUYEN = MST;
//   END";
// $func[1] = "";
// for ($i = 0; $i <= 0; $i++) {
//   $sql_query = $func[$i];
//   if (!mysqli_query($connect, $sql_query)) {
//     echo "<br>" . "#105: TẠO FUNCTION THẤT BẠI. " . "<br>" . mysqli_error($connect);
//     mysqli_close($connect);
//     die("<br>" . "========== KẾT THÚC ==========");
//   }
//   else {
//     echo ($i+1) . " / 29" . "<br>";
//   }
// }
// echo "<br>" . "(5/5) TẠO FUNCTION THÀNH CÔNG." . "<br>";



mysqli_close($connect);

echo "<br>" . "========== KẾT THÚC ==========";

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TẠO DATABASE</title>
</head>
<body>
  
</body>
</html>