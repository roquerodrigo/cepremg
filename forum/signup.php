<?php
//This page let users sign up
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Sign Up</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Espace Membre" /></a>
	    </div>
<?php
if(isset($_POST['username'], $_POST['password'], $_POST['passverif'], $_POST['email'], $_POST['avatar']) and $_POST['username']!='')
{
	if(get_magic_quotes_gpc())
	{
		$_POST['username'] = stripslashes($_POST['username']);
		$_POST['password'] = stripslashes($_POST['password']);
		$_POST['passverif'] = stripslashes($_POST['passverif']);
		$_POST['email'] = stripslashes($_POST['email']);
		$_POST['avatar'] = stripslashes($_POST['avatar']);
	}
	if($_POST['password']==$_POST['passverif'])
	{
		if(strlen($_POST['password'])>=6)
		{
			if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
			{
				$username = mysql_real_escape_string($_POST['username']);
				$password = mysql_real_escape_string(sha1($_POST['password']));
				$email = mysql_real_escape_string($_POST['email']);
				$avatar = mysql_real_escape_string($_POST['avatar']);
				$dn = mysql_num_rows(mysql_query('select id from users where username="'.$username.'"'));
				if($dn==0)
				{
					$dn2 = mysql_num_rows(mysql_query('select id from users'));
					$id = $dn2+1;
					if(mysql_query('insert into users(id, username, password, email, avatar, signup_date) values ('.$id.', "'.$username.'", "'.$password.'", "'.$email.'", "'.$avatar.'", "'.time().'")'))
					{
						$form = false;
?>
<div class="message">Cadastro realizado com sucesso!<br />
<a href="login.php">Logar</a></div>
<?php
					}
					else
					{
						$form = true;
						$message = 'Erro ao logar.';
					}
				}
				else
				{
					$form = true;
					$message = 'Nome de usuário indisponível.';
				}
			}
			else
			{
				$form = true;
				$message = 'Email inválido.';
			}
		}
		else
		{
			$form = true;
			$message = 'Sua senha deve ter no mínimo 6 caracteres.';
		}
	}
	else
	{
		$form = true;
		$message = 'Senhas diferentes.';
	}
}
else
{
	$form = true;
}
if($form)
{
	if(isset($message))
	{
		echo '<div class="message">'.$message.'</div>';
	}
?>
<div class="content">
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Índice fórum</a> &gt; Sign Up
    </div>
	<div class="box_right">
    	<a href="signup.php">Cadastrar</a> - <a href="login.php">Login</a>
    </div>
    <div class="clean"></div>
</div>
    <form action="signup.php" method="post">
        Por favor preencha o formulário abaixo para se cadastrar:<br /><br>
        <div class="center">
            <label for="username">Usuário</label><input type="text" name="username" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <label for="password">Senha<span class="small">(6 characters min.)</span></label><input type="password" name="password" /><br />
            <label for="passverif">Confirmar Senha<span class="small">(verification)</span></label><input type="password" name="passverif" /><br />
            <label for="email">Email</label><input type="text" name="email" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <label for="avatar">Foto<span class="small">(opcional)</span></label><input type="text" name="avatar" value="<?php if(isset($_POST['avatar'])){echo htmlentities($_POST['avatar'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <input type="submit" value="Sign Up" />
		</div>
    </form>
</div>
<?php
}
?>
		
	</body>
</html>
