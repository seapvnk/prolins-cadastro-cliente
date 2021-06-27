<html>
<head></head>
    <body style="background: #F4F4F4; color: #222">
    <h1>{{$title}}</h1>
    <p>{{$content}}</p>
    @isset($url)
        <a style="color: tomato" href="{{$url}}">[!] resetar senha</a>
    @endisset
</body>
</html>