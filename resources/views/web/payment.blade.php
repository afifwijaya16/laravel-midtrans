<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(!empty(env('CLIENT_KEY_MIDTRANS_SANDBOX')))
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{env('CLIENT_KEY_MIDTRANS_SANDBOX')}}"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
    <button id="pay-button">Pay!</button>
    <form action="{{ route('payment.post')}}" id="submit_form" method="POST">
        @csrf
        @method('post')
        <input type="hidden" name="json" id="json_callback">
    </form>
    <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{$snapToken}}', {
                onSuccess: function (result) {
                    /* You may add your own implementation here */
                    // alert("payment success!"); console.log(result);
                    send_response_to_form(result);
                },
                onPending: function (result) {
                    /* You may add your own implementation here */
                    // alert("wating your payment!"); console.log(result);
                    send_response_to_form(result);
                },
                onError: function (result) {
                    /* You may add your own implementation here */
                    // alert("payment failed!"); console.log(result);
                    send_response_to_form(result);
                },
                onClose: function () {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });

        function send_response_to_form(result) {
            document.getElementById('json_callback').value = JSON.stringify(result);
            // console.log(document.getElementById('json_callback').value);
            $('#submit_form').submit();
        }

    </script>
</body>

</html>
