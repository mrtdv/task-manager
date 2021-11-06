<?php if ($status == 1) : ?>
<div class="">Вы авторизованы, вернитесь <a href="<?= $path ?>">На главную</a> либо <a href="<?= $path ?>user/logout">Выйти</a></div>
<?php else : ?>
<a href="<?= $path ?>">На главную</a>

<div class="wrap_auth">
    <h1>Авторизация</h1>
    <form action="<?= $path ?>user/login" method="post" class="auth">
        <table>
        	<tr>
        		<td><label for="login">Логин</label></td>
        		<td><input type="text" name="login" ID="login" required></td>
        	</tr>
        	<tr>
        		<td><label for="password">Пароль</label></td>
        		<td><input type="password" name="password" ID="password" required></td>
        	</tr>
        	<tr>
        		<td colspan="2" class="aright"><input type="submit" value="Войти"></td>
        	</tr>
        </table>
    </form>
</div>

<?php endif ?>