<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/main.css">

    <title>Coalition coding example</title>
</head>

<body>
    <div class="container">
        <!-- product form  -->
        <form class="productForm needs-validation" novalidate>
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" name="name" class="form-control" id="productName" aria-describedby="product name" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity in stock</label>
                <input type="number" name="quantity" class="form-control" id="quantity" required>
            </div>
            <div class="form-group">
                <label for="unitPrice">Price per item</label>
                <input type="string" name="price" class="form-control" id="unitPrice" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- show error message  -->
        <div id="errorModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="errorMsg">Something goes wrong!</p>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
                </div>
            </div>
        </div>

        <!-- list  -->
        <?php
           $jsondata = file_get_contents("data.json");
           // converts json data into array
           $items = json_decode($jsondata, true);
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">price</th>
                    <th scope="col">Date</th>
                    <th scope="col">Total Value</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $index => $item): ?>
                    <tr>
                        <th scope="row"><?php echo $index ?></th>
                        <td><?php echo $item['name'] ?></td>
                        <td><?php echo $item['quantity'] ?></td>
                        <td><?php echo $item['price'] ?></td>
                        <td><?php echo date('Y-m-d H:i:s', $item['date']) ?></td>
                        <td><?php echo ($item['quantity'] * $item['price']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');


                    }, false);
                });
            }, false);

            // submit the form
            $('.productForm').submit(e => {
                console.log('now submit')
                let data = $('.productForm').serialize();
                console.log('aaa', data);
                $.ajax({
                    url: "process.php",
                    type: "post",
                    data: data,
                    dataType: "json",
                    success: res => {
                        console.log(res)
                        if (res.status == 0) {
                            $('#errorMsg').text(res.msg)
                            $('#errorModal').modal()
                        } else if(res.status == 1) {
                            alert('success!')
                            window.location.reload(true)
                        }
                    }
                })

                return false
            })

        })();
    </script>
</body>

</html>
