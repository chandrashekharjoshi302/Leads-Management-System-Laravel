@extends('layouts.app')

@section('content')
    @include('layouts.navbar')

    <div
        style="max-width: 600px; margin: 30px auto; padding: 30px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px; text-align: center; color: #333;">Create New Lead</h2>

        @if ($errors->any())
            <div
                style="background-color: #ffe6e6; border: 1px solid #ff0000; padding: 10px; margin-bottom: 20px; border-radius: 5px; color: #900;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('leads.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Name:</label><br>
                <input type="text" name="name" value="{{ old('name') }}" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Email:</label><br>
                <input type="email" name="email" value="{{ old('email') }}" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Phone:</label><br>
                <input type="text" name="phone" value="{{ old('phone') }}" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Lead Source:</label><br>
                <input type="text" name="lead_source" value="{{ old('lead_source') }}"
                    style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Status:</label><br>
                <select name="status" style="width: 100%; padding: 8px;">
                    @foreach (['New', 'Contacted', 'Converted', 'Lost'] as $status)
                        <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if (auth()->user()->role === 'admin')
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: bold;">Assigned To:</label><br>
                    <select name="assigned_to" style="width: 100%; padding: 8px;">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold;">Remarks:</label><br>
                <textarea name="remarks" style="width: 100%; padding: 8px; height: 100px;">{{ old('remarks') }}</textarea>
            </div>

            <button type="submit"
                style="width: 100%; background-color: #28a745; color: white; border: none; padding: 10px 0; font-size: 16px; border-radius: 5px; cursor: pointer;">
                Create Lead
            </button>
        </form>
    </div>
@endsection
