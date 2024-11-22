<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>User Settings</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
        </style>
    @endif
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
            <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                <div class="flex lg:justify-center lg:col-start-2">
                </div>
            </header>

            <main class="mt-6">
                <h1 class="text-2xl font-bold mb-4">User Settings</h1>
                @if(!empty($plainItems) && count($plainItems) > 0)
                    <table class="min-w-full bg-white dark:bg-gray-800 text-black dark:text-white/70 border border-gray-300 dark:border-gray-700">
                        <thead>
                        <tr class="bg-gray-100 dark:bg-gray-900">
                            <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700">Email</th>
                            <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-700">Action</th>
                        </tr>
                        </thead>
                        <tbody>@foreach($plainItems as $item)
                            @if(array_key_exists('twillioNumber', $item))
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700">{{ $item['email'] }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-700">
                                    <button type="button" class="btn btn-primary"
                                            data-email="{{ $item['email'] }}"
                                            data-number="{{$item['twillioNumber']}}"
                                            data-local="{{ $item['localPhoneNumber'] ?? null }}"
                                            data-forward="{{$item['callForward'] ?? false}}"
                                            data-pager="{{ $item['pagerNumber'] ?? null }}"
                                            data-id="{{ $item['id'] }}"
                                            data-personal="{{$item['myPhoneNumber'] ?? null }}"
                                            data-toggle="modal" data-target="#exampleModal">
                                        Trigger Test
                                    </button>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No data available.</p>
                @endif
            </main>
            <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                {{--Pheonix Test App--}}
            </footer>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Callback Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="user">User ID</label>
                            <input type="text" class="form-control" readonly="readonly" id="user" name="user" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" readonly="readonly" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="callback_number">Callback Number</label>
                            <input type="text" class="form-control" id="callback_number" name="callback_number" required>
                        </div>
                        <div class="form-group">
                            <label for="to_number">To Phone Number</label>
                            <input type="text" class="form-control" id="to_number" readonly="readonly" name="to_number" required>
                        </div>
                        <div class="form-group">
                            <label for="localPhoneNumber">Local PhoneNumber</label>
                            <input type="text" class="form-control" id="localPhoneNumber" readonly="readonly" name="localPhoneNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="callForward">Call Forward</label>
                            <input type="text" class="form-control" id="callForward" readonly="readonly" name="callForward" required>
                        </div>
                        <div class="form-group">
                            <label for="pagerNumber">Pager Number</label>
                            <input type="text" class="form-control" id="pagerNumber" readonly="readonly" name="pagerNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="myPhoneNumber">My Phone Number</label>
                            <input type="text" class="form-control" id="myPhoneNumber" readonly="readonly" name="myPhoneNumber" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Trigger Test</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
<style>
    table {
        width: 100%;
        border-collapse: collapse; /* Collapses borders to make them appear as one */
    }
    th, td {
        border: 1px solid black; /* Adds borders to table cells */
        padding: 3px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2; /* Light gray background for header */
    }
</style>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script>
    const appUrl = "{{ config('app.api_url') }}";
    $(document).ready(function() {
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);  // Button that triggered the modal
            var email = button.data('email');       // Get user ID from data-id attribute
            var user = button.data('id');       // Get user ID from data-id attribute
            var toNumber = button.data('number');       // Get user ID from data-id attribute
            var localPhoneNumber = button.data('local');       // Get user ID from data-id attribute
            var callForward = button.data('forward');       // Get user ID from data-id attribute
            var pagerNumber = button.data('pager');       // Get user ID from data-id attribute
            var myPhoneNumber = button.data('personal');       // Get user ID from data-id attribute

            // Set the user ID in the hidden input field
            var modal = $(this);
            modal.find('#email').val(email);
            modal.find('#user').val(user);
            modal.find('#to_number').val(toNumber);
            modal.find('#localPhoneNumber').val(localPhoneNumber);
            modal.find('#callForward').val(callForward);
            modal.find('#pagerNumber').val(pagerNumber);
            modal.find('#myPhoneNumber').val(myPhoneNumber);
        });

        $('#exampleModal form').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Collect form data
            var formData = {
                userID: $('#user').val(),
                email: $('#email').val(),
                callbackNumber: $('#callback_number').val(),
                toNumber: $('#to_number').val(),
                localPhoneNumber: $('#localPhoneNumber').val(),
                callForward: $('#callForward').val(),
                pagerNumber: $('#pagerNumber').val(),
                myactualPhoneNumber: $('#myPhoneNumber').val()
            };

            // Send API request
            $.ajax({
                url: appUrl, // API endpoint
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData), // Convert form data to JSON
                success: function(response) {
                    // Handle success response
                    alert('Data submitted successfully!');
                    $('#exampleModal').modal('hide'); // Close the modal
                },
                error: function(error) {
                    // Handle error response
                    alert('Failed to submit data. Please try again.');
                    console.error(error);
                }
            });
        });
    });
</script>
