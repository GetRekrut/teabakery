<?php

// первый товар, если в Input он есть, то начинаем собирать данные
if (!empty($input['line_items'][0])){

    $product1 = $input['line_items'][0]; // берем из заказа первый товар

    // добавляем id полей из амо
    $amo_keys_fields_1 = [
        'Название' => 513313,
        'Артикул' => 513315,
        'Количество' => 513317,
        'Стоимость' => 513319,
        'Вес' => 513321,
        'Оформление' => 513323,
        'Вид оформления' => 513325,
        'Декор или цвет. гамма' => 513467,
        'Выберите начинку' => 513463,
        'Укажите рисунок' => 513469,
        'Укажите цифру' => 513465,
        'Укажите надпись' => 513327,
        'Кол-во свечей' => 513329,
        'Комментарий' => 513589,
        'Оформление заказа' => 514635,
    ];

    $lead = $this->addProductInLead($product1, $lead, $amo_keys_fields_1); // добавление в поля сделки инфы по первому товару
    $note_products = $this->addNoteProducts($note_products, $product1, $id = 1); // добавление в массив примечания инфы по перв товару

}

// product 2
if (!empty($input['line_items'][1])){

    $product2 = $input['line_items'][1];

    $amo_keys_fields_2 = [
        'Название' => 513335,
        'Артикул' => 513379,
        'Количество' => 513381,
        'Стоимость' => 513383,
        'Вес' => 513385,
        'Оформление' => 513387,
        'Вид оформления' => 513389,
        'Декор или цвет. гамма' => 513391,
        'Выберите начинку' => 513393,
        'Укажите рисунок' => 513591,
        'Укажите цифру' => 513593,
        'Укажите надпись' => 513595,
        'Кол-во свечей' => 513597,
        'Комментарий' => 513599,
        'Оформление заказа' => 514637,
    ];

    $lead = $this->addProductInLead($product2, $lead, $amo_keys_fields_2);
    $note_products = $this->addNoteProducts($note_products, $product2, $id = 2);
//            Log::info('note : ', $note_products);
}

// product 3
if (!empty($input['line_items'][2])){

    $product3 = $input['line_items'][2];

    $amo_keys_fields_3 = [
        'Название' => 513603,
        'Артикул' => 513605,
        'Количество' => 513607,
        'Стоимость' => 513609,
        'Вес' => 513611,
        'Оформление' => 513613,
        'Вид оформления' => 513615,
        'Декор или цвет. гамма' => 513617,
        'Выберите начинку' => 513619,
        'Укажите рисунок' => 513621,
        'Укажите цифру' => 513623,
        'Укажите надпись' => 513625,
        'Кол-во свечей' => 513627,
        'Комментарий' => 513629,
        'Оформление заказа' => 514639,
    ];

    $lead = $this->addProductInLead($product3, $lead, $amo_keys_fields_3);
    $note_products = $this->addNoteProducts($note_products, $product3, $id = 3);
}

// product 4
if (!empty($input['line_items'][3])){

    $product4 = $input['line_items'][3];

    $amo_keys_fields_4 = [
        'Название' => 513717,
        'Артикул' => 513719,
        'Количество' => 513721,
        'Стоимость' => 513723,
        'Вес' => 513725,
        'Оформление' => 513727,
        'Вид оформления' => 513729,
        'Декор или цвет. гамма' => 513731,
        'Выберите начинку' => 513733,
        'Укажите рисунок' => 513735,
        'Укажите цифру' => 513737,
        'Укажите надпись' => 513739,
        'Кол-во свечей' => 513741,
        'Комментарий' => 513743,
        'Оформление заказа' => 514641,
    ];

    $lead = $this->addProductInLead($product4, $lead, $amo_keys_fields_4);
    $note_products = $this->addNoteProducts($note_products, $product4, $id = 4);
}

// product 5
if (!empty($input['line_items'][4])){

    $product5 = $input['line_items'][4];

    $amo_keys_fields_5 = [
        'Название' => 513747,
        'Артикул' => 513749,
        'Количество' => 513751,
        'Стоимость' => 513753,
        'Вес' => 513755,
        'Оформление' => 513757,
        'Вид оформления' => 513759,
        'Декор или цвет. гамма' => 513761,
        'Выберите начинку' => 513763,
        'Укажите рисунок' => 513765,
        'Укажите цифру' => 513767,
        'Укажите надпись' => 513769,
        'Кол-во свечей' => 513771,
        'Комментарий' => 513773,
        'Оформление заказа' => 514643,
    ];

    $lead = $this->addProductInLead($product5, $lead, $amo_keys_fields_5);
    $note_products = $this->addNoteProducts($note_products, $product5, $id = 5);
}

// product 6
if (!empty($input['line_items'][5])){

    $product6 = $input['line_items'][5];

    $amo_keys_fields_6 = [
        'Название' => 513779,
        'Артикул' => 513781,
        'Количество' => 513783,
        'Стоимость' => 513785,
        'Вес' => 513787,
        'Оформление' => 513789,
        'Вид оформления' => 513791,
        'Декор или цвет. гамма' => 513793,
        'Выберите начинку' => 513795,
        'Укажите рисунок' => 513797,
        'Укажите цифру' => 513799,
        'Укажите надпись' => 513801,
        'Кол-во свечей' => 513803,
        'Комментарий' => 513805,
        'Оформление заказа' => 514645,
    ];

    $lead = $this->addProductInLead($product6, $lead, $amo_keys_fields_6);
    $note_products = $this->addNoteProducts($note_products, $product6, $id = 6);
}

