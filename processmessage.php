<?php

session_start();
require 'autoload.php';

use AfricasTalking\SDK\AfricasTalking;

// $sessionId   = $_POST["sessionId"];
//$serviceCode = $_POST['to'];
$phoneNumber = $_POST["from"];
$text = $_POST['text'];
$linkId = $_POST["linkId"];
//
//
//
//$from = $_POST['from'];
//// Used To bill the user for the response
//$date        = $_POST["date"]; // The time we received the message
//$id          = $_POST["id"];   // A unique id for this message

$phone = "254" . substr($phoneNumber, -9);
$_SESSION['linkId'] = $linkId;
$text = str_replace(' ', '', $text);
$_SESSION["text"] = strtoupper($text);
$_SESSION["shortcode"] = "40495";
$_SESSION["phone"] = $phone;

$prefix = strtoupper(trim(substr($text, 0, 2)));  // returns "query message"   

$txt = trim(substr($text, 3, 40));  // returns "query message"    
//1.	EXPERT REGISTRATION 

$pref = preg_replace('/[^a-zA-Z0-9+]/', '', $prefix);

$number = preg_replace('/[^0-9]+/', '', $prefix);

$file = fopen('error.log', 'w');
fwrite($file, $number . "" . $text . date('YmdHis') . $txt . "<br>");

