<x-layout>
    <h1 class="mb-4">Please verify your email through the email we've sent you.</h1>

    <p>Didn't get an email?</p>
    <form action="{{ route('verification.send')}}" method="post">
        @csrf

        <button class="btn mt-4">Send again</button>
    </form>
</x-layout>