<?php
    namespace Hcode\Model;
    use \Hcode\DB\Sql;
    use Hcode\Model;

    class User extends Model{
        const SESSION="User";
        public static function login($login,$pass){
            $sql = new Sql();
            $results = $sql->select("select * from tb_users where deslogin=:LOGIN",array(
                "LOGIN"=>$login
            ));
            if (count($results)===0) {
                throw new \Exception("User doesn't exist or invalid password.");
            }
            $data = $results[0];
            if(password_verify($pass,$data["despassword"])===true){
                $user = new User();
                $user->setData($data);
                $_SESSION[User::SESSION] = $user->getValues();

            }else{
                throw new \Exception("User doesn't exist or invalid password.");
            }
        }
        public static function verifyLogin($inadmin = true){
           if (
               !isset($_SESSION[User::SESSION])
               or
               !$_SESSION[User::SESSION]
               or
               !(int)$_SESSION[User::SESSION]["iduser"]>0
               or
               (bool)$_SESSION[User::SESSION]["inadmin"]!== $inadmin) {
               header("Location: /master/login");
               exit;
           }
        }

        public static function logout(){
            $_SESSION[User::SESSION]= null;
        }
    }
?>