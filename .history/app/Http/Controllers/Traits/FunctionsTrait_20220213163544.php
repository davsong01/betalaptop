<?php

namespace App\Http\Controllers\Traits;

use App\Emails;
use App\Wallet;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;


trait FunctionsTrait {

    public function uploadImage($image, $location, $width=null, $height=null){
        $imgName = time() . '-' . $image->getClientOriginalName();

        if(!is_null($width) && !is_null($height)){
            $image = Image::make($image)->resize($width, $height);
        }else{
            $image = Image::make($image);
        }
        
        // Check if file exist before saving, to avoid duplicates
        $this->deleteImage($location . '/' . $imgName);

        $image->save($location . '/' . $imgName);
        return $location . '/' . $imgName;
    }

      //Files must be in public and folder name must be appended to the filename for this to work
    public function deleteImage($image){
        // dd($image);
        if (file_exists($image))
        unlink($image);
        return;
    }

     public function sendEmail($name, $recipient, $subject, $content = null, $show_response = null){
        //Prepare data
        $data = [
            'name' => $name,
            'recipient' => $recipient,
            'subject' => $subject,
            'content' => $content,
        ];

        try {
            // Try to send email
            Mail::to($recipient)->send(new NotificationEmail($data));
            $response = 'success';
        } catch(\Exception $e){
            // Log error and store email in database for further processing
            Log::error($e->getMessage());

            Emails::create([
                'subject' => $data['subject'],
                'name' => $data['name'],
                'recipient' => $data['recipient'],
                'content' => $data['content'],
                'errors' => $e->getMessage(),
            ]);

            $response = $e->getMessage();
        }

        if($show_response){
            return $response;
        }else return;

    }

    /**
     * Get user wallet
     *
     * @param int $user_id
     * @param int $amount
     * @return App/Wallet
     */
    public function getWallet($user_id){
        $wallet = Wallet::where('user_id', $user_id)->sum('amount');
        return $wallet;
    }

    /**
     * Top up user wallet
     *
     * @param int $user_id
     * @param int $amount
     * @return App/Wallet
     */
    public function topUpWallet($user_id, $amount){
       $wallet = Wallet::create([
           'user_id' => $user_id,
           'type' => 'topup',
           'amount' => +$amount,
       ]);
       return $wallet;
    }

    /**
     * Withdraw from user wallet
     *
     * @param int $user_id
     * @param int $amount
     * @return App/Wallet
     */
    public function walletWithdraw($user_id, $amount){
        // create wallet with - amount type is withdrawal
        $wallet  = Wallet::create([
            'user_id' => $user_id,
            'type' => 'withdraw',
            'amount' => -$amount
        ]);
        return $wallet;
    }

    /**
     * Transfer from user wallet
     *
     * @param int $sender_id
     * @param int $receiver_id
     * @param int $amount
     * @return void
     */
    public function walletTransfer($sender_id, $receiver_id, $amount){
        $this->walletWithdraw($sender_id, $amount);
        $this->topUpWallet($receiver_id, $amount);
    }

    public function isAdmin(){
        if(auth()->user()->role == 1){
            return 1;
        }else return null;
    }

    public function getLevel($id){
        $level = Matrix::where('user_id', $id)->count();

        return $level;
    }
    // public function saveContactForm($type, $name, $email, $phone, $message ){
    //     EmailContact::create([
    //         'user_id' => $user_id,
    //         'type' => $type,
    //         'name' => $name,
    //         'email' => $email,
    //         'phone' => $phone,
    //         'message' => $message
    //     ]);
    // }
}