switch ($pref) {

    case "":
        $msg = "Thank you for contacting City Corporation \n";
        $msg .= "To continue in English reply with: \n";
        $msg .= "E0 \n ";
        $msg .= "Kuendelea Kwa kiswahili jibu kwa: \n";
        $msg .= "K0 ";
//       $msg .= "  3- For Mini-Ledger ";
        sendmessage($msg);
        echo $msg;
        break;

    case "E0":
        $msg = "Thank you for contacting City Corporation \n";
        $msg .= "Kindly reply with: \n";
        $msg .= " E1 - To appy for a loan \n ";
        $msg .= " E2- For member statements \n ";
        $msg .= " E3- For Mini-Ledger ";
//       $msg .= " E3- For Mini-Ledger ";
        sendmessage($msg);
        echo $msg;
        break;

    case "K0":
        $msg = "Asante kwa kuwasiliana na City Corporation \n";
        $msg .= "Jibu kwa: \n";
        $msg .= " K1 - Kuomba mkopo \n ";
        $msg .= " K2- Kwa taarifa \n ";
        $msg .= " K3- Kwa Mini-Ledger ";
//       $msg .= " E3- For Mini-Ledger ";
        sendmessage($msg);
        echo $msg;
        break;

//    case 5:
//        $msg = "Please enter your firstname,lastname and ID Number as: \n";
//        $msg .= " 3#firstname#lastname#ID e.g\n";
//        $msg .= " 3#John#Doe#123456";
//
//        sendmessage($msg);
//
//
//        break;

    case "E1":
        if (verifyUser() == true) {
            $msg = "Please reply with Loan Product \n";
            $msg .= " EA - MOTORBIKE TVS100CC MAGWHEELS\n";
            $msg .= " EB - MOTORBIKE BOXER100CC\n";
            $msg .= " EC - MOTORBIKE BOXER125CC \n";
            $msg .= " ED - CASINO \n";
            $msg .= " EE - MOTORBIKE TVS125CC \n";
            $msg .= " EF - MOTORBIKE TVS150CC \n";
            $msg .= " EG - MOTORBIKE BOXER150CC \n";
            $msg .= " EH - TUKTUK \n";
            $msg .= " EI - HONDA 125cc-Electric \n";
            $msg .= " EJ - HONDA 125CC KICKSTART \n";
            $msg .= " EK - BAJAJ 100CC \n";
            $msg .= " EL - MOTORBIKE BOXER X150CC\n";
            $msg .= "Example \n";
            $msg .= " EA ";
            echo $msg;
            sendmessage($msg);
        }
        break;

    case "K1":
        if (verifyUserK() == true) {
            $msg = "Jibu kwa aina ya mkopo \n";
            $msg .= " KA - MOTORBIKE TVS100CC MAGWHEELS\n";
            $msg .= " KB - MOTORBIKE BOXER100CC\n";
            $msg .= " KC - MOTORBIKE BOXER125CC \n";
            $msg .= " KD - CASINO \n";
            $msg .= " KE - MOTORBIKE TVS125CC \n";
            $msg .= " KF - MOTORBIKE TVS150CC \n";
            $msg .= " KG - MOTORBIKE BOXER150CC \n";
            $msg .= " KH - TUKTUK \n";
            $msg .= " KI - HONDA 125cc-Electric \n";
            $msg .= " KJ - HONDA 125CC KICKSTART \n";
            $msg .= " KK - BAJAJ 100CC \n";
            $msg .= " KL - MOTORBIKE BOXER X150CC \n";
            $msg .= "mfano: \n";
            $msg .= " KA ";
            echo $msg;
            sendmessage($msg);
        }
        break;


    case "K4":
        if (verifyUserK() == true) {
            if (isset($txt) && $txt != "") {
                $sql = "SELECT * FROM m_client where external_id=$txt ";
                $result = mysqli_query(getDbConnection(), $sql);
                if (mysqli_num_rows($result) > 0) {
                    echo $msg = "Nambari ya Kitambulisho ambayo umetoa tayari imesajiliwa";
                    // sendmessage($msg);
                } else {
                    $sql = "UPDATE m_client SET external_id=$txt where mobile_no= " . $_SESSION['phone'];
                    $result = mysqli_query(getDbConnection(), $sql);
                    echo $msg = "Nambari yako ya kitambulisho imesasishwa \n";
                    sendmessage($msg);
                }
            } else {
                echo $msg = "Jibu batili, jaribu tena baadae \n";
                sendmessage($msg);
            }
        }
        break;
    case "E4":
        if (verifyUser() == true) {
            if (isset($txt) && $txt != "") {
                $sql = "SELECT * FROM m_client where external_id=$txt ";
                $result = mysqli_query(getDbConnection(), $sql);
                if (mysqli_num_rows($result) > 0) {
                    echo $msg = "The ID number you provided is already registered";
                    // sendmessage($msg);
                } else {
                    $sql = "UPDATE m_client SET external_id=$txt where mobile_no= " . $_SESSION['phone'];
                    $result = mysqli_query(getDbConnection(), $sql);
                    echo $msg = "Your ID number has been updated \n";
                    sendmessage($msg);
                }
            } else {
                echo $msg = "Invalid response kindly try again \n";
                sendmessage($msg);
            }
        }
        break;

    case "EA":
        if (verifyUser() == true) {
            $charges = array(array("chargeId" => 36, "amount" => 3.16), array("chargeId" => 38, "amount" => 20000));
            appyLoan(94000.00, 365, 3.12, $charges, 1, null, 0, 1, 0, 1, true);
        }

        break;
    case "KA":
        if (verifyUserK() == true) {
            $charges = array(array("chargeId" => 36, "amount" => 3.16), array("chargeId" => 38, "amount" => 20000));
            appyLoan(94000.00, 365, 3.12, $charges, 1, null, 0, 1, 0, 1, true);
        }

        break;
    //{"clientId":"3","productId":6,"disbursementData":[],"principal":92000,"loanTermFrequency":380,"loanTermFrequencyType":0,
    //"numberOfRepayments":380,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10.1,"amortizationType":1,
    //"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
    //"inArrearsTolerance":1,"graceOnPrincipalPayment":1,"graceOnInterestPayment":1,"transactionProcessingStrategyId":1,
    //"charges":[{"chargeId":36,"amount":3.16},{"chargeId":38,"amount":20000}],"locale":"en","dateFormat":"dd MMMM yyyy",
    //"loanType":"individual","expectedDisbursementDate":"30 December 2018","submittedOnDate":"10 December 2018"}
    case "EB":
        if (verifyUser() == true) {
            $charges = array(array("chargeId" => 36, "amount" => 3.16), array("chargeId" => 38, "amount" => 20000));
            appyLoan(92000, 380, 10.1, $charges, 6, null, 0, 1, 1, 1, true);
        }
        break;

    case "KB":
        if (verifyUserK() == true) {
            $charges = array(array("chargeId" => 36, "amount" => 3.16), array("chargeId" => 38, "amount" => 20000));
            appyLoanK(92000, 380, 10.1, $charges, 6, null, 0, 1, 1, 1, true);
        }
        break;

    case "EC":
        if (verifyUser() == true) {
            $charges = array(array("chargeId" => 36, "amount" => 3.16), array("chargeId" => 38, "amount" => 20000));
            //{"clientId":"3","productId":9,"disbursementData":[],"principal":104000,"loanTermFrequency":380,"loanTermFrequencyType":0,
            //"numberOfRepayments":380,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":9.6,"amortizationType":1,
            //"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"graceOnPrincipalPayment":1,"graceOnInterestPayment":1,"transactionProcessingStrategyId":1,"locale":"en",
            //"dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"30 December 2018",
            //"submittedOnDate":"10 December 2018","charges":[{"chargeId":36,"amount":3.16},{"chargeId":38,"amount":20000}]}
            appyLoan(104000.00, 380, 9.6, $charges, 9, null, 0, 1, 1, 1, true);
        }
        break;

    case "KC":
        if (verifyUserK() == true) {
            $charges = array(array("chargeId" => 36, "amount" => 3.16), array("chargeId" => 38, "amount" => 20000));
            //{"clientId":"3","productId":9,"disbursementData":[],"principal":104000,"loanTermFrequency":380,"loanTermFrequencyType":0,
            //"numberOfRepayments":380,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":9.6,"amortizationType":1,
            //"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"graceOnPrincipalPayment":1,"graceOnInterestPayment":1,"transactionProcessingStrategyId":1,"locale":"en",
            //"dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"30 December 2018",
            //"submittedOnDate":"10 December 2018","charges":[{"chargeId":36,"amount":3.16},{"chargeId":38,"amount":20000}]}
            appyLoanK(104000.00, 380, 9.6, $charges, 9, null, 0, 1, 1, 1, true);
        }
        break;

    case "ED":
        if (verifyUser() == true) {
            //{"clientId":"3","productId":15,"disbursementData":[],"principal":100000,"loanTermFrequency":365,"loanTermFrequencyType":0,
            //"numberOfRepayments":365,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,
            //"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"inArrearsTolerance":1,"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual",
            //"expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018"}
            appyLoan(100000, 365, 10, [], 15, null, 0, null, 1, null, true);
        }
        break;

    case "KD":
        if (verifyUserK() == true) {
            //{"clientId":"3","productId":15,"disbursementData":[],"principal":100000,"loanTermFrequency":365,"loanTermFrequencyType":0,
            //"numberOfRepayments":365,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,
            //"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"inArrearsTolerance":1,"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual",
            //"expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018"}
            appyLoanK(100000, 365, 10, [], 15, null, 0, null, 1, null, true);
        }
        break;

    case "EE":
        if (verifyUser() == true) {
            $charges = array(array("chargeId" => 36, "amount" => 3.16), array("chargeId" => 38, "amount" => 20000));

            //{"clientId":"3","productId":20,"disbursementData":[],"principal":103000,"loanTermFrequency":380,"loanTermFrequencyType":0,
            //"numberOfRepayments":380,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":9.6,"amortizationType":1,
            //"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"inArrearsTolerance":365,"graceOnPrincipalPayment":1,"graceOnInterestPayment":1,"transactionProcessingStrategyId":1,"locale":"en",
            //"dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018",
            //"charges":[{"chargeId":36,"amount":3.16},{"chargeId":38,"amount":20000}]}
            appyLoan(103000, 380, 9.6, $charges, 20, null, 0, 1, 1, 1, true);
        }
        break;

    case "KE":
        if (verifyUserK() == true) {
            $charges = array(array("chargeId" => 36, "amount" => 3.16), array("chargeId" => 38, "amount" => 20000));

            //{"clientId":"3","productId":20,"disbursementData":[],"principal":103000,"loanTermFrequency":380,"loanTermFrequencyType":0,
            //"numberOfRepayments":380,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":9.6,"amortizationType":1,
            //"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"inArrearsTolerance":365,"graceOnPrincipalPayment":1,"graceOnInterestPayment":1,"transactionProcessingStrategyId":1,"locale":"en",
            //"dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018",
            //"charges":[{"chargeId":36,"amount":3.16},{"chargeId":38,"amount":20000}]}
            appyLoanK(103000, 380, 9.6, $charges, 20, null, 0, 1, 1, 1, true);
        }
        break;
    case "EF":
        if (verifyUser() == true) {
            $charges = array(array("chargeId" => 36, "amount" => 3.16), array("chargeId" => 38, "amount" => 20000));

            //{"clientId":"3","productId":21,"disbursementData":[],"principal":103000,"loanTermFrequency":380,"loanTermFrequencyType":0,
            //"numberOfRepayments":380,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":9.6,"amortizationType":1,
            //"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"inArrearsTolerance":365,"graceOnPrincipalPayment":1,"graceOnInterestPayment":1,"transactionProcessingStrategyId":1,"locale":"en",
            //"dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018",
            //"charges":[{"chargeId":36,"amount":3.16},{"chargeId":38,"amount":20000}]}
            appyLoan(103000, 380, 9.6, $charges, 21, null, 0, 1, 1, 1, true);
        }
        break;

    case "KF":
        if (verifyUserK() == true) {
            $charges = array(array("chargeId" => 36, "amount" => 3.16), array("chargeId" => 38, "amount" => 20000));

            //{"clientId":"3","productId":21,"disbursementData":[],"principal":103000,"loanTermFrequency":380,"loanTermFrequencyType":0,
            //"numberOfRepayments":380,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":9.6,"amortizationType":1,
            //"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"inArrearsTolerance":365,"graceOnPrincipalPayment":1,"graceOnInterestPayment":1,"transactionProcessingStrategyId":1,"locale":"en",
            //"dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018",
            //"charges":[{"chargeId":36,"amount":3.16},{"chargeId":38,"amount":20000}]}
            appyLoanK(103000, 380, 9.6, $charges, 21, null, 0, 1, 1, 1, true);
        }
        break;
    case "EG":
        if (verifyUser() == true) {
            $charges = array(array("chargeId" => 36, "amount" => 3.16), array("chargeId" => 38, "amount" => 20000));

            //{"clientId":"3","productId":29,"disbursementData":[],"principal":90000,"loanTermFrequency":365,"loanTermFrequencyType":0,"numberOfRepayments":365,
            //"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":9.45,"amortizationType":1,"isEqualAmortization":true,"interestType":0,
            //"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,"graceOnPrincipalPayment":1,"graceOnInterestPayment":1,
            //"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"20 November 2018",
            //"submittedOnDate":"10 December 2018","charges":[{"chargeId":36,"amount":3.16},{"chargeId":38,"amount":20000}]}
            appyLoan(90000, 365, 9.45, $charges, 29, null, 0, 1, 1, 1, true);
        }
        break;

    case "KG":
        if (verifyUserK() == true) {
            $charges = array(array("chargeId" => 36, "amount" => 3.16), array("chargeId" => 38, "amount" => 20000));

            //{"clientId":"3","productId":29,"disbursementData":[],"principal":90000,"loanTermFrequency":365,"loanTermFrequencyType":0,"numberOfRepayments":365,
            //"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":9.45,"amortizationType":1,"isEqualAmortization":true,"interestType":0,
            //"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,"graceOnPrincipalPayment":1,"graceOnInterestPayment":1,
            //"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"20 November 2018",
            //"submittedOnDate":"10 December 2018","charges":[{"chargeId":36,"amount":3.16},{"chargeId":38,"amount":20000}]}
            appyLoanK(90000, 365, 9.45, $charges, 29, null, 0, 1, 1, 1, true);
        }
        break;
    case "EH":
        if (verifyUser() == true) {
            //{"clientId":"3","productId":28,"disbursementData":[],"fundId":1,"principal":300000,"loanTermFrequency":380,"loanTermFrequencyType":0,
            //"numberOfRepayments":380,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,
            //"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"graceOnPrincipalPayment":1,"graceOnInterestPayment":1,"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy",
            //"loanType":"individual","expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018"}
            appyLoan(300000, 380, 10, [], 28, 1, 0, 1, 1, 1, true);
        }
        break;

    case "KH":
        if (verifyUserK() == true) {
            //{"clientId":"3","productId":28,"disbursementData":[],"fundId":1,"principal":300000,"loanTermFrequency":380,"loanTermFrequencyType":0,
            //"numberOfRepayments":380,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,
            //"isEqualAmortization":true,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"graceOnPrincipalPayment":1,"graceOnInterestPayment":1,"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy",
            //"loanType":"individual","expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018"}
            appyLoanK(300000, 380, 10, [], 28, 1, 0, 1, 1, 1, true);
        }
        break;

    case "EI":
        if (verifyUser() == true) {
            //{"clientId":"3","productId":33,"disbursementData":[],"fundId":1,"principal":92741,"loanTermFrequency":365,"loanTermFrequencyType":0,
            //"numberOfRepayments":365,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,
            //"isEqualAmortization":false,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual",
            //"expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018"}
            appyLoan(92741, 380, 10, [], 33, 1, 0, null, 1, null, TRUE);
        }
        break;
    case "KI":
        if (verifyUserK() == true) {
            //{"clientId":"3","productId":33,"disbursementData":[],"fundId":1,"principal":92741,"loanTermFrequency":365,"loanTermFrequencyType":0,
            //"numberOfRepayments":365,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,
            //"isEqualAmortization":false,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual",
            //"expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018"}
            appyLoanK(92741, 380, 10, [], 33, 1, 0, null, 1, null, TRUE);
        }
        break;

    case "EJ":
        if (verifyUser() == true) {
            //{"clientId":"3","productId":34,"disbursementData":[],"fundId":1,"principal":81393,"loanTermFrequency":365,"loanTermFrequencyType":0,
            //"numberOfRepayments":365,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,
            //"isEqualAmortization":false,
            //"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,"transactionProcessingStrategyId":1,
            //"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"20 November 2018",
            //"submittedOnDate":"10 December 2018"}
            appyLoan(81393, 365, 10, [], 34, 1, 0, null, 1, null, false);
        }
        break;

    case "KJ":
        if (verifyUserK() == true) {
            //{"clientId":"3","productId":34,"disbursementData":[],"fundId":1,"principal":81393,"loanTermFrequency":365,"loanTermFrequencyType":0,
            //"numberOfRepayments":365,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,
            //"isEqualAmortization":false,
            //"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,"transactionProcessingStrategyId":1,
            //"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"20 November 2018",
            //"submittedOnDate":"10 December 2018"}
            appyLoanK(81393, 365, 10, [], 34, 1, 0, null, 1, null, false);
        }
        break;

    case "EK":
        if (verifyUser() == true) {
            //{"clientId":"3","productId":35,"disbursementData":[],"fundId":1,"principal":74275,"loanTermFrequency":365,"loanTermFrequencyType":0,
            //"numberOfRepayments":365,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,
            //"isEqualAmortization":false,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018"}
            appyLoan(74275, 365, 10, [], 35, 1, 0, null, 1, null, false);
        }
        break;

    case "KK":
        if (verifyUserK() == true) {
            //{"clientId":"3","productId":35,"disbursementData":[],"fundId":1,"principal":74275,"loanTermFrequency":365,"loanTermFrequencyType":0,
            //"numberOfRepayments":365,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,
            //"isEqualAmortization":false,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018"}
            appyLoanK(74275, 365, 10, [], 35, 1, 0, null, 1, null, false);
        }
        break;

    case "EL":
        if (verifyUser() == true) {
            //{"clientId":"3","productId":36,"disbursementData":[],"principal":95939,"loanTermFrequency":365,"loanTermFrequencyType":0,
            //"numberOfRepayments":365,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,
            //"isEqualAmortization":false,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018"}
            appyLoan(95939, 365, 10, [], 36, null, 0, null, 1, null, false);
        }
        break;

    case "KL":
        if (verifyUserK() == true) {
            //{"clientId":"3","productId":36,"disbursementData":[],"principal":95939,"loanTermFrequency":365,"loanTermFrequencyType":0,
            //"numberOfRepayments":365,"repaymentEvery":1,"repaymentFrequencyType":0,"interestRatePerPeriod":10,"amortizationType":1,
            //"isEqualAmortization":false,"interestType":0,"interestCalculationPeriodType":1,"allowPartialPeriodInterestCalcualtion":false,
            //"transactionProcessingStrategyId":1,"locale":"en","dateFormat":"dd MMMM yyyy","loanType":"individual","expectedDisbursementDate":"20 November 2018","submittedOnDate":"10 December 2018"}
            appyLoanK(95939, 365, 10, [], 36, null, 0, null, 1, null, false);
        }
        break;

    case "E6":

        if (isset($txt) && $txt != "") {
            $data = explode('#', $txt, 5);

            $sql = "SELECT * FROM m_client where mobile_no= " . $_SESSION['phone'];

            $result = mysqli_query(getDbConnection(), $sql);

            $sq2 = "SELECT * FROM m_client where external_id= " . $data[2];

            $result2 = mysqli_query(getDbConnection(), $sq2);


            if (mysqli_num_rows($result) > 0) {
                $msg = "Mobile number provided is already registered \n";
                $msg .= "Kindly reply with: \n";
                $msg .= " E1 - To appy for a loan \n ";
                $msg .= " E2- For member statements \n ";
                $msg .= " E3- For Mini-Ledger ";
                echo $msg;
                sendmessage($msg);
            } else if (mysqli_num_rows($result2) > 0) {
                $msg = "ID number provided is already registered \n";
                $msg .= "Kindly enter the correct ID: \n";
                echo $msg;
                sendmessage($msg);
            } else {
                $details = Array();
                $details['firstname'] = $data[0];
                $details['lastname'] = $data[1];
                $details['officeId'] = 1;
                $details['active'] = true;
                $details['externalId'] = $data[2];
                $details['activationDate'] = date("d F Y");
                $details['dateFormat'] = "dd MMMM yyyy";
                $details['locale'] = "en";
                $details['mobileNo'] = $_SESSION['phone'];
                $details['savingsProductId'] = 2;

                $url = "https://192.168.1.243:8443/fineract-provider/api/v1/clients?tenantIdentifier=default";
                $response = get_details_to_mifos($url, $details);

                //create deposit account for registration
                $res = json_decode($response, TRUE);


                if (isset($res['clientId']) && $res['clientId'] != "") {
                    $arr = Array();
                    $arr['amount'] = 1;
                    $arr['phone'] = $_SESSION['phone'];
                    $arr['accountReference'] = "deposit";
                    $arr['transactionDesc'] = "deposit";
                    $url = "https://192.168.1.243:3000/mpesa/api/mpesa/push";
                    regPayment($url, $arr);

                    // $msg = "Your account has been created successfully, \n to activate your account \n ensure you have at least KES 220 in your mpesa then reply with ' p' to pay KSH 200 and get your account activated ";
                    sendmessage($msg);
                } else {
                    echo $msg = "An error occurred please try again later";
                    sendmessage($msg);
                }
            }
        } else {
            echo $msg = "Invalid response kindly try again ";
            sendmessage($msg);
        }

        break;

    case "K6":

        if (isset($txt) && $txt != "") {
            $data = explode('#', $txt, 5);

            $sql = "SELECT * FROM m_client where mobile_no= " . $_SESSION['phone'];

            $result = mysqli_query(getDbConnection(), $sql);

            if (mysqli_num_rows($result) > 0) {
                $msg = "Nambari ya simu ya mkononi imeorodheshwa tayari \n";
                $msg .= "Jibu kwa: \n";
                $msg .= " K1 - Kuomba mkopo \n ";
                $msg .= " K2- Kwa taarifa \n ";
                $msg .= " K3- Kwa Mini-Ledger ";
//       echo $msg;
                sendmessage($msg);
            } else {
                $details = Array();
                $details['firstname'] = $data[0];
                $details['lastname'] = $data[1];
                $details['officeId'] = 1;
                $details['active'] = true;
                $details['externalId'] = $data[2];
                $details['activationDate'] = date("d F Y");
                $details['dateFormat'] = "dd MMMM yyyy";
                $details['locale'] = "en";
                $details['mobileNo'] = $_SESSION['phone'];
                $details['savingsProductId'] = 2;

                $url = "https://192.168.1.243:8443/fineract-provider/api/v1/clients?tenantIdentifier=default";
                echo $response = get_details_to_mifos($url, $details);
                $res = json_decode($response, TRUE);
                //create deposit account for registration

                if (isset($res['clientId']) && $res['clientId'] != "") {
                    $arr = Array();
                    $arr['amount'] = 200;
                    $arr['phone'] = $_SESSION['phone'];
                    $arr['accountReference'] = "deposit";
                    $arr['transactionDesc'] = "Member Registration";
                    $url = "https://192.168.1.243:3000/mpesa/api/mpesa/push";
                    regPayment($url, $arr);
                    //$msg = "Akaunti yako imeundwa kwa ufanisi, \ n kuamsha akaunti yako \ n hakikisha una angalau KES 220 katika mpesa wako kisha jibu na ' kp' kulipa KSH 200 na akaunti yako kuanzishwa ";
                    sendmessage($msg);
                } else {
                    echo $msg = "Tatizo dogo limetokea. Tafadhali jaribu tena baadaye";
                    sendmessage($msg);
                }
            }
        } else {
            $msg = "Jibu batili, jaribu tena";
            sendmessage($msg);
        }

        break;

    case "EP":
        if (verifyUser() == true) {
            $arr = Array();
            $arr['amount'] = 1;
            $arr['phone'] = $_SESSION['phone'];
            $arr['accountReference'] = "deposit";
            $arr['transactionDesc'] = "Member Registration";
            $url = "https://192.168.1.243:3000/mpesa/api/mpesa/push";
            regPayment($url, $arr);
        }
        break;

    default:
        $msg = "Could not process your request, try again.\n";
        $msg .= "Haikuweza kusitisha ombi lako, jaribu tena.";
        echo $msg;

    sendmessage($msg);
}

