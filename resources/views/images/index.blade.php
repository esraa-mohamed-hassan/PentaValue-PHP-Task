<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload App</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <h1 class="text-center">Image Uploading ....</h1>
            <div class="mb-4">
                <form class="mb-3" id="uploadForm" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div>
                        <label for="image" class="form-label strong">Choose Image</label>
                        <input class="form-control form-control-lg" name="image" id="image" type="file">
                      </div>
                    <button type="submit" class="mt-3 btn btn-primary">Upload</button>
                </form>
                <div id="message"></div>
            </div>
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
       
        <div class="row" id="images_div">
            @foreach ($images as $image)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset($image->path) }}" class="card-img-top" alt="Image">
                        <div class="card-body">
                            <h5 class="card-title">Image ID: {{ $image->id }}</h5>
                            <p class="card-text">Status: {{ $image->status }}</p>
                            @if ($image->status === 'pending')
                                <button class="btn btn-success approve-btn"
                                    data-id="{{ $image->id }}">Approve</button>
                                <button class="btn btn-danger reject-btn" data-id="{{ $image->id }}">Reject</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="handle_messages" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="myModalLabel">Messages</h3>
                    <button type="button" onclick="javascript:window.location.reload()" class="close"
                        data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center" id="modal_text"></h4>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#uploadForm').submit(function(e) {
                $("#handle_messages").modal("hide");
                $("#modal_text").html('');
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: new FormData(this),
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#message').html('');
                    },
                    success: function(response) {
                        $('#message').html('<div class="alert alert-success">' + response
                            .message + '</div>');
                        $('#image').val('');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#message').append('<div class="alert alert-danger">' +
                                value[0] + '</div>');
                        });
                    }
                });
            });
            $('.approve-btn').click(function() {
                $("#modal_text").html('');
                var imageId = $(this).data('id');
                $.ajax({
                    url: '{{ route('approve') }}',
                    type: 'POST',
                    data: {
                        image_id: imageId,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#modal_text").html(response.message);
                        $("#handle_messages .modal-body").load(response.message);
                        $("#handle_messages").modal("show");
                        $('#handle_messages').on('hidden.bs.modal', function() {
                            $('#handle_messages').removeData('bs.modal');
                            window.location.reload();
                        });
                    }
                });
            });

            $('.reject-btn').click(function() {
                $("#modal_text").html('');
                var imageId = $(this).data('id');
                $.ajax({
                    url: '{{ route('reject') }}',
                    type: 'POST',
                    data: {
                        image_id: imageId,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#modal_text").html(response.message);
                        $("#handle_messages .modal-body").load(response.message);
                        $("#handle_messages").modal("show");
                        $('#handle_messages').on('hidden.bs.modal', function() {
                            $('#handle_messages').removeData('bs.modal');
                            window.location.reload();
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
