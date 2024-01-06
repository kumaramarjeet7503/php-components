<?php

namespace app\modules\gift\controllers;

use app\modules\gift\assets\GiftAssets ;
use yii\helpers\Html ;
use yii\helpers\Url ;
GiftAssets::register($this) ;

?>

<div class="gift-default-index">
        <div class="gift-container">
            <div class="gift-card">
            <button id="gift-button" class="gift-button" data-toggle="modal" data-target="#exampleModalCenter">Redeem</button>
            </div>
        </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gift-title" style="    font-family: emoji">Redeem Gift Card</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <?= Html::img(Url::to("@web/images/gift-v7.jpg"),['height'=>"","width"=>"6vmax","class"=>"gift-image"]) ?>
            <input type="text" id="gift-number"  maxlength =50 onKeyUp="validateField(this.id)" class="col-md-12 form-control form-group mt-2" placeholder="Enter the provided gift card number">
              <div class="redeem-div" >
                <div class="col-md-7 text-right p-0" >
                  <button id="redeem-buttom" onClick="validateRedeem()" class="redeem-buttom" >Redeem</button>
                </div>
                <div class="col-md-5 pl-0">
                  <div class="loader" id = "loader" style="display : none">
                </div>
                </div>
              </div>
            <hr style="color : #dc0607 ;">
            <div class="row"   >
              <div class="col-md-6 text-left" id="balance-div" style="display:none;"><p style="    font-weight: bold;" class="balance" >Balance: &nbsp</p><p id="balance"  ></p></div>
              <div id="gift-status" style="display : none"   class="col-md-6 error-div text-right" ><p  id="gift-validity" ></p></div>
            </div> 
              <input type="text"  id="customerNumber" maxlength =10 onKeyUp="validateField(this.id)"  class="col-md-12 form-control form-group " placeholder="Enter the customer number">
            <div class="text-right">
              <button type="button" id="apply-payment" class="accept-buttom" onClick="applyPaymentFunc()" >Apply Payment</button>
            </div>

</div>
      </div>
  
    </div>
  </div>
</div>