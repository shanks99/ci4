<h2><?= esc($title); ?></h2>

<?php // CSRF 보호와 관련된 오류를 보고하는데 사용 ?>
<?= session()->getFlashdata('error') ?>

<?php // 양식 유효성 검사와 관련된 오류를 보고하는데 사용 ?>
<?= service('validation')->listErrors() ?>

<form action="/news/create" method="post">
    <?php // 일반적인 공격으로 부터 보호하는 CSRF 토큰으로 숨격진입력을 생성 ?>
    <?= csrf_field() ?>

    <label for="title">Title</label>
    <input type="input" name="title" /><br />

    <label for="body">Text</label>
    <textarea name="body" cols="45" rows="4"></textarea><br />

    <input type="submit" name="submit" value="Create news item" />
</form>