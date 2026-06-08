<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>官網聯絡表單</title>
</head>
<body style="font-family: 'Noto Sans TC', Arial, sans-serif; color:#222; line-height:1.6;">
    <h2 style="color:#0A0A0A;">官網聯絡表單新訊息</h2>
    <table cellpadding="8" cellspacing="0" style="border-collapse:collapse; width:100%; max-width:640px;">
        <tr><td style="background:#f5f5f5; width:120px;"><strong>姓名</strong></td><td>{{ $contact->name }}</td></tr>
        <tr><td style="background:#f5f5f5;"><strong>電子郵件</strong></td><td>{{ $contact->email }}</td></tr>
        <tr><td style="background:#f5f5f5;"><strong>聯絡電話</strong></td><td>{{ $contact->phone ?: '—' }}</td></tr>
        <tr><td style="background:#f5f5f5;"><strong>主旨</strong></td><td>{{ $contact->subject ?: '—' }}</td></tr>
        <tr><td style="background:#f5f5f5; vertical-align:top;"><strong>訊息內容</strong></td><td>{!! nl2br(e($contact->message)) !!}</td></tr>
        <tr><td style="background:#f5f5f5;"><strong>來源語系</strong></td><td>{{ $contact->locale ?: '—' }}</td></tr>
        <tr><td style="background:#f5f5f5;"><strong>送出時間</strong></td><td>{{ $contact->created_at->format('Y-m-d H:i:s') }}</td></tr>
    </table>
    <p style="margin-top:16px; color:#888; font-size:13px;">此信由官網聯絡表單自動發送，可直接回覆給寄件人。</p>
</body>
</html>
