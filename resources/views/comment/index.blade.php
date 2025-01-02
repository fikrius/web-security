<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
</head>

<body>

    <h1>Comments Form</h1>

    <form method="POST" action="/comments">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
        </div>
        <div>
            <label for="comment">Comment:</label>
            <textarea id="comment" name="comment" required></textarea>
        </div>
        <button type="submit">Submit</button>
    </form>

    <h2>All Comments</h2>
    <ul>
        @foreach ($comments as $comment)
        <li>
            <strong>{{ $comment->email }}</strong>: {!! $comment->comment !!}
        </li>
        @endforeach
    </ul>

</body>

</html>