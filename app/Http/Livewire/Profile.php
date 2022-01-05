<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public User $user;
    public $upload;
    public $password;
    public $password_confirmation;

    public $maxfilesize = 2048; //KB

    // Fixed: expression is not allowed as field default value. // Use fn rules(), instead of $rules
    // Cant use "Rules\Password::defaults()" because it doesnt work.
    protected function rules()
    {
        return [
            'user.username' => ['required', 'string', 'max:32', Rule::unique('users', 'username')->ignore($this->user->id)],
            'user.email' => ['required', 'string', 'email:filter', 'max:255', Rule::unique('users','email')->ignore($this->user->id)],
            'password' => ['sometimes', 'nullable', 'min:8'],
            'password_confirmation' => ['same:password'],
            'upload' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,jpg,png', "max:{$this->maxfilesize}"],
        ];
    }

    //Real-time Validation
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->user = auth()->user();
    }


    public function save()
    {
        $this->validate();

        $data = [];

        if ( !empty($this->password) ) {
            $data['password'] = bcrypt($this->password);
        }

        if ( !empty($this->upload)) {
            $filename = $this->user->id.'-'.$this->user->username.'.'.$this->upload->extension(); //1-admin.jpg
            $data['avatar'] = $this->upload->storeAs('/',$filename,'avatars');
        }

        $this->user->update($data);

        $this->reset('password','password_confirmation');
        $this->dispatchBrowserEvent('pond-reset');
        $this->dispatchBrowserEvent('notify', 'Profile Updated!');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
