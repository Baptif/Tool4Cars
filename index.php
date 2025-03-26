<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tool4cars</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
<div class="container">
    <h1 class="my-4">Tool4cars</h1>
    <div class="d-flex justify-content-between">
        <div id="client-buttons" class="btn-group mb-4">
            <button class="btn btn-outline-secondary" data-client="clienta">Client A</button>
            <button class="btn btn-outline-secondary" data-client="clientb">Client B</button>
            <button class="btn btn-outline-secondary" data-client="clientc">Client C</button>
        </div>
        <div>
            <select id="module-selector" class="form-control">
                <option value="cars" selected>Cars</option>
                <option value="garages">Garages</option>
            </select>
        </div>
    </div>

    <div class="dynamic-div" data-module="cars" data-script="ajax"></div>
</div>
</body>
</html>