<?php

    require_once 'database.php';
  
    $db = dbConnect();
  
    $requestType = $_SERVER['REQUEST_METHOD'];
  
    $request = substr($_SERVER['PATH_INFO'], 1);
    $request = explode('/', $request);
    $requestRessource = array_shift($request);
  
    if ($requestType == 'GET'){
      if (isset($_GET['login'])) {
        //$return = dbRequestTweets($db, $_GET['login']);
      } else {
        //$return = dbRequestTweets($db);
      }
    } else if ($requestType == 'POST'){
      //$return = dbAddTweet($db, $_POST['login'], $_POST['text']);
    }else if ($requestType == 'DELETE') {
      //$return = dbDeleteTweet($db, $request[0], $_GET['login']);
    } else if ($requestType == 'PUT'){
      parse_str(file_get_contents('php://input'), $_PUT);
      //$return = dbModifyTweet($db, $request[0], $_PUT['login'], $_PUT['text']);
    }
    else {
      $return = false;
    }
  
    echo json_encode($return);

?>