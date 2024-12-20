<x-layout>
    <h1 class="title text-left">Edit Expense</h1>
  
    {{-- Edit Form --}}
    <form action="{{ route('posts.update', $post->id) }}" method="POST" class="mb-4">
        @csrf
        @method('PUT')
  
        <div class="flex gap-4">
            {{-- Category --}}
            <select
                name="category"
                class="border border-gray-300 rounded px-3 py-2 w-1/3"
            >
                <option value="" disabled selected>Select a category</option>
                <option value="Groceries" {{ old('category', $post->category) == 'Groceries' ? 'selected' : '' }}>Groceries</option>
                <option value="Utilities" {{ old('category', $post->category) == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                <option value="Health" {{ old('category', $post->category) == 'Health' ? 'selected' : '' }}>Health</option>
                <option value="Transportation" {{ old('category', $post->category) == 'Transportation' ? 'selected' : '' }}>Transportation</option>
                <option value="Entertainment" {{ old('category', $post->category) == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
            </select>
  
            {{-- Amount --}}
            <input
                type="number"
                name="amount"
                placeholder="Amount"
                value="{{ old('amount', $post->amount) }}"
                class="border border-gray-300 rounded px-3 py-2 w-1/3"
            />
  
            {{-- Date --}}
            <input
                type="date"
                name="date"
                value="{{ old('date', $post->date->format('Y-m-d')) }}"
                class="border border-gray-300 rounded px-3 py-2 w-1/3"
            />
        </div>
  
        <button type="submit" class="bg-red-400 text-white px-4 py-2 rounded mt-4">Update Expense</button>
    </form>
  </x-layout>