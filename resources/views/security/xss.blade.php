<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments - XSS Attack</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center" style="height: auto; margin: 0;">

    <div class="container">

        <a href="{{ url('/') }}">Back to home</a>

        <!-- Post Section -->
        <div class="card mx-auto mb-4" style="max-width: 600px;">
            <img src="{{ Storage::url('public/post/weather.jpg') }}" class="card-img-top" alt="Image">

            <div class="card-body">
                <h5 class="card-title">Understanding the Weather</h5>
                <p class="card-text">
                    Weather is the state of the atmosphere at a specific place and time, including temperature, humidity, wind, and precipitation. It plays a crucial role in our daily lives, affecting everything from the clothes we wear to the activities we plan.
                </p>
            </div>
        </div>

        <!-- Switch Button Sanitize Input -->
        <div class="card mx-auto mb-4" style="max-width: 600px;">
            <div class="card-body">
                <h5 class="card-title">Sanitize Input</h5>
                <p class="card-text">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="toggleSanitizeXss" data-name="sanitize_xss_input" {{ $variable->value == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="toggleSanitizeXss">Filter From XSS Attack</label>
                    </div>
                </p>
            </div>
        </div>

        <!-- Comment Form -->
        <div class="card mx-auto mb-4 p-4" style="max-width: 600px;">
            <h5 class="mb-3">Add a Comment</h5>
            <form id="commentForm">
                <div class="mb-3">
                    <input type="name" id="name" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="mb-3">
                    <input type="email" id="email" class="form-control" placeholder="Your Email" required>
                </div>
                <div class="mb-3">
                    <textarea id="comment" class="form-control" rows="3" placeholder="Your Comment" required></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100">Submit Comment</button>
            </form>
        </div>

        <!-- Comments Section -->
        <div id="commentsSection" class="mx-auto" style="max-width: 600px;">
            {{-- <h5 class="mb-3">Comments <span id="comment-count">{{ $count }}</span></h5> --}}
            <h5 class="mb-3">Comments <span id="comment-count"><?= $count ?></span></h5>
            
            <!-- Dynamic comments will be appended here -->
            @foreach ($comments as $comment)
                <div class="comment-card border-bottom pb-3 mb-3" id="comment-list-{{ $comment->id }}">
                    <div class="d-flex align-items-center">
                        <img src="https://via.placeholder.com/40" class="rounded-circle me-3" alt="User Image">

                        <div>
                            <strong>
                                @if ($variable->value == 1)
                                    {{ $comment->name }}
                                @else
                                    {!! $comment->name !!}
                                @endif
                            </strong>

                            <p class="mb-1">
                                @if ($variable->value == 1)
                                    {{ $comment->email }}
                                @else
                                    {!! $comment->email !!}
                                @endif
                            </p>
                            <p class="mb-1">
                                @if ($variable->value == 1)
                                    {{ $comment->comment }}
                                @else
                                    {!! $comment->comment !!}
                                @endif    
                            </p>
                            <div class="text-muted small">{{ $comment->created_at->diffForHumans() }}</div>
                            <div>
                                <a id="remove-comment" class="text-decoration-none me-3 text-muted small" data-id="{{ $comment->id }}">Remove</a>
                            </div>
                        </div>
                        <div class="ms-auto">
                            <i class="fa-solid fa-star text-warning me-2"></i>
                            <i class="fa-solid fa-check-circle text-primary"></i>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- Example repeated comment -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // AJAX Comment Submission
        $('#commentForm').on('submit', function(event) {
            event.preventDefault();

            const name = $('#name').val();
            const email = $('#email').val();
            const comment = $('#comment').val();

            $.ajax({
                url: '/comment',
                method: 'POST',
                data: {
                    name: name,
                    email: email,
                    comment: comment,
                },
                success: function(response) {

                    var commentCreatedAt = response.comment.created_at; // Raw date passed from Laravel
                    var humanReadableDate = moment(commentCreatedAt).fromNow(); // Example: "2 days ago"

                    const commentHtml = `
                        <div class="comment-card border-bottom pb-3 mb-3">
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/40" class="rounded-circle me-3" alt="User Image">
                                <div>
                                    <strong>${response.comment.name}</strong>
                                    <p class="mb-1">${response.comment.email}</p>
                                    <p class="mb-1">${response.comment.comment}</p>
                                    <div class="text-muted small">${humanReadableDate}</div>
                                    <div>
                                        <a id="remove-comment" class="text-decoration-none me-3 text-muted small" data-id="${response.comment.id}">Remove</a>
                                    </div>
                                </div>
                                <div class="ms-auto">
                                    <i class="fa-solid fa-star text-warning me-2"></i>
                                    <i class="fa-solid fa-check-circle text-primary"></i>
                                </div>
                            </div>
                        </div>
                    `;

                    $('#commentsSection').append(commentHtml);
                    $('#commentForm')[0].reset();

                    $("#comment-count").text(response.count)
                },
                error: function(xhr) {
                    alert('Error adding comment: ' + xhr.responseText);
                }
            });
        });

        $(document).on('click', '#remove-comment', function(e) {
            e.preventDefault();

            var commentId = $(this).data('id'); // Get the comment ID

            // Disable the delete button to prevent multiple clicks
            var $button = $(this);
            $button.prop('disabled', true);

            // Remove the comment from the DOM immediately
            $button.closest('.comment-card').fadeOut(300); // Fade out the comment card for smooth removal

            // Perform Ajax DELETE request
            $.ajax({
                url: '/comment/' + commentId, // The route to delete the comment
                type: 'DELETE',
                success: function(response) {
                    // Optionally, show a success message
                    alert(response.message);

                    $("#comment-count").text(response.count);
                },
                error: function(response) {
                    // If an error occurs (e.g., comment not found), restore the button state
                    alert('Error: ' + response.responseJSON.message);

                    // Show the comment back in case of error
                    $button.closest('.comment-card').fadeIn(300); // Fade it back in
                },
                complete: function() {
                    // Re-enable the button
                    $button.prop('disabled', false);
                }
            });
        });

        // Toggle switch change event
        $('#toggleSanitizeXss').change(function() {
            let isChecked = $(this).is(':checked') ? 1 : 0; // Set 1 for on, 0 for off
            let name = $(this).data('name'); // Retrieve the environment variable name
            
            $.ajax({
                url: '/comment/toggleSanitizeXss',
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
                error: function() {
                    alert('Something went wrong.');
                }
            });
        });

    </script>
</body>
</html>
