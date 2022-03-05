<?php

namespace App\Http\Controllers\Traits;

use App\Emails;
use App\Matrix;
use App\Wallet;
use App\Mail\NotificationEmail;
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
     * @return int
     */
    public function getWallet($user_id){
        $wallet = Wallet::where('user_id', $user_id)->sum('amount');
        return $wallet;
    }

    /**
     * Get user wallet
     *
     * @param int $user_id
     * @param int $amount
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getWalletHistory($user_id){
        $wallets = Wallet::where('user_id', $user_id)->orderBy('id', 'DESC')->get();
        return $wallets;
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
     * @return boolean|App/Wallet
     */
    public function walletWithdraw($user_id, $amount, $receiver_id = null){
        if($this->getWallet($user_id) - $amount >= 0 ){
            // create wallet with - amount type is withdrawal
            $wallet  = Wallet::create([
                'user_id' => $user_id,
                'type' => 'withdraw',
                'amount' => -$amount,
                'recipient_id' => $receiver_id ? $receiver_id : null
            ]);
            return $wallet;
        }
        return false;
    }

    /**
     * Transfer from user wallet
     *
     * @param int $sender_id
     * @param int $receiver_id
     * @param int $amount
     * @return boolean true on success otherwise false
     */
    public function walletTransfer($sender_id, $receiver_id, $amount){
        if($this->walletWithdraw($sender_id, $amount, $receiver_id)){
            $this->topUpWallet($receiver_id, $amount);
            return true;
        }
        return false;
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

    /***
     * Function to get the position of any user in relation to its parent
     *
     * @param child id, parent id
     * @response position in matrix of parent
     */
    public function getPosition($child, $parent){
        $position = NULL;
        // Search through all matrices for the parent
        $parentMatrix = Matrix::whereUserId($parent)->get();
        if($parentMatrix){
             // Search through all left matrices for parent
            foreach($parentMatrix as $matrix){
                $left = json_decode($matrix->left, true);
                $search = array_search($child, $left);
                if($search){
                $position = 'Level '.$matrix->position. ', left '.$search;
                }
            }

            foreach($parentMatrix as $matrix){
                $right = json_decode($matrix->right, true);
                $search = array_search($child, $right);
                if($search){
                $position = 'Level '.$matrix->position. ', right '.$search;
                }
            }

            return $position;
        }

        // Search through all Right matrices for parent
        //  dd($parentMatrix, $parent);
    }

    public function getOpenPositions($id){
        // Get level

    }

    public function getFixedPositions($id){

    }

    public function getUpline($node, $parent){

        $levelPosition = explode (",", $node);
     
        $level = (int) substr($levelPosition[0], -1);
        $side = (int) substr($levelPosition[1], -1);
     
        $upperLevel = $level - 1;
        $upperLevelDetails = Matrix::whereUserId($parent)->wherePosition($upperLevel)->first();
        
        // If right
        if (str_contains($levelPosition[1], 'right')) {
               // Check through
            $upline = $this->getUplineIndex($upperLevelDetails->right, $upperLevel, $level, $side, 'right');
        }

        // If left
        if (str_contains($levelPosition[1], 'left')) {
            $upline = $this->getUplineIndex($upperLevelDetails->left, $upperLevel, $level, $side, 'left');

        }

        return $upline;
    }
    
    public function getIndex($details, $needle){
        foreach($details as $index=>$value){
             dd($value, $index, $needle);
            if($value === $needle){
               
                return $index;
            }
        }
    }

    public function getUplineIndex($potential, $upperLevel,$level, $side, $hand){
        $potential = json_decode($potential, true);
        $index = 0;
        $realIndex = [];
        switch ($upperLevel) {
            case 2:
                if($this->nBetween($side, 2, 1)){
                    $index = 1;
                }

                if($this->nBetween($side, 4, 3)){
                    $index = 2;
                }
              
                break;

            case 3:
                if($this->nBetween($side, 2, 1)){
                    $index = 1;
                }

                if($this->nBetween($side, 4, 3)){
                    $index = 2;
                }

                if($this->nBetween($side, 6, 5)){
                    $index = 3;
                }

                if($this->nBetween($side, 8, 7)){
                    $index = 4;
                }

                break;

            case 4:
                if($this->nBetween($side, 2, 1)){
                    $index = 1;
                }

                if($this->nBetween($side, 4, 3)){
                    $index = 2;
                }

                if($this->nBetween($side, 6, 5)){
                    $index = 3;
                }

                if($this->nBetween($side, 8, 7)){
                    $index = 4;
                }

                if($this->nBetween($side, 10, 9)){
                    $index = 5;
                }

                if($this->nBetween($side, 12, 11)){
                    $index = 6;
                }

                if($this->nBetween($side, 14, 13)){
                    $index = 7;
                }

                if($this->nBetween($side, 16, 15)){
                    $index = 8;
                }

                break;
                
            default:

                break;
        }

        foreach($potential as $key=>$value){
            if($key === $index){
                // dd($key, $value);
                $realIndex['level'] = $upperLevel;
                $realIndex['side'] = $hand;
                $realIndex['index'] = $key;
                $realIndex['id'] = $value;
            }
        }
        
        return $realIndex;
        // Get index and value from potential
    }

    public function nBetween($varToCheck, $high, $low) {
        if($varToCheck < $low) return false;
        if($varToCheck > $high) return false;
        return true;
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