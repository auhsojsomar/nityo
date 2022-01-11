<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./fontawesome-pro/fontawesome.css">
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
                <div class="modal-body">
                    <form method="post" id="productForm">
                        <div class="row">
                            <div class="col-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="col-6">
                                <label for="unit" class="form-label">Unit</label>
                                <input type="text" class="form-control" id="unit" required>
                            </div>
                            <div class="col-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" placeholder="0.00" required>
                            </div>
                            <div class="col-6">
                                <label for="date" class="form-label">Expiration Date</label>
                                <input type="date" class="form-control" id="date" required>
                            </div>
                            <div class="col-6">
                                <label for="available" class="form-label">Available</label>
                                <input type="text" class="form-control" id="available" required>
                            </div>
                            <div class="col-12">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
    </div>
    <script src="./js/jquery.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(() => {
            $('#productForm').on('submit', () => {
                $name = $('#name').val();
                $unit = $('#unit').val();
                $price = $('#price').val();

            })
        });
    </script>
</body>
</html>