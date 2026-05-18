@extends('user/layout/master');

@section('content')
    <div class="container-fluid py-5">
        <div class="container py-5 d-flex justify-content-center align-items-center">
            <div class='col-4'>
                <div class="card py-2">
                    <h1 class="text-center pt-3 text-primary">Contact Us</h1>
                    <div class="card-body">
                        <form action="{{ route('contact#create') }}" method="post" class="p-3 rounded">
                            @csrf
                            <div class="my-3">
                                <input type="text" name="title" class="form-control w-100 @error('title') is-invalid @enderror" placeholder="Tilte..." value="{{old('title')}}">

                                @error('title')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="my-3 form-floating">
                                <textarea class="form-control @error('message') is-invalid @enderror" placeholder="Message..." name="message" id="floatingTextarea2" style="height: 100px">{{old('message')}}</textarea>
                                <label for="floatingTextarea2">Message...</label>

                                @error('message')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="">
                                <input type="submit" value="Submit" class="btn btn-primary text-white">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <img src="{{asset('photo/customer-service-sized.jpg')}}" alt="" class="w-100">
            </div>
        </div>
    </div>
@endsection