function getDbConnection() {
    $DB_HOST = '192.168.1.243:3306';
    $DB_HOST_NAME = 'root';
    $DB_HOST_PASS = 'mysql';
    $DB_NAME = 'mifostenant-default';
    global $conn;
    $conn = mysqli_connect($DB_HOST, $DB_HOST_NAME, $DB_HOST_PASS, $DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function regPayment($url, $arr) {
    $out = array_values($arr);
    $js = json_encode($arr);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        //curl_setopt ($curl, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem"),
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false),
        //CURLOPT_CAINFO=> dirname(__FILE__)."/cacert.pem",
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_PORT => "3000",
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $js,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);


    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        return $response;
    }
}

function verifyUser() {

    $sql = "SELECT mobile_no FROM m_client where mobile_no=" . $_SESSION['phone'];
    $result = mysqli_query(getDbConnection(), $sql);

    if (mysqli_num_rows($result) == 0) {
        $msg = "Kindly ensure you have at least KES. 220 in your mpesa for registration then reply with: \n";
        $msg .= " E6#firstname#lastname#ID e.g\n";
        $msg .= " E6#John#Doe#123456";
        echo $msg;
        sendmessage($msg);
        return false;
    } else {
        $sql = "SELECT external_id,status_enum FROM m_client where mobile_no=" . $_SESSION['phone'];
        $result = mysqli_query(getDbConnection(), $sql);

        if (mysqli_num_rows($result) == 0) {
            $msg = "Please reply with your National ID number as: \n";
            $msg .= " E4#ID Number e.g \n";
            $msg .= " E4#98765433 ";
            echo $msg;
            sendmessage($msg);
            return false;
        } 
//        else if (mysqli_num_rows($result) > 0) {
//
//            while ($row = mysqli_fetch_assoc($result)) {
//                if ($row['status_enum'] == 100) {
//                    echo $msg = "To activate your account kindly pay KES 200 \n";
//                    
//                    sendmessage($msg);
//                     $arr = Array();
//                    $arr['amount'] = 1;
//                    $arr['phone'] = $_SESSION['phone'];
//                    $arr['accountReference'] = "Member Registration";
//                    $arr['transactionDesc'] = "deposit";
//                    $url = "https://192.168.1.243:3000/mpesa/api/mpesa/push";
//                    regPayment($url, $arr);                   
//                    return false;
//                } else if ($row['status_enum'] == 300) {
//                    return TRUE;
//                }
//            }
//        } 
        else {
            return true;
        }
    }
}

