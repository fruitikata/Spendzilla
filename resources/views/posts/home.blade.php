<x-layout>
    @auth
        <h1 class="title text-left font-bold text-2xl mb-8">Latest Expenses</h1>

        {{-- Search and Filter Form --}}
        <form method="GET" action="{{ route('posts.index') }}" class="mb-8">
            <div class="flex flex-wrap gap-6">
                {{-- Search Bar --}}
                <input
                    type="text"
                    name="search"
                    placeholder="Search expenses by category or amount..."
                    value="{{ request('search') }}"
                    class="border h-14 border-gray-300 rounded px-4 py-3 w-full md:w-1/2 text-lg focus:outline-none focus:ring-2 focus:ring-pink-300 focus:ring-offset-2 focus:ring-offset-white"
                    style="transition: all 0.15s ease-in-out;"
                />

                {{-- Category Filter --}}
                <select
                    name="category"
                    class="border border-gray-300 rounded px-4 py-3 w-full md:w-1/4"
                >
                    <option value="">All Categories</option>
                    <option value="Groceries" {{ request('category') == 'Groceries' ? 'selected' : '' }}>Groceries</option>
                    <option value="Utilities" {{ request('category') == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                    <option value="Health" {{ request('category') == 'Health' ? 'selected' : '' }}>Health</option>
                    <option value="Transportation" {{ request('category') == 'Transportation' ? 'selected' : '' }}>Transportation</option>
                    <option value="Entertainment" {{ request('category') == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                </select>

                {{-- Sort Options --}}
                <select
                    name="sort"
                    class="border border-gray-300 rounded px-4 py-3 w-full md:w-1/4"
                >
                    <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date (Newest)</option>
                    <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date (Oldest)</option>
                    <option value="category_asc" {{ request('sort') == 'category_asc' ? 'selected' : '' }}>Category (A-Z)</option>
                    <option value="category_desc" {{ request('sort') == 'category_desc' ? 'selected' : '' }}>Category (Z-A)</option>
                    <option value="amount_asc" {{ request('sort') == 'amount_asc' ? 'selected' : '' }}>Amount (Lowest)</option>
                    <option value="amount_desc" {{ request('sort') == 'amount_desc' ? 'selected' : '' }}>Amount (Highest)</option>
                </select>

                <button type="submit" class="bg-red-400 text-white px-6 py-3 rounded hover:bg-red-600">
                    Apply
                </button>
            </div>
        </form>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div id="flashMessage" class="bg-green-500 text-white px-6 py-4 mb-6 rounded">
            <span>{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(() => {
                const flashMessage = document.getElementById('flashMessage');
                if (flashMessage) {
                    flashMessage.style.transition = "opacity 0.5s ease";
                    flashMessage.style.opacity = "0";
                    setTimeout(() => flashMessage.remove(), 500); // Remove the element after fading out
                }
            }, 2000);
        </script>
        @endif


        {{-- Expenses Table --}}
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 border border-gray-300 text-center">Date</th>
                        <th class="px-6 py-3 border border-gray-300 text-center">Category</th>
                        <th class="px-6 py-3 border border-gray-300 text-center">Amount</th>
                        <th class="px-6 py-3 border border-gray-300 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 border border-gray-300 text-center">{{ $post->date ? $post->date->format('Y-m-d') : 'N/A' }}</td>
                            <td class="px-6 py-3 border border-gray-300 text-center">{{ $post->category }}</td>
                            <td class="px-6 py-3 border border-gray-300 text-center">&#8369;{{ number_format($post->amount, 2) }}</td>
                            <td class="px-6 py-3 border border-gray-300 text-center">
                                {{-- Edit Button --}}
                                <button 
                                    class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 mr-6 w-20" 
                                    onclick="openEditModal({{ $post }})">
                                    Edit
                                </button>

                                {{-- Delete Button --}}
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 w-20">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6">No expenses found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Edit Modal --}}
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-lg p-8 shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Edit Expense</h2>
                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="editDate" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input
                            type="date"
                            required
                            id="editDate"
                            name="date"
                            class="border border-gray-300 rounded px-4 py-2 w-full"
                        />
                    </div>
                    <div class="mb-4">
                        <label for="editCategory" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select
                            id="editCategory"
                            name="category"
                            class="border border-gray-300 rounded px-4 py-2 w-full"
                            required
                        >
                            <option value="Groceries">Groceries</option>
                            <option value="Utilities">Utilities</option>
                            <option value="Health">Health</option>
                            <option value="Transportation">Transportation</option>
                            <option value="Entertainment">Entertainment</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="editAmount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                        <input
                            type="number"
                            id="editAmount"
                            required
                            name="amount"
                            min="0.01"
                            step="0.01"
                            class="border border-gray-300 rounded px-4 py-2 w-full"
                        />
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mt-5">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-5">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- JavaScript --}}
        <script>
            function openEditModal(post) {
                const modal = document.getElementById('editModal');
                const form = document.getElementById('editForm');
                document.getElementById('editDate').value = post.date;
                document.getElementById('editCategory').value = post.category;
                document.getElementById('editAmount').value = post.amount;
                form.action = `/posts/${post.id}`;
                modal.classList.remove('hidden');
            }
        
            function closeEditModal() {
                document.getElementById('editModal').classList.add('hidden');
            }
        </script>

    @endauth

    @guest
        <h1 class="title text-center font-bold text-2xl mb-4">
            SPENDZILLA: Track your expenses so you can finally stop saying, "I swear I had more money yesterday!"
        </h1>
        <h2 class="text-center text-lg">
            Destroy those disorganized expenses. &#x1F4B8;&#x1F54A;
        </h2>
    @endguest
</x-layout>

