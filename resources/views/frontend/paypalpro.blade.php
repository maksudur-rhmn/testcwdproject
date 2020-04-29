 @extends('layouts.frontend')

{{--@section('content')


      <div class="container">
        <div class="row">
          <div class="col-lg-8 m-auto">
                <div id="paypal-button-container"></div>

                <div class="alert alert-success" role="alert" id="success">

                </div>
          </div>
        </div>
      </div>



@endsection

@section('script')
  <script
  src="https://www.paypal.com/sdk/js?client-id=AZXlK10z_marj7HxsEvRG-tLwQUru1kk5stsOpicWs55KSPN6dj8y8nZ4NK5ByIyI9xovM8EV8ZO9PwW"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
</script>



  <script>
  paypal.Buttons({
      createOrder: function(data, actions) {
        // This function sets up the details of the transaction, including the amount and line item details.
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: "{{ $totals }}"
            }
          }]
        });
      },
      onApprove: function(data, actions) {
        // This function captures the funds from the transaction.
        return actions.order.capture().then(function(details) {
          // This function shows a transaction success message to your buyer.
          $('#success').html('Transaction completed by ' + details.payer.name.given_name);

        });
      }
    }).render('#paypal-button-container');
    //This function displays Smart Payment Buttons on your web page.
        </script>
@endsection --}}

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-8 m-auto mb-5">
      <div id="paypal-button" style="margin: 100px 0;"></div>
      </div>
      </div>
      </div>

@endsection
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>

  paypal.Button.render({
    // Configure environment
    env: 'sandbox',
    client: {
      sandbox: 'AZXlK10z_marj7HxsEvRG-tLwQUru1kk5stsOpicWs55KSPN6dj8y8nZ4NK5ByIyI9xovM8EV8ZO9PwW',
      production: 'demo_production_client_id'
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
      size: 'large',
      color: 'gold',
      shape: 'pill',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
      return actions.payment.create({
        redirect_urls: {
          return_url:"http://localhost:8000/execute-payment"
        },
        transactions: [{
          amount: {
            total: 34,
            currency: 'USD'
          }
        }]
      });
    },
    // Execute the payment
    onAuthorize: function(data, actions) {
        return actions.redirect();
    }
  }, '#paypal-button');

</script>
