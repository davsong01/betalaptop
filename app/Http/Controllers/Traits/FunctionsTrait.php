<?php

namespace App\Http\Controllers\Traits;

use App\User;
use App\Emails;
use App\Matrix;
use App\Wallet;
use Illuminate\Support\Str;
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

     public function sendEmail($name, $recipient, $subject, $content){
        
        try {
            // Try to send email
            Emails::create([
                'subject' => $subject,
                'name' => $name,
                'recipient' => $recipient,
                'content' => $content,
                'status' => 'Pending',
            ]);
        } catch(\Exception $e){
            // Log error and store email in database for further processing
            // dd($e->getMessage());
            \Log::error($e->getMessage());
        }
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
    public function topUpWallet($user_id, $amount, $transaction_id = null){
    $transaction_id = !is_null($transaction_id) ? $transaction_id : substr(sha1(time()), 0, 25); 
       $wallet = Wallet::create([
           'user_id' => $user_id,
           'type' => 'topup',
           'amount' => +$amount,
           'transaction_id' => $transaction_id
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
    public function walletWithdraw($user_id, $amount, $receiver_id = null, $transaction_id = null){
        $transaction_id = !is_null($transaction_id) ? $transaction_id : substr(sha1(time()), 0, 25); 
        if($this->getWallet($user_id) - $amount >= 0 ){
            // create wallet with - amount type is withdrawal
            $wallet  = Wallet::create([
                'user_id' => $user_id,
                'type' => 'withdraw',
                'amount' => -$amount,
                'recipient_id' => $receiver_id ? $receiver_id : null,
                'transaction_id' => $transaction_id
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
        $transaction_id = substr(sha1(time()), 0, 25); 
        if($this->walletWithdraw($sender_id, $amount, $receiver_id, $transaction_id)){
            $this->topUpWallet($receiver_id, $amount, $transaction_id);
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

    }

    public function getOpenPositions($id, $level){
        // Get level
        $matrices = Matrix::whereUserId($id)->wherePosition($level)->first();
        $availablePos = [];
        if(!is_null($matrices)){
            // Loop through level to see open positions
            foreach(json_decode($matrices->left, true) as $key=>$matrix){
                if($matrix == 0){
                    $availablePos[] = 'Level ' . $level . ', Left ' . $key;
                }
            }

            foreach(json_decode($matrices->right, true) as $key=>$matrix){
                if($matrix == 0){
                    $availablePos[] = 'Level ' . $level . ', Right ' . $key;
                }
            }
        }
      
        return $availablePos;
    }

    public function getFixedPositions($id){

    }

    public function getUpline($node, $parent){
        $levelPosition = explode (",", $node);
        
        $level = (int) substr($levelPosition[0], -1);
        $side = (int) substr($levelPosition[1], -1);
        
        $upperLevel = $level - 1;

        $upperLevelDetails = Matrix::whereUserId($parent)->wherePosition($upperLevel)->first();
        if(is_null($upperLevelDetails)){
            $upline = [
                "level" => 1,
                "side" => "right",
                "index" => 1,
                "id" => auth()->user()->id,
            ];
            
            return $upline;
        }
        // If right
        if (str_contains($levelPosition[1], 'right') || str_contains($levelPosition[1], 'Right')) {
            // Check through
            $upline = $this->getUplineIndex($upperLevelDetails->right, $upperLevel, $level, $side, 'right');
        }

        // If left
        if (str_contains($levelPosition[1], 'left') || str_contains($levelPosition[1], 'Left')) {
            $upline = $this->getUplineIndex($upperLevelDetails->left, $upperLevel, $level, $side, 'left');
        }
        
        return $upline;
    }

    public function getDownlines(){
        $downlines = [];
        foreach($this->getDownlinesWithPosition(auth()->user()->id) as $downline){
            foreach($downline->details as $details){
                    $downlines[] = $details;
            }
        }
        return $downlines;
    }
    public function getDownlinesWithPosition($id){
        $downlines = Matrix::whereUserId($id)->get();   
               
        $downlines->map(function($downlines){
            $details = [];
            foreach(json_decode($downlines->left) as $key=>$left){
               if($left != 0){
                    $user = User::findOrFail($left);
                    array_push($details, [
                        'avatar'=>$user->avatar,
                        'id'=>$user->id,
                        'wallet'=>$user->wallet(),
                        'level'=>$user->level(),
                        'name'=>$user->name,
                        'username'=>$user->username,
                        'email'=>$user->email,
                        'index' => 'Level '. $downlines['position'] .', '.'Left ' . $key,
                    ]);
               }
            }
            foreach(json_decode($downlines->right) as $key=>$right){
               if($right != 0){
                   $user = User::findOrFail($right);
                    array_push($details, [
                        'avatar'=>$user->avatar,
                        'id'=>$user->id,
                        'wallet'=>$user->wallet(),
                        'level'=>$user->level(),
                        'name'=>$user->name,
                        'username'=>$user->username,
                        'email'=>$user->email,
                        'index' => 'Level '. $downlines['position'] .', '.'Right ' . $key,
                    ]);
               }
            }
            $downlines['details'] = $details;
        });
 
        return $downlines;
    }
    /**
     * Get all the users upline for user
     * the user id for each instance is used as the key
     *
     * @param int $id user id of user to look for uplines
     * @param array $arr array of passed users from recursion
     *
     * @return Collection
     */
    public function getUplines($id, $arr = [])
    {
        $user = User::find($id);
        if ($user && $user->nextUpline) {
            array_push($arr, $user);
            return $this->getUplines($user->nextUpline->id, $arr);
        } else if($user){
            array_push($arr, $user);
        }
        return collect($arr)->keyBy(function ($item, $key) {
            return $item->id;
        });
    }

    public function updateAllUplines($user, $index){
        dd($user, $index);
    }

    public function getIndex($details, $needle){
        foreach($details as $index=>$value){
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
             case 1:
                    $index = 1;
                break;

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

    public function createNextLevel($user){
       
        $level = $user->level();
         // Check if current level is filled before creating another level
        $open = $this->getOpenPositions($user->id, $level);
        if(isset($open) && !empty($open)){
            return;
        }
        
        $nextLevel = $level + 1;
        $length = 0;

        switch($nextLevel){
            case 1: $length = 1;
                break;
            case 2: $length = 2;
                break;
            case 3: $length = 4;
                break;
            case 4: $length = 8;
                break;
            case 5: $length = 16;
                break;

        }
    
        $array = [1 => 0];

        for($i = 2; $i <= $length; $i++){
            array_push($array, 0);
        }
        
        // dd(json_encode($array));
        $matrix = Matrix::create([
            'user_id' => $user->id,
            'position' => $nextLevel,
            'left' => json_encode($array),
            'right' => json_encode($array),
        ]);
        
    }

    public function createUplineNextLevel($id){
        $user = User::findorFail($id);
        $level = $user->level();
         // Check if current level is filled before creating another level
        $open = $this->getOpenPositions($user->id, $level);
        
        if(isset($open) && !empty($open)){
            return;
        }
        
        $nextLevel = $level + 1;
        $length = 0;

        switch($nextLevel){
            case 1: $length = 1;
                break;
            case 2: $length = 2;
                break;
            case 3: $length = 4;
                break;
            case 4: $length = 8;
                break;
            case 5: $length = 16;
                break;

        }
    
        $array = [1 => 0];

        for($i = 2; $i <= $length; $i++){
            array_push($array, 0);
        }

        $matrix = Matrix::create([
            'user_id' => $user->id,
            'position' => $nextLevel,
            'left' => json_encode($array),
            'right' => json_encode($array),
        ]);
    
    }

    public function updateMatrix($user, $index, $downline){
        $userMatrix = Matrix::whereUserId($user->id)->wherePosition($user->level())->first();
       
        $levelPosition = explode (",", $index);
        
        $level = (int) substr($levelPosition[0], -1);       
        $side = (int) substr($levelPosition[1], -1);

        // If right
        if (str_contains($levelPosition[1], 'right') || str_contains($levelPosition[1], 'Right')) {
            // Check through
            $right = json_decode($userMatrix->right, true);
            foreach($right as $pos=>$value){
                if($value == 0 && $pos == $side){
                    $right[$pos] = $downline;
                }
            }

            $userMatrix->right = json_encode($right);
            $userMatrix->save();
        }

        // If left
        if (str_contains($levelPosition[1], ' left') || str_contains($levelPosition[1], ' Left')) {
            // Check through
            $left = json_decode($userMatrix->left, true);
  
            foreach($left as $pos=>$value){
                if($value == 0 && $pos == $side){
                    $left[$pos] = $downline;
                }
            }

            $userMatrix->left = json_encode($left);
            $userMatrix->save();
        }
        
    }

    public function updateUplineMatrix($user, $index, $downline){
        
        $directUplineMatrix = Matrix::whereUserId($user)->latest()->first();
        
        if(!isset($directUplineMatrix)){
            return;
        }
        // Update direct Upline with the user->upline
        // Maybe create new position here
        $parentMatrix = Matrix::whereUserId(auth()->user()->id)->latest()->first();
        
        $levelPosition = explode (",", $index);
       
        $requestSide = $this->getSideFromRequest($levelPosition);
        $requestLevel = $this->getLevelFromRequest($levelPosition);
        $requestIndex = $this->getIndexFromRequest($levelPosition);
        
        $thisUserLevel = $directUplineMatrix->position;
        
        $this->getSpace($user, $thisUserLevel, $requestLevel, $downline, $parentMatrix, $requestSide, $requestIndex, $directUplineMatrix);

        return;
        // dd($space);
        // // If right
        // if ($position['side'] == 'Right') {
        //     // Check through
        //     $right = json_decode($userMatrix->right, true);
        //     foreach($right as $pos=>$value){
        //         if($pos == $position['pos'] && $value == 0){
        //             $right[$pos] = $downline;
        //         }
        //     }
        //    $directUplineMatrix->right = json_encode($right);
        //    $directUplineMatrix->save();
        // }
        
        // // If left
        // if ($position['side'] == 'Left') {
        //     // Check through
        //     $left = json_decode($userMatrix->left, true);
        //     foreach($left as $pos=>$value){
        //         if($pos == $position['pos'] && $value == 0){
        //             $left[$pos] = $downline;
        //         }
        //     }
        //    $directUplineMatrix->left = json_encode($left);
        //    $directUplineMatrix->save();
        // }
       
    }

    public function getSideFromRequest($index){
        $leftOrRight = Str::lower($index[1]);

        if (str_contains($leftOrRight, 'left')){
            $side = 'left';
        }

        if (str_contains($leftOrRight, 'right')){
            $side = 'right';
        }

        return $side;
    }

    public function getLevelFromRequest($index){
        $position = (int) substr($index[0], -1);
        return $position;
    }

    public function getIndexFromRequest($index){
        $leftOrRight = $index[1];
        $index = (int) substr($index[1], -1);
        return $index;
    }

    public function getSpace($user, $thisUserLevel, $requestLevel, $downline, $parentMatrix, $requestSide, $requestIndex, $directUplineMatrix){  
      
        // Problem is we need to know which leg and index to put the incoming downline in this particular upline matrix, we call it space
        // dd($directUplineMatrix->user_id);
        $index = $this->getPositionInParentMatrix( $parentMatrix->user_id, $user); // Child, Parent
        
        $sideToUpdate =  $this->resolveRequestIndex($requestIndex);
        
        // if request index == 3 
        // if 
        // Default index
        // $space = [
        //     'side' => NULL,
        //     'pos' => NULL,
        // ];
        // dd($thisUserLevel, $requestLevel, $downline, $parentMatrix, $requestSide, $requestIndex, $directUplineMatrix);
        switch ($requestLevel) {
            case 2:
                $this->updateUpline($directUplineMatrix, $sideToUpdate, $downline, $requestIndex);
                break;
            case 3:

                if($this->nBetween($requestIndex, 2, 1)  && $index['level'] == $requestLevel - 1){
                    $this->updateUpline($directUplineMatrix, $sideToUpdate, $downline);
                }else{
                   $this->updateOtherUpline($directUplineMatrix, $requestSide, $downline, $requestIndex);
                }
                
        
        
                if($this->nBetween($requestIndex, 4, 3) && $index['level'] == $requestLevel - 1 && $index['position'] == 2){
                    $sideToUpdate =  $this->resolveRequestIndex($requestIndex);
                    $this->updateUpline($directUplineMatrix, $sideToUpdate,$downline);
                }

                if($this->nBetween($requestIndex, 6, 5) && $index['level'] == $requestLevel - 1 && $index['position'] == 3){
                    $sideToUpdate =  $this->resolveRequestIndex($requestIndex);
                    $this->updateUpline($directUplineMatrix, $sideToUpdate,$downline);
                }

                if($this->nBetween($requestIndex, 8, 7) && $index['level'] == $requestLevel - 1 && $index['position'] == 4){
                    $sideToUpdate =  $this->resolveRequestIndex($requestIndex);
                    $this->updateUpline($directUplineMatrix, $sideToUpdate,$downline);
                }

                break;
            default:
                # code...
                break;
        }
       
    }
    
    private function resolveRequestIndex($requestIndex){
        if($requestIndex % 2 == 1){
            $side = 'left';
        }else $side = 'right';

        return $side;
    }

    private function updateUpline($directUplineMatrix, $sideToUpdate, $downline, $requestIndex = NULL){
        $toUpdate = json_decode($directUplineMatrix->$sideToUpdate, true);
            foreach($toUpdate as $up=>$value){
                if($directUplineMatrix->position == $up && $value == 0){
                    $toUpdate[$up] = $downline;
                }
               
                $directUplineMatrix->$sideToUpdate = json_encode($toUpdate);
                $directUplineMatrix->save();
            }
    }

    private function updateOtherUpline($directUplineMatrix, $sideToUpdate, $downline, $requestIndex){
       
        $toUpdate = json_decode($directUplineMatrix->$sideToUpdate, true);
            foreach($toUpdate as $up=>$value){
                if($requestIndex == $up && $value == 0){
                    $toUpdate[$up] = $downline;
                }
                $directUplineMatrix->$sideToUpdate = json_encode($toUpdate);
                $directUplineMatrix->save();
            }


    }

    public function getPositionInParentMatrix( $parent, $child){
        $position = [
            'id' => NULL,
            'level' => NULL,
            'position' => NULL,
            'left' => NULL,
            'parent' => NULL
        ];
        // Loop through all parent instances to get
     
        $parentMatrix = Matrix::whereUserId($parent)->get();
      
        if($parentMatrix){
             // Search through all left matrices for parent
            foreach($parentMatrix as $matrix){
                $left = json_decode($matrix->left, true);
                $search = array_search($child, $left);
                if($search){
                    $position = [
                        'child' => $child,
                        'level' => $matrix->position,
                        'position' => $search,
                        'side' => 'left',
                        'parent' => $matrix,
                    ];
                }
                
            }

            foreach($parentMatrix as $matrix){
                $right = json_decode($matrix->right, true);
                $search = array_search($child, $right);
                if($search){
                    $position = [
                        'child' => $child,
                        'level' => $matrix->position,
                        'position' => $search,
                        'side' => 'right',
                        'parent' => $matrix,
                    ];
                }
            }
        }

        return $position;
    }

    public function generateTransactionId(){
        return substr(sha1(time()), 0, 25);
    }
    
}