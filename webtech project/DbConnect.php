<?php
   class DbConnect
   {
       public $conn;
       public function getConn()
       {
           $conn = new mysqli("localhost", "root", "", "socialsite");
                
            if ($conn->connect_error)
            {
                die("Connection failed: Server Down!!!" . $conn->connect_error);
            }
            else
            {
                echo "connection success";
            }
            if($conn==NULL)
            {
                echo "object is null";
            }
            else
            {
                echo "object is not null";
            }
            return $conn;
       }
      /*  public function getConn()
       {
           if($conn==NULL)
           {
               echo "object is null";
           }
           else
           {
               echo "object is not null";
           }
       } */
   }
?>