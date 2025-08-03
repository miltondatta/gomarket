<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    public static function valActDeMode()
    {
        /* die(HVAL); */
        $demK=get_option('demode_authorization');
        if(is_null($demK)||$demK=="") $demK=getenv('APP_DEMO');
        if(!isset($demK)||!defined("HVAL")||is_null($demK)||$demK!==HVAL)return false;
        return true;
    }
}