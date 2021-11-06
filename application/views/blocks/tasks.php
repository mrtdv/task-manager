<?php if ((isset($status)) && ($status == 1)) : ?> 
    <a href="<?= $path ?>user/logout">Выйти</a>
<?php else: ?>
    <a href="<?= $path ?>user/authorization">Авторизация</a>
<?php endif ?>
<h1>Задачник</h1>
<div class="wrap_tasks_add">
    <h2>Добавить задачу</h2>
    <form action="<?= $path ?>tasks/add" method="post" class="task">
        <table>
        	<tr>
        		<td><label for="user_name">Имя пользователя</label></td>
        		<td><input type="text" name="user_name" ID="user_name" required></td>
        	</tr>
        	<tr>
        		<td><label for="user_email">Email</label></td>
        		<td><input type="email" name="user_email" ID="user_emaile" required></td>
        	</tr>
        	<tr>
        		<td><label for="task">Задача</label></td>
        		<td><textarea name="task" id="task" required></textarea></td>
        	</tr>
        	<tr>
        		<td colspan="2" class="aright"><input type="submit" value="Добавить"></td>
        	</tr>
        </table>
    </form>
</div>
<div class="wrap_tasks">
	<h2>Задачи</h2>
	<?php if (!empty($pagination)) : ?>
	<div class="paginator">
		<?= $pagination ?>
	</div>
	<?php endif ?>
<?php if (isset($tasks[0]) && (!empty($tasks[0]))) : ?>
	<div class="row mb30">
		<div class="col-3"><a href="?<?= http_build_query(array_merge($_GET, ['sort' => (($sort == 'named') ? 'namea': 'named') ] )) ?>">Имя пользователя</a></div>
		<div class="col-3"><a href="?<?= http_build_query(array_merge($_GET, ['sort' => (($sort == 'emaild') ? 'emaila': 'emaild') ] )) ?>">Email</a></div>
		<div class="col-3"><a href="?<?= http_build_query(array_merge($_GET, ['sort' => (($sort == 'taskd') ? 'taska': 'taskd') ] )) ?>">Задача</a></div>
		<div class="col-3"><a href="?<?= http_build_query(array_merge($_GET, ['sort' => (($sort == 'statusd') ? 'statusa': 'statusd') ] )) ?>">Статус</a></div>
	</div>
	<?php foreach ($tasks as $key => $value) : ?>
	<div class="mb30">
	    <div class="row">
			<div class="col-3"><?= $value['user_name'] ?></div>
			<div class="col-3"><?= $value['email'] ?></div>
			<div class="col-3"><?= $value['task'] ?></div>
			<div class="col-3">
				<?= $task_status[$value['status']] ?>
				<?= (!empty($value['comment'])) ? '<p class="fs08 mb0">' . $value['comment'] . '</p>' : '' ?>
			</div>
		</div>
		<?php if ((isset($status)) && ($status == 1)) : ?> 
	    <div class="wrap_task_update">
	    	<a href="#" class="open_hidden">Редактировать</a>
	    	<form action="<?= $path ?>tasks/edit" method="post" class="hidden task">
	    		<div class="row">
					<div class="col-3"><input type="text" name="user_name" value="<?= $value['user_name'] ?>" placeholder="Имя пользователя" required></div>
					<div class="col-3"><input type="email" name="user_email" value="<?= $value['email'] ?>" placeholder="Email" required></div>
					<div class="col-3"><textarea name="task" placeholder="Задача"><?= $value['task'] ?></textarea></div>
					<div class="col-3">
						<input type="hidden" name="ID" value="<?= $value['ID'] ?>">
						<select name="status" class="mb10">
							<option value="0"<?= ($value['status'] == 0) ? ' selected' : '' ?>>Поставлена</option>
							<option value="1"<?= ($value['status'] == 1) ? ' selected' : '' ?>>Выполнена</option>
						</select>
						<div class="">
							<input type="submit" value="Изменить">
						</div>
					</div>
				</div>
			</form>
	    </div>
		<?php endif ?>
	</div>

	<?php endforeach ?>

<?php else : ?>
	<div class="">
		Задач пока нет
	</div>
<?php endif ?>
</div>
