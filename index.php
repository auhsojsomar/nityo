<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/datatables.min.css">
    <title>Nityo Infotech</title>
</head>
<body>
    <div class="container">
        <button id="addButton" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#productModal">Add Product</button>

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
                                <input type="number" step=".01" min="0" value="0.00" class="form-control" name="price" placeholder="0.00">
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
        <table id="productTable" class="w-100">
            <thead>
                <tr>
                    <th class="col">Name</th>
                    <th class="col">Unit</th>
                    <th class="col">Price</th>
                    <th class="col">Date</th>
                    <th class="col">Available</th>
                    <th class="col-2">Image</th>
                    <th class="col">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script src="./js/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="./js/jquery.js"></script>
    <script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/datatables.min.js"></script>
    
    <script type="text/javascript">
        
        $(document).ready(function() {

            let methodType = "";
            let productID = "";

            let productTable = $("#productTable").DataTable({
                processing: true,
                ajax: {
                    url: "product/fetch.php",
                    type: "POST",
                    dataType: "json"
                }
            });
            
            $(document).on("submit","form#productForm", function(e) {
                // prevent to submit form
                e.preventDefault();
                
                let formData = new FormData(this);
                formData.append("id", productID);
                
                $.ajax({
                    type: "POST",
                    url: `product/${methodType}.php`,
                    data: formData,
                    contentType: false,
                    processData:false,
                    dataType:"json",
                    success: function(message){
                        Swal.fire({
                        title: message.message,
                        icon: message.msgType,
                        confirmButtonText: "OK"
                        });

                        if(message.msgType == "success"){
                            $("#productModal").modal("hide");
                            $("#productForm")[0].reset();
                            productTable.ajax.reload();
                        }
                    }
                });
            });

            $(document).on('click','button[name="delete"]', function(){
                Swal.fire({
                title: 'Are you sure you want to delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "product/delete.php",
                        data: {id: this.id},
                        success: message => {
                            if(message == "error"){
                                Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                });
                            }
                            else{
                                 Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );
                                productTable.ajax.reload();
                            }
                            
                        }
                    });
                }
                });

                
            });

            $(document).on('click','button[name="update"]', function(){

                productID = this.id;

                $.ajax({
                    url: "product/fetchSingle.php",
                    type: "POST",
                    dataType: "json",
                    data: {id: this.id},
                    success: function(data){
                        $('[name="name"]').val(data.name);
                        $('[name="unit"]').val(data.unit);
                        $('[name="price"]').val(data.price);
                        $('[name="date"]').val(data.date);
                        $('[name="available"]').val(data.available);
                        $('#productModal').modal('show');
                        methodType = "update";
                    }
                });
            });

            $(document).on('click', '#addButton', function(){
                methodType = "add";
                productID = "";
            });

        });
    </script>
</body>
</html>