<!doctype html>
<html lang="{{ config('app.locale')}}">
<head>
    <Title>Flight Info</Title>
</head>
<body>
<div class="container">
    @yield('firstFlight')<br/><br/>
    @yield('secondFlight')<br/><br/>
    @yield('thirdFlight')<br/><br/>
    @yield('date')
</div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
<script type="text/javascript">
    setInterval(function(){ location.reload(); }, 28800000);
</script>
</html>