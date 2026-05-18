@extends('admin/layout/master');

@section('content')
<div class="col-6 offset-3">
    <div class="card">
        <div class="card-body shadow">
            <form action="{{ route('payment#update') }}" method="post" class="p-3 rounded">
                @csrf
                    <input type="hidden" name="paymentId" value="{{ $payment->id }}">
                    <div class='my-2'>
                        <input type="text" name="accountName" value="{{ old('accountName',$payment->account_name) }}" class="form-control @error('accountName') is-invalid @enderror" placeholder="Account Name...">

                        @error('accountName')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class='my-2'>
                        <input type="text" name="accountNumber" value="{{ old('accountNumber',$payment->account_number) }}" class="form-control @error('accountNumber') is-invalid @enderror" placeholder="Account Number...">

                        @error('accountNumber')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class='my-2'>
                        <input type="text" name="accountType" value="{{ old('accountType',$payment->account_type) }}" class="form-control @error('accountType') is-invalid @enderror" placeholder="Account Type...">

                        @error('accountType')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="">
                        <input type="submit" value="Create" class="btn btn-outline-primary mt-3">
                        <a href="{{ route('payment#page') }}" class="btn btn-secondary shadow-sm mt-3 ml-3">Back</a>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection
