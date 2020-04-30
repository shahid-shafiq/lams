@extends('test.layout')

@section('content')
    <div class='container-block' style="background:tan;">
        <div class="container">
            <h1>Javascript in Laravel</h1>
            <p class="subtitle">Just some jQuery in the view</p>
            <p class="lead">
                This is the oldest way we have used. In some of our projects it is still used as there has not been time to fix the code and it still works.
            </p>
            <p>
                Note that for this use case, we need to have jQuery installed and available on the window. Moreover, jQuery should be loaded before the view is loaded, i.e., in the head of the document.
            </p>
        </div>
    </div>

  @include('test.form')

<script>
    jQuery(document).ready(function() {

        /**
         * We need the following behavior
         *     1] choose a gender => add text input for name prefixed with Mr. or Ms.
         *     2] check if email valid and exist and message user if so or show 'free'
         *     3] zipcode validation based on zipcode and country
         */

        // IFFE so that we can use $ instead of jQuery
        (function ($) {
            const zipcode = $('#zipcode')
            const country = $('#country')

            // To prevent token mismatch error when posting via ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //     1] choose a gender => add text input for name prefixed with the rigth 'aanspreekvorm'
            $('#gender input[type=radio]').on('change', function(e) {
                const gender = e.target.value;

                $('#name-input').remove();

                // create a string to update the DOM
                const textInput = `<div id="name-input" class="form-group">
                        <label for="city">${(gender === 'male' ? 'Mr.' : 'Ms.')}</label>
                        <input type="text" class="form-control" id="name" placeholder="Your name">
                    </div>`

                $('#email-cntr').after(textInput)
            });

            //     2] check if email exist and message user if so or show 'free'
            $('#email').on('blur', function(e) {
                // clean up previous messages
                $('#emailerror').remove()

                const email = e.target.value

                // Check if it is a valid emailaddress
                if (!validateEmail(email)) {
                    const message = `<small id="emailerror" class="form-text text-danger">This is not a valid emailaddress</small>`
                    $('#emailHelp').after(message)
                    return false;
                }

                // add a spinner behind the input
                const spinner = '<i id="spinner" class="fa fa-spinner fa-spin" style="position: absolute; right: -10px; top: 115px;"></i>'

                $(this).after(spinner);

                $.ajax({
                    url: '/email-exist',
                    type: 'POST',
                    data: {
                        email
                    },
                })
                .done(function(response) {
                    // remove spinner
                    $('#spinner').remove()

                    let messageClass, messageText

                    if (response === 'exists') {
                        // email exists => add some html 'text-danger'
                        messageClass = 'text-danger'
                        messageText = 'This emailaddress already exists, please choose another.'
                    } else {
                        // free! => add some html 'text-success'
                        messageClass = 'text-info'
                        messageText = 'Yeah! emailaddress is still free'
                    }
                    const message = `<small id="emailerror" class="form-text ${messageClass}">${messageText}</small>`
                    $('#emailHelp').after(message)
                })
            })

            //     3] zipcode validation based on zipcode and country
            zipcode.on('blur', checkZipcode)
            country.on('change', checkZipcode)

            // ---
            // Extra functions
            // ---
            function checkZipcode(event) {
                // Check for a valid zipcode based on the country
                // and the zipcode using 'checkZipcodeCountry'
                // When country and zipcode don't match, show an error message
            }

            function checkZipcodeCountry(countryV, zipcodeV) {
                let re = /^[1-9][0-9]{3}[a-z]{2}$/i
                if (countryV === 'be') {
                    re = /^B-[1-9][0-9]{3}$/
                } else if (countryV === 'de') {
                    re = /^[1-9][0-9]{4}$/
                }
                return re.test(zipcodeV)
            }

            function validateEmail(email) {
                let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }

        }(jQuery))
    });
</script>


@endsection   