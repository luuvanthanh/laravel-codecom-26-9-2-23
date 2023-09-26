<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="row mt-5">
        <div class="row d-flex justify-content-center align-items-center main">
            <a href="/download-template-employee" type="button" class="btn btn-success col-1">Download</a>
            <form action="/import-employee" method="POST" enctype="multipart/form-data" class="col-3 d-flex">
                @csrf
                <input type="file" name="file" class="form-control" placeholder="Choose file">
                <button type="submit" name="submit" class="btn btn-primary">Import</button>
            </form>
            <a href="/export-template-employee" type="button" class="btn btn-success col-1">Export</a>
        </div>
        @if (Session::has('success'))
            <div class="row d-flex justify-content-center mt-3">
                <p class=" col-4 alert alert-info">{{ Session::get('success') }}</p>
            </div>
        @endif
        @if (Session::has('errors'))
            @foreach (Session::get('errors')['error'] as $error)
                <div class="row d-flex justify-content-center mt-3">
                    <p class=" col-4 alert alert-danger">{{Session::get('errors')['row_error'] . $error }}</p>
                </div>
            @endforeach
        @endif
    </div>
</body>

</html>
