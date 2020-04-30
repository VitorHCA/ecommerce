<?php 
	session_start();
	require_once("vendor/autoload.php");

	use \Slim\Slim;
	use \Hcode\Page;
	use \Hcode\PageAdmin;
	use \Hcode\Model\User;

	$app = new Slim();

	$app->config('debug', true);

	$app->get('/', function() {
		
		/*$sql = new Hcode\DB\Sql();
		$results = $sql->select("select * from tb_users");
		echo json_encode($results);*/

		$page= new Page();
		$page->setTpl("index");
	});

	$app->get('/master', function() {
		User::verifyLogin();
		$page = new PageAdmin();
		$page->setTpl("index");
	});

	$app->get('/master/login',function(){
		$page = new PageAdmin([
			"header"=>false,
			"footer"=>false
		]);
		$page->setTpl("login");
	});

	$app->post('/master/login', function(){
		User::login($_POST["login"],$_POST["password"]);
		header("Location: /master");
		exit;
	});

	$app->get('/master/logout', function(){
		User::logout();
		header("Location: /master/login");
		exit;
	});

	$app->run();
?>