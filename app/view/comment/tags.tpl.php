<h2><?=$title?></h2>

<?php foreach ($tags as $tag) : ?>
{
	<span class="tag"><a href="<?=$this->url->create('comment/tag-comments/' . $tag->name) ?>"><i class="fa fa-tag"></i> <?= $tag->name ?></a></span>
}

<?php endforeach; ?>

