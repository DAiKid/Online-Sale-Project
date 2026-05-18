@extends('admin/layout/master');

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Payment Method</h1>
    </div>

    <div class="">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body shadow">
                        <form action="{{ route('payment#create') }}" method="post" class="p-3 rounded">
                            @csrf

                            <div class='my-2'>
                                <input type="text" name="accountName" value="{{ old('accountName') }}" class="form-control @error('accountName') is-invalid @enderror" placeholder="Account Name...">

                                @error('accountName')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class='my-2'>
                                <input type="text" name="accountNumber" value="{{ old('accountNumber') }}" class="form-control @error('accountNumber') is-invalid @enderror" placeholder="Account Number...">

                                @error('accountNumber')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class='my-2'>
                                <input type="text" name="accountType" value="{{ old('accountType') }}" class="form-control @error('accountType') is-invalid @enderror" placeholder="Account Type...">

                                @error('accountType')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>


                            <input type="submit" value="Create" class="btn btn-outline-primary mt-3">
                        </form>
                    </div>
                </div>
            </div>

            <div class="col ">
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Acc Name</th>
                            <th>Acc Number</th>
                            <th>Acc Type</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($payments as $item => $payment)
                            <tr>

                                <td>{{ $item+1 }}</td>
                                <td>{{ $payment -> account_name }}</td>
                                <td>{{ $payment -> account_number }}</td>
                                <td>{{ $payment -> account_type }}</td>
                                <td class='text-center'>
                                    <a href="{{ route('payment#editPage',$payment->id) }}" class="btn btn-sm btn-outline-secondary mx-2">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type='button' onclick="deleteProcess( {{$payment->id}} )" class="btn btn-sm btn-outline-danger" type="button"> <i class="fa-solid fa-trash"></i>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <span class=" d-flex justify-content-end"></span>

            </div>
        </div>
    </div>

</div>
@endsection

@section('js-script')
    <script>
        function deleteProcess($id){
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                    });

                    setInterval(() => {
                        location.href = '/admin/payment/delete/'+$id
                    }, 1000);
                }
            });
        }
    </script>
@endsection
