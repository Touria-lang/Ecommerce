@extends('layouts.master')

@section('extra-script')
    <script src="https://js.stripe.com/v3/"></script>       
@endsection
@section('extra-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="col-md-12">
        <h1>Page de paiment</h1>
        <div class="row">
            <div class="col-md-6">
                <form id="payment-form" action="{{route('stripes.store')}}" method="POST">
                    @csrf
                    <div id="card-element" class="mt-4 ">
                      <!-- Elements will create input elements here -->
                    </div>
                  
                    <!-- We'll put the error messages in this element -->
                    <div id="card-errors" role="alert"></div>
                  
                <button class="btn btn-success mt-4" id="submit">Proceder au payement ({{getPrice(Cart::total())}} )</button>
                </form>
            </div>
        </div>
    </div>  
@endsection


@section('extra-js')
<script>
    var stripe = Stripe('pk_test_2dToh5EidB5IcmxdHrcZ4rpV002Yvxxzh7');
    var elements = stripe.elements();
    //console.log(elements);

    var style = 
    {
    base: 
    {
        color: "#32325d",
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: "antialiased",
        fontSize: "16px",
        "::placeholder": 
        {
        color: "#aab7c4"
        }
    },
    invalid:
    {
        color: "#fa755a",
        iconColor: "#fa755a"
    }
    };

    var card = elements.create("card", { style: style });
    card.mount("#card-element");

    card.on('change', ({error}) => {
    const displayError = document.getElementById('card-errors');
    if (error) {
        displayError.textContent = error.message;
    } else {
        displayError.textContent = '';
    }
    });

    var submitButton = document.getElementById('submit');

    submitButton.addEventListener('click', function(ev) {
    ev.preventDefault();
    submitButton.disabled = true;

    stripe.confirmCardPayment("{{$client_secret}}", {
    payment_method: {
        card: card
        
    }
    }).then(function(result) {
    if (result.error) {
        submitButton.disabled = false;
        console.log(result.error.message);
        
    } else {
        // The payment has been processed!

        if (result.paymentIntent.status == 'succeeded') {
        
        var paymentIntent = result.paymentIntent;
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var form = document.getElementById('payment-form');
        var url = form.action;
        var redirect = '/merci';
        
        fetch(
            url,
            {
                headers: {
                    "Content-Type" : "application/json",
                    "Accept" : "application/json, text-plain, */*",
                    "X-Requested-With" : "XMLHttpRequest",
                    "X-CSRF-TOKEN" : token
                },
                method : "POST",
                body : JSON.stringify({
                    paymentIntent : paymentIntent
                })
            }
        ).then(
            (data) => {
             console.log(data)
             window.location.href = redirect
        }).catch(
            (error) => {
            console.log(error)
        })
        }
    }
    });
    });

</script>
@endsection