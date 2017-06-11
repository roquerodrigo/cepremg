<?php
//This page let users create new topics
include('config.php');
if(isset($_GET['parent']))
{
	$id = intval($_GET['parent']);
if(isset($_SESSION['username']))
{
	$dn1 = mysql_fetch_array(mysql_query('select count(c.id) as nb1, c.name from categories as c where c.id="'.$id.'"'));
if($dn1['nb1']>0)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>New Topic - <?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?> - Forum</title>
		<script type="text/javascript" src="functions.js"></script>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum" /></a>
	    </div>
        <div class="content">
<?php
$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Índice Fórum</a> &gt; <a href="list_topics.php?parent=<?php echo $id; ?>"><?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; Novo Tópico
    </div>
	<div class="box_right">
    	<a href="list_pm.php">Suas mensagens(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Sair</a>)
    </div>
	<div class="clean"></div>
</div>
<?php
if(isset($_POST['message'], $_POST['title']) and $_POST['message']!='' and $_POST['title']!='')
{
	include('bbcode_function.php');
	$title = $_POST['title'];
	$message = $_POST['message'];
	if(get_magic_quotes_gpc())
	{
		$title = stripslashes($title);
		$message = stripslashes($message);
	}
	$title = mysql_real_escape_string($title);
	$message = mysql_real_escape_string(bbcode_to_html($message));
	if(mysql_query('insert into topics (parent, id, id2, title, message, authorid, timestamp, timestamp2) select "'.$id.'", ifnull(max(id), 0)+1, "1", "'.$title.'", "'.$message.'", "'.$_SESSION['userid'].'", "'.time().'", "'.time().'" from topics'))
	{
	?>
	<div class="message">Tópico criado com sucesso!<br />
	<a href="list_topics.php?parent=<?php echo $id; ?>">Ir para o fórum</a></div>
	<?php
	}
	else
	{
		echo 'Erro ao criar tópico.';
	}
}
else
{
?>
<form action="new_topic.php?parent=<?php echo $id; ?>" method="post">
	<label for="title">Título</label><input type="text" name="title" id="title"  /><br />
    <label for="message">Mensagem</label><br />
    <div class="message_buttons">
        <input type="button" value="Bold" onclick="javascript:insert('[b]', '[/b]', 'message');" /><!--
        --><input type="button" value="Italic" onclick="javascript:insert('[i]', '[/i]', 'message');" /><!--
        --><input type="button" value="Underlined" onclick="javascript:insert('[u]', '[/u]', 'message');" /><!--
        --><input type="button" value="Image" onclick="javascript:insert('[img]', '[/img]', 'message');" /><!--
        --><input type="button" value="Link" onclick="javascript:insert('[url]', '[/url]', 'message');" /><!--
        --><input type="button" value="Left" onclick="javascript:insert('[left]', '[/left]', 'message');" /><!--
        --><input type="button" value="Center" onclick="javascript:insert('[center]', '[/center]', 'message');" /><!--
        --><input type="button" value="Right" onclick="javascript:insert('[right]', '[/right]', 'message');" />
    </div>
    <textarea name="message" id="message" cols="70" rows="6"></textarea><br />
    <input type="submit" value="Enviar" />
</form>
<?php
}
?>
		</div>
		
	</body>
</html>
<?php
}
else
{
	echo '<h2>Categoria nao existente para tópico.</h2>';
}
}
else
{
?>
<h2>É necessário estar logado para acessar esta página.</h2>
<div class="box_login">
	<form action="login.php" method="post">
		<label for="username">Usuário</label><input type="text" name="username" id="username" /><br />
		<label for="password">Senha</label><input type="password" name="password" id="password" /><br />
        <label for="memorize">Lembrar</label><input type="checkbox" name="memorize" id="memorize" value="yes" />
        <div class="center">
	        <input type="submit" value="Login" /> <input type="button" onclick="javascript:document.location='signup.php';" value="Sign Up" />
        </div>
    </form>
</div>
<?php
}
}
else
{
	echo '<h2>Identificação para adicionar tópico não confirmada.</h2>';
}
?>
