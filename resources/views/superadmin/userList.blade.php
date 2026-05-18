@extends('admin/layout/master');

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div>
                <a href="{{ route('adminList#page') }}"> <button class=" btn btn-sm btn-secondary mx-2"> Admin
                        List</button></a>

                @if (request('searchKey'))
                    <a href="{{ route('userList#page') }}"> <button class=" btn btn-sm btn-danger mx-2">Back</button></a>
                @endif


            </div>



            <div class="">

                <form action="" method="get">

                    <div class="input-group">
                        <input type="text" name="searchKey" value="" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No.</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Created Date</th>
                            <th>Platform</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($users as $item => $user)
                            <tr class="">
                                <td class="align-middle">{{ $item + 1 }}</td>
                                <td>
                                    <img src="{{ $user->profile === null ? asset('default/defaultProfile.jpg') : asset('profilePhoto/' . $user->profile) }}"
                                        alt="" class=" img-thumbnail rounded shadow-sm w-50">
                                </td>
                                <td class="align-middle">{{ $user->name != null ? $user->name : $user->nickname }}</td>
                                <td class="align-middle">{{ $user->email }}</td>
                                <td class="align-middle">{!! $user->address === null ? "<span class='text-muted'>Not avaliable</span>" : $user->address !!}</td>
                                <td class="align-middle">{!! $user->phone === null ? "<span class='text-muted'>Not avaliable</span>" : $user->phone !!}</td>
                                <td class="align-middle">
                                    <span
                                        class="btn btn-sm bg-danger text-white rounded shadow-sm">{{ $user->role }}</span>
                                </td>
                                <td class="align-middle">{{ $user->created_at->format('d-m-Y') }}</td>
                                <td class="align-middle">{{ $user->provider }}</td>
                                <td class="align-middle">

                                    <button class="btn btn-sm btn-outline-danger" type="button" onclick="deleteProcess( {{ $user->id }} )"><i class="fa-solid fa-trash"></i></button>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <span class=" d-flex justify-content-end">{{ $users->links() }}</span>

            </div>
        </div>
    </div>
@endsection

@section('js-script')
    <script>
        function deleteProcess($id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                    setInterval(() => {
                        location.href = '/admin/profile/userList/delete/' + $id
                    }, 1000);

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Your imaginary file is safe :)",
                        icon: "error"
                    });
                }

            });
        }
    </script>
@endsection
