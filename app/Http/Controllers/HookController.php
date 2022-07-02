<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Hook;

/*
 * поиск контакта по номеру
 * берем существующий контакт или создаем новый
 * существование сделки не проверяем
 * создаем новую сделку в первом этапе первой воронки
 * в сделке создаем примечание с информацией о заказе
 */

class HookController extends Controller
{
    public function hook(Request $request)
    {

        Log::channel('daily')->info('Первичные данные:');
        Log::channel('daily')->info($request); // ежедневные логи
        Log::info(__METHOD__, $request::capture()->toArray());
        $input = $request->all();

        //logs
        $fw = fopen(__DIR__ . "/post.txt", "a");
        fwrite($fw, "\n" . '[' . date('Y-d-m H:i:s') . '] => ');
        fwrite($fw, print_r($input, true));
        fclose($fw);

        // initialised
        $responsible_user = 6331627; //admin

        // создание контакта
        $billing = $input['billing'];
        $info_contact = [
            'name' => $billing['first_name'] . " " . $billing['last_name'],
            'phone' => $billing['phone'],
            'email' => $billing['email'],
            'address' => $billing['address_1'],
            'resp_contact' => $responsible_user,
        ];

        $contact = $this->searchContact($info_contact);
        if ($contact == null)
            $contact = $this->createContact($info_contact);
        else
            $contact = $this->updateContact($info_contact, $contact);

        // приводим к такому виду 05.05.2022 17:00
        if ($billing['delivery_date']){

            $date_delivery = str_replace('/', '.', $billing['delivery_date']);
            $time_delivery = $billing['delivery_time_mkad_zamkad'] ?? $billing['delivery_time_by_time'];
            $type_delivery = 'Доставка';
        }
        elseif ($billing['samovivoz_date']){

            $date_delivery = str_replace('/', '.', $billing['samovivoz_date']);
            $time_delivery = $billing['samovivoz_time'];
            $type_delivery = 'Самовывоз';
        }

        // проверка есть ли сумма доставки
        $name_tax = $billing['delivery_price_mkad'] ?? null;
        $price_tax = $input['fee_lines'][0]['total'] ?? null;
        $price_clear = $input['total'] - $price_tax;

        //создание лида с основной информацией
        $info_lead = [
            'name'          =>  "Заказ #".$input['id'],
            'resp_lead'     =>  $responsible_user,
            'price'         =>  $input['total'],
            'price_delivey' =>  $price_tax,
            'price_clear'   =>  $price_clear,
            'name_delivery' =>  $name_tax,
            'payment_method' => $input['payment_method_title'] ?? null,
            'date_delivery' =>  $date_delivery ?? null,
            'time_delivery' =>  $time_delivery ?? null,
            'type_delivery' =>  $type_delivery ?? null,
            'comment'       =>  $billing['pr'] ?? null,
            'promo'         =>  $input['coupon_lines'][0]['code'] ?? null,
            'poluchatel'    =>  $billing['poluchatel'],
        ];

        $lead = $this->createLead($info_lead ,$contact);

        //создание примечания на контакте
        $note = [
            'Информация о клиенте',
            '----------------------',
            ' Имя : ' . $info_contact['name'],
            ' Телефон : ' . $info_contact['phone'],
            ' Email : ' . $info_contact['email'],
            ' Адрес : ' . $info_contact['address'] ?? '-',
            ' Тип : ' . $type_delivery ?? '-',
            ' Дата : ' . $date_delivery ?? '-',
            ' Время : ' . $time_delivery ?? '-',
            ' Доставка: ' . $name_tax .' - '. $price_tax,
            '----------------------',
        ];
        $textNote = implode("\n", $note);
        $this->addNote ( $contact, $textNote );

        // add products info in lead
        $products = $input['line_items'];
        $note_products = [
            'Информация о заказе',
        ];

        include_once 'fields_id.php';

        // добавляем второе примечание по товарам
        $textNoteProducts = implode("\n", $note_products);
        $this->addNote($contact, $textNoteProducts);
    }

    private function searchContact ($client_info){

        $ufee = $this->init();
        $contacts = $ufee->contacts()
            ->searchByPhone($client_info['phone']);

        if ($contacts == null || $contacts->first() == null)
            return null;
        else
            return $contacts->first();
    }

    private function createContact ($client_info){

        $ufee = $this->init();

        $contact = $ufee->contacts()->create();

        $contact->name = $client_info['name'] != null ? $client_info['name'] : 'Неизвестно';
        $contact->responsible_user_id = $client_info['resp_contact'];

        if($client_info['phone'])
            $contact->cf('Телефон')->setValue($client_info['phone']);

        if($client_info['email'])
            $contact->cf('Email')->setValue($client_info['email']);

        if($client_info['address'])
            $contact->cf()->byId(199875)->setValue($client_info['address']);

        $contact->save();

        return $contact;
    }

    private function updateContact($client_info, $contact){

        if($client_info['email'])
            $contact->cf('Email')->setValue($client_info['email']);

        if($client_info['address'])
            $contact->cf()->byId(199875)->setValue($client_info['address']);

        $contact->save();

        return $contact;
    }

