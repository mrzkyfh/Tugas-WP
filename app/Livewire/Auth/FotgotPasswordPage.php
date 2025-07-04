<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;
use Symfony\Contracts\Service\Attribute\Required;

#[Title('Forgot password')]

class FotgotPasswordPage extends Component {


    public $email;

    public function save(){
        $this->validate([
            'email' => 'required|email|exists:users,email|max:255'
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if($status === Password::RESET_LINK_SENT){
            session()->flash('success', 'Password reset link has been sent to your email');
            $this->email = '';
        }
    }

    public function render()
    {
        return view('livewire.auth.fotgot-password-page');
    }
}
