<?php   

require('../include/inc/defined_variables.php'); 

require('../include/db.php');



?>

<div class="panel payment_modal settingPayModel">
    <div class="payment-modal-header"> 
        <a href="#">
            <img src="<?php echo SITE_URL;?>/images/content-share-new-logo.png" />
        </a>
        <div class="paymentresponse_btn">
            <a href="#"><i class="fa fa-lock" aria-hidden="true"></i></a>
            <a href="#0" class="cd-popup-close img-replace settingPayModelClose">×</a>
        </div>
    </div>
    <div class="panel-body">
        <form action="BuyImpression.php" method="POST" id="paymentFrm">
        	<div class="payment-form">
            	<input type="hidden" name="user_id" value="<?php echo $_POST['id'];?>">
                <input type="hidden" name="price" value="<?php echo $_POST['price'];?>">
                <div id="paymentResponse" style="display:none;"></div>
            	<!-- <div class="form-group">
                    <input type="text" name="name" placeholder="Please enter email">
                </div> -->
                <div class="form-group card_number">
                    <label>Card number:</label>
                    <div id="card_number" class="field"></div>
                </div>
                <div class="exCardDis">
                    <div class="form-group card_expires">
                        <label>Expires:</label>
                        <div id="card_expiry" class="field"></div>
                    </div>
                    <div class="form-group card_code">
                        <label>Card code:</label>
                        <div id="card_cvc" class="field"></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success" id="payBtn">Pay <?php echo '$'.number_format($_POST['price'],2); ?></button>
            </div>
        </form>
    </div>
</div>



<!-- Stripe JS library -->

<script>

// Create an instance of the Stripe object

// Set your publishable API key

var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');



// Create an instance of elements

var elements = stripe.elements();



var style = {

    base: {

        fontWeight: 400,

        fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',

        fontSize: '16px',

        lineHeight: '1.4',

        color: '#555',

        backgroundColor: '#fff',

        '::placeholder': {

            color: '#888',

        },

    },

    invalid: {

        color: '#eb1c26',

    }

};



var cardElement = elements.create('cardNumber', {

    style: style

});

cardElement.mount('#card_number');



var exp = elements.create('cardExpiry', {

    'style': style

});

exp.mount('#card_expiry');



var cvc = elements.create('cardCvc', {

    'style': style

});

cvc.mount('#card_cvc');



// Validate input of the card elements

var resultContainer = document.getElementById('paymentResponse');

cardElement.addEventListener('change', function(event) {

    if (event.error) {

        resultContainer.innerHTML = '<p>'+event.error.message+'</p>';
        $('#paymentResponse').show();
        setTimeout(function() {
           $('#paymentResponse').fadeOut('slow');
        }, 8000);
    } else {

        resultContainer.innerHTML = '';

    }

});



// Get payment form element

var form = document.getElementById('paymentFrm');



// Create a token when the form is submitted.

form.addEventListener('submit', function(e) {
    document.getElementById("payBtn").disabled=true;
    e.preventDefault();

    createToken();

});


// Create single-use token to charge the user
function createToken() {
    stripe.createToken(cardElement).then(function(result) {
        
        if (result.error) {
            // Inform the user if there was an error
            resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
            document.getElementById("payBtn").disabled=false;
            $('#paymentResponse').show();
            setTimeout(function() {
               $('#paymentResponse').fadeOut('slow');
            }, 8000);
        } else {
            // Send the token to your server
            stripeTokenHandler(result.token);
        }
    });
}



// Callback to handle the response from stripe

function stripeTokenHandler(token) {

    // Insert the token ID into the form so it gets submitted to the server

    var hiddenInput = document.createElement('input');

    hiddenInput.setAttribute('type', 'hidden');

    hiddenInput.setAttribute('name', 'stripeToken');

    hiddenInput.setAttribute('value', token.id);

    form.appendChild(hiddenInput);

  

    // Submit the form

    form.submit();

}

</script>