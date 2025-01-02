<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reflected XSS Attack</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center" style="height: auto; margin: 0;">

    <div class="container">

        <div class="row justify-content-center mt-3 mb-3">
            <div class="col-auto menu-item">
                <a class="btn btn-primary" href="{{ url('/') }}">Back to home</a>
            </div>
            <div class="col-auto menu-item">
                <a class="btn btn-primary" href="{{ url('/stored-xss') }}">Stored XSS</a>
            </div>
        </div>

        <div class="card mx-auto mb-4 p-4" style="max-width: 600px;">
            <h5 class="mb-3">Search Order</h5>
            <form action="{{ route('orders.search') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" id="code" name="code" class="form-control" placeholder="Order Code" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Search</button>
            </form>
        </div>

        @if (!empty($code))
            <div class="card mx-auto mb-4 p-4" style="max-width: 600px;">
                <p>You searched for: {!! $code !!}</p>
            </div>
        @endif

    </div>
</body>
</html>
