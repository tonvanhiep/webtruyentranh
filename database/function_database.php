<?php

include 'connect_database.php';

// tim kiem ten truyen hoac tac gia
function timkiemtruyen($timkiem) {
    $sql_query = "SELECT * FROM TRUYEN WHERE TENTRUYEN LIKE '%$timkiem%' OR TACGIA LIKE '%$timkiem%'
    UNION
    SELECT * FROM TENTRUYEN_KHAC TRK JOIN TRUYEN TR ON TRK.MSTRUYEN = TR.MSTRUYEN WHERE TENKHAC LIKE '%$timkiem%'";
    $dstruyen = [];
    $dstruyen = EXECUTE_RESULT($sql_query);
    return $dstruyen;
}


function themluotxem($mstruyen) {
    EXECUTE("INSERT INTO luotxem_truyen (MSTRUYEN) VALUES ('$mstruyen')");
}
function tangluotxem($mstruyen) {
    EXECUTE("UPDATE luotxem_truyen SET LUOTXEM = LUOTXEM + 1 WHERE MSTRUYEN = $mstruyen");
}


function thembinhluantruyen($user_tendn, $mstruyen, $tieude, $noidung) {
    if($user_tendn == null || $user_tendn == "") echo "BẠN CẦN PHẢI ĐĂNG NHẬP";
    else EXECUTE("INSERT INTO binhluan_truyen (MSTRUYEN, NGUOIDANG, TIEUDE, NOIDUNG) VALUES ('$mstruyen', '$user_tendn', '$tieude''$noidung')");
}
function xoabinhluantruyen($msbl) {
    EXECUTE("DELETE FROM binhluan_truyen WHERE MSBL = $msbl");
}
function chinhsuabinhluan($msbl, $tieude, $noidung) {
    EXECUTE("UPDATE binhluan_truyen SET TIEUDE = '$tieude', NOIDUNG = '$noidung' WHERE MSBL = $msbl");
}
function sobinhluantruyen($mstruyen) {
    $ketqua = EXECUTE_RESULT("SELECT COUNT(*) SL FROM binhluan_truyen WHERE MSTRUYEN = $mstruyen");
    return $ketqua[0]['SL'];
}


function themchuongtruyen($mstruyen, $tenchuong) {
    EXECUTE("INSERT INTO chuongtruyen (MSTRUYEN, TENCHUONG) VALUES ('$mstruyen', '$tenchuong')");
}
function chinhsuachuongtruyen($mschuong, $tenchuong) {
    EXECUTE("UPDATE chuongtruyen SET TENCHUONG = '$tenchuong' WHERE MSCHUONG = $mschuong");
}
function xoachuongtruyen($mschuong) {
    EXECUTE("DELETE FROM chuongtruyen WHERE MSCHUONG = $mschuong");
}
function sochuongtruyen($mstruyen) {
    $ketqua = EXECUTE_RESULT("SELECT SOCHUONG SL FROM truyen WHERE MSTRUYEN = $mstruyen");
    return $ketqua[0]['SL'];
}


function doimatkhau($user_tendn, $mkcu, $mkmoi) {
    EXECUTE("UPDATE dangnhap SET MATKHAU = '$mkmoi' WHERE TENDN = '$user_tendn' AND MATKHAU = '$mkmoi'");
}
function kiemtradangnhap($user_tendn, $mkhau) {
    $ketqua = EXECUTE_RESULT("SELECT COUNT(*) SL FROM dangnhap WHERE TENDN = '$user_tendn' AND MATKHAU = '$mkhau'");
    if($ketqua[0]['SL'] == 0) return 0;
    else return 1;
}
function phanquyen($user_tendn, $quyen) {
    $pquyen = "";
    if($quyen == 0) $pquyen = "MEMBER";
    else $pquyen = "ADMIN";
    EXECUTE("UPDATE dangnhap SET LOAIDN = '$pquyen' WHERE TENDN = $user_tendn");
}
function capquyenadmin($user_tendn) {
    phanquyen($user_tendn, 1);
}
function themdangnhap($user_tendn, $mkhau) {
    EXECUTE("INSERT INTO dangnhap (TENDN, MATKHAU, LOAIDN) VALUES ('$user_tendn', '$mkhau', 'MEMBER')");
}


