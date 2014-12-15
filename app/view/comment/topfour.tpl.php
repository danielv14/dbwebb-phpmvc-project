<div class = 'top-wrapper'>

<div class = 'left'>
<h3> <i class="fa fa-fire"></i> Most used tags </h3>
<p>
	<?php foreach ($tags as $value) : ?>

		<span class="tag">
			<i class="fa fa-tag"></i><a href="<?=$this->url->create('comment/tag-comments/' . $value->tag) ?>">
			<?= $value->tag ?> </a>
		</span><br>

	<?php endforeach; ?>
</p>
</div>

<div class = 'middle'>
<h3><i class="fa fa-clock-o"></i> Fresh discussions</h3>
<p>
<?php foreach ($new as $value) : ?>

		<span class="top-stats">
			<i class="fa fa-comment"></i><a href="<?=$this->url->create('comment/answers/' . $value->id) ?>">
			<?= (strlen($value->title) > 35) ? substr($value->title, 0, 32) . '...' : $value->title ?></a>
		</span><br>

	<?php endforeach; ?>
</p>
</div>

<div class = 'right'>
<h3><i class="fa fa-exchange"></i> Most active users</h3>
<p>
<?php foreach ($users as $value) : ?>

		<span class="top-stats">
			<i class="fa fa-user"></i><a href="<?=$this->url->create('comment/view-by-user/' . $value->userId) ?>">
			<?= $value->name ?></a>
		</span><br>

	<?php endforeach; ?>
</p>
</div>

<div class = 'far-right'>
<h3><i class="fa fa-level-up"> Topics to keep alive</i></h3>
<p>
<?php foreach ($old as $value) : ?>

		<span class="top-stats">
			<i class="fa fa-comment-o"></i><a href="<?=$this->url->create('comment/answers/' . $value->id) ?>">
			<?= (strlen($value->title) > 35) ? substr($value->title, 0, 32) . '...' : $value->title ?></a>
		</span><br>

	<?php endforeach; ?>
</p>
</div>
</div>


