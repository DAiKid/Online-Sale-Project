@extends('admin/layout/master')

@section('content')
<div class="container">
    <div class=" d-flex justify-content-between my-2">
        <div class="">
            <a href="{{ route('sale#info') }}" class=" btn btn-outline-primary  rounded shadow-sm">All Order List ({{ Count($order) }})</a>
        </div>
        <div class="">
            <form action="" method="get">

                <div class="input-group">
                    <input type="text" name="searchKey" value="" class=" form-control"
                        placeholder="Enter Search Key...">
                    <button type="submit" class=" btn bg-dark text-white"> <i
                            class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover shadow-sm table-striped">
                <thead class="text-white table-primary">
                    <tr>
                        <th>Date</th>
                        <th>Order Code</th>
                        <th>Customer Name</th>
                        <th>Payment Method</th>
                        <th>Total Price</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($order) != 0)
                        @foreach ($order as $item)
                        <tr>
                            <td class="align-middle">{{ $item['created_at']->format('d-m-Y') }}</td>
                            <td class="align-middle order-code">{{ $item['order_code'] }}</td>
                            <td class="align-middle">{{ $item['name'] !== null ? $item['name'] : $item['nickname'] }}</td>
                            <td class="align-middle col-2">

                                {{ $item['paymentType'] }}

                            </td>
                            <td class="align-middle">
                                {{ $item['totalAmt'] }}
                            </td>
                            <td class="col-2 align-middle">
                                <a href="{{ route('saleDetail#page',$item['order_code']) }}">Sale Detail <i class="fa-solid fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="7">
                            <h5 class="text-muted text-center">There is no Information</h5>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>



        </div>
    </div>
</div>
@endsection
