@extends('dashboard.navigation')
@section('dashboard-content')

@method('POST')
<h1>Dashboard</h1>

@foreach($hospitals as $hospital)
<div class="col-sm-12 col-mg-6 col-lg-4 mb-4">
    <div class="card">
        <div class="card-header h3">Hospital Details</div>
        <div class="card-body">
            <p><strong>Name:</strong>{{$hospital->name}}</p>
            <p><strong>Location:</strong>{{$hospital->location}}</p>
            <p><strong>Mail:</strong>{{$hospital->email}}</p>
            <p><strong>Contact:</strong>{{$hospital->contact}}</p>
        </div>
        <div class="card-footer p-0 mx-0" style="display: inline;">
            <a href="{{ route('hospital.edit', hash('sha256',$hospital->id)) }}" class="btn btn-primary col-6">Edit</a>
            <form action="{{ route('hospital.destroy', $hospital->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="col-5 btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
            </form>
        </div>
    </div>
</div>

<div class="col-sm-12 col-mg-6 col-lg-4 mb-4">
    <div class="card">
        <div class="card-header h3">Hospital Qr-code</div>
        <div class="card-body text-center">
            <img src="{{ asset('storage/' . $hospital->qrcode) }}" alt="{{$hospital->qrcode}}" title="{{$hospital->qrcode}}">
        </div>
        <a href="{{ asset('storage/' . $hospital->qrcode) }}" download class="text-decoration-none">
            <div class="card-footer text-center text-light bg-primary">Download</div>
        </a>
    </div>
</div>

<div class="col-sm-12 col-mg-6 col-lg-4 mb-4">
    <div class="card">
        <div class="card-header h3">Total Patients</div>
        <div class="card-body text-center">
            @if ($hospital->patients->count()>0)
            <h3>{{$hospital->patients->count()}}</h3>
            @else
            No Patients found
            @endif
        </div>
        <a href="{{route('dashboard.patients.index')}}"><button class="btn btn-primary text-center col-12">Show</button></a>
    </div>
</div>

<div class="col-sm-12 col-mg-6 col-lg-4 mb-4">
    <div class="card">
        <div class="card-header h3">Patients Registered Today</div>
        <div class="card-body">
            <h3 id="patient_td">{{ $hospital->patients->where('created_at', today())
            ->count()}}</h3>
        </div>
    </div>
</div>

<div class="col-sm-12 col-mg-6 col-lg-4 mb-4">
    <div class="card">
        <div class="card-header h3">Patients Registered This Week</div>
        <div class="card-body">
            <h3 id="patient_tw">{{ $hospital->patients->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count(); }}</h3>
        </div>
    </div>
</div>

<div class="col-sm-12 col-mg-6 col-lg-4 mb-4">
    <div class="card">
        <div class="card-header h3">Patients Registered This Year</div>
        <div class="card-body">
            <h3 id="patient_ty">{{ $hospital->patients
            ->where('created_at', now()->year)
            ->count(); }}</h3>
        </div>
    </div>
</div>

<!-- Add this to the head section of your HTML file -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Add this to your HTML body -->
<canvas id="patientChart" width="400" height="200" class=" text-success"></canvas>
<!-- Add this to your HTML body -->
<script>
    // Function to fetch patient registration data and update the chart
    // get data from div

    const patientTY = document.getElementById("patient_ty").innerText;
    const patientTD = document.getElementById("patient_td").innerText;
    const patientTW = document.getElementById("patient_tw").innerText;

    function updatePatientChart() {
        // Replace this with your actual API endpoint or data fetching logic
        // Example data: replace this with the actual data from your server
        const registrationData = {
            labels: ['Today', 'This Week', 'This Year'],
            datasets: [{
                label: 'Number of Patients',
                backgroundColor: ['green', 'blue', 'red'], // Specify colors for today, this week, and this year
                borderColor: 'rgba(75, 192, 192, 1)',
                color: 'red',
                borderWidth: 1,
                data: [patientTD, patientTW, patientTY], // Replace with the actual patient registration counts
            }, ],
        };

        // Get the canvas element
        const ctx = document.getElementById('patientChart').getContext('2d');

        // Create the bar chart
        const myChart = new Chart(ctx, {
            type: 'line',
            data: registrationData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    }

    // Call the function to update the chart
    updatePatientChart();
</script>



@endforeach

@endsection