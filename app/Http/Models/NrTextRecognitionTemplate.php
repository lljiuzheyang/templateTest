<?php

/*
 * What extreme-vision team is that is 'one thing, a team, work together'
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "nr_text_recognition_template".
 *
 * @property string $id               主键模版id
 * @property string $img_json         图片json
 * @property string $last_launch_time 最近发布时间
 * @property string $last_update_time 最近修改时间
 * @property string $state            状态，编辑中或已发布
 * @property int    $version          版本号
 * @property string $create_time      创建时间
 * @property int    $is_delete        删除标识
 * @property int    $create_by        创建者
 * @property int    $sort             排序
 * @property string $algo_rule        算法返回值
 */
class NrTextRecognitionTemplate extends Model
{
    protected $table = 'nr_text_recognition_template';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'img_json',
        'last_launch_time',
        'last_update_time',
        'state',
        'version',
        'create_time',
        'is_delete',
        'create_by',
        'sort',
        'algo_rule ',
    ];

    /**
     * 获取关联到多个框选字段.
     *
     * @author 刘富胜
     *
     * @version 1.0.0
     * @create_time 2019-7-14
     */
    public function relateTemplateField()
    {
        return $this->hasOne('App\Http\Models\NrRegionField', 'template_id', 'id');
    }

    /**
     * 获取关联到多个框选识别区域
     *
     * @author 刘富胜
     *
     * @version 1.0.0
     * @create_time 2019-7-14
     */
    public function relateTemplateRecognition()
    {
        return $this->hasOne('App\Http\Models\NrRegionRecognition', 'template_id', 'id');
    }
}
