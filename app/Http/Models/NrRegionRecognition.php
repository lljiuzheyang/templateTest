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
 * @property string $rect        位置
 * @property string $type        字段类别
 * @property int    $sort        排序
 * @property string $field_name  字段名称
 * @property int    $create_time 创建时间
 * @property int    $create_by   创建者
 */
class NrRegionRecognition extends Model
{
    protected $table = 'nr_region_recognition';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'template_id',
        'version',
        'rect',
        'type',
        'sort',
        'field_name',
        'create_time',
        'create_by',
    ];
}