function themdanhgiatruyen($user_tendn, $mstruyen, $diem) {
    if($user_tendn == null || $user_tendn == "") echo "BẠN CẦN PHẢI ĐĂNG NHẬP";
    else EXECUTE("INSERT INTO danhgia_truyen (MSTRUYEN, DIEM, NGUOIDG) VALUES ('$mstruyen', '$diem', '$user_tendn')");
}
function xoadanhgiatruyen($msdg) {
    EXECUTE("DELETE FROM danhgia_truyen WHERE MSDG = $msdg");
}
function sodanhgiatruyen($mstruyen) {
    $ketqua = EXECUTE_RESULT("SELECT COUNT(*) SL FROM danhgia_truyen WHERE MSTRUYEN = $mstruyen");
    return $ketqua[0]['SL'];
}


function themdiemdanhgiatruyen($mstruyen) {
    EXECUTE("INSERT INTO diemdg_truyen (MSTRUYEN) VALUES ('$mstruyen')");
}


function themfiledinhkemphanhoi($msph, $link) {
    EXECUTE("INSERT INTO filedinhkem_phanhoi (MSPH, LINK) VALUES ('$msph', '$link')");
}
function sofiledinhkemphanhoi($msph) {
    $ketqua = EXECUTE_RESULT("SELECT COUNT(*) SL FROM filedinhkem_phanhoi WHERE MSPH = $msph");
    return $ketqua[0]['SL'];
}


function themlichsudoc($user_tendn, $mstruyen) {
    EXECUTE("INSERT INTO lichsudoc (MSTRUYEN, NGUOIDOC) VALUES ('$mstruyen', '$user_tendn')");
}
function solichsudoc($user_tendn) {
    $ketqua = EXECUTE_RESULT("SELECT COUNT(*) SL FROM lichsudoc WHERE TENDN = '$user_tendn'");
    return $ketqua[0]['SL'];
}


function themguiphanhoi($user_tendn, $nguoinhan, $tieude, $noidung) {
    EXECUTE("INSERT INTO phanhoi (NGUOIGUI, NGUOINHAN, TIEUDE, NOIDUNG) VALUES ('$user_tendn', '$nguoinhan', '$tieude', '$noidung')");
}


function themquocgia($quocgia) {
    EXECUTE("INSERT INTO quocgia (TENQG) VALUES ('$quocgia')");
}


function themtaikhoan($user_tendn, $mkhau, $email) {
    EXECUTE("INSERT INTO taikhoan (TENDN, EMAIL) VALUES ('$user_tendn', '$email'");
    themdangnhap($user_tendn, $mkhau);
}
function xoataikhoan($user_tendn) {
    EXECUTE("DELETE FROM taikhoan WHERE TENDN = '$user_tendn'");
}
function chinhsuagioitinh($user_tendn, $gtinh) {
    $tengt = "";
    if($gtinh == 0) $tengt = "NỮ";
    else $tengt = "NAM";
    EXECUTE("UPDATE taikhoan SET GIOITINH = '$tengt' WHERE TENDN = '$user_tendn'");
}
function chinhsuafacebook($user_tendn, $facebook) {
    EXECUTE("UPDATE taikhoan SET FACEBOOK = '$facebook' WHERE TENDN = '$user_tendn'");
}
function chinhsuaadd($user_tendn, $anhdd) {
    EXECUTE("UPDATE taikhoan SET ANHDD = '$anhdd' WHERE TENDN = '$user_tendn'");
}
function chinhsuangaysinh($user_tendn, $dd, $mm, $yyyy) {
    EXECUTE("UPDATE taikhoan SET NGAYSINH = '$yyyy-$mm-$dd' WHERE TENDN = '$user_tendn'");
}


function themtentruyenkhac($mstruyen, $tenkhac) {
    EXECUTE("INSERT INTO tentruyen_khac (MSTRUYEN, TENKHAC) VALUES ('$mstruyen', '$tenkhac')");
}
function chinhsuatentruyenkhac($id, $tenkhac) {
    EXECUTE("UPDATE tentruyen_khac SET TENKHAC = '$tenkhac' WHERE ID = $id");
}
function xoatentruyenkhac($id) {
    EXECUTE("DELETE FROM tentruyen_khac WHERE ID = $id");
}


