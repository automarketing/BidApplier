<?php

namespace App\Http\Controllers\admin;

use Request;
use App\Http\Requests;
use App\Helpers\AllRequests;
use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\State;
use App\Model\City;
use App\Model\Sport;
use App\Model\VendorBankAccounts;
use App\Model\Team;
use App\Model\TournamentGroups;
use App\Model\TournamentGroupTeams;
use App\Model\Facilityprofile;
use App\Model\BankDocuments;
use Auth;
use Illuminate\Support\Facades\DB;
use Response;
use App\Helpers\Helper;
use App\Model\Photo;
use Carbon\Carbon;
use App\Model\UserStatistic;
use App\User;
use App\Model\MatchSchedule;

class BankAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {

		$globalurl=url(); 
		
		
       	$filter = \DataFilter::source(VendorBankAccounts::with('user'));

        $filter->add('user.name','Name','text');
        $filter->add('account_holder_name','Account Holder Name','text');

		
        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();
		$grid = \DataGrid::source($filter);
		$grid->attributes(array("class"=>"table table-striped"));

		$grid->add('user.name','Name');
        $grid->add('<a href="bankaccounts/user/{{ $user_id }}">{{ $account_holder_name }}</a>','Account Holder Name');
        $grid->add('bank_name','Bank Name');
        $grid->add('<a href="bankaccounts/user/{{ $user_id }}">{{ $user->email }}</a>','User Email');
	    $grid->add('varified','Status')->cell( function( $value, $row) {
	        return ['0'=>'Pending','1'=>'Approved','2'=>'Rejected'][$value];
	   	});
        // $grid->edit('editTournament', 'Operation','modify|delete');
        $grid->orderBy('id','desc');		
        // $grid->link('admin/tournaments/create',"New Tournament", "TR");
		$grid->paginate(
        	config('constants.DEFAULT_PAGINATION')
        );
		//Helper::printQueries();
        return  view('admin.bankaccounts.index', compact('filter', 'grid'));
    }
    public function getUser($id)
    {

        $globalurl=url(); 
        
        
        $filter = \DataFilter::source(VendorBankAccounts::with('user')->where('user_id',$id));
        $user = User::where('id',$id)->first();
        $filter->add('account_holder_name','Account Holder Name','text');

        
        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();
        $grid = \DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));

        $grid->add('<a href="/admin/bankaccounts/details/{{ $id }}">{{ $account_holder_name }}</a>','Account Holder Name');
        $grid->add('bank_name','Bank Name');
        $grid->add('varified','Status')->cell( function( $value, $row) {
            return ['0'=>'Pending','1'=>'Approved','2'=>'Rejected'][$value];
        });
        // $grid->edit('editTournament', 'Operation','modify|delete');
        $grid->orderBy('id','desc');        
        // $grid->link('admin/tournaments/create',"New Tournament", "TR");
        $grid->paginate(
            config('constants.DEFAULT_PAGINATION')
        );
        //Helper::printQueries();
        return  view('admin.bankaccounts.user', compact('filter', 'grid','user'));
    }
    public function getDetails($id){
        $bankDetails = VendorBankAccounts::with('user')->where('id',$id)->first();
        $docs= BankDocuments::where('vendor_bank_account_id',$bankDetails->id)->get();
        $img_array=array();


        foreach($docs as $doc) {
            $loc=$doc->location;
            array_push($img_array,$loc);
        }
 
        
        if($bankDetails){
            return  view('admin.bankaccounts.details', compact('bankDetails','img_array'));
        }
    }





    public function postDetails(){

         $id=$_POST['id'];
         $base_url=url();;


       
        $bankDetails = VendorBankAccounts::with('user')->where('id',$id)->first();
         //echo "<pre>"; print_r($base_url); echo "</pre>"; exit;

        if(isset($_POST['verified'])) {
            if($_POST['verified']==2){
                 if($bankDetails->varified!=2){
                    VendorBankAccounts::where('id',$id)->update(['varified'=>$_POST['verified']]);
                    $mail_id=$bankDetails->user->email;
                    $user_id=$bankDetails->user->id;
                    $name=$bankDetails->user->name;
                    $msg="Hi ".$name." <br>Bank details could not be verified for event . Please check details in the message for reject reason.Please <a href='".$base_url."/tournaments'>click here</a> to upload required documents related to bank account. login with the credentials given below:<br>Email: ".$mail_id."<br>Password:<br>Cheers!<br>Regards,";
                         
                    $mail_send=AllRequests::sendemail($mail_id,$user_id,$name,$msg);
                   // print_r($mail_send); exit; 
                    }
            }  else {
             
            VendorBankAccounts::where('id',$id)->update(['varified'=>$_POST['verified']]); 
               }   
        } else {
          VendorBankAccounts::where('id',$id)->update(['varified'=>0]);
        }
         return redirect('admin/bankaccounts/user/'.$_POST['user_id']);
        
           
    }
}
