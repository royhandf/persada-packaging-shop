<!DOCTYPE html>
<html>

<head>
    <title>Authenticating...</title>
    <script>
        window.opener.postMessage('google_login_success', "{{ url('/') }}");
        window.close();
    </script>
</head>

<body>
    <p>Processing... Please wait.</p>
</body>

</html>
