<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel CRUD Testing : Create Customer</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="py-4">
                    <h1>Create Customer</h1>
                </div>
            </div>
        </div>
        <form class="g-3 needs-validation w-100" action="{{ route('customers.store') }}" method="POST" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-2">
                        <label for="validationCustom01" class="form-label">Code : </label>
                        <input type="text" class="form-control" id="validationCustom01" name="code" required>
                        <div class="invalid-feedback">
                            Please enter customer code.
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-2">
                        <label for="validationCustom02" class="form-label">Name : </label>
                        <input type="text" class="form-control" id="validationCustom02" name="name" required>
                        <div class="invalid-feedback">
                            Please enter customer name.
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-2">
                        <label for="validationCustom03" class="form-label">Email : </label>
                        <div class="input-group has-validation">
                            <input type="email" class="form-control" id="validationCustom03"
                                aria-describedby="inputGroupPrepend" name="email" required>
                            <div class="invalid-feedback">
                                Please enter customer email.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-2">
                        <label for="validationCustom04" class="form-label">Telephone : </label>
                        <input type="text" class="form-control" id="validationCustom04" name="telephone" required>
                        <div class="invalid-feedback">
                            Please enter customer telephone.
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group mb-2">
                        <label class="form-label">Status : </label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="statusRadios1"
                                value="active" checked>
                            <label class="form-check-label" for="statusRadios1">
                                Active
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="statusRadios2"
                                value="inactive">
                            <label class="form-check-label" for="statusRadios2">
                                Inactive
                            </label>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="py-4 d-flex justify-content-end">
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary mx-2">Cancel</a>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        // JavaScript for disabling form submissions if there are invalid fields
        (() => {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>
