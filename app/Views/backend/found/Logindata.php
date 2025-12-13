<?php 
session_start();
include_once "connection.php";

if(isset($_POST['submit']))
    {
		$user=$_POST['email'];
		$password=$_POST['password'];
		    
		$sql = "select * from accounts where username='$user' AND password='$password'";
		$record = $conn->query($sql);
        if($record->num_rows >= 1){
            foreach($record as $row){
                header("location:../dashboard.php");
                $_SESSION['loginid'] = $row['id'];
                $_SESSION['loginname'] = $row['name'];
                $_SESSION['loginusername'] = $row['username'];
                $_SESSION['loginemail'] = $row['email'];
                $_SESSION['loginimage'] = $row['image'];
                $_SESSION['loginmobile'] = $row['mobile'];
                $_SESSION['loginaddress'] = $row['address'];
                $_SESSION['loginopen'] = $row['open'];
                $_SESSION['loginclose'] = $row['close'];
                $_SESSION['loginweek_from'] = $row['week_from'];
                $_SESSION['loginweek_to'] = $row['week_to'];
            }

        }
        else{
            echo "<script>
            alert('Invalid username or password.');
            window.location.href = '../index.php';
            </script>";
            exit;
        }
    }else{
	    header("location:../index.php");
    }
?>