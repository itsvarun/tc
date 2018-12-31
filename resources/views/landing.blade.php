<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">
	<title>Trecelon</title>
	<link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>

	<div id="app">
		<app></app>
	</div>
	<script src="{{ mix('js/bootstrap.js') }}" ></script>
	<script src="{{ mix('js/app.js') }}" ></script>
</body>
</html>