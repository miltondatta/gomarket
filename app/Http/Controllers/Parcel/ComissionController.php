<?php

namespace App\Http\Controllers\Parcel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Excel;

class ComissionController extends Controller
{
   
    public function resturantcomission(Request $request)
    {
    	if(Session::has('vendor_parcel'))
          {
              

                 $vendor_email=Session::get('vendor_parcel');
        
                    $vendor=DB::table('vendor')
                    ->where('vendor_email',$vendor_email)
                    ->first();
    	         $orders= DB::table('comission')
                          ->where('vendor_id',$vendor->vendor_id)
                          ->orderBy('order_date', 'desc')
    	 		          ->get();

    	         return view('parcel.oder_incentive.comission',compact("vendor_email","vendor","orders"));
          }
        else
             {
                return redirect()->route('vendorlogin')->withErrors('please login first');
             }


    }
    public function resturantallexcelgenerator(Request $request)
    {

      if(Session::has('vendor_parcel'))
      {
          

             $vendor_email=Session::get('vendor_parcel');
    
                $vendor=DB::table('vendor')
                ->where('vendor_email',$vendor_email)
                ->first();
            $orders= DB::table('comission')
                      ->where('vendor_id',$vendor->vendor_id)->orderBy('order_date', 'desc')
                    ->get();

          $orders_array[] = array('Vendor Name', 'Order Date', 'Total Product Price','Comission Price','Status','CartID','User Name');
          foreach($orders as $data)
          {
           $orders_array[] .= array(
            'Vendor Name'    => $data->vendor_name,
            'Order Date'  => $data->order_date,
            'Total Product Price'   => $data->total_price,
            'Comission Price'   => $data->comission_price,
            'Status'   => $data->status,
            'Cart ID'   => $data->cart_id,
            'User Name'   => $data->user_name
           );
          }
          
            $export_file = new ExportData_Excel();
            $export_file->exportExcel('report', $orders_array, false, 'SALES_REPORT');

         }
    else
         {
            return redirect()->route('vendorlogin')->withErrors('please login first');
         }

    }

    public function resturantsearchcomission(Request $request)
    {

      $this->validate($request,[
         'startdate' => 'required',
         'enddate' => 'required',
     ]);
      $sdate=$request->startdate;
      $edate=$request->enddate;

    	if(Session::has('vendor_parcel'))
          {
                 $vendor_email=Session::get('vendor_parcel');
        
                    $vendor=DB::table('vendor')
                    ->where('vendor_email',$vendor_email)
                    ->first();
                    $vendor_id =  $vendor->vendor_id;
               If($sdate!=null && $edate!=null){
                  $orders = $this->resturantgetSearch($sdate,$edate,$vendor_id);


                   return view('parcel.oder_incentive.comission',compact("vendor_email","vendor","orders"));

               }else{

               $orders= DB::table('comission')
                                 ->where('vendor_id',$vendor->vendor_id);

                 return view('parcel.oder_incentive.comission',compact("vendor_email","vendor","orders"));
               }
            
          }
        else
             {
                return redirect()->route('vendorlogin')->withErrors('please login first');
             }


    }

   public function resturantgetSearch($sdate,$edate,$vendor_id)
   {
      if($sdate!=null && $edate!=null ){
         
      $od = DB::table('comission')->where([['order_date','>=',$sdate],['order_date','<=',$edate]])->where('vendor_id',$vendor_id)->get();
         return $od;
      }
   }

 public function resturantexcelgenerator($startdate,$enddate)
 {
      $vendor_email=Session::get('vendor_parcel');
      $vendor=DB::table('vendor')
      ->where('vendor_email',$vendor_email)
      ->first();

      $ordersdata= DB::table('comission')
      ->where([['order_date','>=',$startdate],['order_date','<=',$enddate]])
      ->where('vendor_id',$vendor->vendor_id)->orderBy('order_date', 'desc')
      ->get();

      $orders_array[] = array( 'Vendor Name', 'Order Date', 'Total Product Price','Comission Price','Status','CartID','User Name');
      foreach($ordersdata as $data)
      {
         $orders_array[] .= array(
         'Vendor Name'    => $data->vendor_name,
         'Order Date'  => $data->order_date,
         'Total Product Price'   => $data->total_price,
         'Comission Price'   => $data->comission_price,
         'Status'   => $data->status,
         'Cart ID'   => $data->cart_id,
         'User Name'   => $data->user_name
         );
      }
      $export_file = new ExportData_Excel();
      $export_file->exportExcel('report', $orders_array, false, 'SALES_REPORT');
 }
 
  public function resturantsendrequest(Request $request)
    {
    	if(Session::has('vendor_parcel'))
          {
            $vendor_email=Session::get('vendor_parcel');
            $com_id = $request->com_id;

    	      $orders= DB::table('comission')
                          ->where('com_id',$com_id)
                          ->update([
                                     'status'=>1,
                                     ]);
    	 	return redirect()->back()->withErrors('Request Send to Admin');

    	         return view('parcel.oder_incentive.comission',compact("vendor_email","orders"));
          }
        else
             {
                return redirect()->route('vendorlogin')->withErrors('please login first');
             }


    }
}

