validatedCard = false ;
const balanceAmount = new Object() ;
function validateRedeem()
{
    giftCard = $('#gift-number');
    if(validateField("gift-number"))
    {
       makeAjax(giftCard.val());
    }
}

function validateField(id)
{ 
    element = $('#'+id);
    applyPayment = document.getElementById('apply-payment') ;
    // applyPayment.disabled = true ;
    
    if(id == 'gift-number')
    {
        $('#balance-div').hide(1000);
        $('#gift-status').hide(1000);
        validatedCard = false ;
    }
    element.css("border","1px solid red");
    if(element.val())
    {
        element.css("border","1px solid #ced4da");
        if(id == 'customerNumber' && validatedCard )   applyPayment.disabled = false ;
        return true ;
    } 
    return false ;
}

function makeAjax(giftNumber)
{
    balanceDiv =   $('#balance-div')  ;
    balance =  $('#balance') ;
    giftStatus = $('#gift-status') ;
    giftValidity =  $('#gift-validity')  ;    
    applyPayment = document.getElementById('apply-payment') ;
    // applyPayment.disabled = true ;
    loader = $('#loader') ;
    loader.show();
    balanceAmount.amount = null ;

    $.ajax({
        url:`http://localhost:8080/gift/gift-rest/validate-redeem?number=${giftNumber}`,
        type: "GET",
        success: function (data) {   
            loader.hide();      
            balanceAmount.amount = null;
        const active = data.data[0].active ;
        const responseBalance = data.data[0].balance ;
        const dataBalance = parseFloat(data.data[0].balance).toFixed(2)  ;
        console.log(dataBalance == NaN ? " Nam" : "not noan" );

        if(active && responseBalance != null && dataBalance != 0 )
        {
            //   const dataBalance = parseFloat(data.data[0].balance).toFixed(2)  ;
              balanceAmount.amount = dataBalance ;
              validatedCard = true ;
              balanceDiv.show(1000);
              setValue(balance,"$"+dataBalance);
              giftStatus.show(1000);
              setValue(giftValidity,"Valid Gift Card!!");
              giftValidity.css("color","green") ;
              if(validateField("customerNumber"))
              {
                //   applyPayment.disabled = false ;
                  
              } 
        }
        else if(active && responseBalance == null || dataBalance == 0 ) {
            balanceDiv.show(1000);
            setValue(balance,"$0");
            giftStatus.show(1000);
            setValue(giftValidity,"Insufficient Balance!!");
            giftValidity.css("color","red") ;
        }else
        {
            balanceDiv.show(1000);
            setValue(balance,"N.A.");
            giftStatus.show(1000);
            setValue(giftValidity,"Inactive Gift Card!");
            giftValidity.css("color","red") ;

        }   
        },
        error: function (error) {
            loader.hide();      
            balanceDiv.show(1000);
            setValue(balance,"N.A.");
            giftStatus.show(1000);
            setValue(giftValidity,"Invalid Gift Card!");
            giftValidity.css("color","red") ;
           return false ;
        }
    });
}

function applyPaymentFunc()
{
    if( !validateField("gift-number") || !validateField("customerNumber") )
    {
        return ;
    }
    const data = new Object() ;
    data.customer_number = $("#gift-number").val() ;
    data.card_number = $('#customerNumber').val() ;
    data.balance =  balanceAmount.amount ;

    loader = $('#loader') ;
    loader.show();
    $.ajax({
        url:`http://localhost:8080/gift/gift-rest/apply-payment`,
        type: "POST",
        data: JSON.stringify(data),
        success: function (response) {   
        loader.hide();      
            console.log(response) ;
        },
        error: function (error) {
            loader.hide();      
           return false ;
        }
    });
}

function setValue(element,value)
{
    element.text(value) ;
}