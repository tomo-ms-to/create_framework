<h1>Users</h1>

<?php if (!empty($users)): ?>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?php echo htmlspecialchars($user->name); ?> (<?php echo htmlspecialchars($user->email); ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>ユーザーが登録されていません。</p>
<?php endif; ?>

<p><a href="/add-user">新しいユーザーを追加する</a></p>