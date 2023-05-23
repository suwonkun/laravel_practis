<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>
    <h1>{{ $company->name }}</h1>

    <form action="{{ route('sections.store', ['company' => $company]) }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Name">
        <button type="submit">Submit</button>
    </form>

</x-app-layout>
