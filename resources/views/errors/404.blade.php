<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Fastra Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{min-height:100vh;display:flex;align-items:center;justify-content:center;background:#F5F5F0;color:#000;font-family:'DM Sans',sans-serif;padding:20px}
        .code{font-family:'Space Grotesk',sans-serif;font-size:clamp(80px,15vw,180px);font-weight:900;line-height:1;color:#00E5FF;text-shadow:4px 4px 0 #000}
        h2{font-family:'Space Grotesk',sans-serif;font-size:clamp(18px,4vw,28px);font-weight:900;margin-top:24px}
        p{color:#555;margin-top:8px;font-size:15px}
        a{display:inline-flex;align-items:center;gap:8px;margin-top:32px;padding:14px 28px;background:#00E5FF;color:#000;font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:14px;border:3px solid #000;border-radius:12px;box-shadow:4px 4px 0 #000;text-decoration:none;transition:all .15s}
        a:hover{transform:translate(-2px,-2px);box-shadow:6px 6px 0 #000}
        a:active{transform:translate(3px,3px);box-shadow:none}
    </style>
</head>
<body>
    <div style="text-align:center">
        <div class="code">404</div>
        <h2>Halaman Tidak Ditemukan</h2>
        <p>Halaman yang kamu cari tidak ada atau sudah dipindahkan.</p>
        <a href="/">← Kembali ke Beranda</a>
    </div>
</body>
</html>
