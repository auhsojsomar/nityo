$(document).ready(function () {
  let methodType = "";
  let productID = "";

  let productTable = $("#productTable").DataTable({
    processing: true,
    ajax: {
      url: "product/fetch.php",
      type: "POST",
      dataType: "json",
    },
  });

  $(document).on("submit", "form#productForm", function (e) {
    // prevent to submit form
    e.preventDefault();

    let formData = new FormData(this);
    formData.append("id", productID);

    $.ajax({
      type: "POST",
      url: `product/${methodType}.php`,
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (message) {
        Swal.fire({
          title: message.message,
          icon: message.msgType,
          confirmButtonText: "OK",
        });

        if (message.msgType == "success") {
          $("#productModal").modal("hide");
          $("#productForm")[0].reset();
          productTable.ajax.reload();
        }
      },
    });
  });

  $(document).on("click", 'button[name="delete"]', function () {
    Swal.fire({
      title: "Are you sure you want to delete?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "product/delete.php",
          data: { id: this.id },
          success: (message) => {
            if (message == "error") {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
              });
            } else {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              productTable.ajax.reload();
            }
          },
        });
      }
    });
  });

  $(document).on("click", 'button[name="update"]', function () {
    productID = this.id;

    $.ajax({
      url: "product/fetchSingle.php",
      type: "POST",
      dataType: "json",
      data: { id: this.id },
      success: function (data) {
        $('[name="name"]').val(data.name);
        $('[name="unit"]').val(data.unit);
        $('[name="price"]').val(data.price);
        $('[name="date"]').val(data.date);
        $('[name="available"]').val(data.available);
        $("#productModal").modal("show");
        $(".modal-title").html("Edit Product");
        methodType = "update";
      },
    });
  });

  $(document).on("click", "#addButton", function () {
    methodType = "add";
    productID = "";
    $("#productForm")[0].reset();
    $(".modal-title").html("Add Product");
  });
});