function verifyUserK() {

    $sql = "SELECT mobile_no FROM m_client where mobile_no=" . $_SESSION['phone'];
    $result = mysqli_query(getDbConnection(), $sql);

    if (mysqli_num_rows($result) == 0) {
        $msg = "Kujiandikisha jibu na: \ n";
        $msg .= " K6#jina la kwanza#jina la pili#Nambari ya kitambulisho mfano\n";
        $msg .= " K6#John#Doe#123456";
        echo $msg;

        sendmessage($msg);
        return false;
    } else {
        $sql = "SELECT external_id,status_enum FROM m_client where mobile_no=" . $_SESSION['phone'];
        $result = mysqli_query(getDbConnection(), $sql);

        if (mysqli_num_rows($result) == 0) {
            $msg = "Tafadhali jibu kwa nambari yako ya kitambulisho kama\n";
            $msg .= " E4#ID Number mfano:\n";
            $msg .= " E4#98765433 ";
            echo $msg;
            sendmessage($msg);
            return false;
        } else if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['status_enum'] == 100) {
                    echo $msg = "Ili kuamsha akaunti yako jibu na ' EP' kulipa KES 200 \n";
                    sendmessage($msg);
                     $arr = Array();
                    $arr['amount'] = 200;
                    $arr['phone'] = $_SESSION['phone'];
                    $arr['accountReference'] = "Member Registration";
                    $arr['transactionDesc'] = "deposit";
                    $url = "https://192.168.1.243:3000/mpesa/api/mpesa/push";
                    regPayment($url, $arr);   
                    return false;
                } else if ($row['status_enum'] == 300) {
                    return TRUE;
                }
            }
        } else {
            return true;
        }
    }
}


function appyLoan($principal, $loanTermFreq, $interestRate, $charges, $productId, $fundID, $interestType, $gracePrincipal, $amotizaType, $graceOnInt, $isEqualAmortization) {

    $phoneNumber = $_SESSION['phone'];
    $sql = "SELECT id, account_no, external_id FROM m_client where mobile_no=$phoneNumber";
    $result = mysqli_query(getDbConnection(), $sql);

    if (mysqli_num_rows($result) > 0) {

        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            // echo "id: " . $row["id"] . " - Name: " . $row["account_no"] . " " . $row["external_id"] . "<br>";
            $details = Array();
            $details['clientId'] = $row['id'];
            $details['productId'] = $productId;
            $details['principal'] = $principal;
            $details['loanTermFrequency'] = $loanTermFreq;
            $details['loanTermFrequencyType'] = 0;
            $details['numberOfRepayments'] = $loanTermFreq;
            $details['repaymentEvery'] = 1;
            $details['repaymentFrequencyType'] = 0;
            $details['amortizationType'] = $amotizaType;
            $details['interestType'] = $interestType;
            $details['graceOnPrincipalPayment'] = $gracePrincipal;
            $details['graceOnInterestPayment'] = $graceOnInt;
            $details['fundId'] = $fundID;
            $details['isEqualAmortization'] = $isEqualAmortization;
            $details['interestCalculationPeriodType'] = 1;
            $details['transactionProcessingStrategyId'] = 1;
            $details['interestRatePerPeriod'] = $interestRate;
            $details['expectedDisbursementDate'] = date("d F Y");
            $details['submittedOnDate'] = date("d F Y");
            $details['locale'] = "en";
            $details['loanType'] = 'individual';
            $details['dateFormat'] = "dd MMMM yyyy";
            $details['charges'] = $charges;

            $url = "https://192.168.1.243:8443/fineract-provider/api/v1/loans?tenantIdentifier=default";

            $res = json_decode(get_details_to_mifos($url, $details), TRUE);
            if (!isset($res['clientId']) && $res['clientId'] != $row['id']) {
                $msg = "An error occurred please try again later";
                sendmessage($msg);
            }
        }
    } else {
        echo $msg = "Invalid phone number!";
        sendmessage($msg);
    }


    mysqli_close(getDbConnection());
}

function appyLoanK($principal, $loanTermFreq, $interestRate, $charges, $productId, $fundID, $interestType, $gracePrincipal, $amotizaType, $graceOnInt, $isEqualAmortization) {

    $phoneNumber = $_SESSION['phone'];
    $sql = "SELECT id, account_no, external_id FROM m_client where mobile_no=$phoneNumber";
    $result = mysqli_query(getDbConnection(), $sql);

    if (mysqli_num_rows($result) > 0) {

        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            // echo "id: " . $row["id"] . " - Name: " . $row["account_no"] . " " . $row["external_id"] . "<br>";
            $details = Array();
            $details['clientId'] = $row['id'];
            $details['productId'] = $productId;
            $details['principal'] = $principal;
            $details['loanTermFrequency'] = $loanTermFreq;
            $details['loanTermFrequencyType'] = 0;
            $details['numberOfRepayments'] = $loanTermFreq;
            $details['repaymentEvery'] = 1;
            $details['repaymentFrequencyType'] = 0;
            $details['amortizationType'] = $amotizaType;
            $details['interestType'] = $interestType;
            $details['graceOnPrincipalPayment'] = $gracePrincipal;
            $details['graceOnInterestPayment'] = $graceOnInt;
            $details['fundId'] = $fundID;
            $details['isEqualAmortization'] = $isEqualAmortization;
            $details['interestCalculationPeriodType'] = 1;
            $details['transactionProcessingStrategyId'] = 1;
            $details['interestRatePerPeriod'] = $interestRate;
            $details['expectedDisbursementDate'] = date("d F Y");
            $details['submittedOnDate'] = date("d F Y");
            $details['locale'] = "en";
            $details['loanType'] = 'individual';
            $details['dateFormat'] = "dd MMMM yyyy";
            $details['charges'] = $charges;

            $url = "https://192.168.1.243:8443/fineract-provider/api/v1/loans?tenantIdentifier=default";

            $res = json_decode(get_details_to_mifos($url, $details), TRUE);
            if (!isset($res['clientId']) && $res['clientId'] != $row['id']) {
                $msg = "Tatizo dogo limetokea. Tafadhali jaribu tena baadaye";
                sendmessage($msg);
            }
        }
    } else {
        echo $msg = "Nambari ya simu isiyo sahihi!";
        sendmessage($msg);
    }


    mysqli_close(getDbConnection());
}

