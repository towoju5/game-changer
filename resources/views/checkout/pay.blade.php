<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two Column Layout</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="grid lg:grid-cols-2 h-screen">
        <!-- Left side -->
        <div class="hidden lg:block flex-1 bg-blue-500 text-white p-8">
            <!-- Logo and product info -->
            <div class="mb-8">
                <img src="logo.png" alt="Logo" class="w-16 h-16 mb-4">
                <h2 class="text-xl font-bold">Product Name</h2>
                <p class="text-sm">Description of the product goes here.</p>
            </div>
            <!-- Crypto checkout info -->
            <div>
                <h3 class="text-lg font-bold mb-4">Crypto Checkout Info</h3>
                <p class="text-sm">Details about crypto checkout...</p>
                <!-- Add more content here as needed -->
            </div>
        </div>
        <!-- Right side -->
        <div class="flex-1 bg-white text-black p-8 flex flex-col items-center justify-center">
            <!-- Add your content for the right side here -->
            <div class="w-full p-5 lg:p-20">
                <h2 class="text-2xl font-bold mb-4">Checkout</h2>
                <div class="mb-4">
                    <label for="crypto-select" class="block font-bold mb-2">Select Cryptocurrency:</label>
                    <select id="crypto-select" class="border rounded py-2 px-3 w-full select2">
                        <option value="btc">Bitcoin (BTC)</option>
                        <!-- Add more options for other cryptocurrencies -->
                    </select>
                </div>
                <div class="mb-4">
                    <p class="font-bold">Wallet Address:</p>
                    <p>{{ $walletAddress }}</p>
                </div>
                <div class="mb-4">
                    <p class="font-bold">Amount (BTC):</p>
                    <p>{{ $amount }}</p>
                </div>
                <div class="mb-4">
                    <p class="font-bold">Amount (USD):</p>
                    <p>{{ $amountUsd }}</p>
                </div>
                <div class="mb-4">
                    <p class="font-bold">QR Code:</p>
                    {!! $qrCode !!}
                </div>
            </div>

            <!-- Add more content here as needed -->
        </div>
    </div>
    {{-- @section('scripts') --}}
      <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
    {{-- @endsection
    
    @section('styles') --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    {{-- @endsection --}}
    
</body>

</html>