    private function createLead ($client_info, $contact){

        $ufee = $this->init();

        $lead = $ufee->leads()->create();

        $lead->name = $client_info['name'] != null ? $client_info['name'] : 'Неизвестно';
        $lead->responsible_user_id = $client_info['resp_lead'];
        $lead->attachTags(['заказ с сайта', 'teabakery.ru‍']);

        if ($client_info['price']) //бюджет
            $lead->sale = $client_info['price'];

        if ($client_info['date_delivery']) //дата доставки
            $lead->cf()->byId(513077)->setValue($client_info['date_delivery']);

        if ($client_info['time_delivery']) //время доставки
            $lead->cf()->byId(513079)->setValue($client_info['time_delivery']);

        if ($client_info['type_delivery']) //тип доставки
            $lead->cf()->byId(514329)->setValue($client_info['type_delivery']);

        if ($client_info['comment']) //комментарий
            $lead->cf()->byId(514025)->setValue($client_info['comment']);

        if ($client_info['price_delivey']) //цена доставки
            $lead->cf()->byId(514333)->setValue($client_info['price_delivey']);

        if ($client_info['price_clear']) //цена доставки
            $lead->cf()->byId(514619)->setValue($client_info['price_clear']);
        
        if ($client_info['name_delivery']) //цена доставки
            $lead->cf()->byId(514357)->setValue($client_info['name_delivery']);

        if ($client_info['promo']) //купон
            $lead->cf()->byId(514027)->setValue($client_info['promo']);

        if ($client_info['poluchatel']) //получатель
            $lead->cf()->byId(514359)->setValue($client_info['poluchatel']);

        $lead->contacts_id = $contact->id;

        $lead->save();

        return $lead;

    }

    private function addProductInLead ($product, $lead, $keys){

        $lead->cf()->byId($keys['Название'])->setValue($product['name']); //название 1
        $lead->cf()->byId($keys['Артикул'])->setValue($product['product_id']); //артикул 1
        $lead->cf()->byId($keys['Количество'])->setValue($product['quantity']); //кол-во 1
        $lead->cf()->byId($keys['Стоимость'])->setValue($product['total']); //стоимость 1

        $meta_data = $product['meta_data'];
//        Log::info("Продукт: ".$product);
        $custom_order = [];

        //проверяем, есть ли в информации о товаре его вес
        if (!empty($meta_data[0])) {

            if ($meta_data[0]['key'] == 'pa_ves'){

                $weight = $meta_data[0]['value']; //1-5-kg-do-8-portsij
                $custom_order["Вес"] = 'Вес: '.$weight;
                $lead->cf()->byId($keys['Оформление заказа'])->setValue($weight); //вес 1

            }
        }
        /*
         * разбираем доп данные о товаре, в мета дата может быть что угодно из параметров которые ниже
         * поэтому проверяем каждый параметр и если нашли совпадение, то сохраняем в лид
         */
        foreach ($meta_data as $element){

            switch ($element['key']){
                case 'Выберите оформление':
                case 'Оформление':
                    $custom_order["Оформление"] = 'Оформление: '.$element['value'];
//                    $lead->cf()->byId($keys['Оформление'])->setValue($element['value']); // оформление 1
                    break;

                case 'Выберите вид оформления':
                    $custom_order["Вид оформления"] = 'Вид оформления: '.$element['value'];
//                    $lead->cf()->byId($keys['Вид оформления'])->setValue($element['value']);
                    break;

                case 'Укажите название декора или желаемую цветовую гамму':
                    $custom_order["Декор или цвет. гамма"] = 'Декор или цвет: '.$element['value'];
//                    $lead->cf()->byId($keys['Декор или цвет. гамма'])->setValue($element['value']);
                    break;

                case 'Выберите начинку':
                    $custom_order["Выберите начинку"] = 'Начинка: '.$element['value'];
//                    $lead->cf()->byId($keys['Выберите начинку'])->setValue($element['value']);
                    break;

                case 'Укажите рисунок':
                    $custom_order["Укажите рисунок"] = 'Рисунок: '.$element['value'];
//                    $lead->cf()->byId($keys['Укажите рисунок'])->setValue($element['value']);
                    break;

                case 'Укажите цифру':
                    $custom_order["Укажите цифру"] = 'Цифра: '.$element['value'];
//                    $lead->cf()->byId($keys['Укажите цифру'])->setValue($element['value']);
                    break;

                case 'Укажите надпись':
                    $custom_order["Укажите надпись"] = 'Надпись: '.$element['value'];
//                    $lead->cf()->byId($keys['Укажите надпись'])->setValue($element['value']);
                    break;

                case 'Укажите количество свечей':
                case 'Добавить свечу к заказу? (150 р)':
                    $custom_order["Кол-во свечей"] = 'Кол-во свечей: '.$element['value'];
//                    $lead->cf()->byId($keys['Кол-во свечей'])->setValue($element['value']);
                    break;

                case 'Добавьте комментарии к заказу при необходимости':
                    $lead->cf()->byId($keys['Комментарий'])->setValue($element['value']);
                    break;

                default:
                    break;
            }
            $text_custom_order = implode("\n", $custom_order);
            $lead->cf()->byId($keys['Оформление заказа'])->setValue($text_custom_order);
        }
        $lead->save();
        return $lead;
    }

    private function addNote ($entity, $text)
    {
        $note = $entity->createNote( $type = 4 );
        $note->text = $text;
        $note->element_type = 1;
        $note->element_id = $entity->id;
        $note->save();
    }

    private function addNoteProducts ($array, $product, $id){

        $array["$id Разделитель"] = '----------------------';
        $array["Товар №$id"] = "Товар №$id";
        $array["$id Название"] = "Название : ".$product['name'];
        $array["$id Количество"] = "Количество : ".$product['quantity'];
        $array["$id Артикул"] = "Артикул : ".$product['sku'];
        $array["$id Цена"] = "Цена : ".$product['price'];
        return  $array;
    }
}
