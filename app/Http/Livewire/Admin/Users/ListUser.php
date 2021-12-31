<?php

namespace App\Http\Livewire\Admin\Users;
use App\Models\User;
// For Make Viladion
use Illuminate\Support\Facades\Validator;
use Image;
use File;
use  App\Http\Livewire\Admin\AdminComponent;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class ListUser extends AdminComponent
{
    use  WithFileUploads;
    public $showEditModal = false;
    public $ArrayForUserInputFieldValue =[];
    public $user;
    public $userId;
    public $photo;
    public $searchUser = null;

    public $randomForm = null;


    public function cancle()
    {
        //  dd("here");
    }

    // Open add user modal
    public function openAddUserModal()
    {    
       Session::forget('formId');
       Session::forget('fileExtention');
      // Reset form when form modal is open
      $this->reset();

      $this->ArrayForUserInputFieldValue['formId'] = time(). mt_rand(1,1000);

     
      Session::put('formId', $this->ArrayForUserInputFieldValue['formId']);
      
      // Create browser event
       $this->dispatchBrowserEvent('Add_Edit_UserModalOpen',$this->randomForm);
    }


    
    public function createUser(Request $request)
    {
      $formId = Session::get('formId');
      $sessionFileName = Session::get('fileName');
      $sessionExtention = Session::get('fileExtention');

      $validatedData = Validator::make($this->ArrayForUserInputFieldValue,[
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed',
      ])->validate();
      $validatedData['password'] = password_hash($validatedData['password'], PASSWORD_DEFAULT);


      if($sessionExtention){

        $old_image_path = public_path("storage/avatars/tmp/$formId");

        File::move(public_path("storage/avatars/tmp/$formId/$sessionFileName"), public_path("storage/avatars/".$this->ArrayForUserInputFieldValue['email'].".".$sessionExtention));

        $validatedData['avatar'] = $this->ArrayForUserInputFieldValue['email'].".".$sessionExtention;

        File::deleteDirectory($old_image_path);
      }

      #<---=== create custom file mame ===----->
      $imageName = $this->ArrayForUserInputFieldValue['name'].'.'.$this->photo->extension();
      #<---=== check file already exist or not ===----->
      $old_image_path = public_path("storage/avatars/$imageName");
      
      #<---=== If exist, delete this file ===----->
      if(File::exists($old_image_path)) {
          File::delete($old_image_path);
      }
      #<---=== Move new file inside your specific folder ===----->
      // this file store storage/public/avatars/
      $path = $this->photo->storeAs(
        'public/avatars', $imageName
      );
      $validatedData['avatar'] = $imageName;
      

      User::create($validatedData);
      $this->reset();
      
      // Modal close when form is submitted
      $this->dispatchBrowserEvent('Add_Edit_UserModalClose',['message'=>'User added successfully']);
       

    }

    public function showDeleteUserModal($id)
    {
      # code...
      $this->userId = $id;
      $this->dispatchBrowserEvent('openConfirmDeleteModel');
    }

    public function confirmUserDelete()
    {
      # code...
      $user = User::findOrFail($this->userId);
      $user->delete();
      // $this->dispatchBrowserEvent('showDeleteUserModal');
      $this->dispatchBrowserEvent('hideDeleteUserModal',['message'=>'User Deleted successfully']);
    }

    public function showEditUserModal( User $user)
    {
      # code...
      // Reset Form
      $this->reset();
      // To show edit modal, make this true
      $this->showEditModal = true;
      // put $user perimeter inside user variable
      $this->user = $user;
      // make user variable as a array and put it inside ArrayForUserInputFieldValue array.Thats whay we see all input field with value.Because this array is asociated with input field.
      $this->ArrayForUserInputFieldValue = $user->toArray();
      //Open Edit_Add user modal
      $this->dispatchBrowserEvent('Add_Edit_UserModalOpen');
      
    }

    public function Edit_And_UpdateUser(){

      $validatedData = Validator::make($this->ArrayForUserInputFieldValue,[
        'name' => 'required',
        'email' => 'required|email|unique:users,email,'.$this->user->id,
        'password' => 'sometimes|confirmed'
      ])->validate();
        
      if(!empty($validatedData['password'])){
        $validatedData['password'] = bcrypt( $validatedData['password']);
      }

        $this->user->update($validatedData);

        $this->dispatchBrowserEvent('Add_Edit_UserModalClose',['message'=>'User Updated successfully']);
    }


    public function render()
    {       
    
      $users = User::query()
      ->where('name','like','%'.$this->searchUser.'%')
      ->where('email','like','%'.$this->searchUser.'%')
      ->latest()->paginate(4);
      // dd($users);

      return view('livewire.admin.users.list-user',[
        'users' => $users,
      ]);
    }
}
