<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>{{$invoice_id}}</h2>
    <h1>Hello {{$client->name}},</h1>
    <p>Here is your invoice. Plase take a look at it and send the payment!</p>
    <p>Have a good day!</p>
    <p>Regards,</p>
    <p>{{$user->name}}</p>
    
</body>
</html>