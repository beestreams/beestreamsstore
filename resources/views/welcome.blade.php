<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
            
        <script>
            var Beestream = {
                csrfToken: "{{ csrf_token()}}",
                stripeKey: "{{ config('services.stripe.key') }}"
            }
        </script>
    </head>
    <body>
        <div id="app">
            <h1>Welcome to the Beestream store</h1>
            <checkout-form></checkout-form>
        </div>
        
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <script src="js/app.js"></script>
        
    </body>
</html>
