@extends('admin/layout/master')

@section('content')
<div class="container">
    <div class=" d-flex justify-content-between my-2">
        <div class="">
            <a href="{{ route('orderList#page') }}" class=" btn btn-outline-primary  rounded shadow-sm">All Order List</a>
            <a href="{{ route('orderList#page','Pending') }}" class=" btn btn-outline-warning  rounded shadow-sm">Pending</a>
            <a href="{{ route('orderList#page','Reject') }}" class=" btn btn-outline-danger  rounded shadow-sm">Reject</a>
        </div>
        <div class="">
            <form action="" method="get">

                <div class="input-group">
                    <input type="text" name="searchKey" value="" class=" form-control"
                        placeholder="Enter Order Code...">
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
                        <th>No.</th>
                        <th>Date</th>
                        <th>Order Code</th>
                        <th>Customer Name</th>
                        <th>Order Status</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($orders) != 0)

                        @foreach ($orders as $order => $item)
                        <tr>
                            <td class="align-middle">{{ $order + 1 }}</td>
                            <td class="align-middle">{{ $item['created_at']->format('d-m-Y') }}</td>
                            <td class="align-middle order-code">{{ $item['order_code'] }}</td>
                            <td class="align-middle">{{ $item['name'] !== null ? $item['name'] : $item['nickname'] }}</td>
                            <td class="align-middle col-2">

                                <select class="form-select change-status">
                                    <option value="0" @if($item['status'] === 0) selected @endif  class="text-warning">Pending</option>



                                    @if ($item['count'] <= $item['stock'])
                                    <option value="1" @if($item['status'] === 1) selected @endif class="text-success">Accept</option>
                                    @endif



                                    <option value="2" @if($item['status'] === 2) selected @endif class="text-danger">Reject</option>
                                </select>

                            </td>
                            <td class="align-middle">
                                @if ($item['status'] === 0)
                                    <i class="fa-solid fa-spinner text-warning"></i>
                                @elseif ($item['status'] === 1)
                                    <i class="fa-solid fa-check text-success"></i>
                                @else
                                    <i class="fa-solid fa-xmark text-danger"></i>
                                @endif
                            </td>
                            <td class="col-2 align-middle">
                                <a href="{{ route('orderDetail#page',$item['order_code']) }}">Order Detail <i class="fa-solid fa-arrow-right"></i></a>
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

@section('js-script')
<script>
    $(document).ready(function(){
        $('.change-status').change(function(){
            let status = $(this).val();
            let orderCode = $(this).parents('tr').find('.order-code').text();
            let statusData = {
                'status' : status,
                'orderCode' : orderCode
            };

            $.ajax({
                type : 'get',
                url : '/admin/order/status/change',
                data : statusData,
                dataType : 'json',
                success : function(res){
                    res.status === 'success' ? location.reload() : '';
                    // console.log('pass');
                },
                error : function(res){

                    // console.log('error');
                },
            })
            // console.log(statusData);
        })



    })
</script>

@endsection