function themtheloai($theloai) {
    EXECUTE("INSERT INTO theloai (TENTL) VALUES ('$theloai')");
}
function chinhsuatheloai($mstl, $theloai) {
    EXECUTE("UPDATE theloai SET TENTL = '$theloai' WHERE MSTL = $mstl");
}
function xoatheloai($mstl) {
    EXECUTE("DELETE FROM theloai WHERE MSTL = $mstl");
}


function themtheloaitruyen($mstruyen, $mstl) {
    EXECUTE("INSERT INTO theloai_truyen (MSTRUYEN, MSTL) VALUES ('$mstruyen', '$mstl')");
}
function chinhsuatheloaitruyen($id, $mstl) {
    EXECUTE("UPDATE theloai_truyen SET MSTL = '$mstl' WHERE ID = $id");
}
function xoatheloaitruyen($id) {
    EXECUTE("DELETE FROM theloai_truyen WHERE ID = $id");
}


function themtheodoi($user_tendn, $mstruyen) {
    EXECUTE("INSERT INTO theodoi (MSTRUYEN, NGUOIDOC) VALUES ('$mstruyen', '$user_tendn')");
}
function xoatheodoi($id) {
    EXECUTE("DELETE FROM theodoi WHERE ID = $id");
}
function sotheodoi($user_tendn) {
    $ketqua = EXECUTE_RESULT("SELECT COUNT(*) SL FROM theodoi WHERE TENDN = '$user_tendn'");
    return $ketqua[0]['SL'];
}


function themtrangtruyen($mschuong, $anhtr) {
    EXECUTE("INSERT INTO trangtruyen (MSCHUONG, ANHTRUYEN) VALUES ('$mschuong', '$anhtr')");
}
function xoatrangtruyen($mstrang) {
    EXECUTE("DELETE FROM trangtruyen WHERE MSTRANG = $mstrang");
}
function chinhsuatrangtruyen($mstrang, $link) {
    EXECUTE("UPDATE trangtruyen SET ANHTRUYEN = '$link' WHERE MSTRANG = $mstrang");
}
function sotrangtruyen($mschuong) {
    $ketqua = EXECUTE_RESULT("SELECT SOTRANG FROM CHUONGTRUYEN WHERE MSCHUONG = $mschuong");
    return $ketqua[0]['SOTRANG'];
}


function themtruyen($tentr, $tgia, $ngdang, $qgia, $mota) {
    EXECUTE("INSERT INTO truyen (TENTRUYEN, TACGIA, NGUOIDANG, QUOCGIA, MOTA) VALUES ('$tentr', '$tgia', '$ngdang', '$qgia', '$mota')");
}
function xoatruyen($mstruyen) {
    EXECUTE("DELETE FROM truyen WHERE MSTRUYEN = $mstruyen");
}
function chinhsuatinhtrang($mstruyen, $tt) {
    $tentt = "";
    switch($tt) {
        case 1: $tentt = "CHỜ DUYỆT";
            break;
        case 2: $tentt = "ĐANG TIẾN HÀNH";
            break;
        case 3: $tentt = "TẠM NGƯNG";
            break;
        case 4: $tentt = "ĐÃ HOÀN THÀNH";
            break;
    }
    EXECUTE("UPDATE truyen SET TINHTRANG = '$tentt' WHERE MSTRUYEN = $mstruyen");
}
function chinhsuamota($mstruyen, $mota) {
    EXECUTE("UPDATE truyen SET MOTA = '$mota' WHERE MSTRUYEN = '$mstruyen'");
}
function chinhsuatentruyen($mstruyen, $ttruyen) {
    EXECUTE("UPDATE truyen SET TENTRUYEN = '$ttruyen' WHERE MSTRUYEN = '$mstruyen'");
}
function chinhsuatacgia($mstruyen, $tgia) {
    EXECUTE("UPDATE truyen SET TACGIA = '$tgia' WHERE MSTRUYEN = '$mstruyen'");
}
function chinhsuaquocgia($mstruyen, $qgia) {
    EXECUTE("UPDATE truyen SET QUOCGIA = '$qgia' WHERE MSTRUYEN = '$mstruyen'");
}
function duyettruyen($mstruyen) {
    chinhsuatinhtrang($mstruyen, 2);
}


?>