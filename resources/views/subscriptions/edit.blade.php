@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Edit Subscription</h1>
        <form action="{{ route('subscriptions.update', $subscription) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <input type="hidden" name="member_id" value="{{ Auth::guard('member')->id() }}">
    
            </div>



            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $subscription->start_date) }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('start_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="number_of_months" class="block text-sm font-medium text-gray-700">Number of Months</label>
                <input type="number" id="number_of_months" name="number_of_months" value="{{ old('number_of_months', $subscription->number_of_months) }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('number_of_months')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $subscription->price) }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>

            <div id="discountMessage" class="text-sm text-gray-600 mb-2"></div>
            <div id="discountText" class="text-sm text-gray-600"></div>

            <div class="mt-4 text-sm text-gray-600">
                By editing this subscription, you agree to our terms and conditions.
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Subscription
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const number_of_months = document.getElementById('number_of_months');
            const priceInput = document.getElementById('price');
            const discountMessage = document.getElementById('discountMessage');
            const discountText = document.getElementById('discountText');

            number_of_months.addEventListener('change', function () {
                const months = parseInt(this.value);
                let basePrice = 100; // Example base price
                let discount = '';

                if (months > 3 && months <= 6) {
                    priceInput.value = (basePrice * months * 0.9).toFixed(2); // 10% discount for 4 to 6 months
                    discount = '10% discount applied.';
                } else if (months > 6) {
                    priceInput.value = (basePrice * months * 0.8).toFixed(2); // 20% discount for more than 6 months
                    discount = '20% discount applied.';
                } else {
                    priceInput.value = (basePrice * months).toFixed(2); // No discount for 1 to 3 months
                    discount = 'No discount applied.';
                }

                discountMessage.textContent = discount;

                // Additional text based on the discount logic
                if (months > 3) {
                    discountText.textContent = 'You receive a discount because you subscribed for more than 3 months.';
                } else {
                    discountText.textContent = 'No additional discount for subscriptions less than or equal to 3 months.';
                }
            });

            // Trigger the change event if number of months is already set on edit
            if (number_of_months.value) {
                number_of_months.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection
