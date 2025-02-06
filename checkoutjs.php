<!DOCTYPE HTML>
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Embedded Payment Demo</title>
  <script src="https://api.convergepay.com/hosted-payments/Checkout.js"></script>
  <script>
    var callback = {
      onError: function (error) {
        showResult("error", error);
      },
      onDeclined: function (response) {
        showResult("declined", JSON.stringify(response));
      },
      onApproval: function (response) {
        showResult("approval", JSON.stringify(response));
      },
      onCancelled: function () {
        showResult("cancelled", "");
      }
    };

    function initiateEwallets() {
      var paymentData = {
        ssl_txn_auth_token: document.getElementById('token').value
      };
      ConvergeEmbeddedPayment.initGooglePay('googlepay-button', paymentData, callback);
      return false;
    }

    function showResult(status, msg, hash) {
      document.getElementById('txn_status').innerHTML = "<b>" + status + "</b>";
      document.getElementById('txn_response').innerHTML = msg + "</b>";
      document.getElementById('txn_hash').innerHTML = hash;
    }
  </script>

</head>

<body>
  <form>
    Transaction Token: <input type="text" id="token" name="token"> <br>
    <button onclick="return initiateEwallets();">Initiate Checkout.js</button> <br>
  </form>
  <br>
  <br /><br />
  <div id="googlepay-button"></div>
  <br>

  Transaction Status:<div id="txn_status"></div>
  <br>
  Transaction Response:<div id="txn_response"></div>
  <br>
  Transaction Hash Value:<div id="txn_hash"></div>
</body>

</html>