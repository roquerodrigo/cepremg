<?php
//This page display a personnal message
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Read a PM</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum" /></a>
	    </div>
<?php
if(isset($_SESSION['username']))
{
if(isset($_GET['id']))
{
$id = intval($_GET['id']);
$req1 = mysql_query('select title, user1, user2 from pm where id="'.$id.'" and id2="1"');
$dn1 = mysql_fetch_array($req1);
if(mysql_num_rows($req1)==1)
{
if($dn1['user1']==$_SESSION['userid'] or $dn1['user2']==$_SESSION['userid'])
{
if($dn1['user1']==$_SESSION['userid'])
{
	mysql_query('update pm set user1read="yes" where id="'.$id.'" and id2="1"');
	$user_partic = 2;
}
else
{
	mysql_query('update pm set user2read="yes" where id="'.$id.'" and id2="1"');
	$user_partic = 1;
}
$req2 = mysql_query('select pm.timestamp, pm.message, users.id as userid, users.username, users.avatar from pm, users where pm.id="'.$id.'" and users.id=pm.user1 order by pm.id2');
if(isset($_POST['message']) and $_POST['message']!='')
{
	$message = $_POST['message'];
	if(get_magic_quotes_gpc())
	{
		$message = stripslashes($message);
	}
	$message = mysql_real_escape_string(nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8')));
	if(mysql_query('insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "'.(intval(mysql_num_rows($req2))+1).'", "", "'.$_SESSION['userid'].'", "", "'.$message.'", "'.time().'", "", "")') and mysql_query('update pm set user'.$user_partic.'read="yes" where id="'.$id.'" and id2="1"'))
	{
?>
<div class="message">Resposta enviada com sucesso!.<br />
<a href="read_pm.php?id=<?php echo $id; ?>">Ir para mensagens</a></div>
<?php
	}
	else
	{
?>
<div class="message">Erro ao enviar resposta.<br />
<a href="read_pm.php?id=<?php echo $id; ?>">Ir para mensagens</a></div>
<?php
	}
}
else
{
?>
<div class="content">
<?php
if(isset($_SESSION['username']))
{
$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Índice Fórum</a> &gt; <a href="list_pm.php">Lista de Mensagens</a> &gt; Ler mensagem
    </div>
	<div class="box_right">
    	<a href="list_pm.php">Suas mensagens(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Sair</a>)
    </div>
    <div class="clean"></div>
</div>
<?php
}
else
{
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Índice Fórum</a> &gt; <a href="list_pm.php">Lista de Mensagens</a> &gt; Ler mensagem
    </div>
	<div class="box_right">
    	<a href="signup.php">Cadastrar</a> - <a href="login.php">Login</a>
    </div>
    <div class="clean"></div>
</div>
<?php
}
?>
<h1><?php echo $dn1['title']; ?></h1>
<table class="messages_table">
	<tr>
    	<th class="author">Usuário</th>
        <th>Mensagem</th>
    </tr>
<?php
while($dn2 = mysql_fetch_array($req2))
{
?>
	<tr>
    	<td class="author center"><?php
if($dn2['avatar']!='')
{
	echo '<img src="'.htmlentities($dn2['avatar']).'" alt="Image Perso" style="max-width:100px;max-height:100px;" />';
}
?><br /><a href="profile.php?id=<?php echo $dn2['userid']; ?>"><?php echo $dn2['username']; ?></a></td>
    	<td class="left"><div class="date">Date sent: <?php echo date('Y/m/d H:i:s' ,$dn2['timestamp']); ?></div>
    	<?php echo $dn2['message']; ?></td>
    </tr>
<?php
}
?>
</table><br />
<h2>Resposta</h2>
<div class="center">
    <form action="read_pm.php?id=<?php echo $id; ?>" method="post">
    	<label for="message" class="center">Mensagem</label><br />
        <textarea cols="40" rows="5" name="message" id="message"></textarea><br />
        <input type="submit" value="Enviar" />
    </form>
</div>
</div>
<?php
}
}
else
{
	echo '<div class="message">Você não tem permissão para acessar esta página.</div>';
}
}
else
{
	echo '<div class="message">Mensagem não existe.</div>';
}
}
else
{
	echo '<div class="message">Destinatário inexistente.</div>';
}
}
else
{
?>
<div class="message">Você precisa estar logado para acessar esta página.</div>
<div class="box_login">
	<form action="login.php" method="post">
		<label for="username">Úsuário</label><input type="text" name="username" id="username" /><br />
		<label for="password">Senha</label><input type="password" name="password" id="password" /><br />
        <label for="memorize">Lembrar</label><input type="checkbox" name="memorize" id="memorize" value="yes" />
        <div class="center">
	        <input type="submit" value="Login" /> <input type="button" onclick="javascript:document.location='signup.php';" value="Sign Up" />
        </div>
    </form>
</div>
<?php
}
?>
		
	</body>
</html>
