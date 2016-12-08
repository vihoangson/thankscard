<?php
require_once dirname(__FILE__) . "/../library/DB.php";
require_once dirname(__FILE__) . "/../config/config.php";
session_start();
if(!isset($_SESSION["admin"])) {
    header("Location: index.php");
}
//Connect DB
$db = new DB();
$db->db_connect();

//Select from DB
if(isset($_GET["uid"])) {
    $sql = "SELECT * FROM user WHERE user_id = ".$_GET["uid"];
    $rs = $db->db_query($sql);
    $users = $db->fetchAll($rs);
    foreach ($users as $user) {
        $id = $user['user_id'];
        $eid = $user['user_eid'];
        $name = $user['user_nick_name'];
        $gwid = $user['user_gwid'];
    }
}

//Update user information
if(isset($_POST["id"])){
    $p_id = $db->db_escape_string($_POST["id"]);
    $p_eid = $db->db_escape_string($_POST["eid"]);
    $p_nickname = $db->db_escape_string($_POST["name"]);
    $p_gwid = $db->db_escape_string($_POST["gwid"]);

    if($_FILES["user_image"]["tmp_name"]){
        $extention_file = preg_match("/\.([a-z])+$/",$_FILES["user_image"]["name"],$match);
        $file_name = $_FILES["user_image"]["name"].$user_eid.$match[0];
        move_uploaded_file($_FILES["user_image"]["tmp_name"],"../images/".$file_name);
        $file_name = ", user_img = '{$file_name}'";
    }else{
        $file_name = "";
    }
    print_r($file_name);

    $sql = "UPDATE user SET user_eid = '{$p_eid}', user_nick_name = '{$p_nickname}', user_gwid = '{$p_gwid}'  {$file_name} WHERE user_id=" . $p_id;
    $db->db_query($sql);
    header("Location: ../admin/user.php");
}
?>
<!DOCTYPE html>
<html>
<body>
    <h1><?php echo $name ?>'s information</h1>
    <div style="margin:0px 0px 0px 0px;">
        <form id="userIn" action="../admin/edit.php" method="POST" onsubmit="return formValidator()"enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="<?php echo $id ?>" style="margin:0px 0px 0px 48px;"></input>
            <span>User EID:</span><input type="text" name="eid" id="eid" style="margin:5px 0px 0px 38px;" value="<?php echo $eid;?>" ></input></br>
            <span>Nickname:</span><input type="text" name="name" id="name" style="margin:5px 0px 0px 35px;" value="<?php echo $name;?>"></input></br>
            <span>GWID:</span><input type="text" name="gwid" id="gwid" style="margin:5px 0px 0px 35px;" value="<?php echo $gwid;?>"></input></br>
            <p><span>IMG:</span><input type="file" name="user_image"></p>
            <input type="submit" id="submit" value="Submit" style="margin:25px 0px 0px 35px;"></input>
        </form>
    </div>
    <script>
        //Run form
        function formValidator(){
                if(checkeid() && checkname()){
                    var content = "Bạn có đồng ý với nội dung sau:"+"\nUser EID:"+document.getElementById("eid").value+"\nNickname:"+document.getElementById("name").value;
                    var r=confirm(content);
                    if (r==true)
                    {
                        return true;
                    }else{
                        return false;
                    }
                }
                return false;
        }

        //Check name
        function checkname(){
                var checkname = /^[a-zA-Z]+\s*/;
                var name = document.getElementById("name");

                if(name.value.match(checkname)){
                    return true;
                }else if (name.value.length==0) {
                    alert("Name không được bỏ trống!");
                    return false;
                }else{
                    //xuất báo lỗi
                    alert("Name chỉ được nhập kiểu chữ!");
                    return false;
                }
        }

        //Check eid
        function checkeid(){
                var checkeid = /^[0-9]{7,10}$/;
                var eid = document.getElementById("eid");

                if(eid.value.match(checkeid)){
                    return true;
                }else if (eid.value.length==0) {
                    alert("EID không được bỏ trống!");
                    return false;
                }else{
                    //xuất báo lỗi
                    alert("EID chỉ được nhập kiểu số và phải có từ 7 đến 10 ký tự!");
                    return false;
                }
        }
    </script>
</body>
</html>
