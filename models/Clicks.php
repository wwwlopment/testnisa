<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clicks".
 *
 * @property int $id
 * @property int $news_id
 * @property int $unique_clicks
 * @property int $clicks
 * @property string $country_code
 * @property string $date
 * @property string $clientId
 */
class Clicks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clicks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id', 'unique_clicks', 'clicks'], 'integer'],
            [['date'], 'safe'],
            [['country_code', 'clientId'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'News ID',
            'clientId' => 'Client ID',
            'unique_clicks' => 'Unique Clicks',
            'clicks' => 'Clicks',
            'country_code' => 'Country Code',
            'date' => 'Date',
        ];
    }
}