// product 7
if (!empty($input['line_items'][6])){

    $product7 = $input['line_items'][6];

    $amo_keys_fields_7 = [
        'Название' => 513809,
        'Артикул' => 513811,
        'Количество' => 513813,
        'Стоимость' => 513815,
        'Вес' => 513817,
        'Оформление' => 513819,
        'Вид оформления' => 513821,
        'Декор или цвет. гамма' => 513823,
        'Выберите начинку' => 513825,
        'Укажите рисунок' => 513827,
        'Укажите цифру' => 513829,
        'Укажите надпись' => 513831,
        'Кол-во свечей' => 513833,
        'Комментарий' => 513835,
        'Оформление заказа' => 514647,
    ];

    $lead = $this->addProductInLead($product7, $lead, $amo_keys_fields_7);
    $note_products = $this->addNoteProducts($note_products, $product7, $id = 7);
}

// product 8
if (!empty($input['line_items'][7])){

    $product8 = $input['line_items'][7];

    $amo_keys_fields_8 = [
        'Название' => 513839,
        'Артикул' => 513841,
        'Количество' => 513843,
        'Стоимость' => 513845,
        'Вес' => 513847,
        'Оформление' => 513849,
        'Вид оформления' => 513851,
        'Декор или цвет. гамма' => 513853,
        'Выберите начинку' => 513855,
        'Укажите рисунок' => 513857,
        'Укажите цифру' => 513859,
        'Укажите надпись' => 513861,
        'Кол-во свечей' => 513863,
        'Комментарий' => 513865,
        'Оформление заказа' => 514649,
    ];

    $lead = $this->addProductInLead($product8, $lead, $amo_keys_fields_8);
    $note_products = $this->addNoteProducts($note_products, $product8, $id = 8);
}

// product 9
if (!empty($input['line_items'][8])){

    $product9 = $input['line_items'][8];

    $amo_keys_fields_9 = [
        'Название' => 513869,
        'Артикул' => 513871,
        'Количество' => 513873,
        'Стоимость' => 513875,
        'Вес' => 513877,
        'Оформление' => 513879,
        'Вид оформления' => 513881,
        'Декор или цвет. гамма' => 513883,
        'Выберите начинку' => 513885,
        'Укажите рисунок' => 513887,
        'Укажите цифру' => 513889,
        'Укажите надпись' => 513891,
        'Кол-во свечей' => 513893,
        'Комментарий' => 513895,
        'Оформление заказа' => 514651,
    ];

    $lead = $this->addProductInLead($product9, $lead, $amo_keys_fields_9);
    $note_products = $this->addNoteProducts($note_products, $product9, $id = 9);
}

// product 10
if (!empty($input['line_items'][9])){

    $product10 = $input['line_items'][9];

    $amo_keys_fields_10 = [
        'Название' => 513899,
        'Артикул' => 513901,
        'Количество' => 513903,
        'Стоимость' => 513905,
        'Вес' => 513907,
        'Оформление' => 513909,
        'Вид оформления' => 513911,
        'Декор или цвет. гамма' => 513913,
        'Выберите начинку' => 513915,
        'Укажите рисунок' => 513917,
        'Укажите цифру' => 513919,
        'Укажите надпись' => 513921,
        'Кол-во свечей' => 513923,
        'Комментарий' => 513925,
        'Оформление заказа' => 514653,
    ];

    $lead = $this->addProductInLead($product10, $lead, $amo_keys_fields_10);
    $note_products = $this->addNoteProducts($note_products, $product10, $id = 10);
}

// product 11
if (!empty($input['line_items'][10])){

    $product11 = $input['line_items'][10];

    $amo_keys_fields_11 = [
        'Название' => 513929,
        'Артикул' => 513931,
        'Количество' => 513933,
        'Стоимость' => 513935,
        'Вес' => 513937,
        'Оформление' => 513939,
        'Вид оформления' => 513941,
        'Декор или цвет. гамма' => 513943,
        'Выберите начинку' => 513945,
        'Укажите рисунок' => 513947,
        'Укажите цифру' => 513949,
        'Укажите надпись' => 513951,
        'Кол-во свечей' => 513953,
        'Комментарий' => 513955,
        'Оформление заказа' => 514655,
    ];

    $lead = $this->addProductInLead($product11, $lead, $amo_keys_fields_11);
    $note_products = $this->addNoteProducts($note_products, $product11, $id = 11);
}

// product12
if (!empty($input['line_items'][11])){

    $product12 = $input['line_items'][11];

    $amo_keys_fields_12 = [
        'Название' => 513959,
        'Артикул' => 513961,
        'Количество' => 513963,
        'Стоимость' => 513965,
        'Вес' => 513967,
        'Оформление' => 513969,
        'Вид оформления' => 513971,
        'Декор или цвет. гамма' => 513973,
        'Выберите начинку' => 513975,
        'Укажите рисунок' => 513977,
        'Укажите цифру' => 513979,
        'Укажите надпись' => 513981,
        'Кол-во свечей' => 513983,
        'Комментарий' => 513985,
        'Оформление заказа' => 514657,
    ];

    $lead = $this->addProductInLead($product12, $lead, $amo_keys_fields_12);
    $note_products = $this->addNoteProducts($note_products, $product12, $id = 12);
}