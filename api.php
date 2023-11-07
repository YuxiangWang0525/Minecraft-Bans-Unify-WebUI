<?php
//跨域开始
header('Content-Type: text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); 

//载入配置文件 Load config file
$config = json_decode(file_get_contents("config.json"),true);
//连接数据库
$conn = new mysqli($config['database_host'], $config['database_user'], $config['database_password'], $config['database_name']);

$ban=array();

if ($conn->connect_error) {
    die("MySQL Connection Failed: " . $conn->connect_error);
}
//判断插件
switch($config['Plugin']){
    case 'AdvancedBan':advancedban();break;
    case 'BansPlus':bansplus();break;
}
//advancedban 数据库处理开始
function advancedban(){
    //获得type
    $type = $_GET['type'];
    global $conn;
    switch ($type){
        case "now":
            $sql = "SELECT * from Punishments";
            break;
        case "history":
            $sql = "SELECT * from PunishmentHistory";
           break; 
    
    }
    $result = $conn->query($sql);
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $banArr = array();
            foreach ($rows as $row) {
                $ban = array();
                $ban['name'] = $row['name'];
                $ban['uuid'] = $row['uuid'];
                switch($row['punishmentType']){
                    case "BAN":
                        $ban['type'] = "ban";
                        break;
                    case "TEMP_BAN":
                        $ban['type'] = "tempban";
                        break;
                    case "MUTE":
                        $ban['type'] = "mute";  
                        break;
                    case "TEMP_MUTE":
                        $ban['type'] = "tempmute";  
                        break;
                    case "KICK":
                        $ban['type'] = "kick"; 
                        break;
                }
                $ban['starttime'] = date("Y-m-d H:i:s", $row['start']);
                
                switch($row['end']){
                    case -1:
                        $ban['endtime'] = "Forever";
                        break;
                    default:
                        $ban['endtime'] = date("Y-m-d H:i:s", $row['end']);
                        break;
                }
                $ban['reason'] = $row['reason'];
                
                $banArr[] = $ban;
            }
            echo json_encode($banArr);
}
//BansPlus处理开始
function bansplus(){
global $conn;
$type = $_GET['type'];
$sql = "SELECT *, 'ban' AS TYPE FROM bansplus_bans UNION SELECT *, 'mute' AS TYPE FROM bansplus_mutes";
$result = $conn->query($sql);
$result = $conn->query($sql);
$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}
$banArr = array();
foreach ($rows as $row) {
    $ban = array();
    $ban['name'] = $row['Username'];
    $ban['uuid'] = $row['UUID'];
    $ban['type'] = $row['TYPE'];
    $ban['starttime'] = $row['Start'];
    
    switch($row['End']){
        case "Permanent":
            $ban['endtime'] = "Forever";
            break;
        default:
            $ban['endtime'] = $row['End'];
            break;
    }
    $ban['reason'] = $row['Reason'];
    
    $banArr[] = $ban;
}
echo json_encode($banArr);
}
    
$conn->close();
?>