<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSRF Attacker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: red; /* Full red background */
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
    </style>
</head>
<body class="d-flex align-items-center" style="height: auto; margin: 0;">

    <div class="container">

        <div class="row justify-content-center mt-3 mb-3">
            <div class="col-auto menu-item">
                <a class="btn btn-primary" href="{{ url('/') }}">Back to home</a>
            </div>
        </div>

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
        </div>
    </div>

</body>
</html>
