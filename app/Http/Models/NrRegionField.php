<?php

/*
 * What extreme-vision team is that is 'one thing, a team, work together'
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "nr_region_recognition".
 *
 * @property int    $id          主键模版id
 * @property string $template_id 模版id
 * @property string $version     版本号
 * @property string $char_rect   位置
 * @property string $words       文字描述
 * @property int    $sort        排序
 * @property int    $create_time 创建时间
 * @property int    $create_by   创建者
 */
class NrRegionField extends Model
{
    protected $table = 'nr_region_field';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'template_id',
        'version',
        'char_rect',
        'words',
        'create_time',
        'create_by',
        'sort',
    ];
}
