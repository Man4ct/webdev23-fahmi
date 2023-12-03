<!DOCTYPE html>
<html>

<head>
    <title>Form artikel</title>
</head>

<body>
    <form method="post">
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
        <div>
            <label for="title">Judul</label>
            <input type="text" name="title" id="title">
        </div>
        <div>
            <label for="content">Isi</label>
            <textarea name="content" id="content"></textarea>
        </div>
        <div>
            <button type="submit">Simpan</button>
        </div>
    </form>
</body>

</html>
