@extends('user/layout/master');

@section('content')
<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow col py-5 mt-5">

        <form action="{{route('profile#edit')}}" method="post" enctype="multipart/form-data">

            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <img class="img-profile img-thumbnail" id="output" src="{{ Auth::user()->profile === null ? asset('default/defaultProfile.jpg') : asset('/profilePhoto/' . Auth::user()->profile) }}" accept="image/*">
                        <input type="file" name="image" id="" class="form-control mt-1 " onchange="loadPhoto(event)">
                    </div>
                    <div class="col">

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name..." value="{{old('name', Auth::user()->name !== null ? Auth::user()->name : Auth::user()->nickname)}}">

                                    @error('name')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label"> Email</label>
                                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email',Auth::user()->email)}}"  placeholder="Email...">

                                    @error('email')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        Phone</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old('email',Auth::user()->phone)}}"
                                        placeholder="09xxxxxx">

                                    @error('phone')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        Address</label>
                                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{old('email',Auth::user()->address)}}"
                                        placeholder="Address">

                                    @error('address')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <input type="submit" value="Update" class="btn btn-primary mt-3">
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
