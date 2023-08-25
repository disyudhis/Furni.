<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link href="{{ asset('dashboard/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('dashboard/css/tiny-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Furni</title>

</head>


<style type="text/css">
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: whitesmoke;
        padding: 30px 10px;
    }

    .card {
        max-width: 500px;
        margin: auto;
        color: black;
        border-radius: 20 px;
    }

    p {
        margin: 0px;
    }

    .container .h8 {
        font-size: 30px;
        font-weight: 800;
        text-align: center;
    }

    .btn.btn-primary {
        width: 100%;
        margin-top: 10px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 15px;
        border: none;
        transition: 0.5s;
        background-size: 200% auto;

    }


    .btn.btn.btn-primary:hover {
        background-position: right center;
        color: #fff;
        text-decoration: none;
    }



    .btn.btn-primary:hover .fas.fa-arrow-right {
        transform: translate(15px);
        transition: transform 0.2s ease-in;
    }

    .form-control {
        color: black;
        background-color: whitesmoke;
        border: 2px solid transparent;
        height: 60px;
        padding-left: 20px;
        vertical-align: middle;
    }

    .form-control:focus {
        color: black;
        background-color: whitesmoke;
        border: 2px solid #339b39;
        box-shadow: none;
    }

    ::placeholder {
        font-size: 14px;
        font-weight: 600;
    }
</style>

<body>
    @include('sweetalert::alert')

    {{-- start body section --}}
    <div class="untree_co-section product-section before-footer-section">
        <div class="container">
            <div class="card px-4 mx-auto">
                <p class="h8 pt-5">Payment Details</p>
                @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                @endif
                <form role="form" action="{{ route('stripe.post', $totalPrice) }}" method="post"
                    class="require-validation py-5 px-3" data-cc-on-file="false"
                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                    @csrf

                    <div class="row mt-5 gx-3">
                        <div class="col-12">
                            <div class="d-flex flex-column form-group required">
                                <p class="text mb-1 control-label">Name On Card</p>
                                <input class="form-control mb-3" size='4' type="text" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-column form-group card required">
                                <p class="text mb-1 control-label">Card Number</p>
                                <input class="form-control mb-3 card-number" size='20' type='text'
                                    placeholder="1234 5678 435678">
                            </div>
                        </div>
                        <div class="mt-3">
                            
                        </div>
                        <div class="col-4">
                            <div class="d-flex flex-column form-group expiration required">
                                <p class="text mb-1 control-label">Expiration Month</p>
                                <input class="form-control mb-3 card-expiry-month" size='2' type="text"
                                    placeholder="MM">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex flex-column form-group expiration required">
                                <p class="text mb-1 control-label">Expiration Year</p>
                                <input class="form-control mb-3 pt-2 card-expiry-year" size="4" type="text"
                                    placeholder="YYYY">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex flex-column form-group required cvc">
                                <p class="text mb-1 control-label">CVC</p>
                                <input class="form-control mb-3 pt-2 card-cvc" size='4' type="text"
                                    placeholder="ex 311">
                            </div>
                        </div>

                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>Please correct the errors and try
                                    again.</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" class="btn btn-primary mb-3" value="Pay Now" name=""
                                id="">
                            </input>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>

    {{-- End body section --}}



    @include('home.script')

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
        $(function() {

            /*------------------------------------------
            --------------------------------------------
            Stripe Payment Code
            --------------------------------------------
            --------------------------------------------*/

            var $form = $(".require-validation");

            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey('pk_test_51NfGiQKVBk5Kb9tf8qtq4oNN30U7sODPeXs0Fid2zb5PSYXNcHj78nifMM3Z0npkaYukXygrUpI2s1oKxndZQ0f100lxgyqoob');
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            /*------------------------------------------
            --------------------------------------------
            Stripe Response Handler
            --------------------------------------------
            --------------------------------------------*/
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];

                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

        });
    </script>
</body>

</html>
