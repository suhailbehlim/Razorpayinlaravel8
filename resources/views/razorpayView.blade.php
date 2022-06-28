<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel - Razorpay Payment Gateway Integration</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-3 col-md-offset-6">
  
                        @if($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>Error!</strong> {{ $message }}
                            </div>
                        @endif
  
                        @if($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade {{ Session::has('success') ? 'show' : 'in' }}" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>Success!</strong> {{ $message }}
                            </div>
                        @endif
  
                        <div class="card card-default">
                            <div class="card-header">
                                Laravel - Razorpay Payment Gateway Integration
                            </div>
  
                            <div class="card-body text-center">
                                <form action="{{ route('razorpay.payment.store') }}" method="POST" >
                                    @csrf
                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ env('RAZORPAY_KEY') }}"
                                            data-amount="1000"
                                            data-buttontext="Pay 10 INR"
                                            data-name="Suhail Behlim Developer"
                                            data-description="Razerpay"
                                            data-image="data:image/png;base64,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"
                                            data-prefill.name="name"
                                            data-prefill.email="email"
                                            data-theme.color="skyblue">
                                    </script>
                                </form>
                            </div>
                        </div>
  
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>