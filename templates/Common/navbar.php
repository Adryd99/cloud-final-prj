<div class="navbar navcolor">

<!-- links -->
<?php foreach($buttons AS $text => $data): ?>
<?php if($data['public'] == true || ! is_null($user)) :?>
    <a style="display:inline-block; margin: 0 0.5rem;" href="<?= $this->e($data['path']) ?>">
        <?= $this->e($text) ?>
    </a>
<?php endif; ?>
<?php endforeach; ?>


<!-- login/logout -->
<?php 
$action = is_null($user) ? 'Login' : 'Logout';
?>
<a href="/<?= strtolower($action) ?>" style="display:inline-block; margin-left:3em;">
    <?= $action ?>
</a>


<!-- register (if needed) -->
<?php if(is_null($user)): ?>
    <a href="/register" style="display:inline-block; margin: 0 0.5rem;">
        Register
    </a> 
<?php endif; ?>


<!-- username -->
<?php if(! is_null($user)): ?>
    <p style="display:inline; margin: 0 0.5rem;"><?= $this->e($user) ?></p>
<?php endif; ?>
<br/>

</div>