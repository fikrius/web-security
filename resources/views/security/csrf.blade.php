<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSRF Attack Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center" style="height: auto; margin: 0;">

    <div class="container">

        <a href="{{ url('/') }}">Back to home</a>

        <!-- Comment Form -->
        <div class="card mx-auto mb-4 p-4" style="max-width: 600px;">
            <h5 class="mb-3">Transfer</h5>
            <form action="{{ url('csrf/transfer') }}" method="POST">
                {{-- @csrf --}}
                <div class="mb-3">
                    <input type="number" id="account_number" class="form-control" placeholder="Account Number" required>
                </div>
                <div class="mb-3">
                    <input type="number" id="amount" class="form-control" placeholder="Amount" required>
                </div>
                <input type="text" name="source" value="form" hidden>
                <button type="submit" class="btn btn-success w-100">Submit</button>
                {{-- <button type="submit" class="btn btn-success w-100" id="btn-transfer">Submit</button> --}}
            </form>

            @if(session('success'))
                <div class="alert alert-success mt-2">
                    {{ session('success') }}
                </div>
            @endif


            {{-- <div class="alert alert-success mt-2" id="container-message" style="display: none;">
                <p id="message"></p>
            </div> --}}

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>

        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //     }
        // });

        // AJAX Comment Submission
        $('#btn-transfer').on('click', function(event) {
            event.preventDefault();

            console.log('click');

            const account_number = $('#account_number').val();
            const amount = $('#amount').val();

            $.ajax({
                url: '/csrf/transfer',
                method: 'POST',
                data: {
                    account_number: account_number,
                    amount: amount
                },
                success: function(response) {
                    $("#container-message").show();

                    if (response.message != undefined)
                        $("#message").html(response.message);
                },
                error: function(xhr) {
                    if (xhr.status == 419) {
                        alert('CSRF token mismatch. Please reload the page and try again.');
                    } else {
                        alert('AJAX request failed:', xhr);
                    }
                }
            });
        });

        $('#toggleEnableCsrfToken').change(function() {
            let isChecked = $(this).is(':checked') ? 1 : 0; // Set 1 for on, 0 for off
            let name = $(this).data('name'); // Retrieve the environment variable name
            
            $.ajax({
                url: '/csrf/toggleEnableCsrfToken',
                type: 'POST',
                data: {
                    name: name,
                    value: isChecked
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Value updated:', response.value);
                    } else {
                        console.log('Error updating the value:', response.message);
                    }
                },
                error: function(xhr) {
                    console.table(xhr);
                }
            });
        });

    </script>
</body>
</html>
