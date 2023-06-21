<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel CRUD Testing</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="py-4 text-center">
                    <h1>Laravel CRUD Testing</h1>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="py-4 d-flex justify-content-end">
                    <a href="{{ route('customers.create') }}" class="btn btn-success mx-2">Create Customer</a>
                </div>
            </div>

            <div class="col-sm-12" id="message_response"></div>
            @if ($message = Session::get('success'))
                <div class="col-sm-12" id="message">
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                </div>
            @endif

            <div class="col-sm-12">
                <div class="table-responsive" id="costomersTable">
                    <table class="table table-bordered table-striped ">
                        <thead class="thead-dark">
                            <tr class="align-middle">
                                <th scope="col"></th>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telephone</th>
                                <th scope="col">Status </th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $key => $customer)
                                <tr class="align-middle">
                                    <td class="text-center">
                                        <input type="checkbox" name="customerId[]" value="{{ $customer->id }}">
                                    </td>
                                    <td>{{ $customer->code }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->telephone }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input change_status" type="checkbox"
                                                name="customerStatus[]"
                                                {{ $customer->status === 'active' ? 'checked' : null }}>
                                            <label class="form-check-label">{{ $customer->status }}</label>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST">
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ route('customers.edit', $customer->id) }}">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-danger show_confirm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $customers->links('pagination::bootstrap-5') !!}
                </div>

                <div class="col-sm-12">
                    <div class="py-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-warning mx-2" onclick="multipleUpdate()">Multiple Update
                            Status</button>
                        <button type="button" class="btn btn-danger" onclick="multipleDelete()">Multiple
                            Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click','.change_status', function() {

            var status = $(this).next().text();
            console.log("document loaded" + status);
            if (status === 'active') {
                $(this).next().text("inactive");
            } else {
                $(this).next().text("active");
            }
        });

        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            swal({
                    title: `Are you sure you to delete this Customer?`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });

        function multipleUpdate() {
            var elCustomerId = document.getElementsByName('customerId[]');
            var elCustomerStatus = document.getElementsByName('customerStatus[]');

            var customerStatus = Array.from(elCustomerId).map(function(input, index) {
                if (input.checked) {
                    return {
                        id: parseInt(input.value),
                        status: Array.from(elCustomerStatus)[index].nextElementSibling.lastChild.textContent
                    };
                } else {
                    return null;
                }
            });
            var datas = customerStatus.filter(function(v) {
                return v !== null
            });
            console.log(datas);
            if (datas.length !== 0) {
                swal({
                        title: `Are you sure you to update status?`,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('customers.multipleUpdate') }}",
                                dataType: "json",
                                data: {
                                    datas
                                },
                                success: function(datas) {
                                    $('#message').empty();
                                    $('#message_response').empty();
                                    $('#message_response').append('<div class="alert alert-success">' +
                                        '    <p>' + datas.message + '</p>' +
                                        '</div>');
                                    $("#costomersTable").load(
                                        "{{ route('customers.index') }} #costomersTable");
                                }
                            });
                        }
                    });
            } else {
                alert('Please select a customer to update status.');
            }
        }

        function multipleDelete() {
            var elCustomerId = document.getElementsByName('customerId[]');
            var customerIds = Array.from(elCustomerId).map(function(input) {
                if (input.checked) {
                    return parseInt(input.value);
                } else {
                    return null;
                }
            });
            var customerId = customerIds.filter(function(v) {
                return v !== null
            });
            if (customerId.length !== 0) {
                swal({
                        title: `Are you sure you to delete this Customers?`,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('customers.multipleDelete') }}",
                                dataType: "json",
                                data: {
                                    customerId: customerId
                                },
                                success: function(datas) {
                                    $('#message').empty();
                                    $('#message_response').empty();
                                    $('#message_response').append(
                                        '<div class="alert alert-success">' +
                                        '    <p>' + datas.message + '</p>' +
                                        '</div>');
                                    $("#costomersTable").load(
                                        "{{ route('customers.index') }} #costomersTable"
                                    );
                                }
                            });
                        }
                    });
            } else {
                alert('Please select a customer to delete.');
            }
        }
    </script>
</body>

</html>
