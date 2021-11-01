<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Jobs\PostDataToApi;

class MpesaOnlineRequest extends Component
{
    public $amount;
    public $phone_number;

    protected $rules = [
        'amount' => 'required|max:10',
        'phone_number' => 'required|max:20'
    ];
    public function submit()
    {
        $validatedData = $this->validate();

        //Dispatch data to queue
        PostDataToApi::dispatch((object) $validatedData);

        $this->successMessage = 'Payment Initiated Successfully.';
        $this->clearForm();
    }

    public function clearForm(){
        $this->amount = '';
        $this->phone_number = '';
    }
    public function render()
    {
        return view('livewire.mpesa-online-request');
    }
}
