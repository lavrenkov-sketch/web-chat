<?php
include_once 'php-db.php';
$result = $mysqli -> query('
	SELECT * FROM (
		SELECT name, message, time FROM chat_messages ORDER BY time DESC
	) tmp ORDER BY time limit 500
');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Анонимный чат</title>
	<script async type="text/javascript" src="js-index.js"></script>
	<script async type="text/javascript" src="functions.js"></script>

<style type="text/css">
	* {
		box-sizing:border-box;
	}
	body{
		background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
	background-size: 400% 400%;
	animation: gradient 15s ease infinite;
	white-space: normal;
    word-wrap: break-word;
	}
	@keyframes gradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}
	#content {
		width: auto;
		max-width: 90%;
		margin: 30px auto;
		background-color: #fafafa;
		padding: 2%;
		border-radius: 1.35rem;
		display: flex;
	    flex-direction: column;
	}
	#message-box {
	min-height: 300px;
    max-height: 320px;
    overflow: auto;
	overflow-x: hidden;
	}
	.author {
		margin-right: 5px;
    color: rgb(103 0 179);
    font-family: monospace;
	align-self: flex-end;
	}
	.text-box {
		width: 100%;
    border: 3px solid #eee;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 1.35rem;
	}
	.message-class{
		background-color: #6c69ff8c;
    color: #ffffff;
    width: fit-content;
    height: fit-content;
    text-transform: uppercase;
    padding: 8px;
    font-weight: 400;
    border-radius: 1.35rem;
    border-bottom-right-radius: 0px;
    /* border-bottom-left-radius: 0px; */
    border-top-left-radius: 0px;
    margin-top: 1%;
    display: flex;
    flex-direction: column;
	}
	#connecting{
		border-radius: 1.35rem;
    color: white;
    background-color: red;
    padding: 2%;
    FONT-WEIGHT: 900;
    margin-bottom: 1%;
    margin-top: 1%;
	}
	p{
		text-align: center;
    font-size: smaller;
    color: #82888b;
	}
	button{
	background-color: #eee;
    color: #543930;
    width: fit-content;
    height: fit-content;
    text-transform: uppercase;
    padding: 8px;
    font-weight: 400;
    border-radius: 1.35rem;
	outline: none;
    border: 0px;
	margin-right: 1%;
	}
	button:hover{
		background-color: #CDDC39;
	}
	@keyframes glow {
from {
	text-shadow: 0 0 0px #3f00ff;
}
to {
	text-shadow: 0 0 20px #3f00ff;
}
}
  #notify-text{
	-webkit-animation: glow 1s ease-in-out infinite alternate;
	-moz-animation: glow 1s ease-in-out infinite alternate;
	animation: glow 1s ease-in-out infinite alternate;
  
}
#header-box{
	height: 45px;
    background-color: #CDDC39;
    border-radius: 1.25rem;
    border-bottom-left-radius: 0px;
    border-bottom-right-radius: 0px;
    position: relative;
    padding: 0;
    margin: -2.35%;
    margin-bottom: 2%;
    /* padding-bottom: 79px; */
    display: flex;
	align-items: center;
    justify-content: center;
}
#header-box-text{
	display: flex;
	text-transform: uppercase;
	font-size: 140%;
}
#message-box::-webkit-scrollbar {
  display: none;
}
input:focus{
	border: 3px solid #CDDC39;
}
input:hover{
	border: 3px solid #CDDC39;
}
input{
	outline: none;
}
.message-class:hover{
	background-color: #CDDC39;
	color: #4caf50;
	font-weight: 500;
}
#button-block{
	display: flex;
  align-items: center;
  justify-content: center;
}
#button-send-message{
	margin-left: auto;
    padding: 14px;
	background-color: #2196F3;
    font-weight: 900;
    color: white;
}
#button-send-message:hover{
	background-color: #1b3146;
}
#message-input{
	flex-grow: 1;
    margin-right: 10px;
	width: auto;
}
#SendMessageDiv{
	display: flex;
    align-content: stretch;
    justify-content: space-between;
}
</style>

</head>
<body>
<div id="content">
	<div id="header-box"><p id="header-box-text">Анонимный веб-чат</p></div>
	<div id="message-box">

		<?php foreach ($result as $row) : ?>
			<div class="message-class">
				<span class="messsage-text"><?= $row['message'] ?></span>
				<span class="author" id="<?= $row['time'] ?>" ><?= $row['name'] ?></span>
			</div>	
		<?php endforeach; ?>	

	</div>
	<div id="connecting">Подключение к серверу websocket...</div>

	<input type="text" class="text-box" id="name-input" placeholder="Ваш nickname">
	
	<div id="SendMessageDiv">
	<input type="text" class="text-box" id="message-input" placeholder="Ваше сообщение....." onkeyup="handleKeyUp(event)">
	<button id="button-send-message" onclick="sendMessage()">Сказать 🔥 </button>

	</div>

	<p id="notify-text">Для отправки сообщения нажмите ENTER</p>
	<div id="button-block">

			<script>
				function ReloadPageScript(){
					var nickname=document.getElementById("name-input").value;
					console.log(nickname);
					location.reload();
					document.getElementById("name-input").value=nickname;
				}
			</script>

	<button onclick="ReloadPageScript()">обновить вручную</button>
	<button onclick="ClearChatHistory()">очистить</button>
	<button style="margin-left: auto;margin-right: 0%;" onclick="WhoDevelop()">о программе</button>
	</div>


</div>
</body>
</html>
