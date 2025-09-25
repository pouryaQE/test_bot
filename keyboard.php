<?php
require_once 'config.php';
require_once 'functions.php';
require_once 'text.php';
$setting = select("setting", "*");
$admin_ids = select("admin", "id_admin", null, null, "FETCH_COLUMN");
//-----------------------------[  text panel  ]-------------------------------
$sql = "SHOW TABLES LIKE 'textbot'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
$table_exists = count($result) > 0;
$datatextbot = array(
    'text_usertest' => '',
    'text_Purchased_services' => '',
    'text_support' => '',
    'text_help' => '',
    'text_start' => '',
    'text_bot_off' => '',
    'text_dec_info' => '',
    'text_dec_usertest' => '',
    'text_fq' => '',
    'text_account' => '',
    'text_sell' => '',
    'text_Add_Balance' => '',
    'text_Discount' => '',
    'text_Tariff_list' => '',

);
if ($table_exists) {
    $textdatabot = select("textbot", "*", null, null, "fetchAll");
    $data_text_bot = array();
    foreach ($textdatabot as $row) {
        $data_text_bot[] = array(
            'id_text' => $row['id_text'],
            'text' => $row['text']
        );
    }
    foreach ($data_text_bot as $item) {
        if (isset($datatextbot[$item['id_text']])) {
            $datatextbot[$item['id_text']] = $item['text'];
        }
    }
}
$keyboard = [
    'keyboard' => [
        [['text' => $datatextbot['text_sell']], ['text' => $datatextbot['text_usertest']]],
        [['text' => $datatextbot['text_Purchased_services']], ['text' => $datatextbot['text_Tariff_list']]],
        [['text' => $datatextbot['text_account']], ['text' => $datatextbot['text_Add_Balance']]],
        [['text' => $textbotlang['users']['affiliates']['btn']]],
        [['text' => $datatextbot['text_support']], ['text' => $datatextbot['text_help']]],
    ],
    'resize_keyboard' => true
];
if (in_array($from_id, $admin_ids)) {
    $keyboard['keyboard'][] = [
        ['text' => $textbotlang['Admin']['commendadmin']],
    ];
}
$keyboard = json_encode($keyboard);


$keyboardPanel = json_encode([
    'inline_keyboard' => [
        [['text' => $datatextbot['text_Discount'], 'callback_data' => "Discount"]],
    ],
    'resize_keyboard' => true
]);
$keyboardadmin = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['keyboardadmin']['bot_statistics']]],
        [['text' => $textbotlang['Admin']['keyboardadmin']['manage_panel']], ['text' => $textbotlang['Admin']['keyboardadmin']['add_panel']]],
        [['text' => $textbotlang['Admin']['keyboardadmin']['shop_section']], ['text' => $textbotlang['Admin']['keyboardadmin']['finance']]],
        [['text' => $textbotlang['Admin']['keyboardadmin']['admin_section']], ['text' => $textbotlang['Admin']['keyboardadmin']['bot_text_settings']]],
        [['text' => $textbotlang['Admin']['keyboardadmin']['user_services']], ['text' => $textbotlang['Admin']['keyboardadmin']['user_search']], ['text' => $textbotlang['Admin']['keyboardadmin']['send_message']]],
        [['text' => $textbotlang['Admin']['keyboardadmin']['tutorial_section']], ['text' => $textbotlang['Admin']['keyboardadmin']['settings']]],
        [['text' => $textbotlang['users']['backhome']]]
    ],
    'resize_keyboard' => true
]);

$CartManage = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['users']['moeny']['card_number_settings']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$aqayepardakht = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['users']['moeny']['mr_payment_merchant_settings']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);

