<?php
add_hook('OrderPaid', 1, function ($vars) {
    $getCredData = array(
        'clientid' => (string) $vars['userId'],
    );
    $getCredData = localAPI('GetCredits', $getCredData, '');
    $totalamount = 0.0;
    foreach ($getCredData['credits']['credit'] as $credit) {
        $am = $credit['amount'];
        
        $totalamount += $am;
    }

    if($totalamount > 0) {
        $removeCredData = array(
            'clientid' => (string) $vars['userId'],
            'description' => 'Funds is not allowed',
            'amount' => (string) $totalamount,
            'type' => 'remove',
        );

        localAPI('AddCredit', $removeCredData, '');
    }
});
