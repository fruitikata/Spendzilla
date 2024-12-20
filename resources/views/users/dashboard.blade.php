<x-layout>
    <!-- Include Chart.js and 3D Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-3d"></script>

    <h1 class="title text-center">Hello, {{ auth()->user()->username }}!</h1>

    {{-- user expenses (dashboard) --}}
    <div class="flex flex-row">
        <!-- Dashboard Content -->
        <div class="flex-grow p-4">
            <h2 class="font-bold text-xl mb-4">Dashboard</h2>

            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-lg mb-4">Expense Summary</h3>
                @if (!empty($categoryData) && count($categoryData) > 0)
                    <!-- Display chart if there are expenses -->
                    <canvas id="postChart"></canvas>
                @else
                <!-- Display a message if there are no expenses -->
                <p class="text-center text-gray-500">No expenses recorded yet. Start adding some!</p>
                @endif
            </div>
        </div>

        <!-- expense card -->
        <div id="expenseCard" class="card w-96 mb-4 h-full mx-auto mt-14 flex-shrink-0 transition-all ease-in-out duration-300">
            <h2 class="font-bold mb-4 text-center">Spent your money again?</h2>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-yellow-500 text-white text-center p-2 mb-4 rounded-md" id="success-message">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500 text-white p-2 text-center mb-4 rounded-md" id="error-message">
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <style>
                #success-message, #error-message {
                    transition: opacity 0.5s ease-in-out;
                }
            </style>
            <script>
                const message = document.getElementById('success-message') || document.getElementById('error-message');
                if (message) {
                    setTimeout(function() {
                        message.style.opacity = '0';
                        setTimeout(function() {
                            message.style.display = 'none';
                        }, 500);
                    }, 2000);
                }
            </script>

            <!-- add expense Button -->
            <div class="flex justify-center">
                <button 
                    id="addExpenseButton" 
                    class="primary-btn bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600">
                    Add Expense
                </button>
            </div>

            <!-- form to add expense -->
            <div id="expenseForm" class="hidden mt-6">
                <form id="expenseFormAction" action="{{ route('posts.store') }}" method="post" class="bg-white p-6 rounded-lg shadow-md border border-pink-300">
                    @csrf
                    <div class="mb-4">
                        <label for="date" class="text-pink-900 font-semibold">Date</label>
                        <input type="date" name="date" class="input mt-1 border border-pink-300 rounded-md w-full" required>
                    </div>

                    <div class="mb-4">
                        <label for="category" class="text-pink-900 font-semibold">Category</label>
                        <select name="category" class="input mt-1 border border-pink-300 rounded-md w-full" required>
                            <option value="" disabled selected>Select a category</option>
                            <option value="Groceries">Groceries</option>
                            <option value="Utilities">Utilities</option>
                            <option value="Health">Health</option>
                            <option value="Transportation">Transportation</option>
                            <option value="Entertainment">Entertainment</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="amount" class="text-pink-900 font-semibold">Amount</label>
                        <input type="number" name="amount" class="input mt-1 border border-pink-300 rounded-md w-full" step="0.01" min="0" required>
                    </div>

                    <div class="mt-6 flex justify-center">
                        <button type="submit" class="primary-btn bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600">
                            Upload
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex justify-center mt-6">
                <img src="{{ asset('spendzillaDino.png') }}" alt="spendzillaLogo" class="w-20 h-20">
            </div>
        
        </div>

        
        
    </div>
    

    <script>
        // Toggle the visibility of the expense form
        document.getElementById('addExpenseButton').addEventListener('click', function () {
            const form = document.getElementById('expenseForm');
            const card = document.getElementById('expenseCard');
            form.classList.toggle('hidden'); // Toggle the 'hidden' class

            // Adjust the card height when the form is shown (no height restriction, just let it expand)
            if (!form.classList.contains('hidden')) {
                card.classList.add('h-auto'); // Let the card grow to fit the content
            } else {
                card.classList.remove('h-auto'); // Reset it back to default height
            }
        });
    </script>

    <script>
        // Chart.js code for 3D Pie Chart
        const categoryLabels = @json($categoryLabels);
        const categoryData = @json($categoryData);

        const ctx = document.getElementById('postChart').getContext('2d');
        const postChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Expenses by Category',
                    data: categoryData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)'
                    ],
                    hoverOffset: 10,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#333',
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => `${context.label}: ${context.raw}`
                        }
                    },
                    'chartjs-plugin-3d': {
                        enabled: true,  // Enable 3D plugin
                        mode: 'pie',    // Ensure it's a 3D pie chart
                        alpha: 20,      // Adjust rotation angle for 3D effect
                        beta: 30,       // Tilt the pie chart in 3D space
                    }
                },
                layout: {
                    padding: 20
                }
            }
        });
    </script>
</x-layout>