$NowPaymentsManage = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['users']['moeny']['nowpayment_api']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$admin_section_panel = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['Addedadmin']], ['text' => $textbotlang['Admin']['Removeedadmin']]],
        [['text' => $textbotlang['Admin']['manageadmin']['showlistbtn']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]],

    ],
    'resize_keyboard' => true
]);
$keyboard_usertest = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['getlimitusertest']['setlimitallbtn']]],
        [['text' => $textbotlang['Admin']['Usertest']['settimeusertest']], ['text' => $textbotlang['Admin']['Usertest']['setvolumeusertest']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$setting_panel = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['keyboardadmin']['seetingstatus']]],
        [['text' => $textbotlang['Admin']['keyboardadmin']['settingscron']], ['text' => $textbotlang['Admin']['keyboardadmin']['test_account_settings']]],
        [['text' => $textbotlang['Admin']['channel']['channelreport']], ['text' => $textbotlang['Admin']['channel']['setting']]],
        [['text' => $textbotlang['Admin']['keyboardadmin']['affiliate_settings']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$PaySettingcard = select("PaySetting", "ValuePay", "NamePay", 'Cartstatus', "select")['ValuePay'];
$PaySettingnow = select("PaySetting", "ValuePay", "NamePay", 'nowpaymentstatus', "select")['ValuePay'];
$PaySettingdigi = select("PaySetting", "ValuePay", "NamePay", 'digistatus', "select")['ValuePay'];
$PaySettingaqayepardakht = select("PaySetting", "ValuePay", "NamePay", 'statusaqayepardakht', "select")['ValuePay'];
$step_payment = [
    'inline_keyboard' => []
];
if ($PaySettingcard == "oncard") {
    $step_payment['inline_keyboard'][] = [
        ['text' => $textbotlang['users']['moeny']['cart_to_Cart_btn'], 'callback_data' => "cart_to_offline"],
    ];
}
if ($PaySettingnow == "onnowpayment") {
    $step_payment['inline_keyboard'][] = [
        ['text' => $textbotlang['users']['moeny']['nowpaymentbtn'], 'callback_data' => "nowpayments"]
    ];
}
if ($PaySettingdigi == "ondigi") {
    $step_payment['inline_keyboard'][] = [
        ['text' => $textbotlang['users']['moeny']['currency_rial_gateway'], 'callback_data' => "iranpay"]
    ];
}
if ($PaySettingaqayepardakht == "onaqayepardakht") {
    $step_payment['inline_keyboard'][] = [
        ['text' => $textbotlang['users']['moeny']['mr_payment_gateway'], 'callback_data' => "aqayepardakht"]
    ];
}
$step_payment['inline_keyboard'][] = [
    ['text' => $textbotlang['users']['closelist'], 'callback_data' => "closelist"]
];
$step_payment = json_encode($step_payment);
$User_Services = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['ManageUser']['searchorder']]],
        [['text' => $textbotlang['Admin']['ManageUser']['removeorderbtn']], ['text' => $textbotlang['Admin']['Balance']['SendBalanceAll']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$keyboardhelpadmin = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['Help']['addhelp']], ['text' => $textbotlang['Admin']['Help']['removehelpbtn']]],
        [['text' => $textbotlang['Admin']['Help']['edithelp']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$shopkeyboard = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['Product']['addproduct']], ['text' => $textbotlang['Admin']['Product']['titlebtnremove']]],
        [['text' => $textbotlang['Admin']['category']['add']], ['text' => $textbotlang['Admin']['category']['remove']]],
        [['text' => $textbotlang['Admin']['Product']['titlebtnedit']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['setvolume']]],
        [['text' => $textbotlang['Admin']['Discount']['titlebtn']], ['text' => $textbotlang['Admin']['Discount']['titlebtnremove']]],
        [['text' => $textbotlang['Admin']['Discountsell']['create']], ['text' => $textbotlang['Admin']['Discountsell']['remove']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$confrimrolls = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['users']['rulesaccept']]],
    ],
    'resize_keyboard' => true
]);
$request_contact = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['users']['sendnumber'], 'request_contact' => true]],
        [['text' => $textbotlang['users']['backhome']]]
    ],
    'resize_keyboard' => true
]);
$sendmessageuser = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['systemsms']['sendbulkbtn']], ['text' => $textbotlang['Admin']['systemsms']['forwardbulkbtn']]],
        [['text' => $textbotlang['Admin']['systemsms']['sendmessageauser']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$channelkeyboard = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['channel']['changechannelbtn']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$backuser = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['users']['backhome']]]
    ],
    'resize_keyboard' => true,
]);
$backadmin = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true,
]);
$stmt = $pdo->prepare("SHOW TABLES LIKE 'marzban_panel'");
$stmt->execute();
$result = $stmt->fetchAll();
$table_exists = count($result) > 0;
$namepanel = [];
if ($table_exists) {
    $stmt = $pdo->prepare("SELECT * FROM marzban_panel");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $namepanel[] = [$row['name_panel']];
    }
    $list_marzban_panel = [
        'keyboard' => [],
        'resize_keyboard' => true,
    ];
    foreach ($namepanel as $button) {
        $list_marzban_panel['keyboard'][] = [
            ['text' => $button[0]]
        ];
    }
    $list_marzban_panel['keyboard'][] = [
        ['text' => $textbotlang['Admin']['Back-Adminment']],
    ];
    $json_list_marzban_panel = json_encode($list_marzban_panel);
}
$sql = "SHOW TABLES LIKE 'help'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
$table_exists = count($result) > 0;
if ($table_exists) {
    $help = [];
    $stmt = $pdo->prepare("SELECT * FROM help");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $help[] = [$row['name_os']];
    }
    $help_arr = [
        'keyboard' => [],
        'resize_keyboard' => true,
    ];
    foreach ($help as $button) {
        $help_arr['keyboard'][] = [
            ['text' => $button[0]]
        ];
    }
    $help_arr['keyboard'][] = [
        ['text' => $textbotlang['users']['backhome']],
    ];
    $json_list_help = json_encode($help_arr);
}

