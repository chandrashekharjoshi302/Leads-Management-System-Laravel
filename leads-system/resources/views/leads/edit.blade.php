@extends('layouts.app')

@section('content')
    @include('layouts.navbar')

    <div
        style="max-width: 600px; margin: 30px auto; background: #f9f9f9; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="margin-bottom: 20px; text-align: center;">Edit Lead</h2>

        @if ($errors->any())
            <div
                style="background-color: #ffe0e0; color: #d8000c; padding: 10px 15px; border-radius: 4px; margin-bottom: 15px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('leads.update', $lead->id) }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="name" style="font-weight: bold;">Name:</label>
                <input type="text" name="name" id="name" value="{{ old('name', $lead->name) }}"
                    style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="email" style="font-weight: bold;">Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email', $lead->email) }}"
                    style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="phone" style="font-weight: bold;">Phone:</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $lead->phone) }}"
                    style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="lead_source" style="font-weight: bold;">Lead Source:</label>
                <input type="text" name="lead_source" id="lead_source"
                    value="{{ old('lead_source', $lead->lead_source) }}" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="status" style="font-weight: bold;">Status:</label>
                <select name="status" id="status" style="width: 100%; padding: 8px;">
                    @foreach (['New', 'Contacted', 'Converted', 'Lost'] as $status)
                        <option value="{{ $status }}" {{ old('status', $lead->status) == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="assigned_to" style="font-weight: bold;">Assigned To:</label>
                <select name="assigned_to" id="assigned_to" style="width: 100%; padding: 8px;">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ old('assigned_to', $lead->assigned_to) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="remarks" style="font-weight: bold;">Remarks:</label>
                <textarea name="remarks" id="remarks" rows="4" style="width: 100%; padding: 8px;">{{ old('remarks', $lead->remarks) }}</textarea>
            </div>

            <div style="text-align: center;">
                <button type="submit"
                    style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
                    Update Lead
                </button>
            </div>
        </form>
    </div>
@endsection
