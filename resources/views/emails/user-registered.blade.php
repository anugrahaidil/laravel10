<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Berhasil</title>
</head>
<body>
    <h2>Selamat, {{ $userData['name'] }}!</h2>
    <p>Anda telah berhasil mendaftar di aplikasi kami pada tanggal {{ $userData['registered_at'] }}.</p>
    <p><strong>Detail Pendaftaran:</strong></p>
    <ul>
        <li>Nama: {{ $userData['name'] }}</li>
        <li>Email: {{ $userData['email'] }}</li>
        <li>Tanggal Pendaftaran: {{ $userData['registered_at'] }}</li>
    </ul>
    <p>Terima kasih telah bergabung dengan kami!</p>
</body>
</html>
