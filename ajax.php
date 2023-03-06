<?php
if(array_key_exists('request', $_POST)) {
   button1();
}
function button1() {
   echo "Кнопка нажата";
   echo "<br/>";

   $serverName = '10.10.10.10\MSSQL, 1102'; // instance и порт - необязательные параметры
   $connectionInfo = [
      'UID' => 'User', // имя пользователя, имеющего доступ к БД
      'PWD' => 'password', // пароль
      'Database' => 'Base' // название БД, к которой подключаемся
   ];
   $conn = sqlsrv_connect($serverName, $connectionInfo);
   //$servername = "localhost";
   //$username = "root";
   //$password = "";
   //$dbname = "base";
   //$conn = mysqli_connect($servername, $username, $password, $dbname);

   if( $conn ) {
      echo "Соединение установлено. <br />";
   }else{
      echo "Соединение не установлено. <br />";
      die( print_r( sqlsrv_errors(), true));
   }

   $result = sqlsrv_query($conn, "SELECT SUM(Count) AS value_sum FROM table_data");
   $row = sqlsrv_fetch_array($result);
   $sum = $row['value_sum'];
   echo "Общая сумма: ".$sum;
   echo "<br/>";

   $array = Array ("sum" => (int)$sum);

   $json = json_encode(array($array));

   if (file_put_contents("data.json", $json))
      echo "JSON файл успешно создан ...";
   else 
      echo "Ой, файл не создан ...";
}
?>