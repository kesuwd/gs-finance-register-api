<?php
     header('Content-Type: appliction/json');
     header('Access-Control-Allow-Origin: *');
     header('Access-Control-Allow-Method: POST');
     header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Method, Athorization');

     $data = json_decode(file_get_contents("php://input"), true);
     $name = $data['name'];
     $phone = $data['phone'];
     $email = $data['email'];

     $dns = 'mysql:host=www.github.com;dbname=test2';
     $conn = new PDO($dns, "root", "") or die("cannection failed");
     $sql = $conn->prepare("INSERT into data (name, phone, email) values(?,?,?)");
     $sql->bindParam(1, $name, PDO::PARAM_STR);
     $sql->bindParam(2, $phone, PDO::PARAM_STR);
     $sql->bindParam(3, $email, PDO::PARAM_STR);

     $sql2 = $conn->prepare("SELECT phone, email from data") ;

     $sql2->execute() or die("q2 failed");

     if($sql2->rowCount()>0){
          // $flag = 0;
          while($row =$sql2->fetch(PDO::FETCH_ASSOC)){ 
               if($phone == $row['phone'] || $email == $row['email']){
                    echo json_encode(array('status'=>false,'massage'=>'you have already registered'));
                    exit();
               }
          }
     }
     // msg_send()



     if ($name == "" && $phone == "" && $email == "") {
          echo json_encode(array('status'=>false,           'massage'=>'PLEASE FILL ALL OF THE FIELD'));
     } else {
         
          // if
          if ($sql->execute()) {

               echo json_encode(array('status' => true, 'massage' => 'register successfully'));
          } else {
               echo json_encode(array('status' => false, 'massage' => 'unable to register'));
          }
     }


     $conn = NULL;
?>