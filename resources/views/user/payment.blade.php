@extends('user/layout/master');

@section('content')
<div class="container " style="margin-top: 150px">
    <div class="row">
        <div class="card col-12 shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <h5 class="mb-4">Payment methods</h5>

                        @foreach ($payment as $item)
                        <div class="">
                            <b>{{ $item->account_type }}</b> ( Name : {{$item->account_name}})
                        </div>
                            <span>Account No : {{ $item->account_number}}</span>
                        <hr>
                        @endforeach


                    </div>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                Payment Info
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <form action="{{route('payment#order')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mt-4">
                                            <div class="col">
                                                <input type="text" name="name" id="" value="{{Auth::user()->name !== null ? Auth::user()->name : Auth::user()->nickname}}" class="form-control @error('name') is-invalid @enderror" placeholder="User Name...">
                                                @error('name')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <input type="text" name="phone" id="" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror" placeholder="09xxxxxxxx">
                                                @error('phone')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <textarea name="address" id="" cols="30" rows="10" class="form-control @error('phone') is-invalid @enderror" placeholder="Address...">{{ old('address') }}</textarea>
                                            @error('address')
                                                <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col">
                                                <select name="paymentType" id="" class="@error('paymentType') is-invalid @enderror form-select ">
                                                    <option value="">Choose Payment methods...</option>
                                                    @foreach ($payment as $item)
                                                        <option value="{{$item->account_type}}" @if($item->account_type == old('paymentType')) selected @endif>{{ $item->account_type }}</option>
                                                    @endforeach
                                                </select>
                                                @error('name')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <input type="file" name="payslipImage" id="" accept="image/*" class="form-control @error('payslipImage') is-invalid @enderror">
                                                @error('payslipImage')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col">
                                                <input type="hidden" name="orderCode" value="{{ $orderTemp[0]['order_code'] }}">
                                                Order Code : <span class="text-secondary fw-bold">{{ $orderTemp[0]['order_code'] }}</span>
                                            </div>
                                            <div class="col">
                                                <input type="hidden" name="totalAmount" value="{{ $orderTemp[0]['total_cost'] }}">
                                                Total amt : <span class=" fw-bold"> {{ $orderTemp[0]['total_cost'] }}mmk</span>
                                            </div>
                                        </div>

                                        <div class="row mt-4 mx-2">
                                            <button type="submit" class="btn btn-outline-success w-100">
                                                <i class="fa-solid fa-cart-shopping me-3"></i> Order Now...
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


