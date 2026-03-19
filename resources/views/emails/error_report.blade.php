<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hata Bildirimi</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { font-size: 18px; font-weight: bold; margin-bottom: 20px; color: #e53e3e; }
        .content { margin-bottom: 20px; }
        .footer { font-size: 12px; color: #777; border-top: 1px solid #eee; pt: 10px; }
        .label { font-weight: bold; display: block; margin-bottom: 4px; }
        .value { margin-bottom: 16px; background: #f9f9f9; padding: 10px; border-radius: 4px; border: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Yeni Bir Hata Bildirimi Alındı</div>
        
        <div class="content">
            <span class="label">Gönderen:</span>
            <div class="value">{{ $user->name ?? $user->username ?? 'İsimsiz Kullanıcı' }} ({{ $user->email ?? 'E-posta belirtilmemiş' }})</div>
            
            <span class="label">Açıklama:</span>
            <div class="value">{!! nl2br(e($description)) !!}</div>
            
            @if($screenshotPath)
                <p><strong>Not:</strong> Ekran görüntüsü ektedir.</p>
            @else
                <p><strong>Not:</strong> Ekran görüntüsü eklenmedi.</p>
            @endif
        </div>
        
        <div class="footer">
            Bu e-posta Bayi Sistemi üzerinden otomatik olarak gönderilmiştir.
        </div>
    </div>
</body>
</html>
