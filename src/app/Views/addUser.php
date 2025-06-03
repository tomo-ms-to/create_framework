<h1>Add New User</h1>

<form action="/add-user" method="post">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <button type="submit">Add User</button>
</form>

<p><a href="/users">ユーザー一覧に戻る</a></p>