function sendmessage($msg) {
    $shortCode = $_SESSION["shortcode"];
    $phoneNumber = $_SESSION["phone"];
    $keyword = "citycorp";
    $retryDurationInHours = "2";
    $linkId = $_SESSION['linkId'];
//$username = "city";
//$apiKey  = "d0f242c73a33b50b779704b4600c81867e31c25915bef344d43797a63ee2715d";
    $username = "krufed";
    $apiKey = "87ad91890e1fa73f90734f521baffd3af452360bb6c269f95fd83c32d3062bff";

    $AT = new AfricasTalking($username, $apiKey);

// Get one of the services
    $sms = $AT->sms();

// Use the service

    $result = $sms->sendPremium([
        'to' => "+" . $phoneNumber,
        'message' => $msg,
        'from' => $shortCode,
        'keyword' => $keyword,
        'retryDurationInHours' => $retryDurationInHours,
        'linkId' => $linkId
    ]);
    print_r($result);
    //$application = $AT->application();

    session_destroy();
}

function get_details_to_mifos($url, $details) {
    // $out = array_values($details);
    $js = json_encode($details);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        //curl_setopt ($curl, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem"),
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false),
        //CURLOPT_CAINFO=> dirname(__FILE__)."/cacert.pem",
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_PORT => "8443",
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $js,
        CURLOPT_HTTPHEADER => array(
            "authorization: Basic YWRtaW46cGFzc3dvcmQ=",
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: 82f71847-a076-7a85-a4d7-ed6745be0190"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);


    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        return $response;
    }
}
