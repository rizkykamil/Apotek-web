<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <h1>Payment Form</h1>
    <img src="{{asset("assets/img/illustrations/profiles/")}}" alt="">
    <form id="payment-form" action="{{route('process-payment')}}" method="POST">
        @csrf
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required>
        <br><br>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
        <br><br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        <br><br>
        <button type="button" id="pay-button">Pay</button>
    </form>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            var form = document.getElementById('payment-form');
            var formData = new FormData(form);
            fetch('{{route('process-payment')}}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        // Optional
                        onSuccess: function(result) {
                            // pindah kehalaman dashboard
                            window.location.href = "{{route('admin.dashboard')}}";
                        },
                        // Optional
                        onPending: function(result) {
                            /* You may add your own implementation here */
                            alert("Waiting for your payment!"); console.log(result);
                        },
                        // Optional
                        onError: function(result) {
                            /* You may add your own implementation here */
                            alert("Payment Failed!"); console.log(result);
                        }
                    });
                } else {
                    alert('Failed to get snap token');
                }
            });
        };
    </script>
</body>
</html>
