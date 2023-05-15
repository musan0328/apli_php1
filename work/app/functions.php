<?php

  // 第1引数に$strを指定
  function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }

  //トークン生成
  function createToken() {

    // random_bytes 安全でランダムな文字列を生成
    if (!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(random_bytes(32));
    }
  }

  //トークンチェック
  function validateToken() {

    // セッションのトークンが空だったり、POSTで渡ってきたトークンが一致しない場合処理を終了する
    if (
      empty($_SESSION['token']) ||
      $_SESSION['token'] !== filter_input(INPUT_POST, 'token')
    ) {
      exit('Invalid post request');
    }
  }

  session_start();
?>