$users = select("user", "*", "id", $from_id, "select");
if ($users == false) {
    $users = array();
    $users = array(
        'step' => '',
    );
}
$stmt = $pdo->prepare("SELECT * FROM marzban_panel WHERE status = 'activepanel'");
$stmt->execute();
$list_marzban_panel_users = ['inline_keyboard' => []];
while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($users['step'] == "getusernameinfo") {
        $list_marzban_panel_users['inline_keyboard'][] = [
            ['text' => $result['name_panel'], 'callback_data' => "locationnotuser_{$result['id']}"]
        ];
    } else {
        $list_marzban_panel_users['inline_keyboard'][] = [
            ['text' => $result['name_panel'], 'callback_data' => "location_{$result['id']}"]
        ];
    }
}
$list_marzban_panel_users['inline_keyboard'][] = [
    ['text' => $textbotlang['users']['backhome'], 'callback_data' => "backuser"],
];
$list_marzban_panel_user = json_encode($list_marzban_panel_users);

$list_marzban_panel_usertest = [
    'inline_keyboard' => [],
];
$stmt = $pdo->prepare("SELECT * FROM marzban_panel WHERE statusTest = 'ontestshowpanel'");
$stmt->execute();
while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $list_marzban_panel_usertest['inline_keyboard'][] = [
        ['text' => $result['name_panel'], 'callback_data' => "locationtests_{$result['id']}"]
    ];
}
$list_marzban_panel_usertest['inline_keyboard'][] = [
    ['text' => $textbotlang['users']['backhome'], 'callback_data' => "backuser"],
];
$list_marzban_usertest = json_encode($list_marzban_panel_usertest);
$textbot = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['users']['changetext']['set_start_text']], ['text' => $textbotlang['users']['changetext']['purchased_service_button']]],
        [['text' => $textbotlang['users']['changetext']['test_account_button']], ['text' => $textbotlang['users']['changetext']['faq_button']]],
        [['text' => $textbotlang['users']['changetext']['tutorial_button']], ['text' => $textbotlang['users']['changetext']['support_button']]],
        [['text' => $textbotlang['users']['changetext']['increase_balance_button']], ['text' => $textbotlang['users']['changetext']['law_text']]],
        [['text' => $textbotlang['users']['changetext']['buy_subscription_button']], ['text' => $textbotlang['users']['changetext']['tariff_list_button']]],
        [['text' => $textbotlang['users']['changetext']['tariff_list_description']]],
        [['text' => $textbotlang['users']['changetext']['user_account_button']]],
        [['text' => $textbotlang['users']['changetext']['mandatory_membership_description']]],
        [['text' => $textbotlang['users']['changetext']['faq_description']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
//--------------------------------------------------
$sql = "SHOW TABLES LIKE 'protocol'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
$table_exists = count($result) > 0;
if ($table_exists) {
    $getdataprotocol = select("protocol", "*", null, null, "fetchAll");
    $protocol = [];
    foreach ($getdataprotocol as $result) {
        $protocol[] = [['text' => $result['NameProtocol']]];
    }
    $protocol[] = [['text' => $textbotlang['Admin']['Back-Adminment']]];
    $keyboardprotocollist = json_encode(['resize_keyboard' => true, 'keyboard' => $protocol]);
}
//--------------------------------------------------
$sql = "SHOW TABLES LIKE 'product'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
$table_exists = count($result) > 0;
if ($table_exists) {
    $product = [];
    $stmt = $pdo->prepare("SELECT * FROM product WHERE Location = :Location OR Location = '/all'");
    $stmt->bindParam(':Location', $text, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $product[] = [$row['name_product']];
    }
    $list_product = [
        'keyboard' => [],
        'resize_keyboard' => true,
    ];
    $list_product['keyboard'][] = [
        ['text' => $textbotlang['Admin']['Back-Adminment']],
    ];
    foreach ($product as $button) {
        $list_product['keyboard'][] = [
            ['text' => $button[0]]
        ];
    }
    $json_list_product_list_admin = json_encode($list_product);
}
//--------------------------------------------------
$sql = "SHOW TABLES LIKE 'Discount'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
$table_exists = count($result) > 0;
if ($table_exists) {
    $Discount = [];
    $stmt = $pdo->prepare("SELECT * FROM Discount");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $Discount[] = [$row['code']];
    }
    $list_Discount = [
        'keyboard' => [],
        'resize_keyboard' => true,
    ];
    $list_Discount['keyboard'][] = [
        ['text' => $textbotlang['Admin']['Back-Adminment']],
    ];
    foreach ($Discount as $button) {
        $list_Discount['keyboard'][] = [
            ['text' => $button[0]]
        ];
    }
    $json_list_Discount_list_admin = json_encode($list_Discount);
}
//--------------------------------------------------
$sql = "SHOW TABLES LIKE 'DiscountSell'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
$table_exists = count($result) > 0;
$namepanel = [];
if ($table_exists) {
    $DiscountSell = [];
    $stmt = $pdo->prepare("SELECT * FROM DiscountSell");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $DiscountSell[] = [$row['codeDiscount']];
    }
    $list_Discountsell = [
        'keyboard' => [],
        'resize_keyboard' => true,
    ];
    $list_Discountsell['keyboard'][] = [
        ['text' => $textbotlang['Admin']['Back-Adminment']],
    ];
    foreach ($DiscountSell as $button) {
        $list_Discountsell['keyboard'][] = [
            ['text' => $button[0]]
        ];
    }
    $json_list_Discount_list_admin_sell = json_encode($list_Discountsell);
}
$payment = json_encode([
    'inline_keyboard' => [
        [['text' => $textbotlang['users']['buy']['payandGet'], 'callback_data' => "confirmandgetservice"]],
        [['text' => $textbotlang['users']['buy']['discount'], 'callback_data' => "aptdc"]],
        [['text' => $textbotlang['users']['backhome'], 'callback_data' => "backuser"]]
    ]
]);
$change_product = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['Product']['editprice']], ['text' => $textbotlang['Admin']['Product']['editvolume']], ['text' => $textbotlang['Admin']['Product']['edittime']]],
        [['text' => $textbotlang['Admin']['Product']['editname']], ['text' => $textbotlang['Admin']['Product']['editcategory']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$MethodUsername = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['users']['customusernameorder']]],
        [['text' => $textbotlang['users']['customidAndRandom']]],
        [['text' => $textbotlang['users']['customusername']]],
        [['text' => $textbotlang['users']['customtextandrandom']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$optionMarzban = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['managepanel']['btnshowconnect']], ['text' => $textbotlang['Admin']['managepanel']['showpanelbtn']]],
        [['text' => $textbotlang['Admin']['managepanel']['showpaneltestbtn']], ['text' => $textbotlang['Admin']['managepanel']['setinbound']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['namepanel']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['removepanel']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editurl']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editusername']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editpassword']]],
        [['text' => $textbotlang['Admin']['managepanel']['methodusername']]],
        [['text' => $textbotlang['Admin']['managepanel']['sublinkstatus']], ['text' => $textbotlang['Admin']['managepanel']['configstatus']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['on_hold_status']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$optionmikrotik = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['managepanel']['btnshowconnect']], ['text' => $textbotlang['Admin']['managepanel']['showpanelbtn']]],
        [['text' => $textbotlang['Admin']['managepanel']['showpaneltestbtn']], ['text' => $textbotlang['Admin']['managepanel']['setgroup']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['namepanel']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['removepanel']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editurl']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editusername']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editpassword']], ['text' => $textbotlang['Admin']['managepanel']['methodusername']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$optionwgdashboard = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['managepanel']['showpanelbtn']]],
        [['text' => $textbotlang['Admin']['managepanel']['showpaneltestbtn']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['namepanel']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['removepanel']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editpassword']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editusername']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editurl']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editinound']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$options_ui = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['managepanel']['showpanelbtn']]],
        [['text' => $textbotlang['Admin']['managepanel']['showpaneltestbtn']], ['text' => $textbotlang['Admin']['managepanel']['setinbound']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['namepanel']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['removepanel']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editurl']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editusername']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editpassword']]],
        [['text' => $textbotlang['Admin']['managepanel']['methodusername']]],
        [['text' => $textbotlang['Admin']['managepanel']['sublinkstatus']], ['text' => $textbotlang['Admin']['managepanel']['configstatus']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$optionMarzneshin = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['managepanel']['btnshowconnect']], ['text' => $textbotlang['Admin']['managepanel']['showpanelbtn']]],
        [['text' => $textbotlang['Admin']['managepanel']['showpaneltestbtn']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['namepanel']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['removepanel']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editurl']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editusername']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editpassword']], ['text' => $textbotlang['users']['status']['manageService']]],
        [['text' => $textbotlang['Admin']['managepanel']['methodusername']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['on_hold_status']]],
        [['text' => $textbotlang['Admin']['managepanel']['sublinkstatus']], ['text' => $textbotlang['Admin']['managepanel']['configstatus']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$optionX_ui_single = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['managepanel']['btnshowconnect']], ['text' => $textbotlang['Admin']['managepanel']['showpanelbtn']]],
        [['text' => $textbotlang['Admin']['managepanel']['showpaneltestbtn']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['namepanel']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['removepanel']]],
        [['text' => $textbotlang['Admin']['managepanel']['methodusername']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editpassword']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editusername']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editurl']], ['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['editinound']]],
        [['text' => $textbotlang['Admin']['managepanel']['sublinkstatus']], ['text' => $textbotlang['Admin']['managepanel']['configstatus']]],
        [['text' => $textbotlang['Admin']['managepanel']['keyboardpanel']['linksub']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$supportoption = json_encode([
    'inline_keyboard' => [
        [
            ['text' => $datatextbot['text_fq'], 'callback_data' => "fqQuestions"],
        ],
        [
            ['text' => $textbotlang['users']['sendmessagesupport'], 'callback_data' => "support"],
        ],
    ]
]);
$affiliates = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['affiliate']['status']]],
        [['text' => $textbotlang['Admin']['affiliate']['Percentageset']]],
        [['text' => $textbotlang['Admin']['affiliate']['setbaner']]],
        [['text' => $textbotlang['Admin']['affiliate']['porsantafterbuy']], ['text' => $textbotlang['Admin']['affiliate']['gift']]],
        [['text' => $textbotlang['Admin']['affiliate']['giftstart']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
$typepanel = json_encode([
    'inline_keyboard' => [
        [
            ['text' => $textbotlang['Admin']['managepanel']['type']['marzban'], 'callback_data' => "typepanel%marzban"],
            ['text' => $textbotlang['Admin']['managepanel']['type']['3x-ui'], 'callback_data' => "typepanel%x-ui_single"]
        ],
        [
            ['text' => $textbotlang['Admin']['managepanel']['type']['marzneshin'], 'callback_data' => "typepanel%marzneshin"],
            ['text' => $textbotlang['Admin']['managepanel']['type']['alireza'], 'callback_data' => "typepanel%alireza"]
        ],
        [
            ['text' => $textbotlang['Admin']['managepanel']['type']['s-ui'], 'callback_data' => "typepanel%s_ui"],
            ['text' => $textbotlang['Admin']['managepanel']['type']['wgdashboard'], 'callback_data' => "typepanel%wgdashboard"]
        ],
        [
            ['text' => $textbotlang['Admin']['managepanel']['type']['mikrotik'], 'callback_data' => "typepanel%mikrotik"]
        ],
        [
            ['text' => $textbotlang['Admin']['Back-Adminment'], 'callback_data' => "back_admin"]
        ]
    ],
]);
$keyboardcronjob = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['cron']['test']['active']], ['text' => $textbotlang['Admin']['cron']['test']['disable']]],
        [['text' => $textbotlang['Admin']['cron']['volume']['active']], ['text' => $textbotlang['Admin']['cron']['volume']['disable']]],
        [['text' => $textbotlang['Admin']['cron']['time']['active']], ['text' => $textbotlang['Admin']['cron']['time']['disable']]],
        [['text' => $textbotlang['Admin']['cron']['remove']['active']], ['text' => $textbotlang['Admin']['cron']['remove']['disable']]],
        [['text' => $textbotlang['Admin']['cron']['remove']['timeset']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);

$helpedit = json_encode([
    'keyboard' => [
        [['text' => $textbotlang['Admin']['Help']['change']['name']], ['text' => $textbotlang['Admin']['Help']['change']['dec']]],
        [['text' => $textbotlang['Admin']['Help']['change']['editmedia']]],
        [['text' => $textbotlang['Admin']['Back-Adminment']]]
    ],
    'resize_keyboard' => true
]);
function KeyboardCategory()
{
    global $pdo, $textbotlang;
    $stmt = $pdo->prepare("SELECT * FROM category");
    $stmt->execute();
    $list_category = [
        'keyboard' => [],
        'resize_keyboard' => true,
    ];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $list_category['keyboard'][] = [['text' => $row['remark']]];
    }
    $list_category['keyboard'][] = [
        ['text' => $textbotlang['Admin']['Back-Adminment']],
    ];
    return json_encode($list_category);
}
function KeyboardCategorybuy($callback_data, $location)
{
    global $pdo, $textbotlang;
    $stmt = $pdo->prepare("SELECT * FROM category");
    $stmt->execute();
    $list_category = ['inline_keyboard' => [],];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $stmts = $pdo->prepare("SELECT * FROM product WHERE (Location = :location OR Location = '/all') AND category = :category");
        $stmts->bindParam(':location', $location, PDO::PARAM_STR);
        $stmts->bindParam(':category', $row['id'], PDO::PARAM_STR);
        $stmts->execute();
        if ($stmts->rowCount() == 0)
            continue;
        $list_category['inline_keyboard'][] = [['text' => $row['remark'], 'callback_data' => "categorylist_" . $row['id']]];
    }
    $list_category['inline_keyboard'][] = [
        ['text' => $textbotlang['users']['backmenu'], "callback_data" => $callback_data],
    ];
    return json_encode($list_category);
}
function KeyboardProduct($location, $backdata, $MethodUsername, $categoryid = null)
{
    global $pdo, $textbotlang;
    $query = "SELECT * FROM product WHERE (Location = :location OR Location = '/all') ";
    if ($categoryid != null) {
        $query .= "AND category = '$categoryid'";
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    $stmt->execute();
    $product = ['inline_keyboard' => []];
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($MethodUsername == $textbotlang['users']['customusername']) {
            $product['inline_keyboard'][] = [
                ['text' => $result['name_product'], 'callback_data' => "prodcutservices_" . $result['code_product']]
            ];
        } else {
            $product['inline_keyboard'][] = [
                ['text' => $result['name_product'], 'callback_data' => "prodcutservice_{$result['code_product']}"]
            ];
        }
    }
    $product['inline_keyboard'][] = [
        ['text' => $textbotlang['users']['backmenu'], 'callback_data' => $backdata]
    ];

    return json_encode($product);
}