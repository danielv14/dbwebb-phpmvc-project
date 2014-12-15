<h2><?=$title?></h2>

<div class="user-wrapper">

<?php foreach ($users as $user) : ?>
<?php $url = $this->url->create('comment/view-by-user/' . $user->id); ?>


<div class="user-individual">
<a href="<?= $this->url->create('comment/view-by-user/' . $user->id) ?>">

	<div class="avatar">
		<img src="<?=$user->gravatar?>">
	</div>

	<div class="user-info">
		<?=$user->name?><br>
		<?=$user->email?>
	</div>

</a>
</div>

<?php endforeach; ?>

</div>