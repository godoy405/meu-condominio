<?php if (isset($errors) && $errors !== []) : ?>
	<div class="errors" role="alert">
		<ul class="list_unstyled">
		<?php foreach ($errors as $error) : ?>
			<li class="alert alert-danger text-white"><?= esc($error) ?></li>
		<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>