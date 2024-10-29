<?php

class Api
{
    const SITE_ADR = 'https://api.site.com';

    const BOOK_URL = '/book';

    const APPROVE_URL = '/approve';

    public $message = '';


    public function book(int $event_id, string $event_date, int $ticket_adult_price, int $ticket_adult_quantity,
                         int $ticket_kid_price, int $ticket_kid_quantity, string $barcode)
    {
        //todo: curl
        if (rand(0, 1)) {
            $this->message = "{message: 'order successfully booked'}";
            return true;
        } else {
            $this->message = "{error: 'barcode already exists'}";
            return false;
        }
    }

    public function approve(string $barcode)
    {
        //todo: curl
        $approve = rand(0, 10);
        if ($approve >= 1) {
            $this->message = "{message: 'order successfully aproved'}";
            return true;
        } else {
            $error = rand(0, 3);
            switch ($error) {
                case 0:
                    $this->message =  "{error: 'event cancelled'}";
                    break;
                case 1:
                    $this->message =  "{error: 'no tickets'}";
                    break;
                case 2:
                    $this->message =  "{error: 'no seats'}";
                    break;
                default:
                    $this->message =  "{error: 'fan removed'}";
            }
            return false;
        }
    }
}