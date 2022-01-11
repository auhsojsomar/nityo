<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./fontawesome-pro/fontawesome.css">
    <title>Nityo Infotech</title>
</head>
<body>
    <div class="container">
        <div class="btn btn-success" data-bs-toggle="modal" data-bs-target="#productModal">
        <i class="far fa-plus-circle"> Add Product</i>
        </div>

        <div class="modal fade" id="productModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="productForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="col-6">
                                <label for="unit" class="form-label">Unit</label>
                                <input type="text" class="form-control" name="unit">
                            </div>
                            <div class="col-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" name="price" placeholder="0.00">
                            </div>
                            <div class="col-6">
                                <label for="date" class="form-label">Expiration Date</label>
                                <input type="date" class="form-control" name="date">
                            </div>
                            <div class="col-6">
                                <label for="available" class="form-label">Available</label>
                                <input type="text" class="form-control" name="available">
                            </div>
                            <div class="col-12">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
    </div>
    <script type="text/javascript" src="./js/jquery.js"></script>
    <script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#productForm').on('submit', function(e) {
                // prevent to submit form
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'product/add.php',
                    data: $('#productForm').serialize(),
                    success: function(message){
                        alert(message);
                    }
                })
            });
        });
    </script>
</body>
</html>