<?php


class LibFunc extends Phalcon\Mvc\Model{

    static public function month($month){
        switch((int)$month){
            case 1:
                return "Января";
                break;
            case 2:
                return "Февраля";
                break;
            case 3:
                return "Марта";
                break;
            case 4:
                return "Апреля";
                break;
            case 5:
                return "Мая";
                break;
            case 6:
                return "Июня";
                break;
            case 7:
                return "Июля";
                break;
            case 8:
                return "Августа";
                break;
            case 9:
                return "Сентября";
                break;
            case 10:
                return "Октября";
                break;
            case 11:
                return "Ноября";
                break;
            case 12:
                return "Декабря";
                break;
        }
    }

}