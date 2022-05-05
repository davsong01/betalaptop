<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Controllers\Traits\FunctionsTrait;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FunctionsTrait;

    

    public function getSpace($user, $thisUserLevel, $requestLevel, $downline, $parentMatrix, $requestSide, $requestIndex, $directUplineMatrix){  
      
        // Problem is we need to know which leg and index to put the incoming downline in this particular upline matrix, we call it space
        $index = $this->getPositionInParentMatrix( $parentMatrix->user_id, $user); // Child, Parent
        
        $sideToUpdate =  $this->resolveRequestIndex($requestIndex);
       
        // dd($directUplineMatrix,$thisUserLevel, $requestLevel, $downline, $parentMatrix, $requestSide, $requestIndex,  $parentMatrix);
    echo('got to requestlevel' . $requestLevel. ' userlevel: '. $thisUserLevel.'<br>');
        switch ($requestLevel) { // Check parent level
            case 2:
                // Check this upline level
                if($thisUserLevel == 1){
                    $space = $this->getSpaceForUplineLevel1( $requestIndex); // Fixed
                }elseif($thisUserLevel == 2){
                    $space = $this->getSpaceForUplineLevel2($requestIndex);
                }elseif($thisUserLevel == 3){
                    $space = $this->getSpaceForUplineLevel3( $requestIndex);
                }elseif($requestIndex == 4){
                    $space = $this->getSpaceForUplineLevel4( $requestIndex);
                }elseif($requestIndex == 5){
                    $space = $this->getSpaceForUplineLevel5( $requestIndex);
                } 
                
                // $this->updateUpline($directUplineMatrix, $sideToUpdate, $downline, $requestIndex);
                break;
            case 3:
                if($thisUserLevel == 1){
                    $space = $this->getSpaceForRequest3UplineLevel1( $requestIndex); // Fixed
                }elseif($thisUserLevel == 2){
                    $space = $this->getSpaceForRequest3UplineLevel2($requestIndex);
                }elseif($thisUserLevel == 3){
                    $space = $this->getSpaceForRequest3UplineLevel3( $requestIndex);
                }elseif($requestIndex == 4){
                    $space = $this->getSpaceForRequest3UplineLevel14( $requestIndex);
                }elseif($requestIndex == 5){
                    $space = $this->getSpaceForRequest3UplineLevel15( $requestIndex);
                } 
                break;

            case 4:
                if($thisUserLevel == 1){
                    $space = $this->getSpaceForRequest4UplineLevel1( $requestIndex); // Fixed
                }elseif($thisUserLevel == 2){
                    $space = $this->getSpaceForRequest4UplineLevel2($requestIndex);
                }elseif($thisUserLevel == 3){
                    $space = $this->getSpaceForRequest4UplineLevel3( $requestIndex);
                }elseif($thisUserLevel== 4){
                  
                    $space = $this->getSpaceForRequest4UplineLevel4( $requestIndex);
                }elseif($thisUserLevel== 5){
                    $space = $this->getSpaceForRequest4UplineLevel5( $requestIndex);
                } 
                break;
            
            case 5:
               
                 
                if($thisUserLevel == 1){
                    $space = $this->getSpaceForRequest5UplineLevel1( $requestIndex); // Fixed
                }elseif($thisUserLevel == 2){
                    
                    $space = $this->getSpaceForRequest5UplineLevel2($requestIndex);
                }elseif($thisUserLevel == 3){
                    $space = $this->getSpaceForRequest5UplineLevel3( $requestIndex);
                }elseif($thisUserLevel == 4){

                    $space = $this->getSpaceForRequest5UplineLevel4( $requestIndex);
                }elseif($thisUserLevel == 5){
                    $space = $this->getSpaceForRequest5UplineLevel5( $requestIndex);
                } 
                break;
            default;

        }
        
       return $space;
    }

    public function getSpaceForUplineLevel1($requestIndex){
        
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
       
        elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
           
        }
        elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }
    
        return $space;
    }

    public function getSpaceForUplineLevel2($requestIndex){
   
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
         
            $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];

        }elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }

        return $space;
    }

    public function getSpaceForUplineLevel3($requestIndex){
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            
            $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 2,
            ];

        }elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }elseif($requestIndex == 5){
             $space = [
                'side' => 'left',
                'position' => 3,
            ];
        }elseif($requestIndex == 6){
             $space = [
                'side' => 'right',
                'position' => 3,
            ];
        }elseif($requestIndex == 7){
             $space = [
                'side' => 'left',
                'position' => 4,
            ];
        }elseif($requestIndex == 8){
             $space = [
                'side' => 'right',
                'position' => 4,
            ];
        }

        return $space;
    }

    public function getSpaceForUplineLevel4($requestIndex){
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 2,
            ];

        }elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }elseif($requestIndex == 5){
             $space = [
                'side' => 'left',
                'position' => 3,
            ];
        }elseif($requestIndex == 6){
             $space = [
                'side' => 'right',
                'position' => 3,
            ];
        }elseif($requestIndex == 7){
             $space = [
                'side' => 'left',
                'position' => 4,
            ];
        }elseif($requestIndex == 8){
             $space = [
                'side' => 'right',
                'position' => 4,
            ];
        }elseif($requestIndex == 9){
             $space = [
                'side' => 'left',
                'position' => 5,
            ];
        }elseif($requestIndex == 10){
             $space = [
                'side' => 'right',
                'position' => 5,
            ];
        }elseif($requestIndex == 11){
             $space = [
                'side' => 'left',
                'position' => 6,
            ];
        }elseif($requestIndex == 12){
             $space = [
                'side' => 'right',
                'position' => 6,
            ];
        }elseif($requestIndex == 13){
             $space = [
                'side' => 'left',
                'position' => 7,
            ];
        }elseif($requestIndex == 14){
             $space = [
                'side' => 'right',
                'position' => 7,
            ];
        }elseif($requestIndex == 15){
             $space = [
                'side' => 'left',
                'position' => 8,
            ];
        }elseif($requestIndex == 16){
             $space = [
                'side' => 'right',
                'position' => 8,
            ];
        }

        return $space;
    }

    public function getSpaceForRequest3UplineLevel1($requestIndex){
    
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        
        elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
           
        }
        elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
   
        return $space;
    }

    public function getSpaceForRequest3UplineLevel2($requestIndex){
        
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){

            $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];

        }elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }

        return $space;
    }

    public function getSpaceForRequest3UplineLevel3($requestIndex){
       
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            
            $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 2,
            ];

        }elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }elseif($requestIndex == 5){
             $space = [
                'side' => 'left',
                'position' => 3,
            ];
        }elseif($requestIndex == 6){
             $space = [
                'side' => 'right',
                'position' => 3,
            ];
        }elseif($requestIndex == 7){
             $space = [
                'side' => 'left',
                'position' => 4,
            ];
        }elseif($requestIndex == 8){
             $space = [
                'side' => 'right',
                'position' => 4,
            ];
        }

        return $space;
    }

    public function getSpaceForRequest3UplineLevel4($requestIndex){
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 2,
            ];

        }elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }elseif($requestIndex == 5){
             $space = [
                'side' => 'left',
                'position' => 3,
            ];
        }elseif($requestIndex == 6){
             $space = [
                'side' => 'right',
                'position' => 3,
            ];
        }elseif($requestIndex == 7){
             $space = [
                'side' => 'left',
                'position' => 4,
            ];
        }elseif($requestIndex == 8){
             $space = [
                'side' => 'right',
                'position' => 4,
            ];
        }elseif($requestIndex == 9){
             $space = [
                'side' => 'left',
                'position' => 5,
            ];
        }elseif($requestIndex == 10){
             $space = [
                'side' => 'right',
                'position' => 5,
            ];
        }elseif($requestIndex == 11){
             $space = [
                'side' => 'left',
                'position' => 6,
            ];
        }elseif($requestIndex == 12){
             $space = [
                'side' => 'right',
                'position' => 6,
            ];
        }elseif($requestIndex == 13){
             $space = [
                'side' => 'left',
                'position' => 7,
            ];
        }elseif($requestIndex == 14){
             $space = [
                'side' => 'right',
                'position' => 7,
            ];
        }elseif($requestIndex == 15){
             $space = [
                'side' => 'left',
                'position' => 8,
            ];
        }elseif($requestIndex == 16){
             $space = [
                'side' => 'right',
                'position' => 8,
            ];
        }

        return $space;
    }

    // Requestlevel 4
    public function getSpaceForRequest4UplineLevel1($requestIndex){
    
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        
        elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
           
        }
        elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
         elseif($requestIndex == 5){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
           
        }
        elseif($requestIndex == 6){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
         elseif($requestIndex == 7){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
           
        }
        elseif($requestIndex == 8){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
   
        return $space;
    }

    public function getSpaceForRequest4UplineLevel2($requestIndex){
        
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){

            $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];

        }
        elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }
        elseif($requestIndex == 5){
             $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 6){
             $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }
        elseif($requestIndex == 7){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 8){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }

        return $space;
    }

    public function getSpaceForRequest4UplineLevel3($requestIndex){
       
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            
            $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 3,
            ];

        }elseif($requestIndex == 4){
             $space = [
                'side' => 'left',
                'position' => 4,
            ];
        }elseif($requestIndex == 5){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }elseif($requestIndex == 6){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }elseif($requestIndex == 7){
             $space = [
                'side' => 'right',
                'position' => 3,
            ];
        }elseif($requestIndex == 8){
             $space = [
                'side' => 'right',
                'position' => 4,
            ];
        }

        return $space;
    }

    public function getSpaceForRequest4UplineLevel4($requestIndex){
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 2,
            ];

        }elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }elseif($requestIndex == 5){
             $space = [
                'side' => 'left',
                'position' => 3,
            ];
        }elseif($requestIndex == 6){
             $space = [
                'side' => 'right',
                'position' => 3,
            ];
        }elseif($requestIndex == 7){
             $space = [
                'side' => 'left',
                'position' => 4,
            ];
        }elseif($requestIndex == 8){
             $space = [
                'side' => 'right',
                'position' => 4,
            ];
        }elseif($requestIndex == 9){
             $space = [
                'side' => 'left',
                'position' => 5,
            ];
        }elseif($requestIndex == 10){
             $space = [
                'side' => 'right',
                'position' => 5,
            ];
        }elseif($requestIndex == 11){
             $space = [
                'side' => 'left',
                'position' => 6,
            ];
        }elseif($requestIndex == 12){
             $space = [
                'side' => 'right',
                'position' => 6,
            ];
        }elseif($requestIndex == 13){
             $space = [
                'side' => 'left',
                'position' => 7,
            ];
        }elseif($requestIndex == 14){
             $space = [
                'side' => 'right',
                'position' => 7,
            ];
        }elseif($requestIndex == 15){
             $space = [
                'side' => 'left',
                'position' => 8,
            ];
        }elseif($requestIndex == 16){
             $space = [
                'side' => 'right',
                'position' => 8,
            ];
        }

        return $space;
    }
    
    // Request level 5
    public function getSpaceForRequest5UplineLevel1($requestIndex){
    //    dd($requestIndex);
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        
        elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
           
        }
        elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
         elseif($requestIndex == 5){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
           
        }
        elseif($requestIndex == 6){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
         elseif($requestIndex == 7){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
           
        }
        elseif($requestIndex == 8){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 9){
             $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 10){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 11){
             $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 12){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 13){
             $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }

        elseif($requestIndex == 14){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 15){
             $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 16){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        return $space;
    }

    public function getSpaceForRequest5UplineLevel2($requestIndex){

        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){

            $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];

        }
        elseif($requestIndex == 4){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }
        elseif($requestIndex == 5){
             $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 6){
             $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }
        elseif($requestIndex == 7){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 8){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }
        elseif($requestIndex == 9){

            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 10){
            $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }
        elseif($requestIndex == 11){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 12){
            $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }
        elseif($requestIndex == 13){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 14){
            $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }
        elseif($requestIndex == 15){
            $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 16){
            $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }

        return $space;
    }

    public function getSpaceForRequest5UplineLevel3($requestIndex){
     
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            
            $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 3,
            ];

        }elseif($requestIndex == 4){
             $space = [
                'side' => 'left',
                'position' => 4,
            ];
        }elseif($requestIndex == 5){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }elseif($requestIndex == 6){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }elseif($requestIndex == 7){
             $space = [
                'side' => 'right',
                'position' => 3,
            ];
        }
        elseif($requestIndex == 8){
             $space = [
                'side' => 'right',
                'position' => 4,
            ];
        }
        elseif($requestIndex == 9){
             $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 10){
             $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }
        elseif($requestIndex == 11){
             $space = [
                'side' => 'left',
                'position' => 3,
            ];
        }
        elseif($requestIndex == 12){
             $space = [
                'side' => 'left',
                'position' => 4,
            ];
        }

        elseif($requestIndex == 13){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }

        elseif($requestIndex == 14){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }
        elseif($requestIndex == 15){
             $space = [
                'side' => 'right',
                'position' => 3,
            ];
        }
        elseif($requestIndex == 16){
             $space = [
                'side' => 'right',
                'position' => 4,
            ];
        }
      
        return $space;
    }

    public function getSpaceForRequest5UplineLevel4($requestIndex){
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            $space = [
                'side' => 'left',
                'position' => 2,
            ];
          
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 3,
            ];

        }elseif($requestIndex == 4){
             $space = [
                'side' => 'left',
                'position' => 4,
            ];
        }elseif($requestIndex == 5){
             $space = [
                'side' => 'left',
                'position' => 5,
            ];
        }elseif($requestIndex == 6){
             $space = [
                'side' => 'left',
                'position' => 6,
            ];
        }elseif($requestIndex == 7){
             $space = [
                'side' => 'left',
                'position' => 7,
            ];
        }elseif($requestIndex == 8){
             $space = [
                'side' => 'left',
                'position' => 8,
            ];
        }elseif($requestIndex == 9){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }elseif($requestIndex == 10){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }elseif($requestIndex == 11){
             $space = [
                'side' => 'right',
                'position' => 3,
            ];
        }elseif($requestIndex == 12){
             $space = [
                'side' => 'right',
                'position' => 4,
            ];
        }elseif($requestIndex == 13){
             $space = [
                'side' => 'right',
                'position' => 5,
            ];
        }elseif($requestIndex == 14){
             $space = [
                'side' => 'right',
                'position' => 6,
            ];
        }elseif($requestIndex == 15){
             $space = [
                'side' => 'right',
                'position' => 7,
            ];
        }
        elseif($requestIndex == 16){
             $space = [
                'side' => 'right',
                'position' => 8,
            ];
        }
        elseif($requestIndex == 17){
             $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 18){
             $space = [
                'side' => 'left',
                'position' => 2,
            ];
        }
        elseif($requestIndex == 19){
             $space = [
                'side' => 'left',
                'position' => 3,
            ];
        }
        elseif($requestIndex == 20){
             $space = [
                'side' => 'left',
                'position' => 4,
            ];
        }
        elseif($requestIndex == 21){
             $space = [
                'side' => 'left',
                'position' => 5,
            ];
        }
        elseif($requestIndex == 22){
             $space = [
                'side' => 'left',
                'position' => 6,
            ];
        }
        elseif($requestIndex == 23){
             $space = [
                'side' => 'left',
                'position' => 7,
            ];
        }
        elseif($requestIndex == 24){
             $space = [
                'side' => 'left',
                'position' => 8,
            ];
        }
        elseif($requestIndex == 25){
             $space = [
                'side' => 'right',
                'position' => 1,
            ];
        }
        elseif($requestIndex == 26){
             $space = [
                'side' => 'right',
                'position' => 2,
            ];
        }
        elseif($requestIndex == 27){
             $space = [
                'side' => 'right',
                'position' => 3,
            ];
        }
        elseif($requestIndex == 28){
             $space = [
                'side' => 'right',
                'position' =>4,
            ];
        }
        elseif($requestIndex == 29){
             $space = [
                'side' => 'right',
                'position' => 5,
            ];
        }
        elseif($requestIndex == 30){
             $space = [
                'side' => 'right',
                'position' => 6,
            ];
        }
        elseif($requestIndex == 31){
             $space = [
                'side' => 'right',
                'position' => 7,
            ];
        }
        elseif($requestIndex == 32){
             $space = [
                'side' => 'right',
                'position' => 8,
            ];
        }
       
        return $space;
    }

    public function getSpaceForRequest5UplineLevel5($requestIndex){
       
        if($requestIndex == 1){
            $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }elseif($requestIndex == 2){
            $space = [
                'side' => 'left',
                'position' => 2,
            ];
          
        }elseif($requestIndex == 3){
            $space = [
                'side' => 'left',
                'position' => 3,
            ];

        }elseif($requestIndex == 4){
             $space = [
                'side' => 'left',
                'position' => 4,
            ];
        }elseif($requestIndex == 5){
             $space = [
                'side' => 'left',
                'position' => 5,
            ];
        }elseif($requestIndex == 6){
             $space = [
                'side' => 'left',
                'position' => 6,
            ];
        }elseif($requestIndex == 7){
             $space = [
                'side' => 'left',
                'position' => 7,
            ];
        }elseif($requestIndex == 8){
             $space = [
                'side' => 'left',
                'position' => 8,
            ];
        }elseif($requestIndex == 9){
             $space = [
                'side' => 'left',
                'position' => 9,
            ];
        }elseif($requestIndex == 10){
             $space = [
                'side' => 'left',
                'position' => 10,
            ];
        }elseif($requestIndex == 11){
             $space = [
                'side' => 'left',
                'position' => 11,
            ];
        }elseif($requestIndex == 12){
             $space = [
                'side' => 'left',
                'position' => 11,
            ];
        }elseif($requestIndex == 13){
             $space = [
                'side' => 'left',
                'position' => 13,
            ];
        }elseif($requestIndex == 14){
             $space = [
                'side' => 'left',
                'position' => 14,
            ];
        }elseif($requestIndex == 15){
             $space = [
                'side' => 'left',
                'position' => 15,
            ];
        }
        elseif($requestIndex == 16){
             $space = [
                'side' => 'left',
                'position' => 16,
            ];
        }
        elseif($requestIndex == 17){
             $space = [
                'side' => 'left',
                'position' => 1,
            ];
        }
        // elseif($requestIndex == 18){
        //      $space = [
        //         'side' => 'left',
        //         'position' => 2,
        //     ];
        // }
        // elseif($requestIndex == 19){
        //      $space = [
        //         'side' => 'left',
        //         'position' => 3,
        //     ];
        // }
        // elseif($requestIndex == 20){
        //      $space = [
        //         'side' => 'left',
        //         'position' => 4,
        //     ];
        // }
        // elseif($requestIndex == 21){
        //      $space = [
        //         'side' => 'left',
        //         'position' => 5,
        //     ];
        // }
        // elseif($requestIndex == 22){
        //      $space = [
        //         'side' => 'left',
        //         'position' => 6,
        //     ];
        // }
        // elseif($requestIndex == 23){
        //      $space = [
        //         'side' => 'left',
        //         'position' => 7,
        //     ];
        // }
        // elseif($requestIndex == 24){
        //      $space = [
        //         'side' => 'left',
        //         'position' => 8,
        //     ];
        // }
        // elseif($requestIndex == 25){
        //      $space = [
        //         'side' => 'right',
        //         'position' => 1,
        //     ];
        // }
        // elseif($requestIndex == 26){
        //      $space = [
        //         'side' => 'right',
        //         'position' => 2,
        //     ];
        // }
        // elseif($requestIndex == 27){
        //      $space = [
        //         'side' => 'right',
        //         'position' => 3,
        //     ];
        // }
        // elseif($requestIndex == 28){
        //      $space = [
        //         'side' => 'right',
        //         'position' =>4,
        //     ];
        // }
        // elseif($requestIndex == 29){
        //      $space = [
        //         'side' => 'right',
        //         'position' => 5,
        //     ];
        // }
        // elseif($requestIndex == 30){
        //      $space = [
        //         'side' => 'right',
        //         'position' => 6,
        //     ];
        // }
        // elseif($requestIndex == 31){
        //      $space = [
        //         'side' => 'right',
        //         'position' => 7,
        //     ];
        // }
        // elseif($requestIndex == 32){
        //      $space = [
        //         'side' => 'right',
        //         'position' => 8,
        //     ];
        // }
      
        return $space;
    }
}
