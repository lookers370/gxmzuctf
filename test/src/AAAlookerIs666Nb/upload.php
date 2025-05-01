<?php
// 处理文件上传
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "uploads/"; // 上传目录
    
    // 直接使用原始文件名
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // 尝试移动临时文件
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "文件 " . htmlspecialchars(basename($_FILES["file"]["name"])) . " 上传成功";
    } else {
        echo "文件上传失败";
    }
}
?>

<!DOCTYPE html>
<html>
<body>
<!-- 基础上传表单 -->
<form method="post" enctype="multipart/form-data">
    选择文件：<input type="file" name="file">
    <input type="submit" value="上传">
</form>
</body>
</html>