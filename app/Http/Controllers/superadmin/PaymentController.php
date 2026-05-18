<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    //direct to paymentPage
    public function paymentPage(){
        $payments = Payment::orderBy('account_name')->get();
        return view('superadmin/payment/page',compact('payments'));
    }

    // delete paymentData
    public function paymentDelete($id){
        // dd($id);
        Payment::where('id',$id)->delete();
        return back();
    }

    // edit paymentData
    public function paymentEditPage($id){
        $payment = Payment::where('id',$id)->first();
        return view('superadmin/payment/editPage',compact('payment'));
    }

    // update paymentData
    public function paymentUpdate(Request $request){
        $this -> checkValidation($request);
        $data = $this -> paymentMethodData ($request);
        $id = $request->paymentId;
        // dd($id,$data);

        Payment::where('id',$id)->update($data);
        Alert::success('Success Title', 'Updated Successfully');
        return to_route('payment#page');
    }

    // payment create
    public function paymentCreate(Request $request){
        $this -> checkValidation($request);
        $data = $this -> paymentMethodData ($request);
        Payment::Create($data);
        Alert::success('Success Title', 'Created Successfully');
        return back();
    }

    // check paymentMethod Validation
    private function checkValidation($request){
        $request -> validate([
            'accountName' => 'required|min:2|max:20',
            'accountNumber' => 'required|min:5|max:1000000',
            'accountType' => 'required|min:2|max:20',
        ]);
    }

    // get paymentMethod data
    private function paymentMethodData ($request){
        return [
            'account_name' => $request->accountName,
            'account_number' => $request->accountNumber,
            'account_type' => $request->accountType,
        ];
    }
}
