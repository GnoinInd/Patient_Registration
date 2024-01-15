@extends('dashboard.navigation')

@section('dashboard-content')

<div class="container table-responsive bg-opaque p-3 rounded text-light">
    <a class="btn btn-info" href="javascript:void(0)" id="createNewProduct">Add New Patient</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    @foreach ($patients as $patient )

@endforeach
</div>

<!-- The Modal for Create and Edit -->
<div class="modal fade" id="ajaxModelexa" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="patientForm" action="{{ route('dashboard.patients.store') }}" method="post" class="px-5">
                    @csrf
                    <!-- Add a hidden field to store patient ID -->
                    <input type="hidden" name="patient_id" id="patient_id">
                    
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="name" required class="form-control">
                    <br>

                    <label for="dob" class="form-label">Date of Birth:</label>
                    <input type="date" name="dob" required class="form-control">
                    <br>

                    <label for="address" class="form-label">Address:</label>
                    <input type="text" name="address" required class="form-control">
                    <br>

                    <label for="phone_number" class="form-label">Phone Number:</label>
                    <input type="text" name="phone_number" required class="form-control">
                    <br>

                    <label for="gender" class="form-label">Gender:</label>
                    <input type="text" name="gender" required class="form-control">
                    <br>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Search input and button -->


<!-- JavaScript to handle form submission, DataTables, and search -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function () {

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var table = $('.data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('dashboard.patients.get') }}",
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'dob', name: 'dob' },
        { data: 'address', name: 'address' },
        { data: 'phone_number', name: 'phone_number' },
        { data: 'gender', name: 'gender' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
});

$('#createNewProduct').click(function () {
    $('#patientForm').trigger("reset");
    $('#modelHeading').html("Create New Patient");
    $('#ajaxModelexa').modal('show');
});

    $('.data-table').on('click', '.editProduct', function () {
    
        var id = $(this).data('id');
        // Set patient ID in the hidden field
        $('#patient_id').val(id);

        // Make an AJAX request to retrieve patient data
        $.get("{{ route('dashboard.patients.store') }}" + '/' + id , function (data) {
            $('#modelHeading').html("Edit Patient");
            $('#ajaxModelexa').modal('show');
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#dob').val(data.dob);
            $('#address').val(data.address);
            $('#phone_number').val(data.phone_number);
            $('#gender').val(data.gender);
        });
});



// Corrected click event for deleting a patient
$('.data-table').on('click', '.deleteProduct', function () {
    
    var id = $(this).data("id");
    if (confirm("Are you sure you want to delete this patient?")) {
        $.ajax({
            type: "DELETE",
            url: "{{ route('dashboard.patients.destroy', '') }}/" + id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
});

$('#patientForm').submit(function (e) {
    e.preventDefault();
    $.ajax({
        data: $(this).serialize(),
        url: $(this).attr('action'),
        type: "POST",
        dataType: 'json',
        success: function (data) {
            $('#patientForm').trigger("reset");
            $('#ajaxModelexa').modal('hide');
            table.draw();
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});
});

</script>

@endsection
