<?php
namespace App\controllers;

#[\App\core\LoginFilter]
#[\App\core\ProfileFilter]
class UserController extends \App\core\Controller{
    
    public function changePassword() {
        $user = new \App\models\User();

        if(isset($_POST["action"])) {
            if($_POST['password'] == $_POST['password_confirm']){
                $user->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $user->user_id = $_SESSION["user_id"];
                $user->updatePassword();
                header("location:".BASE."/Default/somewhereSecure");
            } else {
                header('location:'.BASE.'/User/changePassword?error=Passwords do not match!');
            }
        }
        $this->view("User/changePassword");
    }

}
?>