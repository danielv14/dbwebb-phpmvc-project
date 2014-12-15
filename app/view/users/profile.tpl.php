<div class = 'profile-wrapper'>
	<h2>Your profile</h2>
	<img src="<?=getGravatar($user->email, 80)?>">
	<p><strong>Your name is: </strong><?=$user->name?></p>
	<p><strong>And your acronym is:</strong> <?=$user->acronym?></p>
	<p><strong>Email: </strong><?=$user->email?></p>
	<a href="<?=$this->url->create('users/update/' . $user->id) ?>"><i class="fa fa-cog"></i> Update profile</a>

</div>
