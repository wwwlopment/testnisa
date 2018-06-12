<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $picture
 * @property string $teaser
 * @property string $content
 * @property string $date
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['title', 'picture', 'teaser'], 'string', 'max' => 255],
            [['content'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'picture' => 'Picture',
            'teaser' => 'Teaser',
            'content' => 'Content',
            'date' => 'Date',
        ];
    }

    public function saveImage($filename) {
        $this->picture = $filename;
        return $this->save(false);
    }

}
