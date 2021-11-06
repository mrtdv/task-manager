    <h3>Для добавления задачи необходимо авторизоваться</h3>
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
