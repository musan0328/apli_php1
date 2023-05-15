<?php

require('../app/functions.php');

//トークンをセッションに保存する
createToken();

// define 定数を定義 $filenameを定義
define('FILENAME', '../app/messages.txt');

//変数 $_SEREVER の REQUEST_METHOD が POST だったら次の処理を実行c
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //Postされた直後に、トークンのチェックをする validateToken関数を呼び出す
  validateToken();
  // POSTで送信されたデータを取得 trim関数で前後の空白を取り除く
  $message = trim(filter_input(INPUT_POST, 'message'));
  //から文字の場合
  $message = $message !== '' ? $message : '...';

  // ファイルに書き込む 
  $filename = '../app/messages.txt';
  // fopen 追記モード
  $fp = fopen(FILENAME, 'a');
  // fwrite ファイルに書き込む
  fwrite($fp, $message . "\n");
  fclose($fp);

  //リダイレクト
  header('Location: http://localhost:8080/result.php');
  exit;
}

$filename = '../app/messages.txt';
// file関数 ファイルの中身を配列で取得する
// FILE_IGNORE_LINES 個々のデータの改行は省略する
$messages = file(FILENAME, FILE_IGNORE_NEW_LINES);

include('../app/_parts/_header.php');

?>

<ul>
  <!-- $messagesからmessageを1つずつ取り出す -->
  <?php foreach ($messages as $message): ?>
    <li><?= h($message); ?></li>
  <?php endforeach; ?>
</ul>
<form action="" method="post">
  <input type="text" name="message">
  <button>Post</button>
  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
</form>

<?php

include('../app/_parts/_footer.php');
