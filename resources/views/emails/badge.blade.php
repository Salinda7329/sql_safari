<!doctype html>
<html>
  <body>
    <h1>Congratulations, {{ $user->name }}</h1>
    <p>You have earned the <strong>{{ $achievement->name }}</strong> badge.</p>
    <p>{{ $achievement->description }}</p>
    <p><a href="{{ url('/achievements') }}">View Your Achievements</a></p>
    <p>Thanks,<br>SQL Safari Team</p>
  </body>
</html>
