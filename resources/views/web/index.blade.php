<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
</head>

<body>
    <form action="{{ route('payment') }}" method="GET">
        <h1>Data Diri</h1>
        <hr />
        <label for="uname"><strong>Nama</strong></label>
        <input type="text" placeholder="Masukan nama" name="uname" required>
        <br>
        <label for="psw"><strong>Email</strong></label>
        <input type="text" placeholder="Masukan Email" name="email" required>
        <br>
        <label for="psw"><strong>Nomor</strong></label>
        <input type="text" placeholder="Masukan Nomor" name="number" required>
        <br>
        <button type="submit">Lanjut</button>
    </form>
    @if(session('alert-success'))
    <script>
        alert("{{session('alert-success')}}")
    </script>
    @elseif(session('alert-failed'))
    <script>
        alert("{{session('alert-failed')}}")
    </script>
    @endif
</body>

</